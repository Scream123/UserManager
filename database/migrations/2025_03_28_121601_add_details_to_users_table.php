<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique()->after('email');
            $table->foreignId('position_id')->constrained('positions')->after('phone');
            $table->string('photo')->nullable()->after('position_id');
            $table->dropColumn('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn(['phone', 'position_id', 'photo']);
            $table->string('password');
        });
    }

};
