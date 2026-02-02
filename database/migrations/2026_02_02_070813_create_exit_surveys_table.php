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
        Schema::create('exit_surveys', function (Blueprint $table) {
            $table->id();
            $table->integer('a1')->nullable();
            $table->integer('a2')->nullable();
            $table->integer('a3')->nullable();
            $table->integer('a4')->nullable();
            $table->integer('a5')->nullable();
            $table->integer('a6')->nullable();
            $table->integer('a7')->nullable();
            $table->integer('a8')->nullable();
            $table->integer('a9')->nullable();
            $table->integer('a10')->nullable();
            $table->integer('b1')->nullable();
            $table->integer('b2')->nullable();
            $table->integer('b3')->nullable();
            $table->integer('b4')->nullable();
            $table->text('b5')->nullable();
            $table->integer('c1')->nullable();
            $table->integer('c2')->nullable();
            $table->integer('c3')->nullable();
            $table->integer('c4')->nullable();
            $table->integer('c5')->nullable();
            $table->integer('c6')->nullable();
            $table->integer('c7')->nullable();
            $table->integer('d1')->nullable();
            $table->integer('d2')->nullable();
            $table->integer('d3')->nullable();
            $table->integer('d4')->nullable();
            $table->integer('d5')->nullable();
            $table->integer('e1')->nullable();
            $table->integer('e2')->nullable();
            $table->integer('e3')->nullable();
            $table->integer('e4')->nullable();
            $table->text('e5')->nullable();
            $table->integer('e6')->nullable();
            $table->integer('e7')->nullable();
            $table->integer('e8')->nullable();
            $table->integer('e9')->nullable();
            $table->integer('e10')->nullable();
            $table->integer('f1')->nullable();
            $table->integer('f2')->nullable();
            $table->integer('f3')->nullable();
            $table->integer('f4')->nullable();
            $table->integer('f5')->nullable();
            $table->integer('f6')->nullable();
            $table->integer('f7')->nullable();
            $table->integer('f8')->nullable();
            $table->integer('f9')->nullable();
            $table->integer('f10')->nullable();
            $table->integer('f11')->nullable();
            $table->integer('f12')->nullable();
            $table->text('f13')->nullable();
            $table->text('f14')->nullable();
            $table->text('f15')->nullable();
            $table->text('f16')->nullable();
            $table->text('f17')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exit_surveys');
    }
};
