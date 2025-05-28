var tables;

var search_name,jenis,merk ,type, stock,status, lokasi, tgl_awal, tgl_akhir;
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
                data.jenis          = $("#jenis").val();
                data.type           = $("#type").val();
                data.stock          = $("#stock").val();
                data.status         = $("#status").val();
                data.lokasi         = $("#lokasi").val();
                data.tgl_awal       = $("#selectTanggalAwal").val();
                data.tgl_akhir      = $("#selectTanggalAkhir").val();

            },
        },
        'order'     : [0, 'ASC'],
        'columnDefs':[
            {"orderData": 5, "targets": 2},
            {targets: 0, className: 'text-center'},
            {targets: 1,className: 'text-center'},
            {targets: 2,className: 'text-center'},
            {targets: 3,className: 'text-center'},
            {targets: 4,className: 'text-center'},
            {targets: 5,className: 'text-center'},
            {targets: 6,className: 'text-center'},
            {targets: 7,className: 'text-left'},
            {targets: 8,className: 'text-center'},
            {targets: 9,className: 'text-center'},
        ]
    });


    $("#"+tableData+"_filter").css("display", "none");
    // $("#tables_length").css("display", "none");
    // $("#"+tableData+"_info").css("display", "none");

    // tables.columns.adjust().draw();

    $('#search_name').on('keyup', function(event) { // for text boxes
        tables.ajax.reload(); //just reload table
    });

    $("#jenis").on("change", function () { //button filter event click
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
    
    $("#selectTanggalAwal").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });

    $("#selectTanggalAkhir").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });
});

