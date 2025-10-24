
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
                    <div class="col-12 col-md-6">
                        <label class="form-label text-black-50"><strong>Kode Kategori<span style="color:red">*</span></strong></label>
                        <span id="kode_kategori"><input type="text" class="form-control" required  readonly name="kode_kategori" placeholder="Kode Kategori" /></span>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-black-50"><strong>Nama Kategori<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required id="nama" name="nama" placeholder="Input Nama Kategori" />
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><i data-acorn-icon="save"></i> Simpan</button>
                    </div>

                    <div class="col-12 mt-2">
                        <label class="form-check-label" ><strong> Note : </strong><span style="color:red">*</span> Wajib</label>
                    </div>
                </form>
            </div>
        </div>
        <!-- Content End -->
    </div>
</div>

<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<script>
var base_url  = '<?php echo base_url()?>';
$(document).ready(function() {

    $('#nama').on('blur', function() {
        var name = $(this).val();
        var id = ''; // untuk update
        var html = '';
        $.post(base_url+'master/kategori/check_name', {
            name: name,
            id: id
        }, function(response) {
            if (response.status == 'error') {
                // Tampilkan pesan error
                dialog_warning('Notification', response.message);
                return false;
            } 
        }, 'json');

        $.post(base_url+'master/kategori/preview_code', {
            name: name
        }, function(response) {
            if (response.status == 'success') {
                html += "<input disabled value=" + response.code + ' name="kode_kategori" class="form-control" >';
                $("#kode_kategori").html(html);
            } 
        }, 'json');

    });

});


</script>