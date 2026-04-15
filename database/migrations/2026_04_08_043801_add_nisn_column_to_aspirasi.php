<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom nisn sudah ada
        if (!Schema::hasColumn('aspirasi', 'nisn')) {
            Schema::table('aspirasi', function (Blueprint $table) {
                $table->string('nisn', 20)->nullable()->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('aspirasi', 'nisn')) {
            Schema::table('aspirasi', function (Blueprint $table) {
                $table->dropColumn('nisn');
            });
        }
    }
};