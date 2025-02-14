<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func;


	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	$isMobile = isMobile();

	// tesx($isMobile);

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

					<!-- <a class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto m-1"
						data-bs-effect="effect-super-scaled"
                        data-bs-toggle="modal" href="#modal_import">
						<i class="fa fa-download"></i>
						<span>Import</span>
					</a> -->

					<!-- Add New Button Start -->
					<a href="<?= base_url($mod.'/'.$func.'/tambah') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-1">
						<i data-acorn-icon="plus"></i>
						<span>Add New</span>
					</a>

					<a href="<?= base_url($mod.'/'.$func.'/tambah_manual') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-1">
						<i data-acorn-icon="plus"></i>
						<span>Add Manual New</span>
					</a>
					<!-- Add New Button End -->

				</div>
				<!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->

		<!-- Controls Start -->
		<div class="row">
			<!-- Search Start -->
			<div class="col-sm-12 col-md-5 col-lg-9 col-xxl-9 mb-1">
				<div class="d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground">
				</div>
			</div>
			<!-- Search End -->

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
		</div>
		<!-- Controls End -->

		<?php $this->load->view('templates/notif') ?>

		<div class="card">
			<div class="card-body">
				<table id="<?= $table_data ?>" class="table table-bordered data-table data-table-pagination  responsive nowrap stripe w-100">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-uppercase">Jenis</th>
							<th class="text-bold text-uppercase">Nomor Transaksi</th>
							<th class="text-bold text-uppercase">Tanggal</th>
							<th class="text-bold text-uppercase">Pengirim</th>
							<th class="text-bold text-uppercase">Tujuan</th>
							<th class="text-bold text-uppercase">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</div>
</div>

<!-- Modal Import -->
<div class="modal fade" data-bs-backdrop="static" id="modal_import">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">

            <div class="card-header">
                <h2 class="card-title m-0">Import </h2>
            </div>
            <form class="modal-dialog-scrollable" enctype='multipart/form-data'  action="<?= base_url($mod.'/'.$func.'/import_excel'); ?>" method="POST">

                <div class="card-body">

                    <div class="form-group mb-2">
                        <input name="fileExcel" class="form-control" type="file" />
                    </div>

                    <div class="form-group">
                        <a href="<?= base_url('upload/template/template-tanda-terima.xls')?>" download
							class="btn btn-sm btn-success mb-2"><i class="far fa-save"></i> Download Template</a>
                    </div>

                </div>

                <div class="card-footer ">
					<div class="row">
						<div class="col-md-6">
							<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
						</div>
						<div class="col-md-6">
							<div class="d-flex align-items-start justify-content-end">
								<button type="submit" class="btn btn-primary  float-right"><i class="fa fa-save"></i> Submit</button>
							</div>
						</div>
					</div>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- remove modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form role="form" action="<?= base_url($mod.'/'.$func.'/delete') ?>" method="post" id="removeForm">
				<div id="id" class="modal-body">
					<p>Yakin <span></span> ?</p>
				</div>

				<div id="messages_modal_remove"></div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id='btn-delete'> Remove</button>
				</div>
			</form>
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