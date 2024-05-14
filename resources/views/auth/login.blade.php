@extends('layouts.app')
@section('content')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            <h2 class="mb-3 fs-7 fw-bolder">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked"
                            checked>
                        <label class="form-check-label text-dark" for="flexCheckChecked">
                            Ingat Saya
                        </label>
                    </div>
                    <a class="text-primary fw-medium" href="authentication-forgot-password.html">Forgot Password ?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Masuk</button>
                    <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">Belum Punya Akun?</p>
                    <a class="text-primary fw-medium ms-2" href="authentication-register.html">Buat Akun</a>
                </div>
            </form>
        </div>
    </div>
@endsection
