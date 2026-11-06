<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Bayar Kas {{ $kas->label }}</h2></x-slot>
    <div class="py-6 max-w-md mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 text-center space-y-4">
            <div class="text-2xl font-bold">Rp {{ number_format($kas->nominal_kas, 0, ',', '.') }}</div>
            @if($qris) <img src="{{ asset('storage/'.$qris) }}" alt="QRIS" class="mx-auto max-w-xs w-full">
            @else <p class="text-gray-400">QRIS belum diunggah admin.</p> @endif
            <p class="text-sm text-gray-500">Scan QRIS, bayar sesuai nominal, lalu klik tombol di bawah.</p>
            @if($pembayaran && $pembayaran->status !== 'gagal')
                <p class="font-semibold">Status: {{ ucfirst($pembayaran->status) }}</p>
            @else
                <form method="POST" action="{{ route('kas.store', $kas) }}">@csrf
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Saya sudah bayar</button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
