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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->json('name')->unique(); // e.g., "President", "Financial Officer"
            $table->string('description')->nullable(); // Optional description of the role

            // Sets the order of apperance in the external display of the board
            // members and functions
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });
    }
};
