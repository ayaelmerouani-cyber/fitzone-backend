<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipement;

class EquipementSeeder extends Seeder
{
    public function run()
    {
        $equipements = [
            ['name' => 'Tapis roulant #1', 'type' => 'Cardio', 'status' => 'Opérationnel', 'last_checked_at' => '2026-05-25'],
            ['name' => 'Tapis roulant #2', 'type' => 'Cardio', 'status' => 'Opérationnel', 'last_checked_at' => '2026-05-25'],
            ['name' => 'Tapis roulant #3', 'type' => 'Cardio', 'status' => 'Maintenance', 'last_checked_at' => '2026-05-10'],
            ['name' => 'Vélo elliptique #1', 'type' => 'Cardio', 'status' => 'Alerte', 'last_checked_at' => '2026-05-20'],
            ['name' => 'Vélo elliptique #2', 'type' => 'Cardio', 'status' => 'Opérationnel', 'last_checked_at' => '2026-05-28'],
            ['name' => 'Rack musculation A', 'type' => 'Force', 'status' => 'Opérationnel', 'last_checked_at' => '2026-05-22'],
            ['name' => 'Rack musculation B', 'type' => 'Force', 'status' => 'Alerte', 'last_checked_at' => '2026-05-15'],
            ['name' => 'Presse à cuisse', 'type' => 'Force', 'status' => 'Opérationnel', 'last_checked_at' => '2026-05-28'],
        ];

        foreach ($equipements as $equipement) {
            Equipement::create($equipement);
        }
    }
}