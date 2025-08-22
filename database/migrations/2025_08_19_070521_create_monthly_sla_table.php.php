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
        // database/migrations/xxxx_xx_xx_create_monthly_sla_table.php
Schema::create('monthly_sla', function (Blueprint $table) {
    $table->id();
    $table->string('client_name');
    $table->integer('total');
    $table->integer('down');
    $table->float('sla');
    $table->string('month'); // format "2025-08"
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_sla');
    }
};
