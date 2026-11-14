<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;

class SonoraController extends Controller
{
    public function inicio()
    {
        $pistas = Track::all()->toArray();
        $playlists = [
            ['titulo' => 'Mezcla diaria 1', 'artista' => 'Para ti',     'duracion' => '1:12:40', 'barras' => [40, 70, 55, 90, 35]],
            ['titulo' => 'Noches de lluvia', 'artista' => 'Playlist',   'duracion' => '48:05',   'barras' => [80, 45, 65, 30, 75]],
            ['titulo' => 'Sin prisa',        'artista' => 'Mar Abierto','duracion' => '36:21',   'barras' => [50, 85, 40, 70, 60]],
            ['titulo' => 'Caminos',          'artista' => 'Playlist',   'duracion' => '1:03:12', 'barras' => [30, 60, 90, 50, 80]],
        ];
        return view('inicio', compact('pistas', 'playlists'));
    }

    public function buscar(Request $request)
    {
        $pistas = Track::all()->toArray(); 
        
        $query = $request->input('q');
        
        if ($query) {
            $resultados = Track::where('titulo', 'LIKE', "%{$query}%")
                               ->orWhere('artista', 'LIKE', "%{$query}%")
                               ->get()->toArray();
        } else {
            $resultados = [];
        }
        return view('buscar', compact('resultados', 'query', 'pistas'));
    }
    public function playlist()
    {
        $pistas = Track::all()->toArray();
        return view('playlist', compact('pistas'));
    }
}