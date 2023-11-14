<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class MenuController extends Controller
{
    public function index()
    {
        $usuario = null;

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el usuario autenticado
            $usuario = Auth::user();
        }

        // Compartir la variable $usuario con la vista del menú
        View::share('usuario', $usuario);
    }
}
