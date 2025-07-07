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
        Schema::dropIfExists('role_permission');

        Schema::create('role_permission', function (Blueprint $table) {
            $table->uuid('roleId');
            $table->foreign('roleId')->references('id')->on('role')->onDelete('cascade');
            $table->uuid('permissionId');
            $table->foreign('permissionId')->references('id')->on('permission')->onDelete('cascade');

            // Set a composite primary key to ensure uniqueness for each role-permission pair
            $table->primary(['roleId', 'permissionId']);
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
