<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jump extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('tank_auth');		
	}

	public function index()
	{
		$this->load->model('Jump_model');
	
		$data = array(
			'days' => $this->Jump_model->latest_x_days()
		);
	
		$this->load->view('header');
		
		if($this->tank_auth->is_logged_in())
			$this->load->view('form_newphoto');
		
		$this->load->view('content', $data);
		$this->load->view('footer');
	}
	
	public function day()
	{
		
	}
	
	/*** ADMIN ACTIONS ***/
	public function deletephoto()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			$this->load->view('welcome', $data);
		}
	}
	
	function newphoto()
	{	
		// GATHER DATA FOR NEW PHOTO
		$caption = $this->input->post('caption');
		$photodate = $this->input->post('photodate');
		
		$newfilename = strtolower(date('Y-F-d',strtotime($photodate)));
		
		// CONFIGURE UPLOAD
		$config['file_name'] = $newfilename.'.jpg';
		$config['upload_path'] = './photos/';
		$config['allowed_types'] = 'jpg';
		$config['max_size']	= '1024';
		$config['max_width']  = '1200';
		$config['max_height']  = '1200';

		// multiple photos on the same day
		$postfixnum = 2;
		while(file_exists($config['upload_path'].$config['file_name']))
		{
			$config['file_name'] = $newfilename.'_'.$postfixnum.'.jpg';
			$postfixnum++;
		}
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('photoupload'))
		{
			// ERROR UPLOADING
		
			$data = array(
				'loggedin' => $this->tank_auth->is_logged_in(),
				'error' => $this->upload->display_errors()
			);
			
			$this->load->view('header');
			$this->load->view('home', $data);
			$this->load->view('footer');
		}
		else
		{
			// UPLOADING SUCCESSFUL
		
			// save to db
			$uploaddata = $this->upload->data();
			
			$this->load->model('Jump_model');
			$this->Jump_model->save_photo($photodate, $uploaddata['file_name'], $caption);

			redirect('');
		}
	}	
}

/* End of file jump.php */
/* Location: ./application/controllers/jump.php */