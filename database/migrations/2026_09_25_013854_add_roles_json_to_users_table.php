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
        Schema::table('users', function (Blueprint $table) {
            $table->json('roles')->nullable()->after('password');
        });

        DB::table('users')->orderBy('id')->each(function (object $user): void {
            $roleName = $user->role_id
                ? DB::table('roles')->where('id', $user->role_id)->value('name')
                : 'admin';

            DB::table('users')->where('id', $user->id)->update([
                'roles' => json_encode([$roleName]),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
        });
    }
};
