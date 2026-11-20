<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthCheck;

class HealthDashboardController extends Controller
{
    /**
     * Daftar nama petugas yang tersedia pada formulir kesehatan.
     */
    private function petugasNames(): array
    {
        return [
            'MUHAMMAD PAISAL ALPARISI',
            'SAMSIR NUR ALAM',
            'ALPI YANOOR',
            'RAHMADI',
            'TRIYONO',
            'MUHAMMAD NOFIE',
            'FAUZI',
            'IMAN SAPUTRA',
            'FAHRIANNOR',
            'MASRI',
            'NANANG ISWAHYUDI',
            'MAKSUM',
            'AGUS SUGIYONO',
            'HANDOYO SAPUTRO',
            'IWAN HARTONO',
            'SUBHAN RAMADHAN PRATAMA',
            'AHMAD RIFANI',
            'HENDRA',
            'MUHAMAD RENALDI',
            'AKHMAD KAMAL FAHRIYANUR',
            'AHMAD ANSOR',
            'SLAMET SETIAWAN',
            'MUHAMMAD KHALILUR RAHMAN',
            'SUKMA KELANA PUTRA',
            'ARJUN PRASETYO W',
            'MUHAMMAD AGUS RIDANI',
            'ABDUL MAJID',
            "MUHAMMAD RAPI'I AKBAR",
            'ASTIMAWANTO',
            'DWI PUSPITA SARI',
        ];
    }

    public function index()
    {
        $petugasNames = $this->petugasNames();

        // Mengambil nama petugas yang sudah pernah diperiksa.
        $examinedNames = HealthCheck::query()
            ->whereIn('nama_petugas', $petugasNames)
            ->distinct()
            ->pluck('nama_petugas');

        $notExaminedNames = collect($petugasNames)
            ->diff($examinedNames)
            ->values();

        $totalPetugas = count($petugasNames);
        $totalSudahDiperiksa = $examinedNames->count();
        $totalBelumDiperiksa = $notExaminedNames->count();

        // Menghitung seluruh riwayat pemeriksaan.
        $totalPemeriksaan = HealthCheck::count();

        $totalHariIni = HealthCheck::whereDate(
            'tanggal_periksa',
            today()
        )->count();

        // Menghitung hasil kesimpulan pemeriksaan.
        $totalSiapBekerja = HealthCheck::where(
            'kesimpulan',
            'SIAP BEKERJA'
        )->count();

        $totalTidakDisarankan = HealthCheck::where(
            'kesimpulan',
            'TIDAK DISARANKAN BEKERJA'
        )->count();

        // Persentase petugas yang sudah diperiksa.
        $persenSudahDiperiksa = $totalPetugas > 0
            ? round(($totalSudahDiperiksa / $totalPetugas) * 100)
            : 0;

        $persenBelumDiperiksa = $totalPetugas > 0
            ? round(($totalBelumDiperiksa / $totalPetugas) * 100)
            : 0;

        // Riwayat pemeriksaan terbaru.
        $healthChecks = HealthCheck::with('user')
            ->orderByDesc('tanggal_periksa')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.health-check.index', compact(
            'totalPetugas',
            'totalSudahDiperiksa',
            'totalBelumDiperiksa',
            'totalPemeriksaan',
            'totalHariIni',
            'totalSiapBekerja',
            'totalTidakDisarankan',
            'persenSudahDiperiksa',
            'persenBelumDiperiksa',
            'notExaminedNames',
            'healthChecks'
        ));
    }

    public function show(HealthCheck $healthCheck)
    {
        $healthCheck->load('user');

        return view('admin.health-check.show', compact(
            'healthCheck'
        ));
    }
}