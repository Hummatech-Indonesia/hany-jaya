@extends('layouts.app') @section('content')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endif
            <h2 class="mb-3 fs-7 fw-bolder">Masuk</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="example@gmail.com" />
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="password" />
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" name="remember_me" id="flexCheckChecked" />
                        <label class="form-check-label text-dark" for="flexCheckChecked">
                            Ingat Saya
                        </label>
                    </div>
                    <a class="text-primary fw-medium" href="{{ route('password.request') }}">Lupa Kata Sandi ?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                    Masuk
                </button>
            </form>
        </div>
    </div>
@endsection
