@extends('layouts.app')

@section('title', 'Data APD - APDMONITOR')

@section('content')

<style>
    .master-apd {
        color: #172b4d;
    }

    .master-apd * {
        box-sizing: border-box;
    }

    /* HEADER */
    .master-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 25px;
    }

    .master-title {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .master-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 25px;
        flex-shrink: 0;
    }

    .master-title h2 {
        margin: 0 0 5px;
        font-size: 24px;
        font-weight: 800;
    }

    .master-title p {
        margin: 0;
        color: #8291a8;
        font-size: 13px;
    }

    /* BUTTON */
    .master-apd .btn-apd {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        border: none;
        border-radius: 10px;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 12px;
        font-weight: 800;
        transition: .2s ease;
    }

    .btn-tambah {
        background: #2563eb;
        color: white;
        box-shadow: 0 4px 12px #2563eb25;
    }

    .btn-tambah:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-edit:hover {
        background: #dbeafe;
    }

    .btn-status {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-status:hover {
        background: #e2e8f0;
    }

    /* STATISTIK */
    .apd-statistik {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 23px;
    }

    .apd-stat-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 19px;
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 15px;
        box-shadow: 0 4px 15px #25385808;
    }

    .apd-stat-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 22px;
        flex-shrink: 0;
    }

    .icon-total {
        color: #2563eb;
        background: #eaf1ff;
    }

    .icon-aktif {
        color: #059669;
        background: #e5f8ef;
    }

    .icon-nonaktif {
        color: #dc6b32;
        background: #fff1e8;
    }

    .apd-stat-info small {
        display: block;
        color: #8291a8;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .apd-stat-info strong {
        display: block;
        color: #172b4d;
        font-size: 24px;
        font-weight: 800;
    }

    /* NOTIFICATION */
    .apd-alert {
        padding: 14px 17px;
        border-radius: 11px;
        margin-bottom: 17px;
        font-size: 13px;
        font-weight: 600;
    }

    .apd-alert-success {
        background: #e5f8ef;
        color: #047857;
        border: 1px solid #bbf7d0;
    }

    .apd-alert-error {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }

    /* TABLE CARD */
    .apd-table-card {
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 16px;
        padding: 21px;
        box-shadow: 0 5px 20px #25385808;
    }

    .apd-table-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .apd-table-heading h3 {
        margin: 0 0 5px;
        font-size: 16px;
        font-weight: 800;
    }

    .apd-table-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 11px;
    }

    .apd-total-label {
        padding: 7px 11px;
        border-radius: 20px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 11px;
        font-weight: 800;
    }

    /* TABLE */
    .apd-table-wrap {
        overflow-x: auto;
        border: 1px solid #edf1f6;
        border-radius: 11px;
    }

    .master-apd table {
        width: 100%;
        min-width: 720px;
        border-collapse: collapse;
    }

    .master-apd th {
        padding: 15px 14px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #edf1f6;
    }

    .master-apd td {
        padding: 15px 14px;
        color: #475569;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .master-apd tbody tr:last-child td {
        border-bottom: none;
    }

    .master-apd tbody tr:hover {
        background: #f8fbff;
    }

    .apd-number {
        color: #94a3b8;
        font-weight: 700;
    }

    .apd-name {
        color: #172b4d;
        font-weight: 800;
    }

    .apd-code {
        display: inline-block;
        padding: 6px 9px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 7px;
        font-family: monospace;
        font-size: 11px;
        font-weight: 700;
    }

    /* STATUS */
    .apd-badge {
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

    .badge-wajib {
        background: #eff6ff;
        color: #2563eb;
    }

    .badge-opsional {
        background: #f1f5f9;
        color: #64748b;
    }

    /* ACTION */
    .apd-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .apd-actions form {
        margin: 0;
    }

    /* EMPTY STATE */
    .apd-empty {
        text-align: center;
        padding: 55px 20px !important;
    }

    .apd-empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: #eaf1ff;
        color: #2563eb;
        box-shadow: 0 5px 15px #2563eb12;
        font-size: 32px;
    }

    .apd-empty strong {
        display: block;
        color: #334155;
        font-size: 14px;
        margin-bottom: 7px;
    }

    .apd-empty p {
        margin: 0;
        color: #94a3b8;
        font-size: 12px;
    }

    /* PAGINATION */
    .apd-pagination {
        margin-top: 20px;
    }

    @media(max-width: 850px) {
        .apd-statistik {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 600px) {
        .master-header {
            align-items: stretch;
        }

        .master-header > a {
            width: 100%;
        }

        .apd-statistik {
            grid-template-columns: 1fr;
        }

        .apd-table-card {
            padding: 13px;
        }

        .master-title h2 {
            font-size: 20px;
        }
    }
</style>


<div class="master-apd">

    {{-- HEADER --}}
    <div class="master-header">

        <div class="master-title">

            <div class="master-icon">
                🛡️
            </div>

            <div>
                <h2>Master APD</h2>
                <p>
                    Kelola jenis alat pelindung diri yang digunakan dalam monitoring.
                </p>
            </div>

        </div>

        <a href="{{ route('admin.apd-items.create') }}"
           class="btn-apd btn-tambah">
            <span>＋</span>
            Tambah Jenis APD
        </a>

    </div>


    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="apd-alert apd-alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="apd-alert apd-alert-error">
            ⚠ Terdapat kesalahan. Silakan periksa kembali data Anda.
        </div>
    @endif


    {{-- STATISTIK --}}
    <div class="apd-statistik">

        <div class="apd-stat-card">

            <div class="apd-stat-icon icon-total">
                📦
            </div>

            <div class="apd-stat-info">
                <small>Total Jenis APD</small>
                <strong>{{ $items->total() }}</strong>
            </div>

        </div>


        <div class="apd-stat-card">

            <div class="apd-stat-icon icon-aktif">
                ✅
            </div>

            <div class="apd-stat-info">
                <small>APD Aktif</small>
                <strong>
                    {{ $items->getCollection()->where('is_active', true)->count() }}
                </strong>
            </div>

        </div>


        <div class="apd-stat-card">

            <div class="apd-stat-icon icon-nonaktif">
                ⏸️
            </div>

            <div class="apd-stat-info">
                <small>APD Nonaktif</small>
                <strong>
                    {{ $items->getCollection()->where('is_active', false)->count() }}
                </strong>
            </div>

        </div>

    </div>


    {{-- TABEL MASTER APD --}}
    <div class="apd-table-card">

        <div class="apd-table-heading">

            <div>
                <h3>Daftar Jenis APD</h3>
                <p>Informasi dan pengelolaan alat pelindung diri.</p>
            </div>

            <span class="apd-total-label">
                {{ $items->total() }} Data APD
            </span>

        </div>


        <div class="apd-table-wrap">

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

                            <td class="apd-number">
                                {{ $items->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <span class="apd-name">
                                    {{ $item->name }}
                                </span>
                            </td>

                            <td>
                                <span class="apd-code">
                                    {{ $item->code }}
                                </span>
                            </td>

                            <td>
                                @if ($item->is_required)
                                    <span class="apd-badge badge-wajib">
                                        ✓ Wajib
                                    </span>
                                @else
                                    <span class="apd-badge badge-opsional">
                                        Opsional
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if ($item->is_active)
                                    <span class="apd-badge badge-aktif">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="apd-badge badge-nonaktif">
                                        ● Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>

                                <div class="apd-actions">

                                    <a class="btn-apd btn-edit"
                                       href="{{ route('admin.apd-items.edit', $item) }}">
                                        ✏️ Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.apd-items.toggle-status', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin {{ $item->is_active ? 'menonaktifkan' : 'mengaktifkan' }} APD ini?')">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn-apd btn-status">
                                            {{ $item->is_active ? '⏸️ Nonaktifkan' : '▶️ Aktifkan' }}
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="apd-empty">

                                <div class="apd-empty-icon">
                                    📋
                                </div>

                                <strong>Belum Ada Data APD</strong>

                                <p>
                                    Data jenis alat pelindung diri belum tersedia.
                                    Silakan tambahkan data APD terlebih dahulu.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if ($items->hasPages())
            <div class="apd-pagination">
                {{ $items->links() }}
            </div>
        @endif

    </div>

</div>

@endsection