<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    public function procesarProyectos(Request $request)
{
    // Obtener los datos del formulario
    $cantidadProyectos = $request->input('cantidadProyectos');
    $idProyecto = 1;

    // Construir la matriz de datos para la inserción
    $datosInsercion = [];

    for ($i = 0; $i < $cantidadProyectos; $i++) {
        $nombreProyecto = $request->input("nombreProyecto{$i}");
        $descripcionProyecto = $request->input("descripcionProyecto{$i}");
        $cantidadModulos = $request->input("cantidadModulos{$i}");

        for ($j = 0; $j < $cantidadModulos; $j++) {
            $nombreModulo = $request->input("nombreModulo{$i}_{$j}");
            $descripcionModulo = $request->input("descripcionModulo{$i}_{$j}");
            $cantidadProcesos = $request->input("cantidadProcesos{$i}_{$j}");

            // Construir la matriz de datos para los procesos
            $procesos = [];
            for ($k = 0; $k < $cantidadProcesos; $k++) {
                $nombreProceso = $request->input("nombreProceso{$i}_{$j}_{$k}");
                $descripcionProceso = $request->input("descripcionProceso{$i}_{$j}_{$k}");
                $procesos[] = [
                    'nombre_proceso' => $nombreProceso,
                    'descripcion_proceso' => $descripcionProceso,
                ];
            }

            // Agregar el proyecto con sus módulos y procesos a la matriz de datos
            $datosInsercion[] = [
                'id_Proyecto' => $idProyecto,
                'nombre_proyecto' => $nombreProyecto,
                'descripcion_proyecto' => $descripcionProyecto,
                'cantidad_modulos' => $cantidadModulos,
                'nombre_modulo' => $nombreModulo,
                'descripcion_modulo' => $descripcionModulo,
                'cantidad_procesos' => $cantidadProcesos,
                'procesos' => $procesos,
            ];

            $idProyecto += 1;
        }
    }

    // Insertar los datos en la base de datos
    foreach ($datosInsercion as $datos) {
        // Insertar el proyecto con sus módulos en la tabla 'proyectos'
        $idProyecto = DB::table('proyectos')->insertGetId([
            'id_Proyecto' => $datos['id_Proyecto'],
            'nombre_proyecto' => $datos['nombre_proyecto'],
            'descripcion_proyecto' => $datos['descripcion_proyecto'],
            'cantidad_modulos' => $datos['cantidad_modulos'],
            'nombre_modulo' => $datos['nombre_modulo'],
            'descripcion_modulo' => $datos['descripcion_modulo'],
            'cantidad_procesos' => $datos['cantidad_procesos'],
        ]);

        // Insertar los procesos del proyecto en la tabla 'procesos'
        foreach ($datos['procesos'] as $proceso) {
            DB::table('procesos')->insert([
                'id_Proyecto' => $idProyecto,
                'nombre_proceso' => $proceso['nombre_proceso'],
                'descripcion_proceso' => $proceso['descripcion_proceso'],
            ]);
        }
    }

    // Devolver una respuesta para indicar que todo ha sido procesado correctamente
    return response()->json(['message' => 'Datos procesados correctamente'], 200);
}

}
