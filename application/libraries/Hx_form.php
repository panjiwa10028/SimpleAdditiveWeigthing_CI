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

class Hx_form {

   ///////////////////////////////////////////////////
   // ------------------- FORM --------------------///
   ///////////////////////////////////////////////////

   public function set_template($arr,$arr_field,$values=array())
   {
      $id_edit = ($values) ? $values[$arr['kunci']] : null;
      if (empty($values[$arr['master']])) {
         $id_master = null;
      } else {
         $id_master = ($values) ? $values[$arr['master']] : null;
      }
      $attr    = (isset($arr['attr'])) ? $arr['attr'] : null;

      $judul   = ($values) ? '<i class="fa fa-edit fa-fw"></i> Edit Data '.$arr['subjek'] : '<i class="fa fa-plus fa-fw"></i> Tambah Data '.$arr['subjek'];
      $tombol  = ($values) ? 'SIMPAN PERUBAHAN' : 'SIMPAN';

      //-------> atur modal
      $form  = '<div class="modal-dialog '.$arr['cs_modal'].'">
                <div class="modal-content">
                <form id="form_input" action="'.site_url($arr['url_save']).'" method="post" class="form-'.$arr['cs_form'].'" '.$attr.'>
                <input type="hidden" name="'.$arr['kunci'].'" id="'.$arr['kunci'].'" value="'.$id_edit.'">
                <input type="hidden" name="'.$arr['master'].'" id="'.$arr['master'].'" value="'.$id_master.'">

                  <div class="modal-header">
                     <button class="close tipb" title="Batal" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">'.$judul.'</h4>
                  </div>

                  <div class="modal-body">';

                     if ($arr['layout']=='multi') {
                        $form .= '<div class="row">';

                                    //---------> looping kolom
                                    foreach ($arr_field as $index=>$k):

                                       $form .= '<div class="'.$k['class'].'">';

                                       if ($k['judul']) {
                                          $form .= '<h3 style="text-transform:uppercase">'.$k['judul'].'</h3><hr style="margin:10px 0">';
                                       }

                                       $form .= $this->set_form($arr['cs_form'],$k['field'],$values);
                                       $form .= '</div>';

                                    endforeach;

                        $form .= '</div>';
                     }
                     else {
                        $form .= $this->set_form($arr['cs_form'],$arr_field,$values);
                     }

   $form .= '     </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> '.$tombol.'</button>
                     <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> BATAL</button>
                  </div>
                </form>
                </div>
                </div>
                <script type="text/javascript" src="'.base_url('as/js/_form.js').'"></script>
                <script type="text/javascript" src="'.base_url('as/js/_script.js').'"></script>';

      return $form;
   }

   public function set_form($layout,$arr_field,$values=array())
   {
      $form = '';
      //echo($layout); exit();

      foreach ($arr_field as $index=>$field):

         if ($values) {
            $val = $values[$index];
         }
         else {
            $val = (array_key_exists('value',$field)) ? $field['value'] : null;
         }

         $list  = (array_key_exists('list',$field)) ? $field['list'] : null;
         $attr  = (array_key_exists('attr',$field)) ? $field['attr'] : null;
         $lebar = (array_key_exists('lebar',$field)) ? $field['lebar'] : null;

         $form .= $this->set_input($layout,$index,$field['label'],$val,$field['tipe'],$list,$lebar,$attr);

      endforeach;

      return $form;
   }

   public function set_input($layout,$name,$label,$value=null,$type,$list=null,$lebar=null,$attr=null)
   {
      //buat layout horizontal
      $lebar       = ($lebar) ? $lebar : '8';
      $class_label = ($layout=='horizontal') ? 'col-sm-3' : '';
      $buka_div    = ($layout=='horizontal') ? '<div class="col-sm-'.$lebar.'">' : '';
      $tutup_div   = ($layout=='horizontal') ? '</div>' : '';

      switch ($type):

         //------->jika type select
         case 'select':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<select name="'.$name.'" id="'.$name.'" class="form-control select_two" '.$attr.'>';
            $input .= '   <option value="">- Pilih '.$label.' -</option>';

            foreach ($list as $_index=>$_item):
               $_selected = ($value==$_index) ? 'selected' : '';

               if (substr($_index,0,2)=='xx') {
                  $input .= '<optgroup label="'.$_item.'"></optgroup>';
               }
               else {
                  $input .= '<option value="'.$_index.'" '.$_selected.'>'.$_item.'</option>';
               }
            endforeach;

            $input .= '</select>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type radio button
         case 'radio':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<div class="cekbox">';

            foreach ($list as $_index=>$_item):
               //exit($value);
               $_checked = ($value==$_index) ? 'checked' : '';
               $input .= '<div class="radio radio-success radio-inline">';
               $input .= '  <input type="radio" name="'.$name.'" id="'.$name.$_index.'" value="'.$_index.'" '.$_checked.'><label for="'.$name.$_index.'">'.$_item.'</label>';
               $input .= '</div>';
            endforeach;

            $input .= '</div>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type textarea
         case 'textarea':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<textarea name="'.$name.'" id="'.$name.'" class="form-control" '.$attr.'>'.$value.'</textarea>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type editor
         case 'editor':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<textarea name="'.$name.'" id="'.$name.'" class="form-control editor-full" rows="8" '.$attr.'>'.$value.'</textarea>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type editor-mini
         case 'editor-mini':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<textarea name="'.$name.'" id="'.$name.'" class="form-control editor-mini" rows="8" '.$attr.'>'.$value.'</textarea>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type number
         case 'number':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<input type="number" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control num" '.$attr.'>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type numeric
         case 'numeric':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control num" '.$attr.'>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type rupiah
         case 'rupiah':
            //$value  = ($value) ? hx_rupiah($value) : '';
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<div class="input-group">';
            $input .= '  <span class="input-group-addon">Rp.</span>';
            $input .= '  <input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control rupiah num" '.$attr.' data-a-sep="." data-a-dec=",">';
            $input .= '</div>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type tanggal
         case 'tanggal':
            $value  = ($value) ? hx_tgl_mysql_id($value) : '';
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<div class="input-group tanggals">';
            $input .= '  <input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control tgl" '.$attr.'>';
            $input .= '  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
            $input .= '</div>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type decimal
         case 'decimal':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control num" '.$attr.'>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //-------->default type password
         case 'password':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" class="form-control" '.$attr.'>';

            if ($value) {
               $input .= '<small class="help-block">Jika tidak mengganti password, dikosongkan saja</small>';
            }

            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type hidden
         case 'hidden':
            $input = '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'">';
         break;

         //------->jika type panjang khusus benih ikan
         case 'panjang':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<div id="div-panjang"><input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control" '.$attr.'></div>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //------->jika type panjang khusus benih ikan
         case 'panjang-benih':
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<div id="div-panjang">';
            $input .= '<select name="'.$name.'" id="'.$name.'" class="form-control" '.$attr.'>';
            $input .= '   <option value="">- Pilih '.$label.' -</option>';

            foreach ($list as $_index=>$_item):
               $_selected = ($value==$_index) ? 'selected' : '';

               if (substr($_index,0,2)=='xx') {
                  $input .= '<optgroup label="'.$_item.'"></optgroup>';
               }
               else {
                  $input .= '<option value="'.$_index.'" '.$_selected.'>'.$_item.'</option>';
               }
            endforeach;

            $input .= '</select>';
            $input .= '</div>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

         //-------->default type text
         default:
            $input  = '<div class="form-group">';
            $input .= '<label for="'.$name.'" class="'.$class_label.' control-label">'.$label.'</label>';
            $input .= $buka_div;
            $input .= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control" '.$attr.'>';
            $input .= $tutup_div;
            $input .= '</div>';
         break;

      endswitch;

      return $input;
   }

   public function set_upload($arr,$id,$field)
   {
      $image = '';
      $ganti = '';

      if (isset($arr['foto'])) {
         $image = '<div class="text-center"><img src="'.base_url($arr['path'].'/'.$arr['foto']).'" class="img-pollaroid" style="height:250px; margin-bottom:10px"><br><h5>'.$arr['foto'].'</h5></div><hr>';
         $ganti = '<input type="hidden" name="ganti_foto" value="Y"><input type="hidden" name="foto_lama" value="'.$arr['foto'].'">';
      }

      //-------> modal dialog
      $form = '<div class="modal-dialog">
                  <div class="modal-content">
                     <form class="hx_form_upload_file" action="'.site_url($arr['url_upload']).'" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="tabel" value="'.$arr['tabel'].'">
                        <input type="hidden" name="kunci" value="'.$arr['kunci'].'">
                        <input type="hidden" name="url" value="'.$arr['url_redirect'].'">
                        <input type="hidden" name="field_tabel" value="'.$field.'">
                        <input type="hidden" name="id_tabel" value="'.$id.'">
                        <input type="hidden" name="ext" value="'.str_replace(',','|',$arr['ext']).'">
                        <input type="hidden" name="path" value="'.$arr['path'].'">
                        '.$ganti.'
                        <div class="modal-header">
                           <button class="close tipb" title="Batal" data-dismiss="modal">&times;</button>
                           <h4 class="modal-title"><i class="fa fa-upload fa-fw"></i> Upload '.ucwords(str_replace('_',' ',$field)).'</h4>
                        </div>
                        <div class="modal-body">
                           '.$image.'
                           <p>Format File <code>'.strtoupper(str_replace(',',', ',$arr['ext'])).'</code> dan maksimal ukuran file <code>'.number_format(substr_replace($arr['size'],'',-3),0,',','.').' KB</code></p>
                           <div class="form-group">
                              <label for="'.$field.'">Pilih File '.ucwords(str_replace('_',' ',$field)).'</label>
                              <input type="file" name="'.$field.'" id="'.$field.'" value="" class="form-control input-files" required data-fv-file="true" data-fv-file-maxsize="'.$arr['size'].'" data-fv-file-extension="'.$arr['ext'].'">
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary disabled"><i class="fa fa-check"></i> UPLOAD</button>
                           <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-remove"></i> BATAL</button>
                        </div>
                     </form>
                  </div>
               </div>
               <script type="text/javascript" src="'.base_url('as/js/_form.js').'"></script>
               <script type="text/javascript" src="'.base_url('as/js/_script.js').'"></script>';

      return $form;
   }
}