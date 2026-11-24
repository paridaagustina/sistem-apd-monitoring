
@extends('layouts.app')

@section('title', 'Data Pekerja - APDMONITOR')

@section('content')

<style>
    .halaman-pekerja {
        color: #172b4d;
    }

    .halaman-pekerja * {
        box-sizing: border-box;
    }

    .pekerja-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
    }

    .pekerja-header h2 {
        margin: 0 0 5px;
        font-size: 20px;
        font-weight: 800;
    }

    .pekerja-header p {
        margin: 0;
        color: #8291a8;
        font-size: 12px;
    }

    .btn-tambah-pekerja {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 13px;
        background: #2563eb;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
    }

    .btn-tambah-pekerja:hover {
        background: #1d4ed8;
    }

    .pekerja-alert {
        padding: 11px 14px;
        border-radius: 9px;
        margin-bottom: 13px;
        font-size: 12px;
        font-weight: 600;
    }

    .alert-success {
        background: #e5f8ef;
        color: #047857;
    }

    .alert-error {
        background: #fff1f2;
        color: #be123c;
    }

    .pekerja-card {
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 13px;
        padding: 15px;
        box-shadow: 0 5px 20px #25385808;
    }

    .pekerja-card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 13px;
    }

    .pekerja-card-heading h3 {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 800;
    }

    .pekerja-card-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 11px;
    }

    .jumlah-pekerja {
        padding: 7px 10px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
    }

    /* PENCARIAN PEKERJA */
    .pekerja-search {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
        margin: 16px 0;
    }

    .pekerja-search-input {
        flex: 1;
        min-width: 220px;
        height: 38px;
        padding: 0 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        outline: none;
        background: #fff;
        color: #334155;
        font-size: 11px;
        transition: .2s;
    }

    .pekerja-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .btn-cari-pekerja {
        height: 38px;
        padding: 0 16px;
        border: none;
        border-radius: 8px;
        background: #2563eb;
        color: white;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s;
    }

    .btn-cari-pekerja:hover {
        background: #1d4ed8;
    }

    .btn-reset-pekerja {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 38px;
        padding: 0 14px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #64748b;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        transition: .2s;
    }

    .btn-reset-pekerja:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .pekerja-table-wrap {
        overflow-x: auto;
        border: 1px solid #edf1f6;
        border-radius: 9px;
    }

    .pekerja-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 450px;
    }

    .pekerja-table th {
        padding: 9px 12px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-align: left;
        border-bottom: 1px solid #edf1f6;
    }

    .pekerja-table td {
        padding: 7px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 12px;
    }

    .pekerja-table tbody tr:last-child td {
        border-bottom: none;
    }

    .pekerja-table tbody tr:hover {
        background: #f8fbff;
    }

    .identitas-pekerja {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .foto-pekerja,
    .foto-default {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        background: #f1f5f9;
    }

    .foto-default {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #94a3b8;
        font-size: 19px;
    }

    .nama-pekerja {
        color: #172b4d;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .jabatan-pekerja {
        color: #8291a8;
        font-size: 11px;
    }

    .btn-edit-pekerja {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 10px;
        background: #fff4dc;
        color: #a16207;
        border-radius: 7px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .btn-edit-pekerja:hover {
        background: #ffebbd;
    }

    .pekerja-empty {
        padding: 35px 15px !important;
        text-align: center;
        color: #94a3b8;
    }

    .pekerja-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #334155;
    }

    @media(max-width: 600px) {
        .pekerja-card {
            padding: 11px;
        }

        .pekerja-header {
            align-items: stretch;
        }

        .btn-tambah-pekerja {
            justify-content: center;
        }

        .pekerja-search {
            flex-direction: column;
            align-items: stretch;
        }

        .pekerja-search-input {
            width: 100%;
            min-width: 100%;
        }

        .btn-cari-pekerja,
        .btn-reset-pekerja {
            width: 100%;
        }
    }
</style>

<div class="halaman-pekerja">

    {{-- HEADER --}}
    <div class="pekerja-header">
        <div>
            <h2>Data Pekerja</h2>
            <p>Informasi nama dan jabatan pekerja lapangan.</p>
        </div>

        <a href="{{ route('admin.workers.create') }}"
           class="btn-tambah-pekerja">
            ＋ Tambah Pekerja
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="pekerja-alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pekerja-alert alert-error">
            ⚠ {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="pekerja-alert alert-error">
            ⚠ Terdapat kesalahan. Silakan periksa kembali data Anda.
        </div>
    @endif

    {{-- DAFTAR PEKERJA --}}
    <div class="pekerja-card">

        <div class="pekerja-card-heading">
            <div>
                <h3>Daftar Data Pekerja</h3>
                <p>Informasi foto, nama, dan jabatan pekerja lapangan.</p>
            </div>

            <span class="jumlah-pekerja">
                {{ $workers->count() }} Data Pekerja
            </span>
        </div>

        {{-- FORM PENCARIAN --}}
        <form method="GET"
              action="{{ route('admin.workers.index') }}"
              class="pekerja-search">

            <input
                type="text"
                name="search"
                class="pekerja-search-input"
                value="{{ $search ?? request('search') }}"
                placeholder="Cari nama atau jabatan pekerja..."
                autocomplete="off"
            >

            <button type="submit" class="btn-cari-pekerja">
                🔍 Cari
            </button>

            @if(request('search'))
                <a href="{{ route('admin.workers.index') }}"
                   class="btn-reset-pekerja">
                    Reset
                </a>
            @endif

        </form>

        <div class="pekerja-table-wrap">

            <table class="pekerja-table">

                <thead>
                    <tr>
                        <th>Nama Pekerja</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($workers as $worker)

                        <tr>

                            {{-- FOTO DAN NAMA --}}
                            <td>
                                <div class="identitas-pekerja">

                                    @if($worker->photo && Storage::disk('public')->exists($worker->photo))
                                        <img
                                            src="{{ asset('storage/' . $worker->photo) }}"
                                            alt="Foto {{ $worker->name }}"
                                            class="foto-pekerja"
                                        >
                                    @else
                                        <div class="foto-default">
                                            👤
                                        </div>
                                    @endif

                                    <div class="nama-pekerja">
                                        {{ $worker->name }}
                                    </div>

                                </div>
                            </td>

                            {{-- JABATAN --}}
                            <td>
                                <span class="jabatan-pekerja">
                                    {{ $worker->position ?: '-' }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td>
                                <div style="display: flex; align-items: center; gap: 7px;">

                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('admin.workers.edit', $worker) }}"
                                       class="btn-edit-pekerja">
                                        ✏️ Edit
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('admin.workers.destroy', $worker) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data pekerja {{ addslashes($worker->name) }}? Data yang dihapus tidak dapat dikembalikan.');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            style="
                                                padding: 7px 10px;
                                                background: #fee2e2;
                                                color: #dc2626;
                                                border: none;
                                                border-radius: 7px;
                                                font-size: 11px;
                                                font-weight: 800;
                                                cursor: pointer;
                                            ">
                                            🗑 Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="pekerja-empty">
                                <strong>
                                    @if(request('search'))
                                        Data Pekerja Tidak Ditemukan
                                    @else
                                        Belum Ada Data Pekerja
                                    @endif
                                </strong>

                                @if(request('search'))
                                    Tidak ditemukan pekerja dengan nama atau jabatan
                                    "{{ request('search') }}".
                                @else
                                    Silakan tambahkan data pekerja terlebih dahulu.
                                @endif
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
