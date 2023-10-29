<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Título del correo electrónico</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
        }

        /* Contenedor principal */
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
        }

        /* Encabezado */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 200px;
        }

        /* Contenido principal */
        .content {
            padding: 20px;
            text-align: center;
        }

        /* Botón */
        .button {
            display: inline-block;
            background-color: #ff5722;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Pie de página */
        .footer {
            text-align: center;
            color: #999999;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('storage/Logo_unbc_color.png')}}"
                alt="Logo de la empresa">
        </div>
        <div class="content">
            <h1>Restablecer contraseña</h1>
            <h3>{{ $email }}</h3>
            <p>Estimado/a,</p>
            <p>Recibió este correo electrónico porque hemos recibido una solicitud para restablecer la contraseña de su cuenta. Para continuar con el proceso de restablecimiento, haga clic en el siguiente enlace:</p>
            <p><a href="{{ url('password/'. $email) }}">Restablecer contraseña</a></p>
            <p>Si no solicitó restablecer su contraseña, puede ignorar este mensaje. Su contraseña no será cambiada.</p>
            <p>Si tiene alguna pregunta o necesita asistencia adicional, no dude en comunicarse con nosotros.</p>
            <p>¡Gracias y que tenga un excelente día!</p>
        </div>
        <div class="footer">
            <p>UNBC.</p>
        </div>


    </div>
</body>

</html>
