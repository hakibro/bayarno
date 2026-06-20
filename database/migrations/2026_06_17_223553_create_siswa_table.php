<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('idperson')->unique();
            $table->string('nama');
            $table->string('no_hp_asli');
            $table->string('no_hp_aktif');
            $table->string('unit_formal')->nullable();
            $table->string('kelas_formal')->nullable();
            $table->string('asrama_pondok')->nullable();
            $table->string('kamar_pondok')->nullable();
            $table->string('tingkat_diniyah')->nullable();
            $table->string('kelas_diniyah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
