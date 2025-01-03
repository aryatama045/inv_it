
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
                <h3 class="pb-0">Form <?= $function ?> - <?= $pagetitle ?></h3>
                <hr class="mb-2">

                <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/edit/'.$ta['kd_ta']); ?>" method="POST">
                    <div class="col-12 col-md-4">
                        <label class="form-label text-black-50"><strong>Kode TA<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="kd_ta" value="<?= $ta['kd_ta'] ?>" readonly/>
                    </div>
                    <div class="col-12 col-md-8">
                        <label class="form-label text-black-50"><strong>Tahun Ajaran<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="ta" value="<?= $ta['ta'] ?>" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-black-50"><strong> Semester<span style="color:red">*</span></strong></label>
                        <select name="smt" required class="form-select">
                            <option value="<?= $ta['smt'] ?>">-- Semester <?= $ta['smt'] ?> --</option>
                            <option value="1"> Semester 1</option>
                            <option value="2"> Semester 2</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-black-50"><strong> Status Aktif<span style="color:red">*</span></strong></label>
                        <select name="aktif" required class="form-select">
                            <option value="<?= $ta['aktif'] ?>">-- <?php if($ta['aktif']==1){echo 'Aktif';}else{echo 'Nonaktif';} ?> --</option>
                            <option value="1"> Aktif</option>
                            <option value="0"> Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-12">
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