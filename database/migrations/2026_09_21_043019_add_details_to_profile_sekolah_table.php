<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ganti 'profil_sekolah' menjadi 'profil_sekolahs'
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            $table->string('principal')->nullable()->after('kepala_sekolah');
            // tambahkan kolom lain jika ada...
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            $table->dropColumn('principal');
        });
    }
};
