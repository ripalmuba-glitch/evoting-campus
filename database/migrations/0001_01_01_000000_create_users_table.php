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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        // Bisa untuk Email atau NIM
        $table->string('email')->unique();
        $table->string('password');
        // Role: admin atau voter. Defaultnya voter.
        $table->enum('role', ['admin', 'voter'])->default('voter');
        // Status apakah sudah memilih (untuk simple check)
        $table->boolean('is_voted')->default(false);
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
