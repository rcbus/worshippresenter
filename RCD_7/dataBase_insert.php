<?php
# Insert :: DataBase
class insert extends support {
	private $columns = array();
	private $values = array();
	private $Check = array();
    private $newId;
	private $idMultiInsert = false;
	private $dataSet = false;
	
	function __construct($id=""){
		$this->id = $id;
	}
	public function setDataSet($data){
		$this->dataSet = $data;
	}
    public function getNewId(){
        return $this->newId;
    }
	public function setInsert($column,$value,$check=false,$multiInsert=false){
		$value = addslashes($value);
		if($multiInsert===false){
			$idColumn = count($this->columns);
			$this->columns[$idColumn] = $column;
			$this->values[$idColumn] = $value;
			$this->Check[$idColumn] = $check;
		}else{
			$idColumn = count($this->columns[$this->idMultiInsert]);
			$this->columns[$this->idMultiInsert][$idColumn] = $column;
			$this->values[$this->idMultiInsert][$idColumn] = $value;
			$this->Check[$this->idMultiInsert][$idColumn] = $check;
		}
	}
	public function setMultiInsert($id){
		$this->idMultiInsert = $id;
	}
	public function set($table=""){
		$this->table = $table;
		$this->sql = "INSERT INTO";
	}
	public function Exe($execute=true){
		if($this->idMultiInsert===false){
			$this->sql .= " ".$this->table." (";
			for($i=0;$i<count($this->columns);$i++){
				if($i>0){
					$this->sql .= ",";
				}
				$this->sql .= $this->columns[$i];
			}
		 	$this->sql .= ") VALUES (";
		 	for($i=0;$i<count($this->values);$i++){
		 		if($this->Check[$i]===true && $this->values[$i]==""){
		 			$this->values[$i] = 0;
		 		}
		 		if($this->Check[$i]>0){
		 			if(strlen($this->values[$i])>$this->Check[$i]){
		 				$this->values[$i] = substr($this->values[$i], 0, $this->Check[$i]);
		 			}
		 		}
		 		if($i>0){
		 			$this->sql .= ",";
		 		}
		 		if($this->values[$i]=="" && $this->values[$i]!="0"){
		 			$this->sql .= "NULL";
		 		}else{
		 			$this->sql .= "'".$this->values[$i]."'";
		 		}
		 	}
		 	$this->sql .= ")";
		}else{
			$this->sql .= " ".$this->table." (";
			foreach ($this->columns as $key => $value){
				for($i=0;$i<count($this->columns[$key]);$i++){
					if($i>0){
						$this->sql .= ",";
					}
					$this->sql .= $this->columns[$key][$i];
				}
				break;
			}
			$this->sql .= ") VALUES ";
			$first = 1;
			foreach ($this->columns as $key => $value){
				if($first==1){
					$first = 0;
					$this->sql .= "(";
				}else{
					$this->sql .= ",(";
				}
				for($i=0;$i<count($this->values[$key]);$i++){
					if($this->Check[$key][$i]===true && $this->values[$key][$i]==""){
						$this->values[$key][$i] = 0;
					}
					if($this->Check[$key][$i]>0){
						if(strlen($this->values[$key][$i])>$this->Check[$key][$i]){
							$this->values[$key][$i] = substr($this->values[$key][$i], 0, $this->Check[$key][$i]);
						}
					}
					if($i>0){
						$this->sql .= ",";
					}
					$this->sql .= "'".$this->values[$key][$i]."'";
				}
				$this->sql .= ")";
			}
		}
		# ERA ASSIM ATÉ 09/08/2016
		/*$this->sql .= ") VALUES (";
		for($i=0;$i<count($this->values);$i++){
			if($this->Check[$i]===true && $this->values[$i]==""){
				$this->values[$i] = 0;
			}
			if($this->Check[$i]>0){
				if(strlen($this->values[$i])>$this->Check[$i]){
					$this->values[$i] = substr($this->values[$i], 0, $this->Check[$i]);
				}
			}
			if($i>0){
				$this->sql .= ",";
			}
			$this->sql .= "'".$this->values[$i]."'";
		}
		$this->sql .= ")";*/
		if($execute===true){
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
					$this->newId = $this->mysqli->insert_id;
					return true;
				}
			}
			/*$this->res = @mysql_query($this->sql,$this->id);
			$this->numRows = @mysql_affected_rows($this->id);
	        $this->newId = @mysql_insert_id($this->id);
			if($this->res!==false){
				return $this->res;
			}else{
				global $page;
				global $PAGENAME;
				global $PROCESSO;
				$preparaSql = addslashes($this->sql);
				$this->lastMsg = @mysql_error($this->id);
				$this->error[count($this->error)] = 5;
				
				return false;
			}*/
		}
	}
}