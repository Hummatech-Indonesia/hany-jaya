@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Beranda
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Laporan Laba Rugi</h4>
                        <p>Laporan laba rugi dari pembelian dan penjualan.</p>
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

        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="type">Tipe Laporan</label>
                    <select name="type" id="type" class="form-select">
                        <option value="" selected disabled>-- pilih tipe laporan --</option>
                        <option value="yearly">Tahunan</option>
                        <option value="monthly">Bulanan</option>
                    </select>
                </div>
                <div class="row" id="detail-type">
                    <div class="col" data-type="monthly">
                        <div class="form-group mb-3">
                            <label for="month">Bulan</label>
                            <select name="month" id="month" class="form-select">
                                <option value="" selected disabled>-- pilih bulan --</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col" data-type="yearly">
                        <div class="form-group mb-3">
                            <label for="year">Tahun</label>
                            <select name="year" id="year" class="form-select">
                                <option value="" selected disabled>-- pilih tahun --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="print-component" style="display: none">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Laporan</h5>
                <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center gap-1" id="btn-print"><i class="ti ti-printer"></i> Cetak Laporan</button>
            </div>
            <div class="card-body" id="printable-element" style="">
                <h5 style="margin-bottom: 0rem; text-align: center; font-weight: bold;font-family: sans-serif">Laporan Laba Rugi Hany Jaya</h5>
                <h5 style="margin-top: 0rem; text-align: center; font-weight: semibold;font-family: sans-serif" id="periode">Periode</h5>
                <table class="table" style="width: 100%; border-collapse: collapse;font-family: sans-serif">
                    <tbody id="printable-list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/libs/apexchartjs/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
    <script>
        $(document).ready(function() {

            firstInit()
            function firstInit() {
                const now = new Date()
                const year = now.getFullYear()
                const month = now.getMonth() + 1

                $('[name=type]').val('monthly').trigger('change')
                $('[name=month]').val(month).trigger('change')
                $('[name=year]').val(year).trigger('change')
            }
            
            initYear()
            let print_title = ''
            function initYear() {
                let year_list = '<option value="" selected disabled>-- pilih tahun --</option>'
                $.ajax({
                    url: "{{route('dashboard.list-tahun')}}",
                    success: (res) => {
                        res.data.map((y) => {
                            year_list += `<option value="${y}">${y}</option>`
                        })

                        $('[name=year]').html(year_list)
                        firstInit()
                    }
                })
            }

            onChangeType()
            function onChangeType() {
                if(!$('[name=type]').val()) {
                    $('#detail-type').hide()
                    $('[data-type=yearly]').hide()
                    $('[data-type=monthly]').hide()
                    $('[name=year]').val('')
                    $('[name=month]').val('')
                } else if($('[name=type]').val() == 'yearly') {
                    $('#detail-type').show()
                    $('[data-type=yearly]').show()
                    $('[data-type=monthly]').hide()
                    $('[name=month]').val('')
                } else {
                    $('#detail-type').show()
                    $('[data-type=yearly]').show()
                    $('[data-type=monthly]').show()
                }

                checkIsCanGetReport()
            }

            function checkIsCanGetReport() {
                if($('[name=type]').val() == 'yearly' && $('[name=year]').val()) {
                    getAccountingReport()
                    print_title = $('[name=year]').val()
                    $('#periode').text('Periode '+print_title)
                    $('#print-component').show()
                }
                else if($('[name=type]').val() == 'monthly' && $('[name=year]').val() && $('[name=month]').val()) {
                    getAccountingReport()
                    print_title = $('[name=month] :selected').html() + ' ' + $('[name=year]').val()
                    $('#periode').text('Periode '+print_title)
                    $('#print-component').show()
                } else {
                    $('#print-component').hide()
                }
            }

            function getAccountingReport() {
                $.ajax({
                    url: "{{route('laba-rugi')}}",
                    data: {
                        type: $('[name=type]').val(),
                        year: $('[name=year]').val(),
                        month: $('[name=month]').val(),
                    },
                    success: (res) => {
                        showPrintable(res.data)
                    }
                })
            }

            function showPrintable(data) {
                const table = $('#printable-list')

                let printable_data = `<tr>
                    <th style="background-color: #ebf3fe; padding:5px; border: 1px solid #aaa;"></th>
                    <th style="background-color: #ebf3fe; padding:5px; border: 1px solid #aaa; text-align: start">${print_title}</th>
                </tr>`

                printable_data += `
                <tr>
                    <td style="padding:5px; border: 1px solid #aaa;">${data.income_price.category}</td>
                    <th style="padding:5px; border: 1px solid #aaa; text-align: start">Rp ${formatNum(data.income_price.price)}</th>
                </tr>
                <tr>
                    <td style="padding:5px; border: 1px solid #aaa;">${data.cost_price.category}</td>
                    <th style="padding:5px; border: 1px solid #aaa; text-align: start">Rp ${formatNum(data.cost_price.price)}</th>
                </tr>
                <tr>
                    <td style="background-color: #ebf3fe; padding:5px; border: 1px solid #aaa;">${data.gross_price.category}</td>
                    <th style="background-color: #ebf3fe; padding:5px; border: 1px solid #aaa; text-align: start">Rp ${formatNum(data.gross_price.price)}</th>
                </tr>
                `
                data.others_price.map(other => {
                    printable_data += `
                    <tr>
                        <td style=" padding:5px; border: 1px solid #aaa;">${other.category}</td>
                        <th style=" padding:5px; border: 1px solid #aaa; text-align: start">Rp ${formatNum(other.price)}</th>
                    </tr>
                    `
                })
                printable_data += `
                    <tr>
                        <td style="background-color: #ebf3fe; padding:5px; border: 1px solid #aaa;">${data.net_price.category}</td>
                        <th style="background-color: #ebf3fe; padding:5px; border: 1px solid #aaa; text-align: start">Rp ${formatNum(data.net_price.price)}</th>
                    </tr>
                `

                table.html(printable_data)
            }

            $('[name=type]').on('change', onChangeType)
            $('[name=year]').on('change', checkIsCanGetReport)
            $('[name=month]').on('change', checkIsCanGetReport)

            $(document).on('click', '#btn-print', function() {
                var printContents = $('#printable-element').html(); // Mengambil konten dari #print-section
                var originalContents = $('body').html(); // Menyimpan konten asli dari body

                // Buat jendela baru untuk print
                var printWindow = window.open('', '', 'height=600,width=800');

                printWindow.document.write('<html><head><title>Cetak Laporan Laba Rugi</title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');

                printWindow.document.close(); // Menutup stream penulisan
                printWindow.print(); // Memanggil fungsi print
            })
        })
    </script>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/selectize/selectize.bootstrap5.min.css')}}"/>

    <style>
        .icon-head {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 7rem;
            opacity: 20%;
        }
        .scorecard:hover {
            opacity: .7;
        }
    </style>
@endsection
