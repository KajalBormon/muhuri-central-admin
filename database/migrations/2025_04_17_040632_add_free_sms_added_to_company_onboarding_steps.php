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
            $table->boolean('free_sms_added')->default(false)->after('fiscal_year_synced');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_onboarding_steps', function (Blueprint $table) {
            $table->dropColumn('free_sms_added');
        });
    }
};
