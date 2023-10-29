<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>UNBC</title>
    <!-- Agrega las siguientes líneas para los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="app.css" type="text/css">
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
            justify-content: center;
        }

        .custom-table .actions-btns a {
            margin-right: 5px;
        }
        body{
            font-family: 'Work Sans', sans-serif;
             
        }
        
    </style>
</head>

<body>
    <header>
        <!-- Aquí puedes agregar tu barra de navegación u otros elementos del encabezado -->
    </header>
    

    <main>
        <!-- Aquí se mostrará el contenido de las vistas que utilices -->
        @yield('content')
    </main>

    <footer>
        <!-- Aquí puedes agregar el contenido de tu pie de página -->
    </footer>

    <!-- Agrega aquí tus scripts si es necesario -->
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
</body>

</html>
