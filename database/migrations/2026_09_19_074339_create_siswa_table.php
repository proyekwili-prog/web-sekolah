<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah 'siswas' menjadi 'siswa'
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 10)->unique();
            $table->string('nama_siswa', 40);
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->year('tahun_masuk');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Ubah 'siswas' menjadi 'siswa'
        Schema::dropIfExists('siswa');
    }
};
