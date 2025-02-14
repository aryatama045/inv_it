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
                <h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?> Detail Manual</h1>
            </div>
        </div>
        <!-- Title End -->

        <!-- Top Buttons Start -->
        <div  class="col-12 col-md-5 d-flex align-items-end justify-content-end">
            <button type="button" onclick="_prints('<?= $header['nomor_transaksi'] ?>')" class="btn btn-outline-primary btn-icon btn-icon-start m-1 ms-0 ms-sm-1 w-100 w-md-auto">
                <i data-acorn-icon="save"></i>
                <span>Print</span>
            </button>

            <a href="<?= base_url($mod.'/'.$func) ?>" class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto add-datatable m-1">
                <i data-acorn-icon="arrow-left"></i>
                <span>Kembali</span>
            </a>

            <!-- Dropdown Button Start -->
            <div hidden class="ms-1">
                <button type="button" class="btn btn-outline-primary btn-icon "
                    data-bs-offset="0,3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-submenu >
                    <i data-acorn-icon="more-horizontal"></i>
                    <span>More</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <button class="dropdown-item" type="button">Jadwal Mengajar</button>
                    <button class="dropdown-item" type="button">Jadwal Kelas</button>
                    <button class="dropdown-item" type="button">Check Ip</button>
                </div>
            </div>
            <!-- Dropdown Button End -->
        </div>

        <!-- Top Buttons End -->

    </div>
</div>
<!-- Title and Top Buttons End -->


<div class="row">
    <div class="col-12 ">
        <div class="card mb-5">
            <div class="card-body">
                <h4>Header</h4> <hr class="mb-2">
                <div class="row g-3">
                    <div class="col-md-4 col-12">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= $header['nomor_transaksi'] ?></b></p>
                            <span class="text-black text-medium"><b>NOMOR TRANSAKSI</b></span>
                        </label>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= $header['kode_dokumen'] ?></b></p>
                            <span class="text-black text-medium"><b>JENIS </b></span>
                        </label>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal']) ?></b></p>
                            <span class="text-black text-medium"><b>TANGGAL</b></span>
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="mb-3 top-label">
                            <?php
                                $getPengirim    = $this->Model_global->getPersonil($header['pengirim']);
                                $pengirim       = $getPengirim['nip'].'-'.$getPengirim['nama'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($pengirim)) ?></b></p>
                            <span class="text-black"><b>PENGIRIM </b></span>
                        </label>
                    </div>

                    <div class="col-md-4">
                        <label class="mb-3 top-label">
                            <?php
                                $getPenerima    = $this->Model_global->getPersonil($header['penerima']);
                                $penerima       = $getPenerima['nip'].'-'.$getPenerima['nama'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($penerima)) ?></b></p>
                            <span class="text-black"><b>PENERIMA </b></span>
                        </label>
                    </div>

                    <div class="col-md-4">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= uppercase(strtolower($header['tujuan'])) ?></b></p>
                            <span class="text-black"><b>TUJUAN </b></span>
                        </label>
                    </div>
                </div>


                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal_pengiriman']) ?></b></p>
                            <span class="text-black"><b>TANGGAL KIRIM </b></span>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal']) ?></b></p>
                            <span class="text-black"><b>TANGGAL TERIMA </b></span>
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

                <h4 class="mt-2">Detail</h4> <hr class="mb-2">

                <table id="tableListBKB" class="table table-striped" >
                    <thead>
                        <tr >
                            <th class="text-bold text-uppercase">NO.</th>
                            <th class="text-bold text-uppercase">QTY</th>
                            <th class="text-bold text-uppercase">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $key => $val) { ?>
                        <tr>
                            <td><?= $val['no_urut'] ?></td>
                            <td><?= $val['qty'] ?></td>
                            <td><?= $val['keterangan_barang'] ?></td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<div id='containerFormRedirect'>
	<form action="<?= base_url($mod.'/'.$func.'/print_action') ?>" method="post" id='formPrintsRedirect'>
	</form>
</div>

<script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>
<script type="text/javascript">
	function _prints(nomor_transaksi) {
        var html ='';
        html += '<input type="hidden" name="nomor_transaksi_print[]" id="nomor_transaksi_print" value="'+nomor_transaksi+'">';
        html += '<input type="hidden" name="pilih_print[]" id="pilih_print" value="1">';
        html += '<input type="hidden" name="printer"      id="printer_print" value=""></input>';
        var form = $("#formPrintsRedirect");
        form.html(html);
        form.attr('target', 'new');
        form.get(0).submit();
    }

$(document).ready(function() {
    /* Inisialisasi Table List BKB */
    var tableListBKB = $('#tableListBKB').DataTable({
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
            {targets: 0,className: 'text-center', width:'8%'},
            {targets: 1,className: 'text-center', width:'15%'},
            {targets: 2,className: 'text-left'},
        ]
    });
    /* End Inisialisasi Table List BKB */
});
</script>