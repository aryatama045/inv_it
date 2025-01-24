<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>
<style>
	span.select2-selection.select2-selection--single {
		height: 100% !important;
	}
</style>

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
					<a href="<?= base_url($mod.'/'.$func.'/tambah') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
						<i data-acorn-icon="plus"></i>
						<span>Add New</span>
					</a>
					<!-- Add New Button End -->
				</div>
				<!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->

		<?= $this->load->view('templates/notif') ?>

        <div class="card ">
            <div class="card-body shadow">
                <div class="row  g-0">
                    <div class="col-3 text-center">
                        <div class="text-muted mb-1">BARANG</div>
                        <div class="cta-1 text-black font-weight-bold">
							<?php
							$cBarang = $this->Model_global->getBarang();
							echo count($cBarang);?>
						</div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-muted mb-1">KATEGORI</div>
                        <div class="cta-1 text-black font-weight-bold">
							<?php
							$cKategori = $this->Model_global->getKategori();
							echo count($cKategori);?>
						</div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-muted mb-1">MERK</div>
                        <div class="cta-1 text-black font-weight-bold">
							<?php
							$cMerk = $this->Model_global->getMerk();
							echo count($cMerk);?>
						</div>
                    </div>
                    <div class="col-3 text-center">
                        <div class="text-muted mb-1">TYPE</div>
                        <div class="cta-1 text-black font-weight-bold">
							<?php
							$cType = $this->Model_global->getType();
							echo count($cType);?>
						</div>
                    </div>
                </div>
            </div>

			<div class="card-body">

				<h3 class="mb-1">Filter Search</h3> <hr class="g-0">

                <!-- Controls Start -->
                <div class="row">
					<!-- Filter -->
                    <div class="col-sm-12 col-md-5 col-lg-9 col-xxl-9 mb-1">
                        <div class="d-inline-block float-md-start me-1 mb-1 w-100">
							<div class="row g-2">
								<div hidden class="col-3 text-center">
									<div class="input-group" >
										<select class="form-control" id="tanggal1">
											<option value=""> -- Tahun --</option>
											<?php for ($year = (int)date('Y'); 2010 <= $year; $year--): ?>
													<option value="<?=$year;?>"><?=$year;?></option>
											<?php endfor; ?>
										</select>
									</div>
								</div>

								<div class="col-3 text-center">
									<div class="form-group ">
										<!-- <label class="top-label mb-0 w-100"> -->
										<select class="form-control select2-single" name="kategori" id="kategori">
											<option value="" >-- Select Kategori--</option>
											<option value="">All</option>
											<?php $nk=1; foreach ($cKategori as $key => $val) { ?>
												<option value="<?= $val['kode_kategori'] ?>"><?= $nk++ .'. ('. $val['kode_kategori'].')' ?> - <?= $val['nama'] ?></option>
											<?php } ?>
										</select>
										<!-- <span>Kategori</span>
										</label> -->
									</div>
								</div>

								<div class="col-3 text-center">
									<div class="form-group ">
										<select class="form-control select2-single" name="merk" id="merk">
											<option value="">-- Select Merk--</option>
											<option value="">All</option>
											<?php $nm=1; foreach ($cMerk as $key => $val) { ?>
												<option value="<?= $val['kode_merk'] ?>"><?= $nm++.'. ('. $val['kode_merk'] .')' ?> - <?= $val['nama'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-3 text-center">
									<div class="form-group ">
										<select class="form-select select2-single" name="type" id="type">
											<option value="">-- Select Type--</option>
											<option value="">All</option>
											<?php $nt=1; foreach ($cType as $key => $val) { ?>
												<option value="<?= $val['kode_type'] ?>"><?= $nt++.'. ('. $val['kode_type'] .')' ?> - <?= $val['nama'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

							</div>
                        </div>
                    </div>

					<!-- Search -->
                    <div class="col-sm-12 col-md-5 col-lg-3 col-xxl-3 text-end mb-1">
                        <div class="d-inline-block me-0 me-sm-3 float-start float-md-none search-input-container w-100 shadow bg-outline-muted">
                            <input class="form-control" placeholder="Search" type="text" name="search_name" id="search_name" />
                            <span class="search-magnifier-icon">
                                <i data-acorn-icon="search"></i>
                            </span>
                            <span class="search-delete-icon d-none">
                                <i data-acorn-icon="close"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Controls End -->

				<div class="row mb-2">
					<div class="col-12 col-md-5 d-flex align-items-start ">
						<!-- Add New Button Start -->
						<a href="<?= base_url($mod.'/'.$func) ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto ">
							<span>Reset</span>
						</a>
						<!-- Add New Button End -->
					</div>
				</div>

				<table id="<?= $table_data ?>" class="table table-bordered data-table data-table-pagination  responsive nowrap stripe w-100">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-uppercase">#</th>
							<th class="text-bold text-uppercase">Nama</th>
							<th class="text-bold text-uppercase">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</div>
</div>





<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
	window.linkstore = '<?php echo $func.'/store' ?>';
    window.tableData = '<?= $table_data ?>'
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>

<?php echo $this->load->assets(to_strip(lowercase($pagetitle)), 'index', 'js');  ?>