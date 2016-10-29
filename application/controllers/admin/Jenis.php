<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis extends HX_Controller {

   public $_subj  = 'Jenis Responden';
   public $_ctrl  = 'jenis';
   public $_child = 'responden';
   public $_tabel = 'jenis_responden';
   public $_kunci = 'id_jenis_responden';

   public function __construct() {
      parent::__construct();
   }

   public function meta_data($tipe='auto') {
      // tabel
      if ($tipe=='tabel') {
         $field['nama_jenis_responden'] = array('label'=>'Nama Jenis Responden','tipe'=>'text');
      }

      // form
      else if ($tipe=='form') {
         $field['nama_jenis_responden'] = array('label'=>'Nama Jenis Responden','tipe'=>'text','attr'=>'required');
      }

      else if ($tipe=='child') {
         $field['nama_responden']  = array('label'=>'Nama Responden','tipe'=>'text');
         $field['tanggal']         = array('label'=>'Tanggal Udate','tipe'=>'tanggal','format'=>'d M Y');
      }

      return $field;
   }

	public function index($offset=null) {

      $get    = $this->input->get();
      $like   = array();
      $get_na = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_jenis_responden',$get['nama']));
      }

      $field['nama'] = array('label'=>'Cari Jenis Responden','tipe'=>'text','value'=>$get_na);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/jenis/index'),$field,$get);

      // parameter utk ambil data dr database
      $param['order']  = 'nama_jenis_responden ASC';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;

      $result   = $this->mm->get($this->_tabel,$param);
      $jml_data = $this->mm->count($this->_tabel,$param);
      $jml_a    = ($offset) ? $offset+1 : 1;
      $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

      $hal['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $hal['jml_data']    = $jml_data;
      $hal['jml_a']       = $jml_a;
      $hal['jml_b']       = $jml_b;

      $arr['nomor_hal']   = $jml_a;
      $arr['kunci']       = $this->_kunci;
      $arr['master']      = null;

      $aksi['view']  = 'admin/'.$this->_ctrl.'/view';
      $aksi['edit']  = 'admin/'.$this->_ctrl.'/form';
      $aksi['hapus'] = 'admin/aksi/hapus/'.$this->_ctrl.'/index/'.$this->_tabel.'/'.$this->_kunci;

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('tabel'),$result,$aksi);

      $load['_judul']  = 'Data '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      $this->view_admin('hx_view', $load);
	}

   public function view($id, $offset=null) {
      $get    = $this->input->get();
      $like   = array();
      $get_na = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_gejala',$get['nama']));
      }

      $field['nama'] = array('label'=>'Cari Nama Responden','tipe'=>'text','value'=>$get_na);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/jenis/view/'.$id),$field,$get);

      // parameter utk ambil data dr database
      $param['select'] = 'responden.foto, responden.nama_responden, responden.tanggal';
      $param['join']   = array(array('jenis_responden','responden.id_jenis_responden=jenis_responden.id_jenis_responden','left'));
      $param['where']  = $this->_child.'.'.$this->_kunci.'="'.$id.'"';
      $param['order']  = 'responden.nama_responden ASC';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;

      $result   = $this->mm->get($this->_child,$param);
      $jml_data = $this->mm->count($this->_child,$param);

      $jml_a    = ($offset) ? $offset+1 : 1;
      $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

      $hal['url_halaman'] = 'admin/'.$this->_ctrl.'/index';
      $hal['jml_data']    = $jml_data;
      $hal['jml_a']       = $jml_a;
      $hal['jml_b']       = $jml_b;

      $arr['nomor_hal']   = $jml_a;
      $arr['kunci']       = $this->_kunci;

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('child'),$result);

      $load['_judul']  = 'Data '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      $this->view_admin('hx_detail', $load);
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

   public function simpan($ctrl,$url,$tabel,$kunci){
      $post = $this->input->post();
      $id   = ($post[$kunci]) ? $post[$kunci] : null;

      if ($id) {

         $save  = $this->mm->save($tabel,$post,array($kunci=>$id));

         if ($save) {
            $pesan = hx_info('success','Perubahan data telah tersimpan');

            // $url = 'view/'.$id;
         } else {
            $pesan = hx_info('danger','Perubahan data gagal tersimpan');
         }
      } else {

         $save = $this->mm->save($tabel,$post);

         if ($save) {
            $pesan = hx_info('success','Data telah tersimpan');

            // $url = 'view/'.$save;
         } else {
            $pesan = hx_info('danger','Data gagal tersimpan');
         }
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }
}