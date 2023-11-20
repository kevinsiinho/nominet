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
        Schema::create('horasextras', function (Blueprint $table) {
            $table->id();
            $table->datetime('llegada');
            $table->datetime('salida');
            $table->double('valor');
            $table->string('descrip1')->nullable();
            $table->string('descrip2')->nullable();
            $table->integer('users');
            $table->foreign('users')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horasextras');
    }
};
