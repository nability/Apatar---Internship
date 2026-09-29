<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('role_module_access', function (Blueprint $table) {
            $table->string('role_key')->nullable()->after('role_id');
        });

        DB::table('role_module_access')->orderBy('id')->each(function (object $access): void {
            $roleKey = DB::table('roles')->where('id', $access->role_id)->value('name');

            DB::table('role_module_access')->where('id', $access->id)->update([
                'role_key' => $roleKey,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_module_access', function (Blueprint $table) {
            $table->dropColumn('role_key');
        });
    }
};
