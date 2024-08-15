@extends('dashboard.layouts.dashboard') 
@push("title")
    Kategori
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Penyesuaian Stok</h4>
                        <p>Sesuaikan stok pada sistem dengan stok fisik.</p>
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
            <div class="card-body table-responsive">
                <div class="form-group mb-4">
                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <select name="category" class="flex-grow-1" id="category_id"></select>
                        <button type="button" class="btn btn-primary" id="btn-update-stock">
                                Sesuaikan Stok
                        </button>
                    </div>
                </div>
                @include('dashboard.adjustment.widgets.dt-update-stock')
            </div>
        </div>

    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/libs/selectize/selectize.bootstrap5.min.css')}}"/>
@endsection
@section('script')
    <script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script>
        $(document).ready(function() {
            getCategories()

            const selectize_category_id = $('#category_id').selectize({
                placeholder: 'Pilih Kategori',
            })
            const select_category_id = selectize_category_id[0].selectize

            function getCategories() {
                $.ajax({
                    url: `{{route('category.list-search')}}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const categories = data.data.map(function(item) {
                            return {
                                value: item.id,
                                text: item.name,
                            }
                        })
                        select_category_id.clearOptions()
                        select_category_id.addOption(categories)
                        select_category_id.setValue(categories[0].value)
                    }
                })
            }
        });
    </script>
@endsection
