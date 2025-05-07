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
        Schema::table('jadwal_belajar', function (Blueprint $table) {
            // Menambahkan kolom tanggal bertipe date
            $table->date('tanggal')->nullable(); // nullable agar tidak wajib diisi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_belajar', function (Blueprint $table) {
            // Menghapus kolom tanggal
            $table->dropColumn('tanggal');
        });
    }
};
