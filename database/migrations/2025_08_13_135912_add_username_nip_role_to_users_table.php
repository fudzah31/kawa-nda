<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 50)->nullable()->after('id')->unique();
            }

            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip', 30)->nullable()->after('username');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'user'])->default('user')->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique('users_username_unique');
                $table->dropColumn('username');
            }
        });
    }
};
