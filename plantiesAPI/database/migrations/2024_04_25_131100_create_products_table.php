<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_quantity');
            $table->string('image_path')->nullable();
            $table->float('price');
            $table->string('name');
            $table->text('info')->nullable();
            $table->integer('number_sold')->default(0);
            $table->integer('care_level')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
