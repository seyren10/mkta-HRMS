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
        Schema::create('pending_violations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\Employee::class)->constrained('employees')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Violation::class)->constrained('violations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->longText('document_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_violations');
    }
};
