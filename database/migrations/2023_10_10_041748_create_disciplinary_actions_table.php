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
        Schema::create('disciplinary_actions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\Violation::class)->constrained('violations')->cascadeOnDelete()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\DisciplinaryMeasure::class)->constrained('disciplinary_measures')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('offense_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_actions');
    }
};