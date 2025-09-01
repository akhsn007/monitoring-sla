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
        Schema::table('log_entries', function (Blueprint $table) {
            //
            $table->string('lastdown')->nullable()->after('status');
            $table->string('deviceid')->nullable()->after('lastdown');
            $table->string('downtime')->nullable()->after('deviceid');
            $table->string('lastup')->nullable()->after('downtime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_entries', function (Blueprint $table) {
            //
        });
    }
};
