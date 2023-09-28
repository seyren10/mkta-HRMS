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
        Schema::table('offenses', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\EmployeeNTE::class)->constrained('employee_ntes')->cascadeOnDelete()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offenses', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\EmployeeNTE::class);
        });
    }
};
