<?php
    error_reporting(1);
    ini_set('display_errors','on');
    ini_set('display_errors',1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>INV IT | Login Page</title>
    <meta name="description" content="Login Page" />

    <!-- Favicon Tags Start -->
    <link rel="shortcut icon" href="https://place-hold.it/100x100/00362b/fff/fff?text=INV IT&fontsize=30&bold" type="image/x-icon" >
    <link rel="icon" type="image/png" href="https://place-hold.it/128x128/00362b/fff/fff?text=INV IT&fontsize=30&bold" sizes="128x128" />
    <meta name="application-name" content="INV IT" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <!-- Favicon Tags End -->

    <!-- Font Tags Start -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/') ?>font/CS-Interface/style.css" />
    <!-- Font Tags End -->

    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/OverlayScrollbars.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Vendor Styles End -->

    <!-- Template Base Styles Start -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/styles.css" />
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/main.css" />
    <!-- Template Base Styles End -->


    <style>
        .fa-eye{
            position: absolute;
            top: 34%;
            right: 4%;
            cursor: pointer;
            color: #7c7676;
        }
        .fa-eye-slash{
            position: absolute;
            top: 34%;
            right: 4%;
            cursor: pointer;
            color: #7c7676;
        }
        .logo-default-login{
            background-image: url("https://place-hold.it/150x75/00362b/fff/fff?text=INV IT&fontsize=20&bold");
            width: 150px;
            min-height: 75px;
            object-position: left;
            object-fit: cover;
            background-repeat: no-repeat;
        }

    </style>
    <script src="<?= base_url('assets/') ?>js/base/loader.js"></script>
</head>

<body class="h-100">
    <!-- Background Start -->
    <div class="fixed-background"></div>
    <!-- Background End -->


    <div id="root" class="h-100">


        <div class="container-fluid p-0 h-100 position-relative">
            <div class="row g-0 h-100">

            <!-- Left Side Start -->
            <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
                <div class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-left-border">
                    <div class="sw-lg-50 px-5">
                        <div class="sh-11">
                        <a href="#">
                            <div class="logo-default-login"></div>
                        </a>
                        </div>
                        <div class="mb-5">
                            <p class="h6">Please use your credentials to login.</p>
                            <!-- <p class="h6">
                                If you are not a member, please
                                <a href="#">register</a>
                                .
                            </p> -->
                        </div>

                        <div class="mt-1 mb-3">
                        <?php $this->load->view('templates/notif') ?>

                        <div>
                            <form action="<?php echo base_url('login/index') ?>" method="post" novalidate>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-acorn-icon="email"></i>
                                    <input type="text" class="form-control" name="username" id="user" placeholder="Email / Username" autocomplete="off" required tabIndex="1" autofocus/>
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-acorn-icon="lock-on"></i>
                                    <input class="form-control pe-7" name="password" id="password" type="password" placeholder="Password" autocomplete="off" required tabIndex="2"/>
                                    <i class="fa fa-eye" onclick="showPass()" id="eye" title="Show Password"></i>
                                </div>
                                <button tabIndex="3" type="submit" class="btn btn-lg btn-primary mr-2">Login</button>
                                <!-- <a class="text-medium t-3 e-3" type="button" style="text-decoration:underline;" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropExample">Forgot?</a> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Side End -->

            <!-- Right Side Start -->
            <div class="offset-0 col-12 d-none d-lg-flex offset-md-1 col-lg h-lg-100">
                <div class="min-h-100 d-flex align-items-center">
                    <div hidden class="w-100 w-lg-75 w-xxl-50">
                        <div>
                            <div class="mb-5">
                                <h5 class="display-5 text-white">AKADEMI REFRAKSI OPTISI</h5>
                                <h1 class="display-2 text-white">LEPRINDO</h1>
                                <h2 class="display-4 text-white">J A K A R T A</h2>
                            </div>
                            <p class="h6 text-white lh-1-5 mb-5">
                                Dynamically target high-payoff intellectual capital for customized technologies. Objectively integrate emerging core competencies before
                                process-centric communities...
                            </p>
                            <div class="mb-5">
                                <!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropExample">
                                    Pendaftaran Mahasiswa Baru
                                </button> -->
                                <a href="<?= base_url('pmb'); ?>" class="btn btn-danger">
                                    Pendaftaran Mahasiswa Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Side End -->


            </div>
        </div>

    </div>

    <!-- Modal  Launch static backdrop modal-->
    <div class="modal fade" id="staticBackdropExample" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="<?php echo base_url('auth/forgot_password') ?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalForgotLabel"> Forgot Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input id="email_forgot" name="email_forgot" type="email" class="form-control" placeholder="Email" autocomplete="off" required>
                                <a href="#" class="btn btn-primary default">
                                    <i data-acorn-icon="search"></i> Check
                                </a>
                            </div>

                            <span class="mt-2" id="hasil_email"></span>

                        </div>

                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                            <button type="submit" class="btn btn-info"><i class="fa fa-envelope"></i> Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    <!-- Vendor Scripts Start -->
    <script src="<?= base_url('assets/') ?>js/vendor/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/OverlayScrollbars.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/autoComplete.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/clamp.min.js"></script>
    <script src="<?= base_url('assets/') ?>icon/acorn-icons.js"></script>
    <script src="<?= base_url('assets/') ?>icon/acorn-icons-interface.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/jquery.validate/jquery.validate.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/jquery.validate/additional-methods.min.js"></script>
    <!-- Vendor Scripts End -->

    <!-- Template Base Scripts Start -->
    <script src="<?= base_url('assets/') ?>js/base/helpers.js"></script>
    <script src="<?= base_url('assets/') ?>js/base/globals.js"></script>
    <script src="<?= base_url('assets/') ?>js/base/nav.js"></script>
    <!-- <script src="<?= base_url('assets/') ?>js/base/search.js"></script> -->
    <script src="<?= base_url('assets/') ?>js/base/settings.js"></script>
    <!-- Template Base Scripts End -->

    <!-- Page Specific Scripts Start -->
    <script src="<?= base_url('assets/') ?>js/common.js"></script>
    <script src="<?= base_url('assets/') ?>js/scripts.js"></script>
    <!-- Page Specific Scripts End -->

    <script type="text/javascript">
        $(document).ready(function() {
            $("#email_forgot").change(function() {
                var email = $("#email_forgot").val();
                //cek jika email kosong
                if (email != "") {
                    $.ajax({
                        url: "<?= base_url(); ?>auth/cek_email",
                        method: "POST",
                        data: {
                            email: email
                        },
                        success: function(data) {
                            $("#hasil_email").html(data);
                        }
                    });
                }
            });
        });
        $(document).on('keypress', 'input,select', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
                console.log($next.length);
                if (!$next.length) {
                $next = $('[tabIndex=1]');        }
                $next.focus() .click();
            }
        });


        function showPass() {
            var x = document.getElementById("password");
            var e = document.getElementById("eye");
            if (x.type === "password") {
                x.type = "text";
                e.classList = "fa fa-eye-slash";
                e.title = "Hidden";
            } else {
                x.type = "password";
                e.classList = "fa fa-eye";
                e.title = "Show Password";
            }
        }
    </script>

</body>
</html>

