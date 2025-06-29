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
        Schema::create('account_report_audits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('account_report_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_approved')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('reason')->nullable();

        });
    }
};
