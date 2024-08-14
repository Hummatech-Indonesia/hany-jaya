<table class="table align-middle" id="table-adjustment-history"></table>

@push('custom-style')
    <link href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}" rel="stylesheet">
@endpush
@push('custom-script')
    <script src="{{asset('assets/libs/momentjs/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            let products = [];

            let tb_adjust_history = $('#table-adjustment-history').DataTable({
                processing: true,
                serverSide: true,
                order: [[5, 'desc']],
                lengthMenu: [[2, 5, 10, 25, 50, -1], [2, 5, 10, 25, 50, "Semua"]],
                language: {
                    processing: `Memuat...`
                },
                ajax: {
                    url: "{{ route('data-table.list-product') }}",
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "name",
                        title: "Produk",
                        render: (data, type, row) => {
                            
                            // cek produk sudah ada atau belum di list products 
                            let product = products.find(p => p.id === row.id)
                            if (!product) {
                                delete row.unit
                                delete row.category
                                delete row.supplier_products
                                delete row.product_units
                                delete row.detail_purchases
                                products.push({...row, newQuantity: row.quantity})
                                product = row
                            }
                            return product.name + ' | ' + product.code
                        },
                    },{
                        data: "quantity",
                        title: "Stok Sebelumnya",
                        render: (data, type) => {
                            let quantity = formatNum(data, true)
                            return `<input class="form-control" value="${quantity}" readonly />`
                        }
                    }, {
                        data: "quantity",
                        title: "Stok Baru",
                        render: (data, type, row) => {
                            let product = products.find(p => p.id === row.id)

                            return `<input data-data="${JSON.stringify(product).replace(/"/g, '&quot;')}" class="form-control btn-edit-quantity" value="${product.newQuantity}" />`
                        }
                    }, {
                        title: "Kererangan",
                        render: (data, type, row) => {
                            return `<textarea class="form-control form-control-sm" >-</textarea/>`
                        },
                    }
                ]
            })

            $(document).on('change', '#category_id', function(e) {
                tb_adjust_history.ajax.url("{{route('data-table.list-product')}}?category_id=" + $('#category_id').val())
                tb_adjust_history.ajax.reload()

                console.log($('#category_id').val())
            })

            $(document).on('change', '.btn-edit-quantity', function () {
                let data = $(this).data('data')
                products.map(p => {
                    if (p.id === data.id) {
                        p.newQuantity = $(this).val()
                    }
                })
                tb_adjust_history.draw()
            })

            $(document).on('click', '#btn-update-stock', function () {
                let updatedProducts = products.filter(p => p.newQuantity !== p.quantity)

                if (updatedProducts.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.adjustments.update-stock') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            products: updatedProducts,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                toastr.success(data.success)
                                tb_adjust_history.draw()
                            }
                        }
                    })
                }
            })
        })
    </script>
@endpush