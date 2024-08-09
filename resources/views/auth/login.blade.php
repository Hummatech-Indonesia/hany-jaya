@extends('layouts.app') @section('content')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            @if (session('success'))
                <x-alert-success></x-alert-success>
            @elseif ($errors->any())
                <x-validation-errors :errors="$errors"></x-validation-errors>
            @elseif(session('error'))
                <x-alert-failed></x-alert-failed>
            @endif
            <h2 class="mb-3 fs-7 fw-bolder">Masuk</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com"
                        value="{{ old('email') }}" />
                </div>
                <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <div class="d-flex align-items-center">
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                            placeholder="password">
                        <i class="ti ti-eye" id="togglePassword" style="z-index: 100; margin-left:-10%;"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" name="remember_me" id="flexCheckChecked" />
                        <label class="form-check-label text-dark" for="flexCheckChecked">
                            Ingat Saya
                        </label>
                    </div>
                    
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                    Masuk
                </button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#togglePassword').on('click', function() {
                // Dapatkan input password
                var passwordField = $('#exampleInputPassword1');
                var passwordFieldType = passwordField.attr('type');

                // Ubah tipe input
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('ti ti-eye').addClass('ti ti-eye-off');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('ti ti-eye-off').addClass('ti ti-eye');
                }
            });
        });
    </script>
@endsection
