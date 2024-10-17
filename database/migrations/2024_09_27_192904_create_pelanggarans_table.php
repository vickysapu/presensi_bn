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
        if (!Schema::hasTable('pelanggaran')) {
            Schema::create('pelanggaran', function (Blueprint $table) {
                $table->id();
                $table->integer('id_pelanggaran');
                $table->string('nis');
                $table->string('keterangan')->nullable();
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
