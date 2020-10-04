<?php
# Update :: DataBase
class update extends support {
	#private $table;
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
	private $dataSet = false;
	
	function __construct($id=""){
		$this->id = $id;
	}
	public function setDataSet($data){
		$this->dataSet = $data;
	}
	public function setJoin($table,$where,$operator,$value,$type="",$tableAs=""){
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
    public function setColumn($column,$value,$withoutQuotation=false){
    	$value = addslashes($value);
		$idColumn = count($this->columns);
		
		if(strlen($value)==0){
			$value = "null";
			$withoutQuotation = true;
		}

        $this->columns[$idColumn] = $column;
        $this->values[$idColumn] = $value;
        $this->withoutQuotations[$idColumn] = $withoutQuotation;
    }
	public function setWhere($column,$operator,$value,$withQuotation=false){
		$this->where = $column;
		$this->operator = $operator;
		$this->value = $value;
		$this->withQuotation = $withQuotation;
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
	public function setOr($column,$operator,$value,$withQuotation=false,$table=false){
		if($table){
			$table .= ".";
		}
		if($value=="NULL" || $value=="null"){
			$operator = " IS ";
		}
		if($withQuotation===false){
			$this->Or[count($this->Or)] = $table.$column.$operator.$value;
		}else{
			$this->Or[count($this->Or)] = $table.$column.$operator."'".$value."'";
		}
	}
	public function set($table=""){
		$this->table = $table;
	}
	public function Exe($execute=1){
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
			if($this->dataSet===false){
				global $idsa;
				$this->dataSet = $idsa;
			}
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
			return true;
		}
        /*if($execute==1){
			$this->res = @mysql_query($this->sql,$this->id);
			if($this->res!==false){
				$numRows = @mysql_affected_rows($this->id);
				if($numRows){
					$this->numRows = $numRows;
				}else{
					$this->numRows = 0;
				}
				return $this->res;
			}else{
				global $page;
				global $PAGENAME;
				global $PROCESSO;
				$preparaSql = addslashes($this->sql);
				$this->numRows = 0;
				$this->error[count($this->error)] = mysql_error($this->id);
				return false;
			}
        }else{
        	return true;	
        }*/
	}
}