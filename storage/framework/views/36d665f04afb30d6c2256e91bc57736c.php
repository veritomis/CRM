<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>UNBC</title>
    <!-- Agrega las siguientes líneas para los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <!-- Agrega aquí tus enlaces a hojas de estilo, scripts y Bootstrap -->
    <style>
        .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table th,
        .custom-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .custom-table th {
            background-color: #7eb189;
            font-weight: bold;
        }

        .custom-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .custom-table tr:hover {
            background-color: #f1f1f1;
        }

        .custom-table .actions-btns {
            display: flex;
            justify-content: center;
            display: inline-block;
            /*margin: 1px;*/
        }

        .custom-table .actions-btns a {
            /*margin-right: 1px;*/
        }
        .botones-alineados {
           text-align: center; /* Centra los botones horizontalmente */
        }

        .botones-alineados a,
        .botones-alineados form {
            display: inline-block; /* Hace que los elementos sean en línea */
            /*vertical-align: middle; /* Alinea verticalmente los elementos */
            /*margin: 2px; /* Agrega margen para espaciarlos un poco */
        }
        .acciones{
            /*background-color: pink;*/
            display: flex; /* Activa el contenedor flex */
            align-items: center; /* Alinea verticalmente en el centro */
            /*margin: 5px;
            padding: 2px;
            margin-right: 10px; */
        }
        .boton{
           margin-right: 10px;
            
        }*/
        
    </style>
</head>

<body>
    <header>
        <!-- Aquí puedes agregar tu barra de navegación u otros elementos del encabezado -->
    </header>
    <main>
        <!-- Aquí se mostrará el contenido de las vistas que utilices -->
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer>
        <!-- Aquí puedes agregar el contenido de tu pie de página -->
    </footer>

    <!-- Agrega aquí tus scripts si es necesario -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/roles/layout.blade.php ENDPATH**/ ?>