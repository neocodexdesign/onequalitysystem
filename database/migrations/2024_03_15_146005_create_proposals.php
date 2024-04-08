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
        Schema::create('proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('titulo_geral');
            $table->string('contact');
            $table->string('image_cover');
            $table->string('logo_cover');
            $table->string('titulo_images');
            $table->text('images');
            $table->string('titulo_description');
            $table->text('description');
            $table->text('addition_description');
            $table->text('additional_notes');
            $table->text('thanks');
            $table->foreignId('building_id')->constrained('buildings')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals'); //
    }
};
