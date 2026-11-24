
@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan Kesehatan')
@section('page-heading', 'Riwayat Pemeriksaan Kesehatan')

@section('content')

<style>
    .history-page {
        width: 100%;
        color: #334155;
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }

    .history-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        color: #172554;
    }

    .history-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .history-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    .history-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .history-card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }

    .history-count {
        background: #eff6ff;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .history-table-wrapper {
        overflow-x: auto;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .history-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 15px 18px;
        text-align: left;
    }

    .history-table td {
        padding: 16px 18px;
        border-top: 1px solid #f1f5f9;
        font-size: 13px;
        color: #475569;
    }

    .history-table tr:hover td {
        background: #f8fafc;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .status-normal {
        background: #dcfce7;
        color: #15803d;
    }

    .status-warning {
        background: #fee2e2;
        color: #b91c1c;
    }

    .detail-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 8px;
        background: #eff6ff;
        color: #1d4ed8;
        text-decoration: none;
        font-weight: 700;
        font-size: 12px;
    }

    .detail-link:hover {
        background: #dbeafe;
    }

    .empty-history {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
    }

    .empty-history strong {
        display: block;
        color: #475569;
        margin-bottom: 6px;
    }

    .pagination-wrapper {
        padding: 18px 22px;
        border-top: 1px solid #e2e8f0;
    }
</style>

<div class="history-page">

    <div class="history-header">
        <div>
            <h2>Riwayat Pemeriksaan Kesehatan</h2>
            <p>Daftar pemeriksaan kesehatan yang telah Anda lakukan.</p>
        </div>

        <a href="{{ route('pekerja.dashboard') }}"
           class="detail-link">
            Kembali ke Dashboard
        </a>
    </div>

    <div class="history-card">

        <div class="history-card-header">
            <h3>Daftar Riwayat Pemeriksaan</h3>

            <span class="history-count">
                {{ $healthChecks->total() }} Pemeriksaan
            </span>
        </div>

        <div class="history-table-wrapper">

            <table class="history-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Nama Petugas</th>
                        <th>Unit</th>
                        <th>Tekanan Darah</th>
                        <th>Oximeter</th>
                        <th>Kesimpulan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($healthChecks as $index => $healthCheck)
                        <tr>
                            <td>
                                {{ $healthChecks->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $healthCheck->tanggal_periksa
                                    ? \Carbon\Carbon::parse($healthCheck->tanggal_periksa)->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>
                                <strong>{{ $healthCheck->nama_petugas }}</strong>
                            </td>

                            <td>{{ $healthCheck->unit ?? '-' }}</td>

                            <td>
                                {{ $healthCheck->sistolik ?? '-' }}/{{ $healthCheck->diastolik ?? '-' }}
                                mmHg
                            </td>

                            <td>
                                {{ $healthCheck->hasil_oximeter ?? '-' }}%
                            </td>

                            <td>
                                @if($healthCheck->kesimpulan === 'SIAP BEKERJA')
                                    <span class="status-badge status-normal">
                                        SIAP BEKERJA
                                    </span>
                                @else
                                    <span class="status-badge status-warning">
                                        {{ $healthCheck->kesimpulan ?? 'Belum ada kesimpulan' }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('pekerja.health-check.detail', $healthCheck->id) }}"
                                   class="detail-link">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-history">
                                    <strong>Belum Ada Riwayat Pemeriksaan</strong>
                                    Riwayat pemeriksaan kesehatan Anda akan muncul di sini.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        @if($healthChecks->hasPages())
            <div class="pagination-wrapper">
                {{ $healthChecks->links() }}
            </div>
        @endif

    </div>
</div>

@endsection
