@extends('layouts.app')

@section('title', 'Dashboard')

@use('App\Models\Transaction')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 mb-0">Dashboard</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Transaksi
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="summary-icon rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pemasukan</div>
                    <div class="h5 mb-0 text-success">{{ Transaction::rupiah($totalPemasukan) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="summary-icon rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pengeluaran</div>
                    <div class="h5 mb-0 text-danger">{{ Transaction::rupiah($totalPengeluaran) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="summary-icon rounded-circle bg-white text-primary d-flex align-items-center justify-content-center">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <div class="small opacity-75">Saldo</div>
                    <div class="h5 mb-0">{{ $saldo < 0 ? '-' : '' }}{{ Transaction::rupiah(abs($saldo)) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Transaksi Terbaru</span>
        <a href="{{ route('transactions.index') }}" class="small">Lihat semua</a>
    </div>
    <ul class="list-group list-group-flush">
        @forelse ($terbaru as $t)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-semibold">{{ $t->category }}</div>
                    <div class="small text-muted">{{ $t->date->format('d/m/Y') }} &middot; {{ $t->description ?: '-' }}</div>
                </div>
                <span class="fw-semibold {{ $t->isPemasukan() ? 'text-success' : 'text-danger' }}">
                    {{ $t->isPemasukan() ? '+' : '-' }} {{ Transaction::rupiah($t->amount) }}
                </span>
            </li>
        @empty
            <li class="list-group-item text-center text-muted py-4">
                Belum ada transaksi. <a href="{{ route('transactions.create') }}">Tambah sekarang</a>
            </li>
        @endforelse
    </ul>
</div>
@endsection
