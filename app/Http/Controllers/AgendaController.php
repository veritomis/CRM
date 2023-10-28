<?php

namespace App\Http\Controllers;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function mostrarAgenda()
    {
        $agendas = Agenda::orderBy('fecha', 'desc')->get();

        return view('agenda', compact('agendas'));
    }
}
