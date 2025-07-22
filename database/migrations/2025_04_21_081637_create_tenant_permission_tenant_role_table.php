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
        Schema::create('tenant_permission_tenant_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_role_id')->constrained('tenant_roles')->cascadeOnDelete();
            $table->foreignId('tenant_permission_id')->constrained('tenant_permissions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_permission_tenant_role');
    }
};
