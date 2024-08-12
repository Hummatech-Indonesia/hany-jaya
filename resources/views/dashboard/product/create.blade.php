@extends('dashboard.layouts.dashboard')
@push("title")
    Tambah Produk
@endpush
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/codemirror/5.41.0/codemirror.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/codemirror/5.41.0/theme/blackboard.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/codemirror/5.41.0/theme/monokai.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/summernote/dist/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/libs/selectize/selectize.bootstrap5.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}">
@endsection
@section('content')
    @include('components.swal-message')
    <div class="container-fluid max-w-full">
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
                                    <label class="mb-2" for="name">Nama Produk <small class="text-danger">*</small></label>
                                    <input type="text" name="name" class="form-control" placeholder="Aqua"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger on_error d-none">Nama Produk tidak boleh kosong</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="mb-2" for="code">Kode Produk <small class="text-danger">*</small></label>
                                    <input type="text" name="code" class="form-control" placeholder="HSN-1203"
                                        value="{{ old('code') }}" />
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger on_error d-none">Kode Produk tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="mb-2 d-flex justify-content-between" for="category_id"><span>Kategori
                                            Produk <small class="text-danger">*</small></span></label>
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
                                    <div class="text-danger on_error d-none">Kategori tidak boleh kosong</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="d-flex gap-2 align-items-center mb-2" for="image">Satuan Terkecil
                                        Produk <small class="text-danger">*</small><div data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Pilih satuan terkecil pada produk yang anda tambahkan, terkadang beberapa produk dijual bukan per-biji melainkan per-pack.">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-help-octagon">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M12.802 2.165l5.575 2.389c.48 .206 .863 .589 1.07 1.07l2.388 5.574c.22 .512 .22 1.092 0 1.604l-2.389 5.575c-.206 .48 -.589 .863 -1.07 1.07l-5.574 2.388c-.512 .22 -1.092 .22 -1.604 0l-5.575 -2.389a2.036 2.036 0 0 1 -1.07 -1.07l-2.388 -5.574a2.036 2.036 0 0 1 0 -1.604l2.389 -5.575c.206 -.48 .589 -.863 1.07 -1.07l5.574 -2.388a2.036 2.036 0 0 1 1.604 0z" />
                                                <path d="M12 16v.01" />
                                                <path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                                            </svg>
                                        </div></label>
                                    <select name="small_unit_id" id="" class="form-control">
                                        <option value="">Pilih Satuan Terkecil</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('small_unit_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger on_error d-none">Satuan terkecil tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6 mb-3">
                                    <label class="mb-2" for="image">Gambar (opsional)</label>
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-warning" role="alert">
                                        <strong>Informasi</strong>
                                        <ol class="mt-3">
                                            <li>Formulir dibawah ini digunakan untuk menambahkan satuan-satuan yang ada pada
                                                produk yang anda tambahkan.</li>
                                            <li>Selain itu, formulir dibawah ini juga digunakan untuk menambahkan harga jual
                                                sesuai dengan satuan, dan untuk memformat satuan tersebut kedalam satuan
                                                terkecil produk yang ditambahkan.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Konversi Satuan & Harga Pada Satuan Lain</h5>
                                    <button type="button" class="btn btn-success" id="btn-add-unit">
                                        + Tambah
                                    </button>
                                </div>
                                <div class="mt-2 table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Satuan <span class="text-danger">*</span></th>
                                                <th>
                                                    <div class="d-flex justify-content-between">

                                                        <div>
                                                            Total Dalam Satuan Terkecil  <span class="text-danger">*</span>
                                                        </div>
                                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Masukkan total satuan terkecil dari satuan yang anda pilih. Misal dalam 1 kardus terdapat 12 pcs, maka diisi dengan angka 12, begitupula dengan satuan yang lainnya.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-help-octagon">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M12.802 2.165l5.575 2.389c.48 .206 .863 .589 1.07 1.07l2.388 5.574c.22 .512 .22 1.092 0 1.604l-2.389 5.575c-.206 .48 -.589 .863 -1.07 1.07l-5.574 2.388c-.512 .22 -1.092 .22 -1.604 0l-5.575 -2.389a2.036 2.036 0 0 1 -1.07 -1.07l-2.388 -5.574a2.036 2.036 0 0 1 0 -1.604l2.389 -5.575c.206 -.48 .589 -.863 1.07 -1.07l5.574 -2.388a2.036 2.036 0 0 1 1.604 0z" />
                                                                <path d="M12 16v.01" />
                                                                <path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Harga Jual  <span class="text-danger">*</span></th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-units">
                                            <tr>
                                                <th colspan="4" class="text-center text-muted">-- Belum Ada Satuan Dipilih --</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex gap-3 mt-3">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-light">Kembali</a>
                                <button class="btn btn-info rounded-md px-4" type="submit">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.product.widgets.modal-create')
@endsection
@section('script')
    <script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
    <script src="{{ asset('assets/js/number-format.js') }}"></script>
    <script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    @include('components.swal-toast')
    <script>
        $(document).ready(function() {

            $.ajax({
                url: "{{route('find.product.last-product')}}?response=code",
                success: function(res) {
                    $('[name=code]').val(res.data)
                }
            })

            const selectize_category = $('[name=category_id]').selectize({
                create: true,
                onOptionAdd: function (val, data) {
                    createNewCategory(val)
                },
            
            })
            const selectize_small_unit = $('[name=small_unit_id]').selectize({
                create: true,
                onOptionAdd: function (val, item) {
                    createNewUnit(val)
                }
            })

            const select = {
                category: selectize_category[0].selectize,
                small_unit: selectize_small_unit[0].selectize
            }

            function createNewCategory(val) {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('api.category.store.ajax') }}",
                    data: {
                        name: val,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: (res) => {
                        select.category.updateOption(
                        val,
                        {
                            value: res.data.id,
                            text: res.data.name
                        })
                        Toaster('success', res.meta.message)
                    },
                    error: (xhr) => {
                        Toaster('error', xhr.responseJSON.message)
                    }
                })
            }

            function createNewUnit(val) {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('api.unit.store.ajax') }}",
                    data: {
                        name: val,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: (res) => {
                        select.small_unit.updateOption(
                        val,
                        {
                            value: res.data.id,
                            text: res.data.name
                        })
                        Toaster('success', res.meta.message)
                    },
                    error: (xhr) => {
                        Toaster('error', xhr.responseJSON.message)
                    }
                })
            }

            $("#btn-add-unit").click(async function () {
                let isError = await isCanAddUnit()
                if(isError) {
                    return 
                }

                $.ajax({
                    url: `/admin/units-ajax/`,
                    type: "GET",
                    success: function (response) {
                        create_new_tb(response.data);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    },
                });
            });

            $(document).ready(function() {
                $(document).on('click', '#form-add-category button[type=submit]', function(e) {
                    e.preventDefault()
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('admin.category.store.ajax') }}",
                        data: {
                            name: $('#category-name').val(),
                            "_token": "{{ csrf_token() }}"
                        },
                        success: (res) => {
                            select.category.addOption({
                                value: res.data.id,
                                text: res.data.name
                            })
                            Toaster('success', res.meta.message)
                        },
                        error: (xhr) => {
                            Toaster('error', xhr.responseJSON.message)
                        }
                    })
                })
            })

            $(document).on('click', '.btn-delete', function() {
                let tr = $(this).parent().parent()
                tr.remove()
            })

            $(document).on('input', '.format-number',function() {
                let unformat_val = unformatNum($(this).val())
                if(unformat_val < 0) unformat_val = 0
                $(this).val(formatNum($(this).val()))
            })

            $(document).on('input', '.input-price', function() {
                $(this).parent().parent().parent().find('.selling-price').val(unformatNum($(this).val()))
            })

            $(document).on('input', '.input-qty', function() {
                $(this).parent().parent().find('.qty-small').val(unformatNum($(this).val()))
            })

            function create_new_tb(data) {
                let last_index = $('#table-units tr[data-index]').last().data('index')
                last_index = last_index ? last_index : 0;

                let optionHTML = ''
                data.forEach(function(unit) {
                    optionHTML += `<option value="${unit.id}">${unit.name}</option>`
                })

                let tr_showed = `
                    <tr data-index="${last_index+1}">
                        <td>
                            <select name="unit_id[]" class="form-select" required>
                                <option value="" selected disabled>-- pilih satuan --</option>
                                ${optionHTML}
                            </select>
                            <input type="hidden" name="quantity_in_small_unit[]" class="qty-small"/>
                            <input type="hidden" name="selling_price[]" class="selling-price"/>
                        </td>
                        <td>
                            <input type="text" class="format-number input-qty form-control" placeholder="Jumlah dalam satuan terkecil" required/>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="text" class="format-number input-price form-control" placeholder="Harga Jual" required />
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete">-</button>
                        </td>
                    </tr>
                `
                if(last_index == 0) $('#table-units').html(tr_showed)
                else $('#table-units').append(tr_showed)
            }

            $(document).on('change', '[name=name]', function(){
                isCanAddUnit()
            })
            $(document).on('change', '[name=code]', function(){
                isCanAddUnit(true)
            })
            $(document).on('change', '[name=category_id]', function(){
                isCanAddUnit()
            })
            $(document).on('change', '[name=supplier_id\\[\\]]', function(){
                isCanAddUnit()
            })
            $(document).on('change', '[name=small_unit_id]', function(){
                isCanAddUnit()
            })

            isCanAddUnit()

            async function checkCode() {
                let code = $('[name=code]').val()
                return await $.ajax({
                    url: "{{ route('find.product.check-code') }}",
                    method: "POST",
                    data: {
                        code
                    }
                })
            }

            async function isCanAddUnit(is_code = false) {
                let product = $('[name=name]').val()
                let invoice = $('[name=code]').val()
                let category = select.category.getValue()
                let small_unit = select.small_unit.getValue()

                let count_error = 0

                if(!small_unit) {
                    $('[name=small_unit_id]').parent().find('.on_error').removeClass('d-none')
                    if(product && invoice && category) select.small_unit.focus()
                    count_error++
                } else {
                    $('[name=small_unit_id]').parent().find('.on_error').addClass('d-none')
                }

                if(!category) {
                    $('[name=category_id]').parent().find('.on_error').removeClass('d-none')
                    if(product && invoice) select.category.focus()
                    count_error++
                } else {
                    $('[name=category_id]').parent().find('.on_error').addClass('d-none')
                }

                let code_error = 0

                if(!invoice) {
                    $('[name=code]').parent().find('.on_error').removeClass('d-none')
                    $('[name=code]').parent().find('.on_error').html('Kode produk tidak boleh kosong')
                    $('[name=code]').focus()
                    count_error++
                    code_error++
                } else {
                    $('[name=code]').parent().find('.on_error').addClass('d-none')
                }
                
                if(is_code) {
                    let code_already_used = await checkCode()
                    if(!code_already_used.data) {
                        $('[name=code]').parent().find('.on_error').removeClass('d-none')
                        $('[name=code]').parent().find('.on_error').html('Kode produk telah digunakan')
                        $('[name=code]').focus()
                        count_error++
                    } else if(code_error == 0) {
                        $('[name=code]').parent().find('.on_error').addClass('d-none')
                    }
                }
                
                if(!product) {
                    $('[name=name]').parent().find('.on_error').removeClass('d-none')
                    $('[name=name]').focus()
                    count_error++
                } else {
                    $('[name=name]').parent().find('.on_error').addClass('d-none')
                }

                if(count_error) $('[type=submit]').prop('disabled', true)
                else $('[type=submit]').prop('disabled', false)

                return count_error
            }
        })
    </script>
@endsection
