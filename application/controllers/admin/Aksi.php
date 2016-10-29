<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aksi extends HX_Controller {

   public function __construct() {
      parent::__construct();
   }

   public function simpan($ctrl,$url,$tabel,$kunci) {
      $post = $this->input->post();
      $id   = ($post[$kunci]) ? $post[$kunci] : null;

      if ($id) {
         $save  = $this->mm->save($tabel,$post,array($kunci=>$id));

         if ($save) {
            $pesan = hx_info('success','Perubahan data telah tersimpan');
         }
         else {
            $pesan = hx_info('danger','Perubahan data gagal tersimpan');
         }
      }
      else {
         $save = $this->mm->save($tabel,$post);

         if ($save) {
            $pesan = hx_info('success','Data telah tersimpan');
         }
         else {
            $pesan = hx_info('danger','Data gagal tersimpan');
         }
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }

   public function hapus($ctrl,$url,$tabel,$kunci,$id) {
      $del = $this->mm->delete($tabel,array($kunci=>$id));

      if ($del) {
         $pesan = hx_info('success','Data telah dihapus');
      }
      else {
         $pesan = hx_info('danger','Data gagal dihapus');
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }

   public function hapus_hasil($ctrl,$url,$tabel,$kunci,$id) {
      $admin   = $this->us['id_admin'];
      $values = $this->mm->get('hasil',array('where'=>'id_user='.$admin.' AND id_responden='.$kunci.' AND id_gejala='.$id),'roar');
      if ($values) {
         $del = $this->mm->delete($tabel,array('id_responden'=>$kunci,'id_gejala'=>$id));
         if ($del) {
            $pesan = hx_info('success','Data telah dihapus');
         }
         else {
            $pesan = hx_info('danger','Data gagal dihapus');
         }
      } else {
         $pesan = hx_info('warning','Data tidak tersedia');
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url.'/'.$kunci);
   }

   public function ubah_status($ctrl,$url,$tabel,$kunci,$id,$field,$status) {
      $save = $this->mm->save($tabel,array($field=>$status),array($kunci=>$id));

      if ($save) {
         $pesan = hx_info('success',ucwords(str_replace('_',' ',$field)).' telah diubah');
      }
      else {
         $pesan = hx_info('danger',ucwords(str_replace('_',' ',$field)).' gagal diubah');
      }

      $this->session->set_flashdata('hx_info',$pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }

   public function upload_file() {
      $tabel = $this->input->post('tabel');
      $kunci = $this->input->post('kunci');
      $url   = $this->input->post('url');
      $field = $this->input->post('field_tabel');
      $id    = $this->input->post('id_tabel');
      $path  = $this->input->post('path');
      $ext   = $this->input->post('ext');

      $rand = rand(111111111,999999999);
      $nama = $tabel.'-'.$id.'-'.$field.'-'.$rand;

      $dir = dirname(BASEPATH);

      if (!file_exists($dir.'/'.$path)) {
         mkdir($dir.'/'.$path,0777,true);
      }

      $config['upload_path']   = $dir.'/'.$path;
      $config['allowed_types'] = $ext;
      $config['file_name']     = $nama;

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload($field)) {
         // $error = array('error'=>$this->upload->display_errors());
         // print_r($error); exit();

         $pesan = hx_info('danger','Gagal upload File '.ucwords(str_replace('_',' ',$field)));

         $this->session->set_flashdata('hx_info',$pesan);
         redirect($url);
      }
      else {
         $file = $this->upload->data();
         $data = array($field=>$file['file_name']);

         $save = $this->mm->save($tabel,$data,array($kunci=>$id));

         if ($save) {
            $pesan = hx_info('success','File '.ucwords(str_replace('_',' ',$field)).' berhasil diupload');
         }
         else {
            $pesan = hx_info('danger','Gagal upload File '.ucwords(str_replace('_',' ',$field)));
         }

         $this->session->set_flashdata('hx_info',$pesan);
         redirect($url);
      }
   }

   public function hapus_file($ctrl,$url,$tabel,$kunci,$id,$field,$file) {
      $get  = $this->input->get('path_file');

      $dir  = dirname(BASEPATH);
      $path = $dir.'/'.$get.'/'.$file;

      $del  = $this->mm->save($tabel,array($field=>''),array($kunci=>$id));

      if ($del) {
         unlink($path);

         $pesan = hx_info('success','File '.ucwords(str_replace('_',' ',$field)).' berhasil dihapus');
      }
      else {
         $pesan = hx_info('danger','File '.ucwords(str_replace('_',' ',$field)).' gagal dihapus');
      }

      $this->session->set_flashdata('hx_info', $pesan);
      redirect('admin/'.$ctrl.'/'.$url);
   }
}