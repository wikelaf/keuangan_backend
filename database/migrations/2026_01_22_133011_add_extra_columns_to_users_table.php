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
        Schema::table('users', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('remember_token');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->string('photo')->nullable()->after('user_agent');
            $table->string('photo_thumb')->nullable()->after('photo');
            $table->string('fcmtoken')->nullable()->after('photo_thumb');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ip_address',
                'user_agent',
                'photo',
                'photo_thumb',
                'fcmtoken'
            ]);
        });
    }
};
