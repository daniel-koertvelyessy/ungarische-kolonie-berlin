<?php

declare(strict_types=1);

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
        Schema::create('member_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->date('designated_at');
            $table->date('resigned_at')->nullable();
            $table->json('about_me')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamps();

            // Optional: Unique constraint to enforce one active role per member
            $table->unique(['member_id', 'role_id', 'designated_at']);
        });

        // A member can on have one active role
        Schema::table('member_role', function (Blueprint $table) {
            DB::statement('CREATE UNIQUE INDEX one_active_role ON member_role (member_id) WHERE resigned_at IS NULL');
        });
    }
};
