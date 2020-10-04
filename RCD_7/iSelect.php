<?php
# Select :: DataBase
class iSelect extends generic {
	private $column = array();
	private $columnBlock = false;
	private $where;
	private $operator;
	private $value;
	private $And = array();
	private $between = array();
    private $or = array();
	private $res;
    private $tableJoin = array();
    private $whereJoin = array();
    private $valueJoin = array();
    private $operatorJoin = array();
    private $typeJoin = array();
    private $dataBaseJoin = array();
    private $like = array();
    private $columnJoin;
    private $order;
    private $orderType;
    private $offSet = 0;
    private $limit = 1000;
    private $rand;
    private $withQuotation;
    private $orTable = array();
    private $as = array();
    private $tableAs = array();
    private $min = array();
    private $minAs = array();
    private $max = array();
    private $maxAs = array();
    private $multiplyColumnA = array();
    private $multiplyColumnB = array();
    private $multiplyAs = array();
    private $sumColumnA = array();
    private $sumColumnB = array();
    private $sumAs = array();
    private $divColumnA = array();
    private $divColumnB = array();
    private $divAs = array();
    private $expression = array();
    public $expressionPastWhere = array();
    private $group = array();
    private $orderTable;
    private $binary = false;
    private $dataSet;
    private $mysqli;
    private $numRows;
    private $listColumn = false;
    private $listDb = false;
    private $listTable = false;
    private $row = false;
    private $whereTable = false;
	
	function __construct($dataSet,$table=false){
		$this->dataSet = $dataSet;
		$this->table = $table;
	}
	
	public function expression($expression){
		$id = count($this->expression);
		$this->expression[$id] = $expression;
	}
	
	public function group($columns,$tables=false){
		$this->group = explode(",",$columns);
		if($tables===false){
			$this->groupTable = explode(",",$this->table);
		}else{
			$this->groupTable = explode(",",$tables);
		}
	}
	
	public function setAnd($column,$operator,$value="",$withQuotation=false,$table=false,$binary=false){
		if($table){
			$table .= ".";
		}else{
			$table = "";
		}
	
		if($binary===true){
			$table = "BINARY ".$table;
		}
	
		if($withQuotation===false){
			$this->And[count($this->And)] = $table.$column.$operator.$value;
		}else{
			$this->And[count($this->And)] = $table.$column.$operator."'".$value."'";
		}
	}
	
	public function between($column,$dateA,$dateB,$mode=false,$table=false){
		if($table){
			$table .= ".";
		}
		if($this->stringToUpper($mode)=="TIMESTAMP"){
			$dateA = date("Y-m-d H:i:s",$dateA);
			$dateB = date("Y-m-d H:i:s",$dateB);
		}
		$this->between[count($this->between)] = " AND ".$table.$column." BETWEEN '".$dateA."' AND '".$dateB."'";
	}
	
	public function sum($columnA,$columnB=false,$table=false,$as=false){
		$id = count($this->sumColumnA);
		if($table!==false){
			$columnA = $table.".".$columnA;
			if($columnB!==false){
				$columnB = $table.".".$columnB;
			}
		}
		$this->sumColumnA[$id] = $columnA;
		$this->sumColumnB[$id] = $columnB;
		$this->sumAs[$id] = $as;
	}
	
	public function columns($columns){
		if($columns!==false){
			$this->column = explode(",",$columns);
		}else{
			$this->columnBlock = true;
		}
	}
	
	public function columnsJoin($columns,$table,$as=""){
		if($columns!==false){
			$this->columnJoin[$table] = explode(",",$columns);
		}else{
			$this->columnJoin[$table] = $columns;
		}
		$this->as[$table] = explode(",",$as);
	}
	
	public function exe(){
		$this->sql = "SELECT ";
		if($this->listColumn===true){
			if($this->dataSet->sqlServer===false){
				$this->sql = "SHOW COLUMNS ";
			}else{
				$this->sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='";
			}
		}else if($this->listDb===true){
			$this->sql = "SHOW DATABASES";
		}else if($this->listTable===true){
			if($this->dataSet->sqlServer===false){
				$this->sql = "SHOW TABLES";
			}else{
				$this->sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES";
			}
		}else{
			if(count($this->column)==0){
				if($this->columnBlock===false){
					$this->sql .= $this->table.".*";
				}
			}else{
				$delimiter = "";
				foreach($this->column as $key => $value){
					$this->sql .= $delimiter.$this->table.".".$value;
					$delimiter = ",";
				}
			}
			if(count($this->tableJoin)){
				if(count($this->columnJoin)==0){
					foreach($this->tableJoin as $key => $value){
						if($value!==false){
							$delimiter = "";
							if($this->sql!="SELECT "){
								$delimiter = ",";
							}
							$this->sql .= $delimiter.$value.".*";
						}
					}
				}else{
					foreach($this->tableJoin as $keyA => $valueA){
						$delimiter = ",";
						if($this->tableAs[$keyA]!=""){
							foreach($this->columnJoin[$this->tableAs[$keyA]] as $keyB => $valueB){
								$delimiter = "";
								if($this->sql!="SELECT "){
									$delimiter = ",";
								}
								$this->sql .= $delimiter.$this->tableAs[$keyA].".".$valueB;
								if(@$this->as[@$this->tableAs[$keyA]][$keyB]!=""){
									$this->sql .= " AS ".$this->as[$this->tableAs[$keyA]][$keyB];
								}
							}
						}else{
							if(isset($this->columnJoin[$valueA])){
								if($this->columnJoin[$valueA]!==false){
									foreach($this->columnJoin[$valueA] as $keyB => $valueB){
										$delimiter = "";
										if($this->sql!="SELECT "){
											$delimiter = ",";
										}
										$this->sql .= $delimiter.$valueA.".".$valueB;
										if(@$this->as[$valueA][$keyB]!=""){
											$this->sql .= " AS ".$this->as[$valueA][$keyB];
										}
									}
								}
							}
						}
					}
					if(count($this->columnJoin)>0){
						/*if(strpos($valueA, ",")===false){
							foreach($this->columnJoin[$valueA] as $keyB => $valueB){
								$this->sql .= $delimiter.$valueA.".".$valueB;
								if(@$this->as[$valueA][$keyB]!=""){
									$this->sql .= " AS ".$this->as[$valueA][$keyB];
								}
							}
						}else{
							$tempTable = explode(",", $valueA);
							foreach($this->columnJoin[$valueA] as $keyB => $valueB){
								$this->sql .= $delimiter.$tempTable[$keyB].".".$valueB;
								if(@$this->as[$valueA][$keyB]!=""){
									$this->sql .= " AS ".$this->as[$valueA][$keyB];
								}
							}
						}*/
						foreach ($this->columnJoin as $keyE => $valueE){
							if(strpos($keyE, ",")!==false){
								$tempTable = explode(",", $keyE);
								foreach($this->columnJoin[$keyE] as $keyF => $valueF){
									$this->sql .= $delimiter.$tempTable[$keyF].".".$valueF;
									if(@$this->as[$keyE][$keyF]!=""){
										$this->sql .= " AS ".$this->as[$keyE][$keyF];
									}
								}
							}
						}
					}
				}
			}
			if(count($this->min)){
				foreach ($this->min as $keyD => $valueD){
					$this->sql .= ",MIN(".$valueD.")";
					if($this->minAs[$keyD]!==false){
						$this->sql .= " AS ".$this->minAs[$keyD];
					}
				}
			}
			if(count($this->max)){
				foreach ($this->max as $keyD => $valueD){
					$this->sql .= ",MAX(".$valueD.")";
					if($this->maxAs[$keyD]!==false){
						$this->sql .= " AS ".$this->maxAs[$keyD];
					}
				}
			}
			if(count($this->multiplyColumnA)){
				foreach ($this->multiplyColumnA as $keyD => $valueD){
					$this->sql .= ",(".$this->multiplyColumnA[$keyD]."*".$this->multiplyColumnB[$keyD].")";
					if($this->multiplyAs[$keyD]!==false){
						$this->sql .= " AS ".$this->multiplyAs[$keyD];
					}
				}
			}
			if(count($this->sumColumnA)){
				foreach ($this->sumColumnA as $keyD => $valueD){
					if($this->sumColumnB[$keyD]!==false){
						$this->sql .= ",(".$this->sumColumnA[$keyD]."+".$this->sumColumnB[$keyD].")";
					}else{
						$this->sql .= ",SUM(".$this->sumColumnA[$keyD].")";
					}
					if($this->sumAs[$keyD]!==false){
						$this->sql .= " AS ".$this->sumAs[$keyD];
					}
				}
			}
			if(count($this->divColumnA)){
				foreach ($this->divColumnA as $keyD => $valueD){
					$this->sql .= ",(".$this->divColumnA[$keyD]."/".$this->divColumnB[$keyD].")";
					if($this->divAs[$keyD]!==false){
						$this->sql .= " AS ".$this->divAs[$keyD];
					}
				}
			}
			if(count($this->expression)){
				foreach ($this->expression as $keyD => $valueD){
					$delimiter = "";
					if($this->sql!="SELECT "){
						$delimiter = ",";
					}
					$this->sql .= $delimiter.$this->expression[$keyD];
				}
			}
		}
		if($this->listDb===false && $this->listTable===false){
			if($this->listColumn===true){
				if($this->dataSet->sqlServer===false){
					$this->sql .= " FROM ".$this->table;
				}else{
					$this->sql .= $this->table."'";
				}
			}else{
				$this->sql .= " FROM ".$this->table;
			}
		}
		if(count($this->tableJoin)){
			foreach($this->tableJoin as $key => $value){
				if($this->dataBaseJoin[$key]!==false){
					$value = $this->dataBaseJoin[$key].".".$value;
				}
				if($this->tableAs[$key]!=""){
					$this->sql .= " ".$this->typeJoin[$key]." JOIN ".$value." AS ".$this->tableAs[$key]." ON ".$this->tableAs[$key].".".$this->whereJoin[$key].$this->operatorJoin[$key].$this->valueJoin[$key];
				}else{
					$this->sql .= " ".$this->typeJoin[$key]." JOIN ".$value." ON ".$value.".".$this->whereJoin[$key].$this->operatorJoin[$key].$this->valueJoin[$key];
				}
			}
		}
		if(count($this->like)==0){
			if($this->where){
				if($this->binary===true){
					$binary = "BINARY ";
				}else{
					$binary = "";
				}
				if($this->listColumn===false){
					if(strlen($this->table)==0){
						$table = $this->table;
					}else if($this->whereTable!==false){
						$table = $this->whereTable;
					}else{
						$table = $this->table.".";
					}
					if($this->withQuotation===false){
						$this->sql .= " WHERE ".$binary.$table.$this->where.$this->operator.$this->value;
					}else{
						$this->sql .= " WHERE ".$binary.$table.$this->where.$this->operator."'".$this->value."'";
					}
				}else{
					if($this->withQuotation===false){
						$this->sql .= " WHERE ".$this->where.$this->operator.$this->value;
					}else{
						$this->sql .= " WHERE ".$this->where.$this->operator."'".$this->value."'";
					}
				}
			}else if($this->listDb===false && $this->listTable===false){
				if($this->dataSet->sqlServer===false){
					$this->sql .= " WHERE 1";
				}
			}
		}
		for($i=0;$i<count($this->like);$i++){
			if($i==0){
				$this->sql .= " WHERE (";
				$this->sql .= $this->like[$i];
			}else{
				$this->sql .= " OR ".$this->like[$i];
			}
		}
		if(count($this->like)){
			$this->sql .= ")";
		}
		for($i=0;$i<count($this->And);$i++){
			$this->sql .= " AND ".$this->And[$i];
		}
		if($this->offSet>0){
			#$this->sql .= " AND ROWNUM >= 0";#.$this->offSet;
		}
		for($i=0;$i<count($this->expressionPastWhere);$i++){
			$this->sql .= " ".$this->expressionPastWhere[$i];
		}
		for($i=0;$i<count($this->between);$i++){
			$this->sql .= $this->between[$i];
		}
		if($this->or){
			$this->sql .= " AND ( ";
			for($i=0;$i<count($this->or);$i++){
				$table = false;
				if($this->orTable[$i]!==false){
					$table = $this->orTable[$i];
				}
				if($table!==false){
					$table .= ".";
				}
				if($i==0){
					$this->sql .= $table.$this->or[$i];
				}else{
					$this->sql .= " OR ".$table.$this->or[$i];
				}
			}
			$this->sql .= ")";
		}
		# Sistema de Agrupamento
		if(count($this->group)>0){
			$columnsAndTables = "";
			foreach ($this->group as $keyC => $valueC){
				if(strlen($columnsAndTables)>0){
					$columnsAndTables .= ",";
				}
				$columnsAndTables .= $this->groupTable[$keyC].".".$this->group[$keyC];
			}
			$this->sql .= " GROUP BY ".$columnsAndTables;
		}
		# Fim - Sistema de Agrupamento
		# Sistema de Ordenação
		if($this->orderTable===false && $this->orderTable!=""){
			$orderTable = $this->table;
		}else if($this->orderTable!=""){
			$orderTable = $this->orderTable;
		}else{
			$orderTable = "";
		}
		if($orderTable==""){
			$columnsAndTables = $this->order[0]." ".$this->orderType[0];
		}else{
			if(count($this->order)>1){
				foreach ($this->order as $keyC => $valueC){
					if(!isset($orderTable[$keyC])){
						$orderTable[$keyC] = $orderTable[0];
					}
					if(isset($columnsAndTables)){
						$columnsAndTables .= ",";
					}else{
						$columnsAndTables = "";
					}
					if(count($this->orderType)>1){
						$columnsAndTables .= $orderTable[$keyC].".".$this->order[$keyC]." ".$this->orderType[$keyC];
					}else{
						$columnsAndTables .= $orderTable[$keyC].".".$this->order[$keyC]." ".$this->orderType[0];
					}
				}
			}else{
				$columnsAndTables = $orderTable[0].".".$this->order[0]." ".$this->orderType[0];
			}
		}
		if($this->order && !$this->rand){
			$this->sql .= " ORDER BY ".$columnsAndTables;
		}
		if($this->rand && $this->order){
			$this->sql .= " ORDER BY ".$columnsAndTables.",rand()";
		}
		if($this->rand && !$this->order){
			$this->sql .= " ORDER BY rand()";
		}
		# Fim - Sistema de Ordenação
		if($this->limit!==false && $this->listColumn===false && $this->listDb===false && $this->listTable===false){
			if($this->dataSet->sqlServer===false){
				$this->sql .= " LIMIT ".$this->offSet.",".$this->limit;
			}else{
				if($this->offSet==0){
					if(strpos($this->sql,"TOP")===false){
						$this->sql = str_replace("SELECT", "SELECT TOP ".$this->limit, $this->sql);
					}
				}else{
					$this->sql .= " OFFSET ".$this->offSet." ROWS FETCH NEXT ".$this->limit." ROWS ONLY";
				}
			}
		}
		
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
					return $this->res;
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
	}
	
	public function getFieldSize(){
		if($this->row===false){
			$this->row = $this->read();
			$column = $this->row;
		}else{
			$column = $this->row;
		}
		return $this->parseTextBetween("(",")",$column['Type']);
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
	
	public function getNumRows(){
		return $this->numRows;
	}
	
	public function getSql($access=false){
		global $REPORTING_ERROR;
		global $page;
		
		if(($REPORTING_ERROR==1 && $page->session->getLoginTipo()==2) || $page->session->getLoginTipo()==2 || ($access===true)){
			return $this->sql;
		}else{
			return null;
		}
	}
	
	public function getTableSetted(){
		return $this->table;
	}
	
	public function join($table,$where,$operator,$value,$type="",$tableAs="",$dataBase=false){
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
		$this->dataBaseJoin[$idJoin] = $dataBase;
	}
	
	public function like($column,$value,$type="%X%",$not=false){
		$value = str_replace("#","%",$value);
		$value = str_replace("*","%",$value);
		if($not!==false){
			$not = " NOT";
		}else{
			$not = "";
		}
		if($type=="%X%"){
			$this->like[count($this->like)] = $column.$not." LIKE '%".$value."%'";
		}else if($type=="X%"){
			$this->like[count($this->like)] = $column.$not." LIKE '".$value."%'";
		}else{
			$this->like[count($this->like)] = $column.$not." LIKE '%".$value."'";
		}
	}
	
	public function limit($limit,$offSet=0){
		$this->offSet = $offSet;
		$this->limit = $limit;
	}
	
	public function listColumn(){
		$this->listColumn = true;
	}
	
	public function listDb(){
		$this->listDb = true;
	}
	
	public function listTable(){
		$this->listTable = true;
	}
	
	public function setOr($column,$operator,$value,$withQuotation=false,$table=false){
		$id = count($this->or);
		if($withQuotation===false){
			$this->or[$id] = $column.$operator.$value;
		}else{
			$this->or[$id] = $column.$operator."'".$value."'";
		}
		$this->orTable[$id] = $table;
	}
	
	public function order($order,$type="ASC",$table=false){
		$this->order = explode(",",$order);
		$this->orderType = explode(",",$type);
		if($table===false && $table!="" && $this->table){
			$this->orderTable = explode(",",$this->table);
		}else if($table!=""){
			$this->orderTable = explode(",",$table);
		}else{
			$this->orderTable = "";
		}
	}
	
	public function rand(){
		$this->rand = true;
	}
	
	public function read(){
		if($this->dataSet->sqlServer===false){
			if($this->res!==false){
				return $this->res->fetch_assoc();
			}else{
				return false;
			}
		}else{
			if($this->res!==false){
				$resSqlsrvFetchArray = @sqlsrv_fetch_array( $this->res, SQLSRV_FETCH_ASSOC);
				if($resSqlsrvFetchArray===false){
					$errors = sqlsrv_errors();
					foreach ($errors as $error){
						$this->dataSet->setError("(".$error['code'].") ".$error['message']);
					}
					return false;
				}else{
					return $resSqlsrvFetchArray;
				}
			}else{
				return false;
			}
		}
	}
	
	public function where($column,$operator,$value,$withQuotation=false,$binary=false,$table=false){
		$this->where = $column;
		$this->operator = $operator;
		$this->value = $value;
		$this->withQuotation = $withQuotation;
		$this->binary = $binary;
		$this->whereTable = $table;
	}
	
}