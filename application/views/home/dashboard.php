<div class="row" style="padding-top: 10px">
   <div class="col-md-8">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="item active">
               <img src="<?= base_url('as/img/slide-1.jpg'); ?>" style="width: 100%">
            </div>
            <div class="item">
               <img src="<?= base_url('as/img/slide-2.jpg'); ?>" style="width: 100%">
            </div>
            <div class="item">
               <img src="<?= base_url('as/img/slide-3.jpg'); ?>" style="width: 100%">
            </div>
            <div class="item">
               <img src="<?= base_url('as/img/slide-4.jpg'); ?>" style="width: 100%">
            </div>
         </div><br>
      </div>
   </div>
   <div class="col-md-4">
      <h3 style="margin-top: 0">Berita Terbaru</h3>
      <hr>
      <?php foreach ($berita as $list): ?>
      <a href="<?= site_url('dashboard/berita_detail/'.$list['id_berita']); ?>"><h4 style="font-size: 16px; margin: 0 0 5px"><?=$list['judul_berita']; ?></h4></a>
      <p class="text-muted" style="margin-bottom: 0">
         <small>
            <i class="fa fa-calendar"></i> <?= hx_tgl($list['tanggal_post'],'d M Y H:i'); ?> &nbsp;&nbsp;&nbsp;
            <i class="fa fa-user"></i> <?= $list['admin']; ?>
         </small>
      </p>
      <hr class="hr-kecil">
      <?php endforeach; ?>
   </div>
</div>