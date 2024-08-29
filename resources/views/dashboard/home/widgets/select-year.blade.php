@php
    use App\Helpers\FormatedHelper;
@endphp
<div class="w-25">
    <select id="year" class="form-select">
        @foreach($year as $y)
            <option value="{{ $y-1 }}">{{ $y-1 }}</option>
            <option value="{{ $y }}">{{ $y }}</option>
        @endforeach
    </select>
</div>

@push('custom-script')
<script>
    $(document).ready(function() {
        const selectize_year = $('#year').selectize({
            create: false,
            maxItems: 1,
            allowEmptyOption: true,
        })
    
        const select_year = selectize_year[0].selectize

        select_year.setValue(new Date().getFullYear())
        onChangeYear()
    
        $('#year').on('change', function() {
            onChangeYear()
        })
        
        function onChangeYear() {
            updateScorecard()
            setSellingChartSettings()
            setNewDtTopBuyer()
        }
    })

</script>
@endpush