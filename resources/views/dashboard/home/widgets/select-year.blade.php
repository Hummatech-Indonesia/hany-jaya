@php
    use App\Helpers\FormatedHelper;
@endphp
<div class="w-25">
    <select id="year" class="form-select">
        @foreach($year as $y)
            <option value="{{ $y }}" {{ $y == FormatedHelper::getYear(now()) ? 'selected' : '' }}>{{ $y }}</option>
            <option value="2023">2023</option>
        @endforeach
    </select>
</div>

@push('custom-script')
<script>
    $(document).ready(function() {
        const selectize_year = $('#year').selectize({
            create: false,
            maxItems: 1,
        })
    
        const select_year = selectize_year[0].selectize
    
        $('#year').on('change', function() {
            updateScorecard()
            setSellingChartSettings()
            setNewDtTopBuyer()
        })
    })

</script>
@endpush