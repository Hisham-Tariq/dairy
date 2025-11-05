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
            $table->foreignId('supervisor_id')->constrained('workers')->onDelete('cascade');
            $table->integer('number_of_trays');
            $table->integer('total_bowls')->nullable();
            $table->integer('total_tables')->nullable();
            $table->string('batch_number');
            $table->decimal('baking_temp', 5, 2);
            $table->integer('baking_time');
            $table->timestamps();
        });

        // Pivot table for mixers (many-to-many)
        Schema::create('dairy_production_mixers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dairy_production_id')->constrained()->onDelete('cascade');
            $table->foreignId('worker_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot table for packing machine workers (many-to-many)
        // Schema::create('dairy_production_packing_worker', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('dairy_production_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('worker_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dairy_production_packing_worker');
        Schema::dropIfExists('dairy_production_mixer');
        Schema::dropIfExists('dairy_productions');
    }
};