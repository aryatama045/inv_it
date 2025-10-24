<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func;

?>

<div class="row">
	<div class="col">

		<!-- Title and Top Buttons Start -->
		<div class="page-title-container">
			<div class="row">
				<!-- Title Start -->
				<div class="col-12 col-md-7">
					<h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?></h1>
					<?= $this->load->view('templates/breadcrumb'); ?>
				</div>
				<!-- Title End -->

				<!-- Top Buttons Start -->
				<div class="col-12 col-md-5 d-flex align-items-start justify-content-end">

					<a hidden class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto m-1"
						data-bs-effect="effect-super-scaled"
                        data-bs-toggle="modal" href="#modal_import">
						<i class="fa fa-download"></i>
						<span>Import</span>
					</a>

					<!-- Add New Button Start -->
					<a href="<?= base_url($mod.'/'.$func.'/tambah') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-1">
						<i data-acorn-icon="plus"></i>
						<span>Add New Stock</span>
					</a>

					<a href="<?= base_url($mod.'/'.$func.'/tambah_manual') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-1">
						<i data-acorn-icon="plus"></i>
						<span>Add New Qty</span>
					</a>
					<!-- Add New Button End -->

				</div>
				<!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->

		

		<?php $this->load->view('templates/notif') ?>

		<div class="card">

			<div class="card-body">


				<!-- Controls Start -->
				<div class="row">
					<!-- Search Start -->
					<div class="col-sm-12 col-md-5 col-lg-9 col-xxl-9 mb-1">
						<div class="d-inline-block float-md-start me-1 mb-1 search-input-container w-100 ">
							<h3 class="">Filter Search</h3>
						</div>
					</div>
					<!-- Search End -->

					<!-- Filter -->
					<div class="col-sm-12 col-md-5 col-lg-9 col-xxl-9 mb-1">
						<div class="d-inline-block float-md-start me-1  w-100">
							<div class="row g-2">
								<!-- Jenis -->
								<div class="col-2 text-center">
									<div class="form-group ">
										<select class="form-control select2-single" disabled name="jenis" id="jenis">
											<option value="" >-- Jenis --</option>
											<option value="">All</option>
											<option value="IN" selected>IN</option>
											<option value="OUT">OUT</option>
										</select>
									</div>
								</div>

								<!-- Pengirim -->
								<div class="col-3 text-center">
									<div class="form-group ">
										<select class="form-select select2-single" name="pengirim" id="pengirim">
											<option value=""> -- Pengirim --</option>
											<option value="">All</option>
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
								</div>

								<!-- Penerima -->
								<div class="col-3 text-center">
									<div class="form-group ">
										<select class="form-control select2-single" name="penerima" id="penerima">
											<option value="" >-- Penerima --</option>
											<option value="">All</option>
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

								<!-- Tujuan -->
								<div class="col-3 text-center">
									<div class="form-group ">
										<select class="form-control select2-single" name="tujuan" id="tujuan">
											<option value="" >-- Tujuan --</option>
											<option value="">All</option>
											<?php $Personil3 = $this->Model_global->getPersonil();
											foreach ($Personil3 as $key => $val) { ?>
												<?php if($val['nip'] == 0){ ?>
													<option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
												<?php } else { ?>
													<option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-sm-12 col-md-5 col-lg-3 col-xxl-3 text-end mb-1">
						<div class="d-inline-block me-0 me-sm-3 float-start float-md-none search-input-container w-100 shadow bg-foreground">
							<input class="form-control" placeholder="Search" type="text" name="search_name" id="search_name" />
							<span class="search-magnifier-icon">
								<i data-acorn-icon="search"></i>
							</span>
							<span class="search-delete-icon d-none">
								<i data-acorn-icon="close"></i>
							</span>
						</div>
					</div>

					<div class="col-12 col-md-5 d-flex align-items-start ">
						<!-- Add New Button Start -->
						<a href="<?= base_url($mod.'/'.$func) ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto ">
							<span>Reset</span>
						</a>
						<!-- Add New Button End -->
					</div>


				</div>
				<!-- Controls End -->
				<hr>

				<table id="<?= $table_data ?>" class="table table-bordered  stripe w-100">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-uppercase">Jenis</th>
							<th class="text-bold text-uppercase">Nomor Transaksi</th>
							<th class="text-bold text-uppercase">Tanggal</th>
							<th class="text-bold text-uppercase text-center">Pengirim</th>
							<th class="text-bold text-uppercase text-center">Penerima</th>
							<th class="text-bold text-uppercase text-center">Tujuan</th>
							<th class="text-bold text-uppercase">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</div>
</div>


<!-- Direct to page with POST Paramaeter -->
<div id='containerFormRedirect'>
	<form action="<?= base_url($mod.'/'.$func.'/print_action') ?>" method="post" id='formPrintsRedirect'>
	</form>
</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
	window.linkstore = '<?php echo $func.'/store' ?>';
    window.tableData = '<?= $table_data ?>'
</script>
<script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>

<?php echo $this->load->assets(to_strip(lowercase($pagetitle)), 'index', 'js');  ?>