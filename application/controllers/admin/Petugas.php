<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends HX_Controller {

   public $_subj  = 'Petugas';
   public $_ctrl  = 'petugas';
   public $_tabel = 'user';
   public $_kunci = 'id_user';

   public function __construct()
   {
      parent::__construct();
   }
   
   //mendefinisikan struktur tabel petugas
   public function meta_data($tipe='auto')
   {
      //tabel
      if ($tipe=='tabel') {
         $field['foto']        = array('label'=>'Foto',
                                        'tipe'=>'foto',
                                        'path_file'=>'as/foto_petugas',
                                        'lebar'=>'60px',
                                        'upload'=>'admin/'.$this->_ctrl.'/form_upload');

         $field['nama_lengkap']  = array('label'=>'Nama Petugas','tipe'=>'text');
         $field['jenis_kelamin'] = array('label'=>'L/P','tipe'=>'array','list'=>array('L'=>'Laki-laki','P'=>'Perempuan'));
         $field['tanggal_lahir'] = array('label'=>'Tanggal Lahir','tipe'=>'tanggal','format'=>'d M Y');
         $field['email']         = array('label'=>'Email','tipe'=>'text');
         $field['no_telp']       = array('label'=>'No Telepon','tipe'=>'text');
         $field['status']        = array('label'=>'Status','tipe'=>'text');
      }

      //form
      else if ($tipe=='form') {

         $field1['nama_lengkap']  = array('label'=>'Nama Lengkap','tipe'=>'text','attr'=>'required');
         $field1['tempat_lahir']  = array('label'=>'Tempat Lahir','tipe'=>'text','attr'=>'required');
         $field1['tanggal_lahir'] = array('label'=>'Tanggal Lahir','tipe'=>'tanggal','attr'=>'required');
         $field1['jenis_kelamin'] = array('label'=>'Jenis Kelamin','tipe'=>'radio','list'=>array('L'=>'Laki-laki','P'=>'Perempuan'));
         $field2['alamat']        = array('label'=>'Alamat','tipe'=>'textarea');
         $field2['no_telp']       = array('label'=>'No Telepon','tipe'=>'text');

         $field3['email']         = array('label'=>'Email <small><i>(Digunakan saat login)</i></small>','tipe'=>'text','attr'=>'required');
         $field3['password']      = array('label'=>'Password <small><i>(Digunakan saat login)</i></small>','tipe'=>'password');
         $field3['foto']          = array('label'=>'Foto Pribadi','tipe'=>'file');
         $field3['status']        = array('label'=>'Status','tipe'=>'radio','list'=>array('Aktif'=>'Aktif','Nonaktif'=>'Nonaktif'));

         $field = array('kolom1'=>array('class'=>'col-sm-4',
                                        'field'=>$field1,
                                        'judul'=>''),
                        'kolom2'=>array('class'=>'col-sm-4',
                                        'field'=>$field2,
                                        'judul'=>''),
                        'kolom3'=>array('class'=>'col-sm-4',
                                        'field'=>$field3,
                                        'judul'=>''));
      }

      return $field;
   }

   public function index($offset=null)
   {
      $get    = $this->input->get();
      $like   = array();
      $get_na = '';

      if (isset($get['nama']) && $get['nama']) {
         $get_na = $get['nama'];
         $like   = array(array('nama_lengkap',$get['nama']));
      }

      $field['nama'] = array('label'=>'Cari Nama','tipe'=>'text','value'=>$get_na);

      $load['pencarian'] = ($get) ? TRUE : FALSE;
      $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'admin/petugas/index'),$field,$get);

      //----------- parameter utk ambil data dr database ----------//
      $param['order']  = 'status DESC, nama_lengkap ASC';
      $param['where']  = 'level = 0';
      $param['like']   = $like;
      $param['limit']  = $this->limit;
      $param['offset'] = $offset;

      //ambil data dari database
      $result   = $this->mm->get($this->_tabel,$param);
      $jml_data = $this->mm->count($this->_tabel,$param);

      //menghitung jumlah data
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

   //halaman profil petugas
   public function view($id)
   {
      $param['where']  = $this->_kunci.'='.$id;

      //ambil data dari database
      $load['result']  = $this->mm->get($this->_tabel,$param,'roar');
      $load['_judul']  = 'Profil '.$this->_subj;

      $this->view_admin('v_detail_petugas',$load);
   }

   //form input dan edit petugas
   public function form($id=null)
   {
      $this->load->library('hx_form');

      $arr['kunci']    = $this->_kunci;
      $arr['master']   = null;
      $arr['subjek']   = $this->_subj;
      $arr['url_save'] = 'admin/'.$this->_ctrl.'/simpan/'.$this->_ctrl.'/index/'.$this->_tabel.'/'.$this->_kunci;
      $arr['cs_form']  = 'vertical';
      $arr['cs_modal'] = 'modal-besar';
      $arr['layout']   = 'multi';
      $arr['attr']     = 'enctype="multipart/form-data"';

      //jika edit
      $values = array();
      if ($id) {
         $values = $this->mm->get($this->_tabel,array('where'=>$this->_kunci.'='.$id),'roar');
      }

      echo $this->hx_form->set_template($arr,$this->meta_data('form'),$values);
   }

   //form upload foto petugas
   public function form_upload($id,$field,$file=null)
   {
      $this->load->library('hx_form');

      if ($file) {
         $arr_upload['foto'] = $file;
      }

      $arr_upload['ext']  = 'jpg,png';
      $arr_upload['size'] = '2097152';
      $arr_upload['path'] = 'as/foto_petugas';

      $arr_upload['tabel']        = $this->_tabel;
      $arr_upload['kunci']        = $this->_kunci;
      $arr_upload['url_redirect'] = 'admin/'.$this->_ctrl.'/view/'.$id;
      $arr_upload['url_upload']   = 'admin/aksi/upload_file';

      echo $this->hx_form->set_upload($arr_upload,$id,$field);
   }

   //proses simpan data petugas
   public function simpan($ctrl,$url,$tabel,$kunci)
   {
      $post = $this->input->post();
      $id   = ($post[$kunci]) ? $post[$kunci] : null;

      $post['tanggal_lahir'] = hx_tgl_id_mysql($post['tanggal_lahir']);

      if ($post['password']) {
         $post['password'] = sha1($post['password']);
      }
      else {
         unset($post['password']);
      }

      if ($id) {

         if ($_FILES) {
            $rand = rand(111111111,999999999);
            $nama = $tabel.'-foto-'.$rand;

            $config['upload_path']   = './as/foto_petugas/';
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

            $url = 'view/'.$id;
         }
         else {
            $pesan = hx_info('danger','Perubahan data gagal tersimpan');
         }
      }
      else {

         if ($_FILES) {
            $rand = rand(111111111,999999999);
            $nama = $tabel.'-foto-'.$rand;

            $config['upload_path']   = './as/foto_petugas/';
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

            $url = 'view/'.$save;
         }
         else {
            $pesan = hx_info('danger','Data gagal tersimpan');
         }
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }
}