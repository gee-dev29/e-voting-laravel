<?php

use App\Http\Id\RoleId;
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
        Schema::create('role_permission', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('roleId');
            $table->string('permissionId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }

    // public function roleId(): RoleId
    // {
    //     return RoleId::fromString();
    // }
};
