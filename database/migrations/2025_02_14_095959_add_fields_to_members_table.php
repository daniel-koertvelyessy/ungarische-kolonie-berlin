<?php

use App\Enums\MemberFamilyStatus;
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
        Schema::table('members', function (Blueprint $table) {
            $table->string('birth_place')->nullable();
            $table->string('citizenship')->nullable();
            $table->enum('family_status', MemberFamilyStatus::toArray())->nullable();

        });
    }
};
