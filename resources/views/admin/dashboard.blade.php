@extends('layouts.app')

@section('title', 'Dashboard Admin - APDMONITOR')

@push('styles')
<style>
    /* ===== DASHBOARD ADMIN ===== */

    .dashboard-admin {
        max-width: 1450px;
        margin: 0 auto;
        color: #172554;
    }

    .dashboard-admin * {
        box-sizing: border-box;
    }

    .dashboard-admin h1,
    .dashboard-admin h2,
    .dashboard-admin p {
        margin-top: 0;
    }

    .dashboard-admin .teks-redup {
        color: #718096;
        line-height: 1.7;
    }

    /* HEADER DASHBOARD */

    .dashboard-welcome {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .welcome-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .7px;
        margin-bottom: 13px;
    }

    .dashboard-welcome h1 {
        font-size: 27px;
        font-weight: 800;
        color: #142b50;
        margin-bottom: 7px;
        letter-spacing: -.6px;
    }

    .dashboard-welcome p {
        font-size: 13px;
        margin-bottom: 0;
        color: #718096;
    }

    .welcome-date {
        background: white;
        border: 1px solid #e8edf5;
        border-radius: 14px;
        padding: 13px 17px;
        color: #64748b;
        font-size: 12px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .03);
        white-space: nowrap;
    }

    /* LIVE LAPORAN */

    .live-banner {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        padding: 27px 30px;
        margin-bottom: 25px;
        border-radius: 19px;
        color: white;
        background: linear-gradient(115deg, #123c75 0%, #1761bd 55%, #3188e8 100%);
        box-shadow: 0 10px 25px rgba(37, 99, 235, .14);
    }

    .live-banner::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border: 35px solid rgba(255,255,255,.07);
        border-radius: 50%;
        right: 110px;
        top: -130px;
        pointer-events: none;
    }

    .live-banner-content {
        position: relative;
        z-index: 1;
    }

    .live-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 11px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .7px;
        margin-bottom: 12px;
    }

    .live-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #86efac;
        box-shadow: 0 0 8px #86efac;
    }

    .live-banner h2 {
        color: white;
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .live-banner p {
        color: rgba(255,255,255,.82);
        font-size: 12px;
        line-height: 1.7;
        margin-bottom: 0;
        max-width: 650px;
    }

    .live-button {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-shrink: 0;
        padding: 12px 19px;
        background: white;
        color: #1755a6;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s ease;
    }

    .live-button:hover {
        background: #eaf3ff;
        transform: translateY(-2px);
    }

    /* STATISTIK */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 24px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        background: white;
        border: 1px solid #edf1f7;
        border-radius: 17px;
        padding: 21px;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .035);
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(15, 23, 42, .07);
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 19px;
    }

    .stat-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
    }

    .stat-icon.blue {
        color: #2563eb;
        background: #eaf1ff;
    }

    .stat-icon.purple {
        color: #7c3aed;
        background: #f2ebff;
    }

    .stat-icon.green {
        color: #059669;
        background: #e5f8ef;
    }

    .stat-icon.red {
        color: #dc2626;
        background: #fff0f0;
    }

    .stat-category {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .stat-number {
        color: #172b4d;
        font-size: 34px;
        line-height: 1.1;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .stat-number.red-number {
        color: #dc2626;
    }

    .stat-description {
        color: #94a3b8;
        font-size: 11px;
        margin-bottom: 17px;
    }

    .stat-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
    }

    .stat-link:hover {
        color: #1d4ed8;
        gap: 11px;
    }

    .stat-bottom-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        font-weight: 700;
        padding: 6px 9px;
        border-radius: 7px;
    }

    .stat-bottom-label.green {
        color: #047857;
        background: #e5f8ef;
    }

    .stat-bottom-label.red {
        color: #b91c1c;
        background: #fff0f0;
    }

    /* KARTU UMUM */

    .dashboard-panel {
        background: white;
        border: 1px solid #edf1f7;
        border-radius: 17px;
        padding: 24px;
        margin-bottom: 23px;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .035);
    }

    .panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 21px;
    }

    .panel-heading h2 {
        color: #172b4d;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .panel-heading p {
        color: #94a3b8;
        font-size: 11px;
        margin-bottom: 0;
    }

    .panel-heading-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 18px;
    }

    /* RINGKASAN */

    .summary-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .summary-item {
        padding: 17px;
        border: 1px solid #edf1f7;
        background: #fafcff;
        border-radius: 13px;
    }

    .summary-item-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 13px;
    }

    .summary-item-name {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }

    .summary-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
    }

    .summary-dot.green {
        background: #10b981;
    }

    .summary-dot.red {
        background: #ef4444;
    }

    .summary-value {
        color: #172b4d;
        font-size: 18px;
        font-weight: 800;
    }

    .summary-progress {
        width: 100%;
        height: 8px;
        border-radius: 20px;
        background: #e9eef5;
        overflow: hidden;
    }

    .summary-progress-bar {
        height: 100%;
        border-radius: 20px;
        transition: width .4s ease;
    }

    .summary-progress-bar.green {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .summary-progress-bar.red {
        background: linear-gradient(90deg, #ef4444, #f87171);
    }

    .summary-percentage {
        color: #94a3b8;
        font-size: 10px;
        margin-top: 9px;
    }

    .summary-note {
        margin-top: 17px;
        padding: 12px 14px;
        border-radius: 10px;
        background: #eff6ff;
        color: #45658c;
        font-size: 11px;
        line-height: 1.7;
    }

    /* TABEL */

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        min-width: 750px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .dashboard-table thead th {
        background: #f5f8fd;
        color: #64748b;
        padding: 14px 13px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #e9eef5;
    }

    .dashboard-table thead th:first-child {
        border-radius: 9px 0 0 9px;
    }

    .dashboard-table thead th:last-child {
        border-radius: 0 9px 9px 0;
    }

    .dashboard-table tbody td {
        padding: 15px 13px;
        color: #475569;
        font-size: 11px;
        border-bottom: 1px solid #f0f3f8;
        vertical-align: middle;
    }

    .dashboard-table tbody tr:last-child td {
        border-bottom: none;
    }

    .dashboard-table tbody tr:hover {
        background: #f9fbff;
    }

    .table-number {
        color: #94a3b8;
        font-weight: 700;
    }

    .table-name {
        color: #1e293b;
        font-weight: 700;
    }

    .table-date {
        white-space: nowrap;
    }

    .table-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .table-status.green {
        background: #e5f8ef;
        color: #047857;
    }

    .table-status.red {
        background: #fff0f0;
        color: #b91c1c;
    }

    .table-video {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 12px;
        color: white;
        background: #2563eb;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s;
    }

    .table-video:hover {
        color: white;
        background: #1d4ed8;
    }

    .table-empty {
        padding: 35px 15px;
        text-align: center;
        color: #94a3b8;
        font-size: 12px;
    }

    .table-empty-icon {
        display: block;
        font-size: 30px;
        margin-bottom: 10px;
    }

    /* RESPONSIVE */

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .dashboard-welcome {
            align-items: flex-start;
            flex-direction: column;
        }

        .dashboard-welcome h1 {
            font-size: 23px;
        }

        .welcome-date {
            white-space: normal;
        }

        .live-banner {
            flex-direction: column;
            align-items: flex-start;
            padding: 22px;
        }

        .live-button {
            width: 100%;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 11px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-number {
            font-size: 27px;
        }

        .stat-icon {
            width: 37px;
            height: 37px;
            font-size: 17px;
        }

        .stat-category {
            font-size: 9px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-panel {
            padding: 17px;
        }
    }

    @media (max-width: 380px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

@php
    $totalPemeriksaan = (int) ($stats['total'] ?? 0);
    $jumlahLengkap = (int) ($stats['lengkap'] ?? 0);
    $jumlahTidakLengkap = (int) ($stats['tidak_lengkap'] ?? 0);

    $persenLengkap = $totalPemeriksaan > 0
        ? round(($jumlahLengkap / $totalPemeriksaan) * 100)
        : 0;

    $persenTidakLengkap = $totalPemeriksaan > 0
        ? round(($jumlahTidakLengkap / $totalPemeriksaan) * 100)
        : 0;
@endphp

<div class="dashboard-admin">

    {{-- HEADER DASHBOARD --}}
    <div class="dashboard-welcome">

        <div>
            <div class="welcome-label">
                <span>✦</span> ADMINISTRATOR
            </div>

            <h1>Dashboard Admin</h1>

            <p>
                Selamat datang kembali,
                <strong>{{ auth()->user()->name }}</strong>.
                Kelola dan pantau keselamatan kerja melalui APDMONITOR.
            </p>
        </div>

        <div class="welcome-date">
            <strong>📅</strong>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>

    </div>


    {{-- LIVE LAPORAN LAPANGAN --}}
    <div class="live-banner">

        <div class="live-banner-content">

            <div class="live-label">
                <span class="live-dot"></span>
                MONITORING LAPANGAN
            </div>

            <h2>Live Laporan Lapangan</h2>

            <p>
                Periksa video kedatangan pekerja di lokasi lapangan,
                lihat waktu perekaman dan pengiriman, serta kelola
                status laporan melalui halaman laporan lapangan.
            </p>

        </div>

        <a href="{{ route('admin.field-reports.index') }}"
           class="live-button">
            Lihat Laporan Lapangan
            <span>→</span>
        </a>

    </div>


    {{-- KARTU STATISTIK --}}
    <div class="stats-grid">

        {{-- JENIS APD --}}
        <div class="stat-card">

            <div class="stat-top">
                <div class="stat-icon blue">🛡️</div>
                <span class="stat-category">INVENTARIS</span>
            </div>

            <div class="stat-number">
                {{ $stats['apd_items'] ?? 0 }}
            </div>

            <div class="stat-description">
                Total jenis perlengkapan APD
            </div>

            <a href="{{ route('admin.apd-items.index') }}"
               class="stat-link">
                Kelola APD <span>→</span>
            </a>

        </div>


        {{-- DATA PEKERJA --}}
        <div class="stat-card">

            <div class="stat-top">
                <div class="stat-icon purple">👷</div>
                <span class="stat-category">PEKERJA</span>
            </div>

            <div class="stat-number">
                {{ $stats['workers'] ?? 0 }}
            </div>

            <div class="stat-description">
                Total pekerja terdaftar
            </div>

            <a href="{{ route('admin.workers.index') }}"
               class="stat-link">
                Kelola Pekerja <span>→</span>
            </a>

        </div>


        {{-- TOTAL PEMERIKSAAN --}}
        <div class="stat-card">

            <div class="stat-top">
                <div class="stat-icon green">📋</div>
                <span class="stat-category">PEMERIKSAAN</span>
            </div>

            <div class="stat-number">
                {{ $totalPemeriksaan }}
            </div>

            <div class="stat-description">
                Total seluruh pemeriksaan APD
            </div>

            <span class="stat-bottom-label green">
                ✓ Seluruh pemeriksaan
            </span>

        </div>


        {{-- TIDAK LENGKAP --}}
        <div class="stat-card">

            <div class="stat-top">
                <div class="stat-icon red">⚠️</div>
                <span class="stat-category">PERHATIAN</span>
            </div>

            <div class="stat-number red-number">
                {{ $jumlahTidakLengkap }}
            </div>

            <div class="stat-description">
                Pemeriksaan APD tidak lengkap
            </div>

            <span class="stat-bottom-label red">
                ! Perlu perhatian
            </span>

        </div>

    </div>


    {{-- RINGKASAN PEMERIKSAAN --}}
    <div class="dashboard-panel">

        <div class="panel-heading">

            <div>
                <h2>Ringkasan Pemeriksaan APD</h2>
                <p>Gambaran hasil pemeriksaan kelengkapan APD pekerja.</p>
            </div>

            <div class="panel-heading-icon">📊</div>

        </div>

        <div class="summary-grid">

            {{-- LENGKAP --}}
            <div class="summary-item">

                <div class="summary-item-top">

                    <div class="summary-item-name">
                        <span class="summary-dot green"></span>
                        APD Lengkap
                    </div>

                    <div class="summary-value">
                        {{ $jumlahLengkap }}
                    </div>

                </div>

                <div class="summary-progress">
                    <div class="summary-progress-bar green"
                         style="width: {{ $persenLengkap }}%;">
                    </div>
                </div>

                <div class="summary-percentage">
                    {{ $persenLengkap }}% dari seluruh pemeriksaan
                </div>

            </div>


            {{-- TIDAK LENGKAP --}}
            <div class="summary-item">

                <div class="summary-item-top">

                    <div class="summary-item-name">
                        <span class="summary-dot red"></span>
                        APD Tidak Lengkap
                    </div>

                    <div class="summary-value">
                        {{ $jumlahTidakLengkap }}
                    </div>

                </div>

                <div class="summary-progress">
                    <div class="summary-progress-bar red"
                         style="width: {{ $persenTidakLengkap }}%;">
                    </div>
                </div>

                <div class="summary-percentage">
                    {{ $persenTidakLengkap }}% dari seluruh pemeriksaan
                </div>

            </div>

        </div>

        <div class="summary-note">
            <strong>Informasi:</strong>
            Gunakan ringkasan ini untuk memantau kepatuhan penggunaan
            APD dan menentukan tindak lanjut terhadap pemeriksaan
            yang belum memenuhi persyaratan keselamatan kerja.
        </div>

    </div>


    {{-- RIWAYAT PEMERIKSAAN --}}
    <div class="dashboard-panel">

        <div class="panel-heading">

            <div>
                <h2>Riwayat Pemeriksaan Terbaru</h2>
                <p>Daftar aktivitas pemeriksaan APD yang telah tercatat.</p>
            </div>

            <div class="panel-heading-icon">🕒</div>

        </div>


        @if($inspections->isEmpty())

            <div class="table-empty">
                <span class="table-empty-icon">📋</span>
                <strong>Belum Ada Pemeriksaan</strong>
                <p>Data pemeriksaan APD belum tercatat dalam sistem.</p>
            </div>

        @else

            <div class="table-responsive">

                <table class="dashboard-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Waktu Pemeriksaan</th>
                            <th>Nama Pekerja</th>
                            <th>Petugas</th>
                            <th>Status</th>
                            <th>Bukti Video</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($inspections as $inspection)

                            <tr>

                                <td class="table-number">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="table-date">
                                    {{ $inspection->started_at
                                        ? $inspection->started_at->format('d/m/Y H:i')
                                        : ($inspection->created_at?->format('d/m/Y H:i') ?? '-') }}
                                </td>

                                <td class="table-name">
                                    {{ $inspection->worker?->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $inspection->user?->name ?? '-' }}
                                </td>

                                <td>

                                    @if($inspection->status === 'lengkap')

                                        <span class="table-status green">
                                            <span>●</span> Lengkap
                                        </span>

                                    @elseif($inspection->status === 'tidak_lengkap')

                                        <span class="table-status red">
                                            <span>●</span> Tidak Lengkap
                                        </span>

                                    @else

                                        <span class="table-status red">
                                            {{ ucfirst(str_replace(
                                                '_',
                                                ' ',
                                                $inspection->status ?? 'Belum diketahui'
                                            )) }}
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($inspection->evidence_path)

                                        <a href="{{ asset('storage/' . $inspection->evidence_path) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="table-video">
                                            <i class="fas fa-play-circle"></i>
                                            Lihat Video
                                        </a>

                                    @else

                                        <span class="teks-redup">
                                            Tidak tersedia
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