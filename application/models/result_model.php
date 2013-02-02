<?php
class Result_model extends CI_Model
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
	 * CreateResult add the result to the scrum_results table
	 * 
	 * Option : Value
	 * --------------
	 * dev_id		require
	 * to_do			require
	 * createDate			require
	 * note
	 * 
	 * @param array option
	 * @return insert_id();
	 */
	function CreateResult($option=array())
	{
		//If the required field isn't contained, return false
		if(!$this->IsContain(array('dev_id','to_do'),$option))
			return false;
		
		$option['createDate'] = date('Y-m-d');
		
		$this->db->insert('scrum_results',$option);//insert the data to the scrum_results
		
		return $this->db->insert_id();//return insert_id();
	}
	
	/**
	 * UpcreateDateResult edit the result information from the scrum_results table
	 * 
	 * Option : Value
	 * ----------------
	 * id			require
	 * dev_id
	 * to_do
	 * note
	 * createDate
	 * 
	 * @param array Option
	 * @return affected_rows();
	 */
	function UpdateResult($option=array())
	{		
		//the updated information
		if(isset($option['finish_task']))
			$this->db->set('finish_task',$option['finish_task']);
		
		if(isset($option['to_do']))
			$this->db->set('to_do',$option['to_do']);
		
		if(isset($option['note']))
			$this->db->set('note',$option['note']);
		
		//Condition
		if(isset($option['id']))
			$this->db->where('id',$option['id']);
		
		if(isset($option['dev_id']))
			$this->db->where('dev_id',$option['dev_id']);
		
		if(isset($option['createDate']))
			$this->db->where('createDate',$option['createDate']);		
		
		$this->db->update('scrum_results');//upcreateDate scrum_results table
		
		return $this->db->affected_rows();//return affected_rows()
	}
	
	/**
	 * GetResults get the results from the scrum_results table
	 * 
	 * Option : Value
	 * ---------------
	 * id			
	 * dev_id
	 * to_do
	 * note
	 * createDate
	 * 
	 * @param array Option
	 * @return results
	 */
	function GetResults($option=array())
	{
		//Qualification
		if(isset($option['id']))
			$this->db->where('id',$option['id']);
		if(isset($option['dev_id']))
			$this->db->where('dev_id',$option['dev_id']);
		if(isset($option['createDate']))
			$this->db->where('createDate',$option['createDate']);
		
		//Offset and Limit
		if(isset($option['limit']) && isset($option['offset']))
			$this->db->limit($option['limit'],$option['offset']);
		else if(isset($option['limit']))
			$this->db->limit($option['limit']);
		
		$results = $this->db->get('scrum_results');//Get Developers from scrum_results table
		
		//if option contains id, return one row
		if(isset($option['id']))
			return $results->row(0);
		
		return $results->result();//otherwise,return the results
	}
	
	/**
	 * DeleteResult delete the result from the scrum_results table
	 * 
	 * Option : Value
	 * ------------------
	 * id				require
	 * 
	 * @param array Option
	 * @return bool status
	 */
	function DeleteResult($option=array())
	{
		//check required value
		if(!$this->IsContain(array('id'),$option))
			return false;
		
		//Qualification
		$this->db->where('id',$option['id']);
		
		//delete developer and return status
		return $this->db->delete('scrum_results');
	}
}
