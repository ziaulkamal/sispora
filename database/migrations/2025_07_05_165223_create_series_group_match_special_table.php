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
        Schema::create('series_group_match_special', function (Blueprint $table) {
            $table->id();
            $table->string('kontingenId');
            $table->uuid('sports_subs_id');
            $table->uuid('sportId');
            $table->string('group')->nullable();
            $table->timestamps();

            $table->foreign('sportId')->references('id')->on('sports')->cascadeOnDelete();
            $table->foreign('kontingenId')->references('id')->on('kontingens')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series_group_match_special');
    }
};
