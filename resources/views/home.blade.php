<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kas Bulanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
<div class="max-w-xl mx-auto p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Kas Bulanan</h1>
        @auth <a class="text-indigo-600" href="{{ route('kas.index') }}">Tagihan saya</a>
        @else <a class="text-indigo-600" href="{{ route('login') }}">Masuk</a> @endauth
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-sm text-gray-500">Total kas terkumpul</div>
        <div class="text-3xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 text-center">
        @if($kas)
            <div class="font-semibold">Kas {{ $kas->label }} — Rp {{ number_format($kas->nominal_kas, 0, ',', '.') }}</div>
            <p class="text-xs text-gray-500 mb-3">Pembayaran bersifat sukarela.</p>
        @endif
        @if($qris) <img src="{{ asset('storage/'.$qris) }}" alt="QRIS" class="mx-auto max-w-xs w-full">
        @else <p class="text-gray-400">QRIS belum diunggah admin.</p> @endif
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <div class="font-semibold mb-2">Sudah bayar bulan ini ({{ $payers->count() }})</div>
        <ul class="list-disc pl-5">
            @forelse($payers as $p) <li>{{ $p->user->username ?? $p->user->name }}</li>
            @empty <li class="list-none text-gray-400">Belum ada.</li> @endforelse
        </ul>
    </div>
</div>
</body>
</html>
