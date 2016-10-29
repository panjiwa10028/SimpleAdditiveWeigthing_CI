<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class HX_Controller extends CI_Controller {

   public $us;
   public $al;
   public $limit = 10;

   public function __construct()
   {
      parent::__construct();

      $this->us = $this->session->sess_user;
      $this->al = $this->session->sess_petugas;
   }

   public function view_admin($view,$load)
   {
      if (empty($this->us)) {
         $pesan = hx_info('warning','Silahkan Login terlebih dahulu');
         $this->session->set_flashdata('hx_info', $pesan);
		   redirect('login');
      }

      $load['_konten'] = $this->load->view('admin/'.$view,$load,TRUE);

      $this->load->view('template/admin',$load);
   }

   public function view_publik($view,$load)
   {
      $load['_konten'] = $this->load->view($view,$load,TRUE);

      $this->load->view('template/dashboard',$load);
   }
}