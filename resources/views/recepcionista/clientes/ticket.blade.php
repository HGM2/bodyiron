<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 100%;
            max-width: 450px;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        .divider {
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }
        .info {
            text-align: left;
            margin-bottom: 10px;
        }
        .info p {
            margin: 5px 0;
        }
        .details {
            margin-top: 15px;
            text-align: left;
        }
        .details p {
            margin: 8px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            color: #555;
        }
        .footer p {
            margin: 5px 0;
        }
        .thanks {
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado del ticket -->
        <div class="header">
            Body Iron Fitness
        </div>
        <div class="info">
            <p><strong>Dirección:</strong>Av Enrique Díaz de León Nte 155, Zona Centro, 44100 Guadalajara, Jal.</p>
            <p><strong>Teléfono:</strong> (123) 456-7890</p>
            <p><strong>Email:</strong> contacto@bodyironfitness.com</p>
        </div>

        <!-- Línea divisoria -->
        <div class="divider"></div>

        <!-- Detalles del cliente y la membresía -->
        <div class="details">
            <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</p>
            <p><strong>Membresía:</strong> {{ $cliente->membresia->nombre }}</p>
            <p><strong>Fecha de Pago:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            <p><strong>Vigencia:</strong> {{ \Carbon\Carbon::parse($cliente->fecha_vencimiento)->format('d/m/Y') }}</p>
            <p><strong>Total Pagado:</strong> ${{ number_format($cliente->membresia->precio, 2) }}</p>
            <p><strong>Atendido por:</strong> {{ auth()->user()->nombre }}</p>
        </div>

        <!-- Línea divisoria -->
        <div class="divider"></div>

        <!-- Mensaje de agradecimiento -->
        <div class="thanks">
            ¡Gracias por ser parte de nuestra comunidad fitness!
        </div>

        <!-- Pie del ticket -->
        <div class="footer">
            <p><strong>Horario:</strong> Lunes a Viernes: 6 AM - 10 PM</p>
            <p>Sábados y Domingos: 8 AM - 8 PM</p>
            <p>Sitio web: www.bodyironfitness.com</p>
        </div>
    </div>
</body>
</html>
