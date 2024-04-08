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
        Schema::create('masters', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true); 
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->unsignedInteger('receive_email')->nullable();
            $table->unsignedInteger('receive_sms')->nullable();
            $table->unsignedInteger('receive_app')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

        }); 
    }
     
    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('masters');
    }

};
