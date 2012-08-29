<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jump extends CI_Controller {

	public function index()
	{
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/jump.php */