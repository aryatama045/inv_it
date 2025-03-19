



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

        <!-- Content Start -->
		<div class="card">
			<div class="card-body">
                <h3 class="pb-0">Form  <?= $function ?> - <?= $pagetitle ?></h3>
                <hr class="mb-2">

                <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/edit/'.$param['kode_barang']); ?>" method="POST">

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Kategori<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="kode_kategori" id="kategori" required disabled>
                                <?php $kode_kategori = $this->Model_global->getKategori($param['kode_kategori']); ?>
                                <option value="<?= $kode_kategori['kode_kategori'] ?>"> -- <?= $kode_kategori['kode_kategori'].'-'.$kode_kategori['nama'] ?> --</option>

                                <?php $Kategori = $this->Model_global->getKategori();
                                foreach ($Kategori as $key => $val) { ?>
                                    <option value="<?= $val['kode_kategori'] ?>" > <?= $val['kode_kategori'].' - '.$val['nama'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-black "> *Jika Pilih Tidak Ada Kategori, Silahkan Input Manual Kode Barang</span>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Merk<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="kode_merk" id="merk" required>
                                <?php $kode_merk = $this->Model_global->getMerk($param['kode_merk']); ?>
                                <option value="<?= $kode_merk['kode_merk'] ?>"> -- <?= $kode_merk['kode_merk'].'-'.$kode_merk['nama'] ?> --</option>

                                <?php $Merk = $this->Model_global->getMerk();
                                foreach ($Merk as $key => $val) { ?>
                                    <option value="<?= $val['kode_merk'] ?>" ><?= $val['kode_merk'].' - '.$val['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Type<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="kode_type" id="type" required>
                                <?php $kode_type = $this->Model_global->getType($param['kode_type']); ?>
                                <option value="<?= $kode_type['kode_type'] ?>"> -- <?= $kode_type['kode_type'].'-'.$kode_type['nama'] ?> --</option>

                                <?php $Type = $this->Model_global->getType();
                                foreach ($Type as $key => $val) { ?>
                                    <option value="<?= $val['kode_type'] ?>" ><?= $val['kode_type'].' - '.$val['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Kode Barang<span style="color:red">*</span></strong></label>
                            <input type="text" class="form-control" required name="kode_barang"  value="<?= $param['kode_barang'] ?>"  readonly/>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Nama Barang<span style="color:red">*</span></strong></label>
                            <input type="text" class="form-control" required name="nama_barang" value="<?= $param['nama_barang'] ?>" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Serial Number<span style="color:red">*</span></strong></label>
                            <input type="text" class="form-control" required name="serial_number" value="<?= $param['serial_number'] ?>" />
                        </div>
                    </div>

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Tanggal Pembelian <span style="color:red">*</span></strong></label>
                            <input class="form-control" name="tanggal_pembelian" value=<?= date('d-m-Y', strtotime($param['tanggal_pembelian'])) ?> required id="selectTanggalAwal" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Harga Beli<span style="color:red">*</span></strong></label>
                            <input type="number" class="form-control" required name="harga_beli" value="<?= $param['harga_beli'] ?>" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Harga Asuransi<span style="color:red">*</span></strong></label>
                            <input type="number" class="form-control" required name="harga_asuransi" value="<?= $param['harga_asuransi'] ?>" />
                        </div>
                    </div>

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-6 ">
                            <label class="form-label text-black"><strong> Keterangan</strong></label>
                            <textarea name="keterangan" row="3" class="form-control" ><?= $param['keterangan'] ?></textarea>
                        </div>

                        <div class="col-12 col-md-6 ">
                            <label class="form-label text-black"><strong> Keterangan Accounting</strong></label>
                            <textarea name="keterangan_acct" row="3" class="form-control" ><?= $param['keterangan_acct'] ?></textarea>
                        </div>
                    </div>

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Lokasi Akhir<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="lokasi_terakhir" id="lokasi_terakhir" required>
                                <?php $Lokasi_terakhir = $this->Model_global->getPersonil($param['lokasi_terakhir']); ?>
                                <option value="<?= $Lokasi_terakhir['nip'] ?>"> -- <?= $Lokasi_terakhir['nip'].'-'.$Lokasi_terakhir['nama'] ?> --</option>
                                <?php $getLokasi = $this->Model_global->getPersonil();
                                foreach ($getLokasi as $key => $val) { ?>
                                    <?php if($val['nip'] == 0){ ?>
                                        <option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Status Stock<span style="color:red">*</span></strong></label>
                            <div class="form-group">
                                <input type="radio" class="btn-check barang_stock" id="withStock" value="True" name="barang_stock" <?= ($param['barang_stock']=='True')?'checked':'' ?>>
                                <label class="btn btn-outline-primary" for="withStock">With Stock</label>
                                <input type="radio" class="btn-check barang_stock" id="withoutStock" value="False" name="barang_stock" <?= ($param['barang_stock']=='False')?'checked':'' ?>>
                                <label class="btn btn-outline-primary" for="withoutStock">Without Stock</label>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row p-1 m-1">
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary"><i data-acorn-icon="save"></i> Simpan</button>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="form-check-label" ><strong> Note : </strong><span style="color:red">*</span> Wajib</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Content End -->
    </div>
</div>


<script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>

<script type="text/javascript">

    var base_url  = '<?php echo base_url()?>';

    $(document).ready(function() {

        $('.select2-single').select2();

        $('#kategori').on('change', function (e) {
            var id = $('[name=kategori]').val();
            $.ajax({
                url         : base_url + 'master/barang/getKodeBarang',
                method      : "POST",
                data        : { id: id },
                async       : true,
                dataType    : "json",
                success: function(data) {
                    $('[name=kode_barang]').val(data.kode);
                }
            });
            return false;
        });
    });

    (function() {
        var textField = document.getElementById('serial_number');

        if(textField) {
            textField.addEventListener('keydown', function(mozEvent) {
                var event = window.event || mozEvent;
                if(event.keyCode === 13) {
                    event.preventDefault();
                }
            });
        }
    })();

</script>
