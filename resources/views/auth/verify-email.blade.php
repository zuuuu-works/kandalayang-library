<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email – Kandalayang Library</title>
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
            <div class="bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width:52px; height:52px;">
                <i class="bi bi-envelope-check text-warning fs-4"></i>
            </div>
            <h6 class="fw-bold mb-1">Verify your email</h6>
            <p class="text-muted small mb-0">
                Thanks for registering! Please check your inbox and click the verification link we sent you.
            </p>
        </div>

        @if(session('status') === 'verification-link-sent')
            <div class="alert alert-success py-2 small mb-3">
                <i class="bi bi-check-circle me-1"></i>
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="bg-light rounded-3 p-3 mb-4 small text-muted text-center">
            <i class="bi bi-info-circle me-1 text-primary"></i>
            Didn't receive the email? Check your spam folder or resend below.
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-warning w-100 fw-semibold py-2 text-dark">
                <i class="bi bi-arrow-repeat me-1"></i> Resend Verification Email
            </button>
        </form>

        <hr class="my-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100 btn-sm">
                <i class="bi bi-box-arrow-left me-1"></i> Sign out of this account
            </button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>