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
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->uuid('sports_sub_id');
            $table->uuid('venue_id');
            $table->enum('status', ['active', 'inactive']);
            $table->uuid('user_id')->nullable();
            $table->timestamps();

            // $table->foreign('sports_sub_id')->references('id')->on('sports_subs')->cascadeOnDelete();
            // $table->foreign('venue_id')->references('id')->on('venues')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
