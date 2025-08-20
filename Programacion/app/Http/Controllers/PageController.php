<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Muestra la página de Inicio.
     */
    public function home()
    {
        $slides = CarouselSlide::where('is_active', true)->orderBy('order')->get();
        return view('home', compact('slides'));
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
