<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->text('payload');
            $table->integer('last_activity');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
