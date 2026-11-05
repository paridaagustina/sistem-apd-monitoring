@extends('layouts.app')

@section('title', 'Dashboard Admin - APDMONITOR')

@section('content')

<div style="margin-bottom: 24px;">
    <span class="status hijau">ADMINISTRATOR</span>

    <h1>Dashboard Admin</h1>

    <p class="teks-redup">
        Selamat datang, {{ auth()->user()->name }}.
        Kelola data APD, data pekerja, dan pantau hasil pemeriksaan
        kelengkapan APD di sini.
    </p>
</div>

{{-- Laporan Lapangan --}}
<div class="kartu" style="margin-bottom:20px;">

    <h2>Live Laporan Lapangan</h2>

    <p class="teks-redup">
        Periksa video kedatangan pekerja di lokasi lapangan,
        lihat waktu perekaman dan pengiriman, serta kelola status laporan.
    </p>

    <a
        href="{{ route('admin.field-reports.index') }}"
        class="tombol">
        Lihat Laporan Lapangan →
    </a>

</div>

{{-- Statistik --}}
<div class="statistik">

    <div class="kartu">
        <div class="teks-redup">Jenis APD</div>
        <div class="angka">{{ $stats['apd_items'] }}</div>
        <a href="{{ route('admin.apd-items.index') }}"
           class="tombol">
            Kelola APD
        </a>
    </div>

    <div class="kartu">
        <div class="teks-redup">Data Pekerja</div>
        <div class="angka">{{ $stats['workers'] }}</div>
        <a href="{{ route('admin.workers.index') }}"
           class="tombol">
            Kelola Pekerja
        </a>
    </div>

    <div class="kartu">
        <div class="teks-redup">Total Pemeriksaan</div>
        <div class="angka">{{ $stats['total'] }}</div>
        <span class="status hijau">Seluruh pemeriksaan</span>
    </div>

    <div class="kartu">
        <div class="teks-redup">Pemeriksaan Tidak Lengkap</div>
        <div class="angka" style="color: #b91c1c;">
            {{ $stats['tidak_lengkap'] }}
        </div>
        <span class="status merah">Perlu perhatian</span>
    </div>

</div>

{{-- Ringkasan hasil --}}
<div class="kartu">
    <h2>Ringkasan Pemeriksaan APD</h2>

    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <span class="status hijau">
            Lengkap: {{ $stats['lengkap'] }}
        </span>

        <span class="status merah">
            Tidak lengkap: {{ $stats['tidak_lengkap'] }}
        </span>
    </div>

    <p class="teks-redup">
        Gunakan data ini untuk memantau kepatuhan penggunaan APD
        dan menentukan tindak lanjut terhadap pemeriksaan yang
        belum memenuhi persyaratan.
    </p>
</div>


{{-- Pemeriksaan terbaru --}}
<div class="kartu">
    <h2>Riwayat Pemeriksaan Terbaru</h2>

    @if($inspections->isEmpty())
        <p class="teks-redup">
            Belum ada pemeriksaan APD yang tercatat.
        </p>
    @else
        <div class="pembungkus-tabel">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Waktu Pemeriksaan</th>
                        <th>Nama Pekerja</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Bukti Video</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($inspections as $inspection)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $inspection->started_at
                                    ? $inspection->started_at->format('d/m/Y H:i')
                                    : $inspection->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td>
                                {{ $inspection->worker?->name ?? '-' }}
                            </td>

                            <td>
                                {{ $inspection->user?->name ?? '-' }}
                            </td>

                            <td>
                                @if($inspection->status === 'lengkap')
                                    <span class="status hijau">Lengkap</span>
                                @else
                                    <span class="status merah">
                                        {{ ucfirst(str_replace('_', ' ', $inspection->status ?? 'Belum diketahui')) }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($inspection->evidence_path)
                                    <a href="{{ asset('storage/' . $inspection->evidence_path) }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="tombol"
                                       style="background: #2563eb; color: white; white-space: nowrap;">
                                        <i class="fas fa-play-circle"></i>
                                        Lihat Video
                                    </a>
                                @else
                                    <span class="teks-redup">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>


@endsection