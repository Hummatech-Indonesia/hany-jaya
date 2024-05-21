$(function () {
    "use strict";

    // Default
    $(".repeater-default").repeater();

    // Custom Show / Hide Configurations
    $(".file-repeater, .email-repeater").repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (remove) {
            if (confirm("Are you sure you want to remove this item?")) {
                $(this).slideUp(remove);
            }
        },
    });
});

var room = 1;

$(document).ready(function () {
    $("#add_click").click(function () {
        $.ajax({
            url: `/admin/units-ajax/`,
            type: "GET",
            success: function (response) {
                education_fields(response.data);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    });
});
function education_fields(units) {
    room++;
    var objTo = document.getElementById("education_fields");
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "mb-3 removeclass" + room);
    var rdiv = "removeclass" + room;
    var selectHTML = `
    <div class="row">
        <div class="col-sm-4">
            <div class="mb-3">
                <label for="unit_id">Pilih Satuan</label>
                <select name="unit_id" class="form-control" id="unit_id_${room}">
                    <option value="Pilih Satuan">Pilih Satuan</option>`;

    if (units) {
        units.forEach(function (unit) {
            selectHTML += `<option value="${unit.id}">${unit.name}</option>`;
        });
    }

    selectHTML += `
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-3">
                <label for="">Total dalam pcs</label>
                <input type="number" class="form-control" id="Age" name="Age" placeholder="10" />
            </div>
        </div>
        <div class="col-sm-4">
            <label for="">Harga Jual</label>
            <div class="mb-3">
                <input type="number" name="selling_price[]" id="" class="form-control" placeholder="10.000">
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
