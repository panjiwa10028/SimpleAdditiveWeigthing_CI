<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends HX_Controller {

   public $_subj  = 'Admin';
   public $_ctrl  = 'admin';
   public $_tabel = 'admin';
   public $_kunci = 'id_admin';

   public function __construct() {
      parent::__construct();
   }

   public function meta_data($tipe='auto') {
      // tabel
      if ($tipe=='tabel') {
         $field['foto'] = array(
            'label'=>'Gambar',
            'tipe'=>'foto',
            'path_file'=>'as/img',
            'lebar'=>'60px',
            'upload'=>'admin/'.$this->_ctrl.'/form_upload'
            );

         $field['nama']           = array('label'=>'Nama Lengkap','tipe'=>'text');
         $field['email']          = array('label'=>'Email','tipe'=>'text');
         $field['login_terakhir'] = array('label'=>'Login Terakhir','tipe'=>'tanggal','format'=>'d M Y H:i');
      }

      // form
      else if ($tipe=='form') {
         $field['nama']     = array('label'=>'Nama Lengkap','tipe'=>'text','attr'=>'required');
         $field['email']    = array('label'=>'Email','tipe'=>'text','attr'=>'required');
         $field['password'] = array('label'=>'Password','tipe'=>'password');
         $field['foto']     = array('label'=>'Foto Profil','tipe'=>'file');
      }

      return $field;
   }

   public function index($offset=null) {
      // parameter utk ambil data dr database
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

      $aksi['edit']  = 'admin/'.$this->_ctrl.'/form';
      $aksi['hapus'] = 'admin/aksi/hapus/'.$this->_ctrl.'/index/'.$this->_tabel.'/'.$this->_kunci;

      // generate HTML
      $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
      $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$this->meta_data('tabel'),$result,$aksi);

      $load['_judul']  = 'Data '.$this->_subj.' (<b class="text-warning">'.$jml_data.'</b>)';

      $this->view_admin('hx_view', $load);
   }

   public function form($id=null) {
      $this->load->library('hx_form');

      $arr['kunci']    = $this->_kunci;
      $arr['master']   = null;
      $arr['subjek']   = $this->_subj;
      $arr['url_save'] = 'admin/'.$this->_ctrl.'/simpan/'.$this->_ctrl.'/index/'.$this->_tabel.'/'.$this->_kunci;
      $arr['cs_form']  = 'vertical';
      $arr['cs_modal'] = 'modal-kecil';
      $arr['layout']   = 'single';
      $arr['attr']     = 'enctype="multipart/form-data"';

      //jika edit
      $values = array();
      if ($id) {
         $values = $this->mm->get($this->_tabel,array('where'=>$this->_kunci.'='.$id),'roar');
         $values['password'] = '';
      }

      echo $this->hx_form->set_template($arr,$this->meta_data('form'),$values);
   }

   public function form_upload($id,$field,$file=null) {
      $this->load->library('hx_form');

      if ($file) {
       $arr_upload['foto'] = $file;
    }

    $arr_upload['ext']  = 'jpg,png';
    $arr_upload['size'] = '2097152';
    $arr_upload['path'] = 'as/img';

    $arr_upload['tabel']        = $this->_tabel;
    $arr_upload['kunci']        = $this->_kunci;
    $arr_upload['url_redirect'] = 'admin/'.$this->_ctrl.'/index';
    $arr_upload['url_upload']   = 'admin/aksi/upload_file';

    echo $this->hx_form->set_upload($arr_upload,$id,$field);
 }

 public function simpan($ctrl,$url,$tabel,$kunci) {
   $post = $this->input->post();
   $id   = ($post[$kunci]) ? $post[$kunci] : null;

   if ($post['password']) {
      $post['password'] = sha1($post['password']);
   }

   if ($id) {

      if ($_FILES) {
         $rand = rand(111111111,999999999);
         $nama = $tabel.'-foto-'.$rand;

         $config['upload_path']   = './as/foto_admin/';
         $config['allowed_types'] = 'jpg|png';
         $config['file_name']     = $nama;

         $this->load->library('upload', $config);

         if ($this->upload->do_upload('foto')) {
            $file = $this->upload->data();

            $post['foto'] = $file['file_name'];
         }
      }

      $save  = $this->mm->save($tabel,$post,array($kunci=>$id));

      if ($save) {
         $pesan = hx_info('success','Perubahan data telah tersimpan');

            // $url = 'view/'.$id;
      }
      else {
         $pesan = hx_info('danger','Perubahan data gagal tersimpan');
      }
   }
   else {

      if ($_FILES) {
         $rand = rand(111111111,999999999);
         $nama = $tabel.'-foto-'.$rand;

         $config['upload_path']   = './as/img/';
         $config['allowed_types'] = 'jpg|png';
         $config['file_name']     = $nama;

         $this->load->library('upload', $config);

         if ($this->upload->do_upload('foto')) {
            $file = $this->upload->data();

            $post['foto'] = $file['file_name'];
         }
      }

      $save = $this->mm->save($tabel,$post);

      if ($save) {
         $pesan = hx_info('success','Data telah tersimpan');

            // $url = 'view/'.$save;
      }
      else {
         $pesan = hx_info('danger','Data gagal tersimpan');
      }
   }

   $this->session->set_flashdata('hx_info',$pesan);
   redirect('admin/'.$ctrl.'/'.$url);
}
}