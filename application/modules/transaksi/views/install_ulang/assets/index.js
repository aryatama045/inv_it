var tables;
var search_name,tujuan;

$(document).ready(function() {

    $("#resetBtn").click(function() {
        $("#tujuan").val("").trigger('change'); // Select2
        $("#search_name").val("");
        tables.ajax.reload(); 
    });


    // initialize the datatable
    tables = $('#'+tableData).DataTable({
        'processing'    : true,
        'serverSide'    : true,
        'paging'        : true,
        'autoWidth'     : false,
        'destroy'       : true,
        'responsive'    : true,
        'ordering'      : false,
        'ajax'          : {
                            'url': linkstore,
                            'type': 'POST',
                            'data': function(data) {
                                data.search_name    = $('#search_name').val();
                                data.tujuan         = $('#tujuan').val();
                            },
                        },
        'order'         : [0, 'ASC'],
        "columnDefs"    : [
                            {targets: 0,width:'16%',className: 'text-center'},
                            {targets: 1,className: 'text-center'},
                            {targets: 2,className: 'text-center'},
                            {targets: 3,className: 'text-center'},
                            {targets: 4,className: 'text-center'},
                            {targets: 5,className: 'text-center'},
                            {targets: 6,className: 'text-center'},
                        ],
    });


    $("#"+tableData+"_filter").css("display", "none");
    // $("#tables_length").css("display", "none");

    $('#search_name').on('keyup', function(event) { // for text boxes
        tables.ajax.reload(); //just reload table
    });

    $("#tujuan").on("change", function () { //button filter event click
        tables.ajax.reload(); //just reload table
    });

    
});



function remove(id)
{
    $("#btn-delete").removeAttr('class');
    $("#btn-delete").text('Remove');
    $("#btn-delete").addClass('btn btn-danger');
    $("#removeModal h5").text('Remove Mata Kuliah');
    $("#messages_modal_remove").html('');
    $("#id span").html('Remove '+' <strong> '+id+'</strong>');
    if(id){
        $("#removeForm").on('submit', function() {
            var form = $(this);
            // remove the text-danger
            $(".text-danger").remove();

            if(id !== null){
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: { id:id },
                    dataType: 'json',
                    success:function(response) {

                        tables.ajax.reload(null, false);

                        if(response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                                '<strong>'+response.messages+ '</strong>' +
                                + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

                            // hide the modal
                            $("#removeModal").modal('hide');

                        } else {

                            $("#messages_modal_remove").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span>  '+response.messages+ '</strong>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>' +
                            + '</div>');
                        }
                    }
                });
            }
            id = null;
            return false;
        });
    }
}


function _prints(nomor_transaksi) {
    var html ='';
    html += '<input type="hidden" name="nomor_transaksi_print[]" id="nomor_transaksi_print" value="'+nomor_transaksi+'">';
    html += '<input type="hidden" name="pilih_print[]"           id="pilih_print" value="1">';
    html += '<input type="hidden" name="printer"                 id="printer_print" value=""></input>';
    var form = $("#formPrintsRedirect");
    form.html(html);
    form.attr('target', 'new');
    form.get(0).submit();
}