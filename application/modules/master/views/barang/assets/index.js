var tables;

var search_name,kategori,merk ,type, stock;
$(document).ready(function() {

    $('.select2-single').select2({});


    //# initialize the datatable
    tables = $('#'+tableData).DataTable({
        'processing': true,
        'serverSide': true,
        // 'serverMethod': 'post',
        // 'scrollX': true,
        'paging' : true,
        'autoWidth': false,
        'destroy': true,
        'responsive': false,
        'ajax': {
            'url': linkstore,
            'type': 'POST',
            'data': function(data) {
                data.search_name    = $('#search_name').val();
                data.kategori       = $("#kategori").val();
                data.merk           = $("#merk").val();
                data.type           = $("#type").val();
                data.stock          = $("#stock").val();
            },
        },
        'order': [0, 'ASC'],
        "columnDefs":[
            {"orderData": 1, "targets": 2},
            {targets: 0,width:'10%',className: 'text-center'},
        ]
    });

    $("#"+tableData+"_filter").css("display", "none");
    // $("#tables_length").css("display", "none");

    tables.columns.adjust().draw();

    $('#search_name').on('keyup', function(event) { // for text boxes
        tables.ajax.reload(); //just reload table
    });

    $("#kategori").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });

    $("#merk").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });

    $("#type").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });

    $("#stock").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });
});

