<!-- Konten Halaman -->
<div class="row">

   <div class="col-md-8">
      <h3><?= $_judul; ?></h3>
      <p class="text-muted">
         <i class="fa fa-calendar"></i> <?= hx_tgl($result['tanggal_post'],'d M Y H:i'); ?> &nbsp;&nbsp;&nbsp;
         <i class="fa fa-user"></i> <?= $result['admin']; ?>
      </p>
      <div class="fb-like" data-href="<?= current_url(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
      <hr>

      <?php if ($result['gambar']): ?>
      <img src="<?= base_url('as/foto_berita/'.$result['gambar']); ?>" style="width: 100%; margin-bottom: 20px" />
      <?php endif; ?>

      <?= $result['isi_berita']; ?>

      <p>&nbsp;</p>
      <div class="fb-comments" data-href="<?= current_url(); ?>" data-numposts="5" data-width="100%"></div>
   </div>

   <div class="col-md-4">
      <br>
      <div class="panel panel-default">
         <div class="panel-body">
            <h3>Berita Lainnya</h3>
            <?php foreach ($lainnya as $list): ?>
            <hr class="hr-kecil">
            <a href="<?= site_url('dashboard/berita_detail/'.$list['id_berita']); ?>"><h4 style="font-size: 16px;"><?=$list['judul_berita']; ?></h4></a>
            <p class="text-muted">
               <small>
                  <i class="fa fa-calendar"></i> <?= hx_tgl($list['tanggal_post'],'d M Y H:i'); ?> &nbsp;&nbsp;&nbsp;
                  <i class="fa fa-user"></i> <?= $list['admin']; ?>
               </small>
            </p>
            <?php endforeach; ?>
         </div>
      </div>
   </div>
</div>