<?php
$fecha = time(); // Obtiene el - Valor actual del tiempo

$fecha = date('Y-m-d H:i:s', $fecha); // Convierte el tiempo en un formato de fecha

?><!DOCTYPE html>
<html>
<head>
    <title>Reporte Diario</title>
</head>
<body>
    <h1>Reporte Diario</h1>
    
    <p>Adjunto encontrará el reporte diario correspondiente a la fecha {{ $fecha }}. El reporte contiene un resumen de las actividades y datos relevantes del día para su revisión y análisis.</p>
    {!! $html !!}
</body>
</html>
