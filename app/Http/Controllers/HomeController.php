<?php
namespace App\Http\Controllers;

use App\Models\{KasBulanan, Pembayaran, Setting};

class HomeController extends Controller
{
    public function index()
    {
        $kas = KasBulanan::orderByDesc('tahun')->orderByDesc('bulan')->first();
        $payers = $kas
            ? Pembayaran::with('user')->where('kas_bulanan_id', $kas->id)->where('status', 'lunas')->get()
            : collect();

        return view('home', [
            'kas'    => $kas,
            'payers' => $payers,
            'total'  => Pembayaran::where('status', 'lunas')->sum('jumlah_bayar'),
            'qris'   => Setting::get('qris_path'),
        ]);
    }
}
