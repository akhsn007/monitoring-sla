<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_entries', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('ip_address');
            $table->enum('root_cause', ['Koneksi Terputus', 'Perangkat Mati', 'Masalah Listrik', 'Serangan DDoS', 'CPU Tinggi', 'Memori Penuh', 'Lainnya']);
            $table->enum('status', ['up', 'down']);
            $table->timestamp('timestamp')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_entries');
    }
};
