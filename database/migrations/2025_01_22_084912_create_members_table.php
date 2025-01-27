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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('applied_at');
            $table->date('entered_at')->nullable();
            $table->date('left_at')->nullable();
            $table->boolean('is_discounted')->default(false);
            $table->dateTime('birth_date')->nullable();
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->enum('gender',\App\Enums\Gender::toArray())->nullable()->default(\App\Enums\Gender::ma);
            $table->enum('type',\App\Enums\MemberType::toArray())->default(\App\Enums\MemberType::ST);
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
