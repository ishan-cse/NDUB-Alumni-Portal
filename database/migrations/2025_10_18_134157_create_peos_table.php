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
        Schema::create('peos', function (Blueprint $table) {
            $table->id();
            $table->integer('b1')->nullable();
            $table->integer('b2')->nullable();
            $table->integer('b3')->nullable();
            $table->string('c1', 265)->nullable();
            $table->string('c2', 265)->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peos');
    }
};
