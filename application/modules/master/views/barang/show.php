
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

        <?php $this->load->view('templates/notif') ?>
    </div>
</div>

<!-- Content -->
<div class="row gx-4 gy-2">
    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                aria-controls="info" aria-selected="true">DETAIL</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab"
                aria-controls="history" aria-selected="false">HISTORY</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="mutasi_rusak-tab" data-bs-toggle="tab" href="#mutasi_rusak" role="tab"
                aria-controls="mutasi_rusak" aria-selected="false">MUTASI RUSAK</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="opname-tab" data-bs-toggle="tab" href="#opname" role="tab"
                aria-controls="opname" aria-selected="false">OPNAME</a>
        </li>

    </ul>

    <div class="tab-content">

        <div class="tab-pane show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <div class="row">
                <div class="col-xl-10">

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
                                            <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['keterangan_acct'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['keterangan'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kode Barang</td>
                                            <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_barang'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kategori</td>
                                            <?php $kode_kategory = $this->Model_global->getKategori($barang['kode_kategori']); ?>
                                            <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_kategori'])) ?> - <?= $kode_kategory['nama'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Merk</td>
                                            <?php $kode_merk = $this->Model_global->getMerk($barang['kode_merk']); ?>
                                            <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_merk'])) ?> - <?= $kode_merk['nama'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <?php $kode_type = $this->Model_global->getType($barang['kode_type']); ?>
                                            <td class="font-weight-bold"> : <?= uppercase(lowercase($barang['kode_type'])) ?> - <?= $kode_type['nama'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <?php $status_barang = $this->Model_global->getStatusBarang($barang['status_barang']); ?>
                                            <td class="font-weight-bold"> : <?= $barang['status_barang'] ?> - <?= $status_barang['nama'] ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Barang Stock</td>
                                            <td class="font-weight-bold">
                                                <div class="form-check form-switch mb-0">
                                                    <input disabled type="checkbox" class="form-check-input" <?= ($barang['barang_stock']=='True')?'checked':'' ?> />
                                                    <?php
                                                        $getStock = $this->Model_global->getStockBarang($barang['kode_barang']);
                                                        $jumlahStock = $getStock['saldo_awal'] + $getStock['in'] - $getStock['out'];
                                                    ?>
                                                    <label class=" font-weight-bold"> <?= ($barang['barang_stock']=='True')?'with':'without' ?> stock <?= ($barang['barang_stock']=='True')?'('.$jumlahStock.')':'' ?></label>
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

                            </div>
                        </div>
                    </div>
                    <!-- Info End -->

                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            <div class="row">
                <div class="col-12 col-md-12">

                    <!-- History Start -->
                    <div class="card d-flex flex-row mb-4">
                        <div class="card-body">
                            <h4 class="text-black pb-1 border-bottom border-separator-light mb-2">Log History</h4>

                            <?php
                                $history = $this->Model_global->getHistoryBarang($barang['kode_barang']);
                                if($history) {
                                foreach ($history as $key => $val) { ?>

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
                                                <?php
                                                    $getPengirim    = $this->Model_global->getPersonil($val['pengirim']);
                                                    $pengirim       = $getPengirim['nip'].'-'.$getPengirim['nama'];
                                                    $getPenerima    = $this->Model_global->getPersonil($val['penerima']);
                                                    $penerima       = $getPenerima['nip'].'-'.$getPenerima['nama'];
                                                    $getTujuan    = $this->Model_global->getPersonil($val['tujuan']);
                                                    $tujuan       = ($getTujuan['nip'])?$getTujuan['nip'].'-'.$getTujuan['nama']:$getTujuan['kd_store'].'-'.$getTujuan['nama'];

                                                ?>
                                                <h4 class="text-black border-bottom border-separator-light mb-1"><b><?= $val['kode_dokumen'] ?> - <?= $val['nomor_transaksi'] ?> </b></h4>
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td width="16%">Tanggal</td>
                                                            <td class="font-weight-bold"> : <?= tanggal($val['tanggal']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td >Pengirim</td>
                                                            <td class="font-weight-bold"> : <?= $pengirim ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Penerima</td>
                                                            <td class="font-weight-bold"> : <?= $penerima ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tujuan</td>
                                                            <td class="font-weight-bold"> : <?= $tujuan ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Status</td>
                                                            <td class="font-weight-bold"> : <?= $val['status_barang_old'] ?>-<?= $val['status_old'] ?> => <?= $val['status_barang'] ?>-<?= $val['status_new'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Qty Barang</td>
                                                            <td class="font-weight-bold"> : <?= $val['qty'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td class="font-weight-bold"> : <?= $val['keterangan_barang'] ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <?php } } else {?>

                            <div class="row g-0">
                                <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4"></div>
                                <div class="col mb-4">
                                    <div class="h-100">
                                        <div class="d-flex flex-column justify-content-start">
                                            <div class="d-flex flex-column">
                                                <div class="heading stretched-link">Tidak Ada History</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }  ?>

                        </div>
                    </div>
                    <!-- History End -->

                </div>
            </div>
        </div>


        <div class="tab-pane fade" id="mutasi_rusak" role="tabpanel" aria-labelledby="mutasi_rusak-tab">
            <div class="row">
                <div class="col-12 col-md-12">

                <!-- Mutasi Rusak Start -->
                <div class="card d-flex flex-row mb-4">
                    <div class="card-body">
                        <h4 class="text-black pb-1 border-bottom border-separator-light mb-2">Log Mutasi Rusak</h4>

                        <?php
                            $mutasi = $this->Model_global->getMutasiBarang($barang['kode_barang']);
                            if($mutasi) {
                            foreach ($mutasi as $key => $val) { ?>

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
                                            <h4 class="text-black border-bottom border-separator-light mb-1">
                                                <b><a href="<?= base_url('transaksi/mutasi_rusak/show/').$val['nomor_transaksi'] ?>"> <?= $val['nomor_transaksi'] ?> </a></b>
                                            </h4>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td width="16%">Tanggal</td>
                                                        <td class="font-weight-bold"> : <?= tanggal($val['tanggal_input']) ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Status</td>
                                                        <td class="font-weight-bold"> : <?= $barang['status_barang'] ?> - <?= $status_barang['nama'] ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Qty Barang</td>
                                                        <td class="font-weight-bold"> : <?= $val['qty_in'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan</td>
                                                        <td class="font-weight-bold"> : <?= $val['keterangan_barang'] ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?php } } else {?>

                        <div class="row g-0">
                            <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4"></div>
                            <div class="col mb-4">
                                <div class="h-100">
                                    <div class="d-flex flex-column justify-content-start">
                                        <div class="d-flex flex-column">
                                            <div class="heading stretched-link">Tidak Ada Mutasi Rusak</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }  ?>

                    </div>
                </div>
                <!-- Mutasi Rusak End -->


                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="opname" role="tabpanel" aria-labelledby="opname-tab">
            <div class="row">
                <div class="col-12 col-md-12">

                <!-- Opname Start -->
                <div class="card d-flex flex-row mb-4">
                    <div class="card-body">
                        <h4 class="text-black pb-1 border-bottom border-separator-light mb-2">Log Opname</h4>

                        <?php
                            $history = $this->Model_global->getHistoryBarang($barang['kode_barang']);
                            if($history) {
                            foreach ($history as $key => $val) { ?>

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
                                            <?php
                                                $getPengirim    = $this->Model_global->getPersonil($val['pengirim']);
                                                $pengirim       = $getPengirim['nip'].'-'.$getPengirim['nama'];
                                                $getPenerima    = $this->Model_global->getPersonil($val['penerima']);
                                                $penerima       = $getPenerima['nip'].'-'.$getPenerima['nama'];
                                                $getTujuan    = $this->Model_global->getPersonil($val['tujuan']);
                                                $tujuan       = ($getTujuan['nip'])?$getTujuan['nip'].'-'.$getTujuan['nama']:$getTujuan['kd_store'].'-'.$getTujuan['nama'];

                                            ?>
                                            <h4 class="text-black border-bottom border-separator-light mb-1"><b><?= $val['kode_dokumen'] ?> - <?= $val['nomor_transaksi'] ?> </b></h4>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td width="16%">Tanggal</td>
                                                        <td class="font-weight-bold"> : <?= tanggal($val['tanggal']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Pengirim</td>
                                                        <td class="font-weight-bold"> : <?= $pengirim ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Penerima</td>
                                                        <td class="font-weight-bold"> : <?= $penerima ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tujuan</td>
                                                        <td class="font-weight-bold"> : <?= $tujuan ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td class="font-weight-bold"> : <?= $val['status_barang_old'] ?>-<?= $val['status_old'] ?> => <?= $val['status_barang'] ?>-<?= $val['status_new'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Qty Barang</td>
                                                        <td class="font-weight-bold"> : <?= $val['qty'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan</td>
                                                        <td class="font-weight-bold"> : <?= $val['keterangan_barang'] ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?php } } else {?>

                        <div class="row g-0">
                            <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4"></div>
                            <div class="col mb-4">
                                <div class="h-100">
                                    <div class="d-flex flex-column justify-content-start">
                                        <div class="d-flex flex-column">
                                            <div class="heading stretched-link">Tidak Ada History</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }  ?>

                    </div>
                </div>
                <!-- Opname End -->


                </div>
            </div>
        </div>


    </div>


</div>
<!-- Content End -->

