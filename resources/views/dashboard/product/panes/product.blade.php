@include('dashboard.product.widgets.modal-detail')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="alert alert-warning" role="alert">
                Sebelum melakukan export / cetak data, pastikan kolom "entries per page" bernilai "semua" agar keseluruhan data tercetak.
            </div>
            <table class="table align-middle table-hover w-100" id="product-table">
            </table>
        </div>
    </div>
</div>
@push('custom-script')
<script src="{{ asset('assets/js/number-format.js') }}"></script>
<script>  
    $(document).ready(function() {
        let product_datatable = $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
            dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            order: [[2, 'asc']],
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    }
                }
            ],
            initComplete: function() {
                $('.dt-buttons').addClass('btn-group-sm')
            },
            language: {
                processing: `Memuat...`
            },
            ajax: {
                url: "{{ route('data-table.list-product') }}",
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No.",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, 
                {
                    title: "Produk",
                    data: "name",
                    render: (data, type, full) => {
                        let image = full['image'] ? `{{ asset('storage') }}/${full['image']}` : `{{ asset('no_image_available.jpeg') }}`;
                        return `<div class="d-flex flex-row gap-4 align-items-center">
                                <img src="${image}" alt="gambar produk" class="rounded" style="width: 48px;height: 48px;object-fit: cover"/>
                                <div>
                                    <a class="productname">${full['name']}</a>
                                    <p class="mb-1 fs-2 text-muted">${full['category']['name']}</p>
                                    <span class="fs-2 mb-1 badge font-medium bg-light-secondary text-secondary">${full['code']}</span>
                                </div>
                            </div>`
                    },
                },
                {
                    title: "Satuan Terkecil",
                    width: "5%",
                    mRender: (data, type, full) => {
                        return full['unit']['name'];
                    }
                },
                {
                    title: "Stok - Harga",
                    data: "quantity",
                    render: (data, type, full) => {
                        let stock = "";
                        full['product_units'].forEach((unit, index) => {
                            stock += ` <span class="fs-2 mb-1 badge font-medium bg-muted text-white">${Math.floor(full['quantity'] / unit['quantity_in_small_unit'])} ${unit['unit']['name']} - Rp.${formatNum(unit['selling_price'], true)}</span>`
                        })
                        return stock ? `<div class="d-flex flex-row gap-2 flex-wrap">
                            ${stock}
                            </div>` : `-`;
                    },
                },
                {
                    title: "Distributor",
                    mRender: (data, type, full) => {
                        console.log(full)
                        let suppliers = "";
                        let list_supplier = [];
                        full['detail_purchases'].forEach((detail_purchase, index) => {
                            if(list_supplier.includes(detail_purchase['purchase']['supplier']['name'])) return;
                            list_supplier.push(detail_purchase['purchase']['supplier']['name']);
                            suppliers += ` <span class="fs-3 mb-1 badge font-medium bg-light-primary text-muted"><i class="ti ti-truck"></i> ${detail_purchase['purchase']['supplier']['name']}</span>`
                        })
                        return suppliers ? `<div class="d-flex flex-row gap-2 flex-wrap">
                            ${suppliers}
                            </div>` : `-`;
                    }
                },
                {
                    mRender: (data, type, full) => {
                        let url_edit = "{{ route('admin.products.edit', 'selected_id') }}"
                        let url_destroy = "{{ route('admin.products.destroy', 'selected_id') }}"
                        url_edit = url_edit.replace('selected_id', full['id'])
                        url_destroy = url_destroy.replace('selected_id', full['id'])

                        return `<div class="d-flex gap-2">
                            <button data-product="${JSON.stringify(full).replaceAll('"', "'")}" class="btn btn-light-primary btn-sm btn-detail"><i class="fs-4 ti ti-eye"></i></button>
                            <a href="${url_edit}" class="btn btn-light-warning btn-sm btn-update-icon"><i class="fs-4 ti ti-edit"></i></a>
                            <button data-url="${url_destroy}" class="btn btn-delete-product btn-light-danger btn-delete-icon btn-sm"><i class="fs-4 ti ti-trash"></i></button>
                        </div>`
                    },
                    title: "Aksi",
                    width: "15%",
                    orderable: false,
                    searchable: false
                }
            ]
        })

        $(document).on("click", '.btn-delete-product', function() {
            $('#delete-title').html('Hapus Produk');
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });

        $(document).on("click", ".btn-detail", function() {
            $('#modalDetailProduct').modal('show');

            let product = $(this).data('product');
            product = JSON.parse(product.replace(/'/g, '"'))

            $('#img-detail').attr('src', "{{ asset('storage') }}/"+product['image']);
            $('#name-product-detail').val(product['name']);  
            $('#code-product-detail').val(product['code']);
            $('#category-detail').val(product['category']['name']);
            console.log(product)
            let table_unit = ''
            product['product_units'].forEach((unit, index) => {
                table_unit += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${Math.floor(product['quantity'] / unit['quantity_in_small_unit'])} ${unit['unit']['name']}</td>
                        <td>Rp ${unit['selling_price']}</td>
                    </tr>
                `
            })
            $('#table-unit-detail').html(table_unit);
        })
    })
</script>
@endpush