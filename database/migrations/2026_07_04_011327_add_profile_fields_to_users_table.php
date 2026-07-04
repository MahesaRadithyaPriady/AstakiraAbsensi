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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->text('alamat')->nullable()->after('nama');
            $table->date('tanggal_lahir')->nullable()->after('alamat');
            $table->string('nisp')->nullable()->after('tanggal_lahir');
            $table->string('foto_profile')->nullable()->after('nisp');
            $table->enum('role', ['admin', 'karyawan', 'pkl'])->default('karyawan')->after('foto_profile');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn(['nama', 'alamat', 'tanggal_lahir', 'nisp', 'foto_profile', 'role']);
        });
    }
};
