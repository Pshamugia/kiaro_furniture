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
    Schema::create('products', function (Blueprint $table) {
        $table->id();

        $table->foreignId('category_id')->constrained()->cascadeOnDelete();

        $table->string('title');
        $table->decimal('price', 10, 2);
        $table->string('color')->nullable();
        $table->text('description')->nullable();

        $table->string('photo1')->nullable();
        $table->string('photo2')->nullable();
        $table->string('photo3')->nullable();
        $table->string('photo4')->nullable();
        $table->string('photo5')->nullable();
        $table->string('photo6')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
