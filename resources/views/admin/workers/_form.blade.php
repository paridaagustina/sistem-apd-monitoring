
<style>
    .form-pekerja { max-width: 760px; margin: 0 auto; color: #263342; }
    .form-pekerja .kartu {
        padding: 24px; background: white; border: 1px solid #e7ebef;
        border-radius: 14px;
    }
    .form-pekerja h2 { margin: 0 0 8px; }
    .form-pekerja .deskripsi { color: #687586; margin: 0 0 22px; }
    .form-pekerja .grup { margin-bottom: 17px; }
    .form-pekerja label { display: block; font-size: 14px; font-weight: 700; margin-bottom: 7px; }
    .form-pekerja input, .form-pekerja textarea {
        width: 100%; padding: 12px; border: 1px solid #d7dee7;
        border-radius: 9px; font: inherit; box-sizing: border-box;
    }
    .form-pekerja .error { color: #b42318; font-size: 12px; margin-top: 5px; }
    .form-pekerja .aksi { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 22px; }
    .form-pekerja .tombol {
        padding: 11px 16px; border: 0; border-radius: 9px;
        text-decoration: none; font-weight: 700; cursor: pointer;
    }
    .form-pekerja .simpan { background: #167d69; color: white; }
    .form-pekerja .batal { background: #edf1f5; color: #344054; }
    @media(max-width:600px) {
        .form-pekerja .kartu { padding: 17px; }
    }
</style>

<div class="form-pekerja">
    <div class="kartu">
        <h2>{{ $worker->exists ? 'Edit Identitas Pekerja' : 'Tambah Pekerja' }}</h2>
        <p class="deskripsi">Lengkapi identitas pekerja yang akan diperiksa.</p>

        <form method="POST" action="{{ $worker->exists
            ? route('admin.workers.update', $worker)
            : route('admin.workers.store') }}">
            @csrf
            @if($worker->exists)
                @method('PUT')
            @endif

            <div class="grup">
                <label for="worker_code">Nomor Identitas Pekerja *</label>
                <input id="worker_code" name="worker_code" type="text"
                       value="{{ old('worker_code', $worker->worker_code) }}"
                       placeholder="Contoh: PKR-001" maxlength="30" required>
                @error('worker_code') <div class="error">{{ $message }}</div> @enderror
            </div>
<div class="grup">
    <label for="user_id">Akun Login Pekerja *</label>

    <select name="user_id" id="user_id" required
        style="width:100%;padding:12px;border:1px solid #d7dee7;border-radius:9px;background:white;">

        <option value="">-- Pilih Akun Pekerja --</option>

        @foreach($users as $user)
            <option value="{{ $user->id }}"
                @selected(old('user_id', $worker->user_id) == $user->id)>
                {{ $user->name }} - {{ $user->email }}
            </option>
        @endforeach
    </select>

    @error('user_id')
        <div class="error">{{ $message }}</div>
    @enderror

    @if($users->isEmpty())
        <div class="error">
            Tidak ada akun pekerja yang tersedia. Buat akun pekerja terlebih dahulu.
        </div>
    @endif
</div>
            <div class="grup">
                <label for="name">Nama Lengkap *</label>
                <input id="name" name="name" type="text"
                       value="{{ old('name', $worker->name) }}"
                       placeholder="Nama lengkap pekerja" maxlength="100" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="grup">
                <label for="department">Departemen / Bagian</label>
                <input id="department" name="department" type="text"
                       value="{{ old('department', $worker->department) }}"
                       placeholder="Contoh: Produksi" maxlength="100">
                @error('department') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="grup">
                <label for="position">Jabatan</label>
                <input id="position" name="position" type="text"
                       value="{{ old('position', $worker->position) }}"
                       placeholder="Contoh: Operator" maxlength="100">
                @error('position') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="grup">
                <label for="notes">Catatan</label>
                <textarea id="notes" name="notes" rows="3"
                          placeholder="Catatan tambahan (opsional)">{{ old('notes', $worker->notes) }}</textarea>
                @error('notes') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="aksi">
                <button type="submit" class="tombol simpan">
                    {{ $worker->exists ? 'Simpan Perubahan' : 'Simpan Pekerja' }}
                </button>
                <a href="{{ route('admin.workers.index') }}" class="tombol batal">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
