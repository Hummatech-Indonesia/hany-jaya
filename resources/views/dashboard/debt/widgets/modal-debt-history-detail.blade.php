<div class="modal modal-lg" tabindex="-1" id="modal-debt-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Piutang</h5>
                <button type="button" data-bs-dismiss="modal" class="btn btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-6 form-group mb-2">
                        <label class="form-label">Nama</label>
                        <div class="form-control" show-for="name"></div>
                    </div>
                    <div class="col-6 form-group mb-2">
                        <label class="form-label">Alamat</label>
                        <div class="form-control" show-for="address"></div>
                    </div>
                    <div class="col-6 form-group mb-2">
                        <label class="form-label">Invoice</label>
                        <div class="form-control" show-for="invoice"></div>
                    </div>
                    <div class="col-6 form-group mb-2">
                        <label class="form-label">Tanggal</label>
                        <div class="form-control" show-for="date"></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody show-for="selling"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.detail-history-debt', function() {
                const data = JSON.parse($(this).data('debt').replaceAll("'", '"'))
                console.log(data)

                $('#modal-debt-detail [show-for=name]').html(data.buyer.name)
                $('#modal-debt-detail [show-for=address]').html(data.buyer.address)
                $('#modal-debt-detail [show-for=invoice]').html(data.selling.invoice_number)
                $('#modal-debt-detail [show-for=date]').html(moment(data.created_at).format('DD MMMM YYYY'))

                let tb_selling = ''
                data.selling.detail_sellings.forEach((data, index) => {
                    tb_selling += `
                        <tr>
                            <th>${index+1}</th>
                            <td>${data.product.name} | ${data.product.code}</td>
                            <td>${formatNum(data.quantity, true)} ${data.product_unit.unit.name}</td>
                            <td>Rp ${formatNum(data.product_unit_price, true)}</td>
                            <td>Rp ${formatNum(data.selling_price, true)}</td>
                        </tr>
                    `
                })

                tb_selling += `
                    <tr>
                        <td colspan="3"></td>
                        <th>Total</th>
                        <td>Rp ${formatNum(data.selling.amount_price, true)}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <th>Tunai</th>
                        <td>Rp ${formatNum(data.selling.pay, true)}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <th>Kembalian</th>
                        <td>Rp ${formatNum(data.selling.return, true)}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <th>Hutang</th>
                        <td>Rp ${formatNum(data.nominal, true)}</td>
                    </tr>
                `

                $('#modal-debt-detail [show-for=selling]').html(tb_selling)

                $('#modal-debt-detail').modal('show')
            })
        })
    </script>
@endpush