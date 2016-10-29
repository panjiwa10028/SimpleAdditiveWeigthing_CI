<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends HX_Controller {

   public $_subj  = 'Hasil';
   public $_ctrl  = 'hasil';
   public $_tabel = 'hasil';
   public $_kunci = 'id_hasil';
   public $_jenis = 'id_jenis_responden';
   public $_rsp   = 'id_responden';
   public $_pnykt = 'id_penyakit';
   public $_gjl   = 'id_gejala';

   public function __construct() {
      parent::__construct();
   }

   // mendefinisikan struktur tabel responden
   public function meta_data($tipe='auto') {
      // tabel
      if ($tipe=='tabel') {
         $field['nama_responden']  = array('label'=>'Nama Responden','tipe'=>'text');
         $field['jenis_responden'] = array('label'=>'Jenis Responden','tipe'=>'text');
         $field['tanggal']         = array('label'=>'Tanggal Udate','tipe'=>'tanggal','format'=>'d M Y');
         $field['penyakit']        = array('label'=>'Penyakit','tipe'=>'text');
      }

      // detail_penyakit
      else if ($tipe=='detail_penyakit') {
         $field['nama_penyakit']    = array('label'=>'Nama Penyakit','tipe'=>'text');
         $field['score']           = array('label'=>'Score','tipe'=>'text');
      }

      // detail_gejala
      else if ($tipe=='detail_gejala') {
         $field['nama_gejala']    = array('label'=>'Nama Gejala','tipe'=>'text');
         $field['score']           = array('label'=>'Score','tipe'=>'text');
      }      

      return $field;
   }

   public function index($offset=null) {
      $get     = $this->input->get();
      $like    = array();
      $get_na  = '';
      $get_tg1 = '';
      $get_tg2 = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_responden',$get['nama']));
      }

      if (isset($get['tanggal_start']) && $get['tanggal_start']) {
         $get_tg1    = $get['tanggal_start'];
         $like_tg11  = array(array('tanggal_start',$get['tanggal_start']));
      }

      if (isset($get['tanggal_end']) && $get['tanggal_end']) {
         $get_tg2    = $get['tanggal_end'];
         $like_tg2   = array(array('tanggal_start',$get['tanggal_end']));
      }

      $field['nama'] = array('label'=>'Cari Nama','tipe'=>'text','value'=>$get_na);
      $field['tanggal_start'] = array('label'=>'Tanggal Start','tipe'=>'tanggal', 'value'=>$get_tg1);
      $field['tanggal_end'] = array('label'=>'Tanggal End','tipe'=>'tanggal', 'value'=>$get_tg2);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/hasil/index'),$field,$get);

      $param['select'] = 'DISTINCT(hasil.id_responden), responden.nama_responden, responden.tanggal, jenis_responden.nama_jenis_responden as jenis_responden';
      $param['join']   = array(
         array('responden','jenis_responden.id_jenis_responden=responden.id_jenis_responden','left'),
         array('hasil','responden.id_responden=hasil.id_responden','right')
         );
      $param['order']  = 'nama_responden ASC';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;  
      if ((!empty($get_tg1)) && (!empty($get_tg2))) {
         $param['where']   = 'hasil.tanggal BETWEEN "'.$get_tg1.'" AND "'.$get_tg2.'"';
      } 
      // ambil data dari database
      $result   = $this->mm->get('jenis_responden',$param);
      foreach ($result as $key => $value) {
         $param            = array();
         $temp             = array();
         $param['select']  = 'penyakit.nama_penyakit, gejala.score';
         $param['join']    = array(
            array('hasil','gejala.id_gejala = hasil.id_gejala','left'),
            array('penyakit','gejala.id_penyakit = penyakit.id_penyakit','left'),
            );
         $param['where']   = 'hasil.id_responden="'.$value['id_responden'].'"';
         $param['order']   = 'penyakit.nama_penyakit ASC';
         $query            = $this->mm->get('gejala',$param);
         // Menghitung nilai bobot dari gejala
         foreach ($query as $k => $val) {
            if ($k === 0) {
               array_push($temp, $val);
            } else {
               foreach ($temp as $data => $v) {
                  if (in_array($val['nama_penyakit'], $v)) {
                     $temp[$data]['score'] += $val['score'];
                     array_pop($temp);
                  } else {
                     array_push($temp, $val);
                  }
               }
            }
         }
         // Mengurutkan nilai score tertinggi masing2 penyakit
         usort($temp, function($a, $b) {
            return $a['score'] <= $b['score'];
          });
         // Mengambil 1 index teratas
         array_splice($temp, 1);
         $result[$key]['penyakit']  = $temp[0]['nama_penyakit'];
         $result[$key]['score']     = $temp[0]['score'];
      }
      $jml_data = count($result);

      // menghitung jumlah data
      $jml_a    = ($offset) ? $offset+1 : 1;
      $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

      $hal['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $hal['jml_data']    = $jml_data;
      $hal['jml_a']       = $jml_a;
      $hal['jml_b']       = $jml_b;

      $arr['nomor_hal']   = $jml_a;
      $arr['kunci']       = $this->_rsp;
      $arr['master']      = null;

      //defenisikan tombol pilihan pada tabel
      $aksi['view']  = 'admin/'.$this->_ctrl.'/view';

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('tabel'),$result,$aksi);

      $load['_judul']  = 'Data '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      //tampilkan data ke view
      $this->view_admin('hx_hasil', $load);
   }

   // form input dan edit responden
   public function view($id, $offset=null) {
      $get    = $this->input->get();
      $like   = array();
      $get_na  = '';
      $get_tg1 = '';
      $get_tg2 = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_penyakit',$get['nama']));
      }

      if (isset($get['tanggal_start']) && $get['tanggal_start']) {
         $get_tg1    = $get['tanggal_start'];
         $like_tg11  = array(array('tanggal_start',$get['tanggal_start']));
      }

      if (isset($get['tanggal_end']) && $get['tanggal_end']) {
         $get_tg2    = $get['tanggal_end'];
         $like_tg2   = array(array('tanggal_start',$get['tanggal_end']));
      }

      $field['nama'] = array('label'=>'Cari Nama Penyakit','tipe'=>'text','value'=>$get_na);
      $field['tanggal_start'] = array('label'=>'Tanggal Start','tipe'=>'tanggal', 'value'=>$get_tg1);
      $field['tanggal_end'] = array('label'=>'Tanggal End','tipe'=>'tanggal', 'value'=>$get_tg2);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/hasil/view'),$field,$get);

      $param['select'] = 'penyakit.id_penyakit, penyakit.nama_penyakit';
      $param['order']  = 'nama_penyakit ASC';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;
      $result          = $this->mm->get('penyakit',$param);

      foreach ($result as $key => $value) {
         $param           = array();
         $param['select'] = 'sum(gejala.score) as score';
         $param['join']   = array(
            array('penyakit','gejala.id_penyakit=penyakit.id_penyakit','left'),
            array('hasil','gejala.id_gejala=hasil.id_gejala','right')
            );
         if ((!empty($get_tg1)) && (!empty($get_tg2))) {
            $param['where']   = 'hasil.id_responden='.$id.' AND penyakit.id_penyakit='.$value['id_penyakit'].'hasil.tanggal BETWEEN "'.$get_tg1.'" AND "'.$get_tg2.'"';
         } else {
            $param['where']  = 'hasil.id_responden='.$id.' AND penyakit.id_penyakit='.$value['id_penyakit'];
         }
         $param['order']  = 'penyakit.nama_penyakit ASC';
         $param['like']   = $like;
         $param['limit']  = $this->limit;
         $param['offset'] = $offset;
         $query           = $this->mm->get('gejala',$param);
         if (empty($query[0]['score'])) {
            unset($result[$key]);
         } else {
            $result[$key]['score'] = $query[0]['score'];
            $result[$key]['id_responden'] = $id;
         }
      }
      usort($result, function($a, $b) {
         return $a['score'] <= $b['score'];
       });
      $jml_data = count($result);

      $jml_a    = ($offset) ? $offset+1 : 1;
      $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

      $hal['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $hal['jml_data']    = $jml_data;
      $hal['jml_a']       = $jml_a;
      $hal['jml_b']       = $jml_b;

      $arr['nomor_hal']   = $jml_a;
      $arr['kunci']       = 'id_penyakit';
      $arr['master']      = 'id_responden';

      $aksi['view']  = 'admin/'.$this->_ctrl.'/view_gejala';

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('detail_penyakit'),$result,$aksi);

      $load['_judul']  = 'Data Penyakit '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      $this->view_admin('hx_detail', $load);
   }

   // form input dan edit responden
   public function view_gejala($id, $id_responden = null, $offset=null) {
      $get    = $this->input->get();
      $like   = array();
      $get_na  = '';
      $get_tg1 = '';
      $get_tg2 = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_penyakit',$get['nama']));
      }

      if (isset($get['tanggal_start']) && $get['tanggal_start']) {
         $get_tg1    = $get['tanggal_start'];
         $like_tg11  = array(array('tanggal_start',$get['tanggal_start']));
      }

      if (isset($get['tanggal_end']) && $get['tanggal_end']) {
         $get_tg2    = $get['tanggal_end'];
         $like_tg2   = array(array('tanggal_start',$get['tanggal_end']));
      }

      $field['nama'] = array('label'=>'Cari Nama Gejala','tipe'=>'text','value'=>$get_na);
      $field['tanggal_start'] = array('label'=>'Tanggal Start','tipe'=>'tanggal', 'value'=>$get_tg1);
      $field['tanggal_end'] = array('label'=>'Tanggal End','tipe'=>'tanggal', 'value'=>$get_tg2);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/hasil/view_gejala'),$field,$get);

      $param['select'] = 'hasil.id_gejala, gejala.nama_gejala, gejala.score';
      $param['join']   = array(
         array('gejala','hasil.id_gejala=gejala.id_gejala','left'),
         array('penyakit','gejala.id_penyakit=penyakit.id_penyakit','left')
         );
      if ((!empty($get_tg1)) && (!empty($get_tg2))) {
         $param['where']   = 'hasil.id_responden='.$id_responden.' AND penyakit.id_penyakit='.$id.'hasil.tanggal BETWEEN "'.$get_tg1.'" AND "'.$get_tg2.'"';
      } else {
         $param['where']   = 'hasil.id_responden='.$id_responden.' AND penyakit.id_penyakit='.$id;
      }
      $param['order']  = 'gejala.nama_gejala ASC';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;
      $result          = $this->mm->get('hasil',$param);

      usort($result, function($a, $b) {
         return $a['score'] <= $b['score'];
       });
      $jml_data = count($result);

      $jml_a    = ($offset) ? $offset+1 : 1;
      $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

      $hal['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $hal['jml_data']    = $jml_data;
      $hal['jml_a']       = $jml_a;
      $hal['jml_b']       = $jml_b;

      $arr['nomor_hal']   = $jml_a;
      $arr['kunci']       = 'id_gejala';
      $arr['master']      = null;

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('detail_gejala'),$result);

      $load['_judul']  = 'Data Penyakit '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      $this->view_admin('hx_detail', $load);
   }

}