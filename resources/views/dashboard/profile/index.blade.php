@extends('dashboard.layouts.dashboard')
@push("title")
    Profil
@endpush
@section('content')
    @include('components.swal-message')
    <div class="container-fluid max-w-full">
        <div class="card w-100 d-flex flex-column flex-md-row overflow-hidden">
            <div class="flex-1 w-100">
                <img 
                    src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/profile/user-1.jpg') }}"
                    alt="profile-image" class="w-100" style="object-fit: cover;"
                >
            </div>
            <div class="flex-1 w-100 justify-self-stretch d-flex flex-column justify-content-between p-3">
                <div>
                    <div class="mb-3">
                        <div class="text-muted fw-bolder">Nama</div>
                        <div class="fw-bolder fs-5">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted fw-bolder">Email</div>
                        <div class="fw-bolder fs-5">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted fw-bolder">Role</div>
                        <div class="fw-bolder fs-5">
                            @foreach(auth()->user()->roles as $role)
                                <div class="badge bg-primary-subtle text-dark">{{ $role->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-stretch gap-2">
                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            Ganti Password
                        </button>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                            Edit
                        </button>
                </div>
            </div>
            
            {{-- <div class="card-body">


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
            </div> --}}
        </div>
    @endsection
    @section('script')
        <x-edit-profile-modal></x-edit-profile-modal>
        <x-change-password-modal></x-change-password-modal>
    @endsection
