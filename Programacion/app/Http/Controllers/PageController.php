<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Muestra la página de Inicio.
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Muestra la página de Nosotros.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Muestra la página de Contacto.
     */
    public function contact()
    {
        return view('contact');
    }
}