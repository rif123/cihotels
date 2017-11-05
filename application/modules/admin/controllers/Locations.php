<?php

class Locations extends Admin_Controller {	
	
	function __construct()
	{		
		parent::__construct();
		$this->load->model('Location_model');
	}
	
	function index()
	{
		$data['page_title']	= lang('countries');
		$data['locations']	= $this->Location_model->get_countries();
		
		$this->render_admin('locations/countries', $data);
	}
	
	function organize_countries()
	{
		$countries	= $this->input->post('country');
		$this->Location_model->organize_countries($countries);
	}
	
	function country_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		
		$data['page_title']		= lang('country_form');
		
		//default values are empty if the product is new
		$data['id']					= '';
		$data['name']				= '';
		$data['sortname']				= '';
		
		if ($id)
		{	
			$country		= (array)$this->Location_model->get_country($id);
			//if the country does not exist, redirect them to the country list with an error
			if (!$country)
			{
				$this->session->set_flashdata('error', lang('error_country_not_found'));
				redirect($this->config->item('admin_folder').'/locations');
			}
			
			$data	= array_merge($data, $country);
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		$this->form_validation->set_rules('sortname', 'lang:sortname', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('locations/country_form', $data);
		}
		else
		{
			$save['id']						= $id;
			$save['name']					= $this->input->post('name');
			$save['sortname']				= $this->input->post('sortname');
			
			$promo_id = $this->Location_model->save_country($save);
			
			$this->session->set_flashdata('message', lang('country_save'));
			
			//go back to the product list
			redirect('admin/locations');
		}
	}

	
	function delete_country($id = false)
	{
		if ($id)
		{	
			$location	= $this->Location_model->get_country($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$location)
			{
				$this->session->set_flashdata('error', lang('country_not_found'));
				redirect('admin/locations');
			}
			else
			{
				$this->Location_model->delete_country($id);
				
				$this->session->set_flashdata('message', lang('country_delete'));
				redirect('admin/locations');
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('error', lang('country_not_found'));
			redirect('admin/locations');
		}
	}
	
	function delete_zone($id = false)
	{
		if ($id)
		{	
			$location	= $this->Location_model->get_zone($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$location)
			{
				$this->session->set_flashdata('error', lang('zone_not_found'));
				redirect('admin/locations');
			}
			else
			{
				$this->Location_model->delete_zone($id);
				
				$this->session->set_flashdata('message', lang('region_delete'));
				redirect('admin/locations/zones/'.$location->country_id);
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('error', lang('error_zone_not_found'));
			redirect($this->config->item('admin_folder').'/locations');
		}
	}
	
	function zones($country_id)
	{
		$data['countries']	= $this->Location_model->get_countries();
		$data['country']	= $this->Location_model->get_country($country_id);
		if(!$data['country'])
		{
			$this->session->set_flashdata('error', lang('zone_not_found'));
			redirect('admin/locations');
		}
		$data['zones']	= $this->Location_model->get_zones($country_id);
		
		$data['page_title']	= sprintf(lang('region'), $data['country']->name);

		$this->render_admin('locations/country_zones', $data);
	}
	
	function zone_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['countries']		= $this->Location_model->get_countries();
		$data['page_title']		= lang('region_form');
		
		//default values are empty if the product is new
		$data['id']			= '';
		$data['name']		= '';
		$data['country_id']	= '';
		
		if ($id)
		{	
			$zone		= (array)$this->Location_model->get_zone($id);

			//if the country does not exist, redirect them to the country list with an error
			if (!$zone)
			{
				$this->session->set_flashdata('error', lang('region_not_found'));
				redirect('admin/locations');
			}
			
			$data	= array_merge($data, $zone);
		}
		
		$this->form_validation->set_rules('country_id', 'Country ID', 'trim|required');
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('locations/country_zone_form', $data);
		}
		else
		{
			$save['id']			= $id;
			$save['country_id']	= $this->input->post('country_id');
			$save['name']		= $this->input->post('name');
		
			$this->Location_model->save_zone($save);
			if($id){
				$this->session->set_flashdata('message', lang('region_update'));
			}else{
							$this->session->set_flashdata('message', lang('region_save'));
			}
			//go back to the product list
			redirect('admin/locations/zones/'.$save['country_id']);
		}
	}
	
	function get_zone_menu()
	{
		$id	= $this->input->post('id');
		$zones	= $this->Location_model->get_zones_menu($id);
		
		foreach($zones as $id=>$z):?>
		
		<option value="<?php echo $id;?>"><?php echo $z;?></option>
		
		<?php endforeach;
	}
	
	
	function zone_areas($id)
	{
		$data['zone']			= $this->Location_model->get_zone($id);
		$data['areas']			= $this->Location_model->get_zone_areas($id);
		
		$data['page_title']		= lang('cities_for').' '. $data['zone']->name;
		
		$this->render_admin('locations/country_zone_areas', $data);
	}

	function delete_zone_area($id = false)
	{
		if ($id)
		{	
			$location	= $this->Location_model->get_zone_area($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$location)
			{
				$this->session->set_flashdata('error', lang('city_not_found'));
				redirect('admin/locations');
			}
			else
			{
				$this->Location_model->delete_zone_area($id);
				
				$this->session->set_flashdata('message', lang('city_delete'));
				redirect('admin/locations/zone_areas/'.$location->state_id);
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('error', lang('city_not_found'));
			redirect('admin/locations/');
		}
	}
		
	function zone_area_form($zone_id, $area_id =false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$zone					= $this->Location_model->get_zone($zone_id);
		$data['page_title']		= sprintf(lang('city_form'), $zone->name);

		//default values are empty if the product is new
		$data['id']			= '';
		$data['zone_id']	= $zone_id;
	
		if ($area_id)
		{	
			$area		= (array)$this->Location_model->get_zone_area($area_id);

			//if the country does not exist, redirect them to the country list with an error
			if (!$area)
			{
				$this->session->set_flashdata('error', lang('city_not_found'));
				redirect('admin/locations/zone_areas/'.$zone_id);
			}

			$data	= array_merge($data, $area);
		}

		$this->form_validation->set_rules('code', 'lang:code', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('locations/country_zone_area_form', $data);
		}
		else
		{
			$save['id']			= $area_id;
			$save['state_id']	= $zone_id;
			$save['name']		= $this->input->post('code');
		
			$this->Location_model->save_zone_area($save);
			if($area_id){
				$this->session->set_flashdata('message', lang('city_update'));
			}else{
				$this->session->set_flashdata('message', lang('city_save'));
			}
			//go back to the product list
			redirect('admin/locations/zone_areas/'.$save['state_id']);
		}
	}
}