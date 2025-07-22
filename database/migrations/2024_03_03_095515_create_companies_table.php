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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn');
            $table->foreignId('category_id')->constrained('company_categories');
            $table->string('email')->unique()->default(null)->nullable();
            $table->string('mobile_number')->unique();
            $table->string('additional_mobile_number')->nullable();
            $table->timestamp('mobile_number_verified_at')->nullable();
            $table->string('domain')->default(null)->nullable();
            $table->string('workspace')->unique();
            $table->json('allowed_domains')->nullable()->default(null);
            $table->string('otp')->nullable()->default(null);
            $table->timestamp('otp_expire_at')->nullable()->default(null);
            $table->foreignId('division_id')->nullable()->default(null);
            $table->foreignId('district_id')->nullable()->default(null);
            $table->foreignId('upazila_id')->nullable()->default(null);
            $table->foreignId('union_id')->nullable()->default(null);
            $table->string('village')->nullable()->default(null);
            $table->boolean('is_onboarding_completed')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
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
        Schema::dropIfExists('companies');
    }
};
