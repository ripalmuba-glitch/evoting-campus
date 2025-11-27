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
    Schema::create('candidates', function (Blueprint $table) {
        $table->id();
        // Menghubungkan kandidat ke pemilihan tertentu (Foreign Key)
        $table->foreignId('election_id')->constrained('elections')->onDelete('cascade');
        $table->string('name');
        $table->string('photo')->nullable(); // Path foto
        $table->text('vision_mission')->nullable();
        // Menyimpan jumlah suara sementara (opsional, agar query cepat)
        $table->integer('total_votes')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
