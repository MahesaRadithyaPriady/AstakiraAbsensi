<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembimbing_pkl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembimbing_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pkl_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['pembimbing_id', 'pkl_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembimbing_pkl');
    }
};
