
@extends('layouts.app')

@section('content')
<style>
    .pekerja { color: #263342; }
    .pekerja .kepala {
        display: flex; justify-content: space-between; align-items: center;
        gap: 12px; flex-wrap: wrap; margin-bottom: 20px;
    }
    .pekerja h2 { margin: 0 0 6px; }
    .pekerja p { color: #687586; margin: 0; font-size: 14px; }
    .pekerja .kartu {
        background: white; padding: 20px; border: 1px solid #e7ebef;
        border-radius: 14px; overflow: hidden;
    }
    .pekerja .tabel-bungkus { overflow-x: auto; }
    .pekerja table { width: 100%; min-width: 650px; border-collapse: collapse; }
    .pekerja th, .pekerja td {
        padding: 13px 10px; text-align: left; font-size: 13px;
        border-bottom: 1px solid #edf0f3;
    }
    .pekerja th { background: #f8fafb; color: #687586; }
    .pekerja .tombol {
        display: inline-block; padding: 9px 12px; border-radius: 8px;
        border: 0; cursor: pointer; text-decoration: none;
        font-size: 12px; font-weight: 700;
    }
    .pekerja .utama { background: #167d69; color: white; }
    .pekerja .edit { background: #fff1d6; color: #895b00; }
    .pekerja .status { background: #edf1f5; color: #344054; }
    .pekerja .aktif { color: #167247; background: #dcfce7; }
    .pekerja .nonaktif { color: #a12b2b; background: #fee2e2; }
    .pekerja .label {
        display: inline-block; padding: 5px 9px;
        border-radius: 20px; font-size: 12px; font-weight: 700;
    }
    .pekerja .notifikasi {
        background: #e5f7ed; color: #176c43;
        padding: 12px 15px; border-radius: 9px; margin-bottom: 16px;
    }
    .pekerja .aksi { display: flex; gap: 6px; align-items: center; }
    .pekerja form { margin: 0; }
    @media(max-width: 600px) {
        .pekerja .kartu { padding: 12px; }
        .pekerja .kepala .utama { width: 100%; text-align: center; }
    }
</style>

<div class="pekerja">
    <div class="kepala">
        <div>
            <h2>Data Pekerja</h2>
            <p>Kelola identitas pekerja yang akan diperiksa.</p>
        </div>
        <a href="{{ route('admin.workers.create') }}" class="tombol utama">
            + Tambah Pekerja
        </a>
    </div>

    @if(session('success'))
        <div class="notifikasi">{{ session('success') }}</div>
    @endif

    <div class="kartu">
        <div class="tabel-bungkus">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Pekerja</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($workers as $worker)
                        <tr>
                            <td>{{ $workers->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $worker->worker_code }}</strong></td>
                            <td>{{ $worker->name }}</td>
                            <td>{{ $worker->department ?: '-' }}</td>
                            <td>{{ $worker->position ?: '-' }}</td>
                            <td>
                                <span class="label {{ $worker->is_active ? 'aktif' : 'nonaktif' }}">
                                    {{ $worker->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="aksi">
                                    <a class="tombol edit"
                                       href="{{ route('admin.workers.edit', $worker) }}">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.workers.toggle-status', $worker) }}"
                                          onsubmit="return confirm('Yakin ingin mengubah status pekerja ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="tombol status" type="submit">
                                            {{ $worker->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada data pekerja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:18px">
            {{ $workers->links() }}
        </div>
    </div>
</div>
@endsection
