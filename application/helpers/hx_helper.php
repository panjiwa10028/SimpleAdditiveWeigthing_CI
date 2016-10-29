<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function hx_info($jenis,$pesan)
{
   if ($jenis=='success') {
      $jdl = 'Sukses';
      $icn = 'check';
   }
   else if ($jenis=='warning') {
      $jdl = 'Peringatan';
      $icn = 'warning';
   }
   else if ($jenis=='danger') {
      $jdl = 'Kesalahan';
      $icn = 'exclamation-circle';
   }
   else {
      $jdl = 'Informasi';
      $icn = 'info-circle';
   }

   $a = '<div class="alert alert-'.$jenis.' alert-dismissible animated bounce">
            <i class="fa fa-'.$icn.' fa-fw fa-2x pull-left"></i>
            <button class="close" data-dismiss="alert">&times;</button>
            <b>'.$jdl.'</b><br>'.$pesan.'.
         </div>';

   return $a;
}

function hx_tgl($tanggal="now",$format='d M Y',$bahasa="id")
{
   $en = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat",
               "Jan","Feb","Mar","Apr","May","Jun","Jul",
               "Aug","Sep","Oct","Nov","Dec");

   $id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
               "Januari","Februari","Maret","April","Mei","Juni","Juli",
               "Agustus","September","Oktober","Nopember","Desember");

   if (empty($tanggal) || $tanggal=='0000-00-00' || $tanggal=='0000-00-00 00:00:00') {
      $tgl = '-';
   }
   else {
      $tgl = str_replace($en,$$bahasa,date($format,strtotime($tanggal)));
   }

   return $tgl;
}

function hx_umur($tanggal,$tipe='tahun')
{
   // PHP 5.3 +
   $a = date_create($tanggal);
   $b = date_create('today');
   if ($tipe=='tahun') {
      return $a->diff($b)->y;
   }
   else if ($tipe=='bulan') {
      return $a->diff($b)->y.' tahun '.$a->diff($b)->m.' bulan';
   }
   else if ($tipe=='thn-bln') {
      return $a->diff($b)->y.'-'.$a->diff($b)->m;
   }
   else {
      return '<strong>'.$a->diff($b)->y.'</strong> thn - <strong>'.$a->diff($b)->m.'</strong> bln - <strong>'.$a->diff($b)->d.'</strong> hari';
   }
}

function hx_rupiah($nominal,$koma=FALSE)
{
   $konversi = '-';

   if ($nominal) {
      if ($koma) {
         $desimal  = substr($nominal,-2);
         $nominal  = substr($nominal,0,-2);

         $konversi = number_format($nominal, 0, '', '.').','.$desimal;
      }
      else {
         $konversi = number_format($nominal, 0, '', '.');
      }
   }

   return $konversi;
}

function hx_rupiah_mysql($nominal,$koma=FALSE)
{
   if ($koma===FALSE) {
      $uang = $nominal;
      if (substr($nominal,-3,1)==',') {
         $uang = substr($nominal,0,-3);
      }
   }
   else {
      $uang = str_replace(',','',$nominal);
   }

   $uang = str_replace('.','',$uang);

   return $uang;
}

function hx_combo($key,$value,$combo,$induk=null)
{
   $arr = array();

   //print_r($combo); exit();

   foreach ($combo as $list) {
      if (is_array($value)) {
         $arr[$list[$key]] = $list[$value[0]].' - '.$list[$value[1]];
      }
      else {
         $val = $list[$value];
         $ke  = $list[$key];

         if ($induk) {
            $val = ($list['induk']=='Y') ? $list[$value] : ' - '.$list[$value];
            $ke  = ($list['induk']=='Y') ? 'xx'.$list[$key] : $list[$key];
         }

         $arr[$ke] = $val;
      }
   }

   //print_r($arr);

   return $arr;
}

function hx_tgl_excel_mysql($tanggal)
{
   list($tgl,$bln,$thn) = explode('/',$tanggal);

   return $thn.'-'.$bln.'-'.$tgl;
}

function hx_tgl_id_mysql($tanggal)
{
   if ($tanggal) {
      list($tgl,$bln,$thn) = explode('-',$tanggal);

      return $thn.'-'.$bln.'-'.$tgl;
   }
   else {
      return '0000-00-00';
   }
}

function hx_tgl_mysql_id($tanggal)
{
   $return = '';
   if ($tanggal) {
      if ($tanggal=='0000-00-00') {
         $return = '';
      }
      else {
         list($thn,$bln,$tgl) = explode('-',$tanggal);

         $return = $tgl.'-'.$bln.'-'.$thn;
      }
   }
   else {
      $return = '';
   }

   return $return;
}

function hx_icon_file($format)
{
   $tipe_file = array('.jpg'=>'file-picture-o text-success',
                      '.JPG'=>'file-picture-o text-success',
                      '.png'=>'file-picture-o text-success',
                      '.pdf'=>'file-pdf-o text-danger',
                      '.doc'=>'file-word-o text-primary',
                      '.docx'=>'file-word-o text-primary',
                      '.xls'=>'file-excel-o text-success',
                      '.xlsx'=>'file-excel-o text-success',
                      '.ppt'=>'file-powerpoint-o text-warning',
                      '.pptx'=>'file-powerpoint-o text-warning',
                      '.txt'=>'file-text-o text-muted',
                      '.rar'=>'file-zip-o text-danger',
                      '.zip'=>'file-zip-o text-warning');

   return $tipe_file[$format];
}