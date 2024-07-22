<div class="widget-content searchable-container list mt-4">
    <div class="card card-body">
        <div class="table-responsive">
            <div class="alert alert-warning" role="alert">
                Sebelum melakukan export / cetak data, pastikan kolom "entries per page" bernilai "semua" agar keseluruhan data tercetak.
            </div>
            <div class="row">
                <div class="d-flex align-items-center" id="input-date-group">
                    <div>Tanggal: </div>
                    <input type="text" id="input-date" class="form-control form-control-sm flex-fill w-100" value="" placeholder="Tanggal Pembelian">
                </div>
            </div>
            <table class="table align-middle table-striped table-hover" id="tb-transaction-history"></table>
        </div>
    </div>
</div>

@push('custom-script')
    <script>

        $(document).ready(function() {
            const datatable_transaction = $('#tb-transaction-history').DataTable({
                processing: true,
                serverSide: true,
                order: [[2, 'desc']],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        }
                    }, {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths = 
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                initComplete: function() {
                    let a = $('#input-date-group').detach()
                    $('.input-date-container').append(a)
                    $('.dt-buttons').addClass('btn-group-sm')
                    $('#input-date').daterangepicker({
                        autoUpdateInput: false
                    })
                },
                language: {
                    processing: 'Memuat...'
                },
                ajax: {
                    url: "{{ route('data-table.list-transaction-history') }}"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "invoice_number",
                        title: "No. Invoice",
                    }, {
                        data: "created_at",
                        title: "Tanggal",
                        render: (data, type, row) => {
                            return moment(data).locale('id').format('LL')
                        },
                    }, {
                        data: "user.name",
                        title: "Nama Pembeli",
                    }, {
                        data: "amount_price",
                        title: "Total Harga",
                        render: (data, type, row) => {
                            return `Rp. ${formatNum(data)}`
                        }
                    }, {
                        data: "status_payment",
                        title: "Status Pembayaran",
                        render: (data, type, row) => {
                            if(data == 'debt') return `<span class="badge bg-warning text-white">Hutang</span>`;
                            else if(data == 'cash') return `<span class="badge bg-success text-white">Tunai</span>`;
                            else return `<span class="badge bg-primary text-white">Split</span>`;
                        }
                    }, {
                        mRender: (data, type, full) => {
                            return `
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-light btn-detail"
                                    data-detail-selling="${JSON.stringify(full['detail_sellings']).replaceAll('"', "'")}"
                                    data-name="${full['buyer']['name']}"
                                    data-price="${full['amount_price']}" data-pay="${full['pay']}"
                                    data-return="${full['return']}"
                                    data-status_payment="${full['status_payment']}"
                                    data-address="${full['buyer']['address']}">
                                        <i class="ti ti-eye"></i>
                                </button>
                                <button 
                                    type="button"
                                    class="btn btn-light btn-print btn-update-icon"
                                    data-id="${full['id']}"
                                >
                                    <i class="ti ti-printer"></i>
                                </button>
                            </div>
                            `
                        },
                        title: "Aksi",
                        searchable: false,
                        orderable: false
                    }
                ]
            })

            $('#input-date').daterangepicker({
                autoUpdateInput: false
            })

            $('#input-date').on('apply.daterangepicker hide.daterangepicker', function(ev, picker) {
                let val = picker.startDate.format('DD-MM-YYYY')+' s/d '+picker.endDate.format('DD-MM-YYYY')
                $('#input-date').val(val)
                let url = "{{ route('data-table.list-transaction-history') }}"
                url = url+'?date='+$('#input-date').val()
                datatable_transaction.ajax.url(url).load()
            })

            $(document).on("click", ".btn-detail", function() {
                $("#value_table").empty();
                $("#modalDetailHistory").modal("show");
                let detailSellings = []
                if(typeof $(this).data("detail-selling") == 'string') {
                    detailSellings = JSON.parse($(this).data("detail-selling").replaceAll("'",'"'));
                }
                let name = `${$(this).data('name')} - ${$(this).data('address')}`;
                let returns = $(this).data('return');
                let status_payment = $(this).data('status_payment');
                let price = $(this).data('price');
                let pay = $(this).data('pay');
                if (status_payment == 'debt') {
                    $('.sembuyikan').hide();
                } else {
                    $('.sembunyikan').show();
                    $('#return').html(formatNum(returns));
                    $('#pay').html(formatNum(pay));
                }

                $('#name').html(name);
                $('#price').html(formatNum(price));
                if (status_payment == 'debt') {
                    $('#status').html('<span class="mb-1 badge font-medium bg-danger text-white">Hutang</span>');
                } else {
                    $('#status').html('<span class="mb-1 badge font-medium bg-success text-white">Tunai</span>');
                }

                detailSellings.forEach(function(item, index) {
                    $("#value_table").append(
                        `
                    <tr class="search-items">
                        <td>${index + 1}</td>
                        <td><h6 class="mb-0">${item.product.name}</h6></td>
                        <td><h6 class="mb-0">${item.product_unit.unit.name}</h6></td>
                        <td><h6 class="mb-0">${item.quantity}</h6></td>
                        <td><h6 class="mb-0">RP. ${formatNum(item.nominal_discount)}</h6></td>
                        <td><h6 class="mb-0">Rp. ${formatNum(item.selling_price)}</h6></td>
                    </tr>
                    `
                    );
                });
            });

            $(document).on("click", ".btn-print", function() {
                let print_url = "{{route('print.transaction-history', 'selected_id')}}"
                print_url = print_url.replace('selected_id', $(this).data('id'))

                Swal.fire({
                    icon: 'question',
                    title: 'Data akan di cetak',
                    text: 'Apakah anda yakin?',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then(res => {
                    if(res.isConfirmed) {
                        $.ajax({
                            url: print_url,
                            success: (res) => {
                                printSwal('success', 'Sukses', res.message)
                            }
                        })
                    }
                })

            })

            function printSwal(icon, title, text) {
                Swal.fire({
                    icon, title, text
                })
            }
        })
    </script>
@endpush