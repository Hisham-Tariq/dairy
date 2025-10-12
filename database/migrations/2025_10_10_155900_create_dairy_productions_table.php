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
        Schema::create('dairy_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('mixer_id')->constrained('workers')->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained('workers')->onDelete('cascade');
            $table->integer('number_of_trays');
            $table->string('batch_number')->unique();
            $table->decimal('baking_temp', 5, 2);
            $table->integer('baking_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dairy_productions');
    }
};
