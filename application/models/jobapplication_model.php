<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Jobapplication_model extends CI_Model {

    

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
   function show_countries(){
       
      $query = $this->db->get('countries');
      
      
       return $query->result();
       
   }
   function get_country($code){
       
       $query = $this->db->get_where('countries', array('country_code' => $code));
       
       foreach($query->result() as $row):$name= $row->country_name;
       endforeach;
       return $name;
       
   }
   function save_user_info($post_data){
       
       
       
    $data = array(
   'firstname' => $this->validatedata($post_data['first_name']) ,
   'lastname' => $this->validatedata($post_data['last_name']) ,
   'email' => $this->validatedata($post_data['email']),
   'address' => $this->validatedata($post_data['address']),
   'country_code' => $this->validatedata($post_data['countries']),
   'facebook_id' => $this->validatedata($post_data['facebook_id']),
   'linkedin_id' => $this->validatedata($post_data['linkedin_id']),    
   'ipAddress' => $_SERVER['REMOTE_ADDR']
            );
    
$success = $this->db->insert('userinfo', $data);   


return $success;
   }
       
   public function validatedata($data, $err = '') {

		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		
		return $data;
	} 
        
        public function get_country_social($location){
         $this->db->select('country_code');
        $this->db->from('countries');
        $this->db->like('country_name', $location);
        $query = $this->db->get();
        
        return $query->row();
        
        }
}