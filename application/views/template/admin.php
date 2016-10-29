<?php $uri = $this->uri->segment(2); ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title><?= strip_tags(ucwords($_judul)); ?> - Admin</title>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
   <!--<meta name="robots" content="noindex, nofollow">-->

   <link rel="icon" type="image/png" href="<?= base_url('as/img/logo-mini.png'); ?>" />

   <!-- Styles -->
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/normalize.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/bootstrap.min.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/font-awesome.min.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/fileinput.min.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/summernote.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/datepicker3.css'); ?>" />

   <!-- Custom Styles -->
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/_back.css'); ?>" />

   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/awesome-bootstrap-checkbox.css'); ?>">

   <script type="text/javascript" src="<?= base_url('as/js/jquery-2.1.3.min.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/bootstrap.min.js'); ?>"></script>
</head>
<body>

   <!-- menu utama -->
   <nav class="navbar navbar-inverse">
      <div class="container">
         <div class="navbar-header" style="width: 50px">
            <span class="navbar-brand" style="width: 50px">
               <img src="<?= base_url('as/img/logo.png'); ?>" class="pull-left">
            </span>
         </div>

         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
               <li class="<?= ($uri=='home') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/home'); ?>">Home</a>
               </li>
               <li class="<?= ($uri=='petugas') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/petugas'); ?>">Petugas</a>
               </li>
               <li class="<?= ($uri=='berita') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/berita'); ?>">Berita</a>
               </li>
               <li class="<?= ($uri=='responden') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/responden'); ?>">Responden</a>
               </li>
               <li class="<?= ($uri=='jenis') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/jenis'); ?>">Jenis Responden</a>
               </li>
               <li class="<?= ($uri=='gejala') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/gejala'); ?>">Gejala</a>
               </li>
               <li class="<?= ($uri=='penyakit') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/penyakit'); ?>">Penyakit</a>
               </li>
               <li class="<?= ($uri=='hasil') ? 'active' : ''; ?>">
                  <a href="<?= site_url('admin/hasil'); ?>">Hasil</a>
               </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="fa fa-user fa-fw"></i> <?= $this->us['nama_lengkap']; ?> <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                     <li>
                        <a href="<?= site_url('login/form') ?>" class="btn-aksi"><i class="fa fa-pencil fa-fw text-warning"></i> Edit Profil</a>
                     </li>
                     <li>
                        <a href="<?= site_url('login/logout'); ?>"><i class="fa fa-power-off fa-fw text-danger"></i> Logout</a>
                     </li>
   			      </ul>
               </li>
            </ul>
         </div>
      </div>
   </nav>

   <!-- konten/isi -->
   <div class="container">
      <?= $_konten; ?>
   </div>

   <div id="modal-layout" class="modal" data-backdrop="static"></div>

   <div id="load-animasi" class="animasi-backdrop" style="display: none">
      <div class="animation-besar">
         <div class="bar bar1"></div><div class="bar bar2"></div><div class="bar bar3"></div><div class="bar bar4"></div><div class="bar bar5"></div>
         <p><small>Mohon tunggu...</small></p>
      </div>
   </div>

   <?= ($_hx_info = $this->session->flashdata('hx_info')) ? $_hx_info : ''; ?>

   <!-- Javascripts -->
   <script type="text/javascript" src="<?= base_url('as/js/dtpck/bootstrap-datepicker.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/dtpck/bootstrap-datepicker.id.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/valid/validation.min.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/valid/bootstrap.min.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/valid/id_ID.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/alphanumeric.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/autoNumeric.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/summernote.min.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/_form.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/_script.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/export/tableExport.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/export/jquery.base64.js'); ?>"></script>

</body>
</html>