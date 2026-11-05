@extends('layouts.app')

@section('title', 'Detail Laporan Lapangan - APDMONITOR')

@section('content')

<div style="margin-bottom:24px;">
    <a
        href="{{ route('admin.field-reports.index') }}"
        class="tombol">
        ← Kembali ke Laporan
    </a>

    <h1 style="margin-top:20px;">Detail Laporan Lapangan</h1>

    <p class="teks-redup">
        Laporan #{{ $fieldReport->id }}
    </p>
</div>

@if(session('success'))
    <div class="kartu" style="background:#dcfce7;color:#166534;">
        {{ session('success') }}
    </div>
@endif

<div class="kartu">

    <h2>Video Laporan</h2>

    <video
        controls
        playsinline
        preload="metadata"
        style="
            width:100%;
            max-height:600px;
            background:#0f172a;
            border-radius:12px;
        "
        src="{{ route('admin.field-reports.video', $fieldReport) }}">
        Browser tidak mendukung pemutar video.
    </video>

    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:15px;">

        <a
            href="{{ route('admin.field-reports.download', $fieldReport) }}"
            class="tombol">
            Unduh Video
        </a>

    </div>

</div>

<div class="kartu">

    <h2>Informasi Laporan</h2>

    <div class="pembungkus-tabel">

        <table>
            <tbody>
                <tr>
                    <th style="text-align:left;padding:12px;">ID Laporan</th>
                    <td style="padding:12px;">{{ $fieldReport->id }}</td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Nama Pekerja</th>
                    <td style="padding:12px;">
                        {{ $fieldReport->user?->name ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Lokasi</th>
                    <td style="padding:12px;">
                        {{ $fieldReport->location_name }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Tanggal</th>
                    <td style="padding:12px;">
                        {{ $fieldReport->started_at->format('d/m/Y') }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Waktu Mulai</th>
                    <td style="padding:12px;">
                        {{ $fieldReport->started_at->format('H:i:s') }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Waktu Selesai</th>
                    <td style="padding:12px;">
                        {{ $fieldReport->ended_at->format('H:i:s') }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Waktu Diterima Server</th>
                    <td style="padding:12px;">
                        {{ $fieldReport->submitted_at->format('d/m/Y H:i:s') }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Durasi Video</th>
                    <td style="padding:12px;">
                        {{ gmdate('H:i:s', $fieldReport->video_duration) }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Ukuran Video</th>
                    <td style="padding:12px;">
                        {{ number_format($fieldReport->video_size / 1048576, 2) }} MB
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;padding:12px;">Status</th>
                    <td style="padding:12px;">
                        {{ $fieldReport->status === 'diperiksa'
                            ? 'Sudah Diperiksa'
                            : 'Menunggu Pemeriksaan' }}
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</div>

<div class="kartu">

    <h2>Pemeriksaan Admin</h2>

    <form
        method="POST"
        action="{{ route('admin.field-reports.update-status', $fieldReport) }}">

        @csrf
        @method('PATCH')

        <label for="status">Status Laporan</label>

        <select
            name="status"
            id="status"
            required
            style="display:block;width:100%;padding:12px;margin:10px 0 18px;">

            <option
                value="menunggu"
                @selected($fieldReport->status === 'menunggu')>
                Menunggu Pemeriksaan
            </option>

            <option
                value="diperiksa"
                @selected($fieldReport->status === 'diperiksa')>
                Sudah Diperiksa
            </option>

        </select>

        <label for="notes">Catatan Admin</label>

        <textarea
            name="notes"
            id="notes"
            rows="4"
            maxlength="2000"
            style="display:block;width:100%;box-sizing:border-box;padding:12px;margin:10px 0 18px;"
            placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $fieldReport->notes) }}</textarea>

        <button type="submit" class="tombol">
            Simpan Pemeriksaan
        </button>

    </form>

</div>

@endsection