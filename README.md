# MoneyTrack — Aplikasi Pencatatan Keuangan Sederhana

MoneyTrack adalah aplikasi web sederhana untuk mencatat pemasukan dan pengeluaran,
sehingga kondisi keuangan pribadi (khususnya mahasiswa) dapat dipantau dengan mudah.

## Fitur

- Login / Register
- Dashboard ringkasan keuangan (total pemasukan, pengeluaran, dan saldo)
- Tambah, lihat, edit, dan hapus transaksi
- Kategori transaksi sesuai jenis (pemasukan / pengeluaran)
- Filter transaksi per bulan

## Teknologi

| Bagian     | Teknologi                    |
|------------|------------------------------|
| Backend    | PHP 8.2, Laravel 12          |
| Frontend   | Blade, Bootstrap 5 (CDN)     |
| Database   | MySQL                        |
| Development| XAMPP                        |

## Struktur Database

- `users` — id, name, email, password
- `transactions` — id, user_id, type, category, amount, description, date

Relasi: satu user memiliki banyak transaksi.

## Cara Menjalankan

1. Clone repository ini, lalu masuk ke foldernya.
2. Install dependency:
   ```bash
   composer install
   ```
3. Salin file environment dan buat app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Jalankan MySQL (XAMPP), lalu buat database bernama `moneytrack`.
5. Jalankan migration dan data contoh:
   ```bash
   php artisan migrate --seed
   ```
6. Jalankan server:
   ```bash
   php artisan serve
   ```
7. Buka http://127.0.0.1:8000

Akun demo: `demo@moneytrack.test` / `password`
