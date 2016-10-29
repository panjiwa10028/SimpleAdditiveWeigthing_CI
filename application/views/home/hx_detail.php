<!-- Judul Halaman -->
<h3>
   <i class="fa fa-folder-open fa-fw"></i> <?= $_judul; ?>
   <a href="<?= site_url('admin/'.$this->_ctrl); ?>" class="btn btn-primary btn-sm pull-right">
      <i class="fa fa-arrow-left fa-lg fa-fw"></i> KEMBALI
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

<?php if (isset($_hasil)): ?>      
<h3>
   <i class="fa fa-folder-open fa-fw"></i> <?= $_judul_hasil; ?>
</h3>
<hr>

<div class="row">
   <div class="col-md-4">
      <div class="panel panel-default">

         <div class="panel-heading">
            <h4 class="panel-title"> Data Responden</h4>
         </div>

         <div class="panel-body">
            <table class="table-profil">
               <tr>
                  <td class="labels" style="width: 130px">Nama</td>
                  <td>: <?= $_detail['nama_responden']; ?></td>
               </tr>
               <tr>
                  <td class="labels">Jenis</td>
                  <td>: <?= $_detail['nama_jenis_responden']; ?></td>
               </tr>
            </table>
         </div>

      </div>
   </div>
   <div class="col-md-8">
      <div class="table-responsive">
         <?= $_tabel_hasil; ?>
      </div>
      <div class="panel-body paging">
         <div class="row">
            <div class="col-sm-6"><?= $_paging_hasil['info']; ?></div>
            <div class="col-sm-6 text-right">
               <ul class="pagination pagination-sm"><?= $_paging_hasil['page']; ?></ul>
            </div>
         </div>
      </div>
   </div>
</div>
<?php endif; ?>

<script type="text/javascript">
   $(document).ready(function(){
      $("#export").click(function(){
         $('#tabel-data').tableExport({type:'excel',escape:'false'});
    });
  });
</script>