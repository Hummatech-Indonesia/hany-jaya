@extends('dashboard.layouts.dashboard') 
@push("title")
    Satuan
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Satuan</h4>
                        <p>List Satuan yang ada di toko anda.</p>
                        @role('admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddUnit">
                                Tambah Satuan
                            </button>
                        @endrole
                        @include('dashboard.unit.widgets.modal-create')
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
        <div class="row mt-3">
            @if (session()->has('error'))
                <div class="col-12">
                    <x-alert-failed />
                </div>
            @endif
            @if ($errors->any())
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <strong>Terjadi Kesalahan</strong>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="col-12">
                    <x-alert-success />
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table align-middle table-striped table-hover" id="tb-unit-list"></table>
            </div>
        </div>
        @include('dashboard.unit.widgets.modal-update')

        <x-dialog.delete title="Hapus Satuan" />
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script>
        let tb_unit = $('#tb-unit-list').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            ajax: {
                url: "{{route('data-table.list-unit')}}"
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No",
                    searchable: false,
                    orderable: false
                }, {
                    data: "name",
                    title: "Satuan"
                }, 
                @role('admin')
                {
                    mRender: (data, type, full) => {
                        let string_data = JSON.stringify(full).replaceAll('"', "'")
                        let edit_url = "{{route('admin.units.edit', 'selected_id')}}"
                        edit_url = edit_url.replace("selected_id", full['id'])
                        let del_url = "{{route('admin.units.destroy', 'selected_id')}}"
                        del_url = del_url.replace("selected_id", full['id'])
                        return `
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-light btn-update btn-update-icon" data-unit="${string_data}"
                                        data-url="${edit_url}">
                                        <i class="fs-4 ti ti-edit"></i>
                                    </button>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-light btn-delete btn-delete-icon" data-url="${del_url}">
                                        <i class="fs-4 ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `
                    },
                    title: "Aksi",
                    searchable: false,
                    orderable: false,
                    width: "15%"
                }
                @endrole
            ]
        })

        // set autofocus 
        $('#modalAddUnit').on('shown.bs.modal', function() {
            $('#name-unit').focus();
        })
        $('#modalUpdateUnit').on('shown.bs.modal', function() {
            $('#edit-name-unit').focus();
        })

        function validate(listId, listMessage) {
            let countError = 0;
            listId.map(id => {
                let siblings = $(id).parent().children().length;
                if (($(id).val() == '' || $(id).val() == null) && siblings == 2) {
                    $(id).addClass('is-invalid')
                    $(id).parent().append(
                        '<small class="text-danger">' + listMessage[listId.indexOf(id)] + '</small>'
                    )
                    countError++;
                }
                if (($(id).val() == '' || $(id).val() == null) && siblings > 2) {
                    countError = 1;
                }
            })

            return countError > 0 ? true : false;
        }

        // validasi form 
        $(document).on('submit', '#form-create-unit', function(e) {
            e.preventDefault();
            let listId = ['#name-unit'];
            let listMessage = ['Nama Satuan tidak boleh kosong'];
            if (validate(listId, listMessage)) {
                return;
            }
            $(this).unbind('submit').submit();
        })
        $(document).on('submit', '#form-update-unit', function(e) {
            e.preventDefault();
            let listId = ['#edit-name-unit'];
            let listMessage = ['Nama Satuan tidak boleh kosong'];
            if (validate(listId, listMessage)) {
                return;
            }
            $(this).unbind('submit').submit();
        })

        // clear error message 
        $('#modalAddUnit').on('hidden.bs.modal', function() {
            $('#name-unit').removeClass('is-invalid')
            $('#name-unit').next().remove()
        })
        $('#modalUpdateUnit').on('hidden.bs.modal', function() {
            $('#edit-name-unit').removeClass('is-invalid')
            $('#edit-name-unit').next().remove()
        })


        $(document).on("click", ".btn-update", function() {
            $("#modalUpdateUnit").modal("show");
            let url = $(this).attr("data-url");
            let stringify_unit = $(this).data("unit");
            let unit = JSON.parse(stringify_unit.replaceAll("'", '"'))

            $("#modalUpdateUnit").find("#edit-name-unit").val(unit.name);
            $("#form-update-unit").attr("action", url);
        });
        $(document).on("click", ".btn-delete", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
        
    </script>
@endsection
