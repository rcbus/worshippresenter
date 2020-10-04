<?php
# Update :: DataBase
class iUpdate extends generic {
	private $columns = array();
	private $where;
	private $operator;
	private $value;
	private $And = array();
	private $Or = array();
	private $res;
    private $values = array();
    private $withoutQuotations = array();
    private $withQuotation;
    private $tableJoin = array();
    private $whereJoin = array();
    private $valueJoin = array();
    private $operatorJoin = array();
    private $typeJoin = array();
    private $tableAs = array();
    private $dataSet;
    private $mysqli;
    private $numRows;
	
	function __construct($dataSet,$table){
		$this->dataSet = $dataSet;
		$this->table = $table;
	}
	
	public function exe($execute=1){
		$this->sql = "UPDATE ".$this->table;
		if(count($this->tableJoin)){
			foreach($this->tableJoin as $key => $value){
				if($this->tableAs[$key]!=""){
					$this->sql .= " ".$this->typeJoin[$key]." JOIN ".$value." AS ".$this->tableAs[$key]." ON ".$this->tableAs[$key].".".$this->whereJoin[$key].$this->operatorJoin[$key].$this->valueJoin[$key];
				}else{
					$this->sql .= " ".$this->typeJoin[$key]." JOIN ".$value." ON ".$value.".".$this->whereJoin[$key].$this->operatorJoin[$key].$this->valueJoin[$key];
				}
			}
		}
		$this->sql .= " SET ";
		$delimiter = "";
		foreach($this->columns as $key => $value){
			if($this->withoutQuotations[$key]===false){
				$this->sql .= $delimiter.$value."='".$this->values[$key]."'";
			}else{
				$this->sql .= $delimiter.$value."=".$this->values[$key];
			}
			$delimiter = ",";
		}
		if($this->where){
			if($this->withQuotation===false){
				$this->sql .= " WHERE ".$this->where.$this->operator.$this->value;
			}else{
				$this->sql .= " WHERE ".$this->where.$this->operator."'".$this->value."'";
			}
		}else{
			#$this->sql .= " WHERE 1";
			$execute = 0;
		}
		for($i=0;$i<count($this->And);$i++){
			$this->sql .= " AND ".$this->And[$i];
		}
		if($this->Or){
			$this->sql .= " AND ( ";
			for($i=0;$i<count($this->Or);$i++){
				if($i==0){
					$this->sql .= $this->Or[$i];
				}else{
					$this->sql .= " OR ".$this->Or[$i];
				}
			}
			$this->sql .= ")";
		}
		$this->sql .= ";";
		if($execute==1){
			if($this->dataSet->sqlServer===false){
				$this->mysqli = $this->dataSet->connect();
				if($this->mysqli===false){
					return false;
				}else{
					@$this->res = $this->mysqli->query($this->sql);
					if($this->res===false){
						$this->dataSet->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
						return false;
					}else{
						$this->numRows = $this->mysqli->affected_rows;
						return true;
					}
				}
			}else{
				$this->res = $this->dataSet->exeQuery($this->sql);
				if($this->res===false){
					return false;
				}else{
					$this->numRows = sqlsrv_num_rows($this->res);
					return $this->res;
				}
			}
		}else{
			return true;
		}
	}
	
	public function getNumRows(){
		return $this->numRows;
	}
	
	public function getSql($access=false){
		global $REPORTING_ERROR;
		global $page;
	
		if(($REPORTING_ERROR==1 && $page->session->getLoginTipo()==2) || $page->session->getLoginTipo()==2){
			return $this->sql;
		}else{
			return null;
		}
	}
	
	public function join($table,$where,$operator,$value,$type="",$tableAs=""){
		if($type==""){
			$type = "LEFT";
		}
		$idJoin = count($this->tableJoin);
		$this->tableJoin[$idJoin] = $table;
		$this->whereJoin[$idJoin] = $where;
		$this->operatorJoin[$idJoin] = $operator;
		$this->valueJoin[$idJoin] = $value;
		$this->typeJoin[$idJoin] = $type;
		$this->tableAs[$idJoin] = $tableAs;
	}
	
	public function set($column,$value,$withoutQuotation=false,$withoutVerifySlashes=false){
	    if(strlen($column)>0){
    		if($withoutVerifySlashes===false){
    			$value = addslashes($value);
    		}
    
    		if(strlen($value)==0){
    			$value = "null";
    			$withoutQuotation = true;
    		}
    
    		$idColumn = count($this->columns);
    		$this->columns[$idColumn] = $column;
    		$this->values[$idColumn] = $value;
    		$this->withoutQuotations[$idColumn] = $withoutQuotation;
	    }
	}
	
	public function setHist($column,$value){
		$value = addslashes($value);
		$value = "CONCAT('".$value."',historico)";
		$idColumn = count($this->columns);
		$this->columns[$idColumn] = $column;
		$this->values[$idColumn] = $value;
		$this->withoutQuotations[$idColumn] = true;
	}
	
	public function setAnd($column,$operator,$value,$withQuotation=false,$table=false){
		if($table){
			$table .= ".";
		}
		if($withQuotation===false){
			$this->And[count($this->And)] = $table.$column.$operator.$value;
		}else{
			$this->And[count($this->And)] = $table.$column.$operator."'".$value."'";
		}
	}
	
	public function where($column,$operator,$value,$withQuotation=false){
		$this->where = $column;
		$this->operator = $operator;
		$this->value = $value;
		$this->withQuotation = $withQuotation;
	}
}