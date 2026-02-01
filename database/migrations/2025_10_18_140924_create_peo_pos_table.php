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
        Schema::create('peo_pos', function (Blueprint $table) {
            $table->id();
            $table->integer('b1')->nullable();
            $table->integer('b2')->nullable();
            $table->integer('b3')->nullable();
            $table->integer('c1')->nullable();
            $table->integer('c2')->nullable();
            $table->integer('c3')->nullable();
            $table->integer('c4')->nullable();
            $table->integer('c5')->nullable();
            $table->integer('c6')->nullable();
            $table->integer('c7')->nullable();
            $table->integer('c8')->nullable();
            $table->integer('c9')->nullable();
            $table->string('d1', 265)->nullable();
            $table->string('d2', 265)->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peo_pos');
    }
};
