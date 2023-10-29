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
            <img src="<?php echo e(asset('storage/Logo_unbc_color.png')); ?>"
                alt="Logo de la empresa">
        </div>
        <div class="content">
            <h1>Bienvenido/a!</h1>
            <h3><?php echo e($name); ?> <?php echo e($apellido); ?></h3>
            <p>Estimado/a,</p>
            <p>Es un placer darle la bienvenida a nuestra empresa. Para comenzar, le solicitamos que establezca una
                contraseña ingresando al siguiente enlace:</p>
            <p><a href="<?php echo e(url('password/'. $email)); ?>">Establecer contraseña</a></p>
            <p>Una vez que haya establecido su contraseña, podrá iniciar sesión utilizando su dirección de correo
                electrónico.</p>
            <p>Estamos comprometidos a brindarle un entorno de trabajo acogedor y satisfactorio. Si tiene alguna
                pregunta o necesita asistencia, no dude en comunicarse con nosotros.</p>
            <p>¡Le damos la bienvenida y esperamos que tenga una experiencia exitosa en nuestra empresa!</p>
        </div>
        <div class="footer">
            <p>UNBC.</p>
        </div>


    </div>
</body>

</html>
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/emails/crearCuenta.blade.php ENDPATH**/ ?>