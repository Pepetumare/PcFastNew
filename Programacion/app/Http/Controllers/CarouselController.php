<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use COM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $slides = CarouselSlide::orderBy('order')->get();
        return view('carousel.index', compact('slides'));
    }

    public function create()
    {
        return view('carousel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'button_text' => 'required|string|max:50',
            'button_link' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $path = $request->file('image')->store('carousel-images', 'public');

        CarouselSlide::create($request->except('image') + ['image_path' => $path, 'is_active' => $request->has('is_active')]);

        return redirect()->route('carousel.index')->with('success', 'Slide creado con éxito.');
    }
    public function edit(CarouselSlide $carouselSlide)
    {
        return view('carousel.edit', ['slide' => $carouselSlide]);
    }
    public function update(Request $request, CarouselSlide $carouselSlide)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'button_text' => 'required|string|max:50',
            'button_link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($carouselSlide->image_path);
            $data['image_path'] = $request->file('image')->store('carousel-images', 'public');
        }

        $carouselSlide->update($data);

        return redirect()->route('carousel.index')->with('success', 'Slide actualizado con éxito.');
    }
    public function destroy(CarouselSlide $carouselSlide)
    {
        Storage::disk('public')->delete($carouselSlide->image_path);
        $carouselSlide->delete();
        return redirect()->route('carousel.index')->with('success', 'Slide eliminado con éxito.');
    }
}
