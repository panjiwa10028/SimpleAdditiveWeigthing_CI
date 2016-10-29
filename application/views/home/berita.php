<!-- Judul Halaman -->
<h3>
   <i class="fa fa-folder-open fa-fw"></i> <?= $_judul; ?>
</h3>
<hr>

<!-- Form Pencarian -->
<?php if (isset($form_cari)): ?>
<div id="form_cari">
   <?= $form_cari; ?><br>
</div>
<?php endif; ?>

<!-- Konten Halaman -->
<div class="row">
   <?php foreach ($result as $list): ?>
      <div class="col-md-6 post">
         <div class="panel panel-default">
            <div class="panel-body">
               <a href="<?= site_url('dashboard/berita_detail/'.$list['id_berita']); ?>"><h3><?=$list['judul_berita']; ?></h3></a>
               <p class="text-muted">
                  <i class="fa fa-calendar"></i> <?= hx_tgl($list['tanggal_post'],'d M Y H:i'); ?> &nbsp;&nbsp;&nbsp;
                  <i class="fa fa-user"></i> <?= $list['admin']; ?>
               </p>
               <?= (strlen($list['isi_berita']) > 220) ? substr($list['isi_berita'],0,220).' [....]' : $list['isi_berita']; ?>
            </div>
         </div>
      </div>
   <?php endforeach; ?>
</div>
<br>
<div class="text-center">
   <p class="lead" style="margin-bottom: 0"><?= $_paging['info']; ?></p>
   <ul class="pagination"><?= $_paging['page']; ?></ul>
</div>