<!DOCTYPE HTML>
<html>
<head>
   <title>Login Admin - Data SAW</title>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
   <meta name="robots" content="noindex, nofollow">

   <link rel="icon" type="image/png" href="<?php echo base_url('as/img/logo-mini.png'); ?>" />

   <link rel="stylesheet" href="<?php echo base_url('as/css/normalize.css'); ?>" />
   <link rel="stylesheet" href="<?php echo base_url('as/css/bootstrap.min.css'); ?>" />
   <link rel="stylesheet" href="<?php echo base_url('as/css/font-awesome.min.css'); ?>" />
   <link rel="stylesheet" href="<?php echo base_url('as/css/_login.css'); ?>" />
</head>
<body>
<div class="form-login col-md-7 col-sm-10">
   <div class="panel panel-default">
      <div class="panel-body">
         <div class="row">
            <div class="col-sm-6 login-border text-center">
               <img src="<?php echo base_url('as/img/login.png'); ?>" style="width: 200px">
            </div>
            <div class="col-sm-6">
               <h3><i class="fa fa-user fa-fw"></i> Login Admin</h3>
               <p>Silahkan masukan email dan password anda dengan benar</p>
               <form id="form_input" action="<?= site_url('login/validasi'); ?>" method="post" onsubmit="$('#progress').show()">
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa-fw fa-lg"></i></span>
                        <input type="text" name="em" class="form-control" placeholder="Email" value="<?= ($_us = $this->session->flashdata('email')) ? $_us : ''; ?>" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key fa-fw fa-lg"></i></span>
                        <input type="password" name="pw" class="form-control" placeholder="Password" required>
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg">
                     <span id="progress" class="collapse"><i class="fa fa-refresh fa-spin fa-fw text-muted"></i></span>
                     LOGIN <i class="fa fa-arrow-right fa-fw"></i>
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?= ($_hx_info = $this->session->flashdata('hx_info')) ? $_hx_info : ''; ?>
<script type="text/javascript" src="<?php echo base_url('as/js/jquery-2.1.3.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('as/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function(){
   $(".form-login").center();
   $(window).resize(function() {
      $(".form-login").center();
   });
   setTimeout(function() {
      $('.alert').fadeOut('slow',function() {
         $('.alert').alert('close');
      });
   }, 10000);
});

/* CENTER ELEMENTS IN THE SCREEN */
jQuery.fn.center = function() {
   this.css("position", "absolute");
   this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
      $(window).scrollTop()) + "px");
   this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
      $(window).scrollLeft()) + "px");
   return this;
}
</script>
</body>
</html>