<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique(); // ID único do produto
            $table->string('name'); // Nome do produto
            $table->text('description')->nullable(); // Descrição detalhada
            $table->integer('amount')->default(0); // Quantidade em estoque
            $table->decimal('price', 10, 2); // Preço unitário
            $table->decimal('total_price', 15, 2)->nullable(); // Preço total (calculado)
            $table->string('sku')->nullable(); // SKU (identificador único no estoque)
            $table->string('barcode')->nullable(); // Código de barras
            $table->string('supplier')->nullable(); // Nome do fornecedor
            $table->string('supplier_contact')->nullable(); // Contato do fornecedor
            $table->string('category')->nullable(); // Categoria do produto
            $table->string('brand')->nullable(); // Marca do produto
            $table->string('location')->nullable(); // Localização no estoque
            $table->integer('minimum_stock'); // Estoque mínimo
            $table->boolean('is_active')->default(true); // Produto ativo ou inativo
            $table->string('unit')->default('pcs'); // Unidade de medida (ex: pcs, kg, etc.)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
