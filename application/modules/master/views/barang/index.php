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
					<!-- <a class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto m-1"
						data-bs-effect="effect-super-scaled"
                        data-bs-toggle="modal" href="#modal_import">
						<i class="fa fa-download"></i>
						<span>Import</span>
					</a> -->

					<!-- <button class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto m-1" 
						onclick="modal_upload()">
						<i class="fa fa-download"></i>
						<span>Import</span>
					</button> -->


					<!-- Add New Button Start -->
					<a href="<?= base_url($mod.'/'.$func.'/tambah_baru') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto m-1">
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

				<table id="<?= $table_data ?>" class="table table-bordered data-table data-table-pagination  responsive nowrap stripe w-100">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-uppercase">#</th>
							<th class="text-bold text-uppercase">Kode</th>
							<th class="text-bold text-uppercase">Nama</th>
							<th class="text-bold text-uppercase">Status</th>
							<th class="text-bold text-uppercase">Qty</th>
							<th class="text-bold text-uppercase">Lokasi</th>
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
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <form class="modal-dialog-scrollable" enctype='multipart/form-data'  action="<?= base_url($mod.'/'.$func.'/import_excel_action'); ?>" method="POST">

				<div class="card-header">
					<h2 class="card-title m-0">Import </h2>
				</div>
				
                <div class="card-body">

                    <div class="form-group mb-1">
						<label class="form-label text-black"><strong>Template </strong></label>
                        <a href="<?= base_url('upload/template/Template-Barang.xls')?>" download
							class="btn btn-sm btn-success"><i class="far fa-save"></i> Download Template</a>
                    </div>

					<div class="form-group mb-2">
						<label class="form-label text-black"><strong>Template </strong></label>
						<input type="file" class="form-control" id="excel_upload" name='excel_upload' onchange="filePicked(event)">
                    </div>


                    <table id="tableListPreview" class="table table-stripped stripe w-100" style="background:white;width:100%">
                        <thead>
                            <tr>
								<th>No.</th>
								<th class="text-center">Kode_Kategori</th>
								<th class="text-center">Kode_Type</th>
								<th class="text-center">Kode_Merk</th>
								<th class="text-center">Kode_Barang</th>
								<th class="text-left">Nama_Barang</th>
								<th class="text-right">Harga_Beli</th>
								<th class="text-center">Tanggal_Beli</th>
								<th class="text-left">Keterangan_Acct</th>
								<th class="text-left">Serial_Number</th>

                            </tr>
                        </thead>
                    </table>

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


<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
	window.linkstore = '<?php echo $func.'/store' ?>';
    window.tableData = '<?= $table_data ?>'
</script>

<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="<?php echo base_url('assets/vendor/sheetjs/jszip.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/sheetjs/xlsx.js') ?>"></script>

<?php //echo $this->load->assets(to_strip(lowercase($pagetitle)), 'index', 'js');  ?>

<script type="text/javascript">
	var tables;

	var search_name,kategori,merk ,type, stock,status, lokasi;

	$(document).ready(function() {

		$('.select2-single').select2({});


		//# initialize the datatable
		tables = $('#'+tableData).DataTable({
			'processing': true,
			'serverSide': true,
			'paging' : true,
			'autoWidth': false,
			'destroy': true,
			'responsive': false,
			// 'fixedHeader': {
			//     'header': true,
			//     'footer': true
			// },
			'ajax': {
				'url': linkstore,
				'type': 'POST',
				'data': function(data) {
					data.search_name    = $('#search_name').val();
					data.kategori       = $("#kategori").val();
					data.merk           = $("#merk").val();
					data.type           = $("#type").val();
					data.stock          = $("#stock").val();
					data.status         = $("#status").val();
					data.lokasi         = $("#lokasi").val();
				},
			},
			'order': [0, 'ASC'],
			"columnDefs":[
				{"orderData": 1, "targets": 2},
				{targets: 0,width:'5%',className: 'text-center'},
			]
		});

		$("#"+tableData+"_filter").css("display", "none");
		// $("#tables_length").css("display", "none");

		// tables.columns.adjust().draw();

		$('#search_name').on('keyup', function(event) { // for text boxes
			tables.ajax.reload(); //just reload table
		});

		$("#kategori").on("change", function () { //button filter event click
			tables.ajax.reload(); //just reload table
		});

		$("#merk").on("change", function () { //button filter event click
			tables.ajax.reload(); //just reload table
		});

		$("#type").on("change", function () { //button filter event click
			tables.ajax.reload(); //just reload table
		});

		$("#stock").on("change", function () { //button filter event click
			tables.ajax.reload(); //just reload table
		});

		$("#status").on("change", function () { //button filter event click
			tables.ajax.reload(); //just reload table
		});

		$("#lokasi").on("change", function () { //button filter event click
			tables.ajax.reload(); //just reload table
		});
	});

	var oFileIn,tableListPreview,url,hasil,hasil_get;

	function modal_upload() {
		$('input[type=search]').val('').change();
		tableListPreview.clear().draw();
		oFileIn.value = "";
		$('#modal_import').modal('show');
	}

	$(function() {
		oFileIn = document.getElementById('excel_upload');
		/* if (oFileIn.addEventListener) {
		console.log(oFileIn.addEventListenerx);
		oFileIn.addEventListener('change', filePicked, true);
		} */
		tableListPreview = $('#tableListPreview').DataTable({
			// 'retrieve'      : true,
			'destroy'       : true,
			'scrollY'       : '45vh',
			// 'fixedColumns'  : false,
			'ordering'      : false,
			'paging'        : false,
			'info'          : false,
			'scrollX'		: true,
			// 'autoWidth'		: true,
			'columnDefs'    : [
				{targets: 0,className: 'text-center'},
				{targets: 1,className: 'text-center'},
				{targets: 2,className: 'text-center'},
				{targets: 3,className: 'text-center'},
				{targets: 4,className: 'text-left'},
				{targets: 5,className: 'text-left', width:'25%'},
				{targets: 6,className: 'text-right'},
				{targets: 7,className: 'text-left'},
				{targets: 8,className: 'text-left'},
				{targets: 9,className: 'text-left'},
			]
		});
		$(".dataTables_filter").css("display","none");
	});

	function filePicked(oEvent) {
		$('input[type=search]').val('').change();
		tableListPreview.clear().draw();
		// Get The File From The Input
		var oFile = oEvent.target.files[0];
		
		if (typeof(oFile) != "undefined") {
			// if (oFile.name == "Input-Nilai-Avg-Upload.xls") {
			if (oFile.type == "application/vnd.ms-excel") {
				var sFilename = oFile.name;
				// Create A File Reader HTML5
				var reader = new FileReader();

				// Ready The Event For When A File Gets Selected
				reader.onload = function(e) {
					var data = e.target.result;
					var cfb = XLS.CFB.read(data, {
						type: 'binary'
					});
					var wb = XLS.parse_xlscfb(cfb);
					// Loop Over Each Sheet
					var error = [];
					var check_merk = true;
					var result_data = [];
					tableListPreview.clear().draw();
					wb.SheetNames.forEach(function(sheetName) {
						// Obtain The Current Row As CSV
						var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);

						var oJS = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
						var row = 1;

						if (oJS[0]) {
							var header_excel = Object.keys(oJS[0]);
							if (header_excel[0] != 'Kategori') {
								dialog_warning('Notification', 'Pastikan Anda Tidak Merubah Baris Pertama dan data tidak kosong, Cek Kembali Header Kode Kategori Pada Colom A1');
							} else if (header_excel[3] != 'Kode Barang') {
								dialog_warning('Notification', 'Pastikan Anda Tidak Merubah Baris Ketiga dan data tidak kosong atau 0, Cek Kembali Header Kode Barang Pada Colom D1');
							}  else {
								oJS.forEach(function(data) {
									if (data['Kode Barang'] == null) {
										error.push(row + 1);
									} else {
											// if (!Number.isInteger(parseInt(data['HPP Akhir'])) && parseInt(data['HPP Akhir']) < 0) {
											// 	error.push(row + 1);
											// } else {
												
												// hasil_get = '';
												
												// if(data['Kategori']){
												// 	hasil_get = getKategori(data['Kategori'],data['Type'],data['Merk']);
												// }
												
												// console.log("Hasil dari PHP:", hasil_get);

												row_data = [
													row - error.length,
													'<input type="hidden" class="form-control" name="kode_kategori[]" value="' + data['Kategori'] + '">' +  data['Kategori'],
													'<input type="hidden" class="form-control" name="kode_type[]" value="' + data['Type'] + '">' + data['Type'],
													'<input type="hidden" class="form-control" name="kode_merk[]" value="' + data['Merk'] + '">' + data['Merk'],
													'<input type="hidden" class="form-control" name="kode_barang[]" value="' + data['Kode Barang'] + '">' + data['Kode Barang'],
													'<input type="hidden" class="form-control" name="nama_barang[]" value="' + data['Nama Barang'] + '">' + data['Nama Barang'],
													'<input type="hidden" class="form-control" name="harga_beli[]" value="' + data['Harga Beli'] + '">' + data['Harga Beli'],
													'<input type="hidden" class="form-control" name="tanggal_pembelian[]" value="' + data['Tanggal Pembelian'] + '">' + data['Tanggal Pembelian'],
													'<input type="hidden" class="form-control" name="keterangan_acct[]" value="' + data['Keterangan Accounting'] + '">' + data['Keterangan Accounting'],
													'<input type="hidden" class="form-control" name="serial_number[]" value="' + data['Serial Number'] + '">' + data['Serial Number'],
												];
												result_data.push(row_data);
											// }
									}
									row++;
								});

																
							}
						} else {
							dialog_warning('Notification', 'Cek Kembali File Yang Anda Pilih !');
						}
					});
					
					if (error.length) {
						dialog_warning('Notification', 'Pastikan Anda Tidak Merubah Baris Pertama, Cek Kembali data Pada Baris ( ' + error.join() +
						' )');
					} else {
						tableListPreview.rows.add(result_data).draw();
					}
				};
				// Tell JS To Start Reading The File.. You could delay this if desired
				reader.readAsBinaryString(oFile);
			} else {
				dialog_warning('Notification', 'Pastikan anda mengunakan File yang telah di download dan tidak merubah nama file !');
			}
		}else{
			dialog_warning('Notification', 'File Tidak Bisa Dibaca, Silahkan Refresh lagi !');
		}


	}


	function sendData(kats,types,merks) {
        const value = document.getElementById("myInput").value;

        //Use jQuery for AJAX request
        $.ajax({
            url: "<?php echo base_url('controller/method'); ?>", // Replace with your controller and method
            type: "POST", // Or "GET" depending on your needs
            data: { data: value }, // Send the value as data
            success: function(response) {
                // Handle the response from the controller
                console.log(response);
            },
            error: function(xhr, status, error) {
               // Handle errors
               console.error(error);
            }
        });
    }

	// Memanggil fungsi kirimData  async
	async function getKategori(kats,types,merks) {
		var data = {
			kategori_id: kats,
			type_id: types,
			merk_id: merks,
		};

		var url = '<?php echo base_url()?>/master/barang/getDataImport'; // File PHP yang akan menerima data
		try {
			var hasil = await kirimData(data, url);

			return hasil;
		} catch (error) {
			console.error("Terjadi kesalahan:", error);
		}
	}

	function kirimData(data, url) {
		return new Promise((resolve, reject) => {
			fetch(url, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
			.then(response => {
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}
				return response.json();
			})
			.then(data => {
				resolve(data);
			})
			.catch(error => {
				reject(error);
			});
		});
	}

</script>