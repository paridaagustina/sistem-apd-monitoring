@extends('layouts.app')

@section('title', 'Live Laporan Lapangan - APDMONITOR')

@section('content')

<style>
    .laporan-wrapper {
        max-width: 1100px;
        margin: auto;
    }

    .laporan-header {
        background: linear-gradient(135deg, #164e63, #0e7490);
        color: white;
        padding: 28px;
        border-radius: 18px;
        margin-bottom: 22px;
    }

    .laporan-header p {
        color: #e0f2fe;
        margin-top: 8px;
    }

    .laporan-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(280px, .8fr);
        gap: 20px;
    }

    .kamera-preview {
        width: 100%;
        background: #0f172a;
        border-radius: 14px;
        min-height: 260px;
        max-height: 480px;
        object-fit: contain;
    }

    .form-laporan label {
        display: block;
        font-weight: 600;
        margin: 15px 0 7px;
    }

    .form-laporan input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
    }

    .tombol-laporan {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 9px;
        margin-top: 12px;
        cursor: pointer;
        font-weight: 700;
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
        background: #1d4ed8;
        color: white;
    }

    .tombol-laporan:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .status-rekaman {
        padding: 10px;
        border-radius: 8px;
        background: #f1f5f9;
        margin: 12px 0;
    }

    .pesan-sukses {
        background: #dcfce7;
        color: #166534;
        padding: 14px;
        border-radius: 9px;
        margin-bottom: 18px;
    }

    .pesan-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px;
        border-radius: 9px;
        margin-bottom: 18px;
    }

    .tabel-laporan {
        width: 100%;
        border-collapse: collapse;
    }

    .tabel-laporan th,
    .tabel-laporan td {
        padding: 12px 8px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }

    @media(max-width: 760px) {
        .laporan-grid {
            grid-template-columns: 1fr;
        }

        .laporan-header {
            padding: 20px;
        }
    }
</style>

<div class="laporan-wrapper">

    <div class="laporan-header">
        <h1>Live Laporan Lapangan</h1>

        <p>
            Rekam kondisi lokasi ketika tiba di lapangan,
            kemudian kirimkan video kepada admin.
            Fitur ini terpisah dari deteksi kelengkapan APD.
        </p>
    </div>

    @if(session('success'))
        <div class="pesan-sukses">
            {{ session('success') }}
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

        <div class="kartu">

            <h2>Kamera Lapangan</h2>

<div
    id="panelLokasi"
    style="
        padding: 18px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        margin-bottom: 16px;
    "
>
    <h3 style="margin-top: 0;">Verifikasi Lokasi GPS</h3>

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

<video
    id="kamera"
    class="kamera-preview"
    autoplay
    muted
    playsinline
></video>

<div class="status-rekaman" id="statusRekaman">
    Kamera terkunci. Verifikasi lokasi terlebih dahulu.
</div>

<div style="margin-bottom: 12px;">
    <strong>Durasi:</strong>
    <span id="durasi">00:00</span>
</div>

<div
    style="
        padding: 14px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 15px;
    "
>
    <strong>Koordinat GPS</strong>

    <p id="koordinatGPS" style="margin-top: 8px;">
        Belum tersedia
    </p>

    <strong>Akurasi GPS</strong>

    <p id="akurasiGPS" style="margin-top: 8px;">
        Belum tersedia
    </p>

    <a
        id="linkPeta"
        href="#"
        target="_blank"
        rel="noopener noreferrer"
        hidden
    >
        Lihat lokasi di Google Maps
    </a>
</div>

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
    Hentikan Rekaman
</button>

            <p class="teks-redup" style="margin-top:12px;">
                Pastikan izin kamera diberikan dan lokasi yang direkam
                terlihat jelas. Setelah rekaman dihentikan, tekan
                tombol Kirim Laporan.
            </p>

        </div>

        <div class="kartu">

            <h2>Informasi Laporan</h2>

            <form
                id="formLaporan"
                class="form-laporan"
                action="{{ route('pekerja.field-reports.store') }}"
                method="POST"
                enctype="multipart/form-data">

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
                    required>

                    <label for="latitude">Latitude GPS</label>

<input
    type="text"
    id="latitudeTampil"
    readonly
    placeholder="Menunggu verifikasi lokasi"
>

<label for="longitude">Longitude GPS</label>

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

                <label>Waktu Mulai</label>

                <input
                    type="text"
                    id="waktuMulaiTampil"
                    readonly
                    placeholder="Otomatis ketika mulai merekam">

                <label>Waktu Selesai</label>

                <input
                    type="text"
                    id="waktuSelesaiTampil"
                    readonly
                    placeholder="Otomatis ketika rekaman dihentikan">

                <input
                    type="hidden"
                    id="started_at"
                    name="started_at">

                <input
                    type="hidden"
                    id="ended_at"
                    name="ended_at">

                <input
                    type="hidden"
                    id="video_duration"
                    name="video_duration">

                <input
                    type="file"
                    id="videoFile"
                    name="video"
                    accept="video/webm,video/mp4,video/quicktime"
                    hidden
                    required>

                <button
                    type="submit"
                    id="btnKirim"
                    class="tombol-laporan btn-kirim"
                    disabled>
                    Kirim Laporan
                </button>

                <p
                    id="statusUpload"
                    class="teks-redup"
                    style="margin-top:12px;">
                </p>

            </form>

        </div>

    </div>

    <div class="kartu" style="margin-top:22px;">

        <h2>Riwayat Laporan Saya</h2>

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
                            <td>{{ $reports->firstItem() + $loop->index }}</td>

                            <td>{{ $report->location_name }}</td>

                            <td>
                                {{ $report->submitted_at->format('d/m/Y H:i:s') }}
                            </td>

                            <td>
                                {{ gmdate('H:i:s', $report->video_duration) }}
                            </td>

                            <td>
                                @if($report->status === 'diperiksa')
                                    <span class="status hijau">
                                        Sudah Diperiksa
                                    </span>
                                @else
                                    <span class="status">
                                        Menunggu Pemeriksaan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:25px;">
                                Belum ada laporan lapangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div style="margin-top:15px;">
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

    // Waktu lokal untuk tampilan.
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

    // Waktu ISO untuk dikirim ke Laravel.
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

    // Mengambil lokasi GPS.
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

    // Meminta lokasi terlebih dahulu, baru mengaktifkan kamera.
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
            // LANGKAH 1: WAJIB mendapatkan lokasi.
            const posisi = await ambilLokasi();

            latitudeGPS = posisi.coords.latitude;
            longitudeGPS = posisi.coords.longitude;
            akurasiGPS = posisi.coords.accuracy;

            // Jika akurasi terlalu rendah, minta pekerja mencoba lagi.
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

            // LANGKAH 2: Kamera baru diminta setelah GPS berhasil.
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

    // Memulai perekaman setelah GPS dan kamera siap.
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

                // Kamera dimatikan setelah rekaman selesai.
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

    // Kirim laporan hanya jika GPS dan video tersedia.
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

    // Kamera tidak boleh terus aktif ketika halaman ditinggalkan.
    window.addEventListener('pagehide', function () {
        if (timer) {
            clearInterval(timer);
        }

        hentikanStream();
    });
});
</script>

@endsection