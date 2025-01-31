
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
                <h3 class="pb-0">Form  <?= $function ?> - <?= $pagetitle ?></h3>
                <hr class="mb-2">

                <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">

                    <div class="col-12 col-md-6">
                        <label class="form-label text-black"><strong>Nip Karyawan<span style="color:red">*</span></strong></label>
                        <select class="form-select select2-single" name="pengirim" id="pengirim" required>
                            <option value=""> -- Select Nip Karyawan --</option>
                            <?php $Personil1 = $this->Model_global->getPersonil();
                            foreach ($Personil1 as $key => $val) { ?>
                                <?php if($val['nip'] != 0){ ?>
                                    <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-12 col-md-3">
                        <label class="form-label text-black"><strong>Roles<span style="color:red">*</span></strong></label>
                        <select class="form-control" name="roles" id="roles" required>
                            <option value="" >-- Select Roles --</option>
                            <?php $roles = $this->Model_global->getRoles();
                                foreach($roles as $key => $val) { ?>
                                <option value="<?= $val['id'] ?>"> <?= uppercase(lowercase($val['name'])) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label text-black"><strong>Status<span style="color:red">*</span></strong></label>
                        <div class="form-group">
                            <input type="radio" class="btn-check status" id="Aktif" value="1" name="status" checked>
                            <label class="btn btn-outline-primary" for="Aktif">Aktif</label>
                            <input type="radio" class="btn-check status" id="nonAktif" value="0" name="status">
                            <label class="btn btn-outline-primary" for="nonAktif">Nonaktif</label>
                        </div>
                    </div>

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

