<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store( Request $request)
    {
        //Dropzone
        $imagen = $request->file('file');

        // Intervention Image
        $nombreImagen = Str::uuid() . "." . $imagen->extension(); // Genera id único
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
