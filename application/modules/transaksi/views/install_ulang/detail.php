<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>


<!-- Title and Top Buttons Start -->
<div class="page-title-container">
    <div class="row">
        <!-- Title Start -->
        <div class="col-auto mb-3 mb-md-0 me-auto">
            <div class="w-auto sw-md-50">
                <a href="<?= base_url(lowercase($modul).'/'.to_strip(lowercase($pagetitle))); ?>" class="muted-link pb-1 d-inline-block breadcrumb-back">
                    <i data-acorn-icon="chevron-left" data-acorn-size="13"></i>
                    <span class="text-small align-middle"> <?= $pagetitle ?></span>
                </a>
                <h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?> Detail</h1>
            </div>
        </div>
        <!-- Title End -->

        <!-- Top Buttons Start -->
        <div  class="col-12 col-md-5 d-flex align-items-end justify-content-end">
            <button hidden type="button" onclick="_prints('<?= $header['nomor_transaksi'] ?>')" class="btn btn-outline-primary btn-icon btn-icon-start m-1 ms-0 ms-sm-1 w-100 w-md-auto">
                <i data-acorn-icon="save"></i>
                <span>Print</span>
            </button>

            <a href="<?= base_url($mod.'/'.$func) ?>" class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto add-datatable m-1">
                <i data-acorn-icon="arrow-left"></i>
                <span>Kembali</span>
            </a>

        </div>

        <!-- Top Buttons End -->

    </div>
</div>
<!-- Title and Top Buttons End -->


<div class="row">
    <div class="col-12 ">
        <div class="card mb-5">
            <form id="formAction" class="row g-3" action="<?= base_url($mod.'/'.$func.'/show/'.$header['nomor_transaksi']); ?>" method="POST">

            <div class="card-body">
                <h4 class="border-bottom mb-2 text-black">Header</h4>
                
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= $header['nomor_transaksi'] ?></b></p>
                            <span class="text-black"><b>NOMOR TRANSAKSI</b></span>
                        </label>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal_dokumen']) ?></b></p>
                            <span class="text-black"><b>TANGGAL DOKUMEN</b></span>
                        </label>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <?php
                                $getMengetahui    = $this->Model_global->getPersonil($header['pic_approve']);
                                $mengetahui       = $getMengetahui['nip'].'-'.$getMengetahui['nama'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($mengetahui)) ?></b></p>
                            <span class="text-black"><b>MENGETAHUI</b></span>
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="mb-3 top-label">
                            <?php
                                $getPCOS    = $this->Model_global->getDataInstallUlang($header['pc_os'],'');
                                $pc_os       = $getPCOS['nama_program'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($pc_os)) ?></b></p>
                            <span class="text-black"><b>PC OS</b></span>
                        </label>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= $header['pc_ip'] ?></b></p>
                            <span class="text-black"><b>PC-IP</b></span>
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <?php
                                $PicInstall    = $this->Model_global->getPersonil($header['pic_install']);
                                $pic_install   = $PicInstall['nip'].'-'.$PicInstall['nama'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($pic_install)) ?></b></p>
                            <span class="text-black"><b>PIC INSTALL</b></span>
                        </label>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <?php
                                $PicCheck    = $this->Model_global->getPersonil($header['pic_check']);
                                $pic_check   = $PicCheck['nip'].'-'.$PicCheck['nama'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($pic_check)) ?></b></p>
                            <span class="text-black"><b>PIC CHECK</b></span>
                        </label>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <?php
                                $getTujuan    = $this->Model_global->getPersonil($header['pc_tujuan']);
                                $tujuan       = $getTujuan['nip'].'-'.$getTujuan['nama'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($tujuan)) ?></b></p>
                            <span class="text-black"><b>TUJUAN</b></span>
                        </label>
                    </div>

                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal_mulai']) ?></b></p>
                            <span class="text-black"><b>TANGGAL MULAI </b></span>
                        </label>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal_check']) ?></b></p>
                            <span class="text-black"><b>TANGGAL CHECK </b></span>
                        </label>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal_selesai']) ?></b></p>
                            <span class="text-black"><b>TANGGAL SELESAI </b></span>
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="mb-3 top-label">
                            <p class="form-control">
                                <?= capital(strtolower($header['keterangan'])) ?>
                            </p>
                            <span class="text-black"><b>KETERANGAN</b></span>
                        </label>
                    </div>
                </div>

                <h4 class="border-bottom mb-2 mt-2">Detail</h4>
                <table id="tableListBKB" class="table table-striped" >
                    <thead>
                        <tr >
                            <th class="text-bold text-uppercase">NO.</th>
                            <th class="text-bold text-uppercase">NAMA PROGRAM</th>
                            <th class="text-bold text-uppercase">BARANG</th>
                            <th class="text-bold text-uppercase">KETERANGAN</th>
                            <th class="text-bold text-uppercase">INSTALL</th>
                            <th class="text-bold text-uppercase">CHECK</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $key => $val) {
                            $barang = $this->Model_global->getBarang($val['kode_barang']);
                        ?>
                        <tr id="rowID_<?= $val['no_urut'] ?>">
                            <td>
                                <input type="hidden" id='urut_<?= $val['no_urut'] ?>' name="no_urut[]" value="<?= $val['no_urut'] ?>" />
                                <?= $val['no_urut'] ?>
                            </td>
                            <td>
                                <input type="hidden" name="kode_program[]" value="<?= $val['kode_program'] ?>" />
                                <input type="hidden" name="nama_program[]" value="<?= $val['nama_program'] ?>" />
                                <?= $val['nama_program'] ?>
                                <br>
                                <?php if($val['tanggal_selesai']==NULL && $this->session->userdata('username') == $val['pic_install'] ){ ?>
                                    <a href="javascript:void(0)" class="text-primary selectBarangLink" 
                                        data-urut="<?= $val['no_urut'] ?>"
                                        data-kode-program="<?= $val['kode_program'] ?>"
                                        onclick="showModalBarang('<?= $val['no_urut'] ?>')">
                                        <i class="fa fa-plus"></i> Pilih Barang
                                    </a>
                                    <input type="hidden" name="kode_barang[]" id="kode_barang_<?= $val['no_urut'] ?>" value="<?= $val['kode_barang'] ?>" />
                                    <div id="barang_display_<?= $val['no_urut'] ?>"></div>
                                <?php } ?>
                            </td>
                            <td>
                                <?= $barang['kode_barang'].' '.$barang['nama_barang'] ?>
                                
                            </td>
                            <td><input type="text" name="keterangan_detail[]" class="form-control " value="<?= $val['keterangan_detail'] ?>" /></td>
                            <td>
                                <div class="form-check">
                                    <input checked disabled class="form-check-input" type="checkbox" id="stackedInstall<?= $val['no_urut'] ?>">
                                    <label class="form-check-label" for="stackedInstall<?= $val['no_urut'] ?>"> Sudah</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input disabled name="pic_check_checked[]" value="<?= $val['pic_check_checked'] ?>" <?= ($val['pic_check_checked'])? 'checked':''; ?> class="form-check-input" type="checkbox" id="stackedCheck<?= $val['no_urut'] ?>">
                                    <label class="form-check-label" for="stackedCheck<?= $val['no_urut'] ?>"> Sudah</label>
                                </div>
                            </td>
                            <td>
                                <?php if($val['tanggal_selesai']==NULL && $this->session->userdata('username') == $val['pic_install'] ){ ?>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow('<?= $val['no_urut'] ?>','<?= $val['kode_program'] ?>')"><i class="fa fa-trash"></i></button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <?php if($val['tanggal_selesai']==NULL && $this->session->userdata('username') == $val['pic_install'] ){ ?>

                <div class="mb-3 mt-3 pb-3 border-bottom text-center">
                    <a onclick='addRow()'  class="btn btn-sm btn-icon btn-icon-start btn-primary addRow">    
                        <i data-acorn-icon="plus"></i>
                        <span>Add Program</span>
                    </a>
                </div>

                
                <div class="col-12 d-flex align-items-end justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-icon-start">
                        <i data-acorn-icon="save"></i> 
                        Update
                    </button>
                </div>

                <?php } ?>

            </div>

            </form>
        </div>
    </div>
</div>

<!-- Direct Print -->
<div id='containerFormRedirect'>
	<form action="<?= base_url($mod.'/'.$func.'/print_action') ?>" method="post" id='formPrintsRedirect'>
	</form>
</div>
<!-- End Direct Print -->

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
            {targets: 5,className: 'text-left'},
            {targets: 6,className: 'text-left'},
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

    /* Event On tr Table Browse Barang */
    $(document).on('click', '#tableListBarang tbody .btn-pilih-barang', function(){
        var kode_barang = $(this).data('kode');
        var nama_barang = $(this).data('nama');
        selectBarang(kode_barang, nama_barang);
    });
    /* End Event On tr Table Browse Barang */

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

    /* Event On tr Table Browse Program */
    $(document).on('click', '#tableListItems tbody .btn-pilih-program', function(){
        var kode_program = $(this).data('kode');
        var nama_program = $(this).data('nama');
        selectProgram(kode_program, nama_program);
    });
    /* End Event On tr Table Browse Program */

    /* Action Form Submit */
    $("#formAction").unbind('submit').on('submit', function() {
        
        dialog_submit('Notification',"Simpan !!");

        $('#btn-submit').click(function() {
            document.getElementById('formAction').submit();
        });

        return false;
        
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


/* Select Program dan tambah ke table */
function selectProgram(kode_program, nama_program){
    var urut = $('input[name="no_urut[]"]').length + 1;
    
    /* Add Click/Select Program to Table BKB */
    var index = $('#tableListBKB').DataTable().row.add( [
        "<input type='hidden' name='no_urut[]' id='urut_"+urut+"' value='"+urut+"' />"+urut,
        "<input type='hidden' name='kode_program[]' id='"+kode_program+"' value='"+kode_program+"' /><input type='hidden' name='nama_program[]' value='"+nama_program+"' />" +
        nama_program +
        '<br><a href="javascript:void(0)" class="text-primary selectBarangLink" data-urut="'+urut+'" data-kode-program="'+kode_program+'" onclick="showModalBarang(\''+urut+'\')"><i class="fa fa-plus"></i> Pilih Barang</a><input type="hidden" name="kode_barang[]" id="kode_barang_'+urut+'" value="" /><div id="barang_display_'+urut+'"></div>',
        '',
        '<input type="text" name="keterangan_detail[]" class="form-control " placeholder="Input Keterangan" />',
        '',
        '',
        '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(\''+urut+'\',\''+kode_program+'\')"><i class="fa fa-trash"></i></button>',
    ] ).draw( false );
    
    /* add id in row */
    var row = $('#tableListBKB').dataTable().fnGetNodes(index);
    $(row).attr( 'id', "rowID_"+urut );
    
    $('#showItemData').modal('hide');
    $("input[type=text]").attr("autocomplete", "off");
}
/* End Select Program */


/* Validation Before addRow() */
function validasi_submit(){

    // if($('#pc_tujuan').val() == ""){
    //     dialog_warning('Notification',"Pilih Tujuan Terlebih Dahulu");
    //     return false;
    // }

    return true;
}
/* End Validation Before addRow() */

/* Action Saat tombol delete di click */
function deleteRow(no_urut,kode_program){
    // Simpan data barang dari semua row sebelum dihapus
    var savedBarangData = {};
    var rows = tableListBKB.rows().nodes();
    $(rows).each(function(index) {
        var currentUrut = $('input[name="no_urut[]"]',this).val();
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
        var oldUrut = $('input[name="no_urut[]"]',this).val();
        newUrtuMap[oldUrut] = new_no_urut;
        
        // Get the kode_program dan nama_program dari hidden field row ini
        var row_kode_program = $('input[name="kode_program[]"]',this).val();
        var row_nama_program = $('input[name="nama_program[]"]',this).val();
        
        // Jika nama_program kosong, ambil dari text content (fallback untuk row lama)
        if(!row_nama_program || row_nama_program === '') {
            var cellText = $(this).find('td').eq(1).clone().children().remove().end().text().trim();
            row_nama_program = cellText.split('\n')[0].trim();
        }
        
        // Ambil data barang yang sudah disimpan (jika ada)
        var savedKodeBarang = '';
        var savedDisplayHtml = '';
        if(savedBarangData[oldUrut]) {
            savedKodeBarang = savedBarangData[oldUrut].kode_barang;
            savedDisplayHtml = savedBarangData[oldUrut].display_html;
        }
        
        // Column 0: no_urut field
        var append_1 = "<input type='hidden' name='no_urut[]' id='urut_"+new_no_urut+"' value='"+new_no_urut+"' />"+new_no_urut;
        
        // Column 1: nama program dan Pilih Barang link
        var append_2 = "<input type='hidden' name='kode_program[]' value='"+row_kode_program+"' /><input type='hidden' name='nama_program[]' value='"+row_nama_program+"' />" + row_nama_program + '<br><a href="javascript:void(0)" class="text-primary selectBarangLink" data-urut="'+new_no_urut+'" data-kode-program="'+row_kode_program+'" onclick="showModalBarang(\''+new_no_urut+'\')"><i class="fa fa-plus"></i> Pilih Barang</a><input type="hidden" name="kode_barang[]" id="kode_barang_'+new_no_urut+'" value="'+savedKodeBarang+'" /><div id="barang_display_'+new_no_urut+'">'+savedDisplayHtml+'</div>';
        
        // Column 6: delete button
        var append_3 = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(\''+new_no_urut+'\',\''+row_kode_program+'\')"><i class="fa fa-trash"></i></button>';
        
        tableListBKB.cell({row:index, column:0}).data(append_1);
        tableListBKB.cell({row:index, column:1}).data(append_2);
        tableListBKB.cell({row:index, column:6}).data(append_3);
        
        new_no_urut++;
    });
    
    tableListBKB.draw(false);
    $("input[type=text]").attr("autocomplete", "off");
}
/* End Action Saat tombol delete di click */


</script>

