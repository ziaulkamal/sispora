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
        Schema::create('additional_schedules_special', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('schedulesId');
            $table->enum('match', ['qualified', 'group', 'grandfinal']);
            $table->string('group')->nullable();
            $table->uuid('kontingenId');
            $table->string('score')->nullable();
            $table->enum('status', ['win', 'lose', 'default'])->default('default');
            $table->timestamps();

            $table->foreign('schedulesId')->references('id')->on('schedules')->cascadeOnDelete();
            $table->foreign('kontingenId')->references('id')->on('kontingens')->cascadeOnDelete();
        });

        Schema::create('additional_schedules_regular', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('schedulesId');
            $table->uuid('kontingenId');
            $table->enum('typeScore', ['minutes', 'weight', 'distance', 'default'])->default('default');
            $table->string('score')->nullable();
            $table->enum('status', ['win', 'lose', 'default'])->default('default');
            $table->timestamps();

            $table->foreign('schedulesId')->references('id')->on('schedules')->cascadeOnDelete();
            $table->foreign('kontingenId')->references('id')->on('kontingens')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_schedules_regular');
        Schema::dropIfExists('additional_schedules_special');
    }
};
