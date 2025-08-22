<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('log_entries', function (Blueprint $table) {
        $table->text('root_cause')->change();
    });
}

public function down()
{
    Schema::table('log_entries', function (Blueprint $table) {
        $table->string('root_cause', 255)->change();
    });
}

};
