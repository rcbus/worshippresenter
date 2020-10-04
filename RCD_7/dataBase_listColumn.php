<?php
# List Column :: DataBase
class listColumn extends support {
	#private $table;
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
	public function setLimit($limit,$offSet=0){
		$this->offSet = $offSet;
		$this->limit = $limit;
	}
	public function getFieldType(){
		if($this->row===false){
			$this->row = $this->read();
			$column = $this->row;
		}else{
			$column = $this->row;
		}
		if($pos = strpos($column['Type'], "(")){
			return substr($column['Type'], 0, $pos);
		}else{
			return $column['Type'];
		}
	}
	public function getFieldSize(){
		if($this->row===false){
			$this->row = $this->read();
			$column = $this->row;
		}else{
			$column = $this->row;
		}
		return $this->parseTextBetween("(",")",$column['Type']);
		#return $this->row;
	}
	public function read(){
		return @mysql_fetch_assoc($this->res);
	}
	public function internalRead(){
		$this->row = @mysql_fetch_assoc($this->res);
	}
	public function setWhere($column,$operator,$value){
		$this->where = $column;
		$this->operator = $operator;
		$this->value = $value;
	}
	public function setAnd($column,$operator,$value){
		$this->And[count($this->And)] = $column.$operator.$value;
	}
	public function set($table=""){
		$this->table = $table;
		$this->sql = "SHOW COLUMNS FROM ".$this->table;
	}
	public function Exe(){
		if($this->where){
			$this->sql .= " WHERE ".$this->where.$this->operator.$this->value;
		}
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