<?php
# List DB :: DataBase
class listDb extends support {
	private $where;
	private $operator;
	private $value;
	private $And = array();
	private $res;
	private $row = false;
	private $offSet = 0;
	private $limit = 1000;
	
	function __construct($id=""){
		$this->id = $id;
	}
	public function read(){
		return @mysql_fetch_assoc($this->res);
	}
	public function setLimit($limit,$offSet=0){
		$this->offSet = $offSet;
		$this->limit = $limit;
	}
	public function Exe(){
		$this->sql = "SHOW DATABASES";
		$this->res = @mysql_query($this->sql,$this->id);
		$this->numRows = @mysql_num_rows($this->res);
		if($this->res!==false){
			return $this->res;
		}else{
			$this->error[count($this->error)] = 4;
			return 0;
		}
	}
}