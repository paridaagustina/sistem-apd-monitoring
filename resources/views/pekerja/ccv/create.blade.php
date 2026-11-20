@extends('layouts.app')

@section('title', 'Formulir CCV')

@section('content')

<style>
    .ccv-wrapper {
        width: 100%;
        max-width: 1050px;
        margin: 10px auto 35px;
        padding: 0;
        color: #172b4d;
    }

    .ccv-wrapper * {
        box-sizing: border-box;
    }

    /* HEADER */
    .ccv-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #164e63, #0e7490, #0f7895);
        color: #ffffff;
        padding: 30px 32px;
        border-radius: 18px;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(14, 116, 144, .13);
    }

    .ccv-header::after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        right: -45px;
        top: -80px;
    }

    .ccv-header h2 {
        font-size: 25px;
        font-weight: 800;
        margin: 0 0 9px;
        position: relative;
        z-index: 1;
    }

    .ccv-header p {
        font-size: 14px;
        margin: 0 0 13px;
        opacity: .95;
        position: relative;
        z-index: 1;
    }

    .ccv-header .ccv-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255,255,255,.17);
        border: 1px solid rgba(255,255,255,.25);
        color: #ffffff;
        padding: 8px 13px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    /* ALERT */
    .ccv-alert {
        padding: 15px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .ccv-alert ul {
        padding-left: 20px;
        margin-top: 8px;
    }

    /* CARD */
    .ccv-card {
        background: #ffffff;
        padding: 27px;
        border-radius: 17px;
        margin-bottom: 22px;
        border: 1px solid #e7edf5;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
    }

    .ccv-card h5 {
        display: flex;
        align-items: center;
        gap: 11px;
        color: #164e63;
        font-size: 16px;
        font-weight: 800;
        margin: 0 0 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #edf1f7;
    }

    .section-number {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #e8f5f9;
        color: #0e7490;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 800;
    }

    /* INPUT */
    .ccv-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 21px 24px;
    }

    .ccv-field {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .ccv-field.full-width {
        grid-column: 1 / -1;
    }

    .ccv-label {
        display: block;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.5;
    }

    .required-mark {
        color: #ef4444;
        margin-left: 2px;
    }

    .ccv-input,
    .ccv-select {
        display: block;
        width: 100%;
        min-width: 0;
        height: 46px;
        padding: 11px 14px;
        border: 1px solid #dce4ef;
        border-radius: 10px;
        background: #ffffff;
        color: #26364d;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .ccv-input:focus,
    .ccv-select:focus {
        border-color: #0e7490;
        box-shadow: 0 0 0 3px rgba(14, 116, 144, .10);
    }

    .ccv-input:disabled {
        background: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }

    .ccv-input::placeholder {
        color: #a0aec0;
    }

    /* QUESTION */
    .question {
        padding: 21px 0;
        border-bottom: 1px solid #edf1f7;
    }

    .question:first-of-type {
        padding-top: 0;
    }

    .question:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .question-title {
        color: #26364d;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.7;
        margin-bottom: 15px;
    }

    .question-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        height: 25px;
        background: #e8f5f9;
        color: #0e7490;
        border-radius: 7px;
        margin-right: 7px;
        font-size: 12px;
        font-weight: 800;
    }

    /* ANSWER */
    .answer-options {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 5px;
    }

    .answer-options.vertical {
        flex-direction: column;
        align-items: stretch;
    }

    .answer-option {
        display: inline-flex;
        align-items: center;
        justify-content: flex-start;
        gap: 9px;
        min-width: 105px;
        padding: 11px 17px;
        border: 1px solid #dce4ef;
        border-radius: 10px;
        background: #ffffff;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .answer-option:hover {
        border-color: #0e7490;
        background: #f0fdfa;
    }

    .answer-option input {
        width: 16px;
        height: 16px;
        margin: 0;
        accent-color: #0e7490;
        cursor: pointer;
        flex-shrink: 0;
    }

    .answer-option:has(input:checked) {
        background: #e8f5f9;
        border-color: #0e7490;
        color: #0e7490;
    }

    /* EVIDENCE */
    .evidence-box {
        margin-top: 18px;
        padding: 17px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
    }

    .evidence-label {
        display: block;
        color: #334155;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .ccv-file {
        display: block;
        width: 100%;
        padding: 11px;
        background: #ffffff;
        border: 1px solid #dce4ef;
        border-radius: 9px;
        color: #475569;
        font-size: 12px;
        cursor: pointer;
    }

    .ccv-file:focus {
        outline: 2px solid rgba(14,116,144,.2);
        border-color: #0e7490;
    }

    .evidence-help {
        display: block;
        margin-top: 8px;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.5;
    }

    /* DOCUMENTATION */
    .documentation-question {
        background: #f0fdfa;
        border: 1px solid #ccece8;
        border-radius: 13px;
        padding: 20px;
        margin-top: 15px;
    }

    .documentation-question .question-title {
        color: #115e59;
    }

    /* RISK CONTAINMENT */
    .risk-description {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 19px;
        color: #334155;
        font-size: 13px;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .risk-description p {
        margin: 0 0 15px;
    }

    .risk-description p:last-child {
        margin-bottom: 0;
    }

    .risk-note {
        background: #f0fdfa;
        border: 1px solid #ccece8;
        border-radius: 12px;
        padding: 17px;
        margin-top: 18px;
        color: #115e59;
        font-size: 13px;
        line-height: 1.7;
    }

    .risk-note p {
        margin: 7px 0 0;
    }

    /* RC SECTION */
    .rc-section {
        display: none;
    }

    .rc-section fieldset {
        min-width: 0;
    }

    /* BUTTON */
    .ccv-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin: 27px 0 40px;
    }

    .btn-submit {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        min-height: 48px;
        padding: 13px 25px;
        background: linear-gradient(135deg, #0e7490, #164e63);
        color: #ffffff;
        border: none;
        border-radius: 11px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 5px 14px rgba(14, 116, 144, .17);
        transition: all .2s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #164e63, #0c4a6e);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(14, 116, 144, .23);
    }

    /* RESPONSIVE */
    @media (max-width: 700px) {
        .ccv-wrapper {
            margin-top: 5px;
        }

        .ccv-header {
            padding: 23px 20px;
        }

        .ccv-header h2 {
            font-size: 21px;
        }

        .ccv-card {
            padding: 20px 17px;
        }

        .ccv-grid {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .ccv-field.full-width {
            grid-column: auto;
        }

        .ccv-card h5 {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .answer-options {
            gap: 9px;
        }

        .answer-option {
            flex: 1;
            min-width: 90px;
        }

        .answer-options.vertical {
            flex-direction: column;
            align-items: stretch;
        }

        .answer-options.vertical .answer-option {
            justify-content: flex-start;
            width: 100%;
        }

        .ccv-actions {
            justify-content: stretch;
        }

        .btn-submit {
            width: 100%;
        }
    }

    @media (max-width: 400px) {
        .ccv-header .ccv-badge {
            font-size: 10px;
        }

        .question-title {
            font-size: 13px;
        }
    }
</style>

<div class="ccv-wrapper">

    {{-- HEADER --}}
    <div class="ccv-header">
        <h2>Formulir CCV</h2>
        <p>Critical Control Verification</p>

        <span class="ccv-badge">
            🛡️ Critical Control Verification - UID KALSELTENG
        </span>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success ccv-alert">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger ccv-alert">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger ccv-alert">
            <strong>Periksa kembali formulir:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pekerja.ccv.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="ccvForm">

        @csrf

        {{-- 1. IDENTITAS OBSERVER --}}
        <div class="ccv-card">

            <h5>
                <span class="section-number">01</span>
                Identitas Observer
            </h5>

            <div class="ccv-grid">

                <div class="ccv-field">
                    <label class="ccv-label">
                        Unit Induk <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           class="ccv-input"
                           value="UID KALSELTENG"
                           disabled>
                </div>

                <div class="ccv-field">
                    <label class="ccv-label">
                        Nama Observer <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="observer_name"
                           class="ccv-input"
                           placeholder="Masukkan nama observer"
                           value="{{ old('observer_name', auth()->user()->name) }}"
                           required>
                </div>

                <div class="ccv-field">
                    <label class="ccv-label">
                        Perusahaan <span class="required-mark">*</span>
                    </label>

                    <select name="company" class="ccv-select" required>
                        <option value="">Pilih Perusahaan</option>

                        @foreach([
                            'PLN',
                            'PLN NUSA DAYA',
                            'PT GRAHA ARTHA',
                            'PT TUBP',
                            'Other'
                        ] as $company)

                            <option value="{{ $company }}"
                                {{ old('company') == $company ? 'selected' : '' }}>
                                {{ $company }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <div class="ccv-field">
                    <label class="ccv-label">
                        Jabatan/Posisi Observer
                        <span class="required-mark">*</span>
                    </label>

                    <select name="position" class="ccv-select" required>
                        <option value="">Pilih Jabatan</option>

                        @foreach([
                            'Pengawas/Koordinator Pekerjaan',
                            'Pelaksana Pekerjaan',
                            'K3L',
                            'Management (Asisten Manager Keatas)',
                            'Other'
                        ] as $position)

                            <option value="{{ $position }}"
                                {{ old('position') == $position ? 'selected' : '' }}>
                                {{ $position }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <div class="ccv-field full-width">
                    <label class="ccv-label">
                        Pekerjaan pada Bagian
                    </label>

                    <input type="text"
                           name="department"
                           class="ccv-input"
                           placeholder="Masukkan bagian pekerjaan"
                           value="{{ old('department') }}">
                </div>

            </div>
        </div>

        {{-- 2. INFORMASI PEKERJAAN --}}
        <div class="ccv-card">

            <h5>
                <span class="section-number">02</span>
                Informasi Pekerjaan
            </h5>

            <div class="ccv-grid">

                <div class="ccv-field">
                    <label class="ccv-label">
                        Lokasi Pekerjaan
                        <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="work_location"
                           class="ccv-input"
                           placeholder="Masukkan lokasi pekerjaan"
                           value="{{ old('work_location') }}"
                           required>
                </div>

                <div class="ccv-field">
                    <label class="ccv-label">
                        Nomor Work Order (WO/PO/WP)
                    </label>

                    <input type="text"
                           name="work_order_number"
                           class="ccv-input"
                           placeholder="Masukkan nomor WO/PO/WP"
                           value="{{ old('work_order_number') }}">
                </div>

                <div class="ccv-field">
                    <label class="ccv-label">
                        Nama Unit Pelaksana
                        <span class="required-mark">*</span>
                    </label>

                    <select name="executing_unit" class="ccv-select" required>
                        <option value="">Pilih Unit Pelaksana</option>

                        @foreach([
                            'UP3 BANJARMASIN',
                            'UP3 PALANGKARAYA',
                            'UP3 BARABAI',
                            'UP3 KUALA KAPUAS',
                            'UP3 TANAH BUMBU',
                            'UP3 PANGKALAN BUN',
                            'UP2D KALSELTENG',
                            'UP2K KALSEL',
                            'UP2K KALTENG',
                            'KANTOR UID KALSELTENG'
                        ] as $unit)

                            <option value="{{ $unit }}"
                                {{ old('executing_unit') == $unit ? 'selected' : '' }}>
                                {{ $unit }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <div class="ccv-field">
                    <label class="ccv-label">
                        Nama Unit Layanan Pelanggan
                    </label>

                    <input type="text"
                           name="customer_service_unit"
                           class="ccv-input"
                           placeholder="Masukkan nama unit layanan pelanggan"
                           value="{{ old('customer_service_unit') }}">
                </div>

            </div>
        </div>

        {{-- 3. RC - RISK CONTAINMENT --}}
        <div class="ccv-card">

            <h5>
                <span class="section-number">03</span>
                RC - Risk Containment
            </h5>

            {{-- PENJELASAN RC --}}
            <div class="risk-description">

                <p>
                    Mohon pengisian berdasarkan <strong>kondisi aktual di lapangan</strong>.
                    Observasi ini dilakukan untuk mendapatkan data risiko yang terjadi
                    di lapangan/area pekerjaan. Data yang Anda masukkan akan sangat
                    berguna dalam tujuan kita <strong>mengendalikan risiko pekerjaan
                    dan mencegah terjadinya kecelakaan kerja.</strong>
                </p>

                <p>
                    <strong>Catatan Pengisian:</strong><br>
                    <strong>Ya</strong>, apabila pada aktual pekerjaan sesuai dengan
                    list observasi yang ditanyakan.<br>
                    <strong>Tidak</strong>, apabila pada aktual pekerjaan tidak sesuai
                    dengan list observasi yang ditanyakan.
                </p>

            </div>

            {{-- PERTANYAAN PENGAWAS --}}
            <div class="question">

                <div class="question-title">
                    Terdapat personil yang berperan sebagai fungsi pengawas
                    pada pekerjaan
                    <span class="required-mark">*</span>
                </div>

                <div class="answer-options vertical">

                    <label class="answer-option">
                        <input type="radio"
                               name="supervisor_present"
                               value="ya"
                               {{ old('supervisor_present', 'ya') == 'ya' ? 'checked' : '' }}
                               required>
                        <span>YA</span>
                    </label>

                    <label class="answer-option">
                        <input type="radio"
                               name="supervisor_present"
                               value="tidak"
                               {{ old('supervisor_present') == 'tidak' ? 'checked' : '' }}
                               required>
                        <span>TIDAK</span>
                    </label>

                </div>
            </div>

            {{-- PILIH RC --}}
            <div class="question">

                <div class="question-title">
                    Pilih salah satu dari Top 3 Risk Containment (RC)
                    yang akan Anda observasi.
                    <span class="required-mark">*</span>
                </div>

                <div class="answer-options vertical">

                    <label class="answer-option">
                        <input type="radio"
                               name="selected_rc"
                               value="RC1"
                               {{ old('selected_rc', 'RC1') == 'RC1' ? 'checked' : '' }}
                               required>

                        <span>
                            RC1 - Bekerja Pada Jaringan Tidak Bertegangan
                        </span>
                    </label>

                    <label class="answer-option">
                        <input type="radio"
                               name="selected_rc"
                               value="RC3"
                               {{ old('selected_rc') == 'RC3' ? 'checked' : '' }}
                               required>

                        <span>
                            RC3 - Bekerja Pada Jaringan Bertegangan
                        </span>
                    </label>

                </div>
            </div>

        </div>

        {{-- 4. RC1 --}}
        <div class="ccv-card rc-section" id="sectionRC1">

            <h5>
                <span class="section-number">04</span>
                RC1 - Bekerja Pada Jaringan Tidak Bertegangan
            </h5>

            <fieldset id="fieldsetRC1"
                      style="border:0;padding:0;margin:0;">

                @foreach($questions as $index => $question)

                    <div class="question">

                        <div class="question-title">
                            <span class="question-number">
                                {{ $index + 1 }}
                            </span>

                            {{ $question['text'] }}
                        </div>

                        <div class="answer-options">

                            <label class="answer-option">
                                <input type="radio"
                                       name="answers[{{ $question['key'] }}]"
                                       value="ya"
                                       {{ old('answers.'.$question['key']) == 'ya' ? 'checked' : '' }}
                                       required>

                                <span>Ya</span>
                            </label>

                            <label class="answer-option">
                                <input type="radio"
                                       name="answers[{{ $question['key'] }}]"
                                       value="tidak"
                                       {{ old('answers.'.$question['key']) == 'tidak' ? 'checked' : '' }}
                                       required>

                                <span>Tidak</span>
                            </label>

                        </div>

                        @if($question['evidence'])

                            <div class="evidence-box">

                                <label class="evidence-label">
                                    📷 Upload Foto Bukti
                                    <span class="required-mark">*</span>
                                </label>

                                <input type="file"
                                       name="evidence[{{ $question['evidence'] }}]"
                                       class="ccv-file"
                                       accept="image/*"
                                       required>

                                <small class="evidence-help">
                                    Unggah foto sebagai bukti pelaksanaan.
                                    Format gambar yang diperbolehkan.
                                </small>

                            </div>

                        @endif

                    </div>

                @endforeach

                {{-- DOKUMENTASI RC1 --}}
                <div class="documentation-question">

                    <div class="question-title">
                        📸 Dokumentasi Pelaksanaan Pekerjaan RC1
                    </div>

                    <div class="evidence-box">

                        <label class="evidence-label">
                            Upload Foto Pelaksanaan
                            <span class="required-mark">*</span>
                        </label>

                        <input type="file"
                               name="evidence[rc1_pelaksanaan]"
                               class="ccv-file"
                               accept="image/*"
                               required>

                        <small class="evidence-help">
                            Unggah foto dokumentasi pelaksanaan pekerjaan RC1.
                        </small>

                    </div>

                </div>

            </fieldset>
        </div>

        {{-- 5. RC3 --}}
        <div class="ccv-card rc-section" id="sectionRC3">

            <h5>
                <span class="section-number">05</span>
                RC3 - Selesai Pekerjaan
            </h5>

            <p style="font-size:13px;color:#475569;margin-bottom:20px;">
                Observasi CCV: Bekerja Pada Jaringan Bertegangan
            </p>

            <fieldset id="fieldsetRC3"
                      style="border:0;padding:0;margin:0;">

                <div class="question">

                    <div class="question-title">
                        {{ $rc3Question['text'] }}
                        <span class="required-mark">*</span>
                    </div>

                    <div class="answer-options vertical">

                        @foreach($rc3Question['options'] as $value => $label)

                            <label class="answer-option">

                                <input type="radio"
                                       name="rc3_answer"
                                       value="{{ $value }}"
                                       {{ old('rc3_answer') == $value ? 'checked' : '' }}
                                       required>

                                <span>{{ $label }}</span>

                            </label>

                        @endforeach

                    </div>

                </div>

            </fieldset>
        </div>

        {{-- TOMBOL KIRIM --}}
        <div class="ccv-actions">

            <button type="submit" class="btn-submit" id="submitButton">
                <span>✓</span>
                Kirim Laporan CCV
            </button>

        </div>

    </form>
</div>

{{-- JAVASCRIPT PILIHAN RC --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const rcRadios = document.querySelectorAll(
        'input[name="selected_rc"]'
    );

    const sectionRC1 = document.getElementById('sectionRC1');
    const sectionRC3 = document.getElementById('sectionRC3');

    const fieldsetRC1 = document.getElementById('fieldsetRC1');
    const fieldsetRC3 = document.getElementById('fieldsetRC3');

    function updateRiskSection() {

        const selected = document.querySelector(
            'input[name="selected_rc"]:checked'
        );

        const rc = selected ? selected.value : '';

        // Tampilkan hanya formulir RC yang dipilih.
        sectionRC1.style.display = rc === 'RC1' ? 'block' : 'none';
        sectionRC3.style.display = rc === 'RC3' ? 'block' : 'none';

        // Input pada RC yang tidak dipilih tidak ikut divalidasi/dikirim.
        fieldsetRC1.disabled = rc !== 'RC1';
        fieldsetRC3.disabled = rc !== 'RC3';
    }

    rcRadios.forEach(function (radio) {
        radio.addEventListener('change', updateRiskSection);
    });

    // Tampilkan formulir sesuai pilihan awal atau pilihan sebelumnya.
    updateRiskSection();

});
</script>

@endsection