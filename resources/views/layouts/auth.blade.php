<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem PMD</title>

    <!-- Bootstrap & Icons (sama seperti app) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            background-color: var(--bs-tertiary-bg);
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
        }

        .login-title {
            font-weight: 600;
            font-size: 18px;
            color: #333;
        }

        .login-subtitle {
            font-size: 13px;
            color: #666;
        }

        .form-control {
            font-size: 13px;
        }

        .btn-login {
            font-size: 13px;
            font-weight: 500;
        }
    </style>

    @livewireStyles
</head>
<body>

    <div class="d-flex align-items-center justify-content-center login-wrapper">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
