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
        Schema::table('azkars', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('azkar_categories')->onDelete('cascade');
            $table->integer('azkar_count')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('azkars', function (Blueprint $table) {
            //
        });
    }
};
