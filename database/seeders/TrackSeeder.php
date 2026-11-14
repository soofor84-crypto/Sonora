<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Track;

class TrackSeeder extends Seeder
{
    public function run(): void
    {
        $pistas = [
            ['titulo' => 'Noches de lluvia', 'artista' => 'Mar Abierto',   'dur' => 258],
            ['titulo' => 'Hora azul',        'artista' => 'Luz de Norte',  'dur' => 232],
            ['titulo' => 'Cuerdas',          'artista' => 'Estudio Cinco', 'dur' => 307],
            ['titulo' => 'Caminos',          'artista' => 'Mar Abierto',   'dur' => 209],
            ['titulo' => 'Sin prisa',        'artista' => 'Luz de Norte',  'dur' => 284],
        ];

        foreach($pistas as $pista){
            Track::create($pista);
        }
    }
}