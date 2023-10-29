<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Proyectos</title>
    <style>
        /* Estilos para la ventana flotante */
        #formWindow {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #f2f2f2;
            padding: 20px;
            border: 1px solid #ccc;
            z-index: 2;
            overflow-y: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        #proyectosForm label {
            font-weight: bold;
        }

        #cantidadProyectos {
            margin-bottom: 10px;
        }

        #finalizarButton {
            background: #86B7B5;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        #closeButton {
            background: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        body{
            font-family: 'Work Sans', sans-serif;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <script>
        // Función para abrir la ventana flotante
        function openFormWindow() {
            var windowHTML = `
                <div id="formWindow">
                    <h2>Formulario de proyectos</h2>
                    <form id="proyectosForm" action="{{ route('formulario.store') }}" method="POST">
                        @csrf
                        <label for="cantidadProyectos">Cantidad de proyectos: </label>
                        <input type="number" id="cantidadProyectos" name="cantidadProyectos"><br><br>
                        <div id="proyectosContainer">
                            <!-- Los proyectos generados dinámicamente se agregarán aquí -->
                        </div>
                        <button type="button" id="finalizarButton">Finalizar</button>
                    </form>
                    <button id="closeButton" type="button">Cerrar</button>
                </div>
            `;

            $('body').append(windowHTML);

            // Cerrar la ventana flotante al hacer clic en el botón "Cerrar"
            $('#closeButton').on('click', function() {
                $('#formWindow').remove();
            });

            // Agregar evento de entrada para la cantidad de proyectos
            $('#cantidadProyectos').on('input', function() {
                var cantidad = parseInt($(this).val());
                $('#proyectosContainer').empty();

                for (var i = 0; i < cantidad; i++) {
                    var proyectoHTML = `
                        <div class="proyecto">
                            <h3>Proyecto ${i + 1}</h3>
                            <label for="nombreProyecto${i}">Nombre del proyecto: </label>
                            <input type="text" id="nombreProyecto${i}" name="nombreProyecto${i}"><br>
                            <label for="descripcionProyecto${i}">Descripción del proyecto: </label>
                            <input type="text" id="descripcionProyecto${i}" name="descripcionProyecto${i}"><br>
                            <label for="cantidadModulos${i}">Cantidad de módulos: </label>
                            <input type="number" id="cantidadModulos${i}" name="cantidadModulos${i}"><br>
                            <div id="modulos${i}"></div><br>
                        </div>
                    `;

                    $('#proyectosContainer').append(proyectoHTML);
                }
            });

            // Agregar evento de entrada para la cantidad de módulos dentro de cada proyecto
            $(document).on('input', '[id^="cantidadModulos"]', function() {
                var proyectoId = $(this).attr('id').replace('cantidadModulos', '');
                var cantidadModulos = parseInt($(this).val());
                var modulosHTML = '';

                for (var j = 0; j < cantidadModulos; j++) {
                    var moduloHTML = `
                        <div class="modulo">
                            <h4>Módulo ${j + 1}</h4>
                            <label for="nombreModulo${proyectoId}_${j}">Nombre del módulo: </label>
                            <input type="text" id="nombreModulo${proyectoId}_${j}" name="nombreModulo${proyectoId}_${j}"><br>
                            <label for="descripcionModulo${proyectoId}_${j}">Descripción del módulo: </label>
                            <input type="text" id="descripcionModulo${proyectoId}_${j}" name="descripcionModulo${proyectoId}_${j}"><br>
                            <label for="cantidadProcesos${proyectoId}_${j}">Cantidad de procesos: </label>
                            <input type="number" id="cantidadProcesos${proyectoId}_${j}" name="cantidadProcesos${proyectoId}_${j}"><br>
                            <div id="procesos${proyectoId}_${j}"></div><br>
                        </div>
                    `;

                    modulosHTML += moduloHTML;
                }

                $('#modulos' + proyectoId).html(modulosHTML);

                // Agregar evento de entrada para la cantidad de procesos dentro del módulo
                $('[id^="cantidadProcesos' + proyectoId + '_"]').on('input', function() {
                    var id = $(this).attr('id');
                    var moduloId = id.substring(id.indexOf('_') + 1);
                    var cantidadProcesos = parseInt($(this).val());
                    var procesosContainer = $('#procesos' + proyectoId + '_' + moduloId);
                    var procesosHTML = '';

                    for (var k = 0; k < cantidadProcesos; k++) {
                        var procesoHTML = `
                            <div class="proceso">
                                <h5>Proceso ${k + 1}</h5>
                                <label for="nombreProceso${proyectoId}_${moduloId}_${k}">Nombre del proceso: </label>
                                <input type="text" id="nombreProceso${proyectoId}_${moduloId}_${k}" name="nombreProceso${proyectoId}_${moduloId}_${k}"><br>
                                <label for="descripcionProceso${proyectoId}_${moduloId}_${k}">Descripción del proceso: </label>
                                <input type="text" id="descripcionProceso${proyectoId}_${moduloId}_${k}" name="descripcionProceso${proyectoId}_${moduloId}_${k}"><br>
                            </div>
                        `;

                        procesosHTML += procesoHTML;
                    }

                    procesosContainer.html(procesosHTML);
                });
            });

            // Enviar formulario sin recargar la página al presionar "Finalizar"
            $('#finalizarButton').on('click', function() {
                var form = $('#proyectosForm');
                var formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    success: function(response) {
                        // Manejar la respuesta del servidor si es necesario
                        console.log(response);
                        swal("¡Éxito!", "Los datos se han guardado correctamente", "success");
                    },
                    error: function(xhr, status, error) {
                        // Manejar el error si ocurre algún problema
                        console.error(error);
                        swal("¡Error!", "Hubo un problema al guardar los datos", "error");
                    }
                });

                // Cerrar la ventana flotante
                $('#formWindow').remove();
            });
        }
    </script>
</head>
<body>
    <button type="button" onclick="openFormWindow()">Analizar</button>
</body>
</html>
