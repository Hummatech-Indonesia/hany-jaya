<div id="pieChart"></div>

@push('custom-script')
<script>
    $.ajax({
        type: "GET",
        url: "{{ route('admin.get.category.ajax') }}",
        success: function(response) {
            let labels = [];
            let series = [];
            let colors = []
            let count = 0; // Inisialisasi count sebelum melakukan penambahan
            $.each(response, function(index, value) {
                labels.push(value.name);
                count = 0;
                $.each(value.products, function(i, item) {
                    if (item.category_id === value.id) {
                        count += item.detail_sellings_count;
                    }
                });
                series.push(count);

                // Menambah total detail sellings count ke dalam series
            });

            if(labels.length < 1) {
                labels.push("kosong")
                series.push(1)
                colors.push("#aaaaaa")
            }

            var options = {
                series: series,
                chart: {
                    width: 300,
                    type: 'pie',
                },
                colors: colors,
                labels: labels,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#pieChart"), options);
            chart.render();

        }
    });
</script>
@endpush