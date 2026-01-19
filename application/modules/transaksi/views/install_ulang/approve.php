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

<?php $this->load->view('templates/notif') ?>

<div class="row">
    <div class="col-12 ">
        <div class="card mb-5">
            <form id="formAction" class="row g-3" action="<?= base_url($mod.'/'.$func.'/approve/'.$header['nomor_transaksi']); ?>" method="POST">

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
                <table class="table table-striped" >
                    <thead>
                        <tr >
                            <th class="text-bold text-uppercase">NO.</th>
                            <th class="text-bold text-uppercase">NAMA PROGRAM</th>
                            <th class="text-bold text-uppercase">KETERANGAN</th>
                            <th class="text-bold text-uppercase">INSTALL</th>
                            <th class="text-bold text-uppercase">CHECK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $key => $val) {
                            $barang = $this->Model_global->getBarang($val['kode_barang']);
                        ?>
                        <tr>
                            <td>
                                <input type="hidden" name="no_urut[]" value="<?= $val['no_urut'] ?>" />
                                <?= $val['no_urut'] ?>
                            </td>
                            <td>
                                <?= $val['nama_program'] ?>
                                <br>
                                <div class="text-black text-medium">
                                    <?= $barang['kode_barang'].' '.$barang['nama_barang'] ?>
                                </div>
                            </td>
                            <td><?= $val['keterangan_detail'] ?></td>
                            <td>
                                <div class="form-check">
                                    <input checked disabled class="form-check-input" type="checkbox" id="stackedInstall<?= $val['no_urut'] ?>">
                                    <label class="form-check-label" for="stackedInstall<?= $val['no_urut'] ?>"> Sudah</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input name="pic_check_checked[]" value="<?= $val['pic_check_checked'] ?>" <?= ($val['pic_check_checked'])? 'checked disabled':''; ?> class="form-check-input" type="checkbox" id="stackedCheck<?= $val['no_urut'] ?>">
                                    <label class="form-check-label" for="stackedCheck<?= $val['no_urut'] ?>"> Sudah</label>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn btn-primary"><i data-acorn-icon="save"></i> Simpan</button>
                </div>

                <div class="col-12 mt-2">
                    <label class="form-check-label" ><strong> Note : </strong><span style="color:red">*</span> Wajib</label>
                </div>

            </div>

            </form>
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
</script>


<script type="text/javascript">


$(document).ready(function() {

    /* Action Form Submit */
    $("#formAction").unbind('submit').on('submit', function() {
        
        dialog_submit('Notification',"Simpan !!");

        $('#btn-submit').click(function() {
            document.getElementById('formAction').submit();
        });

        return false;
        
    });

});


</script>

