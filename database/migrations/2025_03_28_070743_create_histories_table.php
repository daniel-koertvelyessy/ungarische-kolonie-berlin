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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->morphs('historable'); // historable_id and historable_type for polymorphic relation
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Who made the change
            $table->string('action'); // e.g., 'created', 'updated', 'deleted'
            $table->json('changes')->nullable(); // Store old and new values for updates
            $table->timestamp('changed_at'); // When the change occurred
            $table->timestamps();

            $table->index(['historable_id', 'historable_type'], 'historable_index');
            $table->index('user_id');
            $table->index('changed_at');
        });
    }
};
