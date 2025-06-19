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
            $table->uuid('id')->primary();
            $table->foreignId('roleId');
            $table->json('permissionIds');
            $table->timestamps();
        });

        Schema::table('role_permission', function (Blueprint $table) {
            // Check if the old column exists before renaming
            if (Schema::hasColumn('roles_permissions', 'permissionId')) {
                $table->renameColumn('permissionId', 'permissionIds');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
        Schema::table('role_permission', function (Blueprint $table) {
            // Check if the new column exists before renaming back
            if (Schema::hasColumn('roles_permissions', 'permissionIds')) {
                $table->renameColumn('permissionIds', 'permissionId');
            }
        });
    }

    // public function roleId(): RoleId
    // {
    //     return RoleId::fromString();
    // }
};
