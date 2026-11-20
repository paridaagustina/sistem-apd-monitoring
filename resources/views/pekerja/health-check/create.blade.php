
@extends('layouts.app')

@section('title', 'Pemeriksaan Kesehatan Petugas')

{{-- =====================================================
     CSS KHUSUS HALAMAN PEMERIKSAAN KESEHATAN
===================================================== --}}
@push('styles')
<style>
    .health-wrapper {
        width: 100%;
        max-width: 1050px;
        margin: 0 auto;
        padding-bottom: 30px;
        color: #172b4d;
    }

    .health-wrapper * {
        box-sizing: border-box;
    }

    /* BANNER UTAMA */
    .health-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(115deg, #164e63, #087e9b);
        color: white;
        padding: 35px 32px;
        border-radius: 19px;
        margin-bottom: 25px;
        min-height: 175px;
        display: flex;
        align-items: center;
        gap: 22px;
        box-shadow: 0 8px 20px rgba(12, 100, 130, .12);
    }

    .health-header::after {
        content: "";
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        right: -45px;
        top: -90px;
    }

    .health-header-icon {
        width: 85px;
        height: 85px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,.16);
        font-size: 38px;
        position: relative;
        z-index: 1;
    }

    .health-header-content {
        position: relative;
        z-index: 1;
    }

    .health-header h1 {
        font-size: 25px;
        font-weight: 800;
        color: white;
        margin: 0 0 9px;
    }

    .health-header p {
        font-size: 14px;
        color: #e0f2fe;
        margin: 0 0 15px;
    }

    .health-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 15px;
        border-radius: 30px;
        background: rgba(255,255,255,.17);
        border: 1px solid rgba(255,255,255,.25);
        font-size: 12px;
        font-weight: 700;
        color: white;
    }

    /* NOTIFIKASI */
    .health-alert {
        padding: 15px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        border: 1px solid transparent;
    }

    .health-alert-success {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #15803d;
    }

    .health-alert-error {
        background: #fef2f2;
        border-color: #fecaca;
        color: #b91c1c;
    }

    /* FORM CARD */
    .health-card {
        background: #ffffff;
        padding: 28px 30px;
        border-radius: 18px;
        margin-bottom: 23px;
        border: 1px solid #e7edf5;
        box-shadow: 0 5px 20px rgba(15,23,42,.04);
    }

    /* JUDUL SECTION */
    .health-card-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 18px;
        margin-bottom: 25px;
        border-bottom: 1px solid #edf1f7;
    }

    .health-section-number {
        width: 35px;
        height: 35px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e6f5f9;
        color: #087e9b;
        border-radius: 11px;
        font-size: 14px;
        font-weight: 800;
    }

    .health-heading-text h2 {
        color: #164e63;
        font-size: 17px;
        font-weight: 800;
        margin: 0;
    }

    .health-heading-text p {
        color: #8291a6;
        font-size: 12px;
        margin: 5px 0 0;
    }

    /* GRID FORM */
    .health-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 23px 24px;
    }

    .health-full {
        grid-column: 1 / -1;
    }

    .health-form-group {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .health-form-group label {
        display: block;
        color: #263c5a;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .health-required {
        color: #ef4444;
    }

    /* INPUT DAN SELECT */
    .health-wrapper input:not([type="radio"]):not([type="checkbox"]),
    .health-wrapper select {
        width: 100%;
        height: 46px;
        padding: 0 14px;
        border: 1px solid #d5e0ee;
        border-radius: 10px;
        outline: none;
        background: #ffffff;
        color: #263c5a;
        font-family: inherit;
        font-size: 13px;
        transition: .2s ease;
    }

    .health-wrapper input:focus,
    .health-wrapper select:focus {
        border-color: #0e7490;
        box-shadow: 0 0 0 3px rgba(14,116,144,.10);
    }

    .health-wrapper input::placeholder {
        color: #a0aec0;
    }

    /* STATUS PEMERIKSAAN */
    .health-status-line {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 12px;
        font-size: 12px;
        color: #64748b;
    }

    .health-status-line span {
        font-weight: 800;
    }

    .health-status-box {
        padding: 18px 20px;
        margin-top: 24px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .health-status-box h3 {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin: 0;
    }

    .health-status-box p {
        margin: 8px 0 0;
    }

    /* KETERANGAN OXIMETER */
    .health-info-box {
        padding: 17px 19px;
        margin-top: 22px;
        border-radius: 12px;
        background: #eff8ff;
        border: 1px solid #dbeafe;
    }

    .health-info-box h3 {
        font-size: 13px;
        font-weight: 700;
        color: #1e40af;
        margin: 0 0 9px;
    }

    .health-info-box p {
        font-size: 12px;
        color: #1d4ed8;
        margin: 5px 0;
    }

    /* REKOMENDASI */
    #recommendationBox {
        border-radius: 14px;
        padding: 25px;
        text-align: center;
        transition: .2s ease;
    }

    #recommendationIcon {
        font-size: 34px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    #recommendationText {
        font-size: 18px;
    }

    #recommendationDescription {
        font-size: 13px;
        line-height: 1.6;
    }

    .health-disclaimer {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 13px;
        line-height: 1.6;
    }

    /* TOMBOL */
    .health-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 13px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #e7edf5;
    }

    .health-btn {
        min-height: 46px;
        padding: 12px 23px;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: .2s ease;
    }

    .health-btn-back {
        background: #ffffff;
        border: 1px solid #d5e0ee;
        color: #475569;
    }

    .health-btn-back:hover {
        background: #f1f5f9;
    }

    .health-btn-submit {
        background: #087e9b;
        border: 1px solid #087e9b;
        color: white;
        box-shadow: 0 4px 12px rgba(8,126,155,.17);
    }

    .health-btn-submit:hover {
        background: #075f78;
        border-color: #075f78;
        transform: translateY(-2px);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .health-wrapper {
            padding-bottom: 20px;
        }

        .health-header {
            padding: 25px;
            min-height: 145px;
        }

        .health-header-icon {
            width: 65px;
            height: 65px;
            font-size: 29px;
        }

        .health-header h1 {
            font-size: 20px;
        }

        .health-card {
            padding: 22px 20px;
        }
    }

    @media (max-width: 550px) {
        .health-grid {
            grid-template-columns: 1fr;
            gap: 19px;
        }

        .health-full {
            grid-column: auto;
        }

        .health-header {
            padding: 22px 18px;
            gap: 14px;
        }

        .health-header-icon {
            width: 48px;
            height: 48px;
            font-size: 23px;
        }

        .health-header h1 {
            font-size: 17px;
        }

        .health-header p {
            font-size: 12px;
        }

        .health-card {
            padding: 20px 16px;
        }

        .health-heading-text h2 {
            font-size: 14px;
        }

        .health-heading-text p {
            font-size: 11px;
        }

        .health-actions {
            flex-direction: column;
        }

        .health-btn {
            width: 100%;
        }
    }
</style>
@endpush


{{-- =====================================================
     KONTEN HALAMAN
===================================================== --}}
@section('content')

<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">

    <div class="health-wrapper">

        {{-- BANNER UTAMA --}}
        <div class="health-header">

            <div class="health-header-icon">
                ♡
            </div>

            <div class="health-header-content">
                <h1>Pemeriksaan Kesehatan Petugas</h1>

                <p>
                    Sistem Monitoring Kesehatan Petugas Lapangan APDMONITOR
                </p>

                <span class="health-badge">
                    ♡ Pemeriksaan Kesehatan - APDMONITOR
                </span>
            </div>

        </div>


        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="health-alert health-alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="health-alert health-alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="health-alert health-alert-error">

                <p class="font-semibold mb-2">
                    Periksa kembali formulir:
                </p>

                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- DAFTAR NAMA PETUGAS --}}
        @php
            $petugas = [
                'MUHAMMAD PAISAL ALPARISI',
                'SAMSIR NUR ALAM',
                'ALPI YANOOR',
                'RAHMADI',
                'TRIYONO',
                'MUHAMMAD NOFIE',
                'FAUZI',
                'IMAN SAPUTRA',
                'FAHRIANNOR',
                'MASRI',
                'NANANG ISWAHYUDI',
                'MAKSUM',
                'AGUS SUGIYONO',
                'HANDOYO SAPUTRO',
                'IWAN HARTONO',
                'SUBHAN RAMADHAN PRATAMA',
                'AHMAD RIFANI',
                'HENDRA',
                'MUHAMAD RENALDI',
                'AKHMAD KAMAL FAHRIYANUR',
                'AHMAD ANSOR',
                'SLAMET SETIAWAN',
                'MUHAMMAD KHALILUR RAHMAN',
                'SUKMA KELANA PUTRA',
                'ARJUN PRASETYO W',
                'MUHAMMAD AGUS RIDANI',
                'ABDUL MAJID',
                "MUHAMMAD RAPI'I AKBAR",
                'ASTIMAWANTO',
                'DWI PUSPITA SARI',
            ];
        @endphp


        {{-- FORMULIR --}}
        <form action="{{ route('pekerja.health-check.store') }}"
              method="POST"
              id="healthCheckForm">

            @csrf


            {{-- =========================================
                 BAGIAN 01: IDENTITAS PEMERIKSAAN
            ========================================== --}}
            <div class="health-card">

                <div class="health-card-heading">

                    <span class="health-section-number">01</span>

                    <div class="health-heading-text">
                        <h2>Identitas Pemeriksaan</h2>
                        <p>Lengkapi informasi pemeriksaan kesehatan petugas.</p>
                    </div>

                </div>


                <div class="health-grid">

                    {{-- NAMA PETUGAS --}}
                    <div class="health-form-group">

                        <label>
                            Nama Petugas yang Diperiksa
                            <span class="health-required">*</span>
                        </label>

                        <select name="nama_petugas" required>

                            <option value="">Pilih Nama Petugas</option>

                            @foreach($petugas as $nama)
                                <option value="{{ $nama }}"
                                    {{ old('nama_petugas') == $nama ? 'selected' : '' }}>
                                    {{ $nama }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- UNIT --}}
                    <div class="health-form-group">

                        <label>
                            Unit <span class="health-required">*</span>
                        </label>

                        <select name="unit" required>

                            <option value="">Pilih Unit</option>

                            @foreach($units as $unit)
                                <option value="{{ $unit }}"
                                    {{ old('unit') == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- TANGGAL --}}
                    <div class="health-form-group">

                        <label>
                            Tanggal Periksa
                            <span class="health-required">*</span>
                        </label>

                        <input type="date"
                               name="tanggal_periksa"
                               value="{{ old('tanggal_periksa', date('Y-m-d')) }}"
                               required>

                    </div>


                    {{-- USIA --}}
                    <div class="health-form-group">

                        <label>
                            Usia <span class="health-required">*</span>
                        </label>

                        <select name="usia" id="usia" required>

                            <option value="">Pilih Kategori Usia</option>

                            @foreach($ages as $age)
                                <option value="{{ $age }}"
                                    {{ old('usia') == $age ? 'selected' : '' }}>
                                    {{ $age }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- PERUSAHAAN --}}
                    <div class="health-form-group health-full">

                        <label>
                            Perusahaan <span class="health-required">*</span>
                        </label>

                        <select name="perusahaan" required>

                            <option value="">Pilih Perusahaan</option>

                            @foreach($companies as $company)
                                <option value="{{ $company }}"
                                    {{ old('perusahaan') == $company ? 'selected' : '' }}>
                                    {{ $company }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>

            </div>


            {{-- =========================================
                 BAGIAN 02: HASIL PEMERIKSAAN TENSI
            ========================================== --}}
            <div class="health-card">

                <div class="health-card-heading">

                    <span class="health-section-number">02</span>

                    <div class="health-heading-text">
                        <h2>Hasil Pemeriksaan Tekanan Darah</h2>
                        <p>
                            Masukkan hasil sistolik dan diastolik dari alat pengukur tekanan darah.
                        </p>
                    </div>

                </div>


                <div class="health-grid">

                    {{-- SISTOLIK --}}
                    <div class="health-form-group">

                        <label>
                            Sistolik (mmHg)
                            <span class="health-required">*</span>
                        </label>

                        <input type="number"
                               name="sistolik"
                               id="sistolik"
                               min="1"
                               max="300"
                               value="{{ old('sistolik') }}"
                               placeholder="Contoh: 120"
                               required>

                        <div class="health-status-line">
                            Status:
                            <span id="statusSistolik" class="text-slate-400">
                                Belum diperiksa
                            </span>
                        </div>

                    </div>


                    {{-- DIASTOLIK --}}
                    <div class="health-form-group">

                        <label>
                            Diastolik (mmHg)
                            <span class="health-required">*</span>
                        </label>

                        <input type="number"
                               name="diastolik"
                               id="diastolik"
                               min="1"
                               max="200"
                               value="{{ old('diastolik') }}"
                               placeholder="Contoh: 80"
                               required>

                        <div class="health-status-line">
                            Status:
                            <span id="statusDiastolik" class="text-slate-400">
                                Belum diperiksa
                            </span>
                        </div>

                    </div>

                </div>


                {{-- HASIL TENSI KESELURUHAN --}}
                <div class="health-status-box">

                    <h3>Hasil Tekanan Darah</h3>

                    <p id="statusTensi"
                       class="text-lg font-bold text-slate-400">
                        Menunggu hasil pemeriksaan
                    </p>

                    <p id="rentangTensi"
                       class="text-xs text-slate-500">
                        Pilih kategori usia dan masukkan hasil tekanan darah.
                    </p>

                </div>

            </div>


            {{-- =========================================
                 BAGIAN 03: HASIL PEMERIKSAAN OXIMETER
            ========================================== --}}
            <div class="health-card">

                <div class="health-card-heading">

                    <span class="health-section-number">03</span>

                    <div class="health-heading-text">
                        <h2>Hasil Pemeriksaan Oximeter</h2>
                        <p>
                            Masukkan hasil saturasi oksigen dalam darah (SpO₂).
                        </p>
                    </div>

                </div>


                <div class="health-grid">

                    <div class="health-form-group health-full">

                        <label>
                            Hasil Oximeter (%)
                            <span class="health-required">*</span>
                        </label>

                        <input type="number"
                               name="hasil_oximeter"
                               id="hasilOximeter"
                               min="0"
                               max="100"
                               value="{{ old('hasil_oximeter') }}"
                               placeholder="Contoh: 98"
                               required>

                        <div class="health-status-line">
                            Status:
                            <span id="statusOximeter" class="text-slate-400">
                                Belum diperiksa
                            </span>
                        </div>

                    </div>

                </div>


                {{-- KETERANGAN OXIMETER --}}
                <div class="health-info-box">

                    <h3>Keterangan Hasil Oximeter</h3>

                    <p>SpO₂ ≥ 94% : Normal</p>
                    <p>SpO₂ ≤ 93% : Tidak Normal</p>

                </div>

            </div>


            {{-- =========================================
                 BAGIAN 04: REKOMENDASI PEMERIKSAAN
            ========================================== --}}
            <div class="health-card">

                <div class="health-card-heading">

                    <span class="health-section-number">04</span>

                    <div class="health-heading-text">
                        <h2>Rekomendasi Hasil Pemeriksaan</h2>
                        <p>
                            Kesimpulan dihasilkan otomatis berdasarkan hasil tensi dan oximeter.
                        </p>
                    </div>

                </div>


                <div id="recommendationBox"
                     class="rounded-xl bg-slate-50 border border-slate-200 p-5 text-center">

                    <div id="recommendationIcon">
                        —
                    </div>

                    <p id="recommendationText"
                       class="font-bold text-lg text-slate-400">
                        Menunggu hasil pemeriksaan
                    </p>

                    <p id="recommendationDescription"
                       class="text-sm text-slate-500 mt-2">
                        Hasil rekomendasi akan muncul setelah seluruh data pemeriksaan diisi.
                    </p>

                </div>


                <p class="health-disclaimer">
                    Rekomendasi ini merupakan hasil klasifikasi berdasarkan acuan formulir
                    dan bukan pengganti penilaian tenaga kesehatan.
                </p>

            </div>


            {{-- =========================================
                 TOMBOL AKSI
            ========================================== --}}
            <div class="health-actions">

                <a href="{{ route('pekerja.dashboard') }}"
                   class="health-btn health-btn-back">
                    ← Kembali
                </a>

                <button type="submit"
                        class="health-btn health-btn-submit">
                    ✓ Simpan Pemeriksaan
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =====================================================
     JAVASCRIPT PERHITUNGAN OTOMATIS
===================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const usia = document.getElementById('usia');
    const sistolik = document.getElementById('sistolik');
    const diastolik = document.getElementById('diastolik');
    const oximeter = document.getElementById('hasilOximeter');

    const statusSistolik = document.getElementById('statusSistolik');
    const statusDiastolik = document.getElementById('statusDiastolik');
    const statusTensi = document.getElementById('statusTensi');
    const rentangTensi = document.getElementById('rentangTensi');
    const statusOximeter = document.getElementById('statusOximeter');

    const recommendationText = document.getElementById('recommendationText');
    const recommendationDescription = document.getElementById('recommendationDescription');
    const recommendationIcon = document.getElementById('recommendationIcon');
    const recommendationBox = document.getElementById('recommendationBox');


    // ACUAN RENTANG TEKANAN DARAH
    const ranges = {
        'Remaja (14-18 Tahun)': {
            sistolik: [90, 120],
            diastolik: [50, 80]
        },

        'Dewasa (19-40 Tahun)': {
            sistolik: [95, 125],
            diastolik: [60, 80]
        },

        'Dewasa (41-60 Tahun)': {
            sistolik: [110, 145],
            diastolik: [70, 90]
        },

        'Lansia (>60 Tahun)': {
            sistolik: [95, 145],
            diastolik: [70, 90]
        }
    };


    // KLASIFIKASI NILAI
    function classify(value, min, max) {

        if (value < min) return 'Rendah';

        if (value > max) return 'Tinggi';

        return 'Normal';
    }


    // MENGUBAH WARNA STATUS
    function setStatus(element, status) {

        element.textContent = status;

        element.className = 'font-bold';

        if (status === 'Normal') {

            element.classList.add('text-green-600');

        } else if (
            status === 'Rendah' ||
            status === 'Tinggi' ||
            status === 'Tidak Normal'
        ) {

            element.classList.add('text-red-600');

        } else {

            element.classList.add('text-slate-400');

        }
    }


    // REKOMENDASI OTOMATIS
    function updateRecommendation(tensi, oxygen) {

        if (!tensi || !oxygen) {

            recommendationText.textContent = 'Menunggu hasil pemeriksaan';

            recommendationText.className =
                'font-bold text-lg text-slate-400';

            recommendationDescription.textContent =
                'Lengkapi hasil tensi dan oximeter untuk melihat rekomendasi.';

            recommendationIcon.textContent = '—';

            recommendationBox.className =
                'rounded-xl bg-slate-50 border border-slate-200 p-5 text-center';

            return;
        }


        if (tensi === 'Normal' && oxygen === 'Normal') {

            recommendationText.textContent = 'SIAP BEKERJA';

            recommendationText.className =
                'font-bold text-lg text-green-700';

            recommendationDescription.textContent =
                'Hasil tensi dan oximeter berada dalam rentang normal berdasarkan acuan formulir.';

            recommendationIcon.textContent = '✓';

            recommendationBox.className =
                'rounded-xl bg-green-50 border border-green-200 p-5 text-center';

        } else {

            recommendationText.textContent = 'TIDAK DISARANKAN BEKERJA';

            recommendationText.className =
                'font-bold text-lg text-red-700';

            recommendationDescription.textContent =
                'Terdapat hasil pemeriksaan yang tidak normal. Diperlukan penilaian lebih lanjut oleh tenaga kesehatan.';

            recommendationIcon.textContent = '!';

            recommendationBox.className =
                'rounded-xl bg-red-50 border border-red-200 p-5 text-center';

        }
    }


    // PERHITUNGAN KESEHATAN
    function updateHealthCheck() {

        let tensiResult = null;

        let oxygenResult = null;

        const selectedAge = usia.value;

        const systolicValue = sistolik.value;

        const diastolicValue = diastolik.value;

        const oxygenValue = oximeter.value;


        // =====================================
        // PERHITUNGAN TEKANAN DARAH
        // =====================================
        if (selectedAge && ranges[selectedAge]) {

            const range = ranges[selectedAge];

            rentangTensi.textContent =
                `Acuan normal: Sistolik ${range.sistolik[0]}-${range.sistolik[1]} mmHg dan Diastolik ${range.diastolik[0]}-${range.diastolik[1]} mmHg.`;


            if (systolicValue !== '' && diastolicValue !== '') {

                const systolic = Number(systolicValue);

                const diastolic = Number(diastolicValue);


                if (
                    Number.isInteger(systolic) &&
                    Number.isInteger(diastolic) &&
                    systolic >= 1 && systolic <= 300 &&
                    diastolic >= 1 && diastolic <= 200
                ) {

                    const systolicStatus = classify(
                        systolic,
                        range.sistolik[0],
                        range.sistolik[1]
                    );

                    const diastolicStatus = classify(
                        diastolic,
                        range.diastolik[0],
                        range.diastolik[1]
                    );


                    setStatus(statusSistolik, systolicStatus);

                    setStatus(statusDiastolik, diastolicStatus);


                    tensiResult =
                        systolicStatus === 'Normal' &&
                        diastolicStatus === 'Normal'
                            ? 'Normal'
                            : 'Tidak Normal';


                    setStatus(statusTensi, tensiResult);

                } else {

                    setStatus(statusSistolik, 'Belum diperiksa');

                    setStatus(statusDiastolik, 'Belum diperiksa');

                    setStatus(statusTensi, 'Belum diperiksa');

                }

            } else {

                setStatus(statusSistolik, 'Belum diperiksa');

                setStatus(statusDiastolik, 'Belum diperiksa');

                setStatus(statusTensi, 'Belum diperiksa');

            }

        } else {

            rentangTensi.textContent =
                'Pilih kategori usia untuk melihat rentang tekanan darah.';

            setStatus(statusSistolik, 'Belum diperiksa');

            setStatus(statusDiastolik, 'Belum diperiksa');

            setStatus(statusTensi, 'Belum diperiksa');

        }


        // =====================================
        // PERHITUNGAN OXIMETER
        // =====================================
        if (oxygenValue !== '') {

            const oxygen = Number(oxygenValue);

            if (
                Number.isInteger(oxygen) &&
                oxygen >= 0 &&
                oxygen <= 100
            ) {

                oxygenResult = oxygen >= 94
                    ? 'Normal'
                    : 'Tidak Normal';

                setStatus(statusOximeter, oxygenResult);

            } else {

                setStatus(statusOximeter, 'Belum diperiksa');

            }

        } else {

            setStatus(statusOximeter, 'Belum diperiksa');

        }


        // =====================================
        // TAMPILKAN REKOMENDASI
        // =====================================
        updateRecommendation(tensiResult, oxygenResult);

    }


    // EVENT LISTENER
    usia.addEventListener('change', updateHealthCheck);

    sistolik.addEventListener('input', updateHealthCheck);

    diastolik.addEventListener('input', updateHealthCheck);

    oximeter.addEventListener('input', updateHealthCheck);


    // TAMPILKAN HASIL SAAT HALAMAN DIBUKA
    updateHealthCheck();

});
</script>

@endsection
