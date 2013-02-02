<?php
class Developer_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * To check whether the data array contains the required values or not 
	 * @param array require values, array data
	 *@return bool contains or not 
	 */
	function IsContain($require,$data)
	{
		foreach($require as $result)
			if(isset($data[$result]))
				return true;
		return false;
	}
	
	/**
	 * CreateDeveloper add the developer to the scrum_developers table
	 * 
	 * Option : Value
	 * --------------
	 * name				require
	 * 
	 * @param array option
	 * @return insert_id();
	 */
	function CreateDeveloper($option=array())
	{
		//If the required field isn't contained, return false
		if(!IsContain(array('name'),$option))
			return false;
		
		$this->db->insert('scrum_developers',$option);//insert the data to the scrum_developers
		
		return $this->db->insert_id();//return insert_id();
	}
	
	/**
	 * UpdateDevelper edit the developer information from the scrum_developers table
	 * 
	 * Option : Value
	 * ----------------
	 * id				require
	 * name
	 * 
	 * @param array Option
	 * @return affected_rows();
	 */
	function UpdateDeveloper($option=array())
	{
		//if the required field isn't contained, return false
		if(!IsContain(array('id'),$option))
			return false;
		
		//the updated information
		if(isset($option['name']))
			$this->db->set('name',$option['name']);
		
		$this->db->where('id',$option['id']);//condition
		
		$this->db->update('scrum_developers');//update scrum_developers table
		
		return $this->db->affected_rows();//return affected_rows()
	}
	
	/**
	 * GetDevelopers get the developers from the scrum_developers table
	 * 
	 * Option : Value
	 * ---------------
	 * id
	 * name
	 * 
	 * @param array Option
	 * @return Developers
	 */
	function GetDevelopers($option=array())
	{
		//Qualification
		if(isset($option['id']))
			$this->db->where('id',$option['id']);
		if(isset($option['name']))
			$this->db->where('name',$option['name']);
		
		//Offset and Limit
		if(isset($option['limit']) && isset($option['offset']))
			$this->db->limit($option['limit'],$option['offset']);
		else if(isset($option['limit']))
			$this->db->limit($option['limit']);
		
		$developers = $this->db->get('scrum_developers');//Get Developers from scrum_developers table
		
		//if option contains id, return one row
		if(isset($option['id']) || isset($option['name']))
			return $developers->row(0);
		
		return $developers->result();//otherwise,return the developers
	}
	
	/**
	 * DeleteDeveloper delete the developer from the scrum_developers table
	 * 
	 * Option : Value
	 * ------------------
	 * id				req(uire
	 * name
	 * 
	 * @param array Option
	 * @return bool status
	 */
	function DeleteDeveloper($option=array())
	{
		//check required value
		if(!IsContain(array('id'),$option))
			return false;
		
		//Qualification
		$this->db->where('id',$option['id']);
		if(isset($option['name']))
			$this->db->where('name',$option['name']);
		
		//delete developer and return status
		return $this->db->delete('scrum_developers');
	}
}
