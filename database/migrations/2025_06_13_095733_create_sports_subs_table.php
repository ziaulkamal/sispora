<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sports_subs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sportId');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
            $table->uuid('userId')->nullable();

            // Foreign key constraint
            $table->foreign('sportId')
                ->references('id')
                ->on('sports')
                ->onDelete('cascade'); // Opsional: Hapus sub saat sport dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports_subs');
    }
};
