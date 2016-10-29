<!-- Judul Halaman -->
<h3><i class="fa fa-folder-open fa-fw"></i> <?= $_judul; ?></h3>
<hr>

<form id="form_input" action="<?= site_url('dashboard/daftar_proses'); ?>" method="post" class="form-vertical" enctype="multipart/form-data">
   <div class="row">
      <div class="col-md-4">
         <?= $kolom1; ?>
      </div>
      <div class="col-md-4">
         <?= $kolom2; ?>
      </div>
      <div class="col-md-4">
         <?= $kolom3; ?>
      </div>
   </div>
   <hr />
   <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check"></i> DAFTAR</button>
   <a href="<?= site_url('dashboard'); ?>" class="btn btn-warning btn-lg"><i class="fa fa-times"></i> BATAL</a>
</form>

<!-- Javascripts -->
<script type="text/javascript" src="<?= base_url('as/js/dtpck/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/dtpck/bootstrap-datepicker.id.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/valid/validation.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/valid/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/valid/id_ID.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/fileinput.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/alphanumeric.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/autoNumeric.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/summernote.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/_form.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('as/js/_script.js'); ?>"></script>