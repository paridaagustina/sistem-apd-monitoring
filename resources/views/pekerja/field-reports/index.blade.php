@extends('layouts.app')

@section('title', 'Live Laporan Lapangan - APDMONITOR')

@section('content')

<style>
    /* =====================================
       LIVE LAPORAN LAPANGAN - MODERN UI
    ===================================== */

    .laporan-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 8px 0 30px;
        color: #172554;
    }

    .laporan-wrapper * {
        box-sizing: border-box;
    }

    /* HEADER */

    .laporan-header {
        position: relative;
        overflow: hidden;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 24px;
        color: white;
        background: linear-gradient(120deg, #164e80, #087e9c);
        box-shadow: 0 8px 24px rgba(14, 116, 144, .14);
    }

    .laporan-header::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        right: -65px;
        top: -110px;
        border: 35px solid rgba(255,255,255,.08);
        border-radius: 50%;
    }

    .header-content {
        position: relative;
        z-index: 1;
    }

    .header-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .6px;
        margin-bottom: 14px;
    }

    .laporan-header h1 {
        font-size: 25px;
        font-weight: 800;
        margin: 0;
        color: white;
    }

    .laporan-header p {
        margin: 10px 0 0;
        color: #dbeafe;
        font-size: 13px;
        line-height: 1.7;
        max-width: 650px;
    }

    /* NOTIFICATION */

    .pesan-sukses,
    .pesan-error {
        padding: 15px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .pesan-sukses {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .pesan-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    /* GRID */

    .laporan-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(300px, .85fr);
        gap: 22px;
        align-items: start;
    }

    /* CARD */

    .kartu {
        background: #ffffff;
        border: 1px solid #e5edf6;
        border-radius: 18px;
        padding: 23px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .045);
        min-width: 0;
    }

    .kartu h2 {
        font-size: 16px;
        font-weight: 800;
        color: #172554;
        margin: 0 0 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kartu h2::before {
        content: "";
        width: 4px;
        height: 20px;
        background: #2563eb;
        border-radius: 5px;
    }

    /* GPS PANEL */

    .panel-lokasi {
        padding: 18px;
        background: linear-gradient(135deg, #eff6ff, #f0f9ff);
        border: 1px solid #bfdbfe;
        border-radius: 14px;
        margin-bottom: 17px;
    }

    .lokasi-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .lokasi-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .lokasi-heading h3 {
        font-size: 14px;
        font-weight: 800;
        color: #1e3a8a;
        margin: 0;
    }

    .lokasi-heading small {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
    }

    #statusLokasi {
        font-size: 12px;
        color: #475569;
        line-height: 1.6;
        margin: 10px 0 14px;
    }

    /* CAMERA */

    .kamera-container {
        position: relative;
        overflow: hidden;
        background: #0f172a;
        border-radius: 15px;
        border: 1px solid #1e293b;
        margin-bottom: 16px;
        min-height: 260px;
    }

    .kamera-preview {
        display: block;
        width: 100%;
        height: auto;
        min-height: 260px;
        max-height: 430px;
        object-fit: contain;
        background: #0f172a;
    }

    .kamera-label {
        position: absolute;
        top: 14px;
        left: 14px;
        padding: 7px 11px;
        background: rgba(15,23,42,.75);
        color: white;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .5px;
        pointer-events: none;
    }

    /* STATUS REKAMAN */

    .status-rekaman {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 15px;
        border-radius: 11px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        line-height: 1.5;
        margin: 13px 0;
    }

    .status-dot {
        width: 9px;
        height: 9px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #94a3b8;
    }

    /* DURATION */

    .durasi-panel {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        margin-bottom: 15px;
    }

    .durasi-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    #durasi {
        color: #1d4ed8;
        font-size: 20px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    /* GPS INFORMATION */

    .gps-info {
        padding: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .gps-info-title {
        color: #334155;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .gps-info-item {
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .gps-info-item:last-child {
        border-bottom: none;
    }

    .gps-info-item small {
        display: block;
        color: #64748b;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .gps-info-item p {
        color: #1e293b;
        font-size: 12px;
        font-weight: 700;
        margin: 0;
        overflow-wrap: anywhere;
    }

    #linkPeta {
        display: inline-block;
        margin-top: 12px;
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    #linkPeta:hover {
        text-decoration: underline;
    }

    /* BUTTON */

    .tombol-laporan {
        width: 100%;
        padding: 13px 16px;
        border: none;
        border-radius: 10px;
        margin-top: 10px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 800;
        transition: all .2s ease;
    }

    .tombol-laporan:hover:not(:disabled) {
        transform: translateY(-2px);
        filter: brightness(.96);
    }

    .tombol-laporan:disabled {
        opacity: .45;
        cursor: not-allowed;
        transform: none;
    }

    .btn-mulai {
        background: #15803d;
        color: white;
    }

    .btn-stop {
        background: #dc2626;
        color: white;
    }

    .btn-kirim {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        padding: 15px;
        margin-top: 22px;
        box-shadow: 0 5px 13px rgba(37,99,235,.16);
    }

    /* FORM */

    .form-laporan label {
        display: block;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        margin: 17px 0 8px;
    }

    .form-laporan input:not([type="hidden"]):not([type="file"]) {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #dbe4ef;
        border-radius: 10px;
        outline: none;
        background: #fff;
        color: #1e293b;
        font-size: 13px;
        transition: all .2s;
    }

    .form-laporan input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,.1);
    }

    .form-laporan input[readonly] {
        background: #f8fafc;
        color: #64748b;
        cursor: default;
    }

    .form-laporan input::placeholder {
        color: #94a3b8;
    }

    .form-petunjuk {
        padding: 13px;
        background: #eff6ff;
        border-radius: 10px;
        color: #1e40af;
        font-size: 11px;
        line-height: 1.7;
        margin-top: 18px;
    }

    .teks-redup {
        color: #64748b;
        font-size: 11px;
        line-height: 1.7;
    }

    /* HISTORY */

    .riwayat-card {
        margin-top: 23px;
    }

    .riwayat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }

    .riwayat-header h2 {
        margin-bottom: 0;
    }

    .riwayat-label {
        background: #eff6ff;
        color: #2563eb;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
    }

    .pembungkus-tabel {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #e5edf6;
        border-radius: 12px;
    }

    .tabel-laporan {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
        background: white;
    }

    .tabel-laporan th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        padding: 15px;
        text-align: left;
        white-space: nowrap;
    }

    .tabel-laporan td {
        padding: 15px;
        color: #334155;
        font-size: 12px;
        border-top: 1px solid #edf2f7;
    }

    .tabel-laporan tbody tr:hover {
        background: #f8fbff;
    }

    .status {
        display: inline-block;
        padding: 7px 11px;
        border-radius: 20px;
        background: #fff7ed;
        color: #c2410c;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status.hijau {
        background: #dcfce7;
        color: #15803d;
    }

    /* RESPONSIVE */

    @media(max-width: 900px) {
        .laporan-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 600px) {
        .laporan-wrapper {
            padding: 5px 0 20px;
        }

        .laporan-header {
            padding: 22px;
            border-radius: 15px;
        }

        .laporan-header h1 {
            font-size: 21px;
        }

        .kartu {
            padding: 17px;
            border-radius: 14px;
        }

        .kamera-container,
        .kamera-preview {
            min-height: 220px;
        }

        .riwayat-header {
            align-items: flex-start;
        }
    }
</style>

<div class="laporan-wrapper">

    {{-- HEADER --}}
    <div class="laporan-header">
        <div class="header-content">

            <div class="header-label">
                🛡️ WORKPLACE SAFETY SYSTEM
            </div>

            <h1>Live Laporan Lapangan</h1>

            <p>
                Dokumentasikan kondisi lokasi kerja melalui video
                dan koordinat GPS. Kirimkan laporan lapangan kepada
                admin untuk proses pemeriksaan.
            </p>

        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="pesan-sukses">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="pesan-error">
            <strong>Laporan belum berhasil dikirim:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="laporan-grid">

        {{-- KOLOM KAMERA --}}
        <div class="kartu">

            <h2>Kamera Lapangan</h2>

            {{-- GPS VERIFICATION --}}
            <div class="panel-lokasi" id="panelLokasi">

                <div class="lokasi-heading">
                    <div class="lokasi-icon">📍</div>

                    <div>
                        <h3>Verifikasi Lokasi GPS</h3>
                        <small>Langkah pertama sebelum merekam video</small>
                    </div>
                </div>

                <p id="statusLokasi">
                    Izinkan akses lokasi untuk mengaktifkan kamera.
                </p>

                <button
                    type="button"
                    id="btnAktifkan"
                    class="tombol-laporan btn-mulai"
                >
                    📍 Izinkan Lokasi & Aktifkan Kamera
                </button>

            </div>

            {{-- CAMERA PREVIEW --}}
            <div class="kamera-container">

                <div class="kamera-label">
                    ● CAMERA PREVIEW
                </div>

                <video
                    id="kamera"
                    class="kamera-preview"
                    autoplay
                    muted
                    playsinline
                ></video>

            </div>

            {{-- RECORDING STATUS --}}
            <div class="status-rekaman" id="statusRekaman">
                <span class="status-dot"></span>
                Kamera terkunci. Verifikasi lokasi terlebih dahulu.
            </div>

            {{-- DURATION --}}
            <div class="durasi-panel">
                <span class="durasi-label">
                    ⏱ Durasi Perekaman
                </span>

                <span id="durasi">00:00:00</span>
            </div>

            {{-- GPS DETAIL --}}
            <div class="gps-info">

                <div class="gps-info-title">
                    INFORMASI KOORDINAT LOKASI
                </div>

                <div class="gps-info-item">
                    <small>Koordinat GPS</small>
                    <p id="koordinatGPS">Belum tersedia</p>
                </div>

                <div class="gps-info-item">
                    <small>Akurasi GPS</small>
                    <p id="akurasiGPS">Belum tersedia</p>
                </div>

                <a
                    id="linkPeta"
                    href="#"
                    target="_blank"
                    rel="noopener noreferrer"
                    hidden
                >
                    ↗ Lihat lokasi di Google Maps
                </a>

            </div>

            {{-- RECORDING BUTTONS --}}
            <button
                type="button"
                id="btnMulai"
                class="tombol-laporan btn-mulai"
                disabled
            >
                🔴 Mulai Merekam
            </button>

            <button
                type="button"
                id="btnStop"
                class="tombol-laporan btn-stop"
                disabled
            >
                ■ Hentikan Rekaman
            </button>

            <p class="teks-redup" style="margin-top:15px;">
                Pastikan lokasi sudah terverifikasi dan kondisi
                lapangan terlihat jelas. Setelah rekaman dihentikan,
                periksa video sebelum mengirim laporan.
            </p>

        </div>

        {{-- KOLOM FORM --}}
        <div class="kartu">

            <h2>Informasi Laporan</h2>

            <form
                id="formLaporan"
                class="form-laporan"
                action="{{ route('pekerja.field-reports.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <label for="location_name">
                    Nama atau Keterangan Lokasi
                </label>

                <input
                    type="text"
                    id="location_name"
                    name="location_name"
                    maxlength="255"
                    placeholder="Contoh: Proyek Gedung A"
                    value="{{ old('location_name') }}"
                    required
                >

                <label for="latitudeTampil">
                    Latitude GPS
                </label>

                <input
                    type="text"
                    id="latitudeTampil"
                    readonly
                    placeholder="Menunggu verifikasi lokasi"
                >

                <label for="longitudeTampil">
                    Longitude GPS
                </label>

                <input
                    type="text"
                    id="longitudeTampil"
                    readonly
                    placeholder="Menunggu verifikasi lokasi"
                >

                <input
                    type="hidden"
                    id="latitude"
                    name="latitude"
                >

                <input
                    type="hidden"
                    id="longitude"
                    name="longitude"
                >

                <input
                    type="hidden"
                    id="location_accuracy"
                    name="location_accuracy"
                >

                <label for="waktuMulaiTampil">
                    Waktu Mulai
                </label>

                <input
                    type="text"
                    id="waktuMulaiTampil"
                    readonly
                    placeholder="Otomatis ketika mulai merekam"
                >

                <label for="waktuSelesaiTampil">
                    Waktu Selesai
                </label>

                <input
                    type="text"
                    id="waktuSelesaiTampil"
                    readonly
                    placeholder="Otomatis ketika rekaman dihentikan"
                >

                <input
                    type="hidden"
                    id="started_at"
                    name="started_at"
                >

                <input
                    type="hidden"
                    id="ended_at"
                    name="ended_at"
                >

                <input
                    type="hidden"
                    id="video_duration"
                    name="video_duration"
                >

                <input
                    type="file"
                    id="videoFile"
                    name="video"
                    accept="video/webm,video/mp4,video/quicktime"
                    hidden
                    required
                >

                <div class="form-petunjuk">
                    <strong>Informasi Pengiriman</strong><br>
                    Pastikan nama lokasi telah diisi, koordinat GPS
                    tersedia, dan video berhasil direkam sebelum
                    mengirim laporan kepada admin.
                </div>

                <button
                    type="submit"
                    id="btnKirim"
                    class="tombol-laporan btn-kirim"
                    disabled
                >
                    ↑ Kirim Laporan
                </button>

                <p
                    id="statusUpload"
                    class="teks-redup"
                    style="margin-top:12px;"
                ></p>

            </form>

        </div>

    </div>

    {{-- RIWAYAT LAPORAN --}}
    <div class="kartu riwayat-card">

        <div class="riwayat-header">

            <h2>Riwayat Laporan Saya</h2>

            <span class="riwayat-label">
                📋 RIWAYAT
            </span>

        </div>

        <div class="pembungkus-tabel">

            <table class="tabel-laporan">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Lokasi</th>
                        <th>Waktu Kirim</th>
                        <th>Durasi</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($reports as $report)

                        <tr>

                            <td>
                                {{ $reports->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $report->location_name }}</strong>
                            </td>

                            <td>
                                {{ $report->submitted_at->format('d/m/Y H:i:s') }}
                            </td>

                            <td>
                                {{ gmdate('H:i:s', $report->video_duration) }}
                            </td>

                            <td>
                                @if($report->status === 'diperiksa')
                                    <span class="status hijau">
                                        ✓ Sudah Diperiksa
                                    </span>
                                @else
                                    <span class="status">
                                        ◷ Menunggu Pemeriksaan
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" style="text-align:center;padding:30px;">
                                <div style="font-size:25px;margin-bottom:8px;">
                                    📂
                                </div>

                                <strong>Belum Ada Laporan</strong>

                                <p class="teks-redup">
                                    Laporan lapangan yang dikirim akan muncul di sini.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div style="margin-top:18px;">
            {{ $reports->links() }}
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const kamera = document.getElementById('kamera');

    const btnAktifkan = document.getElementById('btnAktifkan');
    const btnMulai = document.getElementById('btnMulai');
    const btnStop = document.getElementById('btnStop');
    const btnKirim = document.getElementById('btnKirim');

    const form = document.getElementById('formLaporan');
    const videoFile = document.getElementById('videoFile');

    const statusLokasi = document.getElementById('statusLokasi');
    const statusRekaman = document.getElementById('statusRekaman');
    const statusUpload = document.getElementById('statusUpload');

    const durasiElement = document.getElementById('durasi');

    let stream = null;
    let recorder = null;
    let chunks = [];
    let timer = null;

    let mulaiMs = null;
    let selesaiMs = null;
    let durasiDetik = 0;

    let lokasiTerverifikasi = false;
    let sedangMerekam = false;
    let sedangMemproses = false;

    let latitudeGPS = null;
    let longitudeGPS = null;
    let akurasiGPS = null;

    let rekamanBlobUrl = null;

    function formatWaktu(ms) {
        return new Date(ms).toLocaleString('id-ID', {
            timeZone: 'Asia/Makassar',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        }) + ' WITA';
    }

    function formatISO(ms) {
        return new Date(ms).toISOString();
    }

    function formatDurasi(total) {
        const jam = Math.floor(total / 3600);
        const menit = Math.floor((total % 3600) / 60);
        const detik = total % 60;

        return [
            String(jam).padStart(2, '0'),
            String(menit).padStart(2, '0'),
            String(detik).padStart(2, '0')
        ].join(':');
    }

    function hentikanStream() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }

        kamera.srcObject = null;
    }

    function resetLokasi() {
        lokasiTerverifikasi = false;

        latitudeGPS = null;
        longitudeGPS = null;
        akurasiGPS = null;

        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        document.getElementById('location_accuracy').value = '';

        document.getElementById('latitudeTampil').value = '';
        document.getElementById('longitudeTampil').value = '';

        document.getElementById('koordinatGPS').textContent =
            'Belum tersedia';

        document.getElementById('akurasiGPS').textContent =
            'Belum tersedia';

        document.getElementById('linkPeta').hidden = true;
    }

    function ambilLokasi() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error(
                    'Browser tidak mendukung layanan lokasi GPS.'
                ));

                return;
            }

            navigator.geolocation.getCurrentPosition(
                resolve,
                reject,
                {
                    enableHighAccuracy: true,
                    timeout: 20000,
                    maximumAge: 0
                }
            );
        });
    }

    btnAktifkan.addEventListener('click', async function () {
        if (sedangMerekam || sedangMemproses) {
            return;
        }

        btnAktifkan.disabled = true;
        btnMulai.disabled = true;

        resetLokasi();

        statusLokasi.textContent =
            'Meminta izin dan mengambil koordinat GPS...';

        statusRekaman.textContent =
            'Kamera masih terkunci.';

        try {
            const posisi = await ambilLokasi();

            latitudeGPS = posisi.coords.latitude;
            longitudeGPS = posisi.coords.longitude;
            akurasiGPS = posisi.coords.accuracy;

            if (akurasiGPS > 100) {
                resetLokasi();

                throw new Error(
                    'Akurasi GPS masih rendah (' +
                    Math.round(akurasiGPS) +
                    ' meter). Pindah ke area terbuka lalu coba lagi.'
                );
            }

            document.getElementById('latitude').value =
                latitudeGPS;

            document.getElementById('longitude').value =
                longitudeGPS;

            document.getElementById('location_accuracy').value =
                akurasiGPS;

            document.getElementById('latitudeTampil').value =
                latitudeGPS.toFixed(7);

            document.getElementById('longitudeTampil').value =
                longitudeGPS.toFixed(7);

            document.getElementById('koordinatGPS').textContent =
                latitudeGPS.toFixed(7) + ', ' +
                longitudeGPS.toFixed(7);

            document.getElementById('akurasiGPS').textContent =
                '±' + Math.round(akurasiGPS) + ' meter';

            const linkPeta = document.getElementById('linkPeta');

            linkPeta.href =
                'https://www.google.com/maps?q=' +
                latitudeGPS + ',' + longitudeGPS;

            linkPeta.hidden = false;

            lokasiTerverifikasi = true;

            statusLokasi.textContent =
                'Lokasi berhasil diperoleh. Mengaktifkan kamera...';

            if (!navigator.mediaDevices ||
                !navigator.mediaDevices.getUserMedia) {
                throw new Error(
                    'Browser tidak mendukung kamera. Gunakan HTTPS atau localhost.'
                );
            }

            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'environment' },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: true
            });

            kamera.srcObject = stream;
            kamera.controls = false;
            kamera.muted = true;

            await kamera.play();

            statusLokasi.textContent =
                'GPS dan kamera berhasil diaktifkan.';

            statusRekaman.textContent =
                'Siap merekam. Periksa lokasi dan kondisi lapangan.';

            btnMulai.disabled = false;

        } catch (error) {
            hentikanStream();
            resetLokasi();

            statusLokasi.textContent =
                error.code === 1
                    ? 'Izin lokasi ditolak. Kamera tidak dapat digunakan.'
                    : error.message ||
                      'Gagal mendapatkan lokasi atau mengaktifkan kamera.';

            statusRekaman.textContent =
                'Perekaman dikunci sampai lokasi berhasil diverifikasi.';

            btnMulai.disabled = true;

        } finally {
            btnAktifkan.disabled = false;
        }
    });

    btnMulai.addEventListener('click', function () {
        if (!lokasiTerverifikasi || !stream) {
            alert(
                'Verifikasi lokasi dan aktifkan kamera terlebih dahulu.'
            );

            return;
        }

        if (sedangMerekam || sedangMemproses) {
            return;
        }

        if (!window.MediaRecorder) {
            alert('Browser tidak mendukung perekaman video.');
            return;
        }

        const tipe = [
            'video/webm;codecs=vp8,opus',
            'video/webm',
            'video/mp4'
        ].find(type => MediaRecorder.isTypeSupported(type));

        chunks = [];

        try {
            recorder = tipe
                ? new MediaRecorder(stream, { mimeType: tipe })
                : new MediaRecorder(stream);

            mulaiMs = Date.now();
            selesaiMs = null;
            durasiDetik = 0;

            document.getElementById('started_at').value =
                formatISO(mulaiMs);

            document.getElementById('ended_at').value = '';

            document.getElementById('video_duration').value = '';

            document.getElementById('waktuMulaiTampil').value =
                formatWaktu(mulaiMs);

            document.getElementById('waktuSelesaiTampil').value = '';

            videoFile.value = '';

            btnKirim.disabled = true;

            statusUpload.textContent = '';

            recorder.ondataavailable = function (event) {
                if (event.data && event.data.size > 0) {
                    chunks.push(event.data);
                }
            };

            recorder.onerror = function () {
                sedangMerekam = false;
                statusRekaman.textContent =
                    'Terjadi kesalahan saat merekam video.';

                btnStop.disabled = true;
                btnMulai.disabled = false;
                btnAktifkan.disabled = false;
            };

            recorder.onstop = function () {
                selesaiMs = Date.now();

                durasiDetik = Math.max(
                    1,
                    Math.ceil((selesaiMs - mulaiMs) / 1000)
                );

                durasiElement.textContent =
                    formatDurasi(durasiDetik);

                const mimeType = recorder.mimeType || 'video/webm';

                const blob = new Blob(chunks, {
                    type: mimeType
                });

                const ekstensi = mimeType.includes('mp4')
                    ? 'mp4'
                    : 'webm';

                const file = new File(
                    [blob],
                    'laporan-lapangan-' + Date.now() + '.' + ekstensi,
                    { type: mimeType }
                );

                const transfer = new DataTransfer();

                transfer.items.add(file);

                videoFile.files = transfer.files;

                document.getElementById('ended_at').value =
                    formatISO(selesaiMs);

                document.getElementById('video_duration').value =
                    durasiDetik;

                document.getElementById('waktuSelesaiTampil').value =
                    formatWaktu(selesaiMs);

                if (rekamanBlobUrl) {
                    URL.revokeObjectURL(rekamanBlobUrl);
                }

                rekamanBlobUrl = URL.createObjectURL(blob);

                kamera.srcObject = null;
                kamera.src = rekamanBlobUrl;
                kamera.controls = true;
                kamera.muted = false;

                statusRekaman.textContent =
                    'Rekaman selesai. Periksa video sebelum mengirim.';

                btnKirim.disabled = false;
                btnMulai.disabled = false;
                btnAktifkan.disabled = false;

                hentikanStream();
            };

            recorder.start(1000);

            sedangMerekam = true;

            btnMulai.disabled = true;
            btnStop.disabled = false;
            btnAktifkan.disabled = true;

            statusRekaman.textContent =
                'Sedang merekam video lokasi lapangan...';

            timer = setInterval(function () {
                durasiDetik = Math.floor(
                    (Date.now() - mulaiMs) / 1000
                );

                durasiElement.textContent =
                    formatDurasi(durasiDetik);

                if (durasiDetik >= 3600) {
                    hentikanRekaman();
                }
            }, 1000);

        } catch (error) {
            statusRekaman.textContent =
                error.message || 'Gagal memulai rekaman.';
        }
    });

    function hentikanRekaman() {
        if (!recorder || recorder.state === 'inactive') {
            return;
        }

        sedangMerekam = false;

        btnStop.disabled = true;

        if (timer) {
            clearInterval(timer);
            timer = null;
        }

        recorder.stop();
    }

    btnStop.addEventListener('click', hentikanRekaman);

    form.addEventListener('submit', function (event) {
        if (sedangMerekam || sedangMemproses) {
            event.preventDefault();
            return;
        }

        if (!lokasiTerverifikasi ||
            !document.getElementById('latitude').value ||
            !document.getElementById('longitude').value) {

            event.preventDefault();

            alert(
                'Lokasi GPS wajib diaktifkan sebelum mengirim laporan.'
            );

            return;
        }

        if (!videoFile.files.length) {
            event.preventDefault();

            alert('Rekam video terlebih dahulu.');

            return;
        }

        if (!document.getElementById('location_name').value.trim()) {
            event.preventDefault();

            alert('Isi keterangan lokasi lapangan.');

            return;
        }

        sedangMemproses = true;

        btnKirim.disabled = true;
        btnMulai.disabled = true;
        btnAktifkan.disabled = true;

        statusUpload.textContent =
            'Mengunggah video dan data GPS. Jangan tutup halaman...';
    });

    window.addEventListener('pagehide', function () {
        if (timer) {
            clearInterval(timer);
        }

        hentikanStream();
    });
});
</script>

@endsection