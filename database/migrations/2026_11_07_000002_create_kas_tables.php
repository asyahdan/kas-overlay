<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kas_bulanans', function (Blueprint $t) {
            $t->id();
            $t->unsignedTinyInteger('bulan');
            $t->unsignedSmallInteger('tahun');
            $t->unsignedInteger('nominal_kas');
            $t->timestamps();
            $t->unique(['bulan', 'tahun']);
        });

        Schema::create('pembayarans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('kas_bulanan_id')->constrained('kas_bulanans')->cascadeOnDelete();
            $t->dateTime('tanggal_bayar')->nullable();
            $t->unsignedInteger('jumlah_bayar');
            $t->string('status')->default('pending'); // pending | lunas | gagal
            $t->foreignId('admin_verifikasi_id')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
            $t->unique(['user_id', 'kas_bulanan_id']);
        });

        Schema::create('settings', function (Blueprint $t) {
            $t->string('key')->primary();
            $t->text('value')->nullable();
        });
    }
    public function down(): void {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('pembayarans');
        Schema::dropIfExists('kas_bulanans');
    }
};
