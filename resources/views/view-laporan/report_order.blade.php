@extends('Partials.dashboard-template-main')

@section('dashboard-content')
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Laporan Kasir</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Kasir</li>
            </ol>
        </nav>
    </div>

    <!-- Form Filter -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filter Laporan</h5>
                <form action="{{ route('laporan-order-page') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Tanggal Mulai:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Tanggal Akhir:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="customer_id" class="form-label">Pembeli:</label>
                        <select name="customer_id" id="customer_id" class="form-select">
                            <option value="">Semua Pembeli</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->Nama_Pelanggan }}
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

    <!-- Total Pendapatan -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Pendapatan</h5>
                <p><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></p>
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
                            <th>Pembeli</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->Nomor_Nota }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                <td>{{ $transaction->Nama_Pelanggan ?? 'Umum' }}</td>
                                <td>{{ number_format($transaction->Uang_Masuk, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data transaksi.</td>
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
@section('scripts')
