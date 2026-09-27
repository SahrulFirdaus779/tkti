<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Membuat user demo beserta contoh transaksi.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Mahasiswa Demo',
            'email' => 'demo@moneytrack.test',
            'password' => 'password',
        ]);

        $month = now()->startOfMonth();

        $transactions = [
            ['pemasukan', 'Uang Saku', 1500000, 'Uang bulanan dari orang tua', 1],
            ['pemasukan', 'Gaji', 500000, 'Gaji part time', 5],
            ['pengeluaran', 'Makanan', 20000, 'Makan siang', 2],
            ['pengeluaran', 'Transportasi', 15000, 'Ojek ke kampus', 3],
            ['pengeluaran', 'Pendidikan', 75000, 'Fotokopi modul', 6],
            ['pengeluaran', 'Belanja', 120000, 'Kebutuhan kos', 8],
            ['pengeluaran', 'Hiburan', 50000, 'Nonton bioskop', 10],
        ];

        foreach ($transactions as [$type, $category, $amount, $description, $day]) {
            $user->transactions()->create([
                'type' => $type,
                'category' => $category,
                'amount' => $amount,
                'description' => $description,
                'date' => $month->copy()->addDays($day - 1),
            ]);
        }
    }
}
