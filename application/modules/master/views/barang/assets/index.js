var tables;

var search_name,kategori,merk ,type, stock,status, lokasi;

$(document).ready(function() {

    $('.select2-single').select2({});


    //# initialize the datatable
    tables = $('#'+tableData).DataTable({
        'processing': true,
        'serverSide': true,
        'paging' : true,
        'autoWidth': false,
        'destroy': true,
        'responsive': false,
        // 'fixedHeader': {
        //     'header': true,
        //     'footer': true
        // },
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
        'order': [0, 'ASC'],
        "columnDefs":[
            {"orderData": 1, "targets": 2},
            {targets: 0,width:'5%',className: 'text-center'},
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

    $("#status").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });

    $("#lokasi").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });
});

var oFileIn,tableListPreview;

function modal_upload() {
    $('input[type=search]').val('').change();
    tableListPreview.clear().draw();
    oFileIn.value = "";
    $('#uploadModal').modal('show');
}

$(function() {
    oFileIn = document.getElementById('excel_upload');
    /* if (oFileIn.addEventListener) {
    console.log(oFileIn.addEventListenerx);
    oFileIn.addEventListener('change', filePicked, true);
    } */
    tableListPreview = $('#tableListPreview').DataTable({
        'retrieve'      : true,
        'destroy'       : true,
        'scrollY'       : '45vh',
        'fixedColumns'  : false,
        'ordering'      : false,
        'paging'        : false,
        'info'          : false,
        'columnDefs'    : [
            {targets: 0,className: 'text-center'},
            {targets: 1,className: 'text-left'},
            {targets: 2,className: 'text-right'}
        ]
    });
    $(".dataTables_filter").css("display","none");
});

function filePicked(oEvent) {
    $('input[type=search]').val('').change();
    tableListPreview.clear().draw();
    // Get The File From The Input
    var oFile = oEvent.target.files[0];
    console.log(oFile.type);
    if (typeof(oFile) != "undefined") {
        // if (oFile.name == "Input-Nilai-Avg-Upload.xls") {
        if (oFile.type == "application/vnd.ms-excel") {
            var sFilename = oFile.name;
            // Create A File Reader HTML5
            var reader = new FileReader();

            // Ready The Event For When A File Gets Selected
            reader.onload = function(e) {
                var data = e.target.result;
                var cfb = XLS.CFB.read(data, {
                    type: 'binary'
                });
                var wb = XLS.parse_xlscfb(cfb);
                // Loop Over Each Sheet
                var error = [];
                var check_merk = true;
                var result_data = [];
                tableListPreview.clear().draw();
                wb.SheetNames.forEach(function(sheetName) {
                    // Obtain The Current Row As CSV
                    var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);

                    var oJS = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
                    var row = 1;

                    if (oJS[0]) {
                        var header_excel = Object.keys(oJS[0]);
                        if (header_excel[0] != 'Kode Barang') {
                            dialog_warning('Notification', 'Pastikan Anda Tidak Merubah Baris Pertama dan data tidak kosong, Cek Kembali Header Kode Barang Pada Colom A1');
                        } else if (header_excel[1] != 'Hpp Akhir') {
                            dialog_warning('Notification', 'Pastikan Anda Tidak Merubah Baris Pertama dan data tidak kosong atau 0, Cek Kembali Header Hpp Akhir Pada Colom A2');
                        }  else {
                            oJS.forEach(function(data) {
                            if (data['Kode Barang'] == null) {
                                error.push(row + 1);
                            } else {
                                    if (!Number.isInteger(parseInt(data['HPP Akhir'])) && parseInt(data['HPP Akhir']) < 0) {
                                        error.push(row + 1);
                                    } else {
                                        row_data = [
                                            row - error.length,
                                            '<input type="hidden" class="form-control" name="upload_kd_brg[]" value="' + data['Kode Barang'] + '">' + data['Kode Barang'],
                                            '<input type="hidden" class="form-control" name="upload_hpp_akhir[]" value="' + data['Hpp Akhir'] + '">' + data['Hpp Akhir'],
                                        ];
                                        result_data.push(row_data);
                                    }
                            }
                            row++;
                            });
                        }
                    } else {
                        dialog_warning('Notification', 'Cek Kembali File Yang Anda Pilih !');
                    }
                });
                
                if (error.length) {
                    dialog_warning('Notification', 'Pastikan Anda Tidak Merubah Baris Pertama, Cek Kembali data Pada Baris ( ' + error.join() +
                    ' )');
                } else {
                    tableListPreview.rows.add(result_data).draw();
                }
            };
            // Tell JS To Start Reading The File.. You could delay this if desired
            reader.readAsBinaryString(oFile);
        } else {
            dialog_warning('Notification', 'Pastikan anda mengunakan File yang telah di download dan tidak merubah nama file !');
        }
    }else{
        dialog_warning('Notification', 'File Tidak Bisa Dibaca, Silahkan Refresh lagi !');
    }


}

