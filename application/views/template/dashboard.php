<?php $uri = $this->uri->segment(2); ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title><?= strip_tags(ucwords($_judul)); ?> - Data SAW</title>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
   <!--<meta name="robots" content="noindex, nofollow">-->

   <link rel="icon" type="image/png" href="<?= base_url('as/img/logo-mini.png'); ?>" />

   <!-- load Styles -->
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/normalize.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/bootstrap.min.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/font-awesome.min.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/awesome-bootstrap-checkbox.css'); ?>">
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/datepicker3.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/summernote.css'); ?>" />
   <link type="text/css" rel="stylesheet" href="<?= base_url('as/css/_front.css'); ?>" />

   <!-- load JavaScript -->
   <script type="text/javascript" src="<?= base_url('as/js/jquery-2.1.3.min.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/bootstrap.min.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/export/tableExport.js'); ?>"></script>
   <script type="text/javascript" src="<?= base_url('as/js/export/jquery.base64.js'); ?>"></script>
</head>
<body>

<div class="container" id="container">

   <!-- header -->
   <header>
      <nav class="navbar navbar-inverse" >
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
         </div>

         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">

               <li class="<?= ($uri=='home' || empty($uri)) ? 'active' : ''; ?>">
                  <a href="<?= site_url('dashboard/index'); ?>">Home</a>
               </li>
               <li class="<?= ($uri=='berita') ? 'active' : ''; ?>">
                  <a href="<?= site_url('dashboard/berita'); ?>">Berita</a>
               </li>

               <?php if (!empty($this->al)): ?>
               <li class="<?= ($uri=='responden' || $uri=='perangkingan') ? 'active' : ''; ?>">
                  <a href="<?= site_url('dashboard/responden'); ?>">Responden</a>
               </li>
               <?php endif; ?>
               <li class="<?= ($uri=='hasil' || $uri=='hasil_penyakit' || $uri=='hasil_gejala') ? 'active' : ''; ?>">
                  <a href="<?= site_url('dashboard/hasil'); ?>">Hasil Perangkingan</a>
               </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
               <li class="dropdown">

                  <?php if (empty($this->al)): ?>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="fa fa-lock fa-fw"></i> LOGIN / DAFTAR <b class="caret"></b>
                  </a>
                  <div class="dropdown-menu form-login" style="width: 300px; padding: 15px">
      			      <form action="<?= site_url('login/validasi_petugas') ?>" method="post" class="form-vertical">
                        <h4 class="text-center"><i class="fa fa-user fa-fw"></i> LOGIN PENGGUNA</h4>
      			         <div class="form-group">
                           <input type="email" name="em" class="form-control" placeholder="Email.." required eror-value="Email tidak boleh kosong." eror-type="Email tidak valid.">
      			         </div>
      			         <div class="form-group">
                           <input type="password" name="pw" class="form-control" placeholder="Password.." required eror-value="Password tidak boleh kosong.">
                        </div>
      			         <div class="form-group">
                           <button type="submit" class="btn btn-info btn-lg btn-block"><i class="fa fa-lock fa-fw"></i> LOGIN</button>
                           <hr style="margin-bottom: 12px;">
                           <small>Anda belum terdaftar? Silahkan <a href="<?= site_url('dashboard/daftar') ?>">DAFTAR <i class="fa fa-arrow-right4 fa-fw"></i></a></small>
      			         </div>
      			      </form>
   			      </div>
                  <?php else: ?>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="fa fa-user fa-fw"></i> <?= $this->al['nama']; ?> <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                     <li>
                        <a href="<?= site_url('dashboard/edit_profil'); ?>"><i class="fa fa-pencil fa-fw text-warning"></i> Edit Profil</a>
                     </li>
                     <li>
                        <a href="<?= site_url('login/logout_user'); ?>"><i class="fa fa-power-off fa-fw text-danger"></i> Logout</a>
                     </li>
   			      </ul>
                  <?php endif; ?>

               </li>
            </ul>
         </div>
      </nav>                              
      <img src="<?= base_url('as/img/header.png'); ?>" alt="" style="width: 100%" />
   </header>

   <!-- konten/isi -->
   <div class="konten">
      <?= $_konten; ?>
   </div>

   <!-- Footer -->
   <footer>
      &copy; <?= date('Y'); ?> <b>Sistem Informasi Peternakan Ayam</b> Berbasis Sample Additive Weighting (SAW)<br>
      <small>Created By <a href="#">Reni</a></small>
   </footer>

</div>

<?= ($_hx_info = $this->session->flashdata('hx_info')) ? $_hx_info : ''; ?>

<!-- Javascript -->
<script type="text/javascript">
   $(document).ready(function(){
      var height = $(window).height();
      $('#container').attr('style','min-height:'+height+'px');
      $(window).resize(function() {
         var height = $(window).height();
         $('#container').attr('style','min-height:'+height+'px');
      });
   });
</script>

</body>
</html>