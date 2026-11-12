@extends('layouts.app')

@section('title', 'Monitoring Kelengkapan APD - APDMONITOR')

@push('styles')
<style>
.monitoring-page {
    width: 100%;
    max-width: 1600px;
    margin: 0 auto;
    color: #172554;
}

.monitoring-heading {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 18px;
    margin-bottom: 24px;
}

.monitoring-heading h1 {
    margin: 10px 0 7px;
    color: #172554;
    font-size: clamp(24px, 3vw, 30px);
    font-weight: 800;
    letter-spacing: -.7px;
}

.monitoring-heading p {
    max-width: 720px;
    margin: 0;
    color: #718096;
    font-size: 14px;
    line-height: 1.7;
}

.heading-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 12px;
    border: 1px solid #dbeafe;
    border-radius: 30px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1px;
}

.heading-badge::before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #2563eb;
}

.monitoring-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.55fr) minmax(290px, .85fr);
    gap: 20px;
    align-items: start;
}

.monitoring-main,
.monitoring-side {
    min-width: 0;
}

.monitor-card {
    padding: 23px;
    margin-bottom: 20px;
    border: 1px solid #e9eef7;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 6px 24px rgba(35, 65, 120, .045);
}

.card-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
}

.card-icon {
    display: grid;
    width: 44px;
    height: 44px;
    flex: 0 0 44px;
    place-items: center;
    border-radius: 13px;
    background: #eaf1ff;
    color: #2563eb;
    font-size: 20px;
}

.card-heading h2 {
    margin: 0 0 4px;
    color: #172554;
    font-size: 16px;
    font-weight: 800;
}

.card-heading p {
    margin: 0;
    color: #8995a8;
    font-size: 12px;
    line-height: 1.5;
}

/* KAMERA */
.camera-container {
    position: relative;
    overflow: hidden;
    border: 1px solid #202c42;
    border-radius: 15px;
    background: #101827;
}

#kamera {
    display: block;
    width: 100%;
    max-height: 490px;
    aspect-ratio: 16 / 9;
    border-radius: 15px;
    background: #101827;
    object-fit: contain;
}

.camera-status {
    display: flex;
    align-items: center;
    gap: 10px;
    min-height: 45px;
    margin-top: 14px;
    padding: 11px 14px;
    border: 1px solid #e7edf6;
    border-radius: 11px;
    background: #f8faff;
    color: #64748b;
    font-size: 12px;
    line-height: 1.5;
}

.camera-status::before {
    content: "";
    width: 9px;
    height: 9px;
    flex: 0 0 9px;
    border-radius: 50%;
    background: #94a3b8;
}

.camera-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
    margin-top: 15px;
}

.camera-actions .tombol {
    min-height: 42px;
}

.monitor-card .tombol {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 11px 16px;
    border: 0;
    border-radius: 10px;
    background: #2563eb;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s ease;
}

.monitor-card .tombol:hover {
    transform: translateY(-1px);
    background: #1d4ed8;
}

.monitor-card .tombol:disabled {
    transform: none;
    opacity: .45;
    cursor: not-allowed;
}

.monitor-card .tombol-merah {
    background: #dc2626;
}

.monitor-card .tombol-merah:hover {
    background: #b91c1c;
}

/* UPLOAD VIDEO */
.upload-box {
    margin-top: 18px;
    padding: 16px;
    border: 1px dashed #b8c8e5;
    border-radius: 12px;
    background: #f8faff;
}

.upload-box label,
.field-group label {
    display: block;
    margin-bottom: 8px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.upload-box input[type="file"] {
    display: block;
    width: 100%;
    margin-top: 8px;
    color: #64748b;
    font-size: 12px;
}

.upload-box p {
    margin: 9px 0 0;
    color: #94a3b8;
    font-size: 11px;
    line-height: 1.5;
}

/* HASIL AI */
.ai-status {
    padding: 13px 15px;
    border: 1px solid #dbeafe;
    border-radius: 11px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    line-height: 1.6;
}

.ai-result {
    margin-top: 15px;
    padding: 16px;
    border: 1px solid #e9eef7;
    border-radius: 12px;
    background: #f8faff;
}

.ai-result h3 {
    margin: 0 0 12px;
    color: #334155;
    font-size: 13px;
    font-weight: 800;
}

#statusKeseluruhan {
    display: inline-flex;
    margin: 0;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background: #fff;
    font-size: 12px;
    font-weight: 800;
}

#detailAI > div {
    padding: 12px !important;
    margin-bottom: 8px !important;
    border: 1px solid #e5eaf2 !important;
    border-radius: 10px !important;
    background: #fff;
    font-size: 12px;
}

#detailAI > div:last-child {
    margin-bottom: 0 !important;
}

#daftarDeteksi p {
    padding: 10px 12px;
    margin: 0 0 8px;
    border: 1px solid #e5eaf2;
    border-radius: 9px;
    background: #fff;
    color: #475569;
    font-size: 12px;
}

#daftarDeteksi p:last-child {
    margin-bottom: 0;
}

/* IDENTITAS PEKERJA */
.identity-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 13px;
}

.field-group input,
.field-group textarea {
    display: block;
    width: 100%;
    padding: 11px 13px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    outline: none;
    background: #f8faff;
    color: #475569;
    font-family: inherit;
    font-size: 12px;
}

.field-group input:focus,
.field-group textarea:focus {
    border-color: #93b4ff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

/* CHECKLIST APD */
.apd-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
}

.baris-apd {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    padding: 13px !important;
    margin: 0 !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 11px !important;
    background: #f8faff;
    cursor: pointer;
    transition: .2s ease;
}

.baris-apd:hover {
    border-color: #a8c2fa !important;
    transform: translateY(-1px);
}

.baris-apd input[type="checkbox"] {
    width: 18px;
    height: 18px;
    flex: 0 0 18px;
    accent-color: #2563eb;
    cursor: pointer;
}

.baris-apd > span:nth-child(2) {
    flex: 1;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.4;
}

.baris-apd .status {
    padding: 5px 8px;
    border-radius: 20px;
    font-size: 9px;
    font-weight: 800;
    white-space: nowrap;
}

.pesan {
    padding: 12px 14px;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    background: #f0fdf4;
    color: #166534;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.5;
}

.pesan-error {
    border-color: #fecaca;
    background: #fff1f2;
    color: #be123c;
}

.catatan-box {
    margin-top: 20px;
}

.catatan-box textarea {
    min-height: 100px;
    resize: vertical;
    background: #fff;
}

.submit-area {
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid #edf1f7;
}

.tombol-simpan {
    width: 100%;
    min-height: 47px;
    font-size: 13px !important;
}

/* RESPONSIVE */
@media (max-width: 1000px) {
    .monitoring-layout {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 650px) {
    .monitor-card {
        padding: 17px;
        border-radius: 14px;
    }

    .identity-grid,
    .apd-grid {
        grid-template-columns: 1fr;
    }

    .monitoring-heading h1 {
        font-size: 23px;
    }

    .camera-actions {
        flex-direction: column;
    }

    .camera-actions .tombol {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
<div class="monitoring-page">

    <div class="monitoring-heading">
        <div>
            <span class="heading-badge">SAFETY MONITORING</span>

            <h1>Monitoring Kelengkapan APD</h1>

            <p>
                Aktifkan webcam untuk merekam proses pemeriksaan.
                Periksa kelengkapan alat pelindung diri melalui bantuan
                AI dan checklist, kemudian simpan hasil pemeriksaan beserta video bukti.
            </p>
        </div>
    </div>

    <form
        method="POST"
        action="{{ route('pekerja.monitoring.store') }}"
        enctype="multipart/form-data"
        id="formPemeriksaan"
    >
        @csrf

        <div class="monitoring-layout">

            <div class="monitoring-main">

                {{-- KAMERA DAN REKAMAN --}}
                <section class="monitor-card">

                    <div class="card-heading">
                        <div class="card-icon">📹</div>

                        <div>
                            <h2>Kamera Laptop / Webcam</h2>
                            <p>Gunakan kamera untuk merekam proses pemeriksaan APD.</p>
                        </div>
                    </div>

                    <div class="camera-container">
                        <video id="kamera" autoplay playsinline muted></video>
                    </div>

                    <div class="camera-actions">

                        <button type="button" class="tombol" id="aktifkanKamera">
                            📷 Aktifkan Kamera
                        </button>

                        <button type="button" class="tombol" id="mulaiRekam" disabled>
                            ● Mulai Rekam
                        </button>

                        <button type="button" class="tombol tombol-merah" id="hentikanRekam" disabled>
                            ■ Hentikan Rekaman
                        </button>

                    </div>

                    <div class="camera-status">
                        <span id="statusKamera">Kamera belum diaktifkan.</span>
                    </div>

                    <div class="upload-box">

                        <label for="videoUpload">
                            📁 Atau pilih video yang sudah ada
                        </label>

                        <input
                            type="file"
                            id="videoUpload"
                            name="video"
                            accept="video/*"
                        >

                        <p>
                            Maksimal 100 MB. Video dikirim ketika tombol
                            Simpan Pemeriksaan ditekan.
                        </p>

                    </div>

                </section>

                {{-- IDENTITAS PEKERJA --}}
                <section class="monitor-card">

                    <div class="card-heading">
                        <div class="card-icon">👤</div>

                        <div>
                            <h2>Identitas Pekerja</h2>
                            <p>Informasi diambil otomatis dari akun yang sedang login.</p>
                        </div>
                    </div>

                    <div class="identity-grid">

                        <div class="field-group">
                            <label>Nama Pekerja</label>
                            <input type="text" value="{{ $worker->name }}" readonly>
                        </div>

                        <div class="field-group">
                            <label>Nomor Identitas</label>
                            <input type="text" value="{{ $worker->worker_code }}" readonly>
                        </div>

                        <div class="field-group">
                            <label>Departemen / Bagian</label>
                            <input type="text" value="{{ $worker->department ?? '-' }}" readonly>
                        </div>

                        <div class="field-group">
                            <label>Jabatan</label>
                            <input type="text" value="{{ $worker->position ?? '-' }}" readonly>
                        </div>

                    </div>

                </section>

                {{-- CHECKLIST APD --}}
                <section class="monitor-card">

                    <div class="card-heading">
                        <div class="card-icon">🛡️</div>

                        <div>
                            <h2>Checklist Kelengkapan APD</h2>
                            <p>Checklist dapat diperbarui berdasarkan hasil deteksi AI.</p>
                        </div>
                    </div>

                    <div id="daftarApd" class="apd-grid">

                        @foreach($items as $apd)

                            <label
                                class="baris-apd"
                                data-id="{{ $apd->id }}"
                                data-apd-name="{{ strtolower($apd->name) }}"
                            >

                                <input
                                    type="checkbox"
                                    name="checked_apd[]"
                                    value="{{ $apd->id }}"
                                >

                                <span>{{ $apd->name }}</span>

                                <span class="status merah labelStatus">
                                    BELUM
                                </span>

                            </label>

                        @endforeach

                    </div>

                    <div id="ringkasan" class="pesan pesan-error" style="margin-top:14px;">
                        0 APD lengkap.
                    </div>

                    <div class="catatan-box field-group">

                        <label for="catatan">Catatan Pemeriksaan</label>

                        <textarea
                            id="catatan"
                            name="notes"
                            rows="4"
                            maxlength="2000"
                            placeholder="Masukkan catatan jika diperlukan..."
                        ></textarea>

                    </div>

                    <div class="submit-area">

                        <button type="submit" class="tombol tombol-simpan">
                            ✓ Simpan Hasil Pemeriksaan
                        </button>

                    </div>

                </section>

            </div>

            <aside class="monitoring-side">

                {{-- HASIL DETEKSI AI --}}
                <section class="monitor-card">

                    <div class="card-heading">
                        <div class="card-icon">🤖</div>

                        <div>
                            <h2>Deteksi AI YOLO</h2>
                            <p>Hasil analisis kelengkapan APD.</p>
                        </div>
                    </div>

                    <div id="statusAI" class="ai-status">
                        Menunggu kamera diaktifkan...
                    </div>

                    <div class="ai-result">

                        <h3>Status Pemeriksaan AI</h3>

                        <div id="hasilStatusAI">
                            <p id="statusKeseluruhan">
                                Belum ada hasil deteksi.
                            </p>
                        </div>

                    </div>

                    <div class="ai-result">

                        <h3>Detail Kelengkapan APD</h3>

                        <div id="detailAI">
                            <p class="teks-redup">Belum ada deteksi.</p>
                        </div>

                    </div>

                    <div class="ai-result">

                        <h3>Objek Terdeteksi</h3>

                        <div id="daftarDeteksi">
                            <p class="teks-redup">
                                Belum ada objek terdeteksi.
                            </p>
                        </div>

                    </div>

                </section>

            </aside>

        </div>

        <canvas id="canvasDeteksi" style="display:none;"></canvas>

    </form>

</div>
@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    const API_DETEKSI = 'http://127.0.0.1:8000/detect';
    const INTERVAL_DETEKSI = 1500;

    const kamera = document.getElementById('kamera');
    const tombolKamera = document.getElementById('aktifkanKamera');
    const tombolMulai = document.getElementById('mulaiRekam');
    const tombolStop = document.getElementById('hentikanRekam');
    const statusKamera = document.getElementById('statusKamera');
    const inputVideo = document.getElementById('videoUpload');
    const form = document.getElementById('formPemeriksaan');

    const canvas = document.getElementById('canvasDeteksi');
    const statusAI = document.getElementById('statusAI');
    const statusKeseluruhan = document.getElementById('statusKeseluruhan');
    const detailAI = document.getElementById('detailAI');
    const daftarDeteksi = document.getElementById('daftarDeteksi');

    let aliranKamera = null;
    let perekam = null;
    let potonganVideo = [];
    let intervalAI = null;
    let sedangMendeteksi = false;

    const namaAPD = {
        'boots': 'Sepatu keselamatan',
        'gloves': 'Sarung tangan',
        'goggles': 'Kacamata pelindung',
        'helmet': 'Helm keselamatan',
        'vest': 'Rompi reflektif'
    };

    function perbaruiChecklist() {

        const baris = document.querySelectorAll('.baris-apd');
        let jumlahLengkap = 0;

        baris.forEach(function (item) {

            const checkbox = item.querySelector('input');
            const label = item.querySelector('.labelStatus');

            if (checkbox.checked) {

                jumlahLengkap++;

                item.style.background = '#e8f8ee';
                item.style.borderColor = '#b6e7c5';

                label.className = 'status hijau labelStatus';
                label.textContent = 'LENGKAP';

            } else {

                item.style.background = '#feecec';
                item.style.borderColor = '#f3c2c2';

                label.className = 'status merah labelStatus';
                label.textContent = 'BELUM';

            }

        });

        const ringkasan = document.getElementById('ringkasan');

        const semuaLengkap =
            baris.length > 0 && jumlahLengkap === baris.length;

        ringkasan.className = semuaLengkap
            ? 'pesan'
            : 'pesan pesan-error';

        ringkasan.textContent =
            jumlahLengkap + ' dari ' + baris.length +
            ' APD lengkap. ' +
            (semuaLengkap
                ? 'Checklist lengkap.'
                : 'Masih ada APD yang belum dicentang.');

    }

    document.getElementById('daftarApd')
        .addEventListener('change', perbaruiChecklist);

    // Mencocokkan nama APD di database dengan kelas YOLO.
    function cocokkanAPD(nama) {

        const teks = nama.toLowerCase();

        const kataKunci = {
            helmet: ['helm', 'helmet'],
            vest: ['rompi', 'vest'],
            boots: ['sepatu', 'boots'],
            goggles: ['kacamata', 'goggles'],
            gloves: ['sarung tangan', 'gloves']
        };

        for (const [kelas, kata] of Object.entries(kataKunci)) {

            if (kata.some(function (item) {
                return teks.includes(item);
            })) {
                return kelas;
            }

        }

        return null;
    }

    // Memperbarui checklist berdasarkan hasil AI.
    // Status belum_dapat_dinilai tidak mengubah checklist.
    function terapkanHasilChecklist(details) {

        details.forEach(function (hasil) {

            if (
                hasil.status !== 'lengkap' &&
                hasil.status !== 'tidak_lengkap'
            ) {
                return;
            }

            const baris = document.querySelectorAll('.baris-apd');

            baris.forEach(function (item) {

                const nama = item.dataset.apdName || '';
                const kelas = cocokkanAPD(nama);

                if (kelas === hasil.class) {

                    const checkbox = item.querySelector('input');

                    checkbox.checked = hasil.status === 'lengkap';

                }

            });

        });

        perbaruiChecklist();
    }

    function tampilkanHasil(data) {

        const status = data.overall_status;

        const labelStatus = {
            lengkap: 'LENGKAP',
            tidak_lengkap: 'TIDAK LENGKAP',
            belum_dapat_dinilai: 'BELUM DAPAT DINILAI'
        };

        statusKeseluruhan.textContent =
            labelStatus[status] || 'BELUM DAPAT DINILAI';

        statusKeseluruhan.style.fontWeight = 'bold';

        if (status === 'lengkap') {

            statusKeseluruhan.style.color = '#15803d';

        } else if (status === 'tidak_lengkap') {

            statusKeseluruhan.style.color = '#dc2626';

        } else {

            statusKeseluruhan.style.color = '#b45309';

        }

        detailAI.replaceChildren();

        data.details.forEach(function (item) {

            const baris = document.createElement('div');

            baris.style.padding = '10px';
            baris.style.marginBottom = '8px';
            baris.style.border = '1px solid #e0e6ef';
            baris.style.borderRadius = '8px';

            const nama = document.createElement('strong');
            nama.textContent = item.name;

            const statusItem = document.createElement('span');

            statusItem.style.display = 'block';
            statusItem.style.marginTop = '5px';

            const label = {
                lengkap: 'LENGKAP',
                tidak_lengkap: 'TIDAK LENGKAP',
                belum_dapat_dinilai: 'BELUM DAPAT DINILAI'
            };

            statusItem.textContent =
                label[item.status] || item.status;

            statusItem.style.color =
                item.status === 'lengkap'
                    ? '#15803d'
                    : item.status === 'tidak_lengkap'
                        ? '#dc2626'
                        : '#b45309';

            baris.append(nama, statusItem);

            detailAI.appendChild(baris);

        });

        daftarDeteksi.replaceChildren();

        if (!data.detections.length) {

            daftarDeteksi.textContent =
                'Belum ada objek APD yang terdeteksi.';

        } else {

            data.detections.forEach(function (item) {

                const baris = document.createElement('p');

                const persen =
                    (item.confidence * 100).toFixed(1);

                baris.textContent =
                    item.class + ' - Confidence ' + persen + '%';

                daftarDeteksi.appendChild(baris);

            });

        }

        // Checklist hanya diperbarui jika AI memberikan status pasti.
        terapkanHasilChecklist(data.details);

        statusAI.textContent =
            'Deteksi berhasil diperbarui. Threshold: ' +
            data.confidence_threshold;

        statusAI.className = 'pesan';

    }

    // Mengirim satu frame webcam ke FastAPI.
    async function deteksiFrame() {

        if (
            sedangMendeteksi ||
            !aliranKamera ||
            kamera.readyState < 2
        ) {
            return;
        }

        sedangMendeteksi = true;

        try {

            const lebar = kamera.videoWidth;
            const tinggi = kamera.videoHeight;

            if (!lebar || !tinggi) {
                return;
            }

            canvas.width = lebar;
            canvas.height = tinggi;

            const context = canvas.getContext('2d');

            context.drawImage(kamera, 0, 0, lebar, tinggi);

            const gambar = await new Promise(function (resolve) {
                canvas.toBlob(resolve, 'image/jpeg', 0.85);
            });

            if (!gambar) {
                throw new Error('Gagal mengambil gambar webcam.');
            }

            const formData = new FormData();

            formData.append('file', gambar, 'frame-apd.jpg');

            const response = await fetch(API_DETEKSI, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {

                throw new Error(
                    'API YOLO memberikan status HTTP ' + response.status
                );

            }

            const data = await response.json();

            if (!data.success) {
                throw new Error('Deteksi YOLO gagal.');
            }

            tampilkanHasil(data);

        } catch (error) {

            console.error('Kesalahan deteksi YOLO:', error);

            statusAI.textContent =
                'Gagal menghubungi AI: ' + error.message;

            statusAI.className = 'pesan pesan-error';

        } finally {

            sedangMendeteksi = false;

        }

    }

    function mulaiDeteksiAI() {

        if (intervalAI) {
            clearInterval(intervalAI);
        }

        deteksiFrame();

        intervalAI = setInterval(
            deteksiFrame,
            INTERVAL_DETEKSI
        );

    }

    function hentikanDeteksiAI() {

        if (intervalAI) {
            clearInterval(intervalAI);
            intervalAI = null;
        }

    }

    // Mengaktifkan webcam.
    tombolKamera.addEventListener('click', async function () {

        try {

            aliranKamera =
                await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });

            kamera.srcObject = aliranKamera;

            await kamera.play();

            tombolMulai.disabled = false;
            tombolKamera.disabled = true;

            statusKamera.textContent =
                'Kamera aktif. Deteksi AI sedang dijalankan.';

            statusAI.textContent = 'Menghubungkan ke YOLO...';

            mulaiDeteksiAI();

        } catch (error) {

            console.error(error);

            statusKamera.textContent =
                'Kamera tidak dapat diakses. Periksa izin browser.';

        }

    });

    // Mulai merekam video webcam.
    tombolMulai.addEventListener('click', function () {

        if (!aliranKamera || !window.MediaRecorder) {

            statusKamera.textContent =
                'Perekaman tidak didukung oleh browser ini.';

            return;

        }

        const tipeVideo = [
            'video/webm;codecs=vp9,opus',
            'video/webm;codecs=vp8,opus',
            'video/webm'
        ].find(function (tipe) {
            return MediaRecorder.isTypeSupported(tipe);
        });

        potonganVideo = [];

        perekam = new MediaRecorder(
            aliranKamera,
            tipeVideo ? { mimeType: tipeVideo } : undefined
        );

        perekam.ondataavailable = function (event) {

            if (event.data && event.data.size > 0) {
                potonganVideo.push(event.data);
            }

        };

        perekam.onstop = function () {

            const videoHasil = new Blob(potonganVideo, {
                type: perekam.mimeType || 'video/webm'
            });

            const ekstensi =
                videoHasil.type.includes('mp4') ? 'mp4' : 'webm';

            const fileVideo = new File(
                [videoHasil],
                'pemeriksaan-apd-' + Date.now() + '.' + ekstensi,
                { type: videoHasil.type }
            );

            const transfer = new DataTransfer();

            transfer.items.add(fileVideo);

            inputVideo.files = transfer.files;

            statusKamera.textContent =
                'Video siap dikirim. Klik Simpan Pemeriksaan.';

            tombolMulai.disabled = false;
            tombolStop.disabled = true;

        };

        inputVideo.value = '';

        perekam.start(1000);

        tombolMulai.disabled = true;
        tombolStop.disabled = false;

        statusKamera.textContent = 'Video sedang direkam...';

    });

    tombolStop.addEventListener('click', function () {

        if (perekam && perekam.state !== 'inactive') {
            perekam.stop();
        }

        tombolStop.disabled = true;

    });

    // Pastikan rekaman selesai sebelum form dikirim.
    form.addEventListener('submit', function (event) {

        if (perekam && perekam.state !== 'inactive') {

            event.preventDefault();

            statusKamera.textContent =
                'Hentikan rekaman sebelum menyimpan pemeriksaan.';

            return;

        }

        if (
            inputVideo.files.length > 0 &&
            inputVideo.files[0].size > 100 * 1024 * 1024
        ) {

            event.preventDefault();

            alert('Ukuran video melebihi 100 MB.');

            return;

        }

        const adaYangBelumLengkap = [
            ...document.querySelectorAll(
                '#daftarApd input[type="checkbox"]'
            )
        ].some(function (checkbox) {
            return !checkbox.checked;
        });

        if (
            adaYangBelumLengkap &&
            !confirm(
                'Ada APD yang belum dicentang. Simpan sebagai tidak lengkap?'
            )
        ) {

            event.preventDefault();

        }

    });

    window.addEventListener('beforeunload', function () {

        hentikanDeteksiAI();

        if (aliranKamera) {

            aliranKamera.getTracks().forEach(function (track) {
                track.stop();
            });

        }

    });

    perbaruiChecklist();

});

</script>
@endpush