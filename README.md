# Kas Bulanan — overlay Laravel (mode statik)

1. Project baru: `laravel new kas` -> pilih Breeze (Blade). Lalu `cd kas`.
2. Salin isi folder ini ke root project (gabung dengan folder yang sama).
3. Di `routes/web.php`: hapus route `/` bawaan, lalu tambahkan di baris paling bawah:
   `require __DIR__.'/kas.php';`
4. Jalankan:
   php artisan migrate
   php artisan db:seed --class=KasSeeder
   php artisan storage:link
   npm install && npm run dev   (terminal lain: php artisan serve)
5. Login admin: admin@kas.test / password   (user: budi@kas.test, dst / password)

URL: `/` publik, `/kas` tagihan user, `/admin` verifikasi + laporan, `/admin/deployment` pilih mode + upload QRIS.
Catatan: ERD aslinya memisah tabel Admin; di sini digabung ke `users` dengan kolom `role` supaya cukup satu login.
