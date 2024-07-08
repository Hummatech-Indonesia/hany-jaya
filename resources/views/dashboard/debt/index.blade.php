@php
    use App\Helpers\FormatedHelper;
    use App\Enums\StatusDebt;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Hutang
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Riwayat Piutang</h4>
                        <p>Riwayat hutang dari pelanggan.</p>
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
        <div class="widget-content searchable-container list mt-4">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>Nama </th>
                            <th>Nominal Hutang</th>
                            {{-- <td>Status</td> --}}
                            <td>Tanggal Hutang</td>
                            <td>Aksi</td>
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
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::rupiahCurrency($debt->nominal) }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::dateTimeFormat($debt->created_at) }}
                                        </h6>
                                    </td>
                                    {{-- <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            @if ($debt->status == StatusDebt::COMPLETED->value)
                                                <span class="ranslate-middle badge rounded-pill bg-success">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="ranslate-middle badge rounded-pill bg-danger">
                                                    Belum Lunas
                                                </span>
                                            @endif
                                        </h6>
                                    </td> --}}
                                    <td>
                                        <div class="d-flex">
                                            {{-- <form action="{{ route('cashier.rolling.student', $debt->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" title="Ubah Status"
                                                        width="16" height="16" fill="currentColor"
                                                        class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                                        <path
                                                            d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                                    </svg>
                                                </button>
                                            </form> --}}
                                            <button class="btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="btn-detail"
                                                    data-detail-selling="{{ $debt->selling->detailSellings }}"
                                                    data-name="{{ $debt->selling->buyer->name }}"
                                                    data-price="{{ $debt->selling->amount_price }}"
                                                    data-address="{{ $debt->selling->buyer->address }}" width="16"
                                                    height="16" fill="currentColor" class="bi bi-eye"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                </svg>
                                            </button>

                                        </div>

                                    </td>
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
    @include('dashboard.debt.widgets.detail-debt')
@endsection
@section('script')
    <script>
        $(".btn-detail").on("click", function() {
            $("#value_table").empty(); // Mengosongkan isi tabel sebelum menambahkan detail penjualan baru
            $("#modalDetailHistory").modal("show");
            let detailSellings = $(this).data("detail-selling");
            let price = $(this).data('price');
            $('#price').html(formatRupiah(price));
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
