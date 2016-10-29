<?php $jk = array('L'=>'Laki-laki','P'=>'Perempuan'); ?>
<!-- Judul Halaman -->
<h3>
   <i class="fa fa-folder-open fa-fw"></i> <?= $_judul; ?>
   <a href="<?= site_url('dashboard/edit_profil'); ?>" class="btn btn-default btn-sm pull-right">
      <i class="fa fa-pencil fa-lg fa-fw text-warning"></i> EDIT PROFIL
   </a>
</h3>
<hr>

<div class="row">
   <div class="col-md-3">
      <div class="panel panel-default">

         <div class="panel-heading">
            <h4 class="panel-title"><i class="fa fa-photo fa-fw"></i> Foto Profil</h4>
         </div>

         <div class="panel-body">

         <?php if ($result['foto']): ?>
         <img src="<?= base_url('as/foto_petugas/'.$result['foto']); ?>" style="width: 100%" />
         <?php else: ?>
         <h4>Belum ada foto profil</h4>
         <?php endif; ?>

         </div>

      </div>
   </div>
   <div class="col-md-9">
      <table class="table-profil">
         <tr>
            <td class="labels" style="width: 130px">Nama Lengkap</td>
            <td>: <?= $result['nama_lengkap']; ?></td>
         </tr>
         <tr>
            <td class="labels">Tempat/Tgl Lahir</td>
            <td>: <?= $result['tempat_lahir'].', '.hx_tgl($result['tanggal_lahir'],'d M Y'); ?></td>
         </tr>
         <tr>
            <td class="labels">Jenis Kelamin</td>
            <td>: <?= $jk[$result['jenis_kelamin']]; ?></td>
         </tr>
         <tr>
            <td class="labels">Alamat</td>
            <td>: <?= $result['alamat']; ?></td>
         </tr>
         <tr>
            <td class="labels">No Telepon</td>
            <td>: <?= $result['no_telp']; ?></td>
         </tr>
         <tr>
            <td class="labels" style="width: 130px">Email</td>
            <td>: <?= $result['email']; ?></td>
         </tr>
      </table>
   </div>
</div>