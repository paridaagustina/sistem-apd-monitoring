
@extends('layouts.app')

@section('content')
<style>
    .master-apd { color: #263342; }
    .master-apd .judul-halaman {
        display: flex; justify-content: space-between; align-items: center;
        gap: 16px; flex-wrap: wrap; margin-bottom: 22px;
    }
    .master-apd h2 { margin: 0 0 6px; font-size: 25px; }
    .master-apd .deskripsi { margin: 0; color: #687586; font-size: 14px; }
    .master-apd .tombol {
        display: inline-flex; align-items: center; justify-content: center;
        gap: 6px; padding: 10px 15px; border: 0; border-radius: 9px;
        text-decoration: none; cursor: pointer; font-size: 13px; font-weight: 700;
    }
    .master-apd .tombol-utama { background: #167d69; color: white; }
    .master-apd .tombol-edit { background: #fff1d6; color: #895b00; }
    .master-apd .tombol-status { background: #edf1f5; color: #344054; }
    .master-apd .kartu-apd {
        background: white; border: 1px solid #e7ebef; border-radius: 14px;
        padding: 20px; box-shadow: 0 5px 20px #2538580a;
    }
    .master-apd .notifikasi {
        padding: 13px 16px; border-radius: 9px; margin-bottom: 16px;
        background: #e5f7ed; color: #176c43;
    }
    .master-apd .tabel-bungkus { overflow-x: auto; }
    .master-apd table { width: 100%; border-collapse: collapse; min-width: 680px; }
    .master-apd th, .master-apd td {
        text-align: left; padding: 14px 12px; border-bottom: 1px solid #edf0f3;
        font-size: 13px; vertical-align: middle;
    }
    .master-apd th { color: #687586; background: #f8fafb; font-weight: 700; }
    .master-apd .kode {
        display: inline-block; background: #f1f5f9; border-radius: 6px;
        padding: 5px 8px; font-family: monospace; color: #475569;
    }
    .master-apd .label-status {
        display: inline-block; padding: 5px 9px; border-radius: 20px;
        font-size: 12px; font-weight: 700;
    }
    .master-apd .aktif { color: #167247; background: #dcfce7; }
    .master-apd .nonaktif { color: #a12b2b; background: #fee2e2; }
    .master-apd .aksi { display: flex; gap: 7px; align-items: center; }
    .master-apd form { margin: 0; }
    .master-apd .kosong { padding: 30px; text-align: center; color: #687586; }
    .master-apd .pagination { margin-top: 18px; }
    @media (max-width: 600px) {
        .master-apd .judul-halaman { align-items: stretch; }
        .master-apd .judul-halaman .tombol { width: 100%; }
        .master-apd .kartu-apd { padding: 12px; }
    }
</style>

<div class="master-apd">
    <div class="judul-halaman">
        <div>
            <h2>Master APD</h2>
            <p class="deskripsi">
                Kelola jenis alat pelindung diri yang digunakan dalam monitoring.
            </p>
        </div>

        <a href="{{ route('admin.apd-items.create') }}"
           class="tombol tombol-utama">
            + Tambah Jenis APD
        </a>
    </div>

    @if (session('success'))
        <div class="notifikasi">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="notifikasi" style="background:#fee2e2;color:#991b1b">
            Terdapat kesalahan. Silakan periksa kembali data Anda.
        </div>
    @endif

    <div class="kartu-apd">
        <div class="tabel-bungkus">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama APD</th>
                        <th>Kode</th>
                        <th>Kewajiban</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $items->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td><span class="kode">{{ $item->code }}</span></td>
                            <td>
                                {{ $item->is_required ? 'Wajib' : 'Tidak wajib' }}
                            </td>
                            <td>
                                @if ($item->is_active)
                                    <span class="label-status aktif">Aktif</span>
                                @else
                                    <span class="label-status nonaktif">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="aksi">
                                    <a class="tombol tombol-edit"
                                       href="{{ route('admin.apd-items.edit', $item) }}">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.apd-items.toggle-status', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin {{ $item->is_active ? 'menonaktifkan' : 'mengaktifkan' }} APD ini?')">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="tombol tombol-status">
                                            {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="kosong">
                                Belum ada data APD. Silakan tambahkan jenis APD.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection

