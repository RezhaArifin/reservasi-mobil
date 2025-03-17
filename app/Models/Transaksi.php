<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksis';
    protected $primarykey = 'id';
    protected $fillable = [
        'id',
        'mobil_id',
        'nama',
        'ponsel',
        'alamat',
        'tanggal_pesan',
        'tanggal_kembali',
        'biaya_driver',
        'dp_bayar',
        'total',
        'denda',
        'status',
        'kode_booking',
        'snap_token'
    ];

    public function mobil(): BelongsTo
    {
        return $this->belongsTo(Mobil::class, 'mobil_id')->withDefault();
    }

    public function getHariTerlambatAttribute()
    {
        // Pastikan status transaksi adalah 'PROSES' sebelum menghitung hari terlambat
        $now = Carbon::now()->setTimezone('Asia/Jakarta')->startOfDay();
        $tanggal_kembali = Carbon::parse($this->tanggal_kembali)->setTimezone('Asia/Jakarta')->startOfDay();

        // Jika tanggal kembali sudah lewat, hitung selisih hari terlambat
        if ($now->greaterThan($tanggal_kembali)) {
            return $now->diffInDays($tanggal_kembali, true); // Selisih hari terlambat
        }

        return 0; // Tidak terlambat jika tanggal kembali belum lewat
    }

    public function hitungDenda()
    {
        // Pastikan status transaksi adalah 'PROSES' sebelum menghitung denda
        $harga = $this->mobil ? $this->mobil->harga : 0;
        $hariTerlambat = $this->hari_terlambat;

        // Jika menggunakan driver, tambahkan biaya tambahan per hari keterlambatan
        if ($this->biaya_driver === 'With-Drive') {
            $harga += 50000; // Biaya tambahan driver
        }

        // Menghitung denda berdasarkan hari terlambat
        return $harga * $hariTerlambat;
    }


    public function getDendaAttribute()
    {
        return $this->hitungDenda();
    }

    public function getTotalWithDendaAttribute()
    {
        return $this->total + $this->denda;
    }


    protected static function booted()
    {
        static::saving(function ($transaksi) {
            // Hanya hitung denda di hook jika belum dihitung di controller
            if ($transaksi->isDirty('tanggal_kembali') || $transaksi->isDirty('status')) {
                $transaksi->denda = $transaksi->hitungDenda();
            }
        });
    }
}
