<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mobil extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mobils';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'nopolisi', 'merk', 'jenis', 'harga', 'kapasitas', 'status_mobil', 'foto'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
    public function transaksi()
{
    return $this->hasMany(Transaksi::class, 'mobil_id', 'id');
}


}
