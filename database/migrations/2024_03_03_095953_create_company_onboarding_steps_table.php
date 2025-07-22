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
        Schema::create('company_onboarding_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->boolean('company_created')->default(false);
            $table->boolean('database_created')->default(false);
            $table->boolean('database_migrated')->default(false);
            $table->boolean('initial_data_loaded')->default(false);
            $table->boolean('user_created')->default(false);
            $table->boolean('subscription_synced')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_onboarding_steps');
    }
};
