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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->json('title');
            $table->json('slug')->unique()->nullable();
            $table->json('description')->nullable();
            $table->unsignedSmallInteger('entry_fee')->nullable();
            $table->unsignedSmallInteger('entry_fee_discounted')->nullable();
            $table->foreignIdFor(\App\Models\Venue::class)->nullable()->constrained()->nullOnDelete();
        });
    }

};
