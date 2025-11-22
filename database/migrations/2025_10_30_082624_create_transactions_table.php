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
        // ..._create_transactions_table.php
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // NOTE: removed ->after('user_id') because "AFTER" is not valid in CREATE TABLE statements.
            // Use plain column definition here; position does not affect functionality.
            $table->unsignedBigInteger('donation_id')->nullable();
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('set null');

            // Tipe: 'initial_balance', 'donation', 'deposit', dll.
            $table->string('type');
            // Jumlah. Bisa positif (masuk) atau negatif (keluar)
            $table->bigInteger('amount');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // defensive: drop foreign key before dropping table when rolling back in DB engines that require it
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                if (Schema::hasColumn('transactions', 'donation_id')) {
                    $table->dropForeign(['donation_id']);
                }
            });
        }

        Schema::dropIfExists('transactions');
    }
};
