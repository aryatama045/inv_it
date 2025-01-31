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
                    <div class="col-md-6">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= $header['nomor_transaksi'] ?></b></p>
                            <span class="text-black text-medium"><b>NOMOR TRANSAKSI</b></span>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="mb-3 top-label">
                            <?php
                                $getUser    = $this->Model_global->getPersonil($header['user_input']);
                                $user       = $getUser['nip'].'-'.$getUser['nama'];
                            ?>
                            <p class="form-control"><b><?= uppercase(strtolower($user)) ?></b></p>
                            <span class="text-black text-medium"><b>USER INPUT </b></span>
                        </label>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal_input']) ?></b></p>
                            <span class="text-black text-medium"><b>TANGGAL</b></span>
                        </label>
                    </div>

                    <div class="col-md-6">
                        <label class="mb-3 top-label">
                            <p class="form-control"><b><?= tanggal($header['tanggal_proses']) ?></b></p>
                            <span class="text-black text-medium"><b>TANGGAL PROSES</b></span>
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

                <table class="table table-striped" >
                    <thead>
                        <tr >
                            <th class="text-bold text-uppercase">NO.</th>
                            <th class="text-bold text-uppercase">KODE BARANG</th>
                            <th class="text-bold text-uppercase">NAMA BARANG</th>
                            <th class="text-bold text-uppercase">STATUS</th>
                            <th class="text-bold text-uppercase">QTY</th>
                            <th class="text-bold text-uppercase">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $key => $val) {
                            $barang = $this->Model_global->getBarang($val['kode_barang']);
                            $status = $this->Model_global->getStatusBarang($barang['status_barang']);
                        ?>
                        <tr>
                            <td><?= $val['no_urut'] ?></td>
                            <td><?= $val['kode_barang'] ?></td>
                            <td><?= $barang['nama_barang'] ?></td>
                            <td><?= $status['status_barang'].'-'.$status['nama'] ?></td>
                            <td><?= $val['qty_in'] ?></td>
                            <td><?= $val['keterangan_barang'] ?></td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <div class="col-12 mt-5">
                    <a  data-bs-toggle="modal" data-bs-target="#batalModal" onclick="batal_dokumen('<?= $header['nomor_transaksi'] ?>')"
                        class="btn btn-danger btn-icon btn-icon-start w-100 w-md-auto  m-1">
                        <i class="fa fa-trash"></i>
                        <span>Batal Dokumen</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>




<!-- batal dokumen modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="batalModal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form role="form" action="<?= base_url($mod.'/'.$func.'/batal_action') ?>" method="post" id="batalForm">
				<div id="id" class="modal-body">
					<p class="mb-1">Yakin <span></span> ?</p>

                    <div class="mb-2" id="messages_modal_batal"></div>

                    <div class="col-12 col-md-12 mb-5">
                        <label class="form-label text-black"><strong> Keterangan Batal </label>
                        <textarea name="keterangan_batal" row="3" class="form-control" placeholder="Input Keterangan" required></textarea>
                    </div>

                </div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id='btn-delete'>Submit Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Direct to page with POST Parameter -->
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

    function batal_dokumen(id)
    {
        $("#btn-delete").removeAttr('class');
        $("#btn-delete").text('Dibatalkan');
        $("#btn-delete").addClass('btn btn-danger');
        $("#batalModal h5").text(id);
        $("#messages_modal_batal").html('');
        $("#id span").html('Dibatalkan '+' <strong> '+id+'</strong>');
        if(id){
            $("#batalForm").on('submit', function() {
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
                                $("#batalModal").modal('hide');

                            } else {

                                $("#messages_modal_batal").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
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
</script>