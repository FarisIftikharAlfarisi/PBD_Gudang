@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title"> {{ Auth::guard('karyawan')->user()->Nomor_karyawan }} | {{ Auth::guard('karyawan')->user()->Nama_Karyawan }}</h5>
        <hr>
        <p class="card-text">  {{ Auth::guard('karyawan')->user()->email }} </p>
        <p class="card-text"> {{ Auth::guard('karyawan')->user()->Jabatan }} </p>
        <p class="card-text"> {{ Auth::guard('karyawan')->user()->Nomor_Telepon }} </p>
        <p class="card-text"> {{ Auth::guard('karyawan')->user()->Alamat }} </p>
    </div>
</div>
@endsection
