<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function calendarioReservas()
    {
        return view('admin.calendario-reservas');
    }

    public function gestionReservas()
    {
        return view('admin.gestion-reservas');
    }

    public function inventarioTarifas()
    {
        return view('admin.inventario-tarifas');
    }

    public function reporteAnalisis()
    {
        return view('admin.reporte-analisis');
    }
}
