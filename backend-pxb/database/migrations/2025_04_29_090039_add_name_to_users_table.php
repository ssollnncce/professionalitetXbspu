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
            
            //Delete old columns / Удаляем старые колонки
            $table->dropColumn('name');

            //Add new columns / Добавляем новые колонки
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('patronymic')->after('last_name');
            $table->string('phone', 16)->after('patronymic')->unique();
            $table->string('profile_photo_path')->after('phone')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //Add old columns / Добавляем старые колонки
            $table->string('name')->after('id');

            //Delete new columns / Удаляем новые колонки
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('patronymic');
            $table->dropColumn('phone');
            $table->dropColumn('profile_photo_path');
            
        });
    }
};
