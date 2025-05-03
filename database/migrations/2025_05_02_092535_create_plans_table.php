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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
        $table->string('name');
        $table->decimal('price', 8, 2);
        $table->string('currency')->default('INR');
        $table->boolean('is_popular')->default(false);
        $table->integer('max_websites')->nullable(); // null means unlimited
        $table->integer('storage_limit')->comment('Product insertion Limit');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
