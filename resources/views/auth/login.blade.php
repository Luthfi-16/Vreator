<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vreator</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --orange-primary: #D96F32;
            --orange-light: #F8B259;
            --orange-bg: #F3E9DC;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--orange-bg) 0%, #FAF6F0 100%);
            display: flex;
            align-items: center;
        }

        .login-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 14px 32px rgba(0,0,0,.07);
            max-width: 420px;
            margin: auto;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--orange-primary), var(--orange-light));
            padding: 20px;
            color: white;
            text-align: center;
        }

        .login-header h2 {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 4px;
        }

        .login-header p {
            font-size: .85rem;
            opacity: .9;
        }

        .login-body {
            padding: 22px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            font-weight: 600;
            font-size: .8rem;
            margin-bottom: 4px;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: .85rem;
        }

        .form-control-custom {
            width: 100%;
            padding: 9px 14px 9px 40px;
            border-radius: 10px;
            border: 1.8px solid #e9ecef;
            background: #f8f9fa;
            font-size: .85rem;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--orange-primary);
            background: #fff;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 11px;
            font-weight: 700;
            font-size: .9rem;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--orange-primary), var(--orange-light));
            border: none;
            color: white;
            box-shadow: 0 4px 12px rgba(217,111,50,.25);
        }

        .extra-link {
            margin-top: 12px;
            font-size: .8rem;
            text-align: center;
        }

        .extra-link a {
            color: var(--orange-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 14px;
        }

        .brand-logo a {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--orange-primary), var(--orange-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="container">
        <div class="brand-logo">
            <a href="/">Vreator</a>
        </div>

        <div class="login-card">
            <div class="login-header">
                <h2>Masuk Akun</h2>
                <p>Selamat datang kembali 👋</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email"
                                class="form-control-custom @error('email') is-invalid @enderror"
                                placeholder="nama@email.com"
                                value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" id="password"
                                class="form-control-custom @error('password') is-invalid @enderror"
                                placeholder="Password" required>
                            <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Masuk
                    </button>
                </form>

                <div class="extra-link">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    @endif
                    <br>
                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = password.type === 'password' ? 'text' : 'password';
        password.type = type;
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>
