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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('company_categories');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable()->default(null);
            $table->integer('price');
            $table->string('plan_type')->default('monthly'); // monthly, yearly
            $table->integer('duration')->default(1);
            $table->string('duration_unit')->default('months');
            $table->integer('trial_duration')->default(0);
            $table->string('trial_duration_unit')->default('months');
            $table->integer('discount_amount')->nullable()->default(0);
            $table->string('note')->nullable()->default(null);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
