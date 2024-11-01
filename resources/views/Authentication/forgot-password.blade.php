@extends('Authentication.auth-template')
@section('authentication-content')
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

      <div class="d-flex justify-content-center py-4">
        <a href="index.html" class="logo d-flex align-items-center w-auto">
          <img src="assets/img/logo.png" alt="">
          <span class="d-none d-lg-block">Lupa Password</span>
        </a>
      </div><!-- End Logo -->

      <div class="card mb-3">

        <div class="card-body">
          <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4"></h5>
            <p class="text-center small">Validasi akun anda menggunakan Nomor Karyawan Dan Email</p>
          </div>

          <form class="row g-3 needs-validation" novalidate>
            <div class="col-12">
                <label for="yourKaryawanNumber" class="form-label">No. Karyawan</label>
                <div class="input-group has-validation">
                  <input type="text" name="no_karyawan" class="form-control" id="input-KaryawanNumber" required>
                  <div class="invalid-feedback">No. Karyawan yang anda salah.</div>
                </div>
              </div>

            <div class="col-12">
              <label for="yourKaryawanNumber" class="form-label">Email</label>
              <div class="input-group has-validation">
                <input type="text" name="Email" class="form-control" id="input-email" required>
                <div class="invalid-feedback">Email yang anda salah.</div>
              </div>
            </div>

            <div class="col-12 text-center">
              <button class="btn btn-primary w-50 " type="submit">Kirim</button>
            </div>
            <div class="col-12">
            </div>
          </form>


        </div>

        <div class="card mb-3" style="display: none">

            <div class="card-body">
              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4"></h5>
                <p class="text-center small">Masukkan Password Baru Anda</p>
              </div>

              <!--Reset Password Pengguna-->
          <form class="row g-3 needs-validation" novalidate>

            <div class="col-12">
              <label for="password_baru" class="form-label">Password Baru</label>
              <div class="input-group has-validation">
                <input type="text" name="new_password" class="form-control" id="input-new-password" required>
                {{-- <div class="invalid-feedback">Email yang anda salah.</div> --}}
              </div>
            </div>

            <div class="col-12">
              <label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru</label>
              <div class="input-group has-validation">
                <input type="text" name="confirm_new_password" class="form-control" id="input-confirm-new-password" required>
                {{-- <div class="invalid-feedback">Email yang anda salah.</div> --}}
              </div>
            </div>

            <div class="col-12 text-center">
              <button class="btn btn-primary w-50 " type="submit">Kirim</button>
            </div>
            <div class="col-12">
            </div>
          </form>


            </div>
      </div>
    </div>
  </div>
@endsection
