
@extends('layouts.app')

@section('title', 'Detail Pemeriksaan Kesehatan - APDMONITOR')
@section('page-heading', 'Detail Pemeriksaan Kesehatan')

@section('content')

<style>
    .detail-page { width: 100%; }

    .detail-heading {
        margin-bottom: 22px;
    }

    .detail-heading h2 {
        color: #17345c;
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 7px;
    }

    .detail-heading p {
        color: #8492a6;
        font-size: 13px;
        margin: 0;
    }

    .detail-panel {
        background: #fff;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        padding: 23px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(30, 64, 110, .035);
    }

    .detail-panel h3 {
        color: #17345c;
        font-size: 16px;
        font-weight: 800;
        margin: 0 0 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .detail-item small {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .detail-item strong {
        color: #17345c;
        font-size: 13px;
        font-weight: 800;
    }

    .result-box {
        padding: 18px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #edf1f7;
        margin-bottom: 12px;
    }

    .result-box small {
        display: block;
        color: #8492a6;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .result-box strong {
        color: #17345c;
        font-size: 18px;
        font-weight: 800;
    }

    .result-normal { color: #059669 !important; }
    .result-abnormal { color: #dc2626 !important; }

    .conclusion {
        padding: 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 800;
        text-align: center;
    }

    .conclusion-ready {
        background: #e7f9ef;
        color: #059669;
    }

    .conclusion-warning {
        background: #fff1f2;
        color: #dc2626;
    }

    .back-btn {
        display: inline-block;
        background: #64748b;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .back-btn:hover {
        background: #475569;
        color: white;
    }

    @media(max-width: 600px) {
        .detail-panel { padding: 16px; }
        .detail-grid { grid-template-columns: 1fr; gap: 17px; }
    }
</style>

<div class="detail-page">

    <a href="{{ route('admin.health-check.index') }}" class="back-btn">
        ← Kembali ke Dashboard
    </a>

    <div class="detail-heading">
        <h2>Detail Hasil Pemeriksaan</h2>
        <p>Informasi lengkap hasil pemeriksaan kesehatan petugas.</p>
    </div>

    {{-- IDENTITAS PETUGAS --}}
    <div class="detail-panel">

        <h3>Informasi Petugas</h3>

        <div class="detail-grid">

            <div class="detail-item">
                <small>Nama Petugas</small>
                <strong>{{ $healthCheck->nama_petugas }}</strong>
            </div>

            <div class="detail-item">
                <small>Unit</small>
                <strong>{{ $healthCheck->unit }}</strong>
            </div>

            <div class="detail-item">
                <small>Perusahaan</small>
                <strong>{{ $healthCheck->perusahaan }}</strong>
            </div>

            <div class="detail-item">
                <small>Kelompok Usia</small>
                <strong>{{ $healthCheck->usia }}</strong>
            </div>

            <div class="detail-item">
                <small>Tanggal Pemeriksaan</small>
                <strong>
                    {{ $healthCheck->tanggal_periksa
                        ? $healthCheck->tanggal_periksa->format('d F Y')
                        : '-' }}
                </strong>
            </div>

        </div>

    </div>

    {{-- HASIL TEKANAN DARAH --}}
    <div class="detail-panel">

        <h3>Hasil Pemeriksaan Tekanan Darah</h3>

        <div class="detail-grid">

            <div class="result-box">
                <small>Tekanan Sistolik</small>
                <strong>{{ $healthCheck->sistolik }} mmHg</strong>
                <div style="margin-top:8px;font-size:11px;color:#8492a6;">
                    Status:
                    <strong class="{{ $healthCheck->status_sistolik === 'Normal' ? 'result-normal' : 'result-abnormal' }}"
                            style="font-size:12px;">
                        {{ $healthCheck->status_sistolik }}
                    </strong>
                </div>
            </div>

            <div class="result-box">
                <small>Tekanan Diastolik</small>
                <strong>{{ $healthCheck->diastolik }} mmHg</strong>
                <div style="margin-top:8px;font-size:11px;color:#8492a6;">
                    Status:
                    <strong class="{{ $healthCheck->status_diastolik === 'Normal' ? 'result-normal' : 'result-abnormal' }}"
                            style="font-size:12px;">
                        {{ $healthCheck->status_diastolik }}
                    </strong>
                </div>
            </div>

        </div>

        <div class="result-box">
            <small>Keseluruhan Status Tekanan Darah</small>
            <strong class="{{ $healthCheck->status_tensi === 'Normal' ? 'result-normal' : 'result-abnormal' }}">
                {{ $healthCheck->status_tensi }}
            </strong>
        </div>

    </div>

    {{-- HASIL OXIMETER --}}
    <div class="detail-panel">

        <h3>Hasil Pemeriksaan Oximeter</h3>

        <div class="result-box">
            <small>Hasil Oximeter</small>
            <strong>{{ $healthCheck->hasil_oximeter }}%</strong>

            <div style="margin-top:8px;font-size:11px;color:#8492a6;">
                Status:
                <strong class="{{ $healthCheck->status_oximeter === 'Normal' ? 'result-normal' : 'result-abnormal' }}"
                        style="font-size:12px;">
                    {{ $healthCheck->status_oximeter }}
                </strong>
            </div>
        </div>

    </div>

    {{-- KESIMPULAN --}}
    <div class="detail-panel">

        <h3>Kesimpulan Pemeriksaan</h3>

        <div class="conclusion {{ $healthCheck->kesimpulan === 'SIAP BEKERJA'
            ? 'conclusion-ready'
            : 'conclusion-warning' }}">
            {{ $healthCheck->kesimpulan }}
        </div>

    </div>

</div>

@endsection
