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
            padding: 1.25rem 2rem;
            text-align: center;
            color: white;
        }
        .register-header h4 { font-weight: 700; margin: 0.25rem 0 0; font-size: 1.1rem; }
        .register-header small { opacity: 0.7; font-size: 0.75rem; }
        .register-body { padding: 1.5rem 2rem; }
    </style>
</head>
<body>

<div class="register-card card">

    {{-- Header --}}
    <div class="register-header">
        <i class="bi bi-book-half fs-4"></i>
        <h4>Kandalayang Library</h4>
        <small>E-Resource Management System</small>
    </div>

    <div class="register-body">
        <h6 class="fw-bold text-center text-muted mb-3" style="font-size:0.85rem;">Create your account</h6>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-danger py-1 px-3 small mb-2">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name Row --}}
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="form-label fw-semibold mb-1 small">First Name</label>
                    <input type="text" name="first_name"
                           class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name') }}" placeholder="Juan" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold mb-1 small">Last Name</label>
                    <input type="text" name="last_name"
                           class="form-control form-control-sm @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name') }}" placeholder="Dela Cruz" required>
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-2">
                <label class="form-label fw-semibold mb-1 small">Email Address</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
            </div>

            {{-- Role Picker --}}
            <div class="mb-2">
                <label class="form-label fw-semibold mb-2 small">I am a...</label>
                <div class="d-flex gap-2">
                    <input type="radio" class="btn-check" name="role" id="role-student"
                           value="student" {{ old('role') === 'student' ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary btn-sm flex-fill" for="role-student">
                        <i class="bi bi-mortarboard me-1"></i>Student
                    </label>

                    <input type="radio" class="btn-check" name="role" id="role-faculty"
                           value="faculty" {{ old('role') === 'faculty' ? 'checked' : '' }}>
                    <label class="btn btn-outline-success btn-sm flex-fill" for="role-faculty">
                        <i class="bi bi-person-workspace me-1"></i>Faculty
                    </label>

                    <input type="radio" class="btn-check" name="role" id="role-researcher"
                           value="researcher" {{ old('role') === 'researcher' ? 'checked' : '' }}>
                    <label class="btn btn-outline-warning btn-sm flex-fill" for="role-researcher">
                        <i class="bi bi-search me-1"></i>Researcher
                    </label>
                </div>
                @error('role')
                    <div class="text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-2">
                <label class="form-label fw-semibold mb-1 small">Password</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password"
                           class="form-control" placeholder="Min. 8 characters" required>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label class="form-label fw-semibold mb-1 small">Confirm Password</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password_confirmation"
                           class="form-control" placeholder="Repeat password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold py-2">
                <i class="bi bi-person-check me-1"></i> Create Account
            </button>
        </form>

        <hr class="my-2">
        <p class="text-center text-muted mb-0" style="font-size:0.8rem;">
            Already have an account?
            <a href="{{ route('login') }}" class="fw-semibold">Sign in</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>