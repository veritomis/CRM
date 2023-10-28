<?php
namespace App\Imports;

use App\Models\leadsArgentina;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadsImport implements ToModel
{
    private $skipRow = true; // Variable para saltar la primera fila

    public function model(array $row)
    {
        if ($this->skipRow) {
            $this->skipRow = false;
            return null; // Retorna null para saltar la primera fila
        }

        // Verifica si todas las columnas están vacías
        if (empty(array_filter($row))) {
            return null; // Retorna null para evitar guardar filas vacías
        }
        // Agrega validación para la columna "tipificacion"
        $tipificacion = $row[11]; // Supongamos que "tipificacion" está en la columna 12 (índice 11)
        // Aplica una regla de validación personalizada
        if ($tipificacion !== null && !is_numeric($tipificacion)) {
            // Si "tipificacion" no es nulo y no es un número, retorna null para omitir esta fila
             return null;
}
        return new LeadsArgentina([
            'campaign_name' => $row[0],
            'form_id' => $row[1],
            'form_name' => $row[2],
            'is_organic' => $row[3],
            'platform' => $row[4],
            'cuentanos_mas_sobre_el_proyecto' => $row[5],
            'full_name' => $row[6],
            'work_phone_number' => $row[7],
            'work_email' => $row[8],
            'job_title' => $row[9],
            'nombre_de_la_empresa' => $row[10],
            'tipificacion' => $tipificacion, // Agrega "tipificacion" al modelo
        ]);
    }
}







      
