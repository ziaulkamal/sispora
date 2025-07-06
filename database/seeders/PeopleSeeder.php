<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;

class PeopleSeeder extends Seeder
{
    public function run()
    {
        Person::factory()->count(20)->create();
    }
}
