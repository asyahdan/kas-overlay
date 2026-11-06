<?php
namespace App\Http\Controllers;

use App\Models\{KasBulanan, Pembayaran};
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'pending' => Pembayaran::with(['user', 'kas'])->where('status', 'pending')->latest()->get(),
            'kas'     => KasBulanan::withCount(['pembayarans as lunas_count' => fn ($q) => $q->where('status', 'lunas')])
                            ->withSum(['pembayarans as lunas_sum' => fn ($q) => $q->where('status', 'lunas')], 'jumlah_bayar')
                            ->orderByDesc('tahun')->orderByDesc('bulan')->get(),
        ]);
    }

    public function storeKas(Request $r)
    {
        $d = $r->validate([
            'bulan'       => 'required|integer|between:1,12',
            'tahun'       => 'required|integer|min:2024|max:2100',
            'nominal_kas' => 'required|integer|min:1000',
        ]);
        KasBulanan::updateOrCreate(['bulan' => $d['bulan'], 'tahun' => $d['tahun']], ['nominal_kas' => $d['nominal_kas']]);
        return back()->with('status', 'Kas bulanan disimpan.');
    }

    public function verifikasi(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'lunas', 'tanggal_bayar' => now(), 'admin_verifikasi_id' => auth()->id()]);
        return back()->with('status', 'Pembayaran diverifikasi.');
    }

    public function tolak(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'gagal', 'admin_verifikasi_id' => auth()->id()]);
        return back()->with('status', 'Pembayaran ditolak.');
    }
}
