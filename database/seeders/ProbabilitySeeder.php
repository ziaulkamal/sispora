<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Probability;
use Illuminate\Support\Str;

class ProbabilitySeeder extends Seeder
{
    public function run()
    {
        $labels = ['atlet', 'coach', 'official', 'transport', 'wasit', 'panitia'];

        foreach ($labels as $label) {
            Probability::create([
                'id' => (string) Str::uuid(),
                'label' => $label,
            ]);
        }
    }
}
