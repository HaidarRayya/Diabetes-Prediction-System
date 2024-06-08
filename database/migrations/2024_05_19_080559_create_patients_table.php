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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->integer("age");
            $table->integer("hypertension");
            $table->integer("heart_disease");
            $table->double("bmi");
            $table->double("HbA1c_level");
            $table->integer("blood_glucose_level");
            $table->boolean("diabetes");
            $table->integer('cluster')->default(-1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
