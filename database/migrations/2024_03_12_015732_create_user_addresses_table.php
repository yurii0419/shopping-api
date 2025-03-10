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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('street')->nullable();
            $table->text('city')->nullable();
            $table->text('province')->nullable();
            $table->text('region')->nullable();
            $table->text('zip_code')->nullable();
            $table->boolean('is_default')->default(0)->nullable();
            $table->boolean('is_deleted')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
