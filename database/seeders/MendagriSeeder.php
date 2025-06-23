<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MendagriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('db_mendagri.sql');

        if (!File::exists($path)) {
            $this->command->error("File db_mendagri.sql tidak ditemukan.");
            return;
        }

        $sql = File::get($path);
        DB::unprepared($sql);

        $this->command->info("db_mendagri.sql berhasil di-import.");
    }
}
