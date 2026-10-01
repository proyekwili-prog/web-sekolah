<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_sekolahs', function (Blueprint $table) {
            $table->id('id_profile');
            $table->string('nama_sekolah');
            $table->string('kepala_sekolah');
            $table->string('foto', 100)->nullable();
            $table->string('logo', 100)->nullable();
            $table->string('npsn', 10);
            $table->text('alamat');
            $table->string('kontak', 15);
            $table->text('visi_misi');
            $table->year('tahun_berdiri');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sekolahs');
    }
};
