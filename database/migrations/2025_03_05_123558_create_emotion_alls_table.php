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
        Schema::create('emotion_alls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emotion_id')->constrained('emotions')->onDelete('cascade');
            $table->foreignId('ayat_id')->nullable()->constrained('ayats')->onDelete('cascade');
            $table->foreignId('ad3ya_id')->nullable()->constrained('ad3yas')->onDelete('cascade');
            $table->foreignId('ahadeth_id')->nullable()->constrained('ahadeths')->onDelete('cascade');
            $table->foreignId('azkar_id')->nullable()->constrained('azkars')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emotion_alls');
    }
};
