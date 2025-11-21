<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('goal_amount', 12, 2);
            $table->decimal('collected_amount', 12, 2)->default(0);
            $table->timestamps();
        });
    }


    
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
