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
        Schema::create('meeting_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meeting_minutes')->onDelete('cascade');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }
};
