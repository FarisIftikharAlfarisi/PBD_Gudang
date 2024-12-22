@extends('Authentication.auth-template')
@section('authentication-content')
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/logo.png" alt="">
                    <span class="d-none d-lg-block">MyJDM</span>
                </a>
            </div><!-- End Logo -->


            @if ($errors->has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ $errors->first('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <div class="card mb-3">

                <div class="card-body">

                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                        <p class="text-center small">Gunakan email dan password anda untuk login.</p>
                    </div>

                    <form action="{{ route('login-process') }}" method="POST" class="row g-3 needs-validation">
                        @csrf
                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Email</label>
                            <div class="input-group has-validation">
                                <input type="email" name="email"
                                    class="form-control @if($errors->has('email')) is-invalid @endif" id="email"
                                    value="{{ old('email') }}" required>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @if($errors->has('password')) is-invalid @endif" id="input-password" required>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="openPassword" onclick="unhide()" id="open-password">
                                <label class="form-check-label" for="openPassword">Perlihatkan Password</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary w-50 " type="submit">Login</button>
                        </div>
                        <div class="col-12">
                            {{-- <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p> --}}
                        </div>
                    </form>

                </div>
            </div>

            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
            </div>

        </div>
    </div>
@endsection
