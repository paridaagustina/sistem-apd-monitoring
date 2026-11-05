<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FieldReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminFieldReportController extends Controller
{
    /**
     * Daftar laporan lapangan.
     */
    public function index(Request $request)
    {
        $query = FieldReport::with('user')
            ->latest('submitted_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('location_name', 'like', "%{$cari}%")
                    ->orWhereHas('user', function ($userQuery) use ($cari) {
                        $userQuery->where('name', 'like', "%{$cari}%");
                    });
            });
        }

        $reports = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => FieldReport::count(),

            'menunggu' => FieldReport::where(
                'status',
                'menunggu'
            )->count(),

            'diperiksa' => FieldReport::where(
                'status',
                'diperiksa'
            )->count(),
        ];

        return view(
            'admin.field-reports.index',
            compact('reports', 'stats')
        );
    }

    /**
     * Detail laporan.
     */
    public function show(FieldReport $fieldReport)
    {
        $fieldReport->load('user');

        return view(
            'admin.field-reports.detail',
            compact('fieldReport')
        );
    }

    /**
     * Memutar video secara privat.
     */
    public function video(FieldReport $fieldReport)
    {
        abort_unless(
            Storage::disk('local')->exists($fieldReport->video_path),
            404,
            'Video tidak ditemukan.'
        );

        return response()->file(
            Storage::disk('local')->path($fieldReport->video_path),
            [
                'Content-Type' => $this->videoMimeType($fieldReport),
                'Content-Disposition' => 'inline',
                'X-Content-Type-Options' => 'nosniff',
                'Cache-Control' => 'private, no-store',
            ]
        );
    }

    /**
     * Mengunduh video.
     */
    public function download(FieldReport $fieldReport)
    {
        abort_unless(
            Storage::disk('local')->exists($fieldReport->video_path),
            404,
            'Video tidak ditemukan.'
        );

        return Storage::disk('local')->download(
            $fieldReport->video_path,
            'laporan-lapangan-' . $fieldReport->id . '.' .
                pathinfo($fieldReport->video_path, PATHINFO_EXTENSION)
        );
    }

    /**
     * Mengubah status laporan.
     */
    public function updateStatus(
        Request $request,
        FieldReport $fieldReport
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['menunggu', 'diperiksa']),
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $fieldReport->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.field-reports.show', $fieldReport)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Menentukan MIME video berdasarkan ekstensi file.
     */
    private function videoMimeType(FieldReport $report): string
    {
        return match (
            strtolower(pathinfo($report->video_path, PATHINFO_EXTENSION))
        ) {
            'mp4', 'm4v' => 'video/mp4',
            'mov' => 'video/quicktime',
            default => 'video/webm',
        };
    }
}