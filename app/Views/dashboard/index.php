<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main class="default-transition" style="opacity: 1;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Dashboard</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url();?>/home">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Library</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
        </div>


            <div class="row sortable">
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <div class="position-absolute handle card-icon">
                                <i class="simple-icon-shuffle"></i>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>/employee">
                        <div class="card-body d-flex justify-content-between align-items-center">
                        	
                            <h6 class="mb-0"><i class="iconsminds-business-man-woman"></i> Employees</h6>
                            <div>
                            	<?php echo $Employees;?>
                            </div>

                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <div class="position-absolute handle card-icon">
                                <i class="simple-icon-shuffle"></i>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>/dep">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            
                            <h6 class="mb-0"> <i class="iconsminds-museum"></i> Departments</h6>
                            <div>
                                <?php echo $Departments;?>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <div class="position-absolute handle card-icon">
                                <i class="simple-icon-shuffle"></i>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>/doc">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="iconsminds-books"></i> Documents</h6>
                            <div>
                                <?php echo $Documents;?>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        <div class="row">
                <div class="col-xl-12 col-lg-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Calendar</h5>
                            <div class="calendar"></div>
                        </div>
                    </div>
                </div>
        </div>
    </main>
<?= $this->endSection() ?>    