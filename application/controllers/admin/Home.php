<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends HX_Controller {

   public function __construct()
   {
      parent::__construct();
   }

	public function index()
	{
      $load['_judul'] = 'Dashboard';

      $this->view_admin('home', $load);
	}
}