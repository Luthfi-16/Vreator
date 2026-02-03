<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Vreator</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --orange-primary: #D96F32;
            --orange-light: #F8B259;
            --orange-bg: #F3E9DC;
            --orange-dark: #C75D2C;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* =========================
        WRAPPER
        ========================= */
        .register-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--orange-bg) 0%, #FAF6F0 100%);
            padding: 16px 0;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* =========================
        CARD
        ========================= */
        .register-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 14px 32px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            max-width: 720px;
            margin: auto;
        }

        /* =========================
        HEADER
        ========================= */
        .register-header {
            background: linear-gradient(135deg, var(--orange-primary), var(--orange-light));
            padding: 18px 22px;
            color: white;
            text-align: center;
        }

        .register-header h2 {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 4px;
        }

        .register-header p {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        /* =========================
        ROLE BADGE
        ========================= */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 0.75rem;
            margin-top: 6px;
            background: rgba(255,255,255,.25);
        }

        /* =========================
        BODY
        ========================= */
        .register-body {
            padding: 18px 22px;
        }

        /* =========================
        FORM
        ========================= */
        .form-group {
            margin-bottom: 12px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 4px;
            color: #2c3e50;
        }

        .form-control-custom {
            width: 100%;
            padding: 8px 14px;
            border: 1.8px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.85rem;
            background: #f8f9fa;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--orange-primary);
            background: #fff;
        }

        /* =========================
        ICON INPUT
        ========================= */
        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            color: #6c757d;
        }

        .input-icon-wrapper .form-control-custom {
            padding-left: 40px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            cursor: pointer;
        }

        /* =========================
        BUTTON
        ========================= */
        .btn-register {
            width: 100%;
            padding: 11px;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--orange-primary), var(--orange-light));
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(217, 111, 50, 0.25);
        }

        /* =========================
        LOGIN LINK
        ========================= */
        .login-link {
            margin-top: 10px;
            font-size: 0.8rem;
            text-align: center;
        }

        .login-link a {
            color: var(--orange-primary);
            font-weight: 600;
            text-decoration: none;
        }

        /* =========================
        BRAND
        ========================= */
        .brand-logo {
            margin-bottom: 12px;
            text-align: center;
        }

        .brand-logo a {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--orange-primary), var(--orange-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none
        }

        /* =========================
        MOBILE EXTRA
        ========================= */
        @media (max-height: 720px) {
            .form-group {
                margin-bottom: 8px;
            }

            .register-body {
                padding: 14px 18px;
            }

            .btn-register {
                padding: 9px;
                font-size: 0.85rem;
            }
        }

        

    </style>
</head>
<body>

<div class="register-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-7">
                
                <!-- Brand Logo -->
                <div class="brand-logo">
                    <a href="index.html">Vreator</a>
                </div>
                
                <div class="register-card">
                    <!-- Header -->
                    <div class="register-header">
                        <h2>Buat Akun Baru</h2>
                        <p>Bergabung dengan komunitas creator</p>
                        
                        <!-- Role Badge - ganti sesuai parameter role -->
                        @if(request('role') === 'creator')
                            <div class="role-badge">
                                <i class="bi bi-camera-video-fill"></i>
                                <span>Mendaftar sebagai Creator</span>
                            </div>
                        @elseif(request('role') === 'user')
                            <div class="role-badge">
                                <i class="bi bi-bag-fill"></i>
                                <span>Mendaftar sebagai User</span>
                            </div>
                        @endif

                    </div>

                    <!-- Body -->
                    <div class="register-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf               
                            <!-- ROLE (HIDDEN) -->
                           <input type="hidden" name="role" value="{{ request('role') }}">


                            <!-- Name -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-person-fill me-2" style="color: var(--orange-primary);"></i>
                                    Nama Lengkap
                                </label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-person input-icon"></i>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        class="form-control-custom" 
                                        placeholder="Masukkan nama lengkap"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-envelope-fill me-2" style="color: var(--orange-primary);"></i>
                                    Email
                                </label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        class="form-control-custom" 
                                        placeholder="nama@email.com"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-lock-fill me-2" style="color: var(--orange-primary);"></i>
                                    Password
                                </label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        id="password"
                                        class="form-control-custom" 
                                        placeholder="Minimal 8 karakter"
                                        required
                                    >
                                    <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-lock-fill me-2" style="color: var(--orange-primary);"></i>
                                    Konfirmasi Password
                                </label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input 
                                        type="password" 
                                        name="password_confirmation" 
                                        id="password_confirmation"
                                        class="form-control-custom" 
                                        placeholder="Ketik ulang password"
                                        required
                                    >
                                    <i class="bi bi-eye password-toggle" id="togglePasswordConfirm"></i>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-whatsapp me-2" style="color: var(--orange-primary);"></i>
                                    WhatsApp <span class="text-muted">(Opsional)</span>
                                </label>
                                <div class="input-icon-wrapper">
                                    <i class="bi bi-phone input-icon"></i>
                                    <input 
                                        type="text" 
                                        name="whatsapp" 
                                        class="form-control-custom" 
                                        placeholder="08xxxxxxxxxx"
                                    >
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-register">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Buat Akun Sekarang
                            </button>
                        </form>

                        <!-- Login Link -->
                        <div class="login-link">
                            Sudah punya akun? <a href="login.html">Masuk di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
    
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirm = document.getElementById('password_confirmation');
    
    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirm.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>