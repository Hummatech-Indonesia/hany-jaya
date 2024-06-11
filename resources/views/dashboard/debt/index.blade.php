@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.cashier')
@section('content')
    <div class="container-fluid">
        <div class="widget-content searchable-container list mt-4">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>No Invoice</th>
                            <th>Total Harga Beli</th>
                            <th>Tanggal Pembelian</th>
                            <td>Detail</td>
                        </thead>
                        <tbody>
                            @forelse ($debts as $index => $debt)
                                <tr class="search-items">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">

                                            {{ $debt->buyer->name }}
                                        </h6>
                                    </td>
                                    <td>{{ FormatedHelper::rupiahCurrency($debt->purchase->name) }}</td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::dateTimeFormat($debt->nominal) }}
                                        </h6>
                                    </td>
                                    <td>Detail</td>
                                </tr>
                            @empty
                                <p>Data pembelian masih kosong</p>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $debts->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.selling.widgets.detail-invoice')
@endsection
@section('script')
    <script>
        $(".btn-detail").on("click", function() {
            $("#value_table").empty(); // Mengosongkan isi tabel sebelum menambahkan detail penjualan baru
            $("#modalDetailHistory").modal("show");
            let detailSellings = $(this).data("detail-selling");
            let name = $(this).data('name');
            let address = $(this).data('address');
            $('#name').html(name);
            $('#address').html(address);
            detailSellings.forEach(function(item, index) {
                $("#value_table").append(
                    `
                <tr class="search-items">
                    <td>${index + 1}</td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.product.name}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.quantity}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">RP. ${formatRupiah(item.nominal_discount)}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">Rp. ${formatRupiah(item.selling_price)}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams"></h6></td>
                </tr>
                `
                );
            });
        });

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }
    </script>
@endsection
