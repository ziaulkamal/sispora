<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('sports.sql');

        if (!File::exists($path)) {
            $this->command->error("File sports.sql tidak ditemukan.");
            return;
        }

        $sql = File::get($path);
        DB::unprepared($sql);

        $this->command->info("sports.sql berhasil di-import.");
    }
}
