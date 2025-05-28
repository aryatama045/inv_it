

<style>
table#manageTableMasterBarang0.dataTable tbody tr:hover {
    background-color: #ffa;
}
table#manageTableMasterBarang1.dataTable tbody tr:hover {
    background-color: #ffa;
}
table#manageTableActive.dataTable tbody tr:hover {
    background-color: #ffa;z
}
.vl {
border-left: 2px solid green;
height: 150px;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Transaksi
    <small><?=lang('input_nilai_avg'); ?></small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="<?=base_url() ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
    <li>Transaksi</li>
    <li class="active"><?=lang('input_nilai_avg'); ?></li>
    
    </ol>
</section>

<!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="col-md-12 col-xs-12">

        

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Transaksi <?=lang('input_nilai_avg'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="card-body text-center">
                <?= $this->session->flashdata('message'); ?>
            </div>

            <div id="messages"></div>

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php elseif ($this->session->flashdata('warning')) : ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('warning'); ?>
                </div>
            <?php elseif ($this->session->flashdata('error')) : ?>
                <div class="alert alert-error alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

                <div class="form-group row">
                    <div class="col-md-8 col-xs-12 pull pull-left ">
                        <form  role="form" action="<?php echo base_url('transaction/input_nilai_avg/create_action');?>" method="post" class="form-horizontal">

                            <!-- Kd Barang -->
                            <div class="form-group row">
                                <label for="kd_merk" class="col-sm-4 col-form-label" style="text-align:left;">BARANG</label>
                                <div class="col-sm-4" style="padding-right: 0px;">
                                <div class="input-group" onclick="getMasterBarang0()" data-toggle="modal" data-target="#modalMasterBarang0"> 
                                <input type="text" class="form-control" id="kd_barang0" name="kd_barang" placeholder="SELECT KD.BRG" style="height: 28px" required>
                                    <div class="input-group-addon" style="height: 28px">
                                        <span class="fa fa-folder" style="font-size: 12px"></span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-sm-4" style="padding-left: 0px;">
                                <input type="text" class="form-control" id="nm_barang0" name="nm_barang0" placeholder="NAMA BARANG" style="height: 28px" readonly required>
                                </div>
                            </div>

                            <!-- Bulan & Tahun -->
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" style="text-align:left;">PERIODE PENGHITUNGAN</label>

                                <div class="col-sm-4" style="padding-right: 0px;">
                                    <div class="input-group date">
                                        <input type="text" class="datepicker form-control" id="awal" name="awal" style="height: 28px">
                                        <div class="input-group-addon" style="height: 28px">
                                        <span class="glyphicon glyphicon-th" style="font-size: 12px"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nilai HPP -->
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" style="text-align:left;">HPP AKHIR</label>
                                <div class="col-sm-8" style="padding-right: 0px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="hpp_akhir" name="hpp_akhir" placeholder="HPP AKHIR" style="height: 28px" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary" style="width: 80px"><?=lang('save')?></button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-4 col-xs-12 vl">
                        <button type="submit" class="btn btn-success" onclick="modal_upload()"><i class="fa fa-fw fa-upload"></i>Upload Point</button>
                        <a class="btn btn-primary" href="<?= base_url('input_nilai_avg_upload/template/Input-Nilai-Avg-Upload.xls') ?>" download><i class="fa fa-fw fa-download"></i> Download Template </a>                    </div>
                </div>
                <div class="col-md-12 col-xs-12 " style="padding-right: 0px;">
                    <hr>
                    <form action="<?php echo base_url('transaction/input_nilai_avg/print_action') ?>" method="post" id='formPrintConfirm'>
                        <!-- <input type="hidden" name="barang" id='kd_barang_print'>
                        <input type="hidden" name="sampai" id='kd_sampai_print'> -->
                        <button type="button" class="btn btn-default" onclick="print($('#kd_barang0').val(),$('#kd_barang1').val(),false)" id='btn-pdf-action' title="Print PDF">PDF</button>
                        <!-- <button type="button" class="btn btn-default" onclick="print($('#kd_barang0').val(),$('#kd_barang1').val(),true)" id='btn-excel-action' title="Export Excel">EXCEl</button> -->

                    </form>
                    <br>
                </div>

                <div class="box-body">
                    <table id="manageTableActive" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <!-- <th>NO</th> -->
                                <th>KD.BARANG</th>
                                <th>NAMA BARANG</th>
                                <th>TAHUN</th>
                                <th>BULAN</th>
                                <th>HPP AKHIR</th>
                                <th>PIC</th>
                                <th>TGL.INPUT</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <!-- <td></td> -->
                                <td><input type="text" data-column="1"  class="search-input-text-active form-control" style="width: 100%" placeholder="Kd Barang"></td>
                                <td><input type="text" data-column="2"  class="search-input-text-active form-control" style="width: 100%" placeholder="Nama Barang"></td>
                                <td><input type="text" data-column="3"  class="search-input-text-active form-control" style="width: 100%" placeholder="Tahun"></td>
                                <td><input type="text" data-column="4"  class="search-input-text-active form-control" style="width: 100%" placeholder="Bulan"></td>
                                <td><input type="text" data-column="5"  class="search-input-text-active form-control" style="width: 100%" placeholder="Hpp Akhir"></td>
                                <td><input type="text" data-column="6"  class="search-input-text-active form-control" style="width: 100%" placeholder="Pic"></td>
                                <td><input type="text" data-column="7"  class="search-input-text-active form-control" style="width: 100%" placeholder="Tgl Input"></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->
        </div>
        <!-- col-md-12 -->
        </div>
        <!-- /.row -->


    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- modal alert-->
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
            <a class="btn btn-default" data-dismiss="modal" id='btn-information'>Close</a>
        </div>
        </div>
    </div>
</div>
<!-- modal alert-->

<!-- modal Master Merk-->
<div class="modal fade" tabindex="-1" role="dialog" id="modalMasterBarang0">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="staticModalLabel">Master Barang</h3>
        </div>
        <div class="modal-body">
            <div class="box-body">
            <table id="manageTableMasterBarang0" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                <tr>
                    <th>KD.BARANG</th>
                    <th>NAMA BARANG</th>
                    <th></th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <td><input type="text" data-column="0"  class="search-input-text-active form-control" style="width: 100%" placeholder="KODE BARANG"></td>
                    <td><input type="text" data-column="1"  class="search-input-text-active form-control" style="width: 100%" placeholder="NAMA BARANG"></td>
                    <td></td>
                </tr>
                </thead>
            </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default" data-dismiss="modal" id='btn-information'>Close</a>
        </div>
        </div>
    </div>
</div>

<form role="form" action="<?php echo base_url('transaction/input_nilai_avg/upload_excel') ?>" enctype="multipart/form-data" method="post" id="uploadFormExcel">
    <div class="modal fade" tabindex="-1" role="dialog" id="uploadModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">Upload </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Bulan & Tahun -->
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" style="text-align:left;">PERIODE PENGHITUNGAN</label>

                        <div class="col-sm-4" style="padding-right: 0px;">
                            <div class="input-group date">
                                <input type="text" class="datepicker form-control" name="periode" style="height: 28px">
                                <div class="input-group-addon" style="height: 28px">
                                <span class="glyphicon glyphicon-th" style="font-size: 12px"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Upload File -->
                    <div class="form-group row">
                        <label for="excel_upload" class="col-sm-4 col-form-label" style="text-align:left;">UPLOAD FILE</label>
                        <div class="col-sm-4" style="padding-right: 0px;">
                            <input type="file" class="form-control-file" id="excel_upload" name='excel_upload' onchange="filePicked(event)">
                        </div>
                    </div>
                    <table id="tableListPreview" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                            <tr>
                            <th>No.</th>
                            <th>SKU</th>
                            <th>Hpp Akhir</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>

            </div>
        </div>
    </div>
</form>


<!-- Direct to page with POST Paramaeter -->
<div id='containerFormRedirect'>
    <form action="input_nilai_avg/export" method="post" id='formEXCELRedirect'>
        <input type="hidden" name="barang" id='kd_barang_excel'>
        <input type="hidden" name="sampai" id='kd_sampai_excel'>
    </form>
</div>
<!-- Direct to page with POST Paramaeter -->


<script type="text/javascript">
    var base_url= '<?php echo base_url()?>';
    var manageTableActive;
    var timer;
    var d = new Date();
    var curr_m = d.getMonth()+1;
    var curr_y = d.getFullYear();
    var mm = ((curr_m < 10) ? '0'+curr_m : curr_m);
    var yy = curr_y.toString().substring(2, 4);
    var dt = yy+mm;

    /* Document Ready */
    $(document).ready(function() {

        $("#TransaksiNav").addClass('active');
        $("#input_nilai_avgTransaksiNav").addClass('active');

        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $('.datepicker').datepicker({
            format: "dd MM yyyy",
            autoclose: true,
        }).datepicker('setDate', '<?=date("d M Y", strtotime($tgl_aktif));?>');

        /*  Datatables ManageTableActive */
        $('.search-input-text-active').val('');
        $('#manageTableActive').dataTable().fnDestroy();
        manageTableActive = $('#manageTableActive').DataTable({
            'orderCellsTop' : true,
            'fixedHeader'   : true,
            // 'ordering'      : false,
            'processing'    : true,
            'serverSide'    : true,
            'fixedColumns'  : true,
            'bLengthMenu '  : false,
            'bInfo'         : true,
            'ajax': {
            'url': base_url + 'transaction/input_nilai_avg/fetchInputNilaiAvgData/',
            'type':'POST',
            'dataType' : 'json'
            },
            'columnDefs'    : [
                {targets: 0,className: 'text-center'},
                {targets: 3,className: 'text-center'},
                {targets: 4,className: 'text-center'},
                {targets: 5,className: 'text-right'},
                {targets: 6,className: 'text-center'},
            ],
            'language': {
            'emptyTable': 'EMPTY'
            }
        });
        // $(".dataTables_paginate").css("display", "none");
        $(".dataTables_filter").css("display","none");
        // $(".dataTables_length").css("display","none");
        $('.search-input-text-active').on( 'keyup click', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            var v =$(this).val();  // getting search input value

            if(this.value.length >= 3 || e.keyCode == 13 || e.focus()) {
                clearTimeout(timer);
                timer = setTimeout(function (event) {
                    manageTableActive.columns(i).search(v).draw();
                }, 1000); //Delay 1 second
            }
            // Ensure we clear the search if they backspace far enough
            if(this.value == "") {
                dtable.search("").draw();
            }
        });
        /* End Datatables ManageTableActive */

    });
    /* End Document Ready */

    function modal_upload() {
        $('input[type=search]').val('').change();
        tableListPreview.clear().draw();
        oFileIn.value = "";
        $('#uploadModal').modal('show');
    }
    var oFileIn;

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
        console.log(oFile);
        if (typeof(oFile) != "undefined") {
        if (oFile.name == "Input-Nilai-Avg-Upload.xls") {
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
        }


    }


    function getMasterBarang0(){

        $('.search-input-text-active').val('');
        $('#manageTableMasterBarang0').dataTable().fnDestroy();

        manageTableMasterBarang0 = $('#manageTableMasterBarang0').DataTable({
            'orderCellsTop': true,
            'fixedHeader': true,
            'processing': true,
            'serverSide': true,
            'ajax': {
            'url': base_url + 'transaction/input_nilai_avg/getDataMasterBarang/',
            'type':'POST',
            },
            'initComplete':function(){onintMasterBarang0();}
        });

        function onintMasterBarang0(){

            $(".dataTables_filter").css("display","none");  // hiding global search box


            $('.search-input-text-active').on( 'keyup click', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            var v =$(this).val();  // getting search input value

            if(this.value.length >= 3 || e.keyCode == 13 || e.focus()) {
                clearTimeout(timer);
                timer = setTimeout(function (event) {
                manageTableMasterBarang0.columns(i).search(v).draw();
                }, 1000); //Delay 1 second
            }
            // Ensure we clear the search if they backspace far enough
            if(this.value == "") {
                dtable.search("").draw();
            }

            });

            $('#manageTableMasterBarang0 tbody').on( 'click', 'tr', function () {

            var rowData = manageTableMasterBarang0.row(this).data();

            var kd_barang  = rowData[0];
            var nm_barang  = rowData[1];

            // //fill data to input
            $("#kd_barang0").val(kd_barang);
            $("#nm_barang0").val(nm_barang);

            // getReportStockNormal(kd_merk);
            // sumReport(kd_merk);

            //alert(row_id);
            row_id = null;
            // hide the modal
            $("#modalMasterBarang0").modal('hide');
            
            });
        }
    }


    /* Function untuk OnClick Button View */
    function excel(barang, sampai){
        $( "#kd_brg_excel" ).val(barang);
        $( "#kd_sampai_excel" ).val(sampai);
        $( "#formEXCELRedirect" ).submit();
    }

    /* Function untuk OnClick Button Konfirmasi Print */
    function print(barang,sampai,page = false){
        if(page){
        $( "#kd_barang_excel" ).val(barang);
        $( "#kd_sampai_excel" ).val(sampai);
        $( "#formEXCELRedirect" ).submit();
        }else{
        $( "#kd_barang_print" ).val(barang);
        $( "#kd_sampai_print" ).val(sampai);
        $( "#formPrintConfirm" ).submit();
        }
    }
    /* End Function untuk OnClick Button Konfirmasi Print */

    /* Direct To page Print Preview */
    $("#formPrintConfirm").on('submit', function() {
        var form = $(this);
        form.attr('target','new');
        form.get(0).submit();
        event.preventDefault();
    });
    /* Direct To page Print Preview */


</script>
