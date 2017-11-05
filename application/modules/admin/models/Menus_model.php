<?php 

class Menus_model extends CI_Model
{
	function get_all()
	{
		return $this->db->get('menus')->result();
	}
	
	function get($id)
	{
		return $this->db->get_where('menus',array('id'=>$id))->row();
	}
	
	function save($save)
	{
		$flag = false;
		if(!empty($save['id']))
			$flag = $this->db->update('menus',$save,array('id'=>$save['id']));
		else
			$flag = $this->db->insert('menus',$save);
		
		return $flag;
	}
	
	function delete($id)
	{
		$query = $this->db->get_where('menus', array('id'=>$id))->row();
		$this->db->delete('menus',array('id'=>$id));
		return $query;
	}
	
}
