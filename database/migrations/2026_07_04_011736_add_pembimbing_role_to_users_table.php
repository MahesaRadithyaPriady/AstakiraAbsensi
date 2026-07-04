<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(255)");
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'karyawan'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'karyawan'");
    }
};
