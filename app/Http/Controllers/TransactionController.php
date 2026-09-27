<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Daftar transaksi, bisa difilter per bulan (format: 2026-09).
     */
    public function index(Request $request)
    {
        $bulan = $request->query('bulan');

        $query = $request->user()->transactions();

        if ($bulan && preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            [$tahun, $bln] = explode('-', $bulan);
            $query->whereYear('date', $tahun)->whereMonth('date', $bln);
        }

        $totalPemasukan = (clone $query)->where('type', Transaction::PEMASUKAN)->sum('amount');
        $totalPengeluaran = (clone $query)->where('type', Transaction::PENGELUARAN)->sum('amount');

        $transactions = $query->orderByDesc('date')->orderByDesc('id')->paginate(10)->withQueryString();

        return view('transactions.index', compact('transactions', 'bulan', 'totalPemasukan', 'totalPengeluaran'));
    }

    public function create()
    {
        return view('transactions.create', [
            'transaction' => new Transaction(['type' => Transaction::PENGELUARAN, 'date' => now()]),
        ]);
    }

    public function store(Request $request)
    {
        $request->user()->transactions()->create($this->validateData($request));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Request $request, Transaction $transaction)
    {
        $this->pastikanMilikUser($request, $transaction);

        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->pastikanMilikUser($request, $transaction);

        $transaction->update($this->validateData($request));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        $this->pastikanMilikUser($request, $transaction);

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * User hanya boleh mengubah transaksinya sendiri.
     */
    private function pastikanMilikUser(Request $request, Transaction $transaction): void
    {
        abort_if((int) $transaction->user_id !== (int) $request->user()->id, 403);
    }

    private function validateData(Request $request): array
    {
        $type = $request->input('type');
        $categories = Transaction::CATEGORIES[$type] ?? [];

        return $request->validate([
            'type' => ['required', Rule::in([Transaction::PEMASUKAN, Transaction::PENGELUARAN])],
            'category' => ['required', Rule::in($categories)],
            'amount' => ['required', 'numeric', 'min:1', 'max:9999999999999'],
            'description' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ], [], [
            'type' => 'jenis transaksi',
            'category' => 'kategori',
            'amount' => 'nominal',
            'description' => 'keterangan',
            'date' => 'tanggal',
        ]);
    }
}
