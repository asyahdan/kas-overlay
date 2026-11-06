<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{
    public function edit()
    {
        return view('admin.deployment', [
            'mode' => Setting::get('payment_mode', 'static'),
            'qris' => Setting::get('qris_path'),
        ]);
    }

    public function update(Request $r)
    {
        // Tahap ini baru 'static'. Saat mock gateway selesai: ubah jadi in:static,gateway
        $d = $r->validate([
            'mode' => 'required|in:static',
            'qris' => 'nullable|image|max:2048',
        ]);

        if ($r->hasFile('qris')) {
            Setting::put('qris_path', $r->file('qris')->store('qris', 'public'));
        }
        Setting::put('payment_mode', $d['mode']);

        return back()->with('status', 'Konfigurasi deployment disimpan.');
    }
}
