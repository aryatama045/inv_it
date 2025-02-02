
<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>
<style>
	span.select2-selection.select2-selection--single {
		height: 100% !important;
	}

    input[type="datetime-local"] {
        position: relative;
    }

    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: auto;
        height: auto;
        color: transparent;
        background: transparent; */you need to disable the background becasue the icon can repeat based on input size */
    }
</style>
<div class="row">
	<div class="col">

		<!-- Title and Top Buttons Start -->
		<div class="page-title-container">
			<div class="row">

				<!-- Title Start -->
				<div class="col-12 col-md-7">

					<h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?></h1>

					<?php $this->load->view('templates/breadcrumb'); ?>

				</div>
				<!-- Title End -->

                <!-- Top Buttons Start -->
                <div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
                    <!-- Add New Button Start -->
                    <a href="<?= base_url($mod.'/'.$func) ?>" class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                        <i data-acorn-icon="arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <!-- Add New Button End -->
                </div>
                <!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->

        <?php $this->load->view('templates/notif') ?>

        <!-- Content Start -->
		<div class="card">
			<div class="card-body">
                <h3 class="pb-0">Form  <?= $function ?> </h3>
                <hr class="mb-2">

                <form id="form<?= $action ?>" class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">
                    <div class="col-12 col-md-4" >
                        <label class="form-label text-black"><strong>Nomor Dokumen</strong></label>
                        <input type="text" disabled class="form-control" placeholder="<?= $new_nomor_transaksi ?>"/>
                    </div>

                    <div class="col-12 col-md-4" >
                        <label class="form-label text-black"><strong>Tanggal Dokumen</strong></label>
                        <input class="form-control" readonly name="tanggal" value=<?= date('d-m-Y') ?> />
                    </div>

                    <div class="col-12 col-md-4" >
                        <label class="form-label text-black"><strong>User Input</strong></label>
                        <input type="text" disabled class="form-control" placeholder="<?= $this->session->userdata('name') ?>"/>
                    </div>


                    <div class="col-12 col-md-12 mb-5">
                        <label class="form-label text-black"><strong> Keterangan</strong></label>
                        <textarea name="keterangan_header" row="3" class="form-control" placeholder="Input Keterangan"></textarea>
                    </div>

                    <h3 class="pb-0"> Data Barang</h3> <hr class="g-0">

                    <table  id="tableListBKB" class="table table-bordered data-table data-table-pagination  responsive nowrap stripe w-100">
                        <thead>
                            <th class="text-center">No.</th>
                            <th class="text-center">Kode Barang</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center" width="10%">Qty</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center"> <a class="btn btn-icon btn-icon-only btn-primary btn-icon-end addRow" onclick='addRow()'><i data-acorn-icon="plus"></i> </a> </th>
                        </thead>
                    </table>
                    <hr>
                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-primary"><i data-acorn-icon="save"></i> Simpan</button>
                    </div>

                    <div class="col-12 mt-2">
                        <label class="form-check-label" ><strong> Note : </strong><span style="color:red">*</span> Wajib</label>
                    </div>
                </form>
            </div>
        </div>
        <!-- Content End -->
    </div>
</div>


<!-- modal datatable item list -->
<div class="modal fade" tabindex="-1" role="dialog" id="showItemData">
    <div class="modal-dialog modal-lg" role="document" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" >BROWSE BARANG</h3>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <table id="tableListItems" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width:150px;">Kode Barang</th>
                                <th>Nama Barang</th>
                                <th style="width:80px;">Is Stok</th>
                                <th style="width:50px;">Stok</th>
                                <th >Lokasi</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <td><input type="text" data-bs-column="0"  class="search-input-text-item form-control" style="width: 100%" placeholder="Kode "></td>
                                <td><input type="text" data-bs-column="1"  class="search-input-text-item form-control" style="width: 100%" placeholder="Nama Barang"></td>
                                <td>
                                    <select data-bs-column="2" class="search-input-select form-control" style="width: 100%">
                                        <option value="">--ALL--</option>
                                        <option value="True">Ada</option>
                                        <option value="False">Tidak</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal" > Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal datatable item list -->

<!-- modal alert item list -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalAlert">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticModalLabel">Information</h3>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div id="messages-alert"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-bs-dismiss="modal" id='btn-information'>Close</a>
            </div>
        </div>
    </div>
</div>
<!-- modal alert item list -->


<script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>
<!-- Dialog -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.css"  />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.min.js" ></script>

<script type="text/javascript">
var base_url  = '<?php echo base_url()?>';
var tableListItems,tableListBKB;
var action = 'Tambah';
var timer;
var jns_kode='';
<?php $status = $this->Model_global->getStatusBarang(); ?>

var getstatus = <?php echo json_encode($status) ?>;


$(document).ready(function() {

    $('.select2-single').select2();

    $("#kd_dokumen").change(function () {
        jns_kode = $(this).val();

        //clear datatable
        tableListBKB.clear().draw();

        //destroy datatable
        // tableListBKB.destroy();
    });

    /* inisialisasi Tabel Browse Barang */
    tableListItems = $('#tableListItems').DataTable({
        'orderCellsTop' : true,
        'fixedHeader'   : true,
        'processing'    : true,
        'serverSide'    : true,
        "autoWidth"     : false,
        "iDisplayLength": 10,
        'fixedColumns': true,
        'order'         : [0, 'ASC'],
        'ajax': {
            'url': base_url + 'transaksi/tanda_terima/getBarangAjax',
            'type':'POST',
            "dataSrc": function ( response ) {
                // if(!response.model.success){
                //   dialog_error("TERJADI KESALAHAN","Datatable & Database Error, Hubungi IT !");
                // }
                return response.data;
            },
            'data': function (d) {
                return $.extend({}, d, {
                'kd_store_tujuan' : $('#kd_store_tujuan').val(),
                'kategori'        : $('#kategori').val(),
                });
            }
            },
            'columnDefs'    : [
            {targets: 2,className: 'text-right'},
            {targets: 3,className: 'text-center'},
                ]
    });
    $(".dataTables_filter").css("display","none");
    /* End inisialisasi Tabel Browse Barang */

    /* Inisialisasi Table List BKB */
    tableListBKB = $('#tableListBKB').DataTable({
        'orderCellsTop' : true,
        'fixedHeader'   : true,
        'processing'    : true,
        'ordering'      : false,
        'bPaginate'     : false,
        'bLengthChange' : false,
        'bFilter'       : false,
        'bInfo'         : false,
        'bAutoWidth'    : false,
        'columnDefs'    : [
            {targets: 0,className: 'text-center'},
            {targets: 1,className: 'text-center'},
            {targets: 2,className: 'text-left'},
            {targets: 3,className: 'text-center'},
            {targets: 4,className: 'text-center', width:'15%'},
            {targets: 5,className: 'text-center'},
        ]
    });
    /* End Inisialisasi Table List BKB */


    /* Search Data On Browse Item */
        $('.search-input-text-item').on('keyup', function (event) {   // for text boxes
            var i =$(this).attr('data-bs-column');  // getting column index
            var v =$(this).val();  // getting search input value
            var keycode = event.which;
            if (keycode == 13) {
                tableListItems.columns(i).search(v).draw();
            }
        });
        $('.search-input-select').on('change', function () {   // for select box
            var i =$(this).attr('data-bs-column');
            var v =$(this).val();
            tableListItems.columns(i).search(v).draw();
        } );
    /* End Search Data On Browse Item */

    /* Event On tr Table Browse Item */
    $('#tableListItems tbody').on( 'click', 'tr', function () {
        // alert( tableListItems.row(this).data() );
        var rowData = tableListItems.row(this).data();
        var urut    = $('input[name="kd_brg[]"]').length + 1;
        var count_kd_double =0;
        var nama_status;


        /* Cek Kode barang sudah pernah diinput/belum */
        $('input[name="kd_brg[]"]').each(function(){
            if($(this).val()==rowData[0]){
                count_kd_double++;
            }
        });

        /* Cek Stock Sebelum ditambahakan */
        if(rowData[3]==0){
            // dialog_warning('Notification',"Stock Barang Kosong");
            alert("Stock Barang Kosong ");
            return false;
        }

        /* Cek Kode barang sudah pernah diinput/belum */
        if(count_kd_double == 0 ){
            /* Add Click/Select Item Browse to Tambe Item BKB */

            // Cek Barang Stok
            if(rowData[2] == 'True'){
                var index   = $('#tableListBKB').DataTable().row.add( [
                    "<input type='hidden' name='urut[]' id='urut_"+urut+"' value='"+urut+"' />"+urut,
                    rowData[0],
                    rowData[1],
                    "<input type='hidden' name='kd_brg[]' id='"+rowData[0]+"' class='form-control' style='width:100%' value='"+rowData[0]+"' />" +
                    "<input type='text' name='qty[]' id='qty' class='form-control' style='width:100%;text-align:center;' data-barang='"+rowData[0]+"' data-value='"+rowData[3]+"' data-max-qty='"+rowData[3]+"' maxlength='5'/>",
                    "<input type='text' name='status[]'  class='form-control' value='"+rowData[5]+"' style='width:100%;text-align:center;' readonly  />",
                    "<input type='text' name='ket[]' required class='form-control' style='width:100%' placeholder='Input Keterangan' />",
                    '<button type="button" class="btn btn-danger" onclick="deleteRow(\''+urut+'\',\''+rowData[0]+'\')"><i class="fa fa-trash"></i></button>',
                ] ).draw( false );
            }else{
                var index   = $('#tableListBKB').DataTable().row.add( [
                    "<input type='hidden' name='urut[]' id='urut_"+urut+"' value='"+urut+"' />"+urut,
                    rowData[0],
                    rowData[1],
                    "<input type='hidden' name='kd_brg[]' id='"+rowData[0]+"' class='form-control' style='width:100%' value='"+rowData[0]+"' />" +
                    "<input type='hidden' name='qty[]' id='qty' class='form-control' style='width:100%' value='"+rowData[3]+"' data-barang='"+rowData[0]+"' data-max-qty='"+rowData[3]+"' maxlength='5'/>" + rowData[3],
                    "<input type='text' name='status[]'  class='form-control' value='"+rowData[5]+"' style='width:100%;text-align:center;' readonly  />",
                    "<input type='text' name='ket[]' required class='form-control' style='width:100%' placeholder='Input Keterangan' />",
                    '<button type="button" class="btn btn-danger" onclick="deleteRow(\''+urut+'\',\''+rowData[0]+'\')"><i class="fa fa-trash"></i></button>',
                ] ).draw( false );
            }


            /* restrict text input number only */
            var input_qty;
            $('input[name="qty[]"]').keypress(function (event) {
                var keycode = event.which;
                console.log(keycode);
                if (!(event.shiftKey == false && ( keycode == 8 || keycode == 37 || (keycode >= 48 && keycode <= 57)))) {
                    event.preventDefault();
                }
                if(keycode == 13){
                    addRow()
                    event.preventDefault();
                }
                input_qty = this.value;
            });

            /* Count barang yang diinput */
            $('input[name="qty[]"]').keyup(function (event) {
                var kd_brg  = $(this).attr('data-barang');
                var max_qty  = $(this).attr('data-max-qty').replace(",", "");
                var qty     = this.value;
                if(qty=='') qty=0;
                if(parseInt(qty) > parseInt(max_qty)){
                    // dialog_warning('Notification',"Qty tidak boleh lebih besar dari Stock");
                    alert("Qty tidak boleh lebih besar dari Stock : '"+max_qty+"' ");
                    this.value = input_qty;
                }
            });


            /* add id in row */
            var row = $('#tableListBKB').dataTable().fnGetNodes(index);
            $(row).attr( 'id', "rowID_"+urut );
            $('#showItemData').modal('hide');
            $('input[data-barang="'+rowData[0]+'"]').focus();
        }else{
            alert("Barang Sudah Ditambahkan");
            return false;
            // response failed
        }
        $("input[type=text]").attr("autocomplete", "off");
    });
    /* End Event On tr Table Browse Item */

    /* Action Form Submit */
    $("#form<?=$action?>").unbind('submit').on('submit', function() {
        var form = $(this);
        if(validation()==true){
        $('#btn-save').prop('disabled', true);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
            if(response.success === true) {
                // response success
                no_doc_trans = response.no_doc_trans;
                $("#formPrintRedirect").submit();
                dialog_success('Success',response.messages,true,'transaksi/tanda_terima');
                // clearTempQty(null,'34');
            } else {
                // response failed
                dialog_warning('Notification',response.messages);
                $('#btn-save').prop('disabled', false);
            }
            }
        });
        }
        return false;
    });
});


/* Action Button Add (+) Clicked*/
function addRow(){
    var validasi = validasi_add_item();
    // if(validasi){
        tableListItems.clear().draw();
        tableListItems.ajax.reload(null,false);
        $('#showItemData').modal('show');
        // $('#myModal').modal('show');
    // }
}
/* End Action Button Add (+) Clicked*/

/* Validation Before addRow() */
function validasi_add_item(){
    // if($('input[id="harga_jual"]').length > 0){
        var qty = $("#form<?=$action?> input[id='qty']");
        for (i = 0; i < qty.length; i++) {
            if( $(qty[i]).val() == '' || $(qty[i]).val() == 0){
                dialog_warning('Notification',"Ada Qty Yang Kosong");
                return false;
            }
        }
    // }


    if($('#kd_dokumen').val() == ""){
        // alert('Pilih Jenis Dokumen Terlebih Dahulu');
        dialog_warning('Notification',"Pilih Tujuan Terlebih Dahulu");
        return false;
    }
    if($('#pengirim').val() == ""){
        alert('Pilih Tujuan Terlebih Dahulu');
        // dialog_warning('Notification',"Pilih Tujuan Terlebih Dahulu");
        return false;
    }
    if($('#tujuan').val() == ""){
        alert('Pilih Tujuan Terlebih Dahulu');
        // dialog_warning('Notification',"Pilih Tujuan Terlebih Dahulu");
        return false;
    }

    return true;
}
/* End Validation Before addRow() */

/* Action Saat tombol delete di click */
function deleteRow(no_urut,kd_brg){
    var data = tableListBKB.rows().data();
    var new_no_urut =1 ;
    for (let index = 0; index < data.length; index++) {
        if(no_urut-1 != index){

            var append_1 = "<input type='hidden' name='urut[]' id='urut_"+new_no_urut+"' value='"+new_no_urut+"' />"+new_no_urut;
            var append_2 = '<button type="button" class="btn btn-danger" onclick="deleteRow(\''+new_no_urut+'\',\''+$('input[name="kd_brg[]"]')[index].value+'\')"><i class="fa fa-trash"></i></button>';

            tableListBKB.cell({row:index, column:0}).data(append_1);
            tableListBKB.cell({row:index, column:6}).data(append_2);
            new_no_urut++;
        }
    }

    tableListBKB.row(no_urut-1).remove().draw();
    $("input[type=text]").attr("autocomplete", "off");
    // count_qty();
}
/* End Action Saat tombol delete di click */

</script>
