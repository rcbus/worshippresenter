<?php
# Delete :: DataBase
class delete extends support {
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
	
	function __construct($id=""){
		$this->id = $id;
	}
    public function setColumn($column,$value,$withoutQuotation=false){
    	$value = addslashes($value);
        $idColumn = count($this->columns);
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
        $this->sql = "DELETE FROM ".$this->table;
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
			$this->res = @mysql_query($this->sql,$this->id);
			if($this->res!==false){
				$numRows = @mysql_affected_rows($this->id);
				if($numRows){
					$this->numRows = $numRows;
					#global $page;
					#global $PAGENAME;
					#$preparaSql = addslashes($this->sql);
					#@mysql_select_db("profiable_sistema",$this->id);
					#@mysql_query("INSERT INTO log_success_update (dataLog,usuario,transacao,linhaComando) VALUES ('".time()."','".$page->session->getLoginId()."','".$PAGENAME."','".$preparaSql."');",$this->id);
				}else{
					$this->numRows = 0;
				}
				return $this->res;
			}else{
				global $page;
				global $PAGENAME;
				global $PROCESSO;
				$preparaSql = addslashes($this->sql);
				@mysql_select_db("profiable_sistema",$this->id);
				@mysql_query("INSERT INTO log_falha_update (dataCriacao,linhaComando,usuario,transacao,processo) VALUES ('".time()."','".$preparaSql."','".$page->session->getLoginId()."','".$PAGENAME."','".$PROCESSO."');",$this->id);
				$this->numRows = 0;
				$this->error[count($this->error)] = mysql_error($this->id);
				return false;
			}
        }else{
        	return true;	
        }
	}
}