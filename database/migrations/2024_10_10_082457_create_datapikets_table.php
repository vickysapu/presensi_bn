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
        // Menghapus tabel jika sudah ada
        Schema::dropIfExists('datapikets');

        Schema::create('datapikets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru');
            $table->string('hari_piket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datapikets');
    }
};
