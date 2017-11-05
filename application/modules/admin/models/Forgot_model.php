<?php
class forgot_model  extends CI_Model  {

	
	function reset_password($email)
    {
        $this->load->library('encrypt');
        $user = $this->get_user_by_email($email);
        if ($user)
        {
            $this->load->helper('string');
            $this->load->library('email');
            
            $new_password       = random_string('alnum', 8);
            $user['password']   = sha1($new_password);
            $this->save($user);
            
            $this->email->from($this->config->item('email'), $this->config->item('School Portal'));
            $this->email->to($email);
            $this->email->subject($this->config->item('School Portal').': Password Reset');
            $this->email->message('Your password has been reset to <strong>'. $new_password .'</strong>.');
            $this->email->send();
            
            return true;
        }
        else
        {
            return false;
        }
    }
	
	
	function get_user_by_email($email)
    {
        $result = $this->db->get_where('admin', array('email'=>$email));
        return $result->row_array();
    }

	
	
	function get_admin_by_code($code)
	{
		$this->db->where("token", $code);
		$this->db->select("email");
		 $this->db->limit(1);
		$result = $this->db->get('users')->row(); 
		
		 if (sizeof($result) > 0)
        {
            return $result; 
        }
        else
        {
			$this->session->set_flashdata('error', "Reset Password Failed");
			redirect('admin/login');
         
        }
	}	
	
	function save_password($save,$email)
	{
		$this->db->where('email',$email);
		$this->db->update('users', $save);
		
	}
	
	function save_user_info($save)
	{
		$this->db->insert('users', $save);
	}
	
	 private function get_admin_by_email($email)
    {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $result = $this->db->get('users');
        $result = $result->row_array();

        if (sizeof($result) > 0)
        {
            return $result; 
        }
        else
        {
            return false;
        }
    }
	
	function edit_admin_to_save_code($email,$token) //save randon string in admin by email
	 {
	 			
	 $admin_email = $this->get_admin_by_email($email);
		
		if ($admin_email['email'])
        {	
			$res = $this->db->where('id', '4')->get('mail_templates');
			$row = $res->row_array();
		
			//print_r($row);die;
			$result = $this->db->where('id', '1')->get('settings');
			$settings = $result->row();
			//echo '<pre>'; print_r($settings->name);die;
			$link = site_url('admin/forgot/reset_password/' . $token['token']);
			
			
			//working code
			$row['content'] = str_replace('{password_reset_link}', $link, $row['content']);
			$row['subject'] = str_replace('{site_name}', $settings->name, $row['subject']);
			
			
			// {site_name}
			$row['subject'] = str_replace('{site_name}', $settings->name, $row['subject']);
			$row['content'] = str_replace('{site_name}', $settings->name, $row['content']);
			$row['content'] = str_replace('{customer_name}', $admin_email['firstname'], $row['content']);
				
				$this->db->where('email',$admin_email['email']);
				$this->db->update('users', $token);
				
				$msg 				 = html_entity_decode($row['content'],ENT_QUOTES, 'UTF-8');
				$params['recipient'] = $admin_email['email'];
				$params['subject'] 	 = $row['subject'];
				$params['message']   = $msg;
				$this->mailer->send($params);
				
				
				
				return TRUE;
					/*
				$this->email->from($settings->email, $settings->name);
				$this->email->to($email);
				$this->email->bcc($settings->email);
				$this->email->subject("Password Rest Link");
				$this->email->message(html_entity_decode($row['content']));
			 	$this->email->send();*/
				
		}else
		{
            return false;
        }		
	 }

	
	
	
}
