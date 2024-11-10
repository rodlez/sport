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
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            // create the user_id column that be the foreign key id in the users DB Table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // create the category_id column that be the foreign key id in the categories DB Table
            $table->foreignId('category_id')->constrained('sport_categories');
            $table->boolean('status');
            $table->string('title', length: 200);
            $table->date('date');
            $table->string('location', length: 200);
            $table->unsignedSmallInteger('duration');
            $table->decimal('distance', total: 3, places: 1)->nullable();
            $table->string('url', 2083)->nullable();
            $table->text('info')->nullable();
            $table->timestamps();
        });

        Schema::table('sports', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
