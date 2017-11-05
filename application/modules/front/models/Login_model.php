<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	function auth($email, $password, $remember=false)
    {
        // make sure the username doesn't go into the query as false or 0
        if(!$email)
        {
            return false;
        }
		
        $this->db->select('*');
       // $this->db->where('active', 1);
		$this->db->where('email', $email);
        $this->db->where('password',  sha1($password));
        $this->db->limit(1);
        $result = $this->db->get('guests');
        $result = $result->row_array();
        if (sizeof($result) > 0)
        {
            $admin = array();
            $admin['front_user'] = array();
            $admin['front_user']['id'] = $result['id'];
            $admin['front_user']['firstname'] = $result['firstname'];
			$admin['front_user']['lastname'] = $result['lastname'];
            $admin['front_user']['email'] = $result['email'];
			$admin['front_user']['mobile'] = $result['mobile'];
			$admin['front_user']['idCategory'] = $result['idCategory'];
            
            if($remember)
            {
                $loginCred = json_encode(array('username'=>$username, 'password'=>$password));
                $loginCred = base64_encode($this->aes256Encrypt($loginCred));
                //remember the user for 6 months
                $this->generateCookie($loginCred, strtotime('+6 months'));
            }

            $this->session->set_userdata($admin);
            return true;
        }
        else
        {
            return false;
        }
    }
	
	 function logout($staff = true)
    {
            $this->session->unset_userdata('front_user');
       	// $this->session->sess_destroy();
    }
    
}
