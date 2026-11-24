<x-guest-layout>

    <style>
        * {
            box-sizing: border-box;
        }

        /* =========================================
           WRAPPER
        ========================================= */
        .register-wrapper {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 20px;
            color: #172b4d;
        }

        /* =========================================
           CARD
        ========================================= */
        .register-card {
            width: 100%;
            overflow: hidden;
            background: #fff;
            border: 1px solid #edf1f7;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .08);
        }

        /* =========================================
           HEADER
        ========================================= */
        .register-header {
            padding: 32px 30px;
            text-align: center;
            color: white;
            background: linear-gradient(
                115deg,
                #123c75 0%,
                #1761bd 55%,
                #3188e8 100%
            );
        }

        .register-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            margin-bottom: 12px;
            border-radius: 16px;
            background: rgba(255,255,255,.17);
            border: 1px solid rgba(255,255,255,.25);
            font-size: 28px;
        }

        .register-header h1 {
            margin: 0 0 7px;
            color: white;
            font-size: 27px;
            font-weight: 800;
        }

        .register-header p {
            margin: 0;
            color: rgba(255,255,255,.85);
            font-size: 13px;
            line-height: 1.6;
        }

        /* =========================================
           BODY
        ========================================= */
        .register-body {
            width: 100%;
            padding: 38px 55px 32px;
        }

        .register-welcome {
            margin-bottom: 30px;
        }

        .register-welcome h2 {
            margin: 0 0 7px;
            color: #172b4d;
            font-size: 22px;
            font-weight: 800;
        }

        .register-welcome p {
            margin: 0;
            color: #94a3b8;
            font-size: 13px;
        }

        /* =========================================
           GRID FORM
        ========================================= */
        .register-grid {
            display: grid;
            width: 100%;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 28px;
            row-gap: 0;
            align-items: start;
        }

        .register-field {
            display: flex;
            flex-direction: column;
            width: 100%;
            min-width: 0;
            margin-bottom: 20px;
        }

        .register-field.full {
            grid-column: 1 / -1;
            width: 100%;
        }

        /* LABEL */
        .register-field label {
            display: block;
            width: 100%;
            margin-bottom: 9px;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        /* =========================================
           INPUT
        ========================================= */
        .register-input-wrapper {
            position: relative;
            display: block;
            width: 100%;
            min-width: 0;
        }

        .register-input {
            display: block;
            width: 100% !important;
            max-width: 100%;
            min-width: 0;
            height: 50px;
            padding: 0 15px;
            color: #172b4d;
            background: #fafcff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            font-family: inherit;
            font-size: 13px;
            transition: .2s ease;
        }

        .register-input:focus {
            background: white;
            border-color: #3188e8;
            box-shadow: 0 0 0 3px rgba(49,136,232,.12);
        }

        .register-input::placeholder {
            color: #a0aec0;
        }

        /* PASSWORD */
        .register-input.register-password {
            width: 100% !important;
            padding-right: 45px;
        }

        .register-toggle {
            position: absolute;
            top: 50%;
            right: 13px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            padding: 5px;
            color: #94a3b8;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .register-toggle:hover {
            color: #2563eb;
        }

        /* =========================================
           ERROR
        ========================================= */
        .register-error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 12px;
        }

        /* =========================================
           INFORMATION
        ========================================= */
        .register-info {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            width: 100%;
            margin: 9px 0 25px;
            padding: 14px 17px;
            color: #45658c;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.7;
        }

        /* =========================================
           BUTTON
        ========================================= */
        .register-actions {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 18px;
        }

        .register-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 50px;
            padding: 12px 18px;
            color: white;
            background: linear-gradient(115deg, #1761bd, #3188e8);
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
            box-shadow: 0 5px 13px rgba(37,99,235,.18);
        }

        .register-button:hover {
            background: linear-gradient(115deg, #123c75, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37,99,235,.23);
        }

        .register-login {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
        }

        .register-login a {
            color: #2563eb;
            font-weight: 800;
            text-decoration: none;
        }

        .register-login a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* =========================================
           FOOTER
        ========================================= */
        .register-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #edf1f7;
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            line-height: 1.8;
        }

        .register-footer strong {
            color: #2563eb;
        }

        /* =========================================
           TABLET
        ========================================= */
        @media (max-width: 900px) {

            .register-wrapper {
                max-width: 760px;
                padding: 22px 16px;
            }

            .register-body {
                padding: 30px 28px;
            }

            .register-grid {
                column-gap: 20px;
            }
        }

        /* =========================================
           MOBILE
        ========================================= */
        @media (max-width: 520px) {

            .register-wrapper {
                padding: 12px 10px;
            }

            .register-card {
                border-radius: 15px;
            }

            .register-header {
                padding: 24px 16px;
            }

            .register-logo {
                width: 50px;
                height: 50px;
                font-size: 23px;
                border-radius: 14px;
            }

            .register-header h1 {
                font-size: 21px;
            }

            .register-header p {
                font-size: 11px;
            }

            .register-body {
                padding: 23px 18px;
            }

            .register-welcome {
                margin-bottom: 21px;
            }

            .register-welcome h2 {
                font-size: 19px;
            }

            .register-welcome p {
                font-size: 12px;
                line-height: 1.6;
            }

            /* Satu kolom di HP */
            .register-grid {
                grid-template-columns: minmax(0, 1fr);
                column-gap: 0;
                row-gap: 0;
            }

            .register-field,
            .register-field.full {
                grid-column: 1 / -1;
                width: 100%;
                margin-bottom: 16px;
            }

            .register-field label {
                font-size: 12px;
                margin-bottom: 7px;
            }

            .register-input {
                width: 100% !important;
                height: 46px;
                font-size: 13px;
                padding: 0 12px;
            }

            .register-input.register-password {
                padding-right: 43px;
            }

            .register-info {
                margin-top: 5px;
                margin-bottom: 20px;
                padding: 11px 12px;
                font-size: 11px;
            }

            .register-button {
                min-height: 47px;
                font-size: 13px;
            }

            .register-footer {
                margin-top: 21px;
                font-size: 10px;
            }
        }

        /* =========================================
           SMALL MOBILE
        ========================================= */
        @media (max-width: 360px) {

            .register-wrapper {
                padding: 8px 7px;
            }

            .register-body {
                padding: 20px 14px;
            }

            .register-header {
                padding: 21px 12px;
            }

            .register-header h1 {
                font-size: 19px;
            }

            .register-welcome h2 {
                font-size: 18px;
            }
        }
    </style>

    <div class="register-wrapper">

        <div class="register-card">

            {{-- HEADER --}}
            <div class="register-header">

                <div class="register-logo">
                    🛡️
                </div>

                <h1>
                    APD<span style="font-weight:400;">MONITOR</span>
                </h1>

                <p>
                    Sistem Monitoring Kelengkapan Alat Pelindung Diri
                </p>

            </div>

            {{-- BODY --}}
            <div class="register-body">

                <div class="register-welcome">

                    <h2>Registrasi Pekerja</h2>

                    <p>
                        Lengkapi data berikut untuk membuat akun pekerja.
                    </p>

                </div>

                <form method="POST" action="{{ route('register') }}">

                    @csrf

                    <div class="register-grid">

                        {{-- NAMA --}}
                        <div class="register-field">

                            <label for="name">
                                Nama Lengkap
                            </label>

                            <input
                                id="name"
                                class="register-input"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap"
                                required
                                autofocus
                                autocomplete="name"
                            >

                            @error('name')
                                <div class="register-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- KODE PEKERJA --}}
                        <div class="register-field">

                            <label for="worker_code">
                                Kode Pekerja
                            </label>

                            <input
                                id="worker_code"
                                class="register-input"
                                type="text"
                                name="worker_code"
                                value="{{ old('worker_code') }}"
                                placeholder="Contoh: WK001"
                                required
                            >

                            @error('worker_code')
                                <div class="register-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- EMAIL --}}
                        <div class="register-field full">

                            <label for="email">
                                Alamat Email
                            </label>

                            <input
                                id="email"
                                class="register-input"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan alamat email"
                                required
                                autocomplete="username"
                            >

                            @error('email')
                                <div class="register-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- DEPARTEMEN --}}
                        <div class="register-field">

                            <label for="department">
                                Departemen
                            </label>

                            <input
                                id="department"
                                class="register-input"
                                type="text"
                                name="department"
                                value="{{ old('department') }}"
                                placeholder="Contoh: Produksi"
                            >

                            @error('department')
                                <div class="register-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- JABATAN --}}
                        <div class="register-field">

                            <label for="position">
                                Jabatan
                            </label>

                            <input
                                id="position"
                                class="register-input"
                                type="text"
                                name="position"
                                value="{{ old('position') }}"
                                placeholder="Contoh: Operator"
                            >

                            @error('position')
                                <div class="register-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- PASSWORD --}}
                        <div class="register-field">

                            <label for="password">
                                Password
                            </label>

                            <div class="register-input-wrapper">

                                <input
                                    id="password"
                                    class="register-input register-password"
                                    type="password"
                                    name="password"
                                    placeholder="Buat password"
                                    required
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="register-toggle"
                                    onclick="toggleRegisterPassword('password', 'icon-password')"
                                    aria-label="Tampilkan password"
                                >
                                    <i id="icon-password" class="fas fa-eye"></i>
                                </button>

                            </div>

                            @error('password')
                                <div class="register-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="register-field">

                            <label for="password_confirmation">
                                Konfirmasi Password
                            </label>

                            <div class="register-input-wrapper">

                                <input
                                    id="password_confirmation"
                                    class="register-input register-password"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    required
                                    autocomplete="new-password"
                                >

                                <button
                                    type="button"
                                    class="register-toggle"
                                    onclick="toggleRegisterPassword('password_confirmation', 'icon-confirmation')"
                                    aria-label="Tampilkan konfirmasi password"
                                >
                                    <i id="icon-confirmation" class="fas fa-eye"></i>
                                </button>

                            </div>

                            @error('password_confirmation')
                                <div class="register-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- INFORMASI --}}
                    <div class="register-info">

                        <span>ℹ️</span>

                        <span>
                            Pastikan nama, kode pekerja, dan informasi akun
                            yang dimasukkan sudah benar sebelum mendaftar.
                        </span>

                    </div>

                    {{-- TOMBOL --}}
                    <div class="register-actions">

                        <button type="submit" class="register-button">

                            <i class="fas fa-user-plus"></i>

                            Daftar Sekarang

                        </button>

                        <div class="register-login">

                            Sudah memiliki akun?

                            <a href="{{ route('login') }}">
                                Masuk di sini
                            </a>

                        </div>

                    </div>

                </form>

                {{-- FOOTER --}}
                <div class="register-footer">

                    <strong>APDMONITOR</strong><br>

                    Sistem Monitoring Kelengkapan APD<br>

                    &copy; {{ date('Y') }} All Rights Reserved.

                </div>

            </div>

        </div>

    </div>

    {{-- SCRIPT PASSWORD --}}
    <script>
        function toggleRegisterPassword(inputId, iconId) {

            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

            } else {

                input.type = 'password';

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

            }
        }
    </script>

</x-guest-layout>