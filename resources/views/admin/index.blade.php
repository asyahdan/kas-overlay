<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"><h2 class="font-semibold text-xl">Admin Kas</h2>
        <a class="text-indigo-600" href="{{ route('admin.deployment') }}">Deployment</a></div>
    </x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('status')) <div class="p-3 bg-green-100 rounded">{{ session('status') }}</div> @endif
        @if($errors->any()) <div class="p-3 bg-red-100 rounded">{{ $errors->first() }}</div> @endif

        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="font-semibold mb-3">Buat / ubah kas bulanan</h3>
            <form method="POST" action="{{ route('admin.kas.store') }}" class="flex gap-2 flex-wrap">@csrf
                <input name="bulan" type="number" min="1" max="12" placeholder="Bulan" value="{{ now()->month }}" class="border rounded p-2 w-24">
                <input name="tahun" type="number" placeholder="Tahun" value="{{ now()->year }}" class="border rounded p-2 w-28">
                <input name="nominal_kas" type="number" placeholder="Nominal" class="border rounded p-2 w-36">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
            </form>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="font-semibold mb-3">Menunggu verifikasi ({{ $pending->count() }})</h3>
            <table class="w-full text-left">
                @forelse($pending as $p)
                    <tr class="border-t">
                        <td class="p-2">{{ $p->user->username ?? $p->user->name }}</td>
                        <td class="p-2">{{ $p->kas->label }}</td>
                        <td class="p-2">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="p-2 flex gap-2">
                            <form method="POST" action="{{ route('admin.verifikasi', $p) }}">@csrf<button class="text-green-700">Verifikasi</button></form>
                            <form method="POST" action="{{ route('admin.tolak', $p) }}">@csrf<button class="text-red-700">Tolak</button></form>
                        </td>
                    </tr>
                @empty <tr><td class="p-2 text-gray-400">Tidak ada.</td></tr> @endforelse
            </table>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="font-semibold mb-3">Laporan kas bulanan</h3>
            <table class="w-full text-left">
                <thead><tr><th class="p-2">Bulan</th><th class="p-2">Nominal</th><th class="p-2">Yang bayar</th><th class="p-2">Terkumpul</th></tr></thead>
                @foreach($kas as $k)
                    <tr class="border-t"><td class="p-2">{{ $k->label }}</td>
                        <td class="p-2">Rp {{ number_format($k->nominal_kas, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $k->lunas_count }}</td>
                        <td class="p-2">Rp {{ number_format($k->lunas_sum ?? 0, 0, ',', '.') }}</td></tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>
