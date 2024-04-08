<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'buildings',
            function (Blueprint $table) {
                $table->unsignedBigInteger('id', true);
                $table->string('name');
                $table->string('phone');
                $table->string('email');
                $table->string('website');
                $table->string('address');
                $table->string('city');
                $table->string('state');
                $table->string('zip');
                $table->string('country');
                $table->string('image');
                $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
                $table->foreignId('assistant_id')->constrained('assistants')->cascadeOnDelete();
                $table->foreignId('maintenance_id')->constrained('maintenances')->cascadeOnDelete();
                $table->foreignId('technician_id')->constrained('technicians')->cascadeOnDelete();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }

    /*
        assistant
        property manager
        maintenance manager
        technician
    */
};

/*
Este trecho de código PHP é uma classe de migração usando o Laravel, um framework PHP. Esta migração é responsável por definir a estrutura da tabela buildings em um banco de dados. Vamos examinar o que cada parte do código faz:

Estrutura da Tabela buildings
Schema::create('buildings', function (Blueprint $table) {...});: Cria uma nova tabela chamada buildings no banco de dados.

$table->id();: Define uma coluna id como chave primária autoincrementável da tabela. Esta é uma convenção do Laravel para IDs.

$table->string('name');: Adiciona uma coluna chamada name do tipo VARCHAR para armazenar o nome do edifício.

$table->string('address');: Adiciona uma coluna address para armazenar o endereço do edifício.

$table->string('city');: Adiciona uma coluna city para armazenar a cidade onde o edifício está localizado.

$table->string('zip');: Adiciona uma coluna zip para armazenar o código postal do edifício.

$table->string('country');: Adiciona uma coluna country para armazenar o país do edifício.

$table->foreignId('property_id')->constrained('property')->cascadeOnDelete();: Define uma coluna property_id como chave estrangeira que referencia a tabela property. A opção cascadeOnDelete indica que, se o registro referenciado em property for excluído, todos os registros correspondentes em buildings também serão excluídos.

$table->foreignId('assistant_id')...: Similar ao property_id, mas para a tabela assistant.

$table->foreignId('maintenance_id')...: Similar ao property_id, mas para a tabela maintenance.

$table->foreignId('technician_id')...: Similar ao property_id, mas para a tabela technician.

$table->timestamps();: Adiciona as colunas created_at e updated_at à tabela, que são automaticamente gerenciadas pelo Laravel para registrar quando cada registro foi criado ou atualizado.

Reversão da Migração
public function down(): void {...}: Define como reverter a migração, neste caso, deletando a tabela buildings. Isso é útil para desfazer a migração, se necessário.
Comentários
Os comentários no final sugerem que as tabelas assistant, property, maintenance, e technician estão relacionadas com a tabela buildings através das chaves estrangeiras. Estas tabelas provavelmente armazenam informações sobre assistentes, gerentes de propriedade, gerentes de manutenção e técnicos, respectivamente.
Essa migração facilita a manutenção da integridade referencial do banco de dados, garantindo que todos os dados relacionados sejam consistentes e atualizados de acordo com as operações de criação, atualização e exclusão.
*/
