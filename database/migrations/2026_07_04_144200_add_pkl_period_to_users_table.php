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
            $table->date('tanggal_mulai_pkl')->nullable()->after('foto_profile');
            $table->date('tanggal_selesai_pkl')->nullable()->after('tanggal_mulai_pkl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai_pkl', 'tanggal_selesai_pkl']);
        });
    }
};
