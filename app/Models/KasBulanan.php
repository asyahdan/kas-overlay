<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasBulanan extends Model
{
    protected $fillable = ['bulan', 'tahun', 'nominal_kas'];

    public function pembayarans() { return $this->hasMany(Pembayaran::class); }

    public function getLabelAttribute(): string
    {
        return \Carbon\Carbon::create($this->tahun, $this->bulan, 1)->translatedFormat('F Y');
    }
}
