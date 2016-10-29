<!-- Judul Halaman -->
<h3>
   <i class="fa fa-folder-open fa-fw"></i> <?= $_judul; ?>
   <a href="<?= site_url('admin/'.$this->_ctrl); ?>" class="btn btn-primary btn-sm pull-right">
      <i class="fa fa-arrow-left fa-lg fa-fw"></i> KEMBALI
   </a>
</h3>
<hr>

<div class="row">
   <div class="col-md-5">
      <div class="panel panel-default">

         <div class="panel-heading">
            <h4 class="panel-title"><i class="fa fa-photo fa-fw"></i> Gambar Berita</h4>
         </div>

         <div class="panel-body">

         <?php if ($result['gambar']): ?>
         <img src="<?= base_url('as/foto_berita/'.$result['gambar']); ?>" style="width: 100%" />
         <a href="<?= site_url('admin/'.$this->_ctrl.'/form_upload/'.$result['id_berita'].'/gambar/'.$result['gambar']); ?>" class="btn btn-block btn-primary btn-aksi">
            <i class="fa fa-camera fa-fw"></i> Ganti Gambar
         </a>
         <?php else: ?>
         <h4>Belum ada gambar berita</h4><br>
         <a href="<?= site_url('admin/'.$this->_ctrl.'/form_upload/'.$result['id_berita'].'/gambar/'.$result['gambar']); ?>" class="btn btn-block btn-primary btn-aksi">
            <i class="fa fa-camera fa-fw"></i> Ganti Gambar
         </a>
         <?php endif; ?>

         </div>

      </div>
   </div>
   <div class="col-md-7">
      <div class="panel panel-default">

         <div class="panel-heading">
            <h4 class="panel-title">
               Penulis : <?= $result['admin']; ?>  &nbsp;|&nbsp; Tanggal Post : <?= hx_tgl($result['tanggal_post'],'d M Y'); ?>
               <div style="float: right" class="fb-share-button" data-href="<?= site_url('web/berita_detail/'.$result['id_berita']); ?>" data-layout="button"></div>
            </h4>
         </div>

         <div class="panel-body">
            <h4><b>Isi berita :</b></h4>
            <hr>
            <?= $result['isi_berita']; ?>
         </div>

      </div>
   </div>
</div>