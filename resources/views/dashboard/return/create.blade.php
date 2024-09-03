@extends('dashboard.layouts.dashboard') 
@push("title")
    Retur Penjualan
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Tambah Retur Penjualan</h4>
                        <p>Tambah data retur oleh pelanggan</p>
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

        <form action="{{ route('admin.purchases.return') }}" method="POST" class="card" id="add-return-form">
            @csrf
            <input type="hidden" name="selling_id">
            <input type="hidden" name="invoice_number">
            <div class="card-body mb-0 pb-0">
                <div class="form-group mb-3">
                    <label for="invoice">No. Invoice <small class="text-danger">*</small></label>
                    <div class="d-flex gap-3">
                        <input type="text" name="invoice" id="invoice" placeholder="No. Invoice" class="form-control w-100">
                        <button type="button" class="btn btn-secondary" id="btn-search-invoice"><i class="ti ti-search"></i></button>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="note">Catatan / Alasan <small class="text-danger">*</small></label>
                    <textarea type="text" name="note" id="note" placeholder="Catatan / Alasan" class="form-control"></textarea>
                </div>
                <div class="tb-product">
                    <label>Produk <small class="text-danger">*</small></label>
                    <table class="table align-middle table-striped text-center">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th style="width: 200px">Produk</th>
                                <th style="width: 100px">Qty Dibeli</th>
                                <th style="width: 200px">Qty Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody id="tb-product-list">
                            <tr>
                                <td colspan="4" class="text-center text-muted">-- no invoice tidak ditemukan --</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-add-return">Tambah</button>
            </div>
        </form>

        @include('components.swal-message')
        @include('components.swal-toast')
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/number-format.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btn-search-invoice', function() {
                $.ajax({
                    url: "{{ route('find.selling-invoice')}}",
                    data: {
                        invoice: $('#invoice').val(),
                    },
                    success: (res) => {
                        let product_html = ''
                        $('[name=selling_id]').val(res.data.id)
                        $('[name=invoice_number]').val(res.data.invoice_number)
                        res.data.detail_sellings.forEach((selling, index) => {
                            product_html += `<tr data-id="${selling.id}">
                                <th>${index+1}</th>
                                <td>${selling.product.name} (${selling.product.code})</td>
                                <td>${selling.quantity}</td>
                                <td>
                                    <input type="hidden" name="selling_detail_id[]" value="${selling.id}" />
                                    <input class="form-control bg-white qty-back" data-max="${selling.quantity}" value="0"/>
                                    <input type="hidden" name="qty_return[]" value="0" />
                                </td>
                            </tr>`
                        })
                        $('#tb-product-list').html(product_html)
                    }, error: (xhr) => {
                        Toaster('error', 'Data penjualan tidak ditemukan')
                        $('#tb-product-list').html('<tr><td colspan="4" class="text-center">-- no invoice tidak ditemukan --</td></tr>')
                    }
                })
            })

            $(document).on('input', '.qty-back', function() {
                let qty = unformatNum($(this).val())
                let max = $(this).data('max')

                if(qty < 0) qty = 0
                if(qty > max) qty = max

                $(this).val(formatNum(qty, true))
                $(this).closest('tr').find('input[name=qty_return\\[\\]]').val(qty)
            })

            $(document).on('input', '#invoice', function() {
                if(!$('#invoice').val()) {
                    $('#invoice').closest('.form-group').find('div.text-danger').remove()
                    $('#invoice').addClass('is-invalid')
                    $('#invoice').closest('.form-group').append('<div class="text-danger">No. Invoice tidak boleh kosong</div>')
                } else if($('[name=invoice_number]').val() && ($('#invoice').val() !== $('[name=invoice_number]').val())) {
                    $('#invoice').closest('.form-group').find('div.text-danger').remove()
                    $('#invoice').addClass('is-invalid')
                    $('#invoice').closest('.form-group').append('<div class="text-danger">Invoice saat ini dan invoice yang dipilih berbeda</div>')
                } else {
                    $('#invoice').closest('.form-group').find('div.text-danger').remove()
                    $('#invoice').removeClass('is-invalid')
                }
            })
            
            $(document).on('input', '#note', function() {
                if(!$('#note').val()) {
                    $('#note').closest('.form-group').find('div.text-danger').remove()
                    $('#note').addClass('is-invalid')
                    $('#note').closest('.form-group').append('<div class="text-danger">Catatan tidak boleh kosong</div>')
                } else {
                    $('#note').closest('.form-group').find('div.text-danger').remove()
                    $('#note').removeClass('is-invalid')
                }
            })

            $(document).on('click', '#btn-add-return', function() {
                if(!$('#invoice').val() || ($('[name=invoice_number]').val() && ($('#invoice').val() !== $('[name=invoice_number]').val()))) {
                    $('#invoice').trigger('input')
                    $('#invoice').focus()
                    return;
                }

                if(!$('#note').val()) {
                    $('#note').trigger('input')
                    $('#note').focus()
                    return;
                }

                if(!$('#tb-product-list [data-id]').length) {
                    Toaster('error', 'Data pembelian belum dipilih atau tidak ada produk dibeli pada pembelian')
                    return;
                }

                $('#add-return-form').submit()
            })
        })
    </script>
@endsection