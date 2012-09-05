<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jump_model extends CI_Model {
	
	function __construct()
	{
        parent::__construct();
        
		$this->load->library('tank_auth');
		$this->load->database();
    }
  
    public function photos_from_timeframe($date, $seconddate)
    {
	    if(!is_numeric($date)) $date = strtotime($date);
	    if(!is_numeric($seconddate)) $seconddate = strtotime($seconddate);
    
	    $days = array();
	    
	    $this->db->select('*');
	    $this->db->order_by("photodate desc, sequence desc, id desc");

	    if($seconddate > $date)
	    {
	    	$this->db->where('photodate <=', date('Y-m-d',$seconddate));
	    	$this->db->where('photodate >=', date('Y-m-d',$date));
	    }
	    else
	    {	
	    	$this->db->where('photodate <=', date('Y-m-d',$date));
	    	$this->db->where('photodate >=', date('Y-m-d',$seconddate));
	    }	    

	    $query = $this->db->get('photos');
	    
	    foreach($query->result_array() as $key => $photo)
	    {
	    	// add helpful classes/ids
	    	$photo['index'] = $key;
	    	
	    	// add to days array
	    	$days[ $photo['photodate'] ][] = $photo;
	    }
	    
	    return $days;
    }
  
    public function last_date_photo_taken()
    {
    	$toreturn = "0000-00-00";
    
	    // get last photo
    	$this->db->select('photodate');
	    $this->db->order_by("photodate desc, id desc");
	    $this->db->limit(1);
	    $query = $this->db->get('photos');
	    
	    if($query->num_rows() > 0)
	    {
	    	$lastimage = $query->row_array();
	    	$toreturn = $lastimage['photodate'];
	    }
	    
	    return $toreturn;
    }
  
    public function last_x_days($x = 7, $starting_point = "last-taken")
    {
    	if($starting_point == "last-taken") $starting_point = $this->last_date_photo_taken();
    
    	$from = strtotime($starting_point);
    	$to = strtotime('-'.($x-1).' days',$from);
    
	    return $this->photos_from_timeframe($from, $to);
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
    
    public function delete_photo($photo_id)
    {
	    return $this->db->delete('photos', array('id' => $photo_id)); 
    }
}