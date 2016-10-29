<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Responden extends HX_Controller {

   public $_subj  = 'Responden';
   public $_ctrl  = 'responden';
   public $_tabel = 'responden';
   public $_kunci = 'id_responden';

   public function __construct() {
      parent::__construct();
   }

   // mendefinisikan struktur tabel responden
   public function meta_data($tipe='auto') {
      // tabel
      if ($tipe=='tabel') {
         $field['foto']            = array('label'=>'Foto',
                                        'tipe'=>'foto',
                                        'path_file'=>'as/foto_responden',
                                        'lebar'=>'60px',
                                        'upload'=>'admin/'.$this->_ctrl.'/form_upload');

         $field['nama_responden']  = array('label'=>'Nama Responden','tipe'=>'text');
         $field['jenis_responden'] = array('label'=>'Jenis Responden','tipe'=>'text');
         $field['tanggal']         = array('label'=>'Tanggal Udate','tipe'=>'tanggal','format'=>'d M Y');
      }

      // form
      else if ($tipe=='form') {

         $param['select'] = 'nama_jenis_responden';
         $ls_jenis = $this->mm->get('jenis_responden',$param);
         $temp = array();
         foreach ($ls_jenis as $key => $value) {
            $temp[$value['nama_jenis_responden']] = $value['nama_jenis_responden'];
         }
         $field['nama_responden']  = array('label'=>'Nama Lengkap','tipe'=>'text','attr'=>'required');
         $field['tanggal'] = array('label'=>'Tanggal Udate','tipe'=>'tanggal','attr'=>'required');
         $field['id_jenis_responden'] = array('label'=>'Jenis Responden','tipe'=>'select','list'=>$temp);
         $field['foto']          = array('label'=>'Foto Pribadi','tipe'=>'file');

      }

      // rangking table
      else if ($tipe=='rangking') {
         $field['nama_gejala']  = array('label'=>'Nama Gejala','tipe'=>'text','attr'=>'required');
         $field['status']       = array('label'=>'Status Responden','tipe'=>'text', 'attr'=>'required');
      } 

      else if ($tipe=='rangking_form') {
         $field['nama_gejala']  = array('label'=>'Nama Gejala','tipe'=>'text','attr'=>'required');
         $field['status']       = array('label'=>'Status','tipe'=>'radio','list'=>array('YA'=>'YA','TIDAK'=>'TIDAK'));
      }

      else if ($tipe=='rangking_hasil') {
         $field['nama_penyakit']  = array('label'=>'Nama Penyakit','tipe'=>'text','attr'=>'required');
         $field['score']          = array('label'=>'Score','tipe'=>'text','attr'=>'required');
      }      

      return $field;
   }

   public function index($offset=null) {
      $get    = $this->input->get();
      $like   = array();
      $get_na = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_responden',$get['nama']));
      }

      $field['nama'] = array('label'=>'Cari Nama','tipe'=>'text','value'=>$get_na);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/responden/index'),$field,$get);

      // parameter utk ambil data dr database
      $param['select'] = 'responden.*, jenis_responden.nama_jenis_responden as jenis_responden';
      $param['join']   = array(array('responden','jenis_responden.id_jenis_responden=responden.id_jenis_responden','right'));
      $param['order']  = 'nama_responden ASC';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;

      // ambil data dari database
      $result   = $this->mm->get('jenis_responden',$param);
      $jml_data = $this->mm->count('jenis_responden',$param);

      // menghitung jumlah data
      $jml_a    = ($offset) ? $offset+1 : 1;
      $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

      $hal['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $hal['jml_data']    = $jml_data;
      $hal['jml_a']       = $jml_a;
      $hal['jml_b']       = $jml_b;

      $arr['nomor_hal']   = $jml_a;
      $arr['kunci']       = $this->_kunci;
      $arr['master']      = null;

      //defenisikan tombol pilihan pada tabel
      $aksi['view']  = 'admin/'.$this->_ctrl.'/view';
      $aksi['edit']  = 'admin/'.$this->_ctrl.'/form';
      $aksi['hapus'] = 'admin/aksi/hapus/'.$this->_ctrl.'/index/'.$this->_tabel.'/'.$this->_kunci;

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('tabel'),$result,$aksi);

      $load['_judul']  = 'Data '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      //tampilkan data ke view
      $this->view_admin('hx_view', $load);
   }

   // form input dan edit responden
   public function view($id, $offset=null) {
      $get    = $this->input->get();
      $like   = array();
      $get_na = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_gejala',$get['nama']));
      }

      $field['nama'] = array('label'=>'Cari Nama Gejala','tipe'=>'text','value'=>$get_na);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/responden/view/'.$id),$field,$get);

      $param['select'] = 'gejala.id_gejala, gejala.nama_gejala';  
      $param['order']  = 'gejala.nama_gejala ASC';
      $param['like']   = $like;
      $param['offset'] = $offset;

      $result          = $this->mm->get('gejala',$param);
      foreach ($result as $key => $value) {
         $param = array();
         $param['select']        = 'if(count(id_gejala) > 0,"YA","TIDAK") as status';
         $param['join']          = array(array('responden','hasil.id_responden=responden.id_responden','left'));
         $param['where']         = 'responden.id_responden="'.$id.'" AND hasil.id_gejala="'.$value['id_gejala'].'"';
         $query                  = $this->mm->get('hasil',$param,'roar');
         $result[$key]['status'] = $query['status'];
         $result[$key]['id_responden'] = $id;
      }
      $jml_data = count($result);

      // Menampilkan hasil dari perangkingan yang dilakukan
      $param           = array();
      $param['select'] = 'penyakit.id_penyakit, penyakit.nama_penyakit';
      $param['order']  = 'nama_penyakit ASC';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;
      $hasil          = $this->mm->get('penyakit',$param);

      foreach ($hasil as $key => $value) {
         $param           = array();
         $param['select'] = 'sum(gejala.score) as score';
         $param['join']   = array(
            array('penyakit','gejala.id_penyakit=penyakit.id_penyakit','left'),
            array('hasil','gejala.id_gejala=hasil.id_gejala','right')
            );
         $param['where']  = 'hasil.id_responden='.$id.' AND penyakit.id_penyakit='.$value['id_penyakit'];
         $param['order']  = 'penyakit.nama_penyakit ASC';
         $param['like']   = $like;
         $param['limit']  = $this->limit;
         $param['offset'] = $offset;
         $query           = $this->mm->get('gejala',$param);
         if (empty($query[0]['score'])) {
            unset($hasil[$key]);
         } else {
            $hasil[$key]['score'] = $query[0]['score'];
         }
      }
      usort($hasil, function($a, $b) {
         return $a['score'] <= $b['score'];
       });
      $jum_hsl  = count($hasil);

      // Mengambail data responden
      $param['select'] = 'responden.nama_responden, jenis_responden.nama_jenis_responden';  
      $param['order']  = 'responden.nama_responden ASC';
      $param['join']   = array(
            array('jenis_responden','responden.id_jenis_responden=jenis_responden.id_jenis_responden','left')
            );
      $param['where']  = 'responden.id_responden='.$id;

      $responden       = $this->mm->get('responden',$param);

      $jml_a    = ($offset) ? $offset+1 : 1;
      $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

      $hal['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $hal['jml_data']    = $jml_data;
      $hal['jml_a']       = $jml_a;
      $hal['jml_b']       = $jml_b;

      $arr['nomor_hal']   = $jml_a;
      $arr['kunci']       = 'id_gejala';
      $arr['master']      = 'id_responden';

      $aksi['add']   = 'admin/'.$this->_ctrl.'/simpan_hasil';
      $aksi['hapus'] = 'admin/aksi/hapus_hasil/'.$this->_ctrl.'/view/hasil/'.$id;

      $jml_x    = ($offset) ? $offset+1 : 1;
      $jml_y    = (($offset+count($hasil))!=$jum_hsl) ? $offset+$this->limit : $jum_hsl;

      $out['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $out['jml_data']    = $jum_hsl;
      $out['jml_a']       = $jml_x;
      $out['jml_b']       = $jml_y;

      $hsl['nomor_hal']   = $jml_x;
      $hsl['kunci']       = 'id_penyakit';
      $hsl['master']      = null;

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('rangking'),$result,$aksi);

      $load['_judul']  = 'Data Gejala '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      $load['_hasil']  = $hasil;
      $load['_detail'] = $responden[0];
      // print_r($load['_detail']);exit();

      $load['_paging_hasil'] = $this->hx_tabel->set_halaman($out,$this->limit,4);
      $load['_tabel_hasil']  = $this->hx_tabel->set_tabel($hsl,$this->meta_data('rangking_hasil'),$hasil);

      $load['_judul_hasil']  = 'Data Hasil Perangkingan Gejala '.$this->_subj.' (<b class="text-warning">'.$jum_hsl.'</b>)';

      $this->view_admin('hx_detail', $load);
   }

   public function ubah($id=null, $master=null) {
      $this->load->library('hx_form');

      $arr['kunci']    = 'id_gejala';
      $arr['master']   = 'id_responden';
      $arr['subjek']   = 'Gejala';
      $arr['url_save'] = 'admin/'.$this->_ctrl.'/simpan_hasil/'.$this->_ctrl.'/index/hasil/id_gejala/id_responden';
      $arr['cs_form']  = 'vertical';
      $arr['cs_modal'] = '';
      $arr['layout']   = 'single';
      $arr['attr']     = 'enctype="multipart/form-data"';

      //jika edit
      $values = array();
      if ($id) {
         $param = array();
         $param['select']        = 'responden.id_responden, gejala.id_gejala, gejala.nama_gejala, if(count(gejala.id_gejala) > 0,"YA","TIDAK") as status';
         $param['join']          = array(array('responden','hasil.id_responden=responden.id_responden','left'),array('gejala','hasil.id_gejala=gejala.id_gejala','left'));
         $param['where']         = 'responden.id_responden="'.$master.'" AND gejala.id_gejala="'.$id.'"';
         $values                 = $this->mm->get('hasil',$param,'roar');
      }

      echo $this->hx_form->set_template($arr,$this->meta_data('rangking_form'),$values);
   }

   public function form($id=null) {
      $this->load->library('hx_form');

      $arr['kunci']    = $this->_kunci;
      $arr['master']   = null;
      $arr['subjek']   = $this->_subj;
      $arr['url_save'] = 'admin/'.$this->_ctrl.'/simpan/'.$this->_ctrl.'/index/'.$this->_tabel.'/'.$this->_kunci;
      $arr['cs_form']  = 'vertical';
      $arr['cs_modal'] = '';
      $arr['layout']   = 'single';
      $arr['attr']     = 'enctype="multipart/form-data"';

      //jika edit
      $values = array();
      if ($id) {
         $values = $this->mm->get($this->_tabel,array('where'=>$this->_kunci.'='.$id),'roar');
      }

      echo $this->hx_form->set_template($arr,$this->meta_data('form'),$values);
   }

   // proses simpan data responden
   public function simpan($ctrl,$url,$tabel,$kunci) {
      $post = $this->input->post();
      $id   = ($post[$kunci]) ? $post[$kunci] : null;

      $post['tanggal'] = hx_tgl_id_mysql($post['tanggal']);
      $values = $this->mm->get('jenis_responden',array('where'=>'nama_jenis_responden ="'.$post['id_jenis_responden'].'"'),'roar');
      $post['id_jenis_responden'] = $values['id_jenis_responden'];

      if ($id) {

         $save  = $this->mm->save($tabel,$post,array($kunci=>$id));

         if ($save) {
            $pesan = hx_info('success','Perubahan data telah tersimpan');

            $url = 'view/'.$id;
         }
         else {
            $pesan = hx_info('danger','Perubahan data gagal tersimpan');
         }
      }
      else {

         $save = $this->mm->save($tabel,$post);

         if ($save) {
            $pesan = hx_info('success','Data telah tersimpan');

            $url = 'view/'.$save;
         }
         else {
            $pesan = hx_info('danger','Data gagal tersimpan');
         }
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }

   public function simpan_hasil($id,$fk) {
      $admin   = $this->us['id_admin'];
      $values = $this->mm->get('hasil',array('where'=>'id_user='.$admin.' AND id_responden='.$fk.' AND id_gejala='.$id),'roar');
      if ($values) {
         $pesan = hx_info('warning','Data telah dipilih');
      } else {
         $data = array(
            'id_responden' => $fk,
            'id_gejala'    => $id,
            'id_user'     => $admin
            );
         $save = $this->mm->save('hasil',$data);

         if ($save) {
            $pesan = hx_info('success','Data telah tersimpan');

            $url = 'view/'.$save;
         }
         else {
            $pesan = hx_info('danger','Data gagal tersimpan');
         }
      }
      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/responden/view/'.$fk);
   }
}