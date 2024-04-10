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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->dateTime('updated');
            $table->dateTime('created');
            $table->string('summary');
            $table->string('status');
            $table->string('location');
            $table->string('description');
            $table->string('url');
            $table->string('event_id');
            $table->string('kind');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
