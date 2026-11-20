
@extends('layouts.app')

@section('title', 'Monitoring Kesehatan - APDMONITOR')
@section('page-heading', 'Monitoring Kesehatan Petugas')

@section('content')

<style>
    .health-page { width: 100%; }

    .health-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .health-heading h2 {
        font-size: 23px;
        font-weight: 800;
        color: #17345c;
        margin: 0 0 7px;
    }

    .health-heading p {
        color: #8492a6;
        font-size: 13px;
        margin: 0;
    }

    .health-label {
        padding: 9px 15px;
        border-radius: 10px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
    }

    .health-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 23px;
    }

    .health-stat {
        background: #fff;
        padding: 21px;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(30, 64, 110, .035);
    }

    .health-stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 17px;
    }

    .health-stat-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
    }

    .health-stat small {
        display: block;
        color: #8997aa;
        font-size: 11px;
        font-weight: 700;
    }

    .health-stat h3 {
        margin: 7px 0 0;
        color: #17345c;
        font-size: 27px;
        font-weight: 800;
    }

    .blue-bg { background: #eaf1ff; color: #2563eb; }
    .green-bg { background: #e7f9ef; color: #059669; }
    .orange-bg { background: #fff4e5; color: #d97706; }
    .purple-bg { background: #f2eaff; color: #7c3aed; }

    .health-panel {
        background: #fff;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        padding: 23px;
        margin-bottom: 22px;
        box-shadow: 0 4px 15px rgba(30, 64, 110, .035);
    }

    .health-panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .health-panel-heading h3 {
        color: #17345c;
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }

    .health-panel-heading span {
        font-size: 11px;
        color: #94a3b8;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .summary-info {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .summary-bar {
        width: 100%;
        height: 11px;
        background: #edf1f7;
        border-radius: 20px;
        overflow: hidden;
    }

    .summary-fill {
        height: 100%;
        border-radius: 20px;
    }

    .summary-examined { background: #10b981; }
    .summary-unexamined { background: #f59e0b; }

    .status-summary {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 25px;
    }

    .status-box {
        padding: 17px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #edf1f7;
    }

    .status-box small {
        display: block;
        font-size: 11px;
        color: #8492a6;
        font-weight: 700;
    }

    .status-box strong {
        display: block;
        margin-top: 7px;
        font-size: 23px;
        color: #17345c;
    }

    .status-ready { color: #059669 !important; }
    .status-warning { color: #dc2626 !important; }

    .not-examined-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .not-examined-item {
        display: inline-block;
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
    }

    .health-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .health-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .health-table th {
        background: #f7f9fc;
        color: #8492a6;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .5px;
        text-align: left;
        padding: 14px;
        white-space: nowrap;
    }

    .health-table td {
        padding: 16px 14px;
        border-bottom: 1px solid #edf1f7;
        color: #475569;
        font-size: 12px;
    }

    .health-table tr:last-child td {
        border-bottom: none;
    }

    .worker-name {
        color: #17345c;
        font-weight: 800;
    }

    .health-badge {
        display: inline-block;
        border-radius: 7px;
        padding: 6px 9px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-ready {
        background: #e7f9ef;
        color: #059669;
    }

    .badge-warning {
        background: #fff1f2;
        color: #dc2626;
    }

    .detail-btn {
        display: inline-block;
        background: #2563eb;
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .detail-btn:hover {
        background: #1d4ed8;
        color: white;
    }

    .empty-data {
        text-align: center;
        padding: 35px !important;
        color: #94a3b8 !important;
    }

    .pagination { margin-top: 18px; }

    @media(max-width: 1000px) {
        .health-stats { grid-template-columns: repeat(2, 1fr); }
    }

    @media(max-width: 600px) {
        .health-stats {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .health-stat { padding: 15px; }
        .health-stat h3 { font-size: 22px; }
        .health-panel { padding: 15px; }
        .summary-grid { grid-template-columns: 1fr; gap: 18px; }
        .status-summary { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="health-page">

    <div class="health-heading">
        <div>
            <h2>Dashboard Pemeriksaan Kesehatan</h2>
            <p>Monitoring hasil pemeriksaan kesehatan seluruh petugas.</p>
        </div>

        <div class="health-label">HEALTH CHECK · MONITORING</div>
    </div>

    {{-- STATISTIK --}}
    <div class="health-stats">

        <div class="health-stat">
            <div class="health-stat-top">
                <small>Total Petugas</small>
                <div class="health-stat-icon blue-bg">♙</div>
            </div>
            <h3>{{ $totalPetugas }}</h3>
        </div>

        <div class="health-stat">
            <div class="health-stat-top">
                <small>Sudah Diperiksa</small>
                <div class="health-stat-icon green-bg">✓</div>
            </div>
            <h3>{{ $totalSudahDiperiksa }}</h3>
        </div>

        <div class="health-stat">
            <div class="health-stat-top">
                <small>Belum Diperiksa</small>
                <div class="health-stat-icon orange-bg">◷</div>
            </div>
            <h3>{{ $totalBelumDiperiksa }}</h3>
        </div>

        <div class="health-stat">
            <div class="health-stat-top">
                <small>Total Pemeriksaan</small>
                <div class="health-stat-icon purple-bg">♡</div>
            </div>
            <h3>{{ $totalPemeriksaan }}</h3>
        </div>

    </div>

    {{-- RINGKASAN PEMERIKSAAN --}}
    <div class="health-panel">

        <div class="health-panel-heading">
            <h3>Ringkasan Pemeriksaan Petugas</h3>
            <span>{{ $totalHariIni }} pemeriksaan hari ini</span>
        </div>

        <div class="summary-grid">

            <div>
                <div class="summary-info">
                    <span style="color:#059669">Sudah Diperiksa</span>
                    <span>{{ $totalSudahDiperiksa }} ({{ $persenSudahDiperiksa }}%)</span>
                </div>

                <div class="summary-bar">
                    <div class="summary-fill summary-examined"
                         style="width: {{ $persenSudahDiperiksa }}%">
                    </div>
                </div>
            </div>

            <div>
                <div class="summary-info">
                    <span style="color:#d97706">Belum Diperiksa</span>
                    <span>{{ $totalBelumDiperiksa }} ({{ $persenBelumDiperiksa }}%)</span>
                </div>

                <div class="summary-bar">
                    <div class="summary-fill summary-unexamined"
                         style="width: {{ $persenBelumDiperiksa }}%">
                    </div>
                </div>
            </div>

        </div>

        <div class="status-summary">
            <div class="status-box">
                <small>Kesimpulan Siap Bekerja</small>
                <strong class="status-ready">{{ $totalSiapBekerja }}</strong>
            </div>

            <div class="status-box">
                <small>Tidak Disarankan Bekerja</small>
                <strong class="status-warning">{{ $totalTidakDisarankan }}</strong>
            </div>
        </div>

    </div>

    {{-- DAFTAR PETUGAS BELUM DIPERIKSA --}}
    <div class="health-panel">

        <div class="health-panel-heading">
            <h3>Petugas Belum Melakukan Pemeriksaan</h3>
            <span>{{ $totalBelumDiperiksa }} petugas</span>
        </div>

        @if($notExaminedNames->isNotEmpty())
            <div class="not-examined-list">
                @foreach($notExaminedNames as $name)
                    <span class="not-examined-item">
                        {{ $name }}
                    </span>
                @endforeach
            </div>
        @else
            <div style="color:#059669;font-size:12px;font-weight:700;">
                Seluruh petugas sudah melakukan pemeriksaan.
            </div>
        @endif

    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="health-panel">

        <div class="health-panel-heading">
            <h3>Riwayat Pemeriksaan Kesehatan</h3>
            <span>{{ $healthChecks->total() }} pemeriksaan terdaftar</span>
        </div>

        <div class="health-table-wrap">
            <table class="health-table">

                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA PETUGAS</th>
                        <th>UNIT</th>
                        <th>PERUSAHAAN</th>
                        <th>TEKANAN DARAH</th>
                        <th>OXIMETER</th>
                        <th>KESIMPULAN</th>
                        <th>TANGGAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($healthChecks as $healthCheck)
                        <tr>
                            <td>
                                {{ $loop->iteration + ($healthChecks->currentPage() - 1) * $healthChecks->perPage() }}
                            </td>

                            <td>
                                <span class="worker-name">
                                    {{ $healthCheck->nama_petugas }}
                                </span>
                            </td>

                            <td>{{ $healthCheck->unit }}</td>

                            <td>{{ $healthCheck->perusahaan }}</td>

                            <td>
                                {{ $healthCheck->sistolik }}/{{ $healthCheck->diastolik }} mmHg
                            </td>

                            <td>{{ $healthCheck->hasil_oximeter }}%</td>

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
                                    Lihat Detail →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty-data">
                                Belum ada data pemeriksaan kesehatan yang masuk.
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
