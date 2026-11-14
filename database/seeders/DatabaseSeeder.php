<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Track;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TrackSeeder::class);
    }
}