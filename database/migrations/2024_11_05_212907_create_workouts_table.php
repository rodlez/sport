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
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();           
            // create the type_id column that be the foreign key id in the types DB Table
            $table->foreignId('type_id')->constrained('workout_types');            
            $table->string('title', length: 200);
            $table->string('author', length: 200);            
            $table->unsignedSmallInteger('duration');   // range 0-255
            $table->string('url', length: 2048)->nullable();
            $table->text('description')->nullable();            
            $table->timestamps();
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->index('type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
