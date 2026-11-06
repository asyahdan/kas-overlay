<?php
namespace App\Http\Controllers;

use App\Models\{KasBulanan, Pembayaran, Setting};

class PembayaranController extends Controller
{
    // Melihat tagihan + riwayat pembayaran milik user
    public function index()
    {
        $kas  = KasBulanan::orderByDesc('tahun')->orderByDesc('bulan')->get();
        $mine = Pembayaran::where('user_id', auth()->id())->get()->keyBy('kas_bulanan_id');
        return view('kas.index', compact('kas', 'mine'));
    }

    public function show(KasBulanan $kas)
    {
        return view('kas.bayar', [
            'kas'        => $kas,
            'qris'       => Setting::get('qris_path'),
            'pembayaran' => Pembayaran::where('user_id', auth()->id())->where('kas_bulanan_id', $kas->id)->first(),
        ]);
    }

    // Mode statik: user klik "Saya sudah bayar" -> pending, menunggu verifikasi admin
    public function store(KasBulanan $kas)
    {
        abort_unless(Setting::get('payment_mode', 'static') === 'static', 404);

        $p = Pembayaran::firstOrNew(['user_id' => auth()->id(), 'kas_bulanan_id' => $kas->id]);
        if ($p->status !== 'lunas') {
            $p->fill(['jumlah_bayar' => $kas->nominal_kas, 'status' => 'pending'])->save();
        }
        return redirect()->route('kas.index')->with('status', 'Terima kasih! Menunggu verifikasi admin.');
    }
}
