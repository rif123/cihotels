<?php
class Mail_templates extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('template_model'));
		$this->load->library('form_validation');
	}
	
	
	function index()
    {
        $data['templates'] = $this->template_model->get_all();
        $data['page_title'] = lang('mail_templates');
       $this->render_admin('mail_templates/list', $data);		
	}

  
    function form($id=false)
    {
        $data['page_title'] = lang('mail_template_form');

        $data['id']         = $id;
        $data['name']       = '';
        $data['subject']    = '';
        $data['content']    = '';
        
        if($id)
        {
            $message = $this->template_model->get($id);
                        
            $data['name']       = $message['name'];
            $data['subject']    = $message['subject'];
            $data['content']    = $message['content'];
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'lang:name', 'trim|required');
        $this->form_validation->set_rules('subject', 'lang:subject', 'trim|required');
        $this->form_validation->set_rules('content', 'lang:content', 'trim|required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            
			$this->render_admin('mail_templates/form', $data);	
        }
        else
        {
            
            $save['id']         = $id;
            $save['name']       = $this->input->post('name');
            $save['subject']    = $this->input->post('subject');
            $save['content']    = $this->input->post('content');
            
            //all created messages are typed to order so admins can send them from the view order page.
            
            $this->template_model->save($save);
            
            $this->session->set_flashdata('message', lang('mail_template_saved'));
            redirect('admin/mail_templates');
        }
    }
    
    function delete($id)
    {
        $this->template_model->delete($id);
        
        $this->session->set_flashdata('message', lang('mail_template_deleted'));
        redirect('admin/mail_templates');
    }
	
	
	function test(){
			
		// If you are using Composer (recommended)
		//require 'vendor/autoload.php';
		require_once APPPATH. '/third_party/sendgrid/vendor/autoload.php';
		
		// If you are not using Composer
		// require("path/to/sendgrid-php/sendgrid-php.php");
		
		$from = new SendGrid\Email(null, "test@example.com");
		$subject = "Hello World from the SendGrid PHP Library!";
		$to = new SendGrid\Email(null, "test@example.com");
		$content = new SendGrid\Content("text/plain", "Hello, Email!");
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		
		$apiKey = getenv('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');
		$sg = new \SendGrid($apiKey);
		
		$response = $sg->client->mail()->send()->post($mail);
		echo $response->statusCode();
		echo '<pre>';print_r($response->headers());
		echo $response->body();				
		 /*
		 $user = $this->config->item('mukeshgodha');
		 $pass = $this->config->item('admin123456');
		 $url = 'https://api.sendgrid.com/';
		 $params = array(
		 'api_user' => $user,
		 'api_key' => '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',
		 'to' => 'mukeshgodha1991@gmail.com',//$email,
		 'subject' => 'Test Subject',
		 'html' =>'Test Message',
		 'from' => 'mukeshgodha1991@gmail.com',
		 );
		 
		 $request = $url.'api/mail.send.json';
		 // Generate curl request
		  
		 $session = curl_init($request);
		 // Tell curl to use HTTP POST
		 curl_setopt ($session, CURLOPT_POST, true);
		  
		 // Tell curl that this is the body of the POST
		 curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		  
		 // Tell curl not to return headers, but do return the response
		 curl_setopt($session, CURLOPT_HEADER, false);
		 // Tell PHP not to use SSLv3 (instead opting for TLS)
		 //curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		 //Turn off SSL
		 curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);//New line
		 curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);//New line
		 curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		  
		 // obtain response
		 $response = curl_exec($session);
		 // print everything out
		 var_dump($response,curl_error($session),curl_getinfo($session));
		 curl_close($session);
		*/			
	}
	
	
}