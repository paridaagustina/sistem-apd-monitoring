@extends('layouts.app')

@section('title', 'Laporan Lapangan - APDMONITOR')

@section('content')

<style>
    .halaman-laporan {
        color: #172b4d;
    }

    .halaman-laporan * {
        box-sizing: border-box;
    }

    /* HEADER */
    .laporan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .laporan-title {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .laporan-icon {
        width: 49px;
        height: 49px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf1ff;
        border-radius: 14px;
        font-size: 25px;
        flex-shrink: 0;
    }

    .laporan-title h2 {
        margin: 0 0 5px;
        font-size: 24px;
        font-weight: 800;
    }

    .laporan-title p {
        margin: 0;
        color: #8291a8;
        font-size: 13px;
    }

    .admin-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        margin-bottom: 9px;
        border-radius: 20px;
        background: #dcfce7;
        color: #15803d;
        font-size: 10px;
        font-weight: 800;
    }

    /* NOTIFICATION */
    .laporan-alert {
        padding: 14px 17px;
        border-radius: 11px;
        margin-bottom: 18px;
        font-size: 13px;
        font-weight: 600;
    }

    .alert-success {
        background: #e5f8ef;
        color: #047857;
        border: 1px solid #bbf7d0;
    }

    /* STATISTICS */
    .laporan-statistik {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
        margin-bottom: 23px;
    }

    .laporan-stat-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 21px;
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 16px;
        box-shadow: 0 4px 15px #25385808;
        transition: .2s ease;
    }

    .laporan-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px #25385810;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 23px;
        flex-shrink: 0;
    }

    .stat-biru {
        background: #eaf1ff;
    }

    .stat-orange {
        background: #fff1e8;
    }

    .stat-hijau {
        background: #e5f8ef;
    }

    .stat-info small {
        display: block;
        color: #8291a8;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .stat-info strong {
        display: block;
        color: #172b4d;
        font-size: 27px;
        font-weight: 800;
    }

    /* MAIN CARD */
    .laporan-card {
        background: white;
        border: 1px solid #e9eef5;
        border-radius: 16px;
        padding: 21px;
        box-shadow: 0 5px 20px #25385808;
    }

    .laporan-card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .laporan-card-heading h3 {
        margin: 0 0 5px;
        font-size: 16px;
        font-weight: 800;
    }

    .laporan-card-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 11px;
    }

    .jumlah-laporan {
        padding: 7px 11px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    /* FILTER */
    .laporan-filter {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 15px;
        margin-bottom: 20px;
        background: #f8fafc;
        border: 1px solid #edf1f6;
        border-radius: 12px;
    }

    .laporan-filter .input-group {
        position: relative;
        flex: 1;
        min-width: 200px;
    }

    .laporan-filter input,
    .laporan-filter select {
        width: 100%;
        height: 41px;
        padding: 0 12px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        outline: none;
        background: white;
        color: #334155;
        font-family: inherit;
        font-size: 12px;
    }

    .laporan-filter input:focus,
    .laporan-filter select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px #3b82f615;
    }

    .laporan-filter select {
        width: 180px;
        cursor: pointer;
    }

    .btn-laporan {
        height: 41px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 15px;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        text-decoration: none;
        font-family: inherit;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
        transition: .2s ease;
    }

    .btn-cari {
        background: #2563eb;
        color: white;
    }

    .btn-cari:hover {
        background: #1d4ed8;
    }

    .btn-reset {
        background: #e2e8f0;
        color: #475569;
    }

    .btn-reset:hover {
        background: #cbd5e1;
    }

    /* TABLE */
    .laporan-table-wrap {
        overflow-x: auto;
        border: 1px solid #edf1f6;
        border-radius: 11px;
    }

    .halaman-laporan table {
        width: 100%;
        min-width: 1100px;
        border-collapse: collapse;
    }

    .halaman-laporan th {
        padding: 15px 12px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #edf1f6;
    }

    .halaman-laporan td {
        padding: 15px 12px;
        color: #475569;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .halaman-laporan tbody tr:last-child td {
        border-bottom: none;
    }

    .halaman-laporan tbody tr:hover {
        background: #f8fbff;
    }

    .nomor-laporan {
        color: #94a3b8;
        font-weight: 700;
    }

    .nama-pelapor {
        color: #172b4d;
        font-weight: 800;
    }

    .lokasi-laporan {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #475569;
    }

    .waktu-laporan {
        white-space: nowrap;
        font-size: 11px;
    }

    /* STATUS */
    .badge-laporan {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-menunggu {
        background: #fff1d6;
        color: #a16207;
    }

    .badge-diperiksa {
        background: #dcfce7;
        color: #15803d;
    }

    /* BUTTON DETAIL */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 12px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 8px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
        transition: .2s ease;
    }

    .btn-detail:hover {
        background: #dbeafe;
        transform: translateY(-1px);
    }

    /* EMPTY STATE */
    .laporan-empty {
        padding: 55px 20px !important;
        text-align: center;
    }

    .laporan-empty-icon {
        width: 75px;
        height: 75px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 17px;
        border-radius: 21px;
        background: #eaf1ff;
        font-size: 34px;
    }

    .laporan-empty strong {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 14px;
    }

    .laporan-empty p {
        margin: 0;
        color: #94a3b8;
        font-size: 12px;
    }

    /* PAGINATION */
    .laporan-pagination {
        margin-top: 20px;
    }

    /* RESPONSIVE */
    @media(max-width: 850px) {
        .laporan-statistik {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 600px) {
        .laporan-statistik {
            grid-template-columns: 1fr;
        }

        .laporan-card {
            padding: 13px;
        }

        .laporan-filter {
            align-items: stretch;
        }

        .laporan-filter .input-group,
        .laporan-filter select,
        .laporan-filter button,
        .laporan-filter a {
            width: 100%;
            min-width: 100%;
        }

        .laporan-title h2 {
            font-size: 20px;
        }
    }
</style>


<div class="halaman-laporan">

    {{-- HEADER --}}
    <div class="laporan-header">
        
            <div class="laporan-title">

                <div class="laporan-icon">
                    🎥
                </div>

                <div>
                    <h2>Live Laporan Lapangan</h2>

                    <p>
                        Periksa laporan video yang dikirim oleh pekerja lapangan.
                        Halaman ini terpisah dari riwayat deteksi APD.
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="laporan-alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif


    {{-- STATISTIK --}}
    <div class="laporan-statistik">

        <div class="laporan-stat-card">

            <div class="stat-icon stat-biru">
                📹
            </div>

            <div class="stat-info">
                <small>Total Laporan</small>
                <strong>{{ $stats['total'] }}</strong>
            </div>

        </div>


        <div class="laporan-stat-card">

            <div class="stat-icon stat-orange">
                ⏳
            </div>

            <div class="stat-info">
                <small>Menunggu Pemeriksaan</small>
                <strong>{{ $stats['menunggu'] }}</strong>
            </div>

        </div>


        <div class="laporan-stat-card">

            <div class="stat-icon stat-hijau">
                ✅
            </div>

            <div class="stat-info">
                <small>Sudah Diperiksa</small>
                <strong>{{ $stats['diperiksa'] }}</strong>
            </div>

        </div>

    </div>


    {{-- DAFTAR LAPORAN --}}
    <div class="laporan-card">

        <div class="laporan-card-heading">

            <div>
                <h3>Daftar Laporan Lapangan</h3>
                <p>Kelola dan pantau laporan video dari pekerja lapangan.</p>
            </div>

            <span class="jumlah-laporan">
                {{ $reports->total() }} Total Laporan
            </span>

        </div>


        {{-- FILTER PENCARIAN --}}
        <form
            method="GET"
            action="{{ route('admin.field-reports.index') }}"
            class="laporan-filter">

            <div class="input-group">

                <input
                    type="text"
                    name="cari"
                    value="{{ request('cari') }}"
                    placeholder="🔍 Cari nama pekerja atau lokasi...">

            </div>


            <select name="status">

                <option value="">
                    Semua Status
                </option>

                <option
                    value="menunggu"
                    @selected(request('status') === 'menunggu')>
                    ⏳ Menunggu
                </option>

                <option
                    value="diperiksa"
                    @selected(request('status') === 'diperiksa')>
                    ✅ Sudah Diperiksa
                </option>

            </select>


            <button type="submit" class="btn-laporan btn-cari">
                🔍 Cari
            </button>


            <a href="{{ route('admin.field-reports.index') }}"
               class="btn-laporan btn-reset">
                ↻ Reset
            </a>

        </form>


        {{-- TABEL --}}
        <div class="laporan-table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pekerja</th>
                        <th>Lokasi</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Waktu Dikirim</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($reports as $report)

                        <tr>

                            <td class="nomor-laporan">
                                {{ $reports->firstItem() + $loop->index }}
                            </td>


                            <td>
                                <span class="nama-pelapor">
                                    {{ $report->user?->name ?? '-' }}
                                </span>
                            </td>


                            <td>
                                <span class="lokasi-laporan">
                                    📍 {{ $report->location_name }}
                                </span>
                            </td>


                            <td class="waktu-laporan">
                                {{ $report->started_at
                                    ? $report->started_at->format('d/m/Y H:i:s')
                                    : '-' }}
                            </td>


                            <td class="waktu-laporan">
                                {{ $report->ended_at
                                    ? $report->ended_at->format('d/m/Y H:i:s')
                                    : '-' }}
                            </td>


                            <td class="waktu-laporan">
                                {{ $report->submitted_at
                                    ? $report->submitted_at->format('d/m/Y H:i:s')
                                    : '-' }}
                            </td>


                            <td class="waktu-laporan">
                                {{ gmdate('H:i:s', $report->video_duration) }}
                            </td>


                            <td>

                                @if($report->status === 'diperiksa')

                                    <span class="badge-laporan badge-diperiksa">
                                        ● Sudah Diperiksa
                                    </span>

                                @else

                                    <span class="badge-laporan badge-menunggu">
                                        ● Menunggu
                                    </span>

                                @endif

                            </td>


                            <td>

                                <a
                                    href="{{ route('admin.field-reports.show', $report) }}"
                                    class="btn-detail">

                                    👁️ Lihat Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="laporan-empty">

                                <div class="laporan-empty-icon">
                                    🎥
                                </div>

                                <strong>Belum Ada Laporan Lapangan</strong>

                                <p>
                                    Belum ada laporan video yang dikirim oleh pekerja lapangan.
                                    Laporan akan muncul di sini setelah dikirim.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($reports->hasPages())

            <div class="laporan-pagination">
                {{ $reports->withQueryString()->links() }}
            </div>

        @endif

    </div>

</div>

@endsection