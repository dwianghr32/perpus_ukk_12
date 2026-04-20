<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan </title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 226, 0.2) 0%, transparent 50%);
            animation: bgFloat 20s ease-in-out infinite;
        }

        @keyframes bgFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1100px;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 
                0 25px 80px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, 
                rgba(102, 126, 234, 0.9) 0%, 
                rgba(118, 75, 162, 0.9) 50%, 
                rgba(240, 147, 251, 0.9) 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -120px;
            right: -80px;
            animation: float 8s ease-in-out infinite;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            bottom: -100px;
            left: -80px;
            animation: float 10s ease-in-out infinite reverse;
        }

        .login-left .shape-1 {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            top: 20%;
            left: 10%;
            animation: rotate 15s linear infinite;
        }

        .login-left .shape-2 {
            position: absolute;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            bottom: 25%;
            right: 15%;
            animation: rotate 20s linear infinite reverse;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        .login-left-content {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .login-left-content i {
            font-size: 90px;
            margin-bottom: 25px;
            animation: bounce 3s ease-in-out infinite, glow 2s ease-in-out infinite alternate;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.3));
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.3)); }
            to { filter: drop-shadow(0 0 30px rgba(255, 255, 255, 0.6)); }
        }

        .login-left-content h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background: linear-gradient(45deg, #ffffff, #f0f8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-left-content p {
            font-size: 16px;
            opacity: 0.95;
            line-height: 1.6;
            margin-bottom: 35px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .features {
            text-align: left;
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 16px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 15px;
            font-weight: 500;
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .feature-item:nth-child(1) { animation-delay: 0.2s; }
        .feature-item:nth-child(2) { animation-delay: 0.4s; }
        .feature-item:nth-child(3) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-item:last-child {
            margin-bottom: 0;
        }

        .feature-item i {
            margin-right: 15px;
            font-size: 22px;
            color: #ffffff;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.5));
        }

        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.98);
        }

        .login-right h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-right p {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 35px;
            font-weight: 400;
        }

        .form-floating {
            margin-bottom: 25px;
        }

        .form-floating .form-control {
            border-radius: 14px;
            border: 2px solid rgba(102, 126, 234, 0.1);
            padding: 18px 16px 10px;
            height: 60px;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(248, 249, 250, 0.8);
            backdrop-filter: blur(10px);
        }

        .form-floating .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15), 0 4px 20px rgba(102, 126, 234, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .form-floating .form-control:hover {
            border-color: rgba(102, 126, 234, 0.3);
        }

        .form-floating label {
            padding: 18px 16px;
            color: #6c757d;
            font-size: 15px;
            font-weight: 500;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            font-size: 17px;
            font-weight: 600;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #f093fb 50%, #667eea 100%);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #6c757d;
            font-size: 15px;
            font-weight: 400;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }

        .register-link a:hover::after {
            width: 100%;
        }

        .register-link a:hover {
            color: #764ba2;
            transform: translateY(-1px);
        }

        .alert {
            border: none;
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 25px;
            animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 15px;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .alert-success {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            border-color: rgba(25, 135, 84, 0.2);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-color: rgba(220, 53, 69, 0.2);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .validation-error {
            color: #e17055;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left {
                padding: 40px 30px;
                min-height: 300px;
            }

            .login-right {
                padding: 40px 30px;
            }

            .login-left-content h2 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .login-left {
                padding: 30px 20px;
            }

            .login-right {
                padding: 30px 20px;
            }

            .login-left-content h2 {
                font-size: 24px;
            }

            .login-left-content i {
                font-size: 70px;
            }

            .features {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Side -->
        <div class="login-left">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="login-left-content">
                <i class="bi bi-book"></i>
                <h2>Perpustakaan </h2>
                <p>Sistem Manajemen Perpustakaan Modern dengan Teknologi Terdepan</p>
                <div class="features">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Kelola Koleksi Buku Lengkap</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Pantau Riwayat Peminjaman</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Proses Peminjaman Cepat & Mudah</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login-right">
            <h1>Masuk</h1>
            <p>Silakan masuk dengan akun Anda</p>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>   
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post">
                <div class="form-floating">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= set_value('username') ?>" required>
                    <label for="username"><i class="bi bi-person me-1"></i>Username / NIS</label>
                </div>
                <?= form_error('username', '<div class="validation-error">', '</div>') ?>

                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password"><i class="bi bi-lock me-1"></i>Password</label>
                </div>
                <?= form_error('password', '<div class="validation-error">', '</div>') ?>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="<?= base_url('auth/register') ?>">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                