<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['user_id', 'kas_bulanan_id', 'tanggal_bayar', 'jumlah_bayar', 'status', 'admin_verifikasi_id'];
    protected $casts = ['tanggal_bayar' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function kas()  { return $this->belongsTo(KasBulanan::class, 'kas_bulanan_id'); }
}
