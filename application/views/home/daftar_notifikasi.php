<div class="text-center">

   <?php if ($status=='sukses'): ?>
   <br><br><p><i class="fa fa-check-circle fa-5x text-success"></i></p>
   <h4><?= $_judul; ?></h4>
   <p>Akun Anda akan diapprove terlebih dahulu oleh administrator. Anda akan menerima notifikasi melalui email.</p>

   <?php else: ?>
   <br><br><p><i class="fa fa-info-circle fa-5x text-warning"></i></p>
   <h4><?= $_judul; ?></h4>
   <p>Silahkan coba lagi atau hubungi administrator</p>
   <?php endif; ?>

</div>