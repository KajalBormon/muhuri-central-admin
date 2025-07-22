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
        Schema::table('company_onboarding_steps', function (Blueprint $table) {
            $table->boolean('payment_method_synced')->default(false)->after('free_sms_added');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_onboarding_steps', function (Blueprint $table) {
            $table->dropColumn('payment_method_synced');
        });
    }
};
