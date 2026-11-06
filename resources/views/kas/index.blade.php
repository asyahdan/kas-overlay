<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Tagihan & Riwayat Kas</h2></x-slot>
    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if(session('status')) <div class="mb-4 p-3 bg-green-100 rounded">{{ session('status') }}</div> @endif
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50"><tr><th class="p-3">Bulan</th><th class="p-3">Nominal</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead>
                <tbody>
                @forelse($kas as $k)
                    @php $p = $mine->get($k->id); @endphp
                    <tr class="border-t">
                        <td class="p-3">{{ $k->label }}</td>
                        <td class="p-3">Rp {{ number_format($k->nominal_kas, 0, ',', '.') }}</td>
                        <td class="p-3">{{ $p ? ucfirst($p->status) : 'Belum bayar' }}</td>
                        <td class="p-3">@if(!$p || $p->status === 'gagal') <a class="text-indigo-600" href="{{ route('kas.bayar', $k) }}">Bayar</a> @endif</td>
                    </tr>
                @empty <tr><td class="p-3 text-gray-400" colspan="4">Belum ada tagihan.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
