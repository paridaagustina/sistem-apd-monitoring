
@extends('layouts.app')

@section('content')
<style>
    .form-apd { max-width: 760px; margin: 0 auto; color: #263342; }
    .form-apd .kartu {
        background: white; border: 1px solid #e7ebef; border-radius: 14px;
        padding: 24px; box-shadow: 0 5px 20px #2538580a;
    }
    .form-apd h2 { margin: 0 0 8px; font-size: 25px; }
    .form-apd .deskripsi { color: #687586; margin: 0 0 24px; font-size: 14px; }
    .form-apd .grup { margin-bottom: 19px; }
    .form-apd label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; }
    .form-apd input[type="text"], .form-apd select {
        width: 100%; padding: 12px; border: 1px solid #d7dee7;
        border-radius: 9px; background: white; font-size: 14px;
    }
    .form-apd input:focus, .form-apd select:focus {
        outline: 2px solid #b8e5d8; border-color: #167d69;
    }
    .form-apd .bantuan { display: block; color: #687586; font-size: 12px; margin-top: 6px; }
    .form-apd .kesalahan { color: #b42318; font-size: 12px; margin-top: 6px; }
    .form-apd .aksi { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 25px; }
    .form-apd .tombol {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 11px 16px; border-radius: 9px; border: 0;
        text-decoration: none; cursor: pointer; font-weight: 700; font-size: 13px;
    }
    .form-apd .simpan { background: #167d69; color: white; }
    .form-apd .batal { background: #edf1f5; color: #344054; }
    @media(max-width: 600px) {
        .form-apd .kartu { padding: 17px; }
        .form-apd .aksi .tombol { flex: 1; }
    }
</style>

<div class="form-apd">
    <div class="kartu">
        <h2>Tambah Jenis APD</h2>
        <p class="deskripsi">Masukkan informasi jenis APD yang akan digunakan.</p>

        <form action="{{ route('admin.apd-items.store') }}" method="POST">
            @csrf

            <div class="grup">
                <label for="name">Nama APD</label>
                <input id="name" name="name" type="text"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Helm Keselamatan" required maxlength="100">
                @error('name') <div class="kesalahan">{{ $message }}</div> @enderror
            </div>

            <div class="grup">
                <label for="code">Kode APD</label>
                <input id="code" name="code" type="text"
                       value="{{ old('code') }}"
                       placeholder="Contoh: helmet" required maxlength="50">
                <span class="bantuan">
                    Gunakan huruf, angka, tanda hubung (-), atau garis bawah (_).
                    Kode harus unik.
                </span>
                @error('code') <div class="kesalahan">{{ $message }}</div> @enderror
            </div>

            <div class="grup">
                <label for="is_required">Kewajiban Penggunaan</label>
                <select id="is_required" name="is_required" required>
                    <option value="1" @selected(old('is_required', '1') == '1')>Wajib digunakan</option>
                    <option value="0" @selected(old('is_required') === '0')>Tidak wajib</option>
                </select>
                @error('is_required') <div class="kesalahan">{{ $message }}</div> @enderror
            </div>

            <div class="grup">
                <label for="is_active">Status APD</label>
                <select id="is_active" name="is_active" required>
                    <option value="1" @selected(old('is_active', '1') == '1')>Aktif</option>
                    <option value="0" @selected(old('is_active') === '0')>Nonaktif</option>
                </select>
                @error('is_active') <div class="kesalahan">{{ $message }}</div> @enderror
            </div>

            <div class="aksi">
                <button type="submit" class="tombol simpan">Simpan APD</button>
                <a href="{{ route('admin.apd-items.index') }}" class="tombol batal">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
