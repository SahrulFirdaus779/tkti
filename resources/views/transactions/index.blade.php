@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@use('App\Models\Transaction')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h1 class="h4 mb-0">Daftar Transaksi</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Transaksi
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('transactions.index') }}" class="row g-2 align-items-end">
            <div class="col-sm-4 col-md-3">
                <label class="form-label small mb-1" for="bulan">Filter bulan</label>
                <input type="month" name="bulan" id="bulan" value="{{ $bulan }}" class="form-control">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-primary">Tampilkan</button>
                @if ($bulan)
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Semua</a>
                @endif
            </div>
            <div class="col-md text-md-end small">
                <span class="text-success me-3">Pemasukan: <strong>{{ Transaction::rupiah($totalPemasukan) }}</strong></span>
                <span class="text-danger">Pengeluaran: <strong>{{ Transaction::rupiah($totalPengeluaran) }}</strong></span>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th class="text-end">Nominal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $t)
                    <tr>
                        <td>{{ $t->date->format('d/m/Y') }}</td>
                        <td>{{ $t->description ?: '-' }}</td>
                        <td>{{ $t->category }}</td>
                        <td>
                            @if ($t->isPemasukan())
                                <span class="badge bg-success-subtle text-success">Pemasukan</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold {{ $t->isPemasukan() ? 'text-success' : 'text-danger' }}">
                            {{ Transaction::rupiah($t->amount) }}
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('transactions.edit', $t) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('transactions.destroy', $t) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $transactions->links() }}
</div>
@endsection
