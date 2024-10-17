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
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('logo_sekolah')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->string('telepon_sekolah')->nullable();
            $table->string('email_sekolah')->nullable();
            $table->string('website_sekolah')->nullable();
            $table->string('alamat_sekolah')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->string('nip_kepala_sekolah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};