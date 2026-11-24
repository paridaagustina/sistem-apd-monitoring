
@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan Petugas - APDMONITOR')
@section('page-heading', 'Riwayat Pemeriksaan Petugas')

@section('content')

<style>
    .history-page {
        width: 100%;
        color: #334155;
    }

    .history-card {
        background: #fff;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        padding: 22px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(30,64,110,.035);
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 22px;
    }

    .history-header h2 {
        color: #17345c;
        font-size: 21px;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .history-header p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    .back-btn {
        display: inline-block;
        padding: 10px 15px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 9px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
    }

    .back-btn:hover {
        background: #e2e8f0;
        color: #17345c;
    }

    .worker-profile {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 20px;
        background: #f8fafc;
        border: 1px solid #edf1f7;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .worker-profile img,
    .worker-avatar {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .worker-avatar {
        display: grid;
        place-items: center;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 25px;
        font-weight: 800;
    }

    .worker-profile h3 {
        margin: 0 0 6px;
        color: #17345c;
        font-size: 17px;
        font-weight: 800;
    }

    .worker-profile p {
        margin: 3px 0;
        color: #8492a6;
        font-size: 11px;
    }

    .history-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 13px;
        margin-bottom: 20px;
    }

    .summary-box {
        background: #fff;
        border: 1px solid #e9eef5;
        border-radius: 12px;
        padding: 17px;
    }

    .summary-box small {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        margin-bottom: 7px;
    }

    .summary-box strong {
        color: #17345c;
        font-size: 23px;
        font-weight: 800;
    }

    .table-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .table-title h3 {
        color: #17345c;
        font-size: 15px;
        font-weight: 800;
        margin: 0;
    }

    .table-title span {
        color: #94a3b8;
        font-size: 11px;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .history-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .history-table th {
        background: #f7f9fc;
        color: #8492a6;
        font-size: 10px;
        font-weight: 800;
        text-align: left;
        padding: 14px;
        white-space: nowrap;
    }

    .history-table td {
        padding: 14px;
        border-bottom: 1px solid #edf1f7;
        color: #475569;
        font-size: 12px;
    }

    .history-table tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-ready {
        color: #059669;
        background: #e7f9ef;
    }

    .status-warning {
        color: #dc2626;
        background: #fff1f2;
    }

    .detail-btn {
        display: inline-block;
        padding: 8px 11px;
        border-radius: 8px;
        background: #2563eb;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .detail-btn:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .empty-data {
        text-align: center;
        padding: 35px !important;
        color: #94a3b8 !important;
    }

    .pagination {
        margin-top: 18px;
    }

    @media(max-width: 600px) {
        .history-card {
            padding: 15px;
        }

        .history-summary {
            grid-template-columns: 1fr;
        }

        .worker-profile {
            align-items: flex-start;
            padding: 14px;
        }

        .worker-profile img,
        .worker-avatar {
            width: 58px;
            height: 58px;
        }

        .worker-profile h3 {
            font-size: 14px;
        }
    }
</style>

<div class="history-page">

    {{-- HEADER --}}
    <div class="history-header">
        <div>
            <h2>Riwayat Pemeriksaan Petugas</h2>
            <p>Seluruh catatan pemeriksaan kesehatan petugas.</p>
        </div>

        <a href="{{ route('admin.health-check.index') }}"
           class="back-btn">
            ← Kembali ke Monitoring
        </a>
    </div>

    {{-- PROFIL PETUGAS --}}
    <div class="history-card">
        <div class="worker-profile">

            @if($worker->photo)
                <img
                    src="{{ asset('storage/' . $worker->photo) }}"
                    alt="Foto {{ $worker->name }}"
                >
            @else
                <div class="worker-avatar">
                    {{ strtoupper(substr($worker->name, 0, 1)) }}
                </div>
            @endif

            <div>
                <h3>{{ $worker->name }}</h3>
                <p>Kode Petugas: {{ $worker->worker_code ?? '-' }}</p>
                <p>Jabatan: {{ $worker->position ?? '-' }}</p>
                <p>Unit/Departemen: {{ $worker->department ?? '-' }}</p>
            </div>

        </div>

        {{-- RINGKASAN --}}
        <div class="history-summary">

            <div class="summary-box">
                <small>Total Pemeriksaan</small>
                <strong>{{ $healthChecks->total() }}</strong>
            </div>

            <div class="summary-box">
                <small>Siap Bekerja</small>
                <strong style="color:#059669">
                    {{ $healthChecks->getCollection()->where('kesimpulan', 'SIAP BEKERJA')->count() }}
                </strong>
            </div>

            <div class="summary-box">
                <small>Tidak Disarankan Bekerja</small>
                <strong style="color:#dc2626">
                    {{ $healthChecks->getCollection()->where('kesimpulan', '!=', 'SIAP BEKERJA')->count() }}
                </strong>
            </div>

        </div>
    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="history-card">

        <div class="table-title">
            <h3>Daftar Riwayat Pemeriksaan</h3>
            <span>
                {{ $healthChecks->total() }} data ditemukan
            </span>
        </div>

        <div class="table-wrap">
            <table class="history-table">

                <thead>
                    <tr>
                        <th>NO</th>
                        <th>TANGGAL</th>
                        <th>UNIT</th>
                        <th>PERUSAHAAN</th>
                        <th>USIA</th>
                        <th>TEKANAN DARAH</th>
                        <th>STATUS TENSI</th>
                        <th>OXIMETER</th>
                        <th>KESIMPULAN</th>
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
                                {{ $healthCheck->tanggal_periksa
                                    ? $healthCheck->tanggal_periksa->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>{{ $healthCheck->unit ?? '-' }}</td>

                            <td>{{ $healthCheck->perusahaan ?? '-' }}</td>

                            <td>{{ $healthCheck->usia ?? '-' }}</td>

                            <td>
                                {{ $healthCheck->sistolik }}/{{ $healthCheck->diastolik }} mmHg
                            </td>

                            <td>{{ $healthCheck->status_tensi ?? '-' }}</td>

                            <td>
                                {{ $healthCheck->hasil_oximeter ?? '-' }}%
                                <br>
                                <small>
                                    {{ $healthCheck->status_oximeter ?? '-' }}
                                </small>
                            </td>

                            <td>
                                @if($healthCheck->kesimpulan === 'SIAP BEKERJA')
                                    <span class="status-badge status-ready">
                                        Siap Bekerja
                                    </span>
                                @else
                                    <span class="status-badge status-warning">
                                        Tidak Disarankan
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.health-check.show', $healthCheck->id) }}"
                                    class="detail-btn"
                                >
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="empty-data">
                                Belum ada riwayat pemeriksaan untuk petugas ini.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pagination">
            {{ $healthChecks->links() }}
        </div>

    </div>

</div>

@endsection
