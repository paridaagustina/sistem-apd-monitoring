@extends('layouts.app')

@section('title', 'Dashboard Pekerja - APDMONITOR')
@section('page-heading', 'Dashboard Pekerja')

@push('styles')
<style>
    .dashboard-pekerja {
        width: 100%;
    }

    /* HERO */
    .dashboard-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #1747bd, #3678ee);
        color: white;
        border-radius: 20px;
        padding: 38px;
        margin-bottom: 23px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        min-height: 225px;
        box-shadow: 0 12px 30px rgba(37, 99, 235, .17);
    }

    .dashboard-header::after {
        content: "";
        position: absolute;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: rgba(255,255,255,.09);
        right: 5%;
        top: -170px;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 650px;
    }

    .badge-pekerja {
        display: inline-block;
        background: rgba(255,255,255,.2);
        color: white;
        border: 1px solid rgba(255,255,255,.3);
        border-radius: 30px;
        padding: 8px 14px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .dashboard-header h1 {
        margin: 17px 0 10px;
        font-size: clamp(27px, 4vw, 36px);
        font-weight: 800;
    }

    .dashboard-header p {
        color: #e5edff;
        line-height: 1.8;
        margin: 0;
        font-size: 14px;
    }

    .hero-button {
        position: relative;
        z-index: 2;
        background: white;
        color: #2055c9;
        white-space: nowrap;
    }

    .hero-button:hover {
        background: #edf3ff;
        color: #1747bd;
    }

    .hero-decoration {
        position: absolute;
        right: 17%;
        bottom: 17px;
        font-size: 90px;
        opacity: .15;
        transform: rotate(-12deg);
    }

    /* SECTION */
    .dashboard-section {
        margin-bottom: 22px;
    }

    .section-heading {
        font-size: 17px;
        font-weight: 800;
        color: #172554;
        margin: 0 0 8px;
    }

    .section-description {
        color: #718096;
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
    }

    /* FIELD REPORT */
    .field-report-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        border-left: 5px solid #5b91ff;
    }

    .field-report-info {
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .field-report-icon {
        min-width: 58px;
        height: 58px;
        border-radius: 17px;
        background: #eaf1ff;
        color: #2563eb;
        display: grid;
        place-items: center;
        font-size: 26px;
    }

    /* STATISTICS */
    .statistik-pekerja {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 23px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 17px;
        min-height: 145px;
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(34,65,120,.09);
    }

    .stat-icon {
        width: 65px;
        height: 65px;
        min-width: 65px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        font-size: 29px;
    }

    .stat-blue .stat-icon {
        background: #e5efff;
        color: #2563eb;
    }

    .stat-green .stat-icon {
        background: #d9f8ee;
        color: #07966e;
    }

    .stat-red .stat-icon {
        background: #f0eaff;
        color: #7950df;
    }

    .stat-label {
        color: #718096;
        font-size: 13px;
        font-weight: 600;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        margin: 8px 0;
        color: #172554;
    }

    .stat-blue .stat-number {
        color: #2563eb;
    }

    .stat-green .stat-number {
        color: #07966e;
    }

    .stat-red .stat-number {
        color: #7950df;
    }

    /* MONITORING */
    .monitoring-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        background: linear-gradient(120deg, #ffffff, #f2f7ff);
    }

    .monitoring-icon {
        font-size: 30px;
        margin-bottom: 10px;
    }

    /* TABLE */
    .table-title {
        font-size: 17px;
        font-weight: 800;
        margin: 0;
    }

    .table-subtitle {
        color: #718096;
        font-size: 13px;
        margin: 7px 0 20px;
    }

    .tabel-dashboard {
        width: 100%;
        border-collapse: collapse;
        min-width: 550px;
    }

    .tabel-dashboard th {
        background: #f7f9fd;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .tabel-dashboard td,
    .tabel-dashboard th {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #edf1f7;
    }

    .tabel-dashboard tbody tr:hover {
        background: #f8faff;
    }

    .kosong {
        text-align: center;
        padding: 45px 15px;
        color: #718096;
    }

    .kosong-icon {
        font-size: 43px;
        margin-bottom: 12px;
    }

    .kosong strong {
        display: block;
        color: #172554;
        font-size: 15px;
    }

    .kosong p {
        font-size: 13px;
        margin: 8px 0;
    }

    @media(max-width: 950px) {
        .statistik-pekerja {
            grid-template-columns: 1fr;
        }

        .stat-card {
            min-height: 115px;
        }
    }

    @media(max-width: 600px) {
        .dashboard-header {
            padding: 25px 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-header p {
            font-size: 13px;
        }

        .hero-decoration {
            right: 5%;
            font-size: 65px;
        }

        .field-report-card,
        .monitoring-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .field-report-info {
            align-items: flex-start;
        }

        .field-report-card .tombol,
        .monitoring-card .tombol {
            width: 100%;
        }

        .statistik-pekerja {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<div class="dashboard-pekerja">

    {{-- HERO --}}
    <div class="dashboard-header">

        <div class="hero-content">
            <span class="badge-pekerja">🛡 PEKERJA LAPANGAN</span>

            <h1>Dashboard Pekerja</h1>

            <p>
                Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
                Pantau hasil pemeriksaan kelengkapan APD dan lakukan
                monitoring keselamatan kerja melalui halaman monitoring.
            </p>
        </div>

        <a href="{{ route('pekerja.monitoring') }}"
           class="tombol hero-button">
            Mulai Monitoring APD →
        </a>

        <div class="hero-decoration">🦺</div>
    </div>

    {{-- LAPORAN LAPANGAN --}}
    <div class="kartu dashboard-section field-report-card">

        <div class="field-report-info">
            <div class="field-report-icon">📈</div>

            <div>
                <h2 class="section-heading">Laporan Lapangan</h2>

                <p class="section-description">
                    Rekam kondisi lapangan, lalu kirim video beserta
                    informasi waktu kepada admin. Fitur ini terpisah
                    dari pemeriksaan APD.
                </p>
            </div>
        </div>

        <a href="{{ route('pekerja.field-reports.index') }}"
           class="tombol">
            📷 Buka Laporan Lapangan →
        </a>

    </div>

    {{-- STATISTIK --}}
    <div class="statistik-pekerja">

        <div class="kartu stat-card stat-blue">
            <div class="stat-icon">📋</div>
            <div>
                <div class="stat-label">Total Pemeriksaan</div>
                <div class="stat-number">
                    {{ $stats['total'] ?? 0 }}
                </div>
                <span class="status" style="background:#e5efff;color:#2563eb;">
                    Seluruh riwayat saya
                </span>
            </div>
        </div>

        <div class="kartu stat-card stat-green">
            <div class="stat-icon">🛡️</div>
            <div>
                <div class="stat-label">APD Lengkap</div>
                <div class="stat-number">
                    {{ $stats['lengkap'] ?? 0 }}
                </div>
                <span class="status hijau">
                    Memenuhi persyaratan
                </span>
            </div>
        </div>

        <div class="kartu stat-card stat-red">
            <div class="stat-icon">⚠️</div>
            <div>
                <div class="stat-label">APD Tidak Lengkap</div>
                <div class="stat-number">
                    {{ $stats['tidak_lengkap'] ?? 0 }}
                </div>
                <span class="status merah">
                    Perlu tindak lanjut
                </span>
            </div>
        </div>

    </div>

    {{-- MONITORING --}}
    <div class="kartu dashboard-section monitoring-card">

        <div>
            <div class="monitoring-icon">🔍</div>

            <h2 class="section-heading">
                Monitoring Kelengkapan APD
            </h2>

            <p class="section-description">
                Pastikan penggunaan helm, rompi, sepatu keselamatan,
                kacamata pelindung, sarung tangan, serta masker
                sesuai standar keselamatan kerja.
            </p>
        </div>

        <a href="{{ route('pekerja.monitoring') }}" class="tombol">
            Buka Monitoring →
        </a>

    </div>

    {{-- RIWAYAT PEMERIKSAAN --}}
    <div class="kartu dashboard-section">

        <h2 class="table-title">Riwayat Pemeriksaan Saya</h2>

        <p class="table-subtitle">
            Daftar pemeriksaan APD yang telah kamu lakukan.
        </p>

        @if($inspections->isEmpty())

            <div class="kosong">
                <div class="kosong-icon">📋</div>

                <strong>Belum Ada Riwayat Pemeriksaan</strong>

                <p>
                    Kamu belum melakukan pemeriksaan APD.
                    Klik tombol di bawah untuk memulai.
                </p>

                <a href="{{ route('pekerja.monitoring') }}"
                   class="tombol"
                   style="margin-top:15px;">
                    Mulai Pemeriksaan →
                </a>
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
                                            ✓ Lengkap
                                        </span>
                                    @elseif($inspection->status === 'tidak_lengkap')
                                        <span class="status merah">
                                            ✕ Tidak Lengkap
                                        </span>
                                    @else
                                        <span class="status" style="background:#edf2f7;color:#64748b;">
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