<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PPKD Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --ppkd-primary: #4caf7d;
            --ppkd-dark: #1b4332;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1b4332 0%, #2d7a55 40%, #40916c 70%, #52b788 100%);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .bg-pattern {
            position: fixed; inset: 0; pointer-events: none; overflow: hidden;
        }
        .bg-circle {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .login-wrapper {
            position: relative; z-index: 10;
            width: 100%; max-width: 440px; padding: 20px;
        }
        .login-card {
            background: rgba(255,255,255,.97);
            border-radius: 24px;
            padding: 44px 40px;
            box-shadow: 0 24px 80px rgba(0,0,0,.25);
            backdrop-filter: blur(20px);
        }
        .login-logo {
            width: 68px; height: 68px;
            background: var(--ppkd-primary);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px; margin: 0 auto 18px;
            box-shadow: 0 8px 24px rgba(76,175,125,.35);
        }
        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; font-weight: 700;
            color: #1a2e23; text-align: center; margin-bottom: 4px;
        }
        .login-subtitle {
            text-align: center; color: #6b8f78;
            font-size: .85rem; margin-bottom: 32px;
        }
        .form-label {
            font-weight: 600; font-size: .8rem;
            color: #6b8f78; text-transform: uppercase;
            letter-spacing: .05em; margin-bottom: 6px;
        }
        .form-control {
            border: 1.5px solid #d4edda; border-radius: 12px;
            padding: 12px 16px; font-size: .9rem;
            transition: all .2s;
        }
        .form-control:focus {
            border-color: var(--ppkd-primary);
            box-shadow: 0 0 0 3px rgba(76,175,125,.15);
        }
        .btn-login {
            width: 100%; background: var(--ppkd-primary);
            color: #fff; border: none; border-radius: 12px;
            padding: 14px; font-weight: 700; font-size: 1rem;
            transition: all .2s; margin-top: 8px;
        }
        .btn-login:hover { background: #388e5c; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(76,175,125,.35); }
        .demo-box {
            background: #f0faf4; border: 1px dashed #b8e4c9;
            border-radius: 12px; padding: 14px; margin-top: 24px; font-size: .78rem;
        }
        .demo-box h6 { font-size: .78rem; font-weight: 700; color: #2d7a55; margin-bottom: 6px; }
    </style>
</head>
<body>
<div class="bg-pattern">
    <div class="bg-circle" style="width:400px;height:400px;top:-100px;right:-100px;"></div>
    <div class="bg-circle" style="width:300px;height:300px;bottom:-80px;left:-80px;"></div>
    <div class="bg-circle" style="width:200px;height:200px;top:50%;left:60%;"></div>
</div>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">🏨</div>
        <div class="login-title">PPKD Hotel</div>
        <div class="login-subtitle">Sistem Manajemen Hotel • Jakarta Pusat</div>

        @if($errors->any())
            <div class="alert alert-danger" style="border-radius:12px;font-size:.85rem;padding:12px 16px;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                       placeholder="nama@ppkdhotel.com" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember" style="font-size:.85rem;color:#6b8f78;">Ingat saya</label>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
            </button>
        </form>

        <div class="demo-box">
            <h6><i class="bi bi-info-circle me-1"></i>Akun Demo</h6>
            <div class="d-flex justify-content-between">
                <div>
                    <div style="color:#374151;font-weight:600;">Administrator</div>
                    <div style="color:#6b7280;">admin@ppkdhotel.com</div>
                    <div style="color:#6b7280;">admin123</div>
                </div>
                <div>
                    <div style="color:#374151;font-weight:600;">Resepsionis</div>
                    <div style="color:#6b7280;">resepsionis@ppkdhotel.com</div>
                    <div style="color:#6b7280;">resep123</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
