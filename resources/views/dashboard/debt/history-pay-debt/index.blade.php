@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Riwayat Pembayaran Piutang</h4>
                        <p>Riwayat pembayaran hutang dari pelanggan.</p>
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
        <div class="row mb-3">
            <div class="col-12">
                <form action="" method="get">
                    <div class="d-flex flex-row gap-2 justify-content-end">
                        <div class="col-md-3 col-sm-6">
                            <input type="text" value="{{ Request::get('name') }}" class="form-control" id="name" name="name"
                                aria-describedby="name" placeholder="Name" />
                        </div>
                        <button class="btn btn-primary">Cari</button>
                        
                    </div>
                </form>
            </div>
        </div>
        <div class="widget-content searchable-container list">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Hutang Dibayar</th>
                            <th>Tanggal Bayar Hutang</th>
                        </thead>
                        <tbody>
                            @foreach ($historyPayDebts as $index => $historyPayDebt)
                                <tr class="search-items">
                                    <td>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $historyPayDebt->buyer->name }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::rupiahCurrency($historyPayDebt->pay_debt) }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::dateTimeFormat($historyPayDebt->created_at) }}
                                        </h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $historyPayDebts->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.debt.users.widgets.pay-debt');
@endsection
@section('script')
    <script>
        $(".btn-pay-debt").on("click", function() {
            $("#modalPayDebt").modal("show");
            let url = $(this).attr("data-url");
            $("#form-update").attr("action", url);
        });
    </script>
@endsection
