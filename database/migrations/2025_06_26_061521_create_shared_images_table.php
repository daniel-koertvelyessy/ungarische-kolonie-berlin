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
        Schema::create('shared_images', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // später evtl. JSON
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('invitation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('path'); // z. B. images/original/uuid.jpg
            $table->string('thumbnail_path')->nullable(); // images/thumbs/uuid.jpg
            $table->boolean('is_approved')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->json('dimensions')->nullable(); // {"width":123,"height":456}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_images');
    }
};
