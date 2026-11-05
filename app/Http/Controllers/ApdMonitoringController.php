<?php

namespace App\Http\Controllers;

use App\Models\ApdItem;
use App\Models\ApdInspection;
use App\Models\ApdInspectionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApdMonitoringController extends Controller
{
    /**
     * Menampilkan halaman monitoring APD.
     */
    public function index(): View
    {
        // Mengambil identitas pekerja dari akun yang sedang login.
        $worker = auth()->user()->worker;

        // Pastikan akun sudah terhubung dengan pekerja aktif.
        if (!$worker || !$worker->is_active) {
            abort(403, 'Akun Anda belum terhubung dengan data pekerja aktif.');
        }

        $items = ApdItem::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('apd.monitoring', compact('items', 'worker'));
    }

    /**
     * Menyimpan hasil pemeriksaan APD.
     */
    public function store(Request $request): RedirectResponse
    {
        // Identitas pekerja otomatis berdasarkan akun login.
        $worker = $request->user()->worker;

        if (!$worker || !$worker->is_active) {
            abort(403, 'Akun Anda belum terhubung dengan data pekerja aktif.');
        }

        // Mengambil APD aktif yang wajib digunakan.
        $items = ApdItem::where('is_active', true)
            ->where('is_required', true)
            ->orderBy('id')
            ->get();

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'checklist' => 'Belum ada APD wajib yang aktif.',
            ]);
        }

        // Validasi checklist, video, dan catatan.
        // worker_id tidak lagi dikirim dari form.
        $data = $request->validate([
            'checked_apd' => ['nullable', 'array'],

            'checked_apd.*' => [
                'integer',
                'distinct',
                'exists:apd_items,id',
            ],

            'video' => [
                'nullable',
                'file',
                'mimes:webm,mp4,mov,avi',
                'max:102400',
            ],

            'notes' => ['nullable', 'string', 'max:2000'],
        ], [
            'checked_apd.*.exists' =>
                'Terdapat jenis APD yang tidak ditemukan.',

            'video.mimes' =>
                'Video harus berformat WEBM, MP4, MOV, atau AVI.',

            'video.max' =>
                'Ukuran video maksimal 100 MB.',
        ]);

        // Mengubah ID checklist menjadi angka dan menghapus duplikat.
        $checkedIds = collect($data['checked_apd'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique();

        // Memastikan hanya APD aktif yang boleh dicentang.
        $validIds = ApdItem::whereIn('id', $checkedIds)
            ->where('is_active', true)
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        if ($checkedIds->diff($validIds)->isNotEmpty()) {
            throw ValidationException::withMessages([
                'checked_apd' =>
                    'Terdapat APD yang tidak aktif atau tidak valid.',
            ]);
        }

        // Menentukan status berdasarkan seluruh APD wajib.
        $requiredIds = $items->pluck('id')
            ->map(fn ($id) => (int) $id);

        $status = $requiredIds->diff($checkedIds)->isEmpty()
            ? 'complete'
            : 'incomplete';

        // Menyimpan video bukti jika tersedia.
        $videoPath = null;

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')
                ->store('apd-videos', 'public');
        }

        try {
            DB::transaction(function () use (
                $request,
                $worker,
                $data,
                $items,
                $checkedIds,
                $status,
                $videoPath
            ) {
                // Menyimpan pemeriksaan dengan identitas pekerja otomatis.
                $inspection = ApdInspection::create([
                    'user_id' => $request->user()->id,
                    'worker_id' => $worker->id,
                    'started_at' => now(),
                    'ended_at' => now(),
                    'status' => $status,
                    'evidence_path' => $videoPath,
                    'notes' => $data['notes'] ?? null,
                ]);

                // Menyimpan detail pemeriksaan setiap APD wajib.
                foreach ($items as $item) {
                    $checked = $checkedIds->contains(
                        (int) $item->id
                    );

                    ApdInspectionDetail::create([
                        'inspection_id' => $inspection->id,
                        'apd_item_id' => $item->id,
                        'is_detected' => $checked,
                        'confidence' => null,
                        'status' => $checked
                            ? 'complete'
                            : 'incomplete',
                    ]);
                }
            });
        } catch (\Throwable $e) {
            // Menghapus video jika penyimpanan database gagal.
            if ($videoPath) {
                Storage::disk('public')->delete($videoPath);
            }

            throw $e;
        }

        return redirect()
            ->route('pekerja.dashboard')
            ->with(
                'success',
                $status === 'complete'
                    ? 'Pemeriksaan berhasil disimpan. APD LENGKAP.'
                    : 'Pemeriksaan berhasil disimpan. APD TIDAK LENGKAP.'
            );
    }
}
