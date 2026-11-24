
@extends('layouts.app')

@section('title', 'Dashboard CCV - APDMONITOR')
@section('page-heading', 'CCV Monitoring')

@section('content')

<style>
    .ccv-page {
        width: 100%;
    }

    .ccv-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .ccv-heading h2 {
        font-size: 23px;
        font-weight: 800;
        color: #17345c;
        margin: 0 0 7px;
    }

    .ccv-heading p {
        color: #8492a6;
        font-size: 13px;
        margin: 0;
    }

    .ccv-label {
        padding: 9px 15px;
        border-radius: 10px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
    }

    /* STATISTIK */
    .ccv-stats {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 23px;
    }

    .ccv-stat {
        background: #fff;
        padding: 21px;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(30, 64, 110, .035);
        min-width: 0;
    }

    .ccv-stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 17px;
    }

    .ccv-stat-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 12px;
        font-size: 20px;
    }

    .ccv-stat small {
        display: block;
        color: #8997aa;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.5;
    }

    .ccv-stat h3 {
        margin: 7px 0 0;
        color: #17345c;
        font-size: 27px;
        font-weight: 800;
    }

    .blue-bg { background: #eaf1ff; color: #2563eb; }
    .green-bg { background: #e7f9ef; color: #059669; }
    .orange-bg { background: #fff4e5; color: #d97706; }
    .purple-bg { background: #f2eaff; color: #7c3aed; }
    .teal-bg { background: #e0f7f5; color: #0f9488; }

    /* PANEL */
    .ccv-panel {
        background: #fff;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        padding: 23px;
        margin-bottom: 22px;
        box-shadow: 0 4px 15px rgba(30, 64, 110, .035);
    }

    .ccv-panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .ccv-panel-heading h3 {
        color: #17345c;
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }

    .ccv-panel-heading span {
        font-size: 11px;
        color: #94a3b8;
    }

    /* RINGKASAN JAWABAN */
    .answer-summary {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .answer-info {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .answer-bar {
        width: 100%;
        height: 10px;
        background: #edf1f7;
        border-radius: 20px;
        overflow: hidden;
    }

    .answer-fill {
        height: 100%;
        border-radius: 20px;
        transition: width .3s ease;
    }

    .answer-yes { background: #10b981; }
    .answer-no { background: #ef4444; }

    /* TABEL */
    .ccv-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .ccv-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .ccv-table th {
        background: #f7f9fc;
        color: #8492a6;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .5px;
        text-align: left;
        padding: 14px;
        white-space: nowrap;
    }

    .ccv-table td {
        padding: 16px 14px;
        border-bottom: 1px solid #edf1f7;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .ccv-table tr:last-child td {
        border-bottom: none;
    }

    .worker-name {
        color: #17345c;
        font-weight: 800;
    }

    .risk-badge {
        display: inline-block;
        border-radius: 7px;
        padding: 6px 10px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .risk-rc1 {
        background: #eaf1ff;
        color: #2563eb;
    }

    .risk-rc3 {
        background: #e0f7f5;
        color: #0f9488;
    }

    .risk-other {
        background: #f1f5f9;
        color: #64748b;
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
        transition: .2s ease;
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

    .pagination {
        margin-top: 18px;
    }

    /* RESPONSIVE */
    @media(max-width: 1200px) {
        .ccv-stats {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media(max-width: 850px) {
        .ccv-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 600px) {
        .ccv-heading h2 {
            font-size: 20px;
        }

        .ccv-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .ccv-stat {
            padding: 15px;
        }

        .ccv-stat h3 {
            font-size: 22px;
        }

        .ccv-stat-icon {
            width: 35px;
            height: 35px;
            font-size: 17px;
        }

        .ccv-panel {
            padding: 15px;
        }

        .answer-summary {
            grid-template-columns: 1fr;
            gap: 18px;
        }
    }

    @media(max-width: 360px) {
        .ccv-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $totalJawaban = $totalYa + $totalTidak;

    $persenYa = $totalJawaban > 0
        ? round(($totalYa / $totalJawaban) * 100)
        : 0;

    $persenTidak = $totalJawaban > 0
        ? round(($totalTidak / $totalJawaban) * 100)
        : 0;
@endphp

<div class="ccv-page">

    {{-- HEADER --}}
    <div class="ccv-heading">
        <div>
            <h2>Dashboard Critical Control Verification</h2>
            <p>Ringkasan hasil verifikasi pengendalian risiko pekerjaan.</p>
        </div>

        <div class="ccv-label">RC1 & RC3 · MONITORING</div>
    </div>

    {{-- STATISTIK --}}
    <div class="ccv-stats">

        <div class="ccv-stat">
            <div class="ccv-stat-top">
                <small>Total Laporan CCV</small>
                <div class="ccv-stat-icon blue-bg">▤</div>
            </div>
            <h3>{{ $totalObservations }}</h3>
        </div>

        <div class="ccv-stat">
            <div class="ccv-stat-top">
                <small>Laporan Hari Ini</small>
                <div class="ccv-stat-icon green-bg">▣</div>
            </div>
            <h3>{{ $totalToday }}</h3>
        </div>

        <div class="ccv-stat">
            <div class="ccv-stat-top">
                <small>Laporan Risiko RC1</small>
                <div class="ccv-stat-icon orange-bg">⚠</div>
            </div>
            <h3>{{ $totalRC1 }}</h3>
        </div>

        <div class="ccv-stat">
            <div class="ccv-stat-top">
                <small>Laporan Risiko RC3</small>
                <div class="ccv-stat-icon teal-bg">⚡</div>
            </div>
            <h3>{{ $totalRC3 }}</h3>
        </div>

        <div class="ccv-stat">
            <div class="ccv-stat-top">
                <small>Total Jawaban</small>
                <div class="ccv-stat-icon purple-bg">✓</div>
            </div>
            <h3>{{ $totalJawaban }}</h3>
        </div>

    </div>

    {{-- RINGKASAN JAWABAN --}}
    <div class="ccv-panel">

        <div class="ccv-panel-heading">
            <h3>Ringkasan Hasil Verifikasi</h3>
            <span>Seluruh laporan CCV</span>
        </div>

        <div class="answer-summary">

            <div>
                <div class="answer-info">
                    <span style="color:#059669">Jawaban Ya</span>
                    <span>{{ $totalYa }} ({{ $persenYa }}%)</span>
                </div>

                <div class="answer-bar">
                    <div class="answer-fill answer-yes"
                         style="width: {{ $persenYa }}%">
                    </div>
                </div>
            </div>

            <div>
                <div class="answer-info">
                    <span style="color:#ef4444">Jawaban Tidak</span>
                    <span>{{ $totalTidak }} ({{ $persenTidak }}%)</span>
                </div>

                <div class="answer-bar">
                    <div class="answer-fill answer-no"
                         style="width: {{ $persenTidak }}%">
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- TABEL LAPORAN --}}
    <div class="ccv-panel">

        <div class="ccv-panel-heading">
            <h3>Data Laporan CCV</h3>
            <span>{{ $observations->total() }} laporan terdaftar</span>
        </div>

        <div class="ccv-table-wrap">
            <table class="ccv-table">

                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA PENGAMAT</th>
                        <th>PERUSAHAAN</th>
                        <th>LOKASI PEKERJAAN</th>
                        <th>RISIKO</th>
                        <th>TANGGAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($observations as $observation)
                        @php
                            $riskCode = strtoupper($observation->risk_code ?? '');
                        @endphp

                        <tr>
                            <td>
                                {{ $loop->iteration + ($observations->currentPage() - 1) * $observations->perPage() }}
                            </td>

                            <td>
                                <span class="worker-name">
                                    {{ $observation->observer_name }}
                                </span>
                            </td>

                            <td>{{ $observation->company }}</td>

                            <td>{{ $observation->work_location }}</td>

                            <td>
                                <span class="risk-badge
                                    {{ $riskCode === 'RC1' ? 'risk-rc1' : ($riskCode === 'RC3' ? 'risk-rc3' : 'risk-other') }}">
                                    {{ $riskCode ?: '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $observation->submitted_at
                                    ? $observation->submitted_at->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td>
                                <a href="{{ route('admin.ccv.show', $observation->id) }}"
                                   class="detail-btn">
                                    Lihat Detail →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-data">
                                Belum ada laporan CCV yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="pagination">
            {{ $observations->links() }}
        </div>

    </div>

</div>

@endsection
