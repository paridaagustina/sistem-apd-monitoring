<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthCheck;
use App\Models\Worker;
use Illuminate\Http\Request;

class HealthDashboardController extends Controller
{
    /**
     * Dashboard monitoring kesehatan petugas.
     */
    public function index(Request $request)
    {
        // Petugas aktif
        $workers = Worker::where('is_active', true)
            ->orderBy('name')
            ->get();

        $totalPetugas = $workers->count();

        // Pemeriksaan hari ini
        $todayChecks = HealthCheck::whereDate(
            'tanggal_periksa',
            today()
        )->get();

        $examinedNames = $todayChecks
            ->pluck('nama_petugas')
            ->unique()
            ->values();

        $totalSudahDiperiksaHariIni = $examinedNames->count();

        $totalBelumDiperiksaHariIni = $workers
            ->filter(fn ($worker) =>
                !$examinedNames->contains($worker->name)
            )
            ->count();

        $persenSudahDiperiksa = $totalPetugas > 0
            ? round(($totalSudahDiperiksaHariIni / $totalPetugas) * 100)
            : 0;

        $persenBelumDiperiksa = 100 - $persenSudahDiperiksa;

        // Total seluruh pemeriksaan
        $totalPemeriksaan = HealthCheck::count();

        // Kesimpulan seluruh riwayat
        $totalSiapBekerja = HealthCheck::where(
            'kesimpulan',
            'SIAP BEKERJA'
        )->count();

        $totalTidakDisarankan = HealthCheck::where(
            'kesimpulan',
            '!=',
            'SIAP BEKERJA'
        )->whereNotNull('kesimpulan')->count();

        // Top 5 petugas paling rutin diperiksa
        $topPetugas = HealthCheck::selectRaw(
            'nama_petugas, COUNT(*) as total_pemeriksaan'
        )
            ->whereNotNull('nama_petugas')
            ->groupBy('nama_petugas')
            ->orderByDesc('total_pemeriksaan')
            ->limit(5)
            ->get()
            ->map(function ($item) use ($workers) {
                $worker = $workers->firstWhere(
                    'name',
                    $item->nama_petugas
                );

                return (object) [
                    'worker_id' => $worker?->id,
                    'name' => $item->nama_petugas,
                    'photo' => $worker?->photo,
                    'total_pemeriksaan' => $item->total_pemeriksaan,
                ];
            });

        // Top 5 unit paling aktif
        $topUnit = HealthCheck::selectRaw(
            'unit, COUNT(*) as total_pemeriksaan'
        )
            ->whereNotNull('unit')
            ->where('unit', '!=', '')
            ->groupBy('unit')
            ->orderByDesc('total_pemeriksaan')
            ->limit(5)
            ->get();

        // Petugas sudah diperiksa hari ini
        $todayExaminedWorkers = $workers
            ->filter(fn ($worker) =>
                $examinedNames->contains($worker->name)
            )
            ->values();

        // Petugas belum diperiksa hari ini
        $notExaminedWorkersToday = $workers
            ->filter(fn ($worker) =>
                !$examinedNames->contains($worker->name)
            )
            ->values();

        // Daftar unit berdasarkan petugas aktif
        $allUnits = $workers
            ->pluck('unit')
            ->filter()
            ->unique()
            ->values();

        $examinedUnits = $todayChecks
            ->pluck('unit')
            ->filter()
            ->unique()
            ->intersect($allUnits)
            ->values();

        $notExaminedUnits = $allUnits
            ->diff($examinedUnits)
            ->values();

        $totalUnit = $allUnits->count();
        $totalUnitSudahMemeriksa = $examinedUnits->count();
        $totalUnitBelumMemeriksa = $notExaminedUnits->count();

        // Pencarian riwayat pemeriksaan
        $search = $request->input('search');

        $healthChecks = HealthCheck::query()
            ->when($search, function ($query, $search) {
                $query->where(
                    'nama_petugas',
                    'like',
                    '%' . $search . '%'
                );
            })
            ->latest('tanggal_periksa')
            ->paginate(10)
            ->withQueryString();

        return view('admin.health-check.index', compact(
            'workers',
            'totalPetugas',
            'totalSudahDiperiksaHariIni',
            'totalBelumDiperiksaHariIni',
            'persenSudahDiperiksa',
            'persenBelumDiperiksa',
            'totalPemeriksaan',
            'totalSiapBekerja',
            'totalTidakDisarankan',
            'topPetugas',
            'topUnit',
            'todayExaminedWorkers',
            'notExaminedWorkersToday',
            'examinedUnits',
            'notExaminedUnits',
            'totalUnit',
            'totalUnitSudahMemeriksa',
            'totalUnitBelumMemeriksa',
            'healthChecks',
            'search'
        ));
    }

    /**
     * Riwayat pemeriksaan satu petugas.
     */
    public function showWorker(Worker $worker)
    {
        $healthChecks = HealthCheck::where(
            'nama_petugas',
            $worker->name
        )
            ->latest('tanggal_periksa')
            ->paginate(10);

        return view('admin.health-check.worker-history', compact(
            'worker',
            'healthChecks'
        ));
    }

    /**
     * Detail satu pemeriksaan kesehatan.
     */
    public function show(HealthCheck $healthCheck)
    {
        $healthCheck->load('user');

        return view('admin.health-check.show', compact(
            'healthCheck'
        ));
    }
}
