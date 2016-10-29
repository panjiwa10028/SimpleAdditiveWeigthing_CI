<!-- Judul Halaman -->
<h3>
   <i class="fa fa-folder-open fa-fw"></i> <?= $_judul; ?>
   <a href="<?= site_url('admin/'.$this->_ctrl.'/form'); ?>" class="btn btn-primary btn-sm btn-aksi pull-right">
      <i class="fa fa-plus fa-lg fa-fw"></i> TAMBAH
   </a>
</h3>
<hr>

<!-- Form Pencarian -->
<?php if (isset($form_cari)): ?>
<div id="form_cari">
   <?= $form_cari; ?><br>
</div>
<?php endif; ?>

<!-- Tabel Data -->
<div class="panel panel-default">
   <div class="table-responsive">
      <?= $_tabel; ?>
   </div>
   <div class="panel-body paging">
      <div class="row">
         <div class="col-sm-6"><?= $_paging['info']; ?></div>
         <div class="col-sm-6 text-right">
            <ul class="pagination pagination-sm"><?= $_paging['page']; ?></ul>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
      $("#export").click(function(){
         $('#tabel-data').tableExport({type:'excel',escape:'false'});
    });
  });
</script>