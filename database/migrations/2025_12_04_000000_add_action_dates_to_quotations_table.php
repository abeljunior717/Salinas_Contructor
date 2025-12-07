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
        Schema::table('quotations', function (Blueprint $table) {
            $table->dateTime('approved_at')->nullable()->after('valid_until');
            $table->dateTime('rejected_at')->nullable()->after('approved_at');
            $table->dateTime('payment_deadline')->nullable()->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['approved_at', 'rejected_at', 'payment_deadline']);
        });
    }
};
