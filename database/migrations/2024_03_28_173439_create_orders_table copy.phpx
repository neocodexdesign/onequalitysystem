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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->foreignId('teamleader_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->text('notes');
            $table->text('from');
            $table->text('unit');
            $table->string('size', 50); // Tamanho escolhido como 50, você pode ajustar conforme necessário
            $table->enum('status', ['CREATED', 'STARTED', 'DONE', 'SCHEDULE'])->default('CREATED');
            $table->dateTime('service_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
