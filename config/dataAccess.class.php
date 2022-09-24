<?php
/*
--------------------------------------
built by : michaelbzone@gmail.com
http://www.michaelbzone.org
contact : (021) 3387 6267
--------------------------------------
*/
class dataAccess{
	var $conn;
	var $query;
	var $row;
	var $result;
	var $affectedrow;
	var $data=array();
	public function __construct() 
	{
		include_once("configdb.php");
		$this->conn=mysql_connect($dbhost, $dbuser, $dbpassword);
		mysql_select_db($dbname, $this->conn)or die("error connecting db");
	}
	function getquery($query)
	{
		$this->query=$query;
	}
	function getdata()
	{
		$this->result=mysql_query($this->query);
		$count=mysql_num_rows($this->result);
		if($count!==false)
		{
			while($this->row=mysql_fetch_array($this->result))
			{
				$this->data[]=$this->row;
			}
		}
		else
		{
			$this->data=false;
		}
		return $this->data;
	}
	function execute()
	{
		$this->result=mysql_query($this->query);
		$this->affectedrow= mysql_affected_rows();
		return $this->affectedrow;
	}
	function clear()
	{
		if($this->result)
			mysql_free_result($this->result);
		$this->data=array();
		$this->affectedrow=0;
		$this->query="";
	}

}
?>