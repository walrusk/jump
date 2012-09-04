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
			'loggedin' => $this->tank_auth->is_logged_in(),
			'days' => $this->Jump_model->last_x_days(5),
		);
	
		$lastday = strtotime(array_pop(array_keys($data['days'])));
		$data['nextday'] = date('Y-m-d',strtotime('-1 day',$lastday));
	
		$this->load->view('header');
		
		if($this->tank_auth->is_logged_in())
			$this->load->view('form_newphoto');
		
		$this->load->view('content', $data);
		$this->load->view('footer');
	}
	
	public function day()
	{
		
	}
	
	public function archive()
	{
		$this->load->model('Jump_model');
	
		$last_date_displayed = $this->uri->segment(2);
	
		$data = array(
			'loggedin' => $this->tank_auth->is_logged_in(),
			'days' => $this->Jump_model->last_x_days(5, $last_date_displayed),
			'archive' => TRUE
		);
		
		$data['nomore'] = in_array('2012-08-28', array_keys($data['days']));
		
		$lastday = strtotime(array_pop(array_keys($data['days'])));
		$data['nextday'] = date('Y-m-d',strtotime('-1 day',$lastday));
		
		$this->load->view('header');
		$this->load->view('content', $data);
		$this->load->view('footer');
	}
	
	/*** ADMIN ACTIONS ***/
	public function deletephoto()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/login/');
		} else {
			
			$photo_id = $this->uri->segment(3);
			
			$this->load->model('Jump_model');
			$this->Jump_model->delete_photo($photo_id);
			
			redirect('');
		}
	}
	
	public function newphoto()
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
	
	public function credits()
	{
		$this->load->view('header');
		$this->load->view('credits');
		$this->load->view('footer');
	}
}

/* End of file jump.php */
/* Location: ./application/controllers/jump.php */