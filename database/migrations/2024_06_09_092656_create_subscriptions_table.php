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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans');
            $table->foreignId('company_id')->constrained('companies');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('price');
            $table->integer('discount_amount')->default(0);
            $table->integer('final_price');
            $table->boolean('is_trial_taken')->default(false);
            $table->date('trial_start_date')->nullable()->default(null);
            $table->date('trial_end_date')->nullable()->default(null);
            $table->string('note')->nullable()->default(null);
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
        Schema::dropIfExists('subscriptions');
    }
};
