<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check database connection type
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'mysql') {
            // MySQL syntax
            DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'dipinjam', 'menunggu_konfirmasi_kembali', 'dikembalikan', 'terlambat', 'ditolak')");
        } else {
            // For other databases (PostgreSQL, SQLite, etc.)
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->string('status_temp')->nullable();
            });

            // Copy data
            DB::table('peminjaman')->update(['status_temp' => DB::raw('status')]);

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->dropColumn('status');
            });

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->enum('status', ['menunggu', 'disetujui', 'dipinjam', 'menunggu_konfirmasi_kembali', 'dikembalikan', 'terlambat', 'ditolak']);
            });

            // Restore data
            DB::table('peminjaman')->update(['status' => DB::raw('status_temp')]);

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->dropColumn('status_temp');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check database connection type
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'mysql') {
            // MySQL syntax
            DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'terlambat', 'ditolak')");
        } else {
            // For other databases (PostgreSQL, SQLite, etc.)
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->string('status_temp')->nullable();
            });

            // Copy data
            DB::table('peminjaman')->update(['status_temp' => DB::raw('status')]);

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->dropColumn('status');
            });

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->enum('status', ['menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'terlambat', 'ditolak']);
            });

            // Restore data
            DB::table('peminjaman')->update(['status' => DB::raw('status_temp')]);

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->dropColumn('status_temp');
            });
        }
    }
};
