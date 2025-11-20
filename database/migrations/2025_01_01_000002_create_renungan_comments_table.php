<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenunganCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('renungan_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renungan_id')->constrained('renungans')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('renungan_comments');
    }
}
