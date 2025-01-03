

    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
        <div class="row">
            <!-- Title Start -->
            <div class="col-12 col-md-7">
                <a class="muted-link pb-2 d-inline-block hidden" href="#">
                    <span class="align-middle lh-1 text-small">&nbsp;</span>
                </a>
                <h1 class="mb-0 pb-0 display-4" id="title">Welcome, <?= $this->session->userdata('username'); ?> ! <br>
            </div>
            <!-- Title End -->
        </div>
    </div>
    <!-- Title and Top Buttons End -->

    <hr>

    <!-- Stats Start -->
    <div class="mb-5">
        <div class="row g-2">

            <div hidden class="div">
                <div class="col-auto col-xl-4 mb-5">
                    <div class="card w-100 sw-sm-45 sh-25 hover-img-scale-up">
                        <img src="<?= base_url('assets/'); ?>img/banner/cta-horizontal-short-1.webp" class="card-img h-100 scale" alt="card image" />
                        <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                            <div class="d-flex flex-column h-100 justify-content-between align-items-start">
                                <div style="background-color: #fffffff0;padding: 1px 9px 6px 16px;border-radius: 13px;">
                                <div class="cta-1 mb-3 mt-1 text-black w-75 w-md-100">Penerimaan Mahasiswa Baru</div>
                                <a href="#" class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                                    <i data-acorn-icon="chevron-right"></i>
                                    <span>View</span>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-auto col-xl-4 mb-5">
                    <div class="card w-100 sw-sm-45 sh-25 hover-img-scale-up">
                        <img src="<?= base_url('assets/'); ?>img/banner/cta-standard-1.webp" class="card-img h-100 scale" alt="card image" />
                        <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                            <div class="d-flex flex-column h-100 justify-content-between align-items-start">
                                <div class="cta-3 mb-5 text-black">
                                    Introduction
                                    <br />
                                    to Bread Making
                                </div>
                                <a href="#" class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                                    <i data-acorn-icon="chevron-right"></i>
                                    <span>View</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-auto col-xl-4 mb-5">
                    <div class="card w-100 sw-sm-45 sh-25 hover-img-scale-up">
                        <img src="<?= base_url('assets/'); ?>img/banner/cta-standard-1.webp" class="card-img h-100 scale" alt="card image" />
                        <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                            <div class="d-flex flex-column h-100 justify-content-between align-items-start">
                                <div class="cta-3 mb-5 text-black">
                                    Introduction
                                    <br />
                                    to Bread Making
                                </div>
                                <a href="#" class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                                    <i data-acorn-icon="chevron-right"></i>
                                    <span>View</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row g-2">
            <div class="col-md-8">
                <div class="row">

                    <section class="scroll-section">
                        <div class="card">
                            <div class="card-body scroll-out mb-n2">
                            <h3>Recent Order</h3><hr>

                            <div class="scroll sh-50">
                                <?php for ($i=0; $i < 12 ; $i++) { ?>

                                    <div class="card mb-2 sh-15 sh-md-6">
                                        <div class="card-body pt-0 pb-0 h-100">
                                            <div class="row g-0 h-100 align-content-center">
                                                <div class="col-10 col-md-4 d-flex align-items-center mb-3 mb-md-0 h-md-100">
                                                <a href="Orders.Detail.html" class="body-link stretched-link">Order #54129</a>
                                                </div>
                                                <div class="col-2 col-md-3 d-flex align-items-center text-muted mb-1 mb-md-0 justify-content-end justify-content-md-start">
                                                <span class="badge bg-outline-primary me-1">PENDING</span>
                                                </div>
                                                <div class="col-12 col-md-2 d-flex align-items-center mb-1 mb-md-0 text-alternate">
                                                <span>
                                                    <span class="text-small">$</span>
                                                    17.35
                                                </span>
                                                </div>
                                                <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-end mb-1 mb-md-0 text-alternate">Today - 13:20</div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>

                            </div>
                        </div>
                    </section>

                </div>

            </div>

            <div class="col-md-4">
                <div class="card w-100 sh-50 mb-5">
                    <img src="<?= base_url('assets/'); ?>img/banner/cta-square-4.webp" class="card-img h-100" alt="card image" />
                    <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                        <h3 class="text-title mb-2"> Data Master</h3>
                        <div class="d-flex flex-column h-100 justify-content-between align-items-start">
                            <div>
                                <a href="#">
                                    <div class="cta-1 text-primary mb-0">124</div>
                                    <div class="lh-1-25 mb-0">Data Barang</div>
                                </a>
                            </div>
                            <div>
                                <a href="#">
                                    <div class="cta-1 text-primary mb-0">64</div>
                                    <div class="lh-1-25 mb-0">Data Kategori</div>
                                </a>
                            </div>
                            <div>
                                <div class="cta-1 text-primary mb-0">34</div>
                                <div class="lh-1-25 mb-0">Data Merk</div>
                            </div>
                            <div>
                                <div class="cta-1 text-primary mb-0">23</div>
                                <div class="lh-1-25 mb-0">Data Type</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Today's Orders End -->
            </div>
        </div>
    </div>
    <!-- Stats End -->

    <script src="<?= base_url('assets/') ?>js/base/searchD.js"></script>
