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
        Schema::create('role_user', function (Blueprint $table) {
            $table->uuid('userId'); // Assuming user UUIDs
            $table->uuid('roleId'); // Assuming role UUIDs
            $table->primary(['userId', 'roleId']); // Composite primary key
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('roleId')->references('id')->on('role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
