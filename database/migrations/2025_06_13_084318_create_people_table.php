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
        Schema::create('people', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fullName');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('identityNumber')->unique();
            $table->string('familyIdentityNumber');
            $table->enum('gender', ['male', 'female']);
            $table->string('streetAddress');
            $table->integer('religion');
            $table->unsignedBigInteger('provinceId');
            $table->unsignedBigInteger('regencieId');
            $table->unsignedBigInteger('districtId');
            $table->unsignedBigInteger('villageId');
            $table->unsignedBigInteger('kontingenId')->nullable();
            $table->string('phoneNumber');
            $table->string('email')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->uuid('documentId')->nullable();
            $table->uuid('userId')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
