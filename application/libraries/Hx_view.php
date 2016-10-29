<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Library HX (Komponens)
 *
 * dibuat oleh hendra sabuna (hendra1602@gmail.com)
 * versi 1.0 -> juli 2014
 * versi 2.0 -> mei 2015
 * versi 3.0 -> juni 2015
 * versi 4.0 -> agustus 2015
 * versi 5.0 (dipisah tabel, form, view) -> november 2015
 *
 * PERHATIAN!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * library ini bukan open source
 * jika anda ingin menggunakan, silahkan izin dulu sama yang punya
 * biasakan menghargai karya orang lain
 */

class Hx_view {

   //////////////////////////////////////////////////
   // ------------------- VIEW --------------------//
   //////////////////////////////////////////////////

   public function set_view_template($arr,$arr_field,$result)
   {
      //-------> atur modal
      $view  = '<div class="modal-dialog '.$arr['cs_modal'].'">
                <div class="modal-content">
                  <div class="modal-header">
                     <button class="close tipb" title="Batal" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title"><i class="fa fa-search fa-fw"></i> Detail Data '.$arr['subjek'].'</h4>
                  </div>

                  <div class="modal-body">';

                  if ($arr['layout']=='multi') {
                     $view .= '<div class="row">';

                                 //---------> looping kolom
                                 foreach ($arr_field as $index=>$k):

                                    $view .= '<div class="'.$k['class'].'">';

                                    if ($k['judul']) {
                                       $view .= '<h3 style="text-transform:uppercase">'.$k['judul'].'</h3><hr style="margin:10px 0">';
                                    }

                                    $view .= $this->set_view($k['field'],$result);
                                    $view .= '</div>';

                                 endforeach;

                     $view .= '</div>';
                  }
                  else {
                     $view .= $this->set_view($arr_field,$result);
                  }

      $view .= '  </div>';

      if (array_key_exists('aksi',$arr) && $arr['aksi']) {
         $view .= '<div class="modal-footer">';

            foreach ($arr['aksi'] as $ls) {
               $view .= '<a href="'.site_url($ls['url']).'" class="'.$ls['class'].'" '.$ls['attr'].'>
                           '.$ls['val'].'
                         </a>';
            }

         $view .= '</div>';
      }

      $view .= '</div>
                </div>
                <script type="text/javascript" src="'.base_url('as/js/_form.js').'"></script>
                <script type="text/javascript" src="'.base_url('as/js/_script.js').'"></script>';

      return $view;
   }

   public function set_view($arr_field,$result)
   {
      //-------> atur modal
      $view  = '<table class="table-profil">';

         //---------> looping kolom
         foreach ($arr_field as $index=>$k):

            $view .= '<tr>';

            switch ($k['tipe']):

               case 'foto':
                  if ($result[$index]) {
                     $view  .= '<td class="text-center" colspan="2">
                                  <img src="'.base_url($k['path_file'].'/'.$result[$index]).'" style="width:80%; margin: 0 0 15px;">
                                </td>';
                  }
                  else {
                     $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                                <td>: -</td>';
                  }
               break;

               case 'multi_foto':
                  if ($result[$index]) {
                     $view  .= '<td class="text-center row-kecil" colspan="2">
                                 <div class="row">';
                                 foreach ($k['list'] as $ls) {

                                    $utama = ($ls['utama']=='Y') ? 'success' : 'default';

                                    $view .= '<div class="col-xs-6">
                                                <div class="panel panel-'.$utama.' panel-file">
                                                   <a href="'.base_url($k['path_file'].'/'.$ls[$index]).'" class="galeri-pop">
                                                      <img src="'.base_url($k['path_file'].'/'.$ls[$index]).'" style="width:100%">
                                                   </a>
                                                   <div class="panel-body">
                                                      <small style="margin-bottom:0">'.$ls['judul'].'</small>
                                                   </div>
                                                </div>
                                              </div>';
                                 }
                     $view  .=  '</div><br>
                               </td>';
                  }
                  else {
                     $view  .= '<td colspan="2">Belum ada '.$arr_field[$index]['label'].'</td>';
                  }
               break;

               case 'file':
                  if ($result[$index]) {
                     $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                                <td>:
                                  <a href="'.base_url($k['path_file'].'/'.$result[$index]).'" class="tip" title="Buka File" target="_blank">
                                    <i class="fa fa-download fa-fw text-primary"></i> '.$result[$index].'
                                  </a>
                                </td>';
                  }
                  else {
                     $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                                <td>: -</td>';
                  }
               break;

               case 'multi_file':
                  if ($result[$index]) {

                     $view  .= '<td class="text-center row-kecil" colspan="2">
                                 <div class="row">';
                                 foreach ($k['list'] as $ls) {

                                    $view .= '<div class="col-xs-6">
                                                <div class="panel panel-default panel-file">
                                                   <div class="panel-body">
                                                      <a href="'.base_url($k['path_file'].'/'.$ls['file']).'" target="_blank">
                                                         <i class="fa fa-'.hx_icon_file($ls['ext']).' fa-4x"></i>
                                                      </a>
                                                      <small style="margin-bottom:0">'.$ls['judul'].'</small>
                                                      <code>'.strtoupper(str_replace('.','',$ls['ext'])).'</code>
                                                   </div>
                                                </div>
                                              </div>';
                                 }
                     $view  .=  '</div><br>
                               </td>';
                  }
                  else {
                     $view  .= '<td colspan="2">Belum ada '.$arr_field[$index]['label'].'</td>';
                  }
               break;

               case 'array':
                  $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                             <td>: '.$k['list'][$result[$index]].'</td>';
               break;

               case 'tanggal':
                  $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                             <td>: '.hx_tgl($result[$index]).'</td>';
               break;

               case 'rupiah':
                  $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                             <td>: Rp. '.hx_rupiah($result[$index]).'</td>';
               break;

               case 'angka':
                  $prefix = (isset($k['prefix'])) ? ' '.$k['prefix'] : '';
                  $vals   = ($result[$index]=='0') ? '-' : $result[$index].$prefix;

                  $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                             <td>: '.$vals.'</td>';
               break;

               case 'editor':
                  $view  .= '<td colspan="2">
                               <h4 style="margin-top:5px"><b>'.$arr_field[$index]['label'].'</b></h4>
                               '.$result[$index].'
                             </td>';
               break;

               case 'text':
                  $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                             <td>: '.$result[$index].'</td>';
               break;

               default:
                  $view  .= '<td class="labels">'.$arr_field[$index]['label'].'</td>
                             <td>: '.$result[$index].'</td>';
               break;

            endswitch;

         endforeach;

      $view .= '</table>';

      return $view;
   }
}