@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>  Riwayat Pembelian </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kasir-index-page') }}">Kasir</a></li>
        <li class="breadcrumb-item active">Riwayat Pembelian</li>
      </ol>
    </nav>
  </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="card-title"> Riwayat Transaksi dari {{ Auth::guard('karyawan')->user()->Kode_Karyawan }} </div>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor Nota</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nilai Transaksi</th>
                    <th>Metode Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->Nomor_Nota }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('dmY', $r->Tanggal_Pembelian)->isoFormat('dddd, D MMMM YYYY') }}
                    </td>
                    <td>Rp. {{ number_format($r->Total_Pembayaran, 0, ',', '.') }}</td>
                    <td>{{ $r->Metode_Pembayaran }}</td>
                    <td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
