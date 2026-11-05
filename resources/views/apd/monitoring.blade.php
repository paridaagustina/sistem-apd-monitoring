
@extends('layouts.app')

@section('title', 'Monitoring Kelengkapan APD')

@section('content')

<div class="kartu">
    <p class="teks-redup">PEMERIKSAAN KESELAMATAN</p>
    <h1>Monitoring Kelengkapan APD</h1>

    <p class="teks-redup">
    Aktifkan webcam untuk merekam proses pemeriksaan.
    Periksa kelengkapan APD melalui checklist, kemudian simpan
    hasil pemeriksaan beserta video bukti.
</p>
</div>

<form
    method="POST"
    action="{{ route('pekerja.monitoring.store') }}" 
    enctype="multipart/form-data"
    id="formPemeriksaan"
>
    @csrf

    <div class="kartu">
        <h2>Kamera Laptop / Webcam</h2>

        <video
            id="kamera"
            autoplay
            playsinline
            muted
            style="
                width:100%;
                max-height:480px;
                background:#111827;
                border-radius:12px;
                object-fit:contain;
                aspect-ratio:16/9;
            "
        ></video>
<div class="kartu" style="margin-top:20px;">
    <h2>Deteksi AI YOLO</h2>

    <p class="teks-redup">
        Sistem mendeteksi kelengkapan APD secara otomatis melalui webcam.
    </p>

    <div id="statusAI" class="pesan pesan-error">
        Menunggu kamera diaktifkan...
    </div>

    <div id="hasilStatusAI" style="margin-top:15px;">
        <h3>Status Pemeriksaan AI</h3>
        <p id="statusKeseluruhan">Belum ada hasil deteksi.</p>
    </div>

    <div style="margin-top:15px;">
        <h3>Detail Kelengkapan APD</h3>
        <div id="detailAI">
            <p class="teks-redup">Belum ada deteksi.</p>
        </div>
    </div>

    <div style="margin-top:15px;">
        <h3>Objek Terdeteksi</h3>
        <div id="daftarDeteksi">
            <p class="teks-redup">Belum ada objek terdeteksi.</p>
        </div>
    </div>
</div>

<canvas id="canvasDeteksi" style="display:none;"></canvas>
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:14px">
            <button type="button" class="tombol" id="aktifkanKamera">
                Aktifkan Kamera
            </button>

            <button
                type="button"
                class="tombol"
                id="mulaiRekam"
                disabled
            >
                Mulai Rekam
            </button>

            <button
                type="button"
                class="tombol tombol-merah"
                id="hentikanRekam"
                disabled
            >
                Hentikan Rekaman
            </button>
        </div>

        <p id="statusKamera" class="teks-redup">
            Kamera belum diaktifkan.
        </p>

        <div style="margin-top:18px">
            <label for="videoUpload">
                Atau pilih video yang sudah ada
            </label>

            <input
                type="file"
                id="videoUpload"
                name="video"
                accept="video/*"
                style="display:block;margin-top:10px"
            >

            <p class="teks-redup">
                Maksimal 100 MB. Video baru dikirim ketika
                tombol Simpan Pemeriksaan ditekan.
            </p>
        </div>
    </div>

    <div class="kartu">
        
<div class="kartu" style="margin-bottom:20px">
    <h3>Identitas Pekerja</h3>

    <p class="teks-redup">
        Identitas diambil otomatis dari akun yang sedang login.
    </p>

    <div class="grup" style="margin-top:15px">
        <label>Nama Pekerja</label>
        <input type="text"
            value="{{ $worker->name }}"
            readonly
            style="width:100%;padding:12px;border:1px solid #e0e6ef;border-radius:10px;background:#f5f7fa;">
    </div>

    <div class="grup">
        <label>Nomor Identitas</label>
        <input type="text"
            value="{{ $worker->worker_code }}"
            readonly
            style="width:100%;padding:12px;border:1px solid #e0e6ef;border-radius:10px;background:#f5f7fa;">
    </div>

    <div class="grup">
        <label>Departemen / Bagian</label>
        <input type="text"
            value="{{ $worker->department ?? '-' }}"
            readonly
            style="width:100%;padding:12px;border:1px solid #e0e6ef;border-radius:10px;background:#f5f7fa;">
    </div>

    <div class="grup">
        <label>Jabatan</label>
        <input type="text"
            value="{{ $worker->position ?? '-' }}"
            readonly
            style="width:100%;padding:12px;border:1px solid #e0e6ef;border-radius:10px;background:#f5f7fa;">
    </div>
</div>

    
</div>

        <h2>Checklist Kelengkapan APD</h2>

        <p class="teks-redup">
            Checklist berikut masih dilakukan secara manual.
            AI belum diaktifkan.
        </p>

        <div id="daftarApd">
            @foreach($items as $apd)
                <label
                    class="baris-apd"
data-id="{{ $apd->id }}"
data-apd-name="{{ strtolower($apd->name) }}"
                    style="
                        display:flex;
                        align-items:center;
                        gap:12px;
                        padding:14px;
                        margin-bottom:10px;
                        border:1px solid #e0e6ef;
                        border-radius:10px;
                        cursor:pointer;
                    "
                >
                    <input
                        type="checkbox"
                        name="checked_apd[]"
                        value="{{ $apd->id }}"
                        style="width:20px;height:20px"
                    >

                    <span style="flex:1;font-weight:bold">
                        {{ $apd->name }}
                    </span>

                    <span class="status merah labelStatus">
                        BELUM
                    </span>
                </label>
            @endforeach
        </div>

        <div id="ringkasan" class="pesan pesan-error">
            0 APD lengkap.
        </div>

        <div style="margin-top:18px">
            <label for="catatan">Catatan pemeriksaan</label>

            <textarea
                id="catatan"
                name="notes"
                rows="3"
                maxlength="2000"
                style="
                    display:block;
                    width:100%;
                    padding:12px;
                    margin-top:8px;
                    border:1px solid #e0e6ef;
                    border-radius:10px;
                "
                placeholder="Masukkan catatan jika diperlukan..."
            ></textarea>
        </div>

        <button
            type="submit"
            class="tombol"
            style="width:100%;margin-top:18px"
        >
            Simpan Pemeriksaan
        </button>
    </div>
</form>

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
