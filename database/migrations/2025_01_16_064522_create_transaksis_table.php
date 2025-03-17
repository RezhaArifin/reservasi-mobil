<?php

use App\Models\Mobil;
use App\Models\User;
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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Mobil::class);
            $table->string('nama')->nullable();
            $table->string('ponsel')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tanggal_pesan')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->string('biaya_driver')->null();
            $table->string('dp_bayar')->null();
            $table->string('total')->nullable();
            $table->string('denda')->null();
            $table->enum('status',['WAIT', 'PROSES', 'SELESAI'])->nullable();
            $table->string('kode_booking')->unique()->nullable();
            $table->string('snap_token')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
