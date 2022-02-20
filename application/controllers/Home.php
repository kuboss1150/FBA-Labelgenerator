<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends KS_Controller {
	
	public function __construct()
	{
		parent::__construct();	
	}

	public function index()
	{
		if ($this->ion_auth->logged_in()){
			if($this->ion_auth->is_admin()){
				redirect('auth/index');
			}elseif($this->ion_auth->in_group('members')){
				redirect('account/index');
			}
		}else{
			redirect('auth/login');
		}
	}
}
