<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register – Kandalayang Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3c5e 0%, #2d6a9f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .register-card {
            width: 100%;
            max-width: 460px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.25);
            border: none;
        }
        .register-header {
            background: #1a3c5e;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem 2rem;
            text-align: center;
            color: white;
        }
        .register-header h4 { font-weight: 700; margin: 0; }
        .register-body { padding: 2rem; }
    </style>
</head>
<body>
<div class="register-card card">
    <div class="register-header">
        <i class="bi bi-person-plus fs-3"></i>
        <h4 class="mt-2">Create an Account</h4>
        <small class="opacity-75">Kandalayang Library System</small>
    </div>
    <div class="register-body">

        @if($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col">
                    <label class="form-label fw-semibold">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name') }}" placeholder="Juan" required>
                </div>
                <div class="col">
                    <label class="form-label fw-semibold">Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name') }}" placeholder="Dela Cruz" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Select your role --</option>
                    <option value="student"    {{ old('role') === 'student'    ? 'selected' : '' }}>Student</option>
                    <option value="faculty"    {{ old('role') === 'faculty'    ? 'selected' : '' }}>Faculty / Teacher</option>
                    <option value="researcher" {{ old('role') === 'researcher' ? 'selected' : '' }}>Researcher</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                <i class="bi bi-person-check me-1"></i> Create Account
            </button>
        </form>

        <hr class="my-3">
        <p class="text-center text-muted mb-0" style="font-size:0.875rem;">
            Already have an account?
            <a href="{{ route('login') }}" class="fw-semibold">Sign in</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>