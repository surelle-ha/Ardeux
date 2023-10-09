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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('status');
            $table->string('tokenCount');
            $table->string('type');
            $table->string('transaction');
            $table->string('previousSupply');
            $table->string('newSupply');
            $table->string('error');
            $table->string('timestampRequested');
            $table->string('timestampCompleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
