var tables;

var search_name,kategori,merk ,type, stock,status, lokasi;
$(document).ready(function() {

    $('.select2-single').select2({});


    //# initialize the datatable
    tables = $('#'+tableData).DataTable({
        'processing': true,
        'serverSide': true,
        'paging'    : true,
        // 'responsive': false,
        // 'autoWidth' : true,
        // 'fixedHeader': true,
        // 'fixedColumns': true,
        // 'fixedColumns': {
        //     'start': 1
        // },
        'scrollX'   : true,
        'ordering'  : false,
        'ajax': {
            'url': linkstore,
            'type': 'POST',
            'data': function(data) {
                data.search_name    = $('#search_name').val();
                data.kategori       = $("#kategori").val();
                data.merk           = $("#merk").val();
                data.type           = $("#type").val();
                data.stock          = $("#stock").val();
                data.status         = $("#status").val();
                data.lokasi         = $("#lokasi").val();
            },
        },
        'order'     : [5, 'ASC'],
        'columnDefs':[
            {"orderData": 5, "targets": 2},
            {targets: 0, className: 'text-center'},
            {targets: 1,className: 'text-left'},
            {targets: 2,className: 'text-center'},
            {targets: 3,className: 'text-center'},
            {targets: 4,className: 'text-center'},
            {targets: 5,className: 'text-center'},
            {targets: 6,className: 'text-right'},
            {targets: 7,className: 'text-left'},
            {targets: 8,className: 'text-center'},
            {targets: 9,className: 'text-center'},
            {targets: 10,className: 'text-center'},
            {targets: 11,className: 'text-center'},
            {targets: 12,className: 'text-center'},
            {targets: 13,className: 'text-center'},
            {targets: 14,className: 'text-center'},
            {targets: 15,className: 'text-center'},
            {targets: 16,className: 'text-center'},
        ]
    });


    $("#"+tableData+"_filter").css("display", "none");
    // $("#tables_length").css("display", "none");
    // $("#"+tableData+"_info").css("display", "none");

    // tables.columns.adjust().draw();

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

    $("#status").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });

    $("#lokasi").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });
});

