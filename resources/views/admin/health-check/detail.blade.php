
@extends('layouts.app')

@section('title', 'Detail Pemeriksaan Kesehatan - APDMONITOR')
@section('page-heading', 'Detail Pemeriksaan Kesehatan')

@section('content')

<style>
    .health-detail {
        width: 100%;
        color: #334155;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 22px;
    }

    .detail-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #173b73;
        margin: 0 0 5px;
    }

    .detail-header p {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 17px;
        border-radius: 9px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-back:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e5eaf1;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    .detail-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #173b73;
        margin-bottom: 20px;
        padding-bottom: 13px;
        border-bottom: 1px solid #edf0f5;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 30px;
    }

    .detail-item {
        min-width: 0;
    }

    .detail-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 7px;
    }

    .detail-value {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        overflow-wrap: anywhere;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-normal {
        background: #dcfce7;
        color: #15803d;
    }

    .status-warning {
        background: #fef3c7;
        color: #b45309;
    }

    .status-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .conclusion-box {
        padding: 18px;
        border-radius: 11px;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        text-align: center;
    }

    .conclusion-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .conclusion-value {
        font-size: 19px;
        font-weight: 800;
        color: #15803d;
    }

    @media (max-width: 600px) {
        .detail-card {
            padding: 18px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .detail-header {
            align-items: flex-start;
        }
    }
</style>

@php
    $tanggal = $healthCheck->tanggal_periksa
        ? \Carbon\Carbon::parse($healthCheck->tanggal_periksa)->format('d/m/Y')
        : '-';

    $statusClass = function ($status) {
        $status = strtolower($status ?? '');

        if ($status === 'normal') {
            return 'status-normal';
        }

        if (str_contains($status, 'tidak normal') ||
            str_contains($status, 'tinggi') ||
            str_contains($status, 'rendah') ||
            str_contains($status, 'abnormal')) {
            return 'status-danger';
        }

        return 'status-warning';
    };
@endphp

<div class="health-detail">

    <div class="detail-header">
        <div>
            <h3>Detail Pemeriksaan Kesehatan</h3>
            <p>Informasi lengkap hasil pemeriksaan kesehatan petugas.</p>
        </div>

        <a href="{{ route('admin.health-check.index') }}" class="btn-back">
            &larr; Kembali
        </a>
    </div>

    {{-- INFORMASI PETUGAS --}}
    <div class="detail-card">
        <div class="detail-card-title">
            Informasi Petugas
        </div>

        <div class="detail-grid">

            <div class="detail-item">
                <span class="detail-label">Nama Petugas</span>
                <div class="detail-value">
                    {{ $healthCheck->nama_petugas ?? '-' }}
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">Unit</span>
                <div class="detail-value">
                    {{ $healthCheck->unit ?? '-' }}
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">Perusahaan</span>
                <div class="detail-value">
                    {{ $healthCheck->perusahaan ?? '-' }}
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">Usia</span>
                <div class="detail-value">
                    {{ $healthCheck->usia ?? '-' }}
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">Tanggal Pemeriksaan</span>
                <div class="detail-value">
                    {{ $tanggal }}
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">Petugas Penginput</span>
                <div class="detail-value">
                    {{ $healthCheck->user?->name ?? '-' }}
                </div>
            </div>

        </div>
    </div>

    {{-- HASIL PEMERIKSAAN TEKANAN DARAH --}}
    <div class="detail-card">
        <div class="detail-card-title">
            Hasil Pemeriksaan Tekanan Darah
        </div>

        <div class="detail-grid">

            <div class="detail-item">
                <span class="detail-label">Tekanan Sistolik</span>
                <div class="detail-value">
                    {{ $healthCheck->sistolik ?? '-' }} mmHg
                </div>
                <span class="status-badge {{ $statusClass($healthCheck->status_sistolik) }}">
                    {{ $healthCheck->status_sistolik ?? '-' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Tekanan Diastolik</span>
                <div class="detail-value">
                    {{ $healthCheck->diastolik ?? '-' }} mmHg
                </div>
                <span class="status-badge {{ $statusClass($healthCheck->status_diastolik) }}">
                    {{ $healthCheck->status_diastolik ?? '-' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Hasil Tekanan Darah</span>
                <div class="detail-value">
                    {{ $healthCheck->sistolik ?? '-' }}/{{ $healthCheck->diastolik ?? '-' }} mmHg
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">Status Tensi</span>
                <span class="status-badge {{ $statusClass($healthCheck->status_tensi) }}">
                    {{ $healthCheck->status_tensi ?? '-' }}
                </span>
            </div>

        </div>
    </div>

    {{-- HASIL OXIMETER --}}
    <div class="detail-card">
        <div class="detail-card-title">
            Hasil Pemeriksaan Oximeter
        </div>

        <div class="detail-grid">

            <div class="detail-item">
                <span class="detail-label">Hasil Oximeter</span>
                <div class="detail-value">
                    {{ $healthCheck->hasil_oximeter ?? '-' }}%
                </div>
            </div>

            <div class="detail-item">
                <span class="detail-label">Status Oximeter</span>
                <span class="status-badge {{ $statusClass($healthCheck->status_oximeter) }}">
                    {{ $healthCheck->status_oximeter ?? '-' }}
                </span>
            </div>

        </div>
    </div>

    {{-- KESIMPULAN --}}
    <div class="detail-card">
        <div class="detail-card-title">
            Kesimpulan Pemeriksaan
        </div>

        <div class="conclusion-box">
            <span class="conclusion-label">
                Hasil Akhir Pemeriksaan
            </span>

            <div class="conclusion-value">
                {{ $healthCheck->kesimpulan ?? '-' }}
            </div>
        </div>
    </div>

</div>

@endsection
