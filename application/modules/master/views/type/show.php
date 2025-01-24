
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
					<h1 class="mb-0 pb-0 display-4" id="title"> <?= $function ?> - <?= $pagetitle ?></h1>

					<?= $this->load->view('templates/breadcrumb'); ?>

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
    </div>
</div>

<!-- Content -->
<div class="row">
    <!-- Left Content -->
    <div class="col-xl-8 ">
        <!-- Info Start -->
        <div class="mb-5">
            <div class="card">
                <div class="card-body mb-n3">
                    <h4 class="text-black pb-1 border-bottom border-separator-light mb-1">Info</h4>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td width="40%">Nama Barang</td>
                                <td class="font-weight-bold"> : <?= capital(lowercase($barang['nama_barang'])) ?></td>
                            </tr>
                            <tr>
                                <td>Serial Number</td>
                                <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['serial_number'])) ?></td>
                            </tr>
                            <tr>
                                <td>Kode Barang</td>
                                <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_barang'])) ?></td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <?php $kode_kategory = $this->Model_global->getKategoriBarang($barang['kode_kategori']); ?>
                                <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_kategori'])) ?> - <?= $kode_kategory['nama_kategory'] ?></td>
                            </tr>
                            <tr>
                                <td>Merk</td>
                                <?php $kode_merk = $this->Model_global->getMerkBarang($barang['kode_merk']); ?>
                                <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_merk'])) ?> - <?= $kode_merk['nama'] ?></td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <?php $kode_type = $this->Model_global->getTypeBarang($barang['kode_type']); ?>
                                <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_type'])) ?> - <?= $kode_type['nama'] ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <?php $status_barang = $this->Model_global->getStatusBarang($barang['status_barang']); ?>
                                <td class="font-weight-bold"> : <?= $barang['status_barang'] ?> - <?= $status_barang['nama'] ?> </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="font-weight-bold">
                                    <div class="form-check form-switch mb-0">
                                        <input disabled type="checkbox" class="form-check-input" <?= ($barang['barang_stock']=='False')?'checked':'' ?> />
                                        <label class=" font-weight-bold">Barang stock</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="text-black pb-1 border-bottom border-separator-light mt-2 mb-1">Pembelian</h4>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td width="40%">Harga Asuransi</td>
                                <td class="font-weight-bold"> : <?= currency($barang['harga_asuransi']) ?></td>
                            </tr>
                            <tr>
                                <td>Harga Beli</td>
                                <td class="font-weight-bold"> : <?= currency($barang['harga_beli']) ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Beli</td>
                                <td class="font-weight-bold"> : <?= tanggal($barang['tanggal_pembelian']) ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td class="font-weight-bold"> : <?= $barang['keterangan_acct'] ?></td>
                            </tr>

                        </tbody>
                    </table>

                    <h4 class="text-black pb-1 border-bottom border-separator-light mt-2 mb-1">Lokasi Akhir</h4>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td width="40%">Lokasi</td>
                                <td class="font-weight-bold"> : <?= $barang['lokasi_terakhir'] ?> </td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td class="font-weight-bold"> : <?= $barang['tanggal_lokasi_akhir'] ?> </td>
                            </tr>
                            <tr>
                                <td>Tanggal Opname</td>
                                <td class="font-weight-bold"> : <?= tanggal($barang['opname']) ?> </td>
                            </tr>

                        </tbody>
                    </table>

                    <h4 class="text-black pb-1 border-bottom border-separator-light mt-2 mb-1">User Input</h4>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td width="40%">Created By</td>
                                <td class="font-weight-bold"> : <?= capital(lowercase($barang['user_input'])) ?></td>
                            </tr>
                            <tr>
                                <td>Created Date</td>
                                <td class="font-weight-bold"> : <?= tanggal($barang['tanggal_input']) ?></td>
                            </tr>

                        </tbody>
                    </table>


                    <!-- <div class="mb-3">
                        <div class="text-small text-muted">CREATED BY</div>
                        <div>Lisa Jackson</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-small text-muted">URL</div>
                        <div>/products/wholewheat/cornbread</div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Info End -->
    </div>
    <!-- Left Content End -->

    <!-- Right Content -->
    <div class="col-xl-4 mb-n5">

        <!-- History Start -->
        <div class="card mb-5">
            <div class="card-body">
                <h4 class="text-black pb-1 border-bottom border-separator-light mb-2">Log History</h4>
                <div class="row g-0">
                    <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                        <div class="w-100 d-flex sh-1"></div>
                        <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                            <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative"></div>
                        </div>
                        <div class="w-100 d-flex h-100 justify-content-center position-relative">
                            <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="h-100">
                            <div class="d-flex flex-column justify-content-start">
                                <div class="d-flex flex-column">
                                    <a href="#" class="heading stretched-link">Order Received</a>
                                    <div class="text-alternate">21.11.2020</div>
                                    <div class="text-muted mt-1">Biscuit donut powder sugar plum pastry. Chupa chups topping pastry halvah.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                        <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                            <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                        </div>
                        <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                            <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative"></div>
                        </div>
                        <div class="w-100 d-flex h-100 justify-content-center position-relative">
                            <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="h-100">
                            <div class="d-flex flex-column justify-content-start">
                                <div class="d-flex flex-column">
                                    <a href="#" class="heading stretched-link">Shipped</a>
                                    <div class="text-alternate">03.12.2020</div>
                                    <div class="text-muted mt-1">Apple pie cotton candy tiramisu biscuit cake muffin tootsie roll bear claw cake.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- History End -->


    </div>
    <!-- Right Content End -->

</div>
<!-- Content End -->

