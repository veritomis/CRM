<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
class CacController extends Controller
{
    public function cac()
    {
        $agendas = Agenda::all();
        return view('cac.agenda', compact('agendas'));
        // Aquí va la lógica del método
        //return view('cac.agenda'); // Asegúrate de que la vista 'cac.agenda' exista
    }
}