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
        Schema::create('event_timelines', function (Blueprint $table) {
            $table->id();
            $table->time('start');
            $table->integer('duration')->nullable();
            $table->time('end');
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('title')->index();
            $table->string('description')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('member_id')->nullable();
            $table->foreignId('user_id')->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }
};
