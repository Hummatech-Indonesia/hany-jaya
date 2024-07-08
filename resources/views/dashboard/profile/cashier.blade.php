@extends('dashboard.layouts.cashier')
@section('content')
    <div class="container-fluid max-w-full">
        @if (session('success'))
            <x-alert-success></x-alert-success>
        @elseif(session('error'))
            <x-alert-failed></x-alert-failed>
        @endif
        <div class="card">
            <div class="card-body">


                <div class="text-center mb-3">

                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/profile/user-1.jpg') }}"
                        alt="photo" class="rounded-circle mb-2" style="object-fit: cover;" width="150"
                        height="150">

                    <h3 class="fw-bolder fs-6 head-master">{{ auth()->user()->name }}</h3>
                    <h4 class="fw-bolder fs-6 email">{{ auth()->user()->email }}</h4>
                </div>

                <div class="grid col-12">
                    <div class="row align-items-center">
                        <div class="form-group col-6">
                            <label for="" class="form-label mb-2 text-black fw-bold fs-4">Nama :</label>
                            <div class="mb-3">

                                <span class="fs-3">{{ auth()->user()->name }}</span>
                                <hr style="border:1px solid;">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="form-label mb-2 text-black fw-bold fs-4">Email :</label>
                            <div class="mb-3">

                                <span class="fs-3">{{ auth()->user()->email }}</span>
                                <hr style="border:1px solid;">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            Ganti Password
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <x-edit-profile-modal></x-edit-profile-modal>
        <x-change-password-modal></x-change-password-modal>
    @endsection
