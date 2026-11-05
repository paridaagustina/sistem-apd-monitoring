@extends('layouts.app')

@section('title', 'Laporan Lapangan - APDMONITOR')

@section('content')

<div style="margin-bottom:24px;">
    <span class="status hijau">ADMINISTRATOR</span>

    <h1>Live Laporan Lapangan</h1>

    <p class="teks-redup">
        Periksa laporan video yang dikirim oleh pekerja lapangan.
        Halaman ini terpisah dari riwayat deteksi APD.
    </p>
</div>

@if(session('success'))
    <div class="kartu" style="background:#dcfce7;color:#166534;">
        {{ session('success') }}
    </div>
@endif

<div class="statistik">

    <div class="kartu">
        <div class="teks-redup">Total Laporan</div>
        <div class="angka">{{ $stats['total'] }}</div>
    </div>

    <div class="kartu">
        <div class="teks-redup">Menunggu Pemeriksaan</div>
        <div class="angka">{{ $stats['menunggu'] }}</div>
    </div>

    <div class="kartu">
        <div class="teks-redup">Sudah Diperiksa</div>
        <div class="angka">{{ $stats['diperiksa'] }}</div>
    </div>

</div>

<div class="kartu">

    <form
        method="GET"
        action="{{ route('admin.field-reports.index') }}"
        style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;">

        <input
            type="text"
            name="cari"
            value="{{ request('cari') }}"
            placeholder="Cari nama pekerja atau lokasi..."
            style="padding:10px;flex:1;min-width:200px;">

        <select name="status" style="padding:10px;">
            <option value="">Semua Status</option>

            <option
                value="menunggu"
                @selected(request('status') === 'menunggu')>
                Menunggu
            </option>

            <option
                value="diperiksa"
                @selected(request('status') === 'diperiksa')>
                Sudah Diperiksa
            </option>
        </select>

        <button type="submit" class="tombol">
            Cari
        </button>

        <a href="{{ route('admin.field-reports.index') }}" class="tombol">
            Reset
        </a>

    </form>

    <div class="pembungkus-tabel">

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pekerja</th>
                    <th>Lokasi</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Waktu Dikirim</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $reports->firstItem() + $loop->index }}</td>

                        <td>{{ $report->user?->name ?? '-' }}</td>

                        <td>{{ $report->location_name }}</td>

                        <td>
                            {{ $report->started_at->format('d/m/Y H:i:s') }}
                        </td>

                        <td>
                            {{ $report->ended_at->format('d/m/Y H:i:s') }}
                        </td>

                        <td>
                            {{ $report->submitted_at->format('d/m/Y H:i:s') }}
                        </td>

                        <td>
                            {{ gmdate('H:i:s', $report->video_duration) }}
                        </td>

                        <td>
                            @if($report->status === 'diperiksa')
                                <span class="status hijau">Sudah Diperiksa</span>
                            @else
                                <span class="status">Menunggu</span>
                            @endif
                        </td>

                        <td>
                            <a
                                href="{{ route('admin.field-reports.show', $report) }}"
                                class="tombol"
                                style="white-space:nowrap;">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:25px;">
                            Belum ada laporan video lapangan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <div style="margin-top:20px;">
        {{ $reports->links() }}
    </div>

</div>

@endsection