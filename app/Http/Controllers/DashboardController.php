<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $transactions = $request->user()->transactions();

        $totalPemasukan = (clone $transactions)->where('type', Transaction::PEMASUKAN)->sum('amount');
        $totalPengeluaran = (clone $transactions)->where('type', Transaction::PENGELUARAN)->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $terbaru = (clone $transactions)
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('dashboard', compact('totalPemasukan', 'totalPengeluaran', 'saldo', 'terbaru'));
    }
}
