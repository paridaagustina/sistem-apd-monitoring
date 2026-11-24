<x-guest-layout>

    <style>
        .login-wrapper {
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
            padding: 15px;
            color: #172b4d;
        }

        .login-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #edf1f7;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .08);
        }

        .login-header {
            padding: 35px 30px;
            text-align: center;
            color: white;
            background: linear-gradient(
                115deg,
                #123c75 0%,
                #1761bd 55%,
                #3188e8 100%
            );
        }

        .login-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 62px;
            height: 62px;
            margin-bottom: 15px;
            border-radius: 17px;
            background: rgba(255,255,255,.17);
            border: 1px solid rgba(255,255,255,.25);
            font-size: 29px;
        }

        .login-header h1 {
            margin: 0 0 8px;
            color: white;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .login-header p {
            margin: 0;
            color: rgba(255,255,255,.82);
            font-size: 12px;
            line-height: 1.6;
        }

        .login-body {
            padding: 30px;
        }

        .login-welcome {
            margin-bottom: 25px;
        }

        .login-welcome h2 {
            margin: 0 0 7px;
            color: #172b4d;
            font-size: 19px;
            font-weight: 800;
        }

        .login-welcome p {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .login-field {
            margin-bottom: 19px;
        }

        .login-field label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
        }

        .login-input-wrapper {
            position: relative;
        }

        .login-input {
            width: 100%;
            height: 47px;
            padding: 0 14px;
            color: #172b4d;
            background: #fafcff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            font-size: 13px;
            transition: .2s ease;
        }

        .login-input:focus {
            background: white;
            border-color: #3188e8;
            box-shadow: 0 0 0 3px rgba(49,136,232,.12);
        }

        .login-input::placeholder {
            color: #a0aec0;
        }

        .password-input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 13px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            font-size: 14px;
        }

        .password-toggle:hover {
            color: #2563eb;
        }

        .login-error {
            margin-top: 7px;
            color: #dc2626;
            font-size: 11px;
        }

        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin: 5px 0 23px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #64748b;
            font-size: 11px;
            cursor: pointer;
        }

        .remember-label input {
            width: 15px;
            height: 15px;
            accent-color: #2563eb;
        }

        .forgot-link {
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 47px;
            padding: 12px 18px;
            color: white;
            background: linear-gradient(115deg, #1761bd, #3188e8);
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
            box-shadow: 0 5px 13px rgba(37,99,235,.18);
        }

        .login-button:hover {
            background: linear-gradient(115deg, #123c75, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37,99,235,.23);
        }

        .login-footer {
            margin-top: 23px;
            padding-top: 18px;
            border-top: 1px solid #edf1f7;
            text-align: center;
            color: #94a3b8;
            font-size: 10px;
            line-height: 1.7;
        }

        .login-footer strong {
            color: #2563eb;
        }

        .login-status {
            margin-bottom: 18px;
            padding: 11px 13px;
            color: #047857;
            background: #e5f8ef;
            border: 1px solid #bbf7d0;
            border-radius: 9px;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .login-wrapper {
                padding: 10px;
            }

            .login-header {
                padding: 28px 20px;
            }

            .login-body {
                padding: 24px 20px;
            }

            .login-options {
                align-items: flex-start;
            }
        }
    </style>

    <div class="login-wrapper">

        <div class="login-card">

            {{-- HEADER --}}
            <div class="login-header">

                <div class="login-logo">
                    🛡️
                </div>

                <h1>APD<span style="font-weight:400;">MONITOR</span></h1>

                <p>
                    Sistem Monitoring Kelengkapan Alat Pelindung Diri
                </p>

            </div>

            {{-- FORM LOGIN --}}
            <div class="login-body">

                <div class="login-welcome">
                    <h2>Selamat Datang!</h2>
                    <p>Silakan masuk menggunakan akun yang telah terdaftar.</p>
                </div>

                {{-- SESSION STATUS --}}
                @if (session('status'))
                    <div class="login-status">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="login-field">

                        <label for="email">Alamat Email</label>

                        <input
                            id="email"
                            class="login-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan alamat email"
                            required
                            autofocus
                            autocomplete="username"
                        >

                        @error('email')
                            <div class="login-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- PASSWORD --}}
                    <div class="login-field">

                        <label for="password">Password</label>

                        <div class="login-input-wrapper">

                            <input
                                id="password"
                                class="login-input password-input"
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword()"
                                aria-label="Tampilkan password"
                            >
                                <i id="password-icon" class="fas fa-eye"></i>
                            </button>

                        </div>

                        @error('password')
                            <div class="login-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- OPTIONS --}}
                    <div class="login-options">

                        <label for="remember_me" class="remember-label">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                            >
                            Ingat saya
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="forgot-link"
                            >
                                Lupa password?
                            </a>
                        @endif

                    </div>

                    {{-- BUTTON LOGIN --}}
                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk ke Sistem
                    </button>

                </form>

                {{-- FOOTER --}}
                <div class="login-footer">
                    <strong>APDMONITOR</strong><br>
                    Sistem Monitoring Kelengkapan APD<br>
                    &copy; {{ date('Y') }} All Rights Reserved.
                </div>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('password-icon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</x-guest-layout>
