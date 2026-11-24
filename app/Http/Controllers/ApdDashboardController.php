<?php

namespace App\Http\Controllers;

use App\Models\ApdInspection;
use App\Models\ApdItem;
use App\Models\HealthCheck;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;

class ApdDashboardController extends Controller
{
    /**
     * Dashboard khusus Admin.
     */
    public function admin()
    {
        $stats = [
            'apd_items' => ApdItem::count(),
            'workers' => Worker::count(),
            'total' => ApdInspection::count(),
            'lengkap' => ApdInspection::where('status', 'lengkap')->count(),
            'tidak_lengkap' => ApdInspection::where('status', 'tidak_lengkap')->count(),
        ];

        $inspections = ApdInspection::with(['worker', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'inspections'
        ));
    }

    /**
     * Dashboard khusus Pekerja Lapangan.
     */
    public function pekerja()
    {
        // Mengambil ID akun pekerja yang sedang login.
        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | 1. STATISTIK PEMERIKSAAN APD
        |--------------------------------------------------------------------------
        */

        $query = ApdInspection::where('user_id', $userId);

        $stats = [
            'total' => (clone $query)->count(),

            'lengkap' => (clone $query)
                ->where('status', 'lengkap')
                ->count(),

            'tidak_lengkap' => (clone $query)
                ->where('status', 'tidak_lengkap')
                ->count(),
        ];

        $inspections = ApdInspection::with('worker')
            ->where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 2. DAFTAR UNIT
        |--------------------------------------------------------------------------
        */

        $units = [
            'ULP Gambut',
            'ULP Ahmad Yani',
            'ULP Lambung Mangkurat',
            'ULP Banjarbaru',
            'ULP Marabahan',
            'ULP Pelaihari',
            'ULP Martapura',
        ];

        /*
        |--------------------------------------------------------------------------
        | 3. DATA PETUGAS AKTIF
        |--------------------------------------------------------------------------
        */

        $workers = Worker::where('is_active', true)
            ->orderBy('name')
            ->get();

        $totalPetugas = $workers->count();

        /*
        |--------------------------------------------------------------------------
        | 4. DATA PEMERIKSAAN KESEHATAN HARI INI
        |--------------------------------------------------------------------------
        */

        $today = now()->toDateString();

        $healthChecksToday = HealthCheck::whereDate(
            'tanggal_periksa',
            $today
        )->get();

        // Nama petugas yang sudah diperiksa hari ini.
        $sudahDiperiksaNames = $healthChecksToday
            ->pluck('nama_petugas')
            ->filter()
            ->unique()
            ->values();

        // Petugas aktif yang sudah diperiksa.
        $todayExaminedWorkers = $workers
            ->whereIn('name', $sudahDiperiksaNames)
            ->values();

        // Petugas aktif yang belum diperiksa hari ini.
        $notExaminedWorkersToday = $workers
            ->whereNotIn('name', $sudahDiperiksaNames)
            ->values();

        // Jumlah petugas yang sudah diperiksa hari ini.
        $totalSudahDiperiksaHariIni = $todayExaminedWorkers->count();

        // Jumlah petugas yang belum diperiksa hari ini.
        $totalBelumDiperiksaHariIni = $notExaminedWorkersToday->count();

        // Jumlah seluruh catatan pemeriksaan hari ini.
        $totalPemeriksaanHariIni = $healthChecksToday->count();

        /*
        |--------------------------------------------------------------------------
        | 5. PERSENTASE PEMERIKSAAN KESEHATAN
        |--------------------------------------------------------------------------
        */

        if ($totalPetugas > 0) {
            $persenSudahDiperiksa = round(
                ($totalSudahDiperiksaHariIni / $totalPetugas) * 100,
                1
            );

            $persenBelumDiperiksa = round(
                ($totalBelumDiperiksaHariIni / $totalPetugas) * 100,
                1
            );
        } else {
            $persenSudahDiperiksa = 0;
            $persenBelumDiperiksa = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | 6. TOTAL SELURUH RIWAYAT PEMERIKSAAN KESEHATAN
        |--------------------------------------------------------------------------
        */

        $totalPemeriksaanKesehatan = HealthCheck::count();

        /*
        |--------------------------------------------------------------------------
        | 7. UNIT SUDAH DAN BELUM MEMERIKSA HARI INI
        |--------------------------------------------------------------------------
        */

        $unitsSudahMemeriksa = $healthChecksToday
            ->pluck('unit')
            ->filter()
            ->unique()
            ->values();

        // Unit yang sudah melakukan pemeriksaan.
        $examinedUnits = collect($units)
            ->intersect($unitsSudahMemeriksa)
            ->values();

        // Unit yang belum melakukan pemeriksaan.
        $notExaminedUnits = collect($units)
            ->diff($examinedUnits)
            ->values();

        $totalUnit = count($units);

        $totalUnitSudahMemeriksa = $examinedUnits->count();

        $totalUnitBelumMemeriksa = $notExaminedUnits->count();

        /*
        |--------------------------------------------------------------------------
        | 8. TOP 5 PETUGAS PALING RUTIN DIPERIKSA
        |--------------------------------------------------------------------------
        |
        | Data hanya diambil dari pemeriksaan yang disimpan
        | melalui akun pekerja yang sedang login.
        |
        */

        // Mengambil data seluruh pekerja untuk mencocokkan foto.
        $workersByName = Worker::get()->keyBy('name');

        $topPetugas = HealthCheck::where('user_id', $userId)
            ->selectRaw(
                'nama_petugas, COUNT(*) as total_pemeriksaan'
            )
            ->whereNotNull('nama_petugas')
            ->groupBy('nama_petugas')
            ->orderByDesc('total_pemeriksaan')
            ->take(5)
            ->get()
            ->map(function ($item) use ($workersByName) {

                // Mencocokkan nama pemeriksaan dengan data pekerja.
                $worker = $workersByName->get($item->nama_petugas);

                // Menyesuaikan properti dengan dashboard Blade.
                $item->name = $item->nama_petugas;
                $item->photo = $worker?->photo;

                return $item;
            });

        /*
        |--------------------------------------------------------------------------
        | 9. TOP 5 UNIT PALING RUTIN MELAKUKAN PEMERIKSAAN
        |--------------------------------------------------------------------------
        */

        $topUnit = HealthCheck::selectRaw(
                'unit, COUNT(*) as total_pemeriksaan'
            )
            ->whereNotNull('unit')
            ->groupBy('unit')
            ->orderByDesc('total_pemeriksaan')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 10. RIWAYAT PEMERIKSAAN KESEHATAN HARI INI
        |--------------------------------------------------------------------------
        */

        $riwayatKesehatanHariIni = HealthCheck::with('user')
            ->whereDate('tanggal_periksa', $today)
            ->orderByDesc('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 11. KIRIM SELURUH DATA KE DASHBOARD PEKERJA
        |--------------------------------------------------------------------------
        */

        return view('pekerja.dashboard', compact(

            // Statistik APD
            'stats',
            'inspections',

            // Data unit
            'units',
            'totalUnit',
            'totalUnitSudahMemeriksa',
            'totalUnitBelumMemeriksa',
            'examinedUnits',
            'notExaminedUnits',

            // Data petugas
            'workers',
            'totalPetugas',

            // Pemeriksaan kesehatan hari ini
            'todayExaminedWorkers',
            'notExaminedWorkersToday',
            'totalSudahDiperiksaHariIni',
            'totalBelumDiperiksaHariIni',
            'totalPemeriksaanHariIni',

            // Persentase
            'persenSudahDiperiksa',
            'persenBelumDiperiksa',

            // Total riwayat kesehatan
            'totalPemeriksaanKesehatan',

            // Peringkat petugas dan unit
            'topPetugas',
            'topUnit',

            // Riwayat kesehatan
            'riwayatKesehatanHariIni'
        ));
    }
}