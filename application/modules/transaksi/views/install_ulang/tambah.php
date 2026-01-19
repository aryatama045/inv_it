
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
                <h3 class="border-bottom mb-2 pb-0">Form  <?= $function ?> </h3>

                <form id="formTambah" class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">
                    
                    <div class="row p-2 m-2">

                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Nomor Dokumen</strong></label>
                            <input type="text" disabled value="<?= $new_nomor_transaksi ?>" class="form-control" name="nomor_dokumen" />
                        </div>  

                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Tanggal Dokumen</strong></label>
                            <input class="form-control" readonly name="tanggal" value=<?= date('d-m-Y') ?> />
                        </div>

                    </div>

                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Tanggal Mulai <span style="color:red">*</span></strong></label>
                            <input class="form-control" name="tanggal_mulai" value=<?= date('d-m-Y') ?> required id="selectTanggalAwal" />
                        </div>

                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>OS Install<span style="color:red">*</span></strong></label>
                            <select class="form-control select2-single" name="pc_os" id="pc_os" required >
                                <option value="" >-- OS Install --</option>
                                <?php $DataOsInstall = $this->Model_global->getDataInstallUlang(NULL,'1');
                                foreach ($DataOsInstall as $key => $val) { ?>
                                    <option value="<?= $val['kode_program'] ?>" ><?= $val['nama_program'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>PC-IP</strong></label>
                            <input type="text" class="form-control" name="pc_ip" />
                        </div>
                    </div>

                    <div class="row p-2 m-2">
                        <div class="col-4 col-md-4" >
                            <label class="form-label text-black"><strong>Pic Install<span style="color:red">*</span></strong></label>
                            <select class="form-control select2-single" name="pic_install" id="pic_install" required>
                                <option value="" >-- Pic Install --</option>
                                <?php $PicInstall = $this->Model_global->getPersonil();
                                foreach ($PicInstall as $key => $val) { ?>
                                    <?php if($val['nip'] == 0){ ?>
                                        <option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-4 col-md-4" >
                            <label class="form-label text-black"><strong>Pic Check<span style="color:red">*</span></strong></label>
                            <select class="form-control select2-single" name="pic_check" id="pic_check" required>
                                <option value="" >-- Pic Check --</option>
                                <?php $PicCheck = $this->Model_global->getPersonil();
                                foreach ($PicCheck as $key => $val) { ?>
                                    <?php if($val['nip'] == 0){ ?>
                                        <option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-4 col-md-4" >
                            <label class="form-label text-black"><strong>Tujuan<span style="color:red">*</span></strong></label>
                            <select class="form-control select2-single" name="pc_tujuan" id="pc_tujuan" required>
                                <option value="" >-- Tujuan --</option>
                                <option value="">All</option>
                                <?php $DataTujuan = $this->Model_global->getPersonil();
                                foreach ($DataTujuan as $key => $val) { ?>
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

                    <h3 class="border-bottom pb-2 mb-2">Data Program</h3>
                    <table id="tableListBKB" class="table table-striped">
                        <thead>
                            <th class="text-uppercase text-left" width="8%">No.</th>
                            <th class="text-uppercase text-left" width="25%">Nama Program</th>
                            <th class="text-uppercase text-left" width="35%">Barang</th>
                            <th class="text-uppercase text-left" >Keterangan</th>
                            <th class="text-center" width="7%"></th>
                        </thead>
                        
                    </table>

                    <div class="mb-3 pb-3 border-bottom text-center">
                        <a onclick='addRow()'  class="btn btn-sm btn-icon btn-icon-start btn-primary addRow">    
                            <i data-acorn-icon="plus"></i>
                            <span>Add Program</span>
                        </a>
                    </div>
                    
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


<!-- modal browse barang -->
<div class="modal fade" tabindex="-1" role="dialog" id="showBarangData">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">PILIH BARANG</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="search_kode_barang" class="form-control form-control-sm" placeholder="Search Kode Barang">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="search_nama_barang" class="form-control form-control-sm" placeholder="Search Nama Barang">
                            </div>
                        </div>
                    </div>
                    <table id="tableListBarang" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-uppercase" width="30%">Kode Barang</th>
                                <th class="text-uppercase" width="50%">Nama Barang</th>
                                <th class="text-center" width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal browse barang -->


<!-- modal datatable program list -->
<div class="modal fade" tabindex="-1" role="dialog" id="showItemData">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">PILIH PROGRAM</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="search_kode_program" class="form-control form-control-sm" placeholder="Search Kode Program">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="search_nama_program" class="form-control form-control-sm" placeholder="Search Nama Program">
                            </div>
                        </div>
                    </div>
                    <table id="tableListItems" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-uppercase" width="25%">Kode Program</th>
                                <th class="text-uppercase" width="60%">Nama Program</th>
                                <th class="text-center" width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal datatable program list -->


<script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>


<script type="text/javascript">
var base_url  = '<?php echo base_url()?>';
var tableListItems,tableListBKB,tableListBarang;
var action = 'Tambah';
var timer;
var jns_kode='';
var search_kode = '';
var search_nama = '';
var search_kode_program = '';
var search_nama_program = '';


$(document).ready(function() {

    $('.select2-single').select2();

    /* Inisialisasi Table List BKB */
    tableListBKB = $('#tableListBKB').DataTable({
        'ordering'      : false,
        'bPaginate'     : false,
        'bLengthChange' : false,
        'bFilter'       : false,
        'bInfo'         : false,
        'bAutoWidth'    : false,
        'columnDefs'    : [
            {targets: 0,className: 'text-left'},
            {targets: 1,className: 'text-left'},
            {targets: 2,className: 'text-left'},
            {targets: 3,className: 'text-left'},
            {targets: 4,className: 'text-left'},
        ]
    });
    $("#tableListBKB_filter").css("display", "none");
    /* End Inisialisasi Table List BKB */


    /* inisialisasi Tabel Browse Barang - SERVERSIDE */
    tableListBarang = $('#tableListBarang').DataTable({
        'processing'    : true,
        'serverSide'    : true,
        "autoWidth"     : false,
        "iDisplayLength": 10,
        'ordering'      : false,
        'ajax': {
                'url': base_url + 'transaksi/install_ulang/getBarangData',
                'type':'POST',
                "dataSrc": function ( response ) {
                    console.log('Barang Response:', response);
                    return response.data;
                },
                'data': function (d) {
                    return $.extend({}, d, {
                        'search_kode_barang' : search_kode,
                        'search_nama_barang' : search_nama,
                    });
                },
                'error': function(xhr, error, thrown) {
                    console.error('Barang AJAX Error:', error, xhr, thrown);
                }
            },
        'columnDefs'    : [
            {targets: 0,className: 'text-left'},
            {targets: 1,className: 'text-left'},
            {targets: 2,className: 'text-center'},
        ]
    });
    $("#tableListBarang_filter").css("display", "none");
    /* End Inisialisasi Tabel Browse Barang */

    /* inisialisasi Tabel Browse Program - SERVERSIDE */
    tableListItems = $('#tableListItems').DataTable({
        'processing'    : true,
        'serverSide'    : true,
        "autoWidth"     : false,
        "iDisplayLength": 10,
        'ordering'      : false,
        'ajax': {
                'url': base_url + 'transaksi/install_ulang/getProgramData',
                'type':'POST',
                "dataSrc": function ( response ) {
                    console.log('Program Response:', response);
                    return response.data;
                },
                'data': function (d) {
                    return $.extend({}, d, {
                        'search_kode_program' : search_kode_program,
                        'search_nama_program' : search_nama_program,
                    });
                },
                'error': function(xhr, error, thrown) {
                    console.error('Program AJAX Error:', error, xhr, thrown);
                }
            },
        'columnDefs'    : [
            {targets: 0,className: 'text-left'},
            {targets: 1,className: 'text-left'},
            {targets: 2,className: 'text-center'},
        ]
    });
    $("#tableListItems_filter").css("display", "none");
    /* End inisialisasi Tabel Browse Program */

    /* Search Data On Browse Program */
    $('#search_kode_program').on('keyup', function(){
        search_kode_program = $(this).val();
        tableListItems.draw();
    });

    $('#search_nama_program').on('keyup', function(){
        search_nama_program = $(this).val();
        tableListItems.draw();
    });
    /* End Search Data On Browse Program */

    /* Search Data On Browse Barang */
    $('#search_kode_barang').on('keyup', function(){
        search_kode = $(this).val();
        tableListBarang.draw();
    });

    $('#search_nama_barang').on('keyup', function(){
        search_nama = $(this).val();
        tableListBarang.draw();
    });
    /* End Search Data On Browse Barang */

    /* Event On tr Table Browse Program */
    $(document).on('click', '#tableListItems tbody .btn-pilih-program', function(){
        var kode_program = $(this).data('kode');
        var nama_program = $(this).data('nama');
        selectProgram(kode_program, nama_program);
    });
    /* End Event On tr Table Browse Program */

    /* Event On tr Table Browse Barang */
    $(document).on('click', '#tableListBarang tbody .btn-pilih-barang', function(){
        var kode_barang = $(this).data('kode');
        var nama_barang = $(this).data('nama');
        selectBarang(kode_barang, nama_barang);
    });
    /* End Event On tr Table Browse Barang */

    /* Action Form Submit */
    $("#formTambah").unbind('submit').on('submit', function() {
        var validasi = validasi_submit();
        if(validasi){
            dialog_submit('Notification',"Simpan !!");

            $('#btn-submit').click(function() {
                document.getElementById('formTambah').submit();
            });

            return false;
        }
    });

});


/* Action Button Add (+) Clicked*/
function addRow(){
    try {
        // Clear search state
        search_kode_program = '';
        search_nama_program = '';
        $('#search_kode_program').val('');
        $('#search_nama_program').val('');
        
        // Reload table data
        if(tableListItems) {
            tableListItems.draw();
        }
    } catch(e) {
        console.error('Error in addRow:', e);
    }
    
    $('#showItemData').modal('show');
}
/* End Action Button Add (+) Clicked*/


/* Show Modal Barang untuk dipilih */
var currentUrut = null;
function showModalBarang(urut){
    currentUrut = urut;
    search_kode = '';
    search_nama = '';
    $('#search_kode_barang').val('');
    $('#search_nama_barang').val('');
    
    try {
        if(tableListBarang) {
            tableListBarang.draw();
        }
    } catch(e) {
        console.error('Error drawing tableListBarang:', e);
    }
    
    $('#showBarangData').modal('show');
}
/* End Show Modal Barang */


/* Select Program dan tambah ke table */
function selectProgram(kode_program, nama_program){
    var urut = $('input[name="urut[]"]').length + 1;
    
    /* Add Click/Select Program to Table BKB */
    var index = $('#tableListBKB').DataTable().row.add( [
        "<input type='hidden' name='urut[]' id='urut_"+urut+"' value='"+urut+"' />"+urut,
        "<input type='hidden' name='kode_program[]' id='"+kode_program+"' value='"+kode_program+"' />" +
        nama_program,
        '<a href="javascript:void(0)" class="text-primary selectBarangLink" data-urut="'+urut+'" data-kode-program="'+kode_program+'" onclick="showModalBarang(\''+urut+'\')"><i class="fa fa-plus"></i> Pilih Barang</a><input type="hidden" name="kode_barang[]" id="kode_barang_'+urut+'" value="" /><div id="barang_display_'+urut+'"></div>',
        '<input type="text" name="keterangan_detail[]" class="form-control " placeholder="Input Keterangan" />',
        '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(\''+urut+'\',\''+kode_program+'\')"><i class="fa fa-trash"></i></button>',
    ] ).draw( false );
    
    /* add id in row */
    var row = $('#tableListBKB').dataTable().fnGetNodes(index);
    $(row).attr( 'id', "rowID_"+urut );
    
    $('#showItemData').modal('hide');
    $("input[type=text]").attr("autocomplete", "off");
}
/* End Select Program */


/* Select Barang dan simpan ke row */
function selectBarang(kode_barang, nama_barang){
    if(currentUrut){
        $('#kode_barang_'+currentUrut).val(kode_barang);
        var display = '<small class="text-black"><strong>'+kode_barang+' - '+nama_barang+'</strong></small>';
        $('#barang_display_'+currentUrut).html(display);
        $('#showBarangData').modal('hide');
        currentUrut = null;
    }
}
/* End Select Barang */


/* Validation Before addRow() */
function validasi_submit(){

    if($('#pc_tujuan').val() == ""){
        dialog_warning('Notification',"Pilih Tujuan Terlebih Dahulu");
        return false;
    }

    return true;
}
/* End Validation Before addRow() */

/* Action Saat tombol delete di click */
function deleteRow(no_urut,kode_program){
    // Simpan data barang dari semua row sebelum dihapus
    var savedBarangData = {};
    var rows = tableListBKB.rows().nodes();
    $(rows).each(function(index) {
        var currentUrut = $('input[name="urut[]"]',this).val();
        var kodeBarang = $('input[name="kode_barang[]"]',this).val();
        var displayHtml = $('[id^="barang_display_"]', this).html();
        savedBarangData[currentUrut] = {
            kode_barang: kodeBarang,
            display_html: displayHtml
        };
    });
    
    // Hapus row yang dipilih
    tableListBKB.row(no_urut-1).remove().draw(false);
    
    // Reindex semua row yang tersisa
    var rows = tableListBKB.rows().nodes();
    var new_no_urut = 1;
    var newUrtuMap = {}; // Map untuk tracking urut lama ke urut baru
    
    $(rows).each(function(index) {
        var oldUrut = $('input[name="urut[]"]',this).val();
        newUrtuMap[oldUrut] = new_no_urut;
        
        // Get the kode_program dari row ini
        var row_kode_program = $('input[name="kode_program[]"]',this).val();
        
        // Ambil data barang yang sudah disimpan (jika ada)
        var savedKodeBarang = '';
        var savedDisplayHtml = '';
        if(savedBarangData[oldUrut]) {
            savedKodeBarang = savedBarangData[oldUrut].kode_barang;
            savedDisplayHtml = savedBarangData[oldUrut].display_html;
        }
        
        // Column 0: urut field
        var append_1 = "<input type='hidden' name='urut[]' id='urut_"+new_no_urut+"' value='"+new_no_urut+"' />"+new_no_urut;
        
        // Column 2: Pilih Barang link and hidden fields (dengan data barang yang sudah disimpan)
        var append_3 = '<a href="javascript:void(0)" class="text-primary selectBarangLink" data-urut="'+new_no_urut+'" data-kode-program="'+row_kode_program+'" onclick="showModalBarang(\''+new_no_urut+'\')"><i class="fa fa-plus"></i> Pilih Barang</a><input type="hidden" name="kode_barang[]" id="kode_barang_'+new_no_urut+'" value="'+savedKodeBarang+'" /><div id="barang_display_'+new_no_urut+'">'+savedDisplayHtml+'</div>';
        
        // Column 4: delete button
        var append_2 = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(\''+new_no_urut+'\',\''+row_kode_program+'\')"><i class="fa fa-trash"></i></button>';
        
        tableListBKB.cell({row:index, column:0}).data(append_1);
        tableListBKB.cell({row:index, column:2}).data(append_3);
        tableListBKB.cell({row:index, column:4}).data(append_2);
        
        new_no_urut++;
    });
    
    tableListBKB.draw(false);
    $("input[type=text]").attr("autocomplete", "off");
}
/* End Action Saat tombol delete di click */

</script>
