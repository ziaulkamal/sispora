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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('peopleId');
            $table->string('imageProfile')->nullable();
            $table->string('familyProfile')->nullable();
            $table->string('selfieProfile')->nullable();
            $table->string('path')->nullable();
            $table->uuid('imageId')->nullable();
            $table->json('extra')->nullable();
            $table->uuid('userId')->nullable();
            $table->timestamps();

            // Foreign key constraint ke people.documentId
            $table->foreign('peopleId')->references('id')->on('people')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
