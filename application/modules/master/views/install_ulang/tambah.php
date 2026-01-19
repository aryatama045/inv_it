
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

        <?= $this->load->view('templates/notif') ?>

        <!-- Content Start -->
		<div class="card">
			<div class="card-body">

                <h3 class="border-bottom mb-2 pb-2 pb-0">Form  <?= $function ?> - <?= $pagetitle ?></h3>
                
                <form id="formTambah" class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">

                    <div class="col-6 col-md-6">
                        <label class="form-label text-black"><strong>Nama Program<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required id="nama_program" name="nama_program" placeholder="Input Nama Program" />
                    </div>

                    <div class="col-6 col-md-6">
                        <label class="form-label text-black"><strong>Keterangan </strong></label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input Keterangan" />
                    </div>

                    <div class="col-6 col-md-6 mt-2">                        
                        <div class="form-check">
                          <input class="form-check-input" name="is_os" value="1" type="checkbox" id="customCheck1">
                          <label class="form-check-label" for="customCheck1">OS Install</label>
                        </div>
                        <span class="text-black"> *Pilih/Checked Jika OS Install</span>
                    </div>

                    <div class="border-bottom mt-2 mb-2"></div>
            
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary"><i data-acorn-icon="save"></i> Simpan</button>
                        <br>
                        <label class="form-check-label mt-3" ><strong> Note : </strong><span style="color:red">*</span> Wajib</label>
                    </div>

                </form>
            </div>
        </div>
        <!-- Content End -->
    </div>
</div>

<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>

<script>

$(document).ready(function() {

    /* Action Form Submit */
    $("#formTambah").unbind('submit').on('submit', function() {
        dialog_submit('Notification',"Simpan !!");

        $('#btn-submit').click(function() {
            document.getElementById('formTambah').submit();
        });

        return false;
    });


});

</script>