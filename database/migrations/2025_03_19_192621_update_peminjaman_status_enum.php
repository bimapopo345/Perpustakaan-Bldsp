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
        // Create temporary column
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('status_temp')->nullable();
        });

        // Copy data to temporary column
        DB::table('peminjaman')->update([
            'status_temp' => DB::raw('status')
        ]);

        // Drop existing enum column
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Create new enum column with updated values
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'dipinjam',
                'menunggu_konfirmasi_pengembalian',
                'dikembalikan',
                'terlambat',
                'ditolak'
            ]);
        });

        // Restore data from temporary column
        DB::table('peminjaman')->update([
            'status' => DB::raw('status_temp')
        ]);

        // Drop temporary column
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('status_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create temporary column
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('status_temp')->nullable();
        });

        // Copy data to temporary column
        DB::table('peminjaman')->update([
            'status_temp' => DB::raw('status')
        ]);

        // Drop existing enum column
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Restore original enum column
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'dipinjam',
                'dikembalikan',
                'terlambat',
                'ditolak'
            ]);
        });

        // Restore data from temporary column, replacing new status with 'dipinjam'
        DB::statement("
            UPDATE peminjaman 
            SET status = CASE 
                WHEN status_temp = 'menunggu_konfirmasi_pengembalian' THEN 'dipinjam'
                ELSE status_temp 
            END
        ");

        // Drop temporary column
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('status_temp');
        });
    }
};
