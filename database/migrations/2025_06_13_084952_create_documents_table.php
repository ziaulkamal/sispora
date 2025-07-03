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

            // Image Profile
            $table->string('imageProfile')->nullable();
            $table->enum('imageProfile_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('imageProfile_note')->nullable();

            // Identity
            $table->string('identityProfile')->nullable();
            $table->enum('identityProfile_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('identityProfile_note')->nullable();

            // Family Card
            $table->string('familyProfile')->nullable();
            $table->enum('familyProfile_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('familyProfile_note')->nullable();

            // Certificate
            $table->string('personalCertificate')->nullable();
            $table->enum('personalCertificate_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('personalCertificate_note')->nullable();

            // Last Diploma
            $table->string('lastDiploma')->nullable();
            $table->enum('lastDiploma_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('lastDiploma_note')->nullable();

            // Supporting PDF
            $table->string('supportPdf')->nullable();
            $table->enum('supportPdf_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('supportPdf_note')->nullable();

            $table->uuid('userId')->nullable();
            $table->timestamps();

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
