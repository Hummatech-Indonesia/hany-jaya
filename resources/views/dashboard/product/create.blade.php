@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Tambah Produk</h4>
                        <p>Isi data dibawah ini dengan benar.</p>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt=""
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  Row 1 -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">Tambah Produk</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name">Nama Produk</label>
                                    <input type="text" name="name" class="form-control" placeholder="Aqua"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="code">Kode Produk</label>
                                    <input type="text" name="code" class="form-control" placeholder="HSN-1203"
                                        value="{{ old('code') }}" />
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category_id">Kategori Produk</label>
                                    <select name="category_id" id="" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="supplier_id">Nama Pemasok</label>
                                        <div class="d-flex flex-row">
                                            <a href="{{ route('admin.suppliers.index') }}"
                                            class="mx-2 text-success"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#13DEB9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                <path d="M9 12h6" />
                                                <path d="M12 9v6" />
                                              </svg> Tambah Pemasok</a>
                                        </div>
                                    </div>
                                    <select class="select2 form-control" name="supplier_id[]" multiple="multiple"
                                        placeholder="Pilih Pemasok" style="height: 36px; width: 100%">
                                        <optgroup label="Pilih Pemasok">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ in_array($supplier->id, old('supplier_id', [])) ? 'selected' : '' }}>
                                                    {{ $supplier->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    @error('supplier_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="quantity">Total Produk</label>
                                    <input type="number" name="quantity" class="form-control" placeholder="0"
                                        value="{{ old('quantity') }}" />
                                    @error('quantity')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="unit_id">Satuan</label>
                                    <select name="unit_id" class="form-control">
                                        <option value="">Pilih Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="selling_price">Harga Jual</label>
                                    <input type="number" name="selling_price" class="form-control" placeholder="10.000"
                                        value="{{ old('selling_price') }}" />
                                    @error('selling_price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="image">Gambar (opsional)</label>
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-info rounded-md px-4 mt-3" type="submit">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
