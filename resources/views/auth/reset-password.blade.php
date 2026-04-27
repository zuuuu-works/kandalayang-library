<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password – Kandalayang Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3c5e 0%, #2d6a9f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.25);
            border: none;
        }
        .login-header {
            background: #1a3c5e;
            border-radius: 16px 16px 0 0;
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .login-header i { font-size: 2.5rem; }
        .login-header h4 { font-weight: 700; margin: 0.5rem 0 0; }
        .login-header small { opacity: 0.7; }
        .login-body { padding: 2rem; }
    </style>
</head>
<body>
<div class="login-card card">
    <div class="login-header">
        <i class="bi bi-book-half"></i>
        <h4>Kandalayang Library</h4>
        <small>E-Resource Management System</small>
    </div>
    <div class="login-body">
        <div class="text-center mb-4">
            <div class="bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width:52px; height:52px;">
                <i class="bi bi-shield-lock text-success fs-4"></i>
            </div>
            <h6 class="fw-bold mb-1">Reset your password</h6>
            <p class="text-muted small mb-0">Enter your new password below.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 small">
                <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $request->email) }}"
                           placeholder="you@example.com" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-semibold py-2">
                <i class="bi bi-check-circle me-1"></i> Reset Password
            </button>
        </form>

        <hr class="my-3">
        <p class="text-center text-muted mb-0" style="font-size:0.875rem;">
            Back to
            <a href="{{ route('login') }}" class="fw-semibold">Sign in</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>