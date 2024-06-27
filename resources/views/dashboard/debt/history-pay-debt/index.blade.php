@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.cashier')
@section('content')
    <div class="container-fluid">
        <form action="" method="get">
            <div class="row justify-content-end">
                <div class="col-3 mb-3">
                    <input type="text" value="{{ Request::get('name') }}" class="form-control" id="name" name="name"
                        aria-describedby="name" placeholder="Name" />
                </div>
                <div class="col-1">
                    <button class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
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
