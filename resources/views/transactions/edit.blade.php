@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <h1 class="h4 mb-4">Edit Transaksi</h1>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('transactions.update', $transaction) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('transactions._form')

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
