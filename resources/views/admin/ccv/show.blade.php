@extends('layouts.app')

@section('title', 'Detail Laporan CCV - APDMONITOR')
@section('page-heading', 'Detail Laporan CCV')

@section('content')

<style>
    .detail-header {
        margin-bottom: 22px;
    }

    .detail-header h2 {
        color: #17345c;
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .detail-header p {
        color: #8492a6;
        font-size: 12px;
    }

    .detail-card {
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        padding: 23px;
        margin-bottom: 20px;
    }

    .detail-card h3 {
        color: #17345c;
        font-size: 15px;
        font-weight: 800;
        margin: 0 0 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .detail-item small {
        display: block;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .detail-item strong {
        color: #334155;
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .answer-card {
        border: 1px solid #edf1f7;
        border-radius: 12px;
        padding: 17px;
        margin-bottom: 15px;
    }

    .answer-card:last-child {
        margin-bottom: 0;
    }

    .answer-question {
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.7;
        margin-bottom: 12px;
    }

    .answer-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 800;
    }

    .status-ya {
        background: #e7f9ef;
        color: #059669;
    }

    .status-tidak {
        background: #fff1f2;
        color: #dc2626;
    }

    .evidence-list {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 15px;
    }

    .evidence-item {
        width: 180px;
    }

    .evidence-item img {
        width: 100%;
        height: 130px;
        object-fit: cover;
        border-radius: 9px;
        border: 1px solid #e2e8f0;
    }

    .evidence-item a {
        display: block;
        margin-top: 7px;
        color: #2563eb;
        font-size: 11px;
        text-decoration: none;
    }

    .back-btn {
        display: inline-block;
        padding: 10px 16px;
        background: #eaf1ff;
        color: #2563eb;
        border-radius: 9px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    @media(max-width: 600px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .detail-card {
            padding: 16px;
        }
    }
</style>

<a href="{{ route('admin.ccv.index') }}" class="back-btn">
    ← Kembali ke Dashboard
</a>

<div class="detail-header">
    <h2>Detail Laporan CCV</h2>
    <p>Informasi pengamatan dan hasil verifikasi pengendalian risiko.</p>
</div>

<div class="detail-card">
    <h3>Informasi Pengamatan</h3>

    <div class="detail-grid">

        <div class="detail-item">
            <small>NAMA PENGAMAT</small>
            <strong>{{ $observation->observer_name }}</strong>
        </div>

        <div class="detail-item">
            <small>PERUSAHAAN</small>
            <strong>{{ $observation->company }}</strong>
        </div>

        <div class="detail-item">
            <small>JABATAN</small>
            <strong>{{ $observation->position }}</strong>
        </div>

        <div class="detail-item">
            <small>DEPARTEMEN</small>
            <strong>{{ $observation->department ?: '-' }}</strong>
        </div>

        <div class="detail-item">
            <small>UNIT INDUK</small>
            <strong>{{ $observation->unit_induk }}</strong>
        </div>

        <div class="detail-item">
            <small>LOKASI PEKERJAAN</small>
            <strong>{{ $observation->work_location }}</strong>
        </div>

        <div class="detail-item">
            <small>NOMOR WORK ORDER</small>
            <strong>{{ $observation->work_order_number ?: '-' }}</strong>
        </div>

        <div class="detail-item">
            <small>UNIT PELAKSANA</small>
            <strong>{{ $observation->executing_unit }}</strong>
        </div>

        <div class="detail-item">
            <small>UNIT LAYANAN PELANGGAN</small>
            <strong>{{ $observation->customer_service_unit ?: '-' }}</strong>
        </div>

        <div class="detail-item">
            <small>PENGAWAS HADIR</small>
            <strong>{{ $observation->supervisor_present ? 'Ya' : 'Tidak' }}</strong>
        </div>

        <div class="detail-item">
            <small>KODE RISIKO</small>
            <strong>{{ $observation->risk_code }}</strong>
        </div>

        <div class="detail-item">
            <small>TANGGAL PENGIRIMAN</small>
            <strong>
                {{ $observation->submitted_at
                    ? $observation->submitted_at->format('d F Y, H:i')
                    : '-' }}
            </strong>
        </div>

    </div>
</div>

<div class="detail-card">
    <h3>Hasil Verifikasi Pengendalian Risiko</h3>

    @forelse($observation->answers as $answer)

        <div class="answer-card">

            <div class="answer-question">
                {{ $loop->iteration }}. {{ $answer->question_text }}
            </div>

            <span class="answer-status {{ $answer->answer === 'ya' ? 'status-ya' : 'status-tidak' }}">
                {{ strtoupper($answer->answer) }}
            </span>

            @if($answer->evidences->count())
                <div class="evidence-list">

                    @foreach($answer->evidences as $evidence)
                        <div class="evidence-item">

                            <a href="{{ asset('storage/' . $evidence->file_path) }}"
                               target="_blank">
                                <img src="{{ asset('storage/' . $evidence->file_path) }}"
                                     alt="Bukti dokumentasi CCV">
                            </a>

                            <a href="{{ asset('storage/' . $evidence->file_path) }}"
                               target="_blank">
                                Lihat bukti dokumentasi
                            </a>

                        </div>
                    @endforeach

                </div>
            @endif

        </div>

    @empty
        <p style="color:#94a3b8;font-size:13px">
            Belum ada jawaban verifikasi.
        </p>
    @endforelse

</div>

@endsection