<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Konfigurasi Deployment</h2></x-slot>
    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if(session('status')) <div class="mb-4 p-3 bg-green-100 rounded">{{ session('status') }}</div> @endif
        @if($errors->any()) <div class="mb-4 p-3 bg-red-100 rounded">{{ $errors->first() }}</div> @endif

        <form method="POST" action="{{ route('admin.deployment.update') }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-5">
            @csrf
            <div>
                <div class="font-semibold mb-2">Mode pembayaran</div>
                <label class="flex items-start gap-2 mb-2">
                    <input type="radio" name="mode" value="static" @checked($mode === 'static')>
                    <span><b>Statik</b> — tampilkan gambar QRIS, pembayaran diverifikasi manual oleh admin.</span>
                </label>
                <label class="flex items-start gap-2 text-gray-400">
                    <input type="radio" name="mode" value="gateway" disabled>
                    <span><b>Payment gateway (API)</b> — QRIS dinamis + webhook otomatis. <i>Belum tersedia (tahap mock berikutnya).</i></span>
                </label>
            </div>

            <div>
                <div class="font-semibold mb-2">Gambar QRIS (mode statik)</div>
                @if($qris) <img src="{{ asset('storage/'.$qris) }}" class="max-w-[200px] mb-2" alt="QRIS saat ini"> @endif
                <input type="file" name="qris" accept="image/*">
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan konfigurasi</button>
        </form>
    </div>
</x-app-layout>
