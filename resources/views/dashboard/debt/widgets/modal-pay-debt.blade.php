<div class="modal" tabindex="-1" id="modal-debt-pay">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="">
            <div class="modal-header">
                <h5>Pembayaran Piutang</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @csrf
                    <div class="col-md-3 mb-md-3">
                        <label for="buyer_id">Pembeli</label> <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-9 mb-3">
                        <select name="buyer_id" id="buyer_id" class="form-select" required></select>
                    </div>

                    <div class="col-md-3 mb-md-3">
                        <label for="debt">Total Hutang</label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" class="form-control" id="debt" placeholder="Total Hutang" readonly>
                        </div>
                    </div>

                    <div class="col-md-3 mb-md-3">
                        <label for="pay">Dibayarkan <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" class="form-control" id="pay" name="pay" placeholder="Hutang Dibayarkan" required>
                            <input type="hidden" name="pay_debt">
                        </div>
                    </div>

                    <div class="col-md-3 mb-md-3">
                        <label for="desc">Keterangan <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="desc" name="desc" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </div>
        </div>
    </div>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            const selectize_buyer = $('#buyer_id').selectize({
                maxItems: 1,
                placeholder: "Pilih Pembeli",
                valueField: "id",
                labelField: "label",
                searchField: "label"
            })

            const select_buyer = selectize_buyer[0].selectize

            $.ajax({
                url: "{{ route('buyer.list-search') }}",
                method: "GET",
                success: (res) => {
                    res.data.forEach(data => {
                        data.label = data.name+" - "+data.address
                        select_buyer.addOption(data)
                    })
                }
            })

            function getSelectedBuyerItem() {
                const selected_buyer_value = select_buyer.getValue()
                return select_buyer.options[selected_buyer_value]
            }

            function changeDebt() {
                $('#pay').val(formatNum($('#pay').val()))
                const selected_buyer_item = getSelectedBuyerItem()

                if(unformatNum($('#pay').val()) < 0) $('#pay').val(0)
                if(!selected_buyer_item) $('#pay').val(0)
                else if(unformatNum($('#pay').val()) > selected_buyer_item.debt) $('#pay').val(formatNum(selected_buyer_item.debt))

                $('[name=pay_debt]').val(unformatNum($('#pay').val()))
            }

            function changePayDebtFormAction() {
                let url = "{{ route('cashier.pay.debt', 'selected_id') }}"
                url = url.replace('selected_id', getSelectedBuyerItem().id)
                $('#modal-debt-pay form').attr('action', url)
            }

            $('#buyer_id').on('change', function() {
                const selected_buyer_item = getSelectedBuyerItem()
                $('#debt').val(formatNum(selected_buyer_item.debt, true))
                changeDebt()
                changePayDebtFormAction()
            })

            $('#pay').on('input', function() {
                changeDebt()
            })
        })
    </script>
@endpush