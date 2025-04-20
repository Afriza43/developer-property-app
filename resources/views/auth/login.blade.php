<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT. AJISAKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sign-in.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="card-header">
                <img src="{{ asset('assets/image/logo-ajisaka.png') }}" width="72" height="72" alt="">
            </div>

            <div class="card-body">
                <h3 class="welcome-text">Selamat Datang!</h3>
                <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <!-- Email Field -->
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com"
                            required name="email">
                        <label for="email">Email Pengguna</label>
                        @error('record')
                            <div class="error-message" id="emailError">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" placeholder="Password" required
                            name="password">
                        <label for="password">Password</label>
                        @error('record')
                            <div class="error-message" id="passwordError">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
