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

			</div>
		</div>
		<!-- Title and Top Buttons End -->

		<?= $this->load->view('templates/notif') ?>

        <div class="card ">

			<div class="card-body">

				<h3 class="mb-1">Filter Search</h3> <hr class="g-0">

				<form action="<?= base_url($mod.'/'.$func.'/export') ?>" method="POST">
					<!-- Controls Start -->
					<div class="row">
						<!-- Filter -->
						<div  class="col-sm-12 col-md-5 col-lg-9 col-xxl-9 mb-1">
							<div  class="d-inline-block float-md-start me-1  w-100">
								<div class="row g-2">

									<div class="col-3 text-center">
										<div class="form-group ">
											<label class="form-label text-black">Tanggal Awal</label>
											<input class="form-control" name="tgl_awal" value="<?= date('d-m-Y') ?>"  id="selectTanggalAwal" />
										</div>
									</div>


									<div class="col-3 text-center">
										<div class="form-group ">
											<label class="form-label text-black">Tanggal Akhir</label>
											<input class="form-control" name="tgl_akhir" value="<?= date('d-m-Y') ?>"  id="selectTanggalAkhir"  />
										</div>
									</div>

									<div class="col-2 text-center">
										<div class="form-group ">
											<label class="form-label text-black">Jenis</label>
											<select class="form-control select2-single" name="jenis" id="jenis">
												<option value="" >-- Jenis --</option>
												<option value="">All</option>
												<option value="IN">IN</option>
												<option value="OUT">OUT</option>

											</select>
										</div>
									</div>

									<div class="col-2 text-center">
										<div class="form-group ">
											<label class="form-label text-black">Type</label>
											<select class="form-control select2-single" name="type" id="type">
												<option value="" >-- Type --</option>
												<option value="">All</option>
												<option value="True">Manual</option>
												<option value="False">Normal</option>

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
							<button type="submit"  class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto ">
								<span><i class="fas fa-file-excel"></i>Export Excel</span>
							</button>
							<!-- Add New Button End -->
						</div>
					</div>
				</form>

				<table id="<?= $table_data ?>"  class="table table-stripped stripe w-100" style="background:white;width:100%">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-center text-uppercase">Nomor_Transaksi</th>
							<th class="text-bold text-center text-uppercase">Jenis</th>
							<th class="text-bold text-center text-uppercase">Tanggal_Input</th>
							<th class="text-bold text-center text-uppercase">Nama_Pengirim</th>
							<th class="text-bold text-center text-uppercase">Nama_Penerima</th>
							<th class="text-bold text-center text-uppercase">Nama_Tujuan</th>
							<th class="text-bold text-center text-uppercase">Kode_Barang</th>
							<th class="text-bold text-center text-uppercase">Nama_Barang</th>
							<th class="text-bold text-center text-uppercase">Qty</th>
							<th class="text-bold text-center text-uppercase">Status</th>
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