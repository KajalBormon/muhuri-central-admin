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
            $table->boolean('tenant_permission_synced')->default(false)->after('job_position_synced');
            $table->boolean('tenant_role_synced')->default(false)->after('tenant_permission_synced');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_onboarding_steps', function (Blueprint $table) {
            $table->dropColumn('tenant_permission_synced');
            $table->dropColumn('tenant_role_synced');
        });
    }
};
