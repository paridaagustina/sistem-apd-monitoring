<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\FieldReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class FieldReportController extends Controller
{
    /**
     * Halaman perekaman dan riwayat laporan pekerja.
     */
    public function index()
    {
        $reports = FieldReport::where('user_id', auth()->id())
            ->latest('submitted_at')
            ->paginate(10);

        return view('pekerja.field-reports.index', compact('reports'));
    }

    /**
     * Menyimpan video laporan lapangan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_name' => [
                'required',
                'string',
                'max:255',
            ],

            'started_at' => [
                'required',
                'date',
            ],

            'ended_at' => [
                'required',
                'date',
                'after:started_at',
            ],

            'video_duration' => [
                'required',
                'integer',
                'min:1',
                'max:3600',
            ],

            'video' => [
                'required',
                'file',
                'mimes:webm,mp4,mov',
                'max:102400',
            ],
        ]);

        $startedAt = \Carbon\Carbon::parse(
            $validated['started_at']
        );

        $endedAt = \Carbon\Carbon::parse(
            $validated['ended_at']
        );

        if ($startedAt->isFuture()) {
            throw ValidationException::withMessages([
                'started_at' => 'Waktu mulai tidak boleh di masa depan.',
            ]);
        }

        if ($endedAt->greaterThan(now())) {
            throw ValidationException::withMessages([
                'ended_at' => 'Waktu selesai tidak boleh di masa depan.',
            ]);
        }

        if ($endedAt->lessThanOrEqualTo($startedAt)) {
            throw ValidationException::withMessages([
                'ended_at' => 'Waktu selesai harus setelah waktu mulai.',
            ]);
        }

        if ($startedAt->diffInSeconds($endedAt) > 3600) {
            throw ValidationException::withMessages([
                'ended_at' => 'Durasi laporan tidak boleh lebih dari satu jam.',
            ]);
        }

        $video = $request->file('video');

        $videoPath = $video->store(
            'field-reports/' . auth()->id(),
            'local'
        );

        if (!$videoPath) {
            throw ValidationException::withMessages([
                'video' => 'Video gagal disimpan. Silakan coba lagi.',
            ]);
        }

        try {
            $report = FieldReport::create([
                'user_id' => auth()->id(),
                'location_name' => $validated['location_name'],
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
                'submitted_at' => now(),
                'video_path' => $videoPath,
                'video_duration' => $validated['video_duration'],
                'video_size' => $video->getSize(),
                'status' => 'menunggu',
            ]);
        } catch (\Throwable $e) {
            Storage::disk('local')->delete($videoPath);

            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'video' => 'Laporan gagal disimpan. Silakan coba kembali.',
                ]);
        }

        return redirect()
            ->route('pekerja.field-reports.index')
            ->with('success', 'Laporan lapangan berhasil dikirim.');
    }
}