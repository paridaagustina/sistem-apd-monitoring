
@extends('layouts.app')

@section('title', 'Monitoring Kesehatan - APDMONITOR')
@section('page-heading', 'Monitoring Kesehatan Petugas')

@section('content')

<style>
    .health-page { width: 100%; color: #334155; }

    .health-heading {
        display:flex; justify-content:space-between; align-items:center;
        gap:15px; flex-wrap:wrap; margin-bottom:22px;
    }
    .health-heading h2 {
        font-size:23px; font-weight:800; color:#17345c; margin:0 0 6px;
    }
    .health-heading p { color:#8492a6; font-size:13px; margin:0; }
    .health-label {
        background:#eaf1ff; color:#2563eb; padding:9px 14px;
        border-radius:9px; font-size:11px; font-weight:800;
    }

    .health-stats {
        display:grid; grid-template-columns:repeat(4,minmax(0,1fr));
        gap:16px; margin-bottom:20px;
    }
    .health-stat {
        background:#fff; border:1px solid #e9eef5; border-radius:15px;
        padding:20px; box-shadow:0 4px 15px rgba(30,64,110,.035);
    }
    .stat-top {
        display:flex; justify-content:space-between; align-items:center;
        gap:8px; margin-bottom:14px;
    }
    .stat-top small { color:#8492a6; font-size:11px; font-weight:700; }
    .stat-icon {
        width:40px; height:40px; border-radius:11px;
        display:grid; place-items:center; font-size:19px;
    }
    .health-stat h3 {
        margin:0; color:#17345c; font-size:27px; font-weight:800;
    }
    .blue-bg { background:#eaf1ff; color:#2563eb; }
    .green-bg { background:#e7f9ef; color:#059669; }
    .orange-bg { background:#fff4e5; color:#d97706; }
    .purple-bg { background:#f2eaff; color:#7c3aed; }

    .health-panel {
        background:#fff; border:1px solid #e9eef5; border-radius:15px;
        padding:22px; margin-bottom:20px;
        box-shadow:0 4px 15px rgba(30,64,110,.035);
        min-width:0;
    }
    .panel-heading {
        display:flex; justify-content:space-between; align-items:center;
        gap:12px; flex-wrap:wrap; margin-bottom:19px;
    }
    .panel-heading h3 {
        color:#17345c; font-size:15px; font-weight:800; margin:0;
    }
    .panel-heading span { color:#94a3b8; font-size:11px; }

    .two-column {
        display:grid; grid-template-columns:repeat(2,minmax(0,1fr));
        gap:18px;
        align-items:stretch;
    }

    .progress-item { margin-bottom:17px; }
    .progress-info {
        display:flex; justify-content:space-between; gap:10px;
        font-size:12px; font-weight:700; margin-bottom:8px;
    }
    .progress-track {
        height:11px; background:#edf1f7; border-radius:20px; overflow:hidden;
    }
    .progress-fill { height:100%; border-radius:20px; }
    .progress-green { background:#10b981; }
    .progress-orange { background:#f59e0b; }

    /*
    |--------------------------------------------------------------------------
    | DIAGRAM PEMERIKSAAN HARI INI
    |--------------------------------------------------------------------------
    */

    .today-chart {
    width:100%;
    max-width:650px;
    min-height:220px;
    margin:10px auto 25px;
    padding:25px 20px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:55px;
    flex-wrap:nowrap;
    box-sizing:border-box;

    /* Geser diagram sedikit ke kanan */
    transform: translateX(100px);
}

    .donut {
        width:180px;
        height:180px;
        min-width:180px;
        border-radius:50%;
        display:grid;
        place-items:center;
        flex-shrink:0;
        background:conic-gradient(
            #10b981 0% var(--checked),
            #f59e0b var(--checked) 100%
        );
        position:relative;
    }

    .donut::before {
        content:"";
        position:absolute;
        width:125px;
        height:125px;
        border-radius:50%;
        background:white;
    }

    .donut-center {
        position:relative;
        z-index:1;
        text-align:center;
    }

    .donut-center strong {
        display:block;
        color:#17345c;
        font-size:29px;
        font-weight:800;
    }

    .donut-center small {
        color:#94a3b8;
        font-size:11px;
    }

    .chart-legend {
        display:grid;
        gap:20px;
        min-width:190px;
        flex-shrink:0;
    }

    .legend-item {
        display:flex;
        align-items:center;
        gap:12px;
    }

    .legend-dot {
        width:13px;
        height:13px;
        border-radius:50%;
        flex-shrink:0;
    }

    .legend-item small {
        display:block;
        color:#8492a6;
        font-size:12px;
        margin-bottom:4px;
    }

    .legend-item strong {
        color:#17345c;
        font-size:16px;
        font-weight:800;
    }

    .status-grid {
        display:grid; grid-template-columns:repeat(2,minmax(0,1fr));
        gap:14px; margin-top:20px;
    }
    .status-box {
        padding:15px; border-radius:11px; background:#f8fafc;
        border:1px solid #edf1f7;
    }
    .status-box small { display:block; color:#8492a6; font-size:11px; }
    .status-box strong {
        display:block; margin-top:6px; color:#17345c; font-size:22px;
    }

    .person-list { display:grid; gap:10px; }
    .person-item {
        display:flex; align-items:center; gap:12px; padding:11px;
        border:1px solid #edf1f7; border-radius:11px;
        text-decoration:none; transition:.2s; min-width:0;
    }
    .person-item:hover {
        border-color:#bfdbfe; background:#f8fbff;
    }
    .person-photo {
        width:43px; height:43px; flex-shrink:0;
        object-fit:cover; border-radius:50%;
    }
    .person-avatar {
        width:43px; height:43px; flex-shrink:0;
        border-radius:50%; background:#eaf1ff; color:#2563eb;
        display:grid; place-items:center; font-size:16px; font-weight:800;
    }
    .person-info { flex:1; min-width:0; }
    .person-info strong {
        display:block; color:#17345c; font-size:12px;
        font-weight:800; overflow-wrap:anywhere;
    }
    .person-info small { color:#94a3b8; font-size:10px; }
    .rank-number {
        width:25px; height:25px; display:grid; place-items:center;
        border-radius:8px; background:#f1f5f9; color:#64748b;
        font-size:11px; font-weight:800; flex-shrink:0;
    }
    .person-count {
        background:#eaf1ff; color:#2563eb; padding:6px 9px;
        border-radius:7px; font-size:10px; font-weight:800;
        white-space:nowrap;
    }

    .unit-item {
        display:flex; justify-content:space-between; align-items:center;
        gap:10px; padding:12px 2px; border-bottom:1px solid #edf1f7;
    }
    .unit-item:last-child { border-bottom:none; }
    .unit-name { color:#17345c; font-size:12px; font-weight:800; }
    .unit-count {
        color:#2563eb; background:#eaf1ff; padding:6px 9px;
        border-radius:7px; font-size:10px; font-weight:800;
        white-space:nowrap;
    }

    /*
       DAFTAR NAMA PETUGAS DAN UNIT
    */
    .name-list {
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(135px, 1fr));
        gap:9px;
        align-items:stretch;
    }

    .name-chip {
        display:flex;
        align-items:center;
        justify-content:center;
        width:100%;
        min-width:0;
        min-height:38px;
        padding:9px 10px;
        border-radius:9px;
        font-size:10px;
        line-height:1.4;
        font-weight:700;
        text-align:center;
        text-decoration:none;
        overflow-wrap:anywhere;
        word-break:normal;
        transition:all .2s ease;
    }

    .chip-green {
        background:#ecfdf5;
        color:#047857;
        border:1px solid #a7f3d0;
    }

    .chip-orange {
        background:#fff7ed;
        color:#c2410c;
        border:1px solid #fed7aa;
    }

    .name-chip:hover {
        transform:translateY(-2px);
        box-shadow:0 3px 9px rgba(30,64,110,.08);
    }

    .name-list .empty-message {
        grid-column:1 / -1;
        width:100%;
    }

    .health-table-wrap { width:100%; overflow-x:auto; }
    .health-table {
        width:100%; border-collapse:collapse; min-width:900px;
    }
    .health-table th {
        background:#f7f9fc; color:#8492a6; font-size:10px;
        font-weight:800; letter-spacing:.4px; text-align:left;
        padding:14px; white-space:nowrap;
    }
    .health-table td {
        padding:14px; border-bottom:1px solid #edf1f7;
        color:#475569; font-size:12px;
    }
    .health-table tr:last-child td { border-bottom:none; }
    .worker-link {
        color:#17345c; font-weight:800; text-decoration:none;
    }
    .worker-link:hover { color:#2563eb; text-decoration:underline; }
    .health-badge {
        display:inline-block; border-radius:7px; padding:6px 9px;
        font-size:10px; font-weight:800; white-space:nowrap;
    }
    .badge-ready { background:#e7f9ef; color:#059669; }
    .badge-warning { background:#fff1f2; color:#dc2626; }
    .detail-btn {
        display:inline-block; background:#2563eb; color:white;
        padding:8px 11px; border-radius:8px; text-decoration:none;
        font-size:10px; font-weight:700; white-space:nowrap;
    }
    .detail-btn:hover { background:#1d4ed8; color:white; }
    .empty-data {
        text-align:center; padding:30px !important; color:#94a3b8 !important;
    }
    .empty-message {
        padding:20px; text-align:center; color:#94a3b8;
        background:#f8fafc; border-radius:10px; font-size:12px;
    }
    .pagination { margin-top:18px; }

    /* FORM PENCARIAN RIWAYAT */
    .health-search {
        display:flex;
        align-items:center;
        gap:9px;
        flex-wrap:wrap;
        margin-bottom:18px;
    }
    .health-search input {
        flex:1;
        min-width:220px;
        padding:11px 13px;
        border:1px solid #e2e8f0;
        border-radius:9px;
        outline:none;
        color:#334155;
        font-size:12px;
        background:#fff;
    }
    .health-search input:focus {
        border-color:#2563eb;
        box-shadow:0 0 0 3px rgba(37,99,235,.08);
    }
    .health-search button {
        border:none;
        background:#2563eb;
        color:white;
        padding:11px 16px;
        border-radius:9px;
        font-size:12px;
        font-weight:700;
        cursor:pointer;
    }
    .health-search button:hover { background:#1d4ed8; }
    .health-search .reset-search {
        display:inline-block;
        padding:11px 14px;
        border-radius:9px;
        background:#f1f5f9;
        color:#64748b;
        text-decoration:none;
        font-size:12px;
        font-weight:700;
    }
    .health-search .reset-search:hover {
        background:#e2e8f0;
    }

    @media(max-width:1000px) {
        .health-stats { grid-template-columns:repeat(2,minmax(0,1fr)); }
    }

    @media(max-width:750px) {
        .two-column {
            grid-template-columns:1fr;
        }

        .name-list {
            grid-template-columns:repeat(auto-fit, minmax(125px, 1fr));
        }
    }

    @media(max-width:600px) {
        .health-stats { gap:10px; }
        .health-stat { padding:14px; }
        .health-stat h3 { font-size:22px; }
        .health-panel { padding:15px; }

        /* Diagram tetap berada di tengah pada layar HP */
        .today-chart {
            width:100%;
            max-width:100%;
            min-height:auto;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:22px;
            padding:20px 5px 25px;
            margin:0 auto 20px;
        }

        .donut {
            width:165px;
            height:165px;
            min-width:165px;
        }

        .donut::before {
            width:115px;
            height:115px;
        }

        .chart-legend {
            width:100%;
            max-width:280px;
            min-width:0;
            grid-template-columns:1fr 1fr;
            gap:12px;
            margin:0 auto;
        }

        .legend-item {
            align-items:flex-start;
            gap:7px;
        }

        .legend-item strong {
            font-size:12px;
        }

        .health-search input { min-width:100%; }
        .health-search button,
        .health-search .reset-search {
            flex:1;
            text-align:center;
        }
        .name-list {
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:8px;
        }
        .name-chip {
            font-size:9px;
            padding:8px 6px;
            min-height:36px;
        }
    }
</style>

<div class="health-page">

    <div class="health-heading">
        <div>
            <h2>Dashboard Pemeriksaan Kesehatan</h2>
            <p>Monitoring pemeriksaan kesehatan seluruh petugas.</p>
        </div>
        <div class="health-label">
            HEALTH CHECK · {{ now()->format('d M Y') }}
        </div>
    </div>

    {{-- STATISTIK UTAMA --}}
    <div class="health-stats">
        <div class="health-stat">
            <div class="stat-top">
                <small>Total Petugas Aktif</small>
                <div class="stat-icon blue-bg">♙</div>
            </div>
            <h3>{{ $totalPetugas }}</h3>
        </div>

        <div class="health-stat">
            <div class="stat-top">
                <small>Sudah Diperiksa Hari Ini</small>
                <div class="stat-icon green-bg">✓</div>
            </div>
            <h3>{{ $totalSudahDiperiksaHariIni }}</h3>
        </div>

        <div class="health-stat">
            <div class="stat-top">
                <small>Belum Diperiksa Hari Ini</small>
                <div class="stat-icon orange-bg">◷</div>
            </div>
            <h3>{{ $totalBelumDiperiksaHariIni }}</h3>
        </div>

        <div class="health-stat">
            <div class="stat-top">
                <small>Total Seluruh Pemeriksaan</small>
                <div class="stat-icon purple-bg">♡</div>
            </div>
            <h3>{{ $totalPemeriksaan }}</h3>
        </div>
    </div>

    {{-- DIAGRAM PEMERIKSAAN HARI INI --}}
    <div class="health-panel">
        <div class="panel-heading">
            <h3>Diagram Pemeriksaan Hari Ini</h3>
            <span>{{ now()->format('d F Y') }}</span>
        </div>

        <div class="today-chart">
            <div class="donut"
                 style="--checked: {{ $persenSudahDiperiksa }}%;">
                <div class="donut-center">
                    <strong>{{ $persenSudahDiperiksa }}%</strong>
                    <small>Sudah diperiksa</small>
                </div>
            </div>

            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-dot" style="background:#10b981"></span>
                    <div>
                        <small>Sudah diperiksa</small>
                        <strong>{{ $totalSudahDiperiksaHariIni }} petugas</strong>
                    </div>
                </div>

                <div class="legend-item">
                    <span class="legend-dot" style="background:#f59e0b"></span>
                    <div>
                        <small>Belum diperiksa</small>
                        <strong>{{ $totalBelumDiperiksaHariIni }} petugas</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="two-column">
            <div class="progress-item">
                <div class="progress-info">
                    <span style="color:#059669">Sudah diperiksa</span>
                    <span>{{ $persenSudahDiperiksa }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill progress-green"
                         style="width:{{ $persenSudahDiperiksa }}%"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-info">
                    <span style="color:#d97706">Belum diperiksa</span>
                    <span>{{ $persenBelumDiperiksa }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill progress-orange"
                         style="width:{{ $persenBelumDiperiksa }}%"></div>
                </div>
            </div>
        </div>

        <div class="status-grid">
            <div class="status-box">
                <small>Kesimpulan Siap Bekerja (seluruh riwayat)</small>
                <strong style="color:#059669">{{ $totalSiapBekerja }}</strong>
            </div>
            <div class="status-box">
                <small>Tidak Disarankan Bekerja (seluruh riwayat)</small>
                <strong style="color:#dc2626">{{ $totalTidakDisarankan }}</strong>
            </div>
        </div>
    </div>

    {{-- TOP 5 PETUGAS DAN TOP 5 UNIT --}}
    <div class="two-column">

        <div class="health-panel">
            <div class="panel-heading">
                <h3>Top 5 Petugas Paling Rutin Diperiksa</h3>
                <span>Berdasarkan seluruh riwayat</span>
            </div>

            <div class="person-list">
                @forelse($topPetugas as $index => $petugas)
                    @if($petugas->worker_id)
                        <a class="person-item"
                           href="{{ route('admin.health-check.worker-history', $petugas->worker_id) }}">
                    @else
                        <div class="person-item">
                    @endif

                        <span class="rank-number">{{ $index + 1 }}</span>

                        @if($petugas->photo)
                            <img class="person-photo"
                                 src="{{ asset('storage/' . $petugas->photo) }}"
                                 alt="Foto {{ $petugas->name }}">
                        @else
                            <div class="person-avatar">
                                {{ strtoupper(substr($petugas->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="person-info">
                            <strong>{{ $petugas->name }}</strong>
                            <small>Klik nama untuk melihat riwayat</small>
                        </div>

                        <span class="person-count">
                            {{ $petugas->total_pemeriksaan }} kali
                        </span>

                    @if($petugas->worker_id)
                        </a>
                    @else
                        </div>
                    @endif
                @empty
                    <div class="empty-message">
                        Belum ada data pemeriksaan petugas.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="health-panel">
            <div class="panel-heading">
                <h3>Top 5 Unit Paling Aktif</h3>
                <span>Berdasarkan seluruh riwayat</span>
            </div>

            @forelse($topUnit as $index => $unit)
                <div class="unit-item">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span class="rank-number">{{ $index + 1 }}</span>
                        <span class="unit-name">{{ $unit->unit }}</span>
                    </div>
                    <span class="unit-count">
                        {{ $unit->total_pemeriksaan }} pemeriksaan
                    </span>
                </div>
            @empty
                <div class="empty-message">
                    Belum ada data pemeriksaan unit.
                </div>
            @endforelse
        </div>

    </div>

    {{-- DAFTAR PETUGAS SUDAH DAN BELUM DIPERIKSA HARI INI --}}
    <div class="two-column">

        <div class="health-panel">
            <div class="panel-heading">
                <h3>Petugas Sudah Diperiksa Hari Ini</h3>
                <span>{{ $totalSudahDiperiksaHariIni }} petugas</span>
            </div>

            <div class="name-list">
                @forelse($todayExaminedWorkers as $worker)
                    <a class="name-chip chip-green"
                       href="{{ route('admin.health-check.worker-history', $worker->id) }}">
                        {{ $worker->name }}
                    </a>
                @empty
                    <div class="empty-message">
                        Belum ada petugas yang diperiksa hari ini.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="health-panel">
            <div class="panel-heading">
                <h3>Petugas Belum Diperiksa Hari Ini</h3>
                <span>{{ $totalBelumDiperiksaHariIni }} petugas</span>
            </div>

            <div class="name-list">
                @forelse($notExaminedWorkersToday as $worker)
                    <span class="name-chip chip-orange">
                        {{ $worker->name }}
                    </span>
                @empty
                    <div class="empty-message">
                        Seluruh petugas aktif sudah diperiksa hari ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- STATUS UNIT HARI INI --}}
    <div class="two-column">

        <div class="health-panel">
            <div class="panel-heading">
                <h3>Unit Sudah Melakukan Pemeriksaan</h3>
                <span>{{ $totalUnitSudahMemeriksa }} dari {{ $totalUnit }} unit</span>
            </div>

            <div class="name-list">
                @forelse($examinedUnits as $unit)
                    <span class="name-chip chip-green">{{ $unit }}</span>
                @empty
                    <div class="empty-message">
                        Belum ada unit yang melakukan pemeriksaan hari ini.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="health-panel">
            <div class="panel-heading">
                <h3>Unit Belum Melakukan Pemeriksaan</h3>
                <span>{{ $totalUnitBelumMemeriksa }} dari {{ $totalUnit }} unit</span>
            </div>

            <div class="name-list">
                @forelse($notExaminedUnits as $unit)
                    <span class="name-chip chip-orange">{{ $unit }}</span>
                @empty
                    <div class="empty-message">
                        Seluruh unit sudah melakukan pemeriksaan hari ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- RIWAYAT PEMERIKSAAN --}}
    <div class="health-panel">
        <div class="panel-heading">
            <h3>Riwayat Pemeriksaan Kesehatan</h3>
            <span>
                {{ $healthChecks->total() }} pemeriksaan ditemukan
            </span>
        </div>

        {{-- FORM PENCARIAN NAMA PETUGAS --}}
        <form method="GET"
              action="{{ route('admin.health-check.index') }}"
              class="health-search">

            <input
                type="text"
                name="search"
                value="{{ $search ?? request('search') }}"
                placeholder="Cari berdasarkan nama petugas..."
                autocomplete="off"
            >

            <button type="submit">
                Cari
            </button>

            @if(request('search'))
                <a href="{{ route('admin.health-check.index') }}"
                   class="reset-search">
                    Reset
                </a>
            @endif

        </form>

        <div class="health-table-wrap">
            <table class="health-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA PETUGAS</th>
                        <th>UNIT</th>
                        <th>PERUSAHAAN</th>
                        <th>TEKANAN DARAH</th>
                        <th>STATUS TENSI</th>
                        <th>OXIMETER</th>
                        <th>KESIMPULAN</th>
                        <th>TANGGAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($healthChecks as $healthCheck)
                        @php
                            $worker = $workers->firstWhere(
                                'name',
                                $healthCheck->nama_petugas
                            );
                        @endphp

                        <tr>
                            <td>
                                {{ $loop->iteration + ($healthChecks->currentPage() - 1) * $healthChecks->perPage() }}
                            </td>

                            <td>
                                @if($worker)
                                    <a class="worker-link"
                                       href="{{ route('admin.health-check.worker-history', $worker->id) }}">
                                        {{ $healthCheck->nama_petugas }}
                                    </a>
                                @else
                                    <strong>{{ $healthCheck->nama_petugas }}</strong>
                                @endif
                            </td>

                            <td>{{ $healthCheck->unit }}</td>
                            <td>{{ $healthCheck->perusahaan }}</td>

                            <td>
                                {{ $healthCheck->sistolik }}/{{ $healthCheck->diastolik }} mmHg
                            </td>

                            <td>{{ $healthCheck->status_tensi ?? '-' }}</td>

                            <td>
                                {{ $healthCheck->hasil_oximeter }}%
                                <br>
                                <small>{{ $healthCheck->status_oximeter }}</small>
                            </td>

                            <td>
                                @if($healthCheck->kesimpulan === 'SIAP BEKERJA')
                                    <span class="health-badge badge-ready">
                                        Siap Bekerja
                                    </span>
                                @else
                                    <span class="health-badge badge-warning">
                                        Tidak Disarankan
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $healthCheck->tanggal_periksa
                                    ? $healthCheck->tanggal_periksa->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                <a href="{{ route('admin.health-check.show', $healthCheck->id) }}"
                                   class="detail-btn">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="empty-data">
                                @if(request('search'))
                                    Tidak ditemukan riwayat pemeriksaan untuk nama
                                    "{{ request('search') }}".
                                @else
                                    Belum ada data pemeriksaan kesehatan yang masuk.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $healthChecks->links() }}
        </div>
    </div>

</div>

@endsection
