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
                        <h4 class="fw-semibold mb-8">Daftar Piutang</h4>
                        <p>Daftar piutang dari pelanggan.</p>
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
        <div class="row  mb-3">
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
                            <th>Name</th>
                            <th>Total Hutang</th>
                            <th>Bayar Hutang</th>
                        </thead>
                        <tbody>
                            @forelse ($buyers as $index => $buyer)
                                <tr class="search-items">
                                    <td>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $buyer->name }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::rupiahCurrency($buyer->debt) }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            <button class="btn btn-primary btn-pay-debt"
                                                data-url="{{ route('cashier.pay.debt', $buyer->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                    <path
                                                        d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z" />
                                                </svg>
                                            </button>
                                        </h6>
                                    </td>
                                </tr>
                            @empty
                                <p>Data Kosong</p>
                            @endforelse

                        </tbody>
                    </table>
                    {{-- {{ $buyers->links() }} --}}
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
