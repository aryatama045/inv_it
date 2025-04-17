<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>
<style>
	span.select2-selection.select2-selection--single {
		height: 100% !important;
	}
	table.dataTable.stripe tbody tr.odd {
		background-color: rgb(255 252 252) !important;
	}
</style>

<div class="row">
	<div class="col">

		<!-- Title and Top Buttons Start -->
		<div class="page-title-container">
			<div class="row">
				<!-- Title Start -->
				<div class="col-12 col-md-7">
					<h1 class="mb-0 pb-0 display-4" id="title"><?= capital($modul).' '.$pagetitle ?></h1>
					<?php $this->load->view('templates/breadcrumb'); ?>
				</div>
				<!-- Title End -->

				<!-- Top Buttons Start -->
				<div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
					<!-- Dropdown Button Start -->
                    <div class="ms-1">

                        <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-1"
                            data-bs-offset="0,3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-submenu >
                            <i data-acorn-icon="more-horizontal"></i>
                            <span>Export</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
								<button type="button"  class="dropdown-item" id='btn-pdf-action' title="Print PDF"><i class="fas fa-print"></i> PDF</button>
								<button type="button"  class="dropdown-item" id='btn-excel-action' title="Export Excel"><i class="fas fa-file-excel"></i> Excel</button>

								<!-- <a href="<?= base_url($mod.'/'.$func.'/export/excel') ?>" class="dropdown-item" ><i class="fas fa-file-excel"></i> Excel</a>
								<a href="<?= base_url($mod.'/'.$func.'/export/pdf') ?>" class="dropdown-item" ><i class="fas fa-print"></i> PDF</a> -->

                        </div>
                    </div>
                    <!-- Dropdown Button End -->

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
                        <div class="d-inline-block float-md-start me-1  w-100">
							<div class="row g-2">

								<div class="col-2 text-center">
									<div class="form-group ">
										<select class="form-control select2-single" name="kategori" id="kategori">
											<option value="" >-- Kategori--</option>
											<option value="">All</option>
											<?php $nk=1; foreach ($cKategori as $key => $val) { ?>
												<option value="<?= $val['kode_kategori'] ?>"><?= $nk++ .'. ('. $val['kode_kategori'].')' ?> - <?= $val['nama'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-2 text-center">
									<div class="form-group ">
										<select class="form-control select2-single" name="merk" id="merk">
											<option value="">-- Merk--</option>
											<option value="">All</option>
											<?php $nm=1; foreach ($cMerk as $key => $val) { ?>
												<option value="<?= $val['kode_merk'] ?>"><?= $nm++.'. ('. $val['kode_merk'] .')' ?> - <?= $val['nama'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-2 text-center">
									<div class="form-group ">
										<select class="form-select select2-single" name="type" id="type">
											<option value="">-- Type--</option>
											<option value="">All</option>
											<?php $nt=1; foreach ($cType as $key => $val) { ?>
												<option value="<?= $val['kode_type'] ?>"><?= $nt++.'. ('. $val['kode_type'] .')' ?> - <?= $val['nama'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-2 text-center">
									<div class="form-group ">
										<select class="form-select select2-single" name="stock" id="stock">
											<option value="">-- Stock--</option>
											<option value="">All</option>
											<option value="True">With Stock</option>
											<option value="False">Without Stock</option>
										</select>
									</div>
								</div>

								<div class="col-2 text-center">
									<div class="form-group ">
										<select class="form-select select2-single" name="status" id="status">
											<option value="">-- Status--</option>
											<option value="">All</option>
											<?php $statuGet = $this->Model_global->getStatusBarang();
												foreach ($statuGet as $key => $val) { ?>
													<option value="<?= $val['status_barang'] ?>" ><?= $val['status_barang'].'-'.$val['nama'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-2 text-center">
									<div class="form-group ">
										<select class="form-select select2-single" name="lokasi" id="lokasi">
											<option value="">-- User Akhir--</option>
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

				<table id="<?= $table_data ?>"  class="table table-stripped stripe w-100" style="background:white;width:100%">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-center text-uppercase">Kode_Barang</th>
							<th class="text-bold text-center text-uppercase">Nama_Barang</th>
							<th class="text-bold text-center text-uppercase">Kode_Kategori</th>
							<th class="text-bold text-center text-uppercase">Kode_Merk</th>
							<th class="text-bold text-center text-uppercase">Kode_Type</th>
							<th class="text-bold text-center text-uppercase">Tanggal_Pembelian</th>
							<th class="text-bold text-center text-uppercase">Harga_Pembelian</th>
							<th class="text-bold text-center text-uppercase">Keterangan_Barang</th>
							<th class="text-bold text-center text-uppercase">Keterangan_ACCT</th>
							<th class="text-bold text-center text-uppercase">Status_Barang</th>
							<th class="text-bold text-center text-uppercase">Tanggal_Terakhir</th>
							<th class="text-bold text-center text-uppercase">Lokasi_Terakhir</th>
							<th class="text-bold text-center text-uppercase">Serial_Number</th>
							<th class="text-bold text-center text-uppercase">Qty_Baik</th>
							<th class="text-bold text-center text-uppercase">Qty_Rusak</th>
							<th class="text-bold text-center text-uppercase">Barang_Stock</th>
							<th class="text-bold text-center text-uppercase">Tanggal_Opname</th>
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
	window.linkexport = '<?php echo $func.'/export' ?>';
    window.tableData = '<?= $table_data ?>'
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>

<?php echo $this->load->assets(to_strip(lowercase($pagetitle)), 'index', 'js');  ?>