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
        // ..._create_badges_table.php
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Bronze, Silver, Gold, Diamond
            $table->bigInteger('min_donation'); // Syarat total donasi minimum
            $table->string('icon_url')->nullable(); // Link ke gambar badge
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
