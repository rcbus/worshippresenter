<?php
# Select :: DataBase
class select extends support {
	#private $table;
	private $column = array();
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
    private $expressionPastWhere = array();
    private $group = array();
    private $orderTable = array();
	private $binary = false;
	private $dataSet = false;
	
	function __construct($id=""){
		$this->id = $id;
	}
	public function setDataSet($data){
		$this->dataSet = $data;
	}
	public function setExpression($expression){
		$id = count($this->expression);
		$this->expression[$id] = $expression;
	}
	public function setDiv($columnA,$columnB,$table=false,$as=false){
		$id = count($this->divColumnA);
		if($table!==false){
			$columnA = $table.".".$columnA;
			$columnB = $table.".".$columnB;
		}
		$this->divColumnA[$id] = $columnA;
		$this->divColumnB[$id] = $columnB;
		$this->divAs[$id] = $as;
	}
	public function setSum($columnA,$columnB=false,$table=false,$as=false){
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
	public function setMultiply($columnA,$columnB,$table=false,$as=false){
		$id = count($this->multiplyColumnA);
		if($table!==false){
			$columnA = $table.".".$columnA;
			$columnB = $table.".".$columnB;
		}
		$this->multiplyColumnA[$id] = $columnA; 
		$this->multiplyColumnB[$id] = $columnB;
		$this->multiplyAs[$id] = $as;
	}
	public function setMin($column,$table=false,$as=false){
		$id = count($this->min);
		if($table!==false){
			$column = $table.".".$column;
		}
		$this->min[$id] = $column;
		$this->minAs[$id] = $as;
	}
	public function setMax($column,$table=false,$as=false){
		$id = count($this->max);
		if($table!==false){
			$column = $table.".".$column;
		}
		$this->max[$id] = $column;
		$this->maxAs[$id] = $as;
	}
    public function setLike($column,$value,$type="%X%"){
    	if($type=="%X%"){
        	$this->like[count($this->like)] = $column." LIKE '%".$value."%'";
    	}else if($type=="X%"){
    		$this->like[count($this->like)] = $column." LIKE '".$value."%'";
    	}else{
    		$this->like[count($this->like)] = $column." LIKE '%".$value."'";
    	}
    }
    public function setRand(){
        $this->rand = true;
	}
	public function limit($limit,$offSet=0){
		$this->offSet = $offSet;
		$this->limit = $limit;
	}
    public function setLimit($limit,$offSet=0){
        $this->offSet = $offSet;
        $this->limit = $limit;
    }
    public function setOrder($order,$type="ASC",$table=false){
        $this->order = explode(",",$order);
        $this->orderType = explode(",",$type);
        if($table===false && $table==""){
        	$this->orderTable = explode(",",$this->table);
        }else if($table!=""){
        	$this->orderTable = explode(",",$table);
        }else{
        	$this->orderTable = "";
        }
    }
    public function setGroup($columns,$tables=false){
    	$this->group = explode(",",$columns);
    	if($tables===false){
    		$this->groupTable = explode(",",$this->table);
    	}else{
    		$this->groupTable = explode(",",$tables);
    	}
    }
    public function setJoin($table,$where,$operator,$value,$type="",$tableAs="",$dataBase=false){
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
    public function setColumnsJoin($columns,$table,$as=""){
        $this->columnJoin[$table] = explode(",",$columns);
        $this->as[$table] = explode(",",$as);
    }
    public function setColumns($columns){
        $this->column = explode(",",$columns);
    }
	public function read(){
		if($this->res!==false){
			return $this->res->fetch_assoc();
		}else{
			return false;
		}
		/*return @mysql_fetch_assoc($this->res);*/
	}
	public function setWhere($column,$operator,$value,$withQuotation=false,$binary=false){
		$this->where = $column;
		$this->operator = $operator;
		$this->value = $value;
		$this->withQuotation = $withQuotation;
		$this->binary = $binary;
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
	public function setExpressionPastWhere($expression){
		$this->expressionPastWhere[count($this->expressionPastWhere)] = $expression;
	}
	public function unSetAnd($index=0){
		if($index==0){
			$index = (count($this->And)-1);
		}
		unset($this->And[$index]);
	}
	public function setBetween($column,$dateA,$dateB,$mode=false,$table=false){
		if($table){
			$table .= ".";
		}
		if($this->stringToUpper($mode)=="TIMESTAMP"){
			$dateA = date("Y-m-d H:i:s",$dateA);
			$dateB = date("Y-m-d H:i:s",$dateB);
		}
		$this->between[count($this->between)] = " AND ".$table.$column." BETWEEN '".$dateA."' AND '".$dateB."'";
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
	public function set($table=""){
		$this->table = $table;
	}
	public function getTableSetted(){
		return $this->table;
	}
	public function Exe(){
        $this->sql = "SELECT ";
		if(count($this->column)==0){
			$this->sql .= $this->table.".*";
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
                    $this->sql .= ",".$value.".*";
                }
            }else{
                foreach($this->tableJoin as $keyA => $valueA){
                    $delimiter = ",";
                    if($this->tableAs[$keyA]!=""){
	                    foreach($this->columnJoin[$this->tableAs[$keyA]] as $keyB => $valueB){
	                    	$this->sql .= $delimiter.$this->tableAs[$keyA].".".$valueB;
                    		if($this->as[$this->tableAs[$keyA]][$keyB]!=""){
                    			$this->sql .= " AS ".$this->as[$this->tableAs[$keyA]][$keyB];
                    		}
	                    }
                    }else{
                    	if(isset($this->columnJoin[$valueA])){
		                    foreach($this->columnJoin[$valueA] as $keyB => $valueB){
		                    	$this->sql .= $delimiter.$valueA.".".$valueB;
	                        	if(@$this->as[$valueA][$keyB]!=""){
	                        		$this->sql .= " AS ".$this->as[$valueA][$keyB];
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
        		$this->sql .= ",".$this->expression[$keyD];
        	}
        }
		$this->sql .= " FROM ".$this->table;
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
		    	if($this->withQuotation===false){
		    		$this->sql .= " WHERE ".$binary.$this->table.".".$this->where.$this->operator.$this->value;
		    	}else{
		    		$this->sql .= " WHERE ".$binary.$this->table.".".$this->where.$this->operator."'".$this->value."'";
		    	}
		    }else{
			    $this->sql .= " WHERE 1";
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
		for($i=0;$i<count($this->expressionPastWhere);$i++){
			$this->sql .= " ".$this->expressionPastWhere[$i];
		}
		for($i=0;$i<count($this->between);$i++){
			$this->sql .= $this->between[$i];
		}
        if($this->or){        	
            $this->sql .= " AND ( ";
            for($i=0;$i<count($this->or);$i++){
            	if($this->orTable[$i]===false){
            		$table = $this->table;
            	}else{
            		$table = $this->orTable[$i];
            	}
                if($i==0){
			        $this->sql .= $table.".".$this->or[$i];
                }else{
                    $this->sql .= " OR ".$table.".".$this->or[$i];
                }
		    }
            $this->sql .= ")";
        }
        # Sistema de Agrupamento
        if(count($this->group)>0){
        	$columnsAndTables = "";
        	foreach ($this->group as $keyC => $valueC){
        		$columnsAndTables = $this->groupTable[$keyC].".".$this->group[$keyC];
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
        if($this->limit!==false){
            $this->sql .= " LIMIT ".$this->offSet.",".$this->limit;
		}
		
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
				return $this->res;
			}
		}

		/*$this->res = @mysql_query($this->sql,$this->id);
		$this->numRows = @mysql_num_rows($this->res);
		if($this->res){
			return $this->res;
		}else{
			$this->error[count($this->error)] = 3;
			return false;
		}*/
	}
}