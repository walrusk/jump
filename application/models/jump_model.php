<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jump_model extends CI_Model {
	
	function __construct()
	{
        parent::__construct();
        
		$this->load->library('tank_auth');
		$this->load->database();
    }
  
    public function latest_x_days($x = 5)
    {
    	$days = array();
    
    	// get last photo
    	$this->db->select('photodate');
	    $this->db->order_by("photodate desc, id desc");
	    $this->db->limit(1);
	    $query = $this->db->get('photos');
	    
	    if($query->num_rows() > 0)
	    {
		    $lastimage = $query->row_array();
		    $fetch_since = date('Y-m-d',strtotime('-'.($x+1).' days',strtotime($lastimage['photodate'])));
    
		    $this->db->select('*');
		    $this->db->order_by("photodate desc, id desc");
	
		    $this->db->where('photodate >', $fetch_since);
	
		    $query = $this->db->get('photos');
		    
		    
		    foreach($query->result_array() as $key => $photo)
		    {
		    	// add helpful classes/ids
		    	$photo['index'] = $key;
		    	
		    	// add to days array
		    	$days[ $photo['photodate'] ][] = $photo;
		    }
	    }
	    
	    return $days;
    }  
    
    public function latest_x_photos($x = 5)
    {
	    $this->db->select('*');
	    $this->db->limit($x);
	    $this->db->order_by("photodate desc, id asc");

	    $query = $this->db->get('photos');
	    
	    return $query->result_array();
    }
    
    public function save_photo($date, $path, $caption = "") /* requires photo date and path, caption is optional */
    {
	    $timestamp = date('Y-m-d H:i:s');
	    
	    $photodata = array(
	    	'user_id' => $this->tank_auth->get_user_id(),
	    	'created' => $timestamp,
	    	'updated' => $timestamp,
	    	'photodate' => $date,
	    	'photopath' => $path,
	    	'caption' => $caption
	    );
	    
	    return $this->db->insert('photos', $photodata);
    }
}