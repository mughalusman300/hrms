<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dore jQuery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url(); ?>/public/asset/font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/public/asset/font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="<?= base_url(); ?>/public/asset/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/public/asset/css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/public/asset/css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/public/asset/css/main.css" />
</head> 

<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">
                            <p class=" text-white h2">DETAILS</p>
                            <p class="white mb-0">
                               Please use your credentials to login.
                                <br>If you are not a member, please register.
                                <a href="#" class="white">login</a>.
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">Login</h6>

                            <form method="post" action="<?= base_url();?>/Login/login_process">
                                <label class="form-group has-float-label mb-4">
                                    <input name="email" required class="form-control" />
                                    <span>E-mail</span>
                                </label>
                                
                                
                                <label class="form-group has-float-label mb-4">
                                    <input name="password" required class="form-control" type="password" placeholder="" />
                                    <span>Password</span>
                                </label>
                                <?php if ($error!=''):?>
                                <center>
                                    <p class=" alert alert-danger form-group"><?= $error;?></p>
                                <?php endif?>
                                </center>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url(); ?>/public/asset/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>/public/asset/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/public/asset/js/dore.script.js"></script>
    <script src="<?= base_url(); ?>/public/asset/js/scripts.js"></script>
</body> 
</html>