<!-- Konten Halaman -->
<div class="wrapper wrapper-content">
   <div class="row">
      <div class="col-md-12">
         <div class="ibox">
            <div class="ibox-title">
               <h3><i class="fa fa-bell fa-fw"></i> Notifikasi (<b class="text-warning"><?= count($notif); ?></b>)</h3>
               <div class="clearfix m-b-sm"></div>
               <div class="table-responsive">
                  <table class="table table-hover issue-tracker">
                     <tbody>
                        <?php
                        if ($notif):
                        foreach ($notif as $list):
                        if ($this->us['tingkat']=='pusat') {
                           $info = '<strong>'.$list['satuan'].'</strong> belum update stok varietas <strong>'.$list['komoditas'].'</strong><br>';
                        }
                        else {
                           $info = 'Stok varietas <strong>'.$list['komoditas'].'</strong> belum diupdate<br>';
                        }
                        ?>
                           <tr>
                              <td class="issue-info">
                                 <a href="<?= site_url('admin/satuan_kerja/form_stok/'.$list['id_satuan_kerja'].'/'.$list['id_komoditas'].'/'.$list['id_produksi']); ?>" class="btn-aksi">
                                    <i class="fa fa-angle-double-right fa-fw"></i> <?= $info; ?>
                                 </a>
                              </td>
                              <td class="text-right">
                                 Bulan <?= hx_tgl($list['tgl_operator'],'M Y'); ?>
                              </td>
                           </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                           <tr>
                              <td class="text-center">
                                 <h4 class="m-n"><i class="fa fa-info-circle fa-fw"></i> Belum ada notifikasi</h4>
                              </td>
                           </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>