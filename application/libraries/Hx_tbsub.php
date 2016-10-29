<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Library HX (Komponens)
 *
 * dibuat oleh hendra sabuna (hendra1602@gmail.com)
 * versi 1.0 -> juli 2014
 * versi 2.0 -> mei 2015
 * versi 3.0 -> juni 2015
 * versi 4.0 -> agustus 2015
 *
 * PERHATIAN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * library ini bukan open source
 * jika anda ingin menggunakan, silahkan izin dulu sama yang punya
 * biasakan menghargai karya orang lain
 */

class Hx_tbsub {

   private $tabel_cls = 'table table-bordered table-condensed table-hover';
   private $tabel_id  = 'tabel-data';

   ///////////////////////////////////////////////////
   // ------------------- TABEL --------------------//
   ///////////////////////////////////////////////////

   public function set_head_tabel($aksi=array(),$arr_field)
   {
      $tabel  = '<thead>
                   <tr>
                     <th style="width:40px" class="text-center">No.</th>';

                     foreach ($arr_field as $index=>$list):
                        $tabel .= '<th class="text-center" colspan="2">'.$list['label'].'</th>';
                     endforeach;

      if ($aksi) {
         $tabel .= '<th colspan="'.count($aksi).'" class="text-center">Pilihan</th>';
      }

      $tabel .= '  </tr>
                 </thead>';

      return $tabel;
   }

   public function set_aksi_tabel($aksi,$id,$induk,$id_induk)
   {
      $cols   = ($induk=='Y') ? '2' : '';

      $tabel  = '';

      $tabel .= '<td class="aksi" colspan="'.$cols.'">
                    <a href="'.site_url($aksi['edit'].'/'.$id).'" class="tip btn-aksi" title="Edit Data">
                      <i class="fa fa-pencil fa-lg text-warning"></i>
                    </a>
                 </td>';

      if ($induk=='N'):

      $tabel .= '<td class="aksi">
                    <a href="#modal_konf_hapus" url="'.site_url($aksi['hapus'].'/'.$id.'/'.$id_induk).'" class="tip tombol-hapus" title="Hapus Data" data-toggle="modal">
                      <i class="fa fa-times fa-lg text-danger"></i>
                    </a>
                 </td>';

      endif;

      return $tabel;
   }

   public function set_tabel($arr,$arr_field,$result,$aksi=array())
   {
      $tabel_class = (array_key_exists('tabel_class',$arr)) ? $arr['tabel_class'] : $this->tabel_cls;
      $tabel_id    = (array_key_exists('tabel_id',$arr)) ? $arr['tabel_id'] : $this->tabel_id;

      $tabel  = '<table id="'.$tabel_id.'" class="'.$tabel_class.'">';

      //set heading tabel

      if (array_key_exists('head_tabel',$arr)) {
         $tabel .= $arr['head_tabel'];
      }
      else {
         $tabel .= $this->set_head_tabel($aksi,$arr_field);
      }

      //--------> body tabel
      $tabel .= '  <tbody>';

      //buat index tabel
      if (isset($arr['tabel_index'])) {
         $tabel .= '<tr>';
         for ($i=1; $i<=(count($arr_field)+1); $i++) {
            $tabel .= '<td class="td-kecil" style="text-align:center"><b>'.$i.'</b></td>';
         }
         $tabel .= '</tr>';
      }

      //echo $tabel; exit();

      //nomor tabel
      $nox = 1;
      $no  = ($arr['nomor_hal']) ? $arr['nomor_hal'] : 1;

      //---------> looping data
      foreach ($result as $list):

         $class = ($list['id_induk']=='0') ? 'warning" style="font-weight:bold; height:45px' : '';
         $link  = (isset($arr['tambah_sub']) && $list['id_induk']=='0') ? '<a href="'.site_url($arr['tambah_sub'].'/'.$list[$arr['kunci']]).'" class="tip btn-aksi" title="Tambah Sub"><i class="fa fa-plus-circle fa-lg fa-fw"></i></a>' : '';
         $nomor = ($list['id_induk']=='0') ? $nox.'.' : '&nbsp;';

         $tabel .= '<tr class="'.$class.'">';
         $tabel .= '  <td class="text-center">'.$nomor.'</td>';

         //---------> looping kolom
         foreach ($arr_field as $index=>$k):

            if ($list['id_induk']=='0') {
               $tabel .= '<td colspan="2">
                            '.$list[$index].'
                            '.$link.'
                          </td>';
            }
            else {
               $tabel .= '<td style="width:35px">'.$no.'.</td>
                          <td>
                            '.$list[$index].'
                          </td>';
            }

         endforeach;

         // ---------> set aksi tabel
         if ($aksi) {
            $tabel .= $this->set_aksi_tabel($aksi,$list[$arr['kunci']],$list['induk'],$list['id_induk']);
         }

         $tabel .= '</tr>';

         if ($list['id_induk']=='0') {
            $nox++;
            $no=1;
         }
         else {
            $no++;
         }

      endforeach;

      $tabel .= '  </tbody>
                 </table>';

      if (isset($arr['js_hapus'])) :

      $tabel .= '';

      else :

      $tabel .= '<div id="modal_konf_hapus" class="modal">
                     <div class="modal-dialog">
                        <div class="modal-content modal_konf_hapus">
                           <div class="modal-body text-center">
                              <i class="fa fa-warning fa-5x"></i>
                              <h4><b>HAPUS DATA</b></h4>
                              <p>Apakah anda yakin akan menghapus data ini?</p>
                           </div>
                           <div class="modal-footer">
                              <a id="link-hapus" class="btn btn-primary btn-progress"><i class="fa fa-check fa-fw"></i> HAPUS</a>
                              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> BATAL</button>
                           </div>
                        </div>
                     </div>
                  </div>

                  <script type="text/javascript">
                  $(document).ready(function(){
                     $(".tombol-hapus").click(function(){
                        $("#link-hapus").attr("href",$(this).attr("url"));
                     });
                  });
                </script>';

      endif;

      return $tabel;
   }
}