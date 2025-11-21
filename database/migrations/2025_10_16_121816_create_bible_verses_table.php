<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('bible_verses', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->string('book');
            $table->unsignedInteger('chapter');
            $table->unsignedInteger('verse');
            $table->text('text');
            $table->timestamps();

            $table->index(['version', 'book', 'chapter', 'verse']);
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('bible_verses');
    }
};