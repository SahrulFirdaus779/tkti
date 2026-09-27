@use('App\Models\Transaction')

@php
    $selectedType = old('type', $transaction->type);
    $selectedCategory = old('category', $transaction->category);
@endphp

<div class="mb-3">
    <label class="form-label" for="type">Jenis Transaksi</label>
    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
        <option value="{{ Transaction::PEMASUKAN }}" @selected($selectedType === Transaction::PEMASUKAN)>Pemasukan</option>
        <option value="{{ Transaction::PENGELUARAN }}" @selected($selectedType === Transaction::PENGELUARAN)>Pengeluaran</option>
    </select>
    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="amount">Nominal</label>
    <div class="input-group has-validation">
        <span class="input-group-text">Rp</span>
        <input type="number" name="amount" id="amount" min="1" step="1"
               value="{{ old('amount', $transaction->amount !== null ? (int) $transaction->amount : '') }}"
               class="form-control @error('amount') is-invalid @enderror" placeholder="Contoh: 20000" required>
        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="category">Kategori</label>
    <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
        {{-- Opsi diisi oleh JavaScript sesuai jenis transaksi --}}
    </select>
    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="description">Keterangan</label>
    <input type="text" name="description" id="description" maxlength="255"
           value="{{ old('description', $transaction->description) }}"
           class="form-control @error('description') is-invalid @enderror" placeholder="Contoh: Makan siang">
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="form-label" for="date">Tanggal</label>
    <input type="date" name="date" id="date"
           value="{{ old('date', $transaction->date?->format('Y-m-d')) }}"
           class="form-control @error('date') is-invalid @enderror" required>
    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

@push('scripts')
<script>
    // Ganti daftar kategori setiap kali jenis transaksi berubah
    const categories = @json(Transaction::CATEGORIES);
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category');
    let selectedCategory = @json($selectedCategory);

    function renderCategories() {
        categorySelect.innerHTML = '';
        (categories[typeSelect.value] || []).forEach(function (name) {
            const option = new Option(name, name, false, name === selectedCategory);
            categorySelect.add(option);
        });
    }

    typeSelect.addEventListener('change', function () {
        selectedCategory = null;
        renderCategories();
    });

    renderCategories();
</script>
@endpush
