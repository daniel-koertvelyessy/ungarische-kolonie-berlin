<?php

declare(strict_types=1);

use App\Enums\MemberFeeType;
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
            $table->enum('fee_type', MemberFeeType::toArray())->default(MemberFeeType::FULL->value);
        });
    }
};
