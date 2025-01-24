

<h4>Data Diri</h4> <hr class="mb-2">
    <!-- No Daftar & Tanggal -->
    <div class="row g-3">
        <div class="col-md-12">
            <label class="mb-3 top-label">
                <p class="form-control"><b><?= $karyawan['nip'] ?></b></p>
                <span class="text-black text-medium"><b>NOMOR INDUK PEGAWAI (NIP)</b></span>
            </label>
        </div>
    </div>

    <!-- Nama Lengkap & Jenis Kelamin -->
    <div class="row g-3">
        <div class="col-md-12">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= $karyawan['gelar_depan'] ?> <?= capital(strtolower($karyawan['nama'])) ?> <?= $karyawan['gelar_blk'] ?>
                </p>
                <span class="text-black"><b>NAMA LENGKAP </b></span>
            </label>
        </div>
    </div>

    <!-- Agama & Kota -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($karyawan['nm_agama'])?$karyawan['nm_agama']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>AGAMA </b></span>
            </label>
        </div>

        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($karyawan['nm_kota'])?$karyawan['nm_kota']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>KOTA </b></span>
            </label>
        </div>
    </div>

    <!-- Alamat -->
    <div class="row g-3">
        <div class="col-md-12">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($karyawan['alamat'])?$karyawan['alamat']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>ALAMAT</b></span>
            </label>
        </div>
    </div>


    <div class="row g-3">
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($karyawan['status'])?$karyawan['status']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>STATUS </b></span>
            </label>
        </div>
    </div>


