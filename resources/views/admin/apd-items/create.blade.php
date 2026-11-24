
@extends('layouts.app')

@section('title', 'Tambah Jenis APD - APDMONITOR')
@section('page-heading', 'Tambah Jenis APD')

@section('content')

<style>
    .form-apd-page {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        color: #334155;
        padding-bottom: 25px;
    }

    /* HEADER */
    .form-apd-header {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 27px 30px;
        margin-bottom: 22px;
        border-radius: 18px;
        color: #fff;
        background: linear-gradient(120deg, #1747bd, #3678ee);
        box-shadow: 0 10px 25px rgba(37, 99, 235, .15);
    }

    .form-apd-header::after {
        content: "";
        position: absolute;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        right: -45px;
        top: -105px;
        background: rgba(255,255,255,.10);
    }

    .form-apd-header-content {
        position: relative;
        z-index: 2;
    }

    .form-apd-header h2 {
        margin: 0 0 8px;
        font-size: 25px;
        font-weight: 800;
        color: #fff;
    }

    .form-apd-header p {
        margin: 0;
        color: #e4edff;
        font-size: 13px;
        line-height: 1.7;
    }

    .form-apd-header-icon {
        position: relative;
        z-index: 2;
        width: 65px;
        height: 65px;
        min-width: 65px;
        display: grid;
        place-items: center;
        border-radius: 18px;
        background: rgba(255,255,255,.17);
        border: 1px solid rgba(255,255,255,.25);
        font-size: 32px;
    }

    /* FORM CARD */
    .form-apd-card {
        background: #fff;
        border: 1px solid #e7edf5;
        border-radius: 17px;
        padding: 30px;
        box-shadow: 0 5px 22px rgba(30, 64, 110, .045);
    }

    .form-apd-section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 19px;
        margin-bottom: 23px;
        border-bottom: 1px solid #edf1f7;
    }

    .form-apd-section-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 20px;
    }

    .form-apd-section-heading h3 {
        margin: 0 0 4px;
        color: #17345c;
        font-size: 15px;
        font-weight: 800;
    }

    .form-apd-section-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 12px;
    }

    /* INPUT */
    .form-apd-group {
        margin-bottom: 22px;
    }

    .form-apd-group label {
        display: block;
        margin-bottom: 9px;
        color: #263b58;
        font-size: 13px;
        font-weight: 750;
    }

    .form-apd-required {
        color: #ef4444;
        margin-left: 3px;
    }

    .form-apd-control-wrap {
        position: relative;
    }

    .form-apd-control-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
    }

    .form-apd-control {
        display: block;
        width: 100%;
        min-height: 49px;
        padding: 12px 15px 12px 43px;
        border: 1px solid #dce4ef;
        border-radius: 10px;
        background: #fbfcfe;
        color: #334155;
        font-family: inherit;
        font-size: 13px;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        box-sizing: border-box;
    }

    .form-apd-control::placeholder {
        color: #a0aec0;
    }

    .form-apd-control:hover {
        border-color: #b8c9e0;
        background: #fff;
    }

    .form-apd-control:focus {
        outline: none;
        border-color: #3977e8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .11);
    }

    .form-apd-control.is-invalid {
        border-color: #dc2626;
        background: #fffafa;
    }

    .form-apd-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .09);
    }

    select.form-apd-control {
        cursor: pointer;
        appearance: auto;
    }

    .form-apd-help {
        display: block;
        margin-top: 8px;
        color: #8492a6;
        font-size: 11px;
        line-height: 1.6;
    }

    .form-apd-error {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        margin-top: 7px;
        color: #dc2626;
        font-size: 11px;
        line-height: 1.5;
    }

    /* STATUS INFO */
    .form-apd-info {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 15px;
        margin-top: 5px;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        background: #f4f8ff;
        color: #45638f;
        font-size: 11px;
        line-height: 1.7;
    }

    .form-apd-info-icon {
        flex-shrink: 0;
        font-size: 16px;
    }

    /* BUTTON */
    .form-apd-actions {
        display: flex;
        align-items: center;
        gap: 11px;
        flex-wrap: wrap;
        padding-top: 22px;
        margin-top: 24px;
        border-top: 1px solid #edf1f7;
    }

    .form-apd-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 11px 19px;
        border: 0;
        border-radius: 9px;
        text-decoration: none;
        font-family: inherit;
        font-size: 12px;
        font-weight: 750;
        cursor: pointer;
        transition: all .2s ease;
    }

    .form-apd-save {
        color: #fff;
        background: linear-gradient(120deg, #078568, #0d9b78);
        box-shadow: 0 4px 10px rgba(13, 148, 113, .15);
    }

    .form-apd-save:hover {
        color: #fff;
        background: #06765e;
        transform: translateY(-2px);
        box-shadow: 0 7px 15px rgba(13, 148, 113, .2);
    }

    .form-apd-cancel {
        color: #475569;
        background: #edf2f7;
    }

    .form-apd-cancel:hover {
        color: #1e293b;
        background: #e2e8f0;
    }

    .form-apd-button:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .25);
        outline-offset: 3px;
    }

    /* RESPONSIVE */
    @media(max-width: 600px) {
        .form-apd-header {
            padding: 23px 20px;
            border-radius: 14px;
        }

        .form-apd-header h2 {
            font-size: 21px;
        }

        .form-apd-header p {
            font-size: 12px;
        }

        .form-apd-header-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            font-size: 25px;
        }

        .form-apd-card {
            padding: 20px 17px;
            border-radius: 14px;
        }

        .form-apd-section-heading {
            align-items: flex-start;
        }

        .form-apd-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .form-apd-button {
            width: 100%;
        }
    }
</style>

<div class="form-apd-page">

    {{-- HEADER --}}
    <div class="form-apd-header">

        <div class="form-apd-header-content">
            <h2>Tambah Jenis APD</h2>

            <p>
                Tambahkan jenis alat pelindung diri yang akan digunakan
                dalam sistem monitoring keselamatan kerja.
            </p>
        </div>

        <div class="form-apd-header-icon">
            🦺
        </div>

    </div>


    {{-- FORM --}}
    <div class="form-apd-card">

        <div class="form-apd-section-heading">

            <div class="form-apd-section-icon">
                ✏️
            </div>

            <div>
                <h3>Informasi Jenis APD</h3>
                <p>Lengkapi seluruh informasi APD di bawah ini.</p>
            </div>

        </div>


        <form action="{{ route('admin.apd-items.store') }}" method="POST">
            @csrf

            {{-- NAMA APD --}}
            <div class="form-apd-group">

                <label for="name">
                    Nama APD <span class="form-apd-required">*</span>
                </label>

                <div class="form-apd-control-wrap">

                    <span class="form-apd-control-icon">🛡️</span>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="form-apd-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Helm Keselamatan"
                        maxlength="100"
                        required
                    >

                </div>

                @error('name')
                    <div class="form-apd-error">
                        <span>⚠</span>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            </div>


            {{-- KODE APD --}}
            <div class="form-apd-group">

                <label for="code">
                    Kode APD <span class="form-apd-required">*</span>
                </label>

                <div class="form-apd-control-wrap">

                    <span class="form-apd-control-icon">#</span>

                    <input
                        id="code"
                        name="code"
                        type="text"
                        class="form-apd-control @error('code') is-invalid @enderror"
                        value="{{ old('code') }}"
                        placeholder="Contoh: helmet"
                        maxlength="50"
                        required
                    >

                </div>

                <span class="form-apd-help">
                    Gunakan huruf, angka, tanda hubung (-), atau garis bawah (_).
                    Kode harus unik dan digunakan sebagai identitas APD.
                </span>

                @error('code')
                    <div class="form-apd-error">
                        <span>⚠</span>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            </div>


            {{-- KEWAJIBAN --}}
            <div class="form-apd-group">

                <label for="is_required">
                    Kewajiban Penggunaan <span class="form-apd-required">*</span>
                </label>

                <div class="form-apd-control-wrap">

                    <span class="form-apd-control-icon">📌</span>

                    <select
                        id="is_required"
                        name="is_required"
                        class="form-apd-control @error('is_required') is-invalid @enderror"
                        required
                    >
                        <option value="1" @selected(old('is_required', '1') == '1')>
                            Wajib digunakan
                        </option>

                        <option value="0" @selected(old('is_required') === '0')>
                            Tidak wajib
                        </option>
                    </select>

                </div>

                @error('is_required')
                    <div class="form-apd-error">
                        <span>⚠</span>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            </div>


            {{-- STATUS APD --}}
            <div class="form-apd-group">

                <label for="is_active">
                    Status APD <span class="form-apd-required">*</span>
                </label>

                <div class="form-apd-control-wrap">

                    <span class="form-apd-control-icon">●</span>

                    <select
                        id="is_active"
                        name="is_active"
                        class="form-apd-control @error('is_active') is-invalid @enderror"
                        required
                    >
                        <option value="1" @selected(old('is_active', '1') == '1')>
                            Aktif
                        </option>

                        <option value="0" @selected(old('is_active') === '0')>
                            Nonaktif
                        </option>
                    </select>

                </div>

                @error('is_active')
                    <div class="form-apd-error">
                        <span>⚠</span>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

            </div>


            {{-- INFORMASI --}}
            <div class="form-apd-info">
                <span class="form-apd-info-icon">ℹ️</span>

                <span>
                    Pastikan nama dan kode APD sudah benar.
                    Kode APD harus berbeda dari kode APD lainnya agar
                    setiap jenis perlengkapan dapat dikenali oleh sistem.
                </span>
            </div>


            {{-- TOMBOL --}}
            <div class="form-apd-actions">

                <button type="submit" class="form-apd-button form-apd-save">
                    ✓ Simpan APD
                </button>

                <a
                    href="{{ route('admin.apd-items.index') }}"
                    class="form-apd-button form-apd-cancel"
                >
                    ← Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
