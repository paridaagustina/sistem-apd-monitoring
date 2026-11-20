
<style>
    .form-pekerja {
        max-width: 760px;
        margin: 0 auto;
        color: #263342;
    }

    .form-pekerja .kartu {
        padding: 24px;
        background: white;
        border: 1px solid #e7ebef;
        border-radius: 14px;
    }

    .form-pekerja h2 {
        margin: 0 0 8px;
    }

    .form-pekerja .deskripsi {
        color: #687586;
        margin: 0 0 22px;
    }

    .form-pekerja .grup {
        margin-bottom: 20px;
    }

    .form-pekerja label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .form-pekerja input {
        width: 100%;
        padding: 12px;
        border: 1px solid #d7dee7;
        border-radius: 9px;
        font: inherit;
        box-sizing: border-box;
        background: white;
    }

    .form-pekerja .error {
        color: #b42318;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-pekerja .aksi {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .form-pekerja .tombol {
        padding: 11px 16px;
        border: 0;
        border-radius: 9px;
        text-decoration: none;
        font-weight: 700;
        cursor: pointer;
    }

    .form-pekerja .simpan {
        background: #167d69;
        color: white;
    }

    .form-pekerja .batal {
        background: #edf1f5;
        color: #344054;
    }

    .form-pekerja .foto-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e7ebef;
        margin-bottom: 12px;
        display: block;
    }

    .form-pekerja .petunjuk {
        color: #687586;
        font-size: 12px;
        margin-top: 6px;
    }

    @media(max-width:600px) {
        .form-pekerja .kartu {
            padding: 17px;
        }
    }
</style>

<div class="form-pekerja">
    <div class="kartu">

        <h2>
            {{ $worker->exists ? 'Edit Data Petugas' : 'Tambah Petugas' }}
        </h2>

        <p class="deskripsi">
            Lengkapi nama, foto, dan jabatan petugas.
        </p>

        <form
            method="POST"
            enctype="multipart/form-data"
            action="{{ $worker->exists
                ? route('admin.workers.update', $worker)
                : route('admin.workers.store') }}"
        >

            @csrf

            @if($worker->exists)
                @method('PUT')
            @endif

            {{-- NAMA LENGKAP --}}
            <div class="grup">
                <label for="name">Nama Lengkap *</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $worker->name) }}"
                    placeholder="Masukkan nama lengkap petugas"
                    maxlength="100"
                    required
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- FOTO PEKERJA --}}
            <div class="grup">
                <label for="photo">Foto Petugas</label>

                @if($worker->photo)
                    <img
                        id="previewFoto"
                        src="{{ asset('storage/' . $worker->photo) }}"
                        class="foto-preview"
                        alt="Foto petugas"
                    >
                @else
                    <img
                        id="previewFoto"
                        src=""
                        class="foto-preview"
                        alt="Pratinjau foto"
                        style="display:none;"
                    >
                @endif

                <input
                    type="file"
                    id="photo"
                    name="photo"
                    accept="image/jpeg,image/png,image/webp"
                >

                <div class="petunjuk">
                    Format JPG, JPEG, PNG, atau WEBP.
                    Maksimal 2 MB.
                </div>

                @error('photo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- JABATAN --}}
            <div class="grup">
                <label for="position">Jabatan *</label>

                <input
                    type="text"
                    id="position"
                    name="position"
                    value="{{ old('position', $worker->position) }}"
                    placeholder="Contoh: Petugas Lapangan"
                    maxlength="100"
                    required
                >

                @error('position')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- TOMBOL --}}
            <div class="aksi">

                <button type="submit" class="tombol simpan">
                    {{ $worker->exists
                        ? 'Simpan Perubahan'
                        : 'Simpan Petugas' }}
                </button>

                <a
                    href="{{ route('admin.workers.index') }}"
                    class="tombol batal"
                >
                    Kembali
                </a>

            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const inputFoto = document.getElementById('photo');
        const previewFoto = document.getElementById('previewFoto');

        inputFoto.addEventListener('change', function (event) {

            const file = event.target.files[0];

            if (file) {
                previewFoto.src = URL.createObjectURL(file);
                previewFoto.style.display = 'block';
            }

        });

    });
</script>