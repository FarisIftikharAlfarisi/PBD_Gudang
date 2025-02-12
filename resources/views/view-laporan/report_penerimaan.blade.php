@extends('Partials.dashboard-template-main')

@section('dashboard-content')
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Laporan Penerimaan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Penerimaan</li>
            </ol>
        </nav>
    </div>

    <!-- Form Filter -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filter Laporan</h5>
                <form action="{{ route('laporan-penerimaan-page') }}" method="GET" class="row g-3" id="filterForm">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Tanggal Mulai:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Tanggal Akhir:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="supplier_id" class="form-label">Supplier:</label>
                        <select name="supplier_id" id="supplier_id" class="form-select">
                            <option value="">Semua Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->ID_Supplier }}" {{ request('supplier_id') == $supplier->ID_Supplier ? 'selected' : '' }}>
                                    {{ $supplier->Nama_Supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Tabel Hasil Laporan -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Transaksi</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->No_Faktur }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                <td>{{ $transaction->supplier?->Nama_Supplier ?? 'Tidak Diketahui' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    // Fungsi untuk mereset filter
    function resetFilters() {
        // Reset form
        document.getElementById('filterForm').reset();

        // Redirect ke halaman tanpa query string
        window.location.href = "{{ route('laporan-penerimaan-page') }}";
    }
</script>