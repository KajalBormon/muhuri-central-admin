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
            $table->boolean('item_synced')->default(false)->after('subscription_synced');
            $table->boolean('brand_synced')->default(false)->after('item_synced');
            $table->boolean('fiscal_year_synced')->default(false)->after('brand_synced');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_onboarding_steps', function (Blueprint $table) {
            $table->dropColumn('item_synced');
            $table->dropColumn('brand_synced');
            $table->dropColumn('fiscal_year_synced');
        });
    }
};
