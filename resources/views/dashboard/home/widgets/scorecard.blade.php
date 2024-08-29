@php
    use App\Helpers\FormatedHelper;
@endphp

<div class="row" id="score-card">
    <div class="col-lg-4 col-xxl">
        <div class="card bg-primary-subtle scorecard p-3 position-relative overflow-hidden">
            <p class="fs-3">Total Penjualan</p>
            <h4 class="fw-semibold fs-7" id="selling_count">{{ $selling_count }}</h4>
            <i class="ti ti-shopping-cart icon-head"></i>
        </div>
    </div>
    <div class="col-lg-4 col-xxl">
        <div class="card bg-info-subtle scorecard p-3 position-relative overflow-hidden">
            <p class="fs-3">Total Omset</p>
            <h4 class="fw-semibold fs-7" id="selling_sum">{{ FormatedHelper::rupiahCurrency($selling_sum) }}</h4>
            <i class="ti ti-chart-line icon-head"></i>
        </div>
    </div>
    <div class="col-lg-4 col-xxl">
        <div class="card bg-success-subtle scorecard p-3 position-relative overflow-hidden">
            <p class="fs-3">Total Produk</p>
            <h4 class="fw-semibold fs-7" id="product_count">{{ $product_count }}</h4>
            <i class="ti ti-package icon-head"></i>
        </div>
    </div>
    <div class="col-lg-6 col-xxl">
        <div class="card bg-warning-subtle scorecard p-3 position-relative overflow-hidden">
            <p class="fs-3">Jumlah Piutang</p>
            <h4 class="fw-semibold fs-7" id="debt_sum">{{ FormatedHelper::rupiahCurrency($debt) }}</h4>
            <i class="ti ti-wallet icon-head"></i>
        </div>
    </div>
    <div class="col-lg-6 col-xxl">
        <div class="card bg-danger-subtle scorecard p-3 position-relative overflow-hidden">
            <p class="fs-3">Total Pengeluaran</p>
            <h4 class="fw-semibold fs-7" id="cost_sum">{{ FormatedHelper::rupiahCurrency($debt) }}</h4>
            <i class="ti ti-businessplan icon-head"></i>
        </div>
    </div>
</div>

@push('custom-script')
<script>
    function updateScorecard() {
        let year = $('#year').val()
        $.ajax({
            url: "{{route('chart.card.dashboard')}}",
            data: {
                year
            },
            success: (res) => {
                let data = res.data
                $('#score-card #selling_count').html(formatNum(data.selling_count))
                $('#score-card #selling_sum').html('Rp '+formatNum(data.selling_sum))
                $('#score-card #product_count').html(formatNum(data.product_count))
                $('#score-card #debt_sum').html('Rp '+formatNum(data.debt_sum))
                $('#score-card #cost_sum').html('Rp '+formatNum(data.cost_sum))
            }
        })
    }
</script>
@endpush