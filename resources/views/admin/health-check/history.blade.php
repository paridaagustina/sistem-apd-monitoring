ini sdh benar kah kodenya biar aku tempel di vs code 


@extends('layouts.app')

@section('title', 'Riwayat Kesehatan Petugas - APDMONITOR')
@section('page-heading', 'Riwayat Kesehatan Petugas')

@section('content')

<div style="background:white;padding:24px;border-radius:15px;margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:18px;flex-wrap:wrap;">

        @if($worker->photo)
            <img
                src="{{ asset('storage/' . $worker->photo) }}"
                alt="Foto {{ $worker->name }}"
                style="width:85px;height:85px;object-fit:cover;border-radius:12px;"
            >
        @else
            <div style="width:85px;height:85px;border-radius:12px;background:#eaf0ff;display:grid;place-items:center;color:#2563eb;font-size:28px;font-weight:bold;">
                {{ strtoupper(substr($worker->name, 0, 1)) }}
            </div>
        @endif

        <div>
            <h2 style="margin:0;color:#17345c;font-size:20px;">
                {{ $worker->name }}
            </h2>
            <p style="margin:7px 0;color:#8492a6;font-size:13px;">
                {{ $worker->position ?? 'Petugas' }}
            </p>
            <p style="margin:0;color:#8492a6;font-size:12px;">
                Total pemeriksaan: {{ $healthChecks->total() }} kali
            </p>
        </div>

    </div>
</div>

<div style="background:white;padding:24px;border-radius:15px;">

    <h3 style="color:#17345c;margin:0 0 20px;">
        Riwayat Pemeriksaan Kesehatan
    </h3>

    @forelse($healthChecks as $check)
        <div style="padding:18px;border:1px solid #e9eef5;border-radius:12px;margin-bottom:14px;">

            <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:15px;">
                <strong style="color:#17345c;">
                    {{ $check->tanggal_periksa->format('d F Y') }}
                </strong>

                <span style="font-size:12px;color:#8492a6;">
                    {{ $check->unit }}
                </span>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:15px;">

                <div>
                    <small style="color:#8492a6;">Tekanan Darah</small>
                    <div style="font-weight:800;color:#17345c;margin-top:5px;">
                        {{ $check->sistolik }}/{{ $check->diastolik }} mmHg
                    </div>
                    <small>{{ $check->status_tensi }}</small>
                </div>

                <div>
                    <small style="color:#8492a6;">Oximeter</small>
                    <div style="font-weight:800;color:#17345c;margin-top:5px;">
                        {{ $check->hasil_oximeter }}%
                    </div>
                    <small>{{ $check->status_oximeter }}</small>
                </div>

                <div>
                    <small style="color:#8492a6;">Kesimpulan</small>
                    <div style="font-weight:800;margin-top:5px;color:{{ $check->kesimpulan === 'SIAP BEKERJA' ? '#059669' : '#dc2626' }};">
                        {{ $check->kesimpulan }}
                    </div>
                </div>

            </div>
        </div>
    @empty
        <p style="text-align:center;color:#8492a6;padding:30px;">
            Belum ada riwayat pemeriksaan kesehatan.
        </p>
    @endforelse

    {{ $healthChecks->links() }}

    <a href="{{ route('admin.health-check.index') }}"
       style="display:inline-block;margin-top:15px;background:#64748b;color:white;padding:10px 15px;border-radius:8px;text-decoration:none;font-size:12px;">
        ← Kembali ke Dashboard
    </a>

</div>

@endsection