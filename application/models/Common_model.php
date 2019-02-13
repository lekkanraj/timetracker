<?php
////==============================================================================================================
// Project	: Nissan Connect
// Page		: common_model.php
// Version  	Date        Name                 Comments 
// 1.0        7/9/2016  	Lekkan M 	          Phase I
//=================================================================================================================
class common_model extends CI_Model 
{
	/**
	 * Insert Query: Active Record
	 * @param $input
	 * @return bool
	**/
	function insert_db($tableName, $arrayData) //Insert data to the table
	{
		$query	= $this->db->insert($tableName, $arrayData);
		
		if($this->db->insert_id())
			return $this->db->insert_id();
		else if($query)
			return true;
		else
			return false;		
	}
	/**
	 * Update Query: Active Record
	 * @param $input
	 * @return bool
	**/
	function edit_db($tableName, $arrayData, $whereCon) //Edit data to the table
	{
		$query	= $this->db->update($tableName, $arrayData, $whereCon);
		
		if($query)
			return true;
		else
			return false;
	}
	/**
	 * Select Query: Active Record
	 * @param $input
	 * @return query
	**/
	//common function for select statement
	function select_db($tableName, $selectFileds = NULL, $whereCon = NULL, $orderBy = NULL, $startLimit = NULL, $endLimit = NULL, $likeCon = NULL, $groupBy = NULL) 
	{
		if($selectFileds != '')
		{
			$this->db->select($selectFileds);
		}
		if($whereCon != '')
		{	
			$this->db->where($whereCon);
		}	
		if($orderBy != '')
		{	
			$this->db->order_by($orderBy);
		}
		if(!is_null($startLimit) && !is_null($endLimit) && (!empty($startLimit)))
		{
			$this->db->limit($startLimit, $endLimit);	
		}
		if($likeCon != '')
		{
			if(sizeof($likeCon) == 3)
			{
				$this->db->like($likeCon[0], $likeCon[1], $likeCon[2]); 	
			}
			else
			{
				$this->db->like($likeCon); 
			}
			
		}
		
		if($groupBy != '')
		{
			$this->db->group_by($groupBy); 
		}

		$query	= $this->db->get($tableName);
		return $query;		
	}
	/**
	 * Select Number of Rows: Active Record
	 * @param $input
	 * @return number of rows
	**/
	function get_num_rows($tableName, $whereCon = NULL, $likeCon = NULL, $groupBy = NULL) //get number of rows in the table
	{
		if($whereCon != '')
		{	
			$this->db->where($whereCon);
		}
		if($likeCon != '')
		{	
			$this->db->like($likeCon);
		}
		if($groupBy != '')
		{
			$this->db->group_by($groupBy); 
		}
		$query	= $this->db->get($tableName);
		return $query->num_rows();			
	}
	/**
	 * Delete Query: Active Record
	 * @param $input
	 * @return bool
	**/
	function delete_db($tableName,  $whereCon = NULL) //common function for delete statement
	{
		if($whereCon != '')
		{	
			$this->db->where($whereCon);
		}	
		
		$query	= $this->db->delete($tableName);
		
		if($query)
			return true;
		else
			return false;
	}
	/**
	 * Select Query object: Active Record
	 * @param $query
	 * @return object
	**/
	function select_db_query($query)
	{
		$query = $this->db->query($query);
		
		return $query;
		
	}
	/**
	 * Select Data Query object: Active Record
	 * @param $input
	 * @return object
	**/
	public function selectData($tableName=null,$select=null,$where=null,$join=null,$like=null,$order_by=null,$order=null,$ion_limit=null,$ion_offset=null,$group_by=null)
	{
		if (isset($select) && !empty($select))
		{
			foreach ($select as $select1)
			{
				$this->db->select($select1);
			}
	
			$select = array();
		}
		else
		{
			//default selects
			$this->db->select("*");
		}
		 
		 if (isset($join) && !empty($join))
		{
			foreach ($join as $key => $value)
			{
				$valuearr = explode('@', $value);
				$value = $valuearr[0];
				if(isset($valuearr[1])&&$valuearr[1]!=''){
					$jointype = $valuearr[1];
				}else{
					$jointype = 'INNER';
				}
				$this->db->join($key,$value,$jointype);
			}
			$join = array();
		}
		 
		if (isset($where) && !empty($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key,$value);
			}
			//$where = array();
		}
		 
		if (isset($like) && !empty($like))
		{
			foreach ($like as $key => $value)
			{
				$this->db->like($key,$value);
			}
			$like = array();
		}
	
		if (isset($ion_limit) && isset($ion_offset))
		{
			$this->db->limit($ion_limit, $ion_offset);
			 
		}
		else if (isset($ion_limit))
		{
			$this->db->limit($ion_limit);
	
		}
		 
		if (isset($order_by) && isset($order))
		{
			$this->db->order_by($order_by, $order);
		}
		if (isset($group_by))
		{
			$this->db->group_by($group_by);
		}
		$result = $this->db->get($tableName)->result();
		//echo $this->db->last_query();die();
		return $result;
	}
}

// END Common Model

/* End of file common_model.php */