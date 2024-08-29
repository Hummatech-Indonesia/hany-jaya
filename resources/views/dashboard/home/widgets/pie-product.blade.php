<div id="pieChart"></div>

@push('custom-script')
<script>
    var options = {
        series: [1],
        chart: {
            width: 300,
            type: 'pie',
        },
        legend: {
            position: 'bottom'
        },
        colors: ["#aaaaaa"],
        labels: ["kosong"],
        responsive: [{
            breakpoint: 990,
            options: {
                chart: {
                    width: 300
                },
                legend: {
                    position: 'right'
                }
            }
        }]
    };
    
    var pie_chart = new ApexCharts(document.querySelector("#pieChart"), options);
    pie_chart.render();

    updatePieChart()

    function updatePieChart() {
        let year = $('#year').val()

        $.ajax({
            type: "GET",
            url: "{{ route('admin.get.category.ajax') }}?year="+year,
            success: function(response) {
                var options = {
                    series: [],
                    chart: {
                        width: 300,
                        type: 'pie',
                    },
                    colors: [],
                    labels: [],
                };
                let count = 0; // Inisialisasi count sebelum melakukan penambahan
                $.each(response, function(index, value) {
                    options.labels.push(value.name);
                    count = 0;
                    $.each(value.products, function(i, item) {
                        if (item.category_id === value.id) {
                            count += item.detail_sellings_count;
                        }
                    });
                    options.series.push(count);
                });
    
                if(options.labels.length < 1) {
                    options.labels.push("kosong")
                    options.series.push(1)
                    options.colors.push("#aaaaaa")
                }

                pie_chart.updateOptions(options)
            }
            
        });
    }
</script>
@endpush