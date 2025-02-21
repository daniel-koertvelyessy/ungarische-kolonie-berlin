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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('name')->nullable();
            $table->enum('gender', \App\Enums\Gender::toArray())->after('name')->nullable()->default(\App\Enums\Gender::ma);
            $table->string('username')->after('name')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->string('mobile')->after('email')->nullable();
            $table->boolean('is_admin')->after('password')->nullable();
            $table->enum('locale', \App\Enums\Locale::toArray())->after('name')->nullable()->default(\App\Enums\Locale::DE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'gender',
                'username',
                'phone',
                'mobile',
                'locale',
                'is_admin',
            ]);
        });
    }
};
