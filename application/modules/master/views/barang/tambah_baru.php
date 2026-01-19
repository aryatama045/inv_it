
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

        <?php $this->load->view('templates/notif') ?>

        <!-- Content Start -->
		<div class="card">
			<div class="card-body">
                
                <h3 class="border-bottom pb-2 mb-2">Form  <?= $function ?> </h3>

                <form id="formTambah" class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah_baru'); ?>" method="POST">

                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Nomor Dokumen</strong></label>
                            <input type="text" disabled class="form-control" placeholder="<?= $new_nomor_transaksi ?>"/>
                        </div>

                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Jenis Dokumen<span style="color:red">*</span></strong></label>
                            <select class="form-control kd_dokumen" name="kd_dokumen" id="kd_dokumen" readonly>
                                <option value="IN" selected>IN - Terima</option>
                            </select>

                        </div>
                    </div>

                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Tanggal Proses <span style="color:red">*</span></strong></label>
                            <input class="form-control" name="tanggal_pengiriman" value=<?= date('d-m-Y') ?> required id="selectTanggalAwal" />
                        </div>

                        <div class="col-12 col-md-6" >
                            <label class="form-label text-black"><strong>Tanggal Dokumen</strong></label>
                            <input class="form-control" readonly name="tanggal" value=<?= date('d-m-Y') ?> />
                        </div>
                    </div>

                    <div class="row p-2 m-2">
                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Pengirim<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="pengirim" id="pengirim" required>
                                <option value=""> -- Select Pengirim --</option>
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

                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Penerima<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="penerima" id="penerima" required>
                                <option value=""> -- Select Tujuan --</option>
                                <?php $Personil2 = $this->Model_global->getPersonil();
                                foreach ($Personil2 as $key => $val) { ?>
                                    <?php if($val['nip'] == 0){ ?>
                                        <option value="<?= $val['kd_store'] ?>" ><?= $val['kd_store'].'-'.$val['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $val['nip'] ?>" ><?= $val['nip'].'-'.$val['nama'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-4" >
                            <label class="form-label text-black"><strong>Tujuan<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="tujuan" id="tujuan" disabled>
                                <option value="ho_it" selected> HO IT</option>
                            </select>
                        </div>
                    </div>

                    <div class="row p-2 m-2 mb-5">
                        <div class="col-12 ">
                            <label class="form-label text-black"><strong> Keterangan</strong></label>
                            <textarea name="keterangan_header" row="3" class="form-control" placeholder="Input Keterangan"></textarea>
                        </div>
                    </div>

                    <h3 class="border-bottom mb-0 pb-2">Data Barang</h3>

                    <table id="tableListBKB" class="table table-bordered data-table data-table-pagination  responsive nowrap stripe w-100">
                        <thead>
                            <th class="text-left">No.</th>
                            <th class="text-left">Spesifikasi</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Serial Number</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center"> </th>
                        </thead>
                    </table>

                    <div class="mb-3 pb-3 border-bottom text-center">
                        <a onclick='addRow()'  class="btn btn-sm btn-icon btn-icon-start btn-primary addRow">    
                            <i data-acorn-icon="plus"></i>
                            <span>Add New</span>
                        </a>
                    </div>
                    
                    <div class="col-12 mt-5">
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


<!-- modal datatable item list -->
<?php $kategoriList = $this->Model_global->getKategori(); ?>
<div class="modal fade" tabindex="-1" role="dialog" id="showItemData">
    <div class="modal-dialog modal-xl" role="document" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-black" >GENERATE DATA BARANG</h3>
            </div>
            <div class="card-body">
                <div class="row p-2 m-2 mb-2">
                    <div class="col-3 text-center">
                        <label class="form-label text-black"><strong>Jenis Stock<span style="color:red">*</span></strong></label>
                        <select class="form-select select2-single" name="jenis_stock" id="jenis_stock">
                            <option value=""> -- Select Jenis Stock --</option>
                            <option value="S"> STOCK</option>
                            <option value="QTY"> QTY</option>
                        </select>
                    </div>

                    <div class="col-3 text-center">
                        <label class="form-label text-black"><strong>Kategori<span style="color:red">*</span></strong></label>
                        <select class="form-select select2-single" name="kategori" id="kategori">
                            <option value=""> -- Select Kategori --</option>
                            <?php foreach ($kategoriList as $key => $val) { ?>
                                <option value="<?= $val['kode_kategori'] ?>" data-jenis="<?= $val['jenis'] ?>"><?= $val['kode_kategori'].'-'.$val['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-3 text-center">
                        <div class="form-group ">
                            <label class="form-label text-black"><strong>Merk<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="merk" id="merk">
                                <option value=""> -- Select Merk --</option>
                                <?php $merk = $this->Model_global->getMerk();
                                    foreach ($merk as $key => $val) { ?>
                                    <option value="<?= $val['kode_merk'] ?>" ><?= $val['kode_merk'].'-'.$val['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-3 text-center">
                        <div class="form-group ">
                            <label class="form-label text-black"><strong>Type<span style="color:red">*</span></strong></label>
                            <select class="form-select select2-single" name="type" id="type">
                                <option value=""> -- Select Type --</option>
                                <?php $type = $this->Model_global->getType();
                                    foreach ($type as $key => $val) { ?>
                                    <option value="<?= $val['kode_type'] ?>" ><?= $val['kode_type'].'-'.$val['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row p-2 m-2 mb-5">

                    <div class="col-3 text-center">
                        <div class="form-group ">
                            <label class="form-label text-black"><strong>Nomor Pembelian<span style="color:red">*</span></strong></label>
                            <input name="nomor_pembelian" type="text" class="form-control" id="nomor_pembelian" placeholder="Input Nomor Pembelian">
                        </div>
                    </div>

                    <div class="col-3 text-center" >
                        <label class="form-label text-black"><strong>Tanggal Pembelian <span style="color:red">*</span></strong></label>
                        <input class="form-control" name="tanggal_pembelian_modal" value=<?= date('d-m-Y') ?> id="tanggal_pembelian_modal" />
                    </div>
                    
                    <div class="col-3 text-center">
                        <div class="form-group ">
                            <label class="form-label text-black"><strong>Qty Beli<span style="color:red">*</span></strong></label>
                            <input name="qty_beli" type="number" class="form-control" id="qty_beli" min="1" value="1">
                        </div>
                    </div>

                    <div class="col-3 text-center">
                        <div class="form-group ">
                            <label class="form-label text-black"><strong>Harga Beli /Item<span style="color:red">*</span></strong></label>
                            <input name="harga_beli" type="number" class="form-control" id="harga_beli" min="0" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                    <i data-acorn-icon="close"></i>
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="btnGenerate" onclick="generateToTable()">
                    <i data-acorn-icon="check"></i>
                    Generate
                </button>
            </div>
        </div>
    </div>
</div>
<!-- modal datatable item list -->



<script src="<?= base_url('assets/js/jquery-2.2.0.min.js') ?>"></script>


<script type="text/javascript">
var base_url  = '<?php echo base_url()?>';
var tableListBKB;
var action = 'Tambah';
var timer;
var jns_kode='';
var kategoriData = <?php echo json_encode($kategoriList, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
// Menyimpan base suffix awal per kategori (untuk jenis S) agar re-flow selalu mulai dari awal batch
var kodeBasePerKategori = {};

function populateKategoriOptions(selectedJenis) {
    var $kategoriSelect = $('#kategori');
    var currentValue = $kategoriSelect.val();
    var placeholder = '<option value=""> -- Select Kategori --</option>';

    $kategoriSelect.empty().append(placeholder);

    if (!Array.isArray(kategoriData)) {
        kategoriData = [];
    }

    var filteredData = kategoriData.filter(function(item) {
        if (!selectedJenis || selectedJenis === '') {
            return true;
        }
        if (!item || typeof item !== 'object') {
            return false;
        }
        return item.jenis === selectedJenis;
    });

    filteredData.forEach(function(item) {
        if (!item) {
            return;
        }
        var kode = item.kode_kategori || '';
        var nama = item.nama || '';
        var namaClean = nama.replace(/\r?\n/g, '').trim();
        var jenis = item.jenis || '';
        var optionText = kode + '-' + namaClean;
        var $option = $('<option></option>')
            .val(kode)
            .attr('data-jenis', jenis)
            .text(optionText);
        $kategoriSelect.append($option);
    });

    if (filteredData.some(function(item) { return item && item.kode_kategori === currentValue; })) {
        $kategoriSelect.val(currentValue);
    } else {
        $kategoriSelect.val('');
    }

    if ($kategoriSelect.hasClass('select2-hidden-accessible')) {
        $kategoriSelect.trigger('change.select2');
    } else {
        $kategoriSelect.trigger('change');
    }
}

$(document).ready(function() {

    $('.select2-single').select2();

    $('#jenis_stock').on('change', function() {
        var selectedJenis = $(this).val();
        populateKategoriOptions(selectedJenis);
    });

    // Inisialisasi ulang select2 saat modal dibuka
    $('#showItemData').on('shown.bs.modal', function () {
        $('#jenis_stock').select2({
            dropdownParent: $('#showItemData'),
            // width: '100%'
        });

        $('#kategori').select2({
            dropdownParent: $('#showItemData'),
            // width: '100%'
        });

        populateKategoriOptions($('#jenis_stock').val());

        $('#merk').select2({
            dropdownParent: $('#showItemData'),
            // width: '100%'
        });

        $('#type').select2({
            dropdownParent: $('#showItemData'),
            // width: '100%'
        });

        // Inisialisasi datepicker untuk tanggal pembelian di modal
        $('#tanggal_pembelian_modal').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

    });

    // Reset form saat modal ditutup
    $('#showItemData').on('hidden.bs.modal', function () {
        $('#jenis_stock').val('').trigger('change');
        $('#merk').val('').trigger('change');
        $('#type').val('').trigger('change');
        $('#nomor_pembelian').val('');
        $('#tanggal_pembelian_modal').val('<?= date('d-m-Y') ?>');
        $('#qty_beli').val('1');
        $('#harga_beli').val('0');
        populateKategoriOptions('');
    });

    $(".kd_dokumen").change(function () {
        jns_kode = $(this).val();

        //clear datatable
        tableListBKB.clear().draw();

    });

    /* Inisialisasi Table List BKB */
    tableListBKB = $('#tableListBKB').DataTable({
        // 'orderCellsTop' : true,
        // 'fixedHeader'   : true,
        // 'processing'    : true,
        'ordering'      : false,
        'bPaginate'     : false,
        'bLengthChange' : false,
        'bFilter'       : false,
        'bInfo'         : false,
        'bAutoWidth'    : false,
        'columnDefs'    : [
            {targets: 0,className: 'text-center'},
            {targets: 1,className: 'text-left'},
            {targets: 2,className: 'text-left'},
            {targets: 3,className: 'text-center'},
            {targets: 4,className: 'text-center', width:'15%'},
            {targets: 5,className: 'text-center'},
        ]
    });
    /* End Inisialisasi Table List BKB */

    /* Action Form Submit */
    $("#formTambah").unbind('submit').on('submit', function() {
        dialog_submit('Notification',"Simpan !!");

        $('#btn-submit').click(function() {
            document.getElementById('formTambah').submit();
        });

        return false;
    });

    /* Event handler untuk auto-focus serial number ke field dibawahnya */
    $(document).on('keydown', 'input[name="serial_number[]"]', function(e) {
        var currentInput = $(this);
        
        // Cek jika user menekan Enter (untuk submit manual input)
        if(e.which === 13) {
            e.preventDefault();
            
            var currentValue = currentInput.val().trim();
            
            // Jika field kosong, jangan pindah
            if(currentValue === '') {
                return false;
            }
            
            // Cari semua input serial number
            var allSerialInputs = $('input[name="serial_number[]"]');
            var currentIndex = allSerialInputs.index(this);
            
            // Pindah ke input serial number berikutnya
            if(currentIndex < allSerialInputs.length - 1) {
                allSerialInputs.eq(currentIndex + 1).focus().select();
            } else {
                // Jika sudah di field terakhir, blur/unfocus
                currentInput.blur();
            }
            
            return false;
        }
        
        // Cek jika user menekan Tab untuk navigasi manual
        if(e.which === 9) {
            // Biarkan tab berfungsi normal, tidak auto-move
            return true;
        }
    });

    /* Event handler khusus untuk barcode scanner */
    $(document).on('input', 'input[name="serial_number[]"]', function(e) {
        var currentInput = $(this);
        var currentValue = currentInput.val().trim();
        
        // Tandai waktu mulai input
        if(!currentInput.data('inputStartTime')) {
            currentInput.data('inputStartTime', Date.now());
        }
        
        // Clear timeout sebelumnya jika ada
        if(currentInput.data('scanTimeout')) {
            clearTimeout(currentInput.data('scanTimeout'));
        }
        
        // Set timeout untuk deteksi selesai scan
        var scanTimeout = setTimeout(function() {
            var inputDuration = Date.now() - currentInput.data('inputStartTime');
            
            // Jika input sangat cepat (<200ms untuk >5 karakter), kemungkinan barcode scanner
            // Scanner biasanya input dalam 50-150ms
            if(inputDuration < 150 && currentValue.length >= 5) {
                // Auto pindah ke field berikutnya (untuk barcode scanner)
                var allSerialInputs = $('input[name="serial_number[]"]');
                var currentIndex = allSerialInputs.index(currentInput);
                
                if(currentIndex < allSerialInputs.length - 1) {
                    allSerialInputs.eq(currentIndex + 1).focus().select();
                }
            }
            
            // Reset timer
            currentInput.removeData('inputStartTime');
            currentInput.removeData('scanTimeout');
            
        }, 150); // Delay 150ms untuk memastikan scan selesai
        
        currentInput.data('scanTimeout', scanTimeout);
    });

});

/* Action Button Add (+) Clicked*/
function addRow(){
    var validasi = validasi_add_item();
    if(validasi){
        $('#showItemData').modal('show');
    }
}
/* End Action Button Add (+) Clicked*/

/* Validation Before addRow() */
function validasi_add_item(){


    if($('.kd_dokumen').val() == ""){
        // alert('Pilih Jenis Dokumen Terlebih Dahulu');
        dialog_warning('Notification',"Pilih Jenis Dokumen Terlebih Dahulu");
        return false;
    }
    // if($('#pengirim').val() == ""){
    //     // alert('Pilih Pengirim Terlebih Dahulu');
    //     dialog_warning('Notification',"Pilih Pengirim Terlebih Dahulu");
    //     return false;
    // }
    // if($('#penerima').val() == ""){
    //     // alert('Pilih Tujuan Terlebih Dahulu');
    //     dialog_warning('Notification',"Pilih Penerima Terlebih Dahulu");
    //     return false;
    // }
    if($('#tujuan').val() == ""){
        // alert('Pilih Tujuan Terlebih Dahulu');
        dialog_warning('Notification',"Pilih Tujuan Terlebih Dahulu");
        return false;
    }

    return true;
}
/* End Validation Before addRow() */

/* Action Saat tombol delete di click */
function deleteRow(no_urut, kd_brg){
    // Konfirmasi sebelum delete
    // if(!dialog_warning('Notification',"Pilih Jenis Dokumen Terlebih Dahulu")) {
    //     return false;
    // }

    //  dialog_warning('Notification',"Pilih Jenis Dokumen Terlebih Dahulu");
    
    // Hapus row yang dipilih
    tableListBKB.row(no_urut - 1).remove().draw(false);
    
    // Re-index semua nomor urut setelah delete
    var data = tableListBKB.rows().data();
    for (let index = 0; index < data.length; index++) {
        var new_no_urut = index + 1;
        
        // Update nomor urut di kolom pertama (column 0)
        var append_1 = "<input type='hidden' name='urut[]' id='urut_"+new_no_urut+"' value='"+new_no_urut+"' />" + new_no_urut;
        
        // Update tombol delete di kolom terakhir (column 5) dengan nomor urut baru
        var append_2 = '<button type="button" class="btn btn-danger" onclick="deleteRow('+new_no_urut+',\'\')"><i class="fa fa-trash"></i></button>';
        
        tableListBKB.cell({row:index, column:0}).data(append_1);
        tableListBKB.cell({row:index, column:6}).data(append_2);
    }
    
    // Redraw table untuk update tampilan
    tableListBKB.draw(false);
    
    // Re-flow kode barang untuk jenis S agar tidak ada loncatan setelah delete
    reflowKodeBarangSequences();

    // Disable autocomplete
    $("input[type=text]").attr("autocomplete", "off");
}
/* End Action Saat tombol delete di click */

/* Re-flow kode barang per kategori untuk jenis S agar berurutan setelah ada delete */
function reflowKodeBarangSequences(){
    try {
        var groups = {}; // kategori => array of {rowIdx, padLen, suffixNum}
        var idxes = tableListBKB.rows({ order: 'applied' }).indexes();
        idxes.each(function(rowIdx){
            var cellNode = tableListBKB.cell(rowIdx, 1).node(); // kolom Spesifikasi
            var $cell = $(cellNode);
            var kategori = $cell.find('input[name="kode_kategori[]"]').val();
            var barangStock = $cell.find('input[name="barang_stock[]"]').val();
            var $kbInput = $cell.find('input[name="kode_barang[]"]');
            if(!$kbInput.length) return; // baris lama tanpa field ini
            if(barangStock !== 'False') return; // hanya untuk jenis S (stock item)
            var kb = $kbInput.val() || '';
            if(!kategori || kb.indexOf(kategori) !== 0) return;
            var suffix = kb.substring(kategori.length);
            var num = parseInt((suffix || '').replace(/[^0-9]/g, ''), 10);
            var padLen = (suffix || '').length || 3;
            if(!groups[kategori]) groups[kategori] = [];
            groups[kategori].push({ rowIdx: rowIdx, padLen: padLen, suffixNum: isNaN(num) ? 0 : num });
        });

        Object.keys(groups).forEach(function(kat){
            var arr = groups[kat];
            if(arr.length === 0){
                if(typeof kodeBasePerKategori[kat] !== 'undefined'){
                    delete kodeBasePerKategori[kat];
                }
                return;
            }
            if(arr.length === 1){
                // Tetap update pad/format jika perlu, tapi tidak perlu re-flow keseluruhan
                var onlyIdx = arr[0].rowIdx;
                var startNumSingle = (typeof kodeBasePerKategori[kat] !== 'undefined') ? Math.max(1, parseInt(kodeBasePerKategori[kat],10)||1) : (arr[0].suffixNum>0?arr[0].suffixNum:1);
                var padWsingle = Math.max(3, arr[0].padLen, (startNumSingle+'').length);
                var newKodeSingle = kat + String(startNumSingle).padStart(padWsingle, '0');
                var $cellSingle = $(tableListBKB.cell(onlyIdx, 1).node());
                $cellSingle.find('input[name="kode_barang[]"]').val(newKodeSingle);
                var $kbSpanSingle = $cellSingle.find('span.badge');
                if($kbSpanSingle.length){ $kbSpanSingle.text(newKodeSingle); }
                tableListBKB.cell(onlyIdx, 1).invalidate('dom');
                return;
            }

            // Tentukan starting number dari base tersimpan; fallback ke min suffix
            var padW = 3;
            arr.forEach(function(it){ padW = Math.max(padW, it.padLen); });
            var startNum;
            if(typeof kodeBasePerKategori[kat] !== 'undefined'){
                startNum = Math.max(1, parseInt(kodeBasePerKategori[kat], 10) || 1);
            } else {
                var min = Infinity;
                arr.forEach(function(it){ if(it.suffixNum > 0 && it.suffixNum < min) min = it.suffixNum; });
                startNum = isFinite(min) ? min : 1;
            }
            padW = Math.max(padW, (startNum+'').length);

            for(var i=0;i<arr.length;i++){
                var rowIdx = arr[i].rowIdx;
                var newNum = startNum + i;
                var newSuffix = String(newNum).padStart(padW, '0');
                var newKode = kat + newSuffix;

                var $cell = $(tableListBKB.cell(rowIdx, 1).node());
                var $kbInput = $cell.find('input[name="kode_barang[]"]');
                $kbInput.val(newKode);
                var $kbSpan = $cell.find('span.badge');
                if($kbSpan.length){ $kbSpan.text(newKode); }
                // Beritahu DataTables bahwa DOM berubah
                tableListBKB.cell(rowIdx, 1).invalidate('dom');
            }
        });
    } catch(e) {
        // silent fail agar tidak mengganggu input
        // console.warn('reflowKodeBarangSequences error', e);
    }
}

/* Function untuk generate data dari modal ke datatable */
function generateToTable() {
    // Validasi input di modal
    var jenis_stock = $('#jenis_stock').val();
    var kategori = $('#kategori').val();
    var merk = $('#merk').val();
    var type = $('#type').val();
    var nomor_pembelian = $('#nomor_pembelian').val();
    var tanggal_pembelian = $('#tanggal_pembelian_modal').val();
    var qty_beli = parseInt($('#qty_beli').val());
    var harga_beli = $('#harga_beli').val();

    // Validasi field wajib
    if(jenis_stock == "" || jenis_stock == null){
        dialog_warning('Notification', 'Pilih Jenis Stock terlebih dahulu!');
        return false;
    }
    if(kategori == "" || kategori == null){
        dialog_warning('Notification', 'Pilih Kategori terlebih dahulu!');
        return false;
    }
    if(merk == "" || merk == null){
        dialog_warning('Notification', 'Pilih Merk terlebih dahulu!');
        return false;
    }
    if(type == "" || type == null){
        dialog_warning('Notification', 'Pilih Type terlebih dahulu!');
        return false;
    }
    if(nomor_pembelian == "" || nomor_pembelian == null){
        dialog_warning('Notification', 'Input Nomor Pembelian terlebih dahulu!');
        return false;
    }
    if(qty_beli <= 0 || isNaN(qty_beli)){
        dialog_warning('Notification', 'Qty Beli harus lebih dari 0!');
        return false;
    }

    // Get text dari select option
    var kategori_text = $('#kategori option:selected').text();
    var merk_text = $('#merk option:selected').text();
    var type_text = $('#type option:selected').text();

    // Disable tombol generate sementara
    $('#btnGenerate').prop('disabled', true);

    // Hitung suffix terbesar yang sudah ada di tabel untuk kategori ini (hanya S yang relevan)
    function getExistingMaxSuffixForKategori(kat){
        var maxNum = 0;
        $('input[name="kode_barang[]"]').each(function(){
            var kb = $(this).val() || '';
            if(kb.indexOf(kat) === 0){
                var suf = kb.substring(kat.length);
                // ambil hanya digit di suffix
                var num = parseInt(suf.replace(/[^0-9]/g, ''), 10);
                if(!isNaN(num) && num > maxNum){ maxNum = num; }
            }
        });
        return maxNum;
    }

    var existingMax = 0;
    if(jenis_stock === 'S'){
        existingMax = getExistingMaxSuffixForKategori(kategori);
    }

    // Ambil kode barang dari server sesuai aturan (cek mst_barang)
    $.ajax({
        url: base_url + 'master/barang/generate_kode_batch',
        type: 'POST',
        dataType: 'json',
        data: {
            kategori: kategori,
            jenis_stock: jenis_stock,
            qty: qty_beli,
            existing_max: existingMax
        },
        success: function(resp){
            if(!resp || resp.success !== true || !Array.isArray(resp.codes)){
                dialog_warning('Notification', resp && resp.message ? resp.message : 'Gagal generate kode barang.');
                $('#btnGenerate').prop('disabled', false);
                return;
            }

            var codes = resp.codes;
            var addedCount = 0;

            if(jenis_stock === 'S'){
                // Simpan base awal per kategori dari kode pertama batch ini
                if(codes.length > 0){
                    var firstCode = codes[0] || '';
                    var sufStr = firstCode.substring(kategori.length).replace(/[^0-9]/g,'');
                    var baseInt = parseInt(sufStr || '0', 10);
                    if(!isNaN(baseInt) && baseInt > 0){
                        if(typeof kodeBasePerKategori[kategori] === 'undefined' || baseInt < kodeBasePerKategori[kategori]){
                            kodeBasePerKategori[kategori] = baseInt;
                        }
                    }
                }
                // S: tambahkan 1 row per kode (qty detail = 1)
                for(var i = 0; i < codes.length; i++){
                    var rowCount = tableListBKB.rows().count() + 1;
                    var kode_barang = codes[i];
                    var nama_barang = kategori_text.split('-')[1] + ' ' + merk_text.split('-')[1];

                    tableListBKB.row.add([
                        "<input type='hidden' name='urut[]' id='urut_"+rowCount+"' value='"+rowCount+"' />"+rowCount,

                        "<input type='hidden' name='kode_kategori[]' id='kode_kategori_"+rowCount+"' value='"+kategori+"' />" +
                        "<input type='hidden' name='kode_merk[]' id='kode_merk_"+rowCount+"' value='"+merk+"' />" +
                        "<input type='hidden' name='kode_type[]' id='kode_type_"+rowCount+"' value='"+type+"' />" + 
                        "<input type='hidden' name='tanggal_beli[]' id='tanggal_beli_"+rowCount+"' value='"+tanggal_pembelian+"' />" +
                        "<input type='hidden' name='barang_stock[]' id='barang_stock_"+rowCount+"' value='False' />" +
                        "<input type='hidden' name='qty_detail[]' id='qty_detail_"+rowCount+"' value='1' />" +
                        "<input type='hidden' name='kode_barang[]' id='kode_barang_"+rowCount+"' value='"+kode_barang+"' />" +

                        "<b>Kode Barang</b> : <span class='badge bg-primary'>"+kode_barang+"</span><br>" +
                        "<b>Kategori</b> : " + kategori_text + "<br>" +
                        "<b>Merk</b> : " + merk_text + "<br>" +
                        "<b>Type</b> : " + type_text + "<br>" +
                        "<b>Tanggal Beli</b> : " + tanggal_pembelian + "<br>" +
                        "<b>No. Pembelian</b> :  <br>" +
                        "<input class='form-control' type='text' name='nomor_pembelian[]' id='nomor_pembelian_"+rowCount+"' value='"+nomor_pembelian+"' />" +
                        "<b>Harga</b> : <br>" +
                        "<input type='number' class='form-control' name='harga_beli[]' id='harga_beli_"+rowCount+"' value='"+harga_beli+"' /> <br>" +
                        "",
                        "<input type='text' class='form-control' name='nama_barang[]' id='nama_barang_"+rowCount+"' value='"+nama_barang+"' required/>",
                        "<input type='text' class='form-control' name='serial_number[]' id='serial_number_"+rowCount+"' placeholder='Input Serial Number' />",
                        "<input type='number' class='form-control' id='qty_"+rowCount+"' value='1' disabled/>",
                        "<textarea class='form-control' name='keterangan[]' id='keterangan_"+rowCount+"' rows='2'></textarea>",
                        '<button type="button" class="btn btn-danger" onclick="deleteRow('+rowCount+',\'\')"><i class="fa fa-trash"></i></button>'
                    ]).draw(false);

                    addedCount++;
                }
            } else {
                // QTY: hanya satu row dengan qty_detail = qty_beli dan kode = KAT001
                var rowCount = tableListBKB.rows().count() + 1;
                var kode_barang = codes[0] || (kategori + '001');
                var nama_barang = kategori_text.split('-')[1] + ' ' + merk_text.split('-')[1];

                tableListBKB.row.add([
                    "<input type='hidden' name='urut[]' id='urut_"+rowCount+"' value='"+rowCount+"' />"+rowCount,

                    "<input type='hidden' name='kode_kategori[]' id='kode_kategori_"+rowCount+"' value='"+kategori+"' />" +
                    "<input type='hidden' name='kode_merk[]' id='kode_merk_"+rowCount+"' value='"+merk+"' />" +
                    "<input type='hidden' name='kode_type[]' id='kode_type_"+rowCount+"' value='"+type+"' />" + 
                    "<input type='hidden' name='tanggal_beli[]' id='tanggal_beli_"+rowCount+"' value='"+tanggal_pembelian+"' />" +
                    "<input type='hidden' name='barang_stock[]' id='barang_stock_"+rowCount+"' value='True' />" +
                    "<input type='hidden' name='qty_detail[]' id='qty_detail_"+rowCount+"' value='"+qty_beli+"' />" +
                    "<input type='hidden' name='kode_barang[]' id='kode_barang_"+rowCount+"' value='"+kode_barang+"' />" +

                    "<b>Kode Barang</b> : <span class='badge bg-primary'>"+kode_barang+"</span><br>" +
                    "<b>Kategori</b> : " + kategori_text + "<br>" +
                    "<b>Merk</b> : " + merk_text + "<br>" +
                    "<b>Type</b> : " + type_text + "<br>" +     
                    "<b>Tanggal Beli</b> : " + tanggal_pembelian + "<br>" +
                    "<b>No. Pembelian</b> :  <br>" +
                    "<input class='form-control' type='text' name='nomor_pembelian[]' id='nomor_pembelian_"+rowCount+"' value='"+nomor_pembelian+"' />" +
                    "<b>Harga</b> : <br>" +
                    "<input type='number' class='form-control' name='harga_beli[]' id='harga_beli_"+rowCount+"' value='"+harga_beli+"' /> <br>" +
                    "",
                    "<input type='text' class='form-control' name='nama_barang[]' id='nama_barang_"+rowCount+"' value='"+nama_barang+"' required/>",
                    "<input type='text' class='form-control' name='serial_number[]' id='serial_number_"+rowCount+"' placeholder='Input Serial Number' />",
                    "<input type='number' class='form-control' name='qty_detail[]' id='qty_"+rowCount+"' value='"+qty_beli+"'/>",
                    "<textarea class='form-control' name='keterangan[]' id='keterangan_"+rowCount+"' rows='2'></textarea>",
                    '<button type="button" class="btn btn-danger" onclick="deleteRow('+rowCount+',\'\')"><i class="fa fa-trash"></i></button>'
                ]).draw(false);

                addedCount = 1;
            }

            // Tutup modal setelah generate
            $('#showItemData').modal('hide');

            // Tampilkan notifikasi sukses
            if(jenis_stock === 'S'){
                dialog_success('Notification', codes.length + ' data barang berhasil ditambahkan!');
            }else{
                dialog_success('Notification', 'Data barang berhasil ditambahkan!');
            }

            // Auto focus ke serial number pertama dari data yang baru ditambahkan
            setTimeout(function() {
                var totalRows = tableListBKB.rows().count();
                var firstIndex = jenis_stock === 'S' ? (totalRows - codes.length + 1) : (totalRows);
                var firstNewSerialNumber = $('#serial_number_' + firstIndex);
                if(firstNewSerialNumber.length > 0) {
                    firstNewSerialNumber.focus().select();
                }
            }, 300);

            // Enable tombol kembali
            $('#btnGenerate').prop('disabled', false);
        },
        error: function(){
            dialog_warning('Notification', 'Terjadi kesalahan saat menghubungi server.');
            $('#btnGenerate').prop('disabled', false);
        }
    });
}
/* End Function untuk generate data dari modal ke datatable */

</script>
