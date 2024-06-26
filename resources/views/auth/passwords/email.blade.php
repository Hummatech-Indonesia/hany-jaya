@extends('layouts.forgot-pass') @section('content')
<div
    class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center"
>
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <a
                            href="index-2.html"
                            class="text-nowrap logo-img text-center d-block mb-5 w-100"
                        >
                            <img
                                src="{{asset('logo.png')}}"
                                width="180"
                                alt=""
                            />
                        </a>
                        <div class="row mb-3">
                            <div class="col-12 mb-2 mb-sm-0">
                                <h2 class="fw-bolder fs-5 mb-3">
                                    Lupa Kata Sandi?
                                </h2>
                                <p class="mb-0">
                                    Silakan masukkan alamat email yang terkait
                                    dengan akun anda, kemudian kami akan
                                    mengirimkan email berisi tautan untuk
                                    mengatur ulang kata sandi anda.
                                </p>
                            </div>
                        </div>
                        @if (session('status'))
                        <div
                            class="alert alert-success alert-dismissible"
                            role="alert"
                        >
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>
                            <div class="alert-message">
                                <strong>Sukses!</strong> Link verifikasi
                                berhasil dikirim. Silahkan cek email anda
                            </div>
                        </div>
                        @endif @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form
                            class="my-4"
                            method="POST"
                            action="{{ route('password.email') }}"
                        >
                            @csrf
                            <div class="mb-4">
                                <label
                                    for="exampleInputEmail1"
                                    class="form-label"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="example@gmail.com"
                                    name="email"
                                />
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary w-100 py-8 mb-4 rounded-2"
                            >
                                Reset Password
                            </button>
                            <div
                                class="d-flex align-items-center justify-content-center"
                            >
                                <a
                                    class="text-primary fw-medium ms-2"
                                    href="{{ route('login') }}"
                                    >Kembali ke halaman masuk</a
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
