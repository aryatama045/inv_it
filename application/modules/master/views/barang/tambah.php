
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

                <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Kategori<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="kategori" id="kategori" required>
                                <option value=""> -- Select Kategori --</option>
                                <?php $Kategori = $this->Model_global->getKategori();
                                foreach ($Kategori as $key => $val) { ?>
                                    <option value="<?= $val['kode_kategori'] ?>" > <?= $val['kode_kategori'].' - '.$val['nama'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-black "> *Jika Pilih Tidak Ada Kategori, Silahkan Input Manual Kode Barang</span>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Merk<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="merk" id="merk" required>
                                <option value=""> -- Select Merk --</option>
                                <?php $Merk = $this->Model_global->getMerk();
                                foreach ($Merk as $key => $val) { ?>
                                    <option value="<?= $val['kode_merk'] ?>" ><?= $val['kode_merk'].' - '.$val['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Type<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="type" id="type" required>
                                <option value=""> -- Select Type --</option>
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
                            <input type="text" class="form-control" required name="kode_barang"  placeholder="Input Kode Barang" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Nama Barang<span style="color:red">*</span></strong></label>
                            <input type="text" class="form-control" required name="nama_barang" placeholder="Input Nama Barang" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Serial Number<span style="color:red">*</span></strong></label>
                            <input type="text" class="form-control" required name="serial_number" placeholder="Input Serial Number" />
                        </div>
                    </div>

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Tanggal Pembelian <span style="color:red">*</span></strong></label>
                            <input class="form-control" name="tanggal_pembelian" value=<?= date('d-m-Y') ?> required id="selectTanggalAwal" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Harga Beli<span style="color:red">*</span></strong></label>
                            <input type="number" class="form-control" required name="harga_beli" value="0" />
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Harga Asuransi<span style="color:red">*</span></strong></label>
                            <input type="number" class="form-control" required name="harga_asuransi" value="0" />
                        </div>
                    </div>

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-6 ">
                            <label class="form-label text-black"><strong> Keterangan</strong></label>
                            <textarea name="keterangan" row="3" class="form-control" placeholder="Input Keterangan"></textarea>
                        </div>

                        <div class="col-12 col-md-6 ">
                            <label class="form-label text-black"><strong> Keterangan Accounting</strong></label>
                            <textarea name="keterangan_acct" row="3" class="form-control" placeholder="Input Keterangan Accounting"></textarea>
                        </div>
                    </div>

                    <div class="row p-1 m-1">
                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Saldo Awal<span style="color:red">*</span></strong></label>
                            <input type="number" class="form-control" required name="saldo_awal" value="0" />
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label text-black"><strong>Status Stock<span style="color:red">*</span></strong></label>
                            <div class="form-group">
                                <input type="radio" class="btn-check barang_stock" id="withStock" value="True" name="barang_stock" checked>
                                <label class="btn btn-outline-primary" for="withStock">With Stock</label>
                                <input type="radio" class="btn-check barang_stock" id="withoutStock" value="False" name="barang_stock">
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
