<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends HX_Controller {

   public $_subj  = 'Berita';
   public $_ctrl  = 'berita';
   public $_tabel = 'berita';
   public $_kunci = 'id_berita';

   public function __construct()
   {
      parent::__construct();
   }

   public function meta_data($tipe='auto')
   {
      //tabel
      if ($tipe=='tabel') {
         $field['gambar']       = array('label'=>'Gambar',
                                        'tipe'=>'foto',
                                        'path_file'=>'as/foto_berita',
                                        'lebar'=>'100px',
                                        'upload'=>'admin/'.$this->_ctrl.'/form_upload');

         $field['judul_berita'] = array('label'=>'Judul Berita','tipe'=>'text');
         $field['admin']        = array('label'=>'Penulis','tipe'=>'text');
         $field['tanggal_post'] = array('label'=>'Tanggal Post','tipe'=>'tanggal','format'=>'d M Y');
      }

      //form
      else if ($tipe=='form') {
         $field['judul_berita'] = array('label'=>'Judul Berita','tipe'=>'text','attr'=>'required');
         $field['isi_berita']   = array('label'=>'Isi Berita','tipe'=>'editor');
         $field['gambar']       = array('label'=>'Gambar','tipe'=>'file');
      }

      return $field;
   }

	public function index($offset=null) {
      $param['select'] = 'berita.*, user.nama_lengkap as admin';
      $param['join']   = array(array('user','berita.id_user=user.id_user','left'));
      $param['order']  = 'tanggal_post DESC';
      //$param['like']   = $like;
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

   public function view($id)
   {
      $param['select'] = 'berita.*, user.nama_lengkap as admin';
      $param['join']   = array(array('user','berita.id_user=user.id_user','left'));
      $param['where']  = $this->_kunci.'='.$id;

      $load['result']  = $this->mm->get($this->_tabel,$param,'roar');

      $load['_judul']  = $load['result']['judul_berita'];
      $load['_desc']   = substr($load['result']['isi_berita'],0,250);
      $load['_img']    = ($load['result']['gambar']) ? base_url('as/foto_berita/'.$load['result']['gambar']) : '';

      $this->view_admin('v_detail_berita',$load);
   }

   public function form($id=null)
   {
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

	public function form_upload($id,$field,$file=null)
	{
      $this->load->library('hx_form');

      if ($file) {
	      $arr_upload['foto'] = $file;
      }

      $arr_upload['ext']  = 'jpg,png';
      $arr_upload['size'] = '2097152';
      $arr_upload['path'] = 'as/foto_berita';

      $arr_upload['tabel']        = $this->_tabel;
      $arr_upload['kunci']        = $this->_kunci;
      $arr_upload['url_redirect'] = 'admin/'.$this->_ctrl.'/view/'.$id;
      $arr_upload['url_upload']   = 'admin/aksi/upload_file';

      echo $this->hx_form->set_upload($arr_upload,$id,$field);
	}

   public function simpan($ctrl,$url,$tabel,$kunci)
   {
      $post = $this->input->post();
      $id   = ($post[$kunci]) ? $post[$kunci] : null;

      $post['id_user'] = $this->us['id_admin'];

      if ($id) {

         if ($_FILES) {
            $rand = rand(111111111,999999999);
            $nama = $tabel.'-gambar-'.$rand;

            $config['upload_path']   = './as/foto_berita/';
            $config['allowed_types'] = 'jpg|png';
            $config['file_name']     = $nama;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
               $file = $this->upload->data();

               $post['gambar'] = $file['file_name'];
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
            $nama = $tabel.'-gambar-'.$rand;

            $config['upload_path']   = './as/foto_berita/';
            $config['allowed_types'] = 'jpg|png';
            $config['file_name']     = $nama;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
               $file = $this->upload->data();

               $post['gambar'] = $file['file_name'];
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