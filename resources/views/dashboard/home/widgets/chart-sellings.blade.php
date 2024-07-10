<div id="sellings-chart">
</div>

@push('custom-script')
    <script>
        let chartSettings = {
            chart: {
                type: 'bar',
                height: 300
            },
            series: [],
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return formatNum(val)
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: (val) => {
                        return formatNum(val)
                    }
                }
            },
            dataLabels: {
                enabled: false
            }
        }

        var sellingsChart = new ApexCharts(document.querySelector('#sellings-chart'), chartSettings)
        sellingsChart.render()

        setSellingChartSettings()

        function setSellingChartSettings() {
            let year = $('#year').val()

            $.ajax({
                url: "{{route('chart.penjualan')}}",
                method: 'GET',
                data: {
                    type: 'yearly',
                    year
                },
                success: (res) => {
                    let new_series = [{
                        data: []
                    }]
                    
                    Object.keys(res.data).forEach((data) => {
                        new_series[0].data.push({
                            x: data.substr(0, 3),
                            y: res.data[data]
                        })
                    })

                    sellingsChart.updateSeries(new_series)
                },
                error: (xhr) => {
                    console.log(xhr)
                }
            })
        }
    </script>
@endpush