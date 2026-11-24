
@extends('layouts.app')

@section('title', 'Dashboard Pekerja - APDMONITOR')
@section('page-heading', 'Dashboard Pekerja')

@push('styles')
<style>
    .dashboard-pekerja {
        width: 100%;
        color: #334155;
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

    /* STATISTICS APD */
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

    .stat-blue .stat-number { color: #2563eb; }
    .stat-green .stat-number { color: #07966e; }
    .stat-red .stat-number { color: #7950df; }

    /* MONITORING APD */
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

    /* JUDUL TABEL */
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

    /* ==========================================
       MONITORING KESEHATAN
    ========================================== */

    .health-section {
        margin-bottom: 23px;
    }

    .health-panel {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 16px;
        padding: 23px;
        box-shadow: 0 4px 15px rgba(30,64,110,.035);
        min-width: 0;
    }

    .health-panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .health-panel-heading h2 {
        color: #17345c;
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }

    .health-panel-heading span {
        color: #94a3b8;
        font-size: 11px;
    }

    .health-overview {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 18px;
        margin-bottom: 18px;
    }

    /* DIAGRAM DONAT */
    .health-chart-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
        padding: 12px 0;
    }

    .health-donut {
        width: 190px;
        height: 190px;
        flex-shrink: 0;
        border-radius: 50%;
        display: grid;
        place-items: center;
        position: relative;
        background: conic-gradient(
            #16a36a 0% {{ $persenSudahDiperiksa }}%,
            #f59e0b {{ $persenSudahDiperiksa }}% 100%
        );
    }

    .health-donut::before {
        content: "";
        position: absolute;
        width: 125px;
        height: 125px;
        border-radius: 50%;
        background: white;
    }

    .health-donut-center {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .health-donut-center strong {
        display: block;
        font-size: 29px;
        font-weight: 800;
        color: #17345c;
    }

    .health-donut-center small {
        display: block;
        font-size: 10px;
        color: #94a3b8;
        margin-top: 3px;
    }

    .health-legend {
        display: grid;
        gap: 17px;
        min-width: 155px;
    }

    .health-legend-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .health-legend-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        margin-top: 4px;
        flex-shrink: 0;
    }

    .health-legend-item small {
        display: block;
        color: #8492a6;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .health-legend-item strong {
        display: block;
        color: #17345c;
        font-size: 17px;
        font-weight: 800;
    }

    .health-total-info {
        border-top: 1px solid #edf1f7;
        padding-top: 14px;
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        color: #8492a6;
    }

    .health-total-info strong {
        color: #17345c;
    }

    /* KARTU DAFTAR NAMA */
    .health-list-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 18px;
    }

    .health-name-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        gap: 9px;
    }

    .health-name-card {
        min-width: 0;
        min-height: 43px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 11px;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .health-name-card.green {
        color: #047857;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
    }

    .health-name-card.orange {
        color: #c2410c;
        background: #fff7ed;
        border: 1px solid #fed7aa;
    }

    .health-name-card .name-indicator {
        width: 7px;
        height: 7px;
        flex-shrink: 0;
        border-radius: 50%;
        background: currentColor;
    }

    .health-empty {
        width: 100%;
        padding: 18px;
        border-radius: 10px;
        background: #f8fafc;
        color: #94a3b8;
        font-size: 12px;
        text-align: center;
        grid-column: 1 / -1;
    }

    /* UNIT */
    .health-unit-list {
        display: grid;
        gap: 10px;
    }

    .health-unit-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8fafc;
        border: 1px solid #edf1f7;
        border-radius: 10px;
    }

    .health-unit-name {
        color: #17345c;
        font-size: 11px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .health-unit-status {
        padding: 5px 9px;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .health-unit-status.done {
        color: #047857;
        background: #d1fae5;
    }

    .health-unit-status.pending {
        color: #c2410c;
        background: #ffedd5;
    }

    /* TOP 5 */
    .health-ranking-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 23px;
    }

    .health-ranking-list {
        display: grid;
        gap: 10px;
    }

    .health-ranking-item {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 11px;
        border: 1px solid #edf1f7;
        border-radius: 11px;
        min-width: 0;
    }

    .health-rank {
        width: 27px;
        height: 27px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 11px;
        font-weight: 800;
    }

    .health-person-photo,
    .health-person-avatar {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border-radius: 50%;
        object-fit: cover;
    }

    .health-person-avatar {
        display: grid;
        place-items: center;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 15px;
        font-weight: 800;
    }

    .health-person-info {
        flex: 1;
        min-width: 0;
    }

    .health-person-info strong {
        display: block;
        color: #17345c;
        font-size: 11px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .health-person-info small {
        display: block;
        color: #94a3b8;
        font-size: 10px;
        margin-top: 4px;
    }

    .health-count {
        flex-shrink: 0;
        padding: 6px 8px;
        border-radius: 7px;
        color: #2563eb;
        background: #eaf1ff;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .health-ranking-unit {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 10px;
        border-bottom: 1px solid #edf1f7;
    }

    .health-ranking-unit:last-child {
        border-bottom: none;
    }

    .health-ranking-unit-name {
        flex: 1;
        min-width: 0;
        color: #17345c;
        font-size: 11px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    /* TABEL APD */
    .pembungkus-tabel {
        width: 100%;
        overflow-x: auto;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 700;
    }

    .status.hijau {
        background: #e7f9ef;
        color: #059669;
    }

    .status.merah {
        background: #fff1f2;
        color: #dc2626;
    }

    @media(max-width: 950px) {
        .statistik-pekerja {
            grid-template-columns: 1fr;
        }

        .stat-card {
            min-height: 115px;
        }
    }

    @media(max-width: 700px) {
        .health-overview,
        .health-list-grid,
        .health-ranking-grid {
            grid-template-columns: 1fr;
        }

        .health-panel {
            padding: 17px;
        }

        .health-chart-content {
            gap: 20px;
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

        .health-name-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .health-donut {
            width: 160px;
            height: 160px;
        }

        .health-donut::before {
            width: 105px;
            height: 105px;
        }

        .health-donut-center strong {
            font-size: 24px;
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


    {{-- STATISTIK APD --}}
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


    {{-- MONITORING APD --}}
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


    {{-- ==========================================
         MONITORING KESEHATAN PETUGAS
    =========================================== --}}

    <div class="health-section">

        {{-- DIAGRAM DAN RINGKASAN --}}
        <div class="health-panel" style="margin-bottom:18px;">

            <div class="health-panel-heading">
                <div>
                    <h2>Monitoring Pemeriksaan Kesehatan</h2>
                    <p class="section-description" style="margin-top:6px;">
                        Rekap pemeriksaan kesehatan seluruh petugas aktif.
                    </p>
                </div>

                <span>
                    {{ now()->format('d F Y') }}
                </span>
            </div>

            {{-- DIAGRAM DONAT --}}
            <div class="health-overview">

                <div class="health-chart-content">

                    <div class="health-donut">
                        <div class="health-donut-center">
                            <strong>{{ $persenSudahDiperiksa }}%</strong>
                            <small>Sudah diperiksa</small>
                        </div>
                    </div>

                    <div class="health-legend">

                        <div class="health-legend-item">
                            <span class="health-legend-dot"
                                  style="background:#16a36a;"></span>

                            <div>
                                <small>Sudah diperiksa</small>
                                <strong>
                                    {{ $totalSudahDiperiksaHariIni }} petugas
                                </strong>
                                <small>{{ $persenSudahDiperiksa }}%</small>
                            </div>
                        </div>

                        <div class="health-legend-item">
                            <span class="health-legend-dot"
                                  style="background:#f59e0b;"></span>

                            <div>
                                <small>Belum diperiksa</small>
                                <strong>
                                    {{ $totalBelumDiperiksaHariIni }} petugas
                                </strong>
                                <small>{{ $persenBelumDiperiksa }}%</small>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="health-panel" style="background:#f8fafc;box-shadow:none;">

                    <div class="health-panel-heading">
                        <h2>Ringkasan Pemeriksaan</h2>
                    </div>

                    <div class="health-unit-list">

                        <div class="health-unit-item">
                            <span class="health-unit-name">
                                Total Petugas Aktif
                            </span>
                            <strong>{{ $totalPetugas }}</strong>
                        </div>

                        <div class="health-unit-item">
                            <span class="health-unit-name">
                                Total Pemeriksaan Hari Ini
                            </span>
                            <strong>{{ $totalPemeriksaanHariIni }}</strong>
                        </div>

                        <div class="health-unit-item">
                            <span class="health-unit-name">
                                Total Seluruh Riwayat
                            </span>
                            <strong>{{ $totalPemeriksaanKesehatan }}</strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOP 5 LANGSUNG DI BAWAH DIAGRAM --}}
        <div class="health-ranking-grid">

            {{-- TOP 5 PETUGAS --}}
            <div class="health-panel">

                <div class="health-panel-heading">
                    <h2>Top 5 Petugas Paling Rutin Diperiksa</h2>
                    <span>Seluruh riwayat</span>
                </div>

                <div class="health-ranking-list">

                    @forelse($topPetugas as $index => $petugas)

                        <div class="health-ranking-item">

                            <span class="health-rank">
                                {{ $index + 1 }}
                            </span>

                            @if($petugas->photo)
                                <img
                                    src="{{ asset('storage/' . $petugas->photo) }}"
                                    alt="Foto {{ $petugas->name }}"
                                    class="health-person-photo"
                                >
                            @else
                                <div class="health-person-avatar">
                                    {{ strtoupper(substr($petugas->name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="health-person-info">
                                <strong>{{ $petugas->name }}</strong>
                                <small>Jumlah pemeriksaan kesehatan</small>
                            </div>

                            <span class="health-count">
                                {{ $petugas->total_pemeriksaan }} kali
                            </span>

                        </div>

                    @empty
                        <div class="health-empty">
                            Belum ada data pemeriksaan petugas.
                        </div>
                    @endforelse

                </div>

            </div>


            {{-- TOP 5 UNIT --}}
            <div class="health-panel">

                <div class="health-panel-heading">
                    <h2>Top 5 Unit Paling Rutin Memeriksa</h2>
                    <span>Seluruh riwayat</span>
                </div>

                @forelse($topUnit as $index => $unit)

                    <div class="health-ranking-unit">

                        <span class="health-rank">
                            {{ $index + 1 }}
                        </span>

                        <span class="health-ranking-unit-name">
                            {{ $unit->unit }}
                        </span>

                        <span class="health-count">
                            {{ $unit->total_pemeriksaan }} kali
                        </span>

                    </div>

                @empty
                    <div class="health-empty">
                        Belum ada data pemeriksaan unit.
                    </div>
                @endforelse

            </div>

        </div>


        {{-- DAFTAR SUDAH DAN BELUM DIPERIKSA --}}
        <div class="health-list-grid">

            {{-- SUDAH DIPERIKSA --}}
            <div class="health-panel">

                <div class="health-panel-heading">
                    <h2>Petugas Sudah Diperiksa Hari Ini</h2>

                    <span>
                        {{ $totalSudahDiperiksaHariIni }} petugas
                    </span>
                </div>

                <div class="health-name-grid">

                    @forelse($todayExaminedWorkers as $worker)
                        <div class="health-name-card green">
                            <span class="name-indicator"></span>
                            {{ $worker->name }}
                        </div>
                    @empty
                        <div class="health-empty">
                            Belum ada petugas yang diperiksa hari ini.
                        </div>
                    @endforelse

                </div>

            </div>


            {{-- BELUM DIPERIKSA --}}
            <div class="health-panel">

                <div class="health-panel-heading">
                    <h2>Petugas Belum Diperiksa Hari Ini</h2>

                    <span>
                        {{ $totalBelumDiperiksaHariIni }} petugas
                    </span>
                </div>

                <div class="health-name-grid">

                    @forelse($notExaminedWorkersToday as $worker)
                        <div class="health-name-card orange">
                            <span class="name-indicator"></span>
                            {{ $worker->name }}
                        </div>
                    @empty
                        <div class="health-empty">
                            Seluruh petugas aktif sudah diperiksa hari ini.
                        </div>
                    @endforelse

                </div>

            </div>

        </div>


        {{-- STATUS UNIT --}}
        <div class="health-list-grid">

            {{-- UNIT SUDAH MEMERIKSA --}}
            <div class="health-panel">

                <div class="health-panel-heading">
                    <h2>Unit Sudah Melakukan Pemeriksaan</h2>

                    <span>
                        {{ $totalUnitSudahMemeriksa }} dari {{ $totalUnit }} unit
                    </span>
                </div>

                <div class="health-unit-list">

                    @forelse($examinedUnits as $unit)
                        <div class="health-unit-item">
                            <span class="health-unit-name">
                                {{ $unit }}
                            </span>

                            <span class="health-unit-status done">
                                Sudah memeriksa
                            </span>
                        </div>
                    @empty
                        <div class="health-empty">
                            Belum ada unit yang melakukan pemeriksaan hari ini.
                        </div>
                    @endforelse

                </div>

            </div>


            {{-- UNIT BELUM MEMERIKSA --}}
            <div class="health-panel">

                <div class="health-panel-heading">
                    <h2>Unit Belum Melakukan Pemeriksaan</h2>

                    <span>
                        {{ $totalUnitBelumMemeriksa }} dari {{ $totalUnit }} unit
                    </span>
                </div>

                <div class="health-unit-list">

                    @forelse($notExaminedUnits as $unit)
                        <div class="health-unit-item">
                            <span class="health-unit-name">
                                {{ $unit }}
                            </span>

                            <span class="health-unit-status pending">
                                Belum memeriksa
                            </span>
                        </div>
                    @empty
                        <div class="health-empty">
                            Seluruh unit sudah melakukan pemeriksaan hari ini.
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================
         RIWAYAT PEMERIKSAAN APD
    =========================================== --}}

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
                                        <span class="status"
                                              style="background:#edf2f7;color:#64748b;">
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
