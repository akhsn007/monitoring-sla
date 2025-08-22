<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('ip_address');
        $table->boolean('is_down')->default(false); // Untuk status jaringan
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
