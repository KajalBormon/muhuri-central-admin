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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->enum('type', ['sale', 'expense', 'purchase'])->default('expense');
            $table->foreignId('parent_id')->nullable()->constrained('items');
            $table->string('item_type')->nullable()->default(null);
            $table->foreignId('category_id')->nullable()->constrained('company_categories');
            $table->string('description')->nullable()->default(null);
            $table->integer('display_order')->default(0);
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
        Schema::dropIfExists('items');
    }
};
