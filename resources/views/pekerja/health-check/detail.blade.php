
@extends('layouts.app')

@section('title', 'Detail Pemeriksaan Kesehatan')
@section('page-heading', 'Detail Pemeriksaan Kesehatan')

@section('content')

<style>
    .detail-page {
        width: 100%;
        color: #334155;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }

    .detail-header h2 {
        margin: 0;
        color: #172554;
        font-size: 22px;
        font-weight: 800;
    }

    .detail-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 10px 15px;
        border-radius: 9px;
        background: #eff6ff;
        color: #1d4ed8;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
    }

    .back-button:hover {
        background: #dbeafe;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    .detail-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .detail-card-header h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
        color: #1e293b;
    }

    .detail-card-body {
        padding: 22px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .detail-item label {
        display: block;
        margin-bottom: 6px;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .detail-item p {
        margin: 0;
        color: #334155;
        font-size: 14px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .result-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .result-box {
        padding: 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .result-box label {
        display: block;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 9px;
    }

    .result-box strong {
        display: block;
        font-size: 19px;
        color: #1e293b;
        margin-bottom: 8px;
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

    .conclusion {
        padding: 22px;
        border-radius: 13px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        text-align: center;
    }

    .conclusion.warning {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .conclusion h3 {
        margin: 0 0 8px;
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
    }

    .conclusion strong {
        font-size: 23px;
        font-weight: 900;
        color: #15803d;
    }

    .conclusion.warning strong {
        color: #b91c1c;
    }

    @media(max-width: 700px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .result-grid {
            grid-template-columns: 1fr;
        }

        .detail-card-body {
            padding: 16px;
        }
    }
</style>

@php
    $siapBekerja = $healthCheck->kesimpulan === 'SIAP BEKERJA';
@endphp

<div class="detail-page">

    <div class="detail-header">
        <div>
            <h2>Detail Pemeriksaan Kesehatan</h2>
            <p>Informasi lengkap hasil pemeriksaan kesehatan Anda.</p>
        </div>

        <a href="{{ route('pekerja.health-check.history') }}"
           class="back-button">
            Kembali ke Riwayat
        </a>
    </div>

    {{-- INFORMASI PETUGAS --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <h3>Informasi Petugas</h3>
        </div>

        <div class="detail-card-body">
            <div class="detail-grid">

                <div class="detail-item">
                    <label>Nama Petugas</label>
                    <p>{{ $healthCheck->nama_petugas }}</p>
                </div>

                <div class="detail-item">
                    <label>Unit Kerja</label>
                    <p>{{ $healthCheck->unit ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Tanggal Pemeriksaan</label>
                    <p>
                        {{ $healthCheck->tanggal_periksa
                            ? \Carbon\Carbon::parse($healthCheck->tanggal_periksa)->format('d F Y')
                            : '-' }}
                    </p>
                </div>

                <div class="detail-item">
                    <label>Kategori Usia</label>
                    <p>{{ $healthCheck->usia ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Perusahaan</label>
                    <p>{{ $healthCheck->perusahaan ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <label>Waktu Input</label>
                    <p>
                        {{ $healthCheck->created_at
                            ? $healthCheck->created_at->format('d/m/Y H:i')
                            : '-' }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- HASIL PEMERIKSAAN --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <h3>Hasil Pemeriksaan Kesehatan</h3>
        </div>

        <div class="detail-card-body">
            <div class="result-grid">

                <div class="result-box">
                    <label>Tekanan Sistolik</label>
                    <strong>{{ $healthCheck->sistolik ?? '-' }} mmHg</strong>

                    <span class="status-badge {{ $healthCheck->status_sistolik === 'Normal' ? 'status-normal' : 'status-warning' }}">
                        {{ $healthCheck->status_sistolik ?? '-' }}
                    </span>
                </div>

                <div class="result-box">
                    <label>Tekanan Diastolik</label>
                    <strong>{{ $healthCheck->diastolik ?? '-' }} mmHg</strong>

                    <span class="status-badge {{ $healthCheck->status_diastolik === 'Normal' ? 'status-normal' : 'status-warning' }}">
                        {{ $healthCheck->status_diastolik ?? '-' }}
                    </span>
                </div>

                <div class="result-box">
                    <label>Tekanan Darah</label>
                    <strong>{{ $healthCheck->sistolik ?? '-' }}/{{ $healthCheck->diastolik ?? '-' }}</strong>

                    <span class="status-badge {{ $healthCheck->status_tensi === 'Normal' ? 'status-normal' : 'status-warning' }}">
                        {{ $healthCheck->status_tensi ?? '-' }}
                    </span>
                </div>

                <div class="result-box">
                    <label>Hasil Oximeter</label>
                    <strong>{{ $healthCheck->hasil_oximeter ?? '-' }}%</strong>

                    <span class="status-badge {{ $healthCheck->status_oximeter === 'Normal' ? 'status-normal' : 'status-warning' }}">
                        {{ $healthCheck->status_oximeter ?? '-' }}
                    </span>
                </div>

            </div>
        </div>
    </div>

    {{-- KESIMPULAN --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <h3>Kesimpulan Pemeriksaan</h3>
        </div>

        <div class="detail-card-body">
            <div class="conclusion {{ $siapBekerja ? '' : 'warning' }}">
                <h3>Rekomendasi Hasil Pemeriksaan</h3>

                <strong>
                    {{ $healthCheck->kesimpulan ?? 'Belum ada kesimpulan' }}
                </strong>
            </div>
        </div>
    </div>

</div>

@endsection
