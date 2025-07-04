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
        // Drop the old table if it exists (important!)
        Schema::dropIfExists('role_permission');

        // Create the new, correctly structured pivot table
        Schema::create('role_permission', function (Blueprint $table) {
            // Using unsignedBigInteger for consistency with `id()` and `foreignId()`
            $table->unsignedBigInteger('roleId');
            $table->unsignedBigInteger('permissionId');

            // Define foreign key constraints
            $table->foreign('roleId')->references('id')->on('role')->onDelete('cascade');
            $table->foreign('permissionId')->references('id')->on('permissions')->onDelete('cascade');

            // Set a composite primary key to ensure uniqueness for each role-permission pair
            $table->primary(['roleId', 'permissionId']);

            $table->timestamps(); // Optional, but good practice for auditing
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
