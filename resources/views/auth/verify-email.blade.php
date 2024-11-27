<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Correo Electrónico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset('images/fondo5.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .container {
            background-color: rgba(26, 26, 26, 0.85);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 text-center">
            <h2 class="mb-4">Verifica tu Correo Electrónico</h2>
            <p class="mb-4">Antes de continuar, por favor revisa tu correo electrónico y haz clic en el enlace de verificación.</p>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    Un nuevo enlace de verificación ha sido enviado a tu correo electrónico.
                </div>
            @endif
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Reenviar Correo de Verificación</button>
            </form>
        </div>
    </div>
</body>
</html>
