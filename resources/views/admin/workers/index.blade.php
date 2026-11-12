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

    /* HEADER */
    .pekerja-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 25px;
    }

    .pekerja-title {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .pekerja-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf1ff;
        border-radius: 14px;
        font-size: 25px;
        flex-shrink: 0;
    }

    .pekerja-title h2 {
        margin: 0 0 5px;
        font-size: 24px;
        font-weight: 800;
    }

    .pekerja-title p {
        margin: 0;
        color: #8291a8;
        font-size: 13px;
    }

    /* BUTTON */
    .halaman-pekerja .btn-pekerja {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 14px;
        border: none;
        border-radius: 9px;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 12px;
        font-weight: 800;
        transition: .2s ease;
        white-space: nowrap;
    }

    .btn-tambah-pekerja {
        background: #2563eb;
        color: white;
        box-shadow: 0 4px 12px #2563eb25;
    }

    .btn-tambah-pekerja:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .btn-edit-pekerja {
        background: #fff4dc;
        color: #a16207;
    }

    .btn-edit-pekerja:hover {
        background: #ffebbd;
    }

    .btn-ubah-status {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-ubah-status:hover {
        background: #e2e8f0;
    }

    /* STATISTIK */
    .pekerja-statistik {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 23px;
    }

    .pekerja-stat-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 19px;
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        box-shadow: 0 4px 15px #25385808;
    }

    .stat-icon-pekerja {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-total {
        background: #eaf1ff;
    }

    .stat-aktif {
        background: #e5f8ef;
    }

    .stat-nonaktif {
        background: #fff1e8;
    }

    .stat-info-pekerja small {
        display: block;
        color: #8291a8;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .stat-info-pekerja strong {
        display: block;
        color: #172b4d;
        font-size: 24px;
        font-weight: 800;
    }

    /* ALERT */
    .pekerja-alert {
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 17px;
        font-size: 13px;
        font-weight: 600;
    }

    .alert-success {
        background: #e5f8ef;
        color: #047857;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }

    /* TABLE CARD */
    .pekerja-card {
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 16px;
        padding: 21px;
        box-shadow: 0 5px 20px #25385808;
    }

    .pekerja-card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .pekerja-card-heading h3 {
        margin: 0 0 5px;
        font-size: 16px;
        font-weight: 800;
    }

    .pekerja-card-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 11px;
    }

    .jumlah-pekerja {
        padding: 7px 11px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    /* TABLE */
    .pekerja-table-wrap {
        overflow-x: auto;
        border: 1px solid #edf1f6;
        border-radius: 11px;
    }

    .halaman-pekerja table {
        width: 100%;
        min-width: 780px;
        border-collapse: collapse;
    }

    .halaman-pekerja th {
        padding: 15px 13px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #edf1f6;
    }

    .halaman-pekerja td {
        padding: 15px 13px;
        color: #475569;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .halaman-pekerja tbody tr:last-child td {
        border-bottom: none;
    }

    .halaman-pekerja tbody tr:hover {
        background: #f8fbff;
    }

    .nomor-pekerja {
        color: #94a3b8;
        font-weight: 700;
    }

    .kode-pekerja {
        display: inline-block;
        padding: 6px 9px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 7px;
        font-family: monospace;
        font-size: 11px;
        font-weight: 800;
    }

    .nama-pekerja {
        color: #172b4d;
        font-weight: 800;
    }

    /* BADGE */
    .badge-pekerja {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-aktif {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-nonaktif {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* ACTION */
    .aksi-pekerja {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .aksi-pekerja form {
        margin: 0;
    }

    /* EMPTY STATE */
    .pekerja-empty {
        padding: 55px 20px !important;
        text-align: center;
    }

    .pekerja-empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf1ff;
        border-radius: 20px;
        font-size: 32px;
    }

    .pekerja-empty strong {
        display: block;
        color: #334155;
        font-size: 14px;
        margin-bottom: 7px;
    }

    .pekerja-empty p {
        margin: 0;
        color: #94a3b8;
        font-size: 12px;
    }

    /* PAGINATION */
    .pekerja-pagination {
        margin-top: 20px;
    }

    @media(max-width: 850px) {
        .pekerja-statistik {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 600px) {
        .pekerja-header {
            align-items: stretch;
        }

        .pekerja-header > a {
            width: 100%;
        }

        .pekerja-statistik {
            grid-template-columns: 1fr;
        }

        .pekerja-card {
            padding: 13px;
        }

        .pekerja-title h2 {
            font-size: 20px;
        }
    }
</style>


<div class="halaman-pekerja">

    {{-- HEADER --}}
    <div class="pekerja-header">

        <div class="pekerja-title">

            <div class="pekerja-icon">
                👷
            </div>

            <div>
                <h2>Data Pekerja</h2>
                <p>Kelola identitas pekerja yang akan diperiksa.</p>
            </div>

        </div>

        <a href="{{ route('admin.workers.create') }}"
           class="btn-pekerja btn-tambah-pekerja">
            <span>＋</span>
            Tambah Pekerja
        </a>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="pekerja-alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="pekerja-alert alert-error">
            ⚠ Terdapat kesalahan. Silakan periksa kembali data Anda.
        </div>
    @endif


    {{-- STATISTIK --}}
    <div class="pekerja-statistik">

        <div class="pekerja-stat-card">
            <div class="stat-icon-pekerja stat-total">
                👥
            </div>

            <div class="stat-info-pekerja">
                <small>Total Pekerja</small>
                <strong>{{ $workers->total() }}</strong>
            </div>
        </div>


        <div class="pekerja-stat-card">
            <div class="stat-icon-pekerja stat-aktif">
                ✅
            </div>

            <div class="stat-info-pekerja">
                <small>Pekerja Aktif</small>
                <strong>
                    {{ $workers->getCollection()->where('is_active', true)->count() }}
                </strong>
            </div>
        </div>


        <div class="pekerja-stat-card">
            <div class="stat-icon-pekerja stat-nonaktif">
                ⏸️
            </div>

            <div class="stat-info-pekerja">
                <small>Pekerja Nonaktif</small>
                <strong>
                    {{ $workers->getCollection()->where('is_active', false)->count() }}
                </strong>
            </div>
        </div>

    </div>


    {{-- DAFTAR PEKERJA --}}
    <div class="pekerja-card">

        <div class="pekerja-card-heading">

            <div>
                <h3>Daftar Data Pekerja</h3>
                <p>Informasi identitas dan status pekerja lapangan.</p>
            </div>

            <span class="jumlah-pekerja">
                {{ $workers->total() }} Data Pekerja
            </span>

        </div>


        <div class="pekerja-table-wrap">

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

                            <td class="nomor-pekerja">
                                {{ $workers->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <span class="kode-pekerja">
                                    {{ $worker->worker_code }}
                                </span>
                            </td>

                            <td>
                                <span class="nama-pekerja">
                                    {{ $worker->name }}
                                </span>
                            </td>

                            <td>
                                {{ $worker->department ?: '-' }}
                            </td>

                            <td>
                                {{ $worker->position ?: '-' }}
                            </td>

                            <td>
                                @if($worker->is_active)
                                    <span class="badge-pekerja badge-aktif">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="badge-pekerja badge-nonaktif">
                                        ● Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>

                                <div class="aksi-pekerja">

                                    <a class="btn-pekerja btn-edit-pekerja"
                                       href="{{ route('admin.workers.edit', $worker) }}">
                                        ✏️ Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.workers.toggle-status', $worker) }}"
                                        onsubmit="return confirm('Yakin ingin mengubah status pekerja ini?')">

                                        @csrf
                                        @method('PATCH')

                                        <button class="btn-pekerja btn-ubah-status"
                                                type="submit">

                                            {{ $worker->is_active
                                                ? '⏸️ Nonaktifkan'
                                                : '▶️ Aktifkan' }}

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="pekerja-empty">

                                <div class="pekerja-empty-icon">
                                    👷
                                </div>

                                <strong>Belum Ada Data Pekerja</strong>

                                <p>
                                    Data pekerja belum tersedia.
                                    Silakan tambahkan data pekerja terlebih dahulu.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($workers->hasPages())
            <div class="pekerja-pagination">
                {{ $workers->links() }}
            </div>
        @endif

    </div>

</div>

@endsection