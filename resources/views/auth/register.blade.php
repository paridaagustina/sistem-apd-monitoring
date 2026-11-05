
<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-gray-800">
            Registrasi Pekerja
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Daftarkan akun untuk menggunakan sistem monitoring APD.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Pekerja -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Kode Pekerja -->
        <div class="mt-4">
            <x-input-label for="worker_code" value="Kode Pekerja" />
            <x-text-input
                id="worker_code"
                class="block mt-1 w-full"
                type="text"
                name="worker_code"
                :value="old('worker_code')"
                required
                placeholder="Contoh: WK001"
            />
            <x-input-error :messages="$errors->get('worker_code')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Departemen -->
        <div class="mt-4">
            <x-input-label for="department" value="Departemen" />
            <x-text-input
                id="department"
                class="block mt-1 w-full"
                type="text"
                name="department"
                :value="old('department')"
                placeholder="Contoh: Produksi"
            />
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>

        <!-- Jabatan -->
        <div class="mt-4">
            <x-input-label for="position" value="Jabatan" />
            <x-text-input
                id="position"
                class="block mt-1 w-full"
                type="text"
                name="position"
                :value="old('position')"
                placeholder="Contoh: Operator"
            />
            <x-input-error :messages="$errors->get('position')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                value="Konfirmasi Password"
            />
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a
                class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}"
            >
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4">
                Daftar Sekarang
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
