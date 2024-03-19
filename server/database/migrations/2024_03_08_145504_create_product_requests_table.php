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
        Schema::create('product_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamp('requested_at');
            $table->string('status')->default(1);
            $table->string('size');
            $table->string('brand');
            $table->string('requested_by');
            $table->timestamps();
        });
        Schema::create('product_requests_link', function (Blueprint $table) {
            $table->id();
            $table->string('request_id');
            $table->text('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requests');
        Schema::dropIfExists('product_requests_link');
    }
};
