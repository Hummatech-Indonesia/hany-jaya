@extends('layouts.app')

@section('content')
    <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
        <div class="d-flex align-items-center w-100 h-100">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="alert-message">
                        <strong>Sukses!</strong> Link verifikasi berhasil dikirim. Silahkan cek email anda
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <div class="mb-5">
                    <h2 class="fw-bolder fs-7 mb-3">Lupa Kata Sandi?</h2>
                    <p class="mb-0 ">
                        Please enter the email address associated with your account and We will email you a link to reset
                        your password.
                    </p>
                </div>
                <form method="POST" class="row g-4" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <button class="btn btn-primary w-100 py-8 mb-3" type="submit">Kirim Email</button>
                    <a href="authentication-login.html" class="btn btn-light-primary text-primary w-100 py-8">Back to
                        Login</a>
                </form>
            </div>
        </div>
    </div>
@endsection
