
@extends('layouts.app')

@section('title', 'Dashboard Pekerja - APDMONITOR')

@section('content')

<style>
    .dashboard-pekerja {
        width: 100%;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #2457d6, #4779e8);
        color: white;
        border-radius: 18px;
        padding: 30px;
        margin-bottom: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .dashboard-header h1 {
        margin: 12px 0 8px;
        font-size: clamp(25px, 4vw, 32px);
    }

    .dashboard-header p {
        color: #e5edff;
        line-height: 1.7;
        max-width: 600px;
    }

    .badge-pekerja {
        display: inline-block;
        background: #dce8ff;
        color: #1945a8;
        border-radius: 20px;
        padding: 7px 13px;
        font-size: 11px;
        font-weight: bold;
    }

    .dashboard-header .tombol {
        background: white;
        color: #2457d6;
        white-space: nowrap;
    }

    .dashboard-header .tombol:hover {
        background: #edf2ff;
    }

    .statistik-pekerja {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .statistik-pekerja .kartu {
        margin-bottom: 0;
    }

    .ikon-statistik {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #e8efff;
        color: #2457d6;
        font-size: 20px;
        margin-bottom: 13px;
    }

    .dashboard-section {
        margin-bottom: 20px;
    }

    .dashboard-section h2 {
        margin-bottom: 8px;
    }

    .aksi-monitoring {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .aksi-monitoring .tombol {
        white-space: nowrap;
    }

    .tabel-dashboard {
        width: 100%;
        border-collapse: collapse;
    }

    .tabel-dashboard th,
    .tabel-dashboard td {
        padding: 13px 10px;
        text-align: left;
        border-bottom: 1px solid #e0e6ef;
    }

    .tabel-dashboard th {
        color: #65718a;
        font-size: 12px;
    }

    .kosong {
        text-align: center;
        padding: 30px 15px;
        color: #65718a;
    }

    @media (max-width: 700px) {
        .statistik-pekerja {
            grid-template-columns: 1fr;
        }

        .dashboard-header {
            padding: 22px;
        }

        .aksi-monitoring {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="dashboard-pekerja">

    <!-- Sambutan -->
    <div class="dashboard-header">
        <div>
            <span class="badge-pekerja">PEKERJA LAPANGAN</span>

            <h1>Dashboard Pekerja</h1>

            <p>
                Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
                Pantau hasil pemeriksaan kelengkapan APD dan lakukan
                monitoring keselamatan kerja melalui halaman monitoring.
            </p>
        </div>

        <a href="{{ route('pekerja.monitoring') }}" class="tombol">
            Mulai Monitoring APD →
        </a>
    </div>
    {{-- Live Laporan Lapangan --}}
<div class="kartu dashboard-section">

    <div class="aksi-monitoring">
        <div>
            <h2>Live Laporan Lapangan</h2>

            <p class="teks-redup">
                Sudah sampai di lokasi? Rekam kondisi lapangan,
                lalu kirim video beserta informasi waktu kepada admin.
                Fitur ini terpisah dari pemeriksaan APD.
            </p>
        </div>

        <a
            href="{{ route('pekerja.field-reports.index') }}"
            class="tombol">
            Buka Laporan Lapangan
        </a>
    </div>

</div>

    <!-- Statistik Pemeriksaan -->
    <div class="statistik-pekerja">

        <div class="kartu">
            <div class="ikon-statistik">📋</div>
            <div class="teks-redup">Total Pemeriksaan</div>
            <div class="angka">
                {{ $stats['total'] ?? 0 }}
            </div>
            <span class="status hijau">Seluruh riwayat saya</span>
        </div>

        <div class="kartu">
            <div class="ikon-statistik">✓</div>
            <div class="teks-redup">APD Lengkap</div>
            <div class="angka" style="color: #166534;">
                {{ $stats['lengkap'] ?? 0 }}
            </div>
            <span class="status hijau">Memenuhi persyaratan</span>
        </div>

        <div class="kartu">
            <div class="ikon-statistik">!</div>
            <div class="teks-redup">APD Tidak Lengkap</div>
            <div class="angka" style="color: #b91c1c;">
                {{ $stats['tidak_lengkap'] ?? 0 }}
            </div>
            <span class="status merah">Perlu tindak lanjut</span>
        </div>

    </div>

    <!-- Informasi Monitoring -->
    <div class="kartu dashboard-section">
        <div class="aksi-monitoring">
            <div>
                <h2>Monitoring Kelengkapan APD</h2>

                <p class="teks-redup">
                    Lakukan pemeriksaan terhadap pekerja dan pastikan
                    penggunaan helm, rompi, sepatu keselamatan,
                    kacamata pelindung, sarung tangan, serta masker
                    sesuai standar keselamatan kerja.
                </p>
            </div>

            <a href="{{ route('pekerja.monitoring') }}" class="tombol">
                Buka Monitoring
            </a>
        </div>
    </div>

    <!-- Riwayat Pemeriksaan -->
    <div class="kartu dashboard-section">

        <h2>Riwayat Pemeriksaan Saya</h2>

        <p class="teks-redup" style="margin-bottom: 18px;">
            Daftar pemeriksaan APD yang telah kamu lakukan.
        </p>

        @if($inspections->isEmpty())

            <div class="kosong">
                <div style="font-size: 35px; margin-bottom: 10px;">📋</div>

                <strong>Belum Ada Riwayat Pemeriksaan</strong>

                <p style="margin-top: 7px;">
                    Kamu belum melakukan pemeriksaan APD.
                    Klik tombol Monitoring APD untuk memulai.
                </p>

                <div style="margin-top: 18px;">
                    <a href="{{ route('pekerja.monitoring') }}" class="tombol">
                        Mulai Pemeriksaan
                    </a>
                </div>
            </div>

        @else

            <div class="pembungkus-tabel">
                <table class="tabel-dashboard">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Waktu Pemeriksaan</th>
                            <th>Nama Pekerja</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($inspections as $inspection)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $inspection->started_at
                                        ? $inspection->started_at->format('d/m/Y H:i')
                                        : ($inspection->created_at
                                            ? $inspection->created_at->format('d/m/Y H:i')
                                            : '-') }}
                                </td>

                                <td>
                                    {{ $inspection->worker?->name
                                        ?? $inspection->worker?->nama
                                        ?? '-' }}
                                </td>

                                <td>
                                    @if($inspection->status === 'lengkap')
                                        <span class="status hijau">
                                            Lengkap
                                        </span>
                                    @elseif($inspection->status === 'tidak_lengkap')
                                        <span class="status merah">
                                            Tidak Lengkap
                                        </span>
                                    @else
                                        <span class="status">
                                            {{ ucfirst(str_replace('_', ' ', $inspection->status ?? 'Belum diketahui')) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>

</div>

@endsection
