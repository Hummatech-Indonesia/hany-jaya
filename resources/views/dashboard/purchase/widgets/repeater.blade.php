<script>
    $(function() {
        "use strict";

        // Default
        $(".repeater-default").repeater();

        // Custom Show / Hide Configurations
        $(".file-repeater, .email-repeater").repeater({
            show: function() {
                $(this).slideDown();
            },
            hide: function(remove) {
                if (confirm("Are you sure you want to remove this item?")) {
                    $(this).slideUp(remove);
                }
            },
        });
    });

    var room = 1;

    $(document).ready(function() {
        $("#add_click").click(function() {
            $.ajax({
                url: `/admin/units-ajax/`,
                type: "GET",
                success: function(response) {
                    education_fields(response.data);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
            });
        });
    });

    function education_fields(units) {
        room++;
        $(document).ready(function() {
            $('#product-' + room).change(function() {
                var product = $(this).val();
                $.ajax({
                    url: `{{ route('admin.product.unit.index', ['product' => '']) }}/${product}`,
                    type: 'GET',
                    success: function(response) {
                        $('#unit-' + room)
                            .empty();
                        $('#unit-' + room).append(
                            '<option value="">Pilih Satuan</option>'
                        );
                        response.data.forEach(function(item) {
                            console.log(item.product_id);
                            $('#unit-' + room).append(
                                `<option value="${item.unit_id}">${item.unit}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
        var objTo = document.getElementById("education_fields");
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "mb-3 removeclass" + room);
        var rdiv = "removeclass" + room;
        var selectHTML = `
    <div class="row">
        <div class="col-sm-2">
            <div class="mb-3">
                <label class="mb-2" for="product_id" style="font-size: 0.8rem">Pilih
                    Produk</label>
                <select name="product_id[]" class="select_product form-control" id="product-${room}">
                    <option value="Pilih Produk">Pilih Produk</option>
                    <option value="" class="product_id"></option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-3">
                <label class="mb-2" for="unit_id" style="font-size: 0.8rem">Pilih Satuan</label>
                <select name="unit_id[]" class="form-control" id="unit-${room}">
                    <option value="Pilih Satuan">Pilih Satuan</option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-3">
                <label class="d-flex gap-2 align-items-center mb-2" style="font-size: 0.8rem">Harga
                    Beli per
                    Satuan</label>
                <input type="number" class="form-control" id="Age"
                    name="quantity_in_small_unit[]" placeholder="10" />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-3">
                <label class="d-flex gap-2 align-items-center mb-2" style="font-size: 0.8rem">Jumlah
                    Pembelian</label>
                <input type="number" class="form-control" id="Age"
                    name="quantity_in_small_unit[]" placeholder="10" />
            </div>
        </div>
        <div class="col-sm-2">
            <label class="mb-2" for="" style="font-size: 0.8rem">Total Harga
                Pembelian</label>
            <div class="mb-3">
                <input type="number" disabled class="form-control">
            </div>
        </div>
        <div class="col-sm-2" style="margin-top: 1.35rem">
            <button class="btn btn-danger" type="button"  onclick="remove_education_fields(${room});">
                <i class="ti ti-minus"></i>
            </button>
        </div>
    </div>`;
        divtest.innerHTML = selectHTML;
        objTo.appendChild(divtest);
    }

    function remove_education_fields(rdid) {
        $(".removeclass" + rdid).remove();
    }
</script>
