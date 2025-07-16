<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->string('registration_number')->unique();
            $table->integer('year')->nullable();
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->decimal('rate_per_day', 8, 2)->nullable();
            $table->decimal('rate_per_km', 8, 2)->nullable();
            // $table->unsignedBigInteger('car_model_id')->nullable();
            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
