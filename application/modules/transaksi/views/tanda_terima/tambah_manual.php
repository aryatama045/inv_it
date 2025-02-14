
<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>

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

                <form id="form<?= $action ?>" class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah_manual'); ?>" method="POST">
                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Nomor Dokumen</strong></label>
                            <input type="text" disabled class="form-control" placeholder="<?= $new_nomor_transaksi_manual ?>"/>
                        </div>

                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Jenis Dokumen<span style="color:red">*</span></strong></label>
                            <select class="form-control select2-single" name="kd_dokumen" id="kd_dokumen" required>
                                <option value=""> -- Select Jenis --</option>
                                <option value="IN" >IN - Terima</option>
                                <option value="OUT" >OUT - Kirim</option>
                            </select>
                            <!-- <div class="form-group">
                                <input type="radio" class="btn-check kd_dokumen" id="inTerima" value="IN" name="kd_dokumen" checked>
                                <label class="btn btn-outline-primary" for="inTerima">IN - TERIMA</label>
                                <input type="radio" class="btn-check kd_dokumen" id="outKirim" value="OUT" name="kd_dokumen">
                                <label class="btn btn-outline-primary" for="outKirim">OUT - KIRIM</label>
                            </div> -->
                        </div>
                    </div>

                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Tanggal Dokumen</strong></label>
                            <input class="form-control" readonly name="tanggal" value=<?= date('d-m-Y') ?> />
                        </div>

                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Tanggal Proses <span style="color:red">*</span></strong></label>
                            <input class="form-control" name="tanggal_pengiriman" value=<?= date('d-m-Y') ?> required id="selectTanggalAwal" />
                        </div>
                    </div>


                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Pengirim<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="pengirim" id="pengirim" required>
                                <option value=""> -- Select Pengirim --</option>
                                <?php $Personil1 = $this->Model_global->getPersonil();
                                foreach ($Personil1 as $key => $val) { ?>
                                    <?php if($val['nip'] == 0){ ?>
                                        <option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Penerima<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="penerima" id="penerima" required>
                                <option value=""> -- Select Tujuan --</option>
                                <?php $Personil2 = $this->Model_global->getPersonil();
                                foreach ($Personil2 as $key => $val) { ?>
                                    <?php if($val['nip'] == 0){ ?>
                                        <option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Tujuan<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="tujuan" id="tujuan" required>
                                <option value=""> -- Select Tujuan --</option>
                                <?php $Personil2 = $this->Model_global->getPersonil();
                                foreach ($Personil2 as $key => $val) { ?>
                                    <?php if($val['nip'] == 0){ ?>
                                        <option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-12 mb-5">
                            <label class="form-label text-black"><strong> Keterangan</strong></label>
                            <textarea name="keterangan_header" row="3" class="form-control" placeholder="Input Keterangan"></textarea>
                        </div>
                    </div>

                    <h3 class="pb-0"> Data </h3> <hr class="g-0">

                    <table  id="tableListBKB" class="table table-bordered data-table data-table-pagination  responsive nowrap stripe w-100">
                        <thead>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center"> <a class="btn btn-icon btn-icon-only btn-primary btn-icon-end add" ><i data-acorn-icon="plus"></i> </a> </th>
                        </thead>
                        <body>
                            <tr>
                                <td><input type='number' name='qty[]' required class='form-control'  placeholder='Input Qty' /></td>
                                <td><input type='text' name='keterangan[]' required class='form-control' style='width:100%' placeholder='Input Keterangan' /></td>
                                <td></td>
                            </tr>
                        </body>
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


<script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>
<script type="text/javascript">
var base_url  = '<?php echo base_url()?>';
var tableListItems,tableListBKB;
var action = 'Tambah';
var timer;
var jns_kode='';

// var getstatus = <?php echo json_encode($status) ?>;


$(document).ready(function() {

    $('.select2-single').select2();

    $(".kd_dokumen").change(function () {
        jns_kode = $(this).val();

        //clear datatable
        tableListBKB.clear().draw();

        //destroy datatable
        // tableListBKB.destroy();
    });

    /* inisialisasi Tabel Browse Barang */
    tableListItems = $('#tableListItems').DataTable({
        // 'orderCellsTop' : true,
        // 'fixedHeader'   : true,
        'processing'    : true,
        'serverSide'    : true,
        "autoWidth"     : false,
        "iDisplayLength": 10,
        'fixedColumns': true,
        'order'         : [0, 'ASC'],
        'ajax': {
            'url': base_url + 'master/barang/getBarangAjax',
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
        // 'orderCellsTop' : true,
        // 'fixedHeader'   : true,
        'processing'    : true,
        'ordering'      : false,
        'bPaginate'     : false,
        'bLengthChange' : false,
        'bFilter'       : false,
        'bInfo'         : false,
        'bAutoWidth'    : false,
        'columnDefs'    : [
            {targets: 0,className: 'text-center', width:'15%'},
            {targets: 1,className: 'text-center'},
            {targets: 2,className: 'text-center', width:'15%'},
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
        dialog_warning('Notification',"Pilih Jenis Dokumen Terlebih Dahulu");
        return false;
    }
    if($('#pengirim').val() == ""){
        // alert('Pilih Pengirim Terlebih Dahulu');
        dialog_warning('Notification',"Pilih Pengirim Terlebih Dahulu");
        return false;
    }
    if($('#penerima').val() == ""){
        // alert('Pilih Tujuan Terlebih Dahulu');
        dialog_warning('Notification',"Pilih Penerima Terlebih Dahulu");
        return false;
    }
    if($('#tujuan').val() == ""){
        // alert('Pilih Tujuan Terlebih Dahulu');
        dialog_warning('Notification',"Pilih Tujuan Terlebih Dahulu");
        return false;
    }

    return true;
}
/* End Validation Before addRow() */



var count = 1;

function add_input_field(count) {
    var html = "";

    if (count > 1) {
        html += "<tr>";

        html +=
        '<td><input type="number" name="qty[]" class="form-control " placeholder="Input Qty"  required/></td>';

        html +=
        '<td><input type="text" name="keterangan[]" class="form-control " placeholder="Input Keterangan"  required/></td>';
    }
    var remove_button = "";

    if (count > 1) {
        remove_button =
        '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i> Remove</button>';
    }

    html += "<td>" + remove_button + "</td></tr>";

    return html;
}

$("#tableListBKB").append(add_input_field(1));


$(document).on("click", ".add", function () {
    count++;
    $("#tableListBKB").prepend(add_input_field(count));

});

$(document).on("click", ".remove", function () {
    $(this).closest("tr").remove();
});

</script>
