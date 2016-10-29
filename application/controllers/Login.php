<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
   }


   //-------------------------------------------//
   //Login ADMIN
   //-------------------------------------------//

	public function index()
	{
	   $id = $this->session->sess_user;

      //cek apakah sudah ada sesi tersimpan atau belum
		if ($id) { //jika sudah alihkan ke halaman admin
         $pesan = hx_info('info','Sesi anda masih aktif');
         $this->session->set_flashdata('hx_info', $pesan);

		   redirect('admin/home');
      }
      else { //jika belum alihkan ke halaman login
         $this->load->view('admin/login');
      }
	}

   //cek apakah user yang login terdaftar atau tidak
   public function validasi()
   {
      $p = $this->input->post();

      if (empty($p)) {
         redirect('login');
      }

      //ambil data user dari database untuk dicocokan
      $user = $this->mm->get('user',array('where'=>'level = 1 AND email="'.$p['em'].'"'),'roar');

      //jika ada data user
      if ($user)
      {
         //jika password sesuai
         if (sha1($p['pw'])===$user['password'])
         {
            $tgl_login = hx_tgl(substr($user['login_terakhir'],0,10),'d-m-Y').' '.substr($user['login_terakhir'],11,5);

            $sess = array('id_admin'=>$user['id_user'],
                          'nama_lengkap'=>$user['nama_lengkap'],
                          'foto'=>$user['foto'],
                          'login_terakhir'=>$tgl_login);

            //simpan data user ke dalam session
            $this->session->set_userdata('sess_user',$sess);

            //update waktu login
            $update_login = array('login_terakhir'=>date('Y-m-d H:i:s'));
            $this->mm->save('user',$update_login,array('id_user'=>$user['id_admin']));

            $pesan = hx_info('info','Anda berhasil masuk ke sistem');
            $this->session->set_flashdata('hx_info', $pesan);

            //alihkan ke halaman admin
            redirect('admin/home');
         }
         //jika password salah
         else
         {
            $pesan = hx_info('danger','Password yang anda masukan salah');
            $this->session->set_flashdata('hx_info',$pesan);
            $this->session->set_flashdata('email',$p['em']);

            redirect('login');
         }
      }
      //jika data user tidak ditemukan
      else
      {
         $pesan = hx_info('danger','Anda belum terdaftar. Silahkan mengubungi Administrator');
         $this->session->set_flashdata('hx_info', $pesan);

         redirect('login');
      }
   }

   //form edit profil user
   public function form()
   {
      $this->load->library('hx_form');

      $arr['kunci']    = 'id_user';
      $arr['master']   = null;
      $arr['subjek']   = 'Profil Admin';
      $arr['url_save'] = 'login/simpan/home/index/user/id_user';
      $arr['cs_form']  = 'vertical';
      $arr['cs_modal'] = 'modal-kecil';
      $arr['layout']   = 'single';
      $arr['attr']     = 'enctype="multipart/form-data"';

      $id  = $this->session->sess_user['id_admin'];
      $val = $this->mm->get('user',array('where'=>'level = 1 AND id_user='.$id),'roar');

      // array field
      $field['nama_lengkap']     = array('label'=>'Nama Lengkap','tipe'=>'text','attr'=>'required');
      $field['email']    = array('label'=>'Email','tipe'=>'text','attr'=>'required');
      $field['password'] = array('label'=>'Password','tipe'=>'password');
      $field['foto']     = array('label'=>'Foto Profil','tipe'=>'file');

      echo $this->hx_form->set_template($arr,$field,$val);
   }

   //proses simpan data user
   public function simpan($ctrl,$url,$tabel,$kunci)
   {
      $us = $this->session->sess_user;

      $post = $this->input->post();
      $id   = ($post[$kunci]) ? $post[$kunci] : null;

      $update = array('nama_lengkap'=>$post['nama_lengkap'],
                      'email'=>$post['email']);

      if ($post['password']) {
         $update['password'] = sha1($post['password']);
      }
      else {
         unset($post['password']);
      }

      if ($_FILES) {
         $rand = rand(111111111,999999999);
         $nama = $tabel.'-'.$id.'-foto-'.$rand;

         $config['upload_path']   = './as/img/';
         $config['allowed_types'] = 'jpg|png';
         $config['file_name']     = $nama;

         $this->load->library('upload', $config);

         if ($this->upload->do_upload('foto')) {
            $file = $this->upload->data();

            $update['foto'] = $file['file_name'];
         }
      }

      $save = $this->mm->save($tabel,$update,array($kunci=>$id));

      if ($save) {
         $pesan = hx_info('success','Perubahan data telah tersimpan');

         //simpan aktivitas user
         //$this->mm->save_aktivitas('Ubah profil',$us,$tabel,$id);
      }
      else {
         $pesan = hx_info('danger','Perubahan data gagal tersimpan');
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }

   //logout user
   public function logout()
   {
      //hapus sesi
      $this->session->sess_destroy();

      $pesan = hx_info('info','Anda berhasil keluar dari sistem');
      $this->session->set_flashdata('hx_info', $pesan);

      //alihkan ke halaman login
		redirect('login');
   }


   //-------------------------------------------//
   //Login PETUGAS
   //-------------------------------------------//

   public function validasi_petugas()
   {
      $p = $this->input->post();

      if (empty($p)) {
         redirect('dashboard/index');
      }

      $user = $this->mm->get('user',array('select'=>'id_user,nama_lengkap,foto,password','where'=>'level = 0 AND email="'.$p['em'].'" AND status="Aktif"'),'roar');

      if ($user)
      {
         if (sha1($p['pw'])===$user['password'])
         {
            $sess = array('id_petugas'=>$user['id_user'],
                          'nama'=>$user['nama_lengkap'],
                          'foto'=>$user['foto']);

            $this->session->set_userdata('sess_petugas',$sess);

            $pesan = hx_info('info','Anda berhasil masuk ke sistem');
            $this->session->set_flashdata('hx_info', $pesan);

            redirect('dashboard/profil_petugas');
         }
         else
         {
            $pesan = hx_info('danger','Password yang anda masukan salah');
            $this->session->set_flashdata('hx_info',$pesan);

            redirect('dashboard/index');
         }
      }
      else
      {
         $pesan = hx_info('danger','Anda belum terdaftar. Silahkan mengubungi Administrator');
         $this->session->set_flashdata('hx_info', $pesan);

         redirect('dashboard/index');
      }
   }

   public function logout_user()
   {
      $this->session->sess_destroy();

      $pesan = hx_info('info','Anda berhasil keluar dari sistem');
      $this->session->set_flashdata('hx_info', $pesan);

		redirect('dashboard');
   }
}