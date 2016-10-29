<!-- Judul Halaman -->
<h3>
   <i class="fa fa-folder-open fa-fw"></i> <?= $_judul; ?>
   <a href="#form-posting" class="btn btn-primary pull-right" data-toggle="collapse"><i class="fa fa-plus fa-fw"></i> Tambah</a>
</h3>
<hr>
<div id="form-posting" class="collapse">
   <div class="row">
      <div class="col-md-3">
         <h4><b>Responden Baru</b></h4>
         <form action="<?= site_url('dashboard/simpan_responden'); ?>" method="post" class="form-vertical">
            <div class="form-group">
               <input type="text" name="nama" class="form-control" placeholder="Nama Responden" />
            </div>
            <div class="form-group">
               <select name="jenis" id="jenis">
                  <option value="">- Pilih Jenis Responden -</option>
                  <?php foreach ($penyakit as $key => $value) { ?>
                     <option value="<?php echo $value['nama_jenis_responden']; ?>"><?php echo ucfirst($value['nama_jenis_responden']); ?></option>
                  <?php } ?>
               </select>
            </div>
            <div class="form-group">
               <button type="submit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Simpan</button>
               <a aria-expanded="true" href="#form-posting" class="btn btn-warning" data-toggle="collapse"><i class="fa fa-times fa-fw"></i> BATAL</a>
            </div>
         </form>
      </div>
   </div>
   <hr>
</div>

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