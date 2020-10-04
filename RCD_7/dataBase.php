<?php
include_once 'dataBase_support.php';
include_once 'dataBase_insert.php';
include_once 'dataBase_listColumn.php';
include_once 'dataBase_listDb.php';
include_once 'dataBase_listTable.php';
include_once 'dataBase_select.php';
include_once 'dataBase_update.php';
include_once 'dataBase_delete.php';

# DataBase
class dataBase extends support {
	private $dataSetName;
	private $dataBase;
	private $server;
	private $user;
	private $pass;
	private $fields;
	private $values;
	private $select;
	private $listColumn;
	private $listDb;
	private $listTable;
	private $insert;
    private $update;
    private $delete;
    public $versao = "old";

	function __construct($dataSetName){
		$this->dataSetName = $dataSetName;
		$this->select = new select();
		$this->listColumn = new listColumn();
		$this->listDb = new listDb();
		$this->listTable = new listTable();
		$this->insert = new insert();
        $this->update = new update();
        $this->delete = new delete();
	}
	public function getDataBase(){
		return $this->dataBase;
	}
	public function getDataSetName(){
		return $this->dataSetName;
	}
	public function getValueDb($columnGet,$table,$where,$operator,$value,$order=false,$orderType="ASC",$limit=1,$and=false,$or=false){
		$sel = $this->select();
		$sel->set($table);
		$sel->setColumns($columnGet);
		if($and!==false){
			$value .= " ".$and;
		}
		if($or!==false){
			$value .= " ".$or;
		}
		$sel->setWhere($where,$operator,$value);
		if($order!==false){
			$sel->setOrder($order,$orderType);
		}
		if($limit!==false){
			$sel->setLimit($limit);
		}
		$sel->Exe();
		$row = $sel->read();
		return $row[$columnGet];
	}
	public function getStringConnection(){
		return "SERVER: ".$this->server." - PORT: ".$this->port." - DB: ".$this->dataBase;
	}
	public function setConnection($server,$dataBase,$user,$pass,$port=false){
		$this->dataBase = $dataBase;
		$this->server = $server;
		$this->user = $user;
		$this->pass = $pass;
		$this->port = $port;
	}
	public function setServer($server){
		$this->server = $server;
	}
	public function setPort($port){
		$this->port = $port;
	}
	public function setDataBase($dataBase){
		$this->dataBase = $dataBase;
		$this->id = "";
	}
    public function update($table=false){
    	/*$this->connect();*/
        $this->update = new update($this->id);
        if($table!==false){
        	$this->update->set($table);
        }
        return $this->update;
    }
    public function delete($table=false){
    	$this->connect();
    	$this->delete = new delete($this->id);
    	if($table!==false){
    		$this->delete->set($table);
    	}
    	return $this->delete;
    }
	public function insert($table=false){
		/*$this->connect();*/
		$this->insert = new insert($this->id);
		if($table!==false){
			$this->insert->set($table);
		}
		return $this->insert;
	}
	public function listColumn($table=false){   
		$this->connect();
		$this->listColumn = new listColumn($this->id);
		if($table!==false){
			$this->listColumn->set($table);
		}
		return $this->listColumn;
	}
	public function listDb(){
		$this->connect(false);
		$this->listDb = new listDb($this->id);
		return $this->listDb;
	}
	public function listTable(){
		$this->connect();
		$this->listTable = new listTable($this->id);
		return $this->listTable;
	}
	public function select($table=false){
		/*$this->connect();*/
		$this->select = new select($this->id);
		if($table!==false){
			$this->select->set($table);
		}
		return $this->select;
	}
	public function connect($selectDataBase=true){
		if($this->port===false){
			$server = $this->server;
		}else{
			$server = $this->server.":".$this->port;
		}
		if($this->id = @mysql_connect($server,$this->user,$this->pass)){
			mysql_query("SET NAMES 'utf8'");
			mysql_query('SET character_set_connection=utf8');
			mysql_query('SET character_set_client=utf8');
			mysql_query('SET character_set_results=utf8');
			if($selectDataBase===true){
				if(@mysql_select_db($this->dataBase,$this->id)){
					return $this->id;
				}else{
					$this->error[count($this->error)] = 1;  
					return 0;
				}
			}else{
				return $this->id;
			}
		}else{
			$this->error[count($this->error)] = 0;  
			return 0;
		}
	}
	public function createDb($dataBaseName){
		$id = $this->connect(false);
		$this->res = @mysql_query("CREATE DATABASE IF NOT EXISTS `".$dataBaseName."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",$this->id);
		if($this->res){
			return true;
		}else{
			return false;
		}
	}
	public function dropDb($dataBaseName){
		$id = $this->connect(false);
		$this->res = @mysql_query("DROP DATABASE ".$dataBaseName.";",$this->id);
		if($this->res){
			return true;
		}else{
			return false;
		}
	}
	public function createTable($tableName,$tableNameMdf){
		$id = $this->connect();
		
		$fields = "`id".$tableNameMdf."` int(11) NOT NULL AUTO_INCREMENT,";
		$fields .= "`dataCriacao` bigint(20) DEFAULT NULL,";
		$fields .= "`dataModificacao` bigint(20) DEFAULT NULL,";
		$fields .= "`historico` text,";
		$fields .= "`status".$tableNameMdf."` int(1) DEFAULT '1',";
		$fields .= "`id".$tableNameMdf."Remoto` int(11) DEFAULT NULL,";
		$fields .= "`filial` int(11) DEFAULT NULL,";
		$fields .= "`usuario` int(11) DEFAULT NULL,";
		$fields .= "PRIMARY KEY (`id".$tableNameMdf."`)";
		
		$sql = "CREATE TABLE `".$tableName."` (".$fields.") ENGINE=InnoDB DEFAULT CHARSET=utf8";
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			return true;
		}else{
			return false;
		}
	}
	public function dropTable($table){
		$id = $this->connect();
		$this->sql = "DROP TABLE ".$table;
		$this->res = @mysql_query($this->sql,$this->id);
		if($this->res){
			return true;
		}else{
			return false;
		}
	}
	public function addColumnTable($table,$columnName,$type,$size=false,$after=false,$null=false,$default=false,$autoIncrement=false,$primaryKey=false){
		$sql = "";
		$id = $this->connect();
		$sizes = array("bigint" => "(20)","decimal" => "(11,4)","int" => "(11)","text" => "","varchar" => "(4096)","timestamp" => "","enum" => "");
		if($size==false || strlen($size)==0 || $size==0){
			$size = $sizes[$type];
		}else if($type!="text"){
			$size = "(".$size.")";
		}else{
			$size = "";
		}
		if($after=="0"){
			$after = "";
		}else if($after=="1"){
			$after = " FIRST";
		}else{
			$after = " AFTER ".$after;
		}
		if($null=="NO"){
			$null = " NOT NULL";
		}else{
			$null = "";
		}
		if(strtoupper($default)=="NULL"){
			$default = "ALTER TABLE ".$table." ALTER ".$columnName." SET DEFAULT NULL";
		}else if($default){
			$default = "ALTER TABLE ".$table." ALTER ".$columnName." SET DEFAULT '".$default."'";
		}else{
			$default = "";
		}
		if($autoIncrement!==false && strlen($autoIncrement)>0){
			$autoIncrement = " AUTO_INCREMENT";
		}else{
			$autoIncrement = "";
		}
		if($primaryKey!==false && strlen($primaryKey)>0){
			$primaryKey = ", ADD PRIMARY KEY (".$columnName.")";
		}else{
			$primaryKey = "";
		}
		$sql .= "ALTER TABLE ".$table." ADD ".$columnName." ".$type.$size.$null.$autoIncrement.$after.$primaryKey;
		$this->sql = $sql;
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			if(strlen($default)>0){
				$sql .= ";".$default.";";
				$this->res = @mysql_query($default,$this->id);
				if($this->res){
					return true;
				}else{
					return false;
				}
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	public function dropColumnTable($table,$columnName){
		$id = $this->connect();
		$sql = "ALTER TABLE ".$table." DROP COLUMN ".$columnName;
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			return true;
		}else{
			return false;
		}
	}
	public function changeColumnTable($table,$columnName,$newColumnName,$type,$size=false,$after=false,$null=false,$default=false,$autoIncrement=false,$primaryKey=false){
		$sql = "";
		$id = $this->connect();
		$sizes = array("bigint" => "(20)","decimal" => "(11,4)","int" => "(11)","text" => "","varchar" => "(4096)","timestamp" => "","enum" => "");
		if($size==false || strlen($size)==0 || $size==0){
			$size = $sizes[$type];
		}else if($type!="text"){
			$size = "(".$size.")";
		}else{
			$size = "";
		}
		if($after=="0"){
			$after = "";
		}else if($after=="1"){
			$after = " FIRST";
		}else{
			$after = " AFTER ".$after;
		}
		if($null=="NO"){
			$null = " NOT NULL";
		}else{
			$null = "";
		}
		if(strtoupper($default)=="NULL"){
			$default = "ALTER TABLE ".$table." ALTER ".$columnName." SET DEFAULT NULL";
		}else if($default || $default=="0"){
			$default = "ALTER TABLE ".$table." ALTER ".$columnName." SET DEFAULT '".$default."'";
		}else{
			$default = "";
		}
		if($autoIncrement!==false && strlen($autoIncrement)>0){
			$autoIncrement = " AUTO_INCREMENT";
		}else{
			$autoIncrement = "";
		}
		if($primaryKey!==false && strlen($primaryKey)>0){
			$primaryKey = ", ADD PRIMARY KEY(".$columnName.")";
		}else{
			$primaryKey = "";
		}
		$sql .= "ALTER TABLE ".$table." CHANGE ".$columnName." ".$newColumnName." ".$type.$size.$null.$autoIncrement.$after.$primaryKey;
		$this->sql = $sql;
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			if(strlen($default)>0){
				$sql .= ";".$default.";";
				$this->sql = $sql;
				$this->res = @mysql_query($default,$this->id);
				if($this->res){
					return true;
				}else{
					return false;
				}
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	public function countReg($table){
		$id = $this->connect();
		$sql = "SELECT COUNT(*) AS TOTAL FROM ".$table." WHERE 1";
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			$row = @mysql_fetch_assoc($this->res);
			return $row['TOTAL'];
		}else{
			return false;
		}
	}
	public function showCreateTable($table,$autoIncrement=true,$engine=true,$charset=true){
		$id = $this->connect();
		$sql = "SHOW CREATE TABLE ".$table;
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			$row = @mysql_fetch_assoc($this->res);
			$return = "";
			$first = 1;
			foreach ($row as $key => $value){
				if($first==0){
					$return .= $value;
				}else{
					$first = 0;
				}
			}
			if($autoIncrement===false){
				if(strpos($return," AUTO_INCREMENT=")){
					$parseStrReplace = $this->parseTextBetween(" AUTO_INCREMENT=", " DEFAULT CHARSET=", $return);
					$return = str_replace($parseStrReplace, "", $return);
				}
			}
			if($engine===false){
				if(strpos($return," ENGINE=")){
					if(strpos($return," AUTO_INCREMENT=")){
						$parseStrReplace = $this->parseTextBetween(" ENGINE=", " AUTO_INCREMENT=", $return);
					}else{
						$parseStrReplace = $this->parseTextBetween(" ENGINE=", " DEFAULT CHARSET=", $return);
					}
					$return = str_replace($parseStrReplace, "", $return);
				}
			}
			if($charset===false){
				if(strpos($return," DEFAULT CHARSET=")){
					$posIni = strpos($return," DEFAULT CHARSET=");
					$parseStrReplace = substr($return, $posIni,strlen($return)-$posIni);
					$return = str_replace($parseStrReplace, "", $return);
				}
			}
			$return = str_replace(" ON UPDATE CURRENT_TIMESTAMP", "", $return);
			if(strpos($return,"UNIQUE")){
				$posIni = strpos($return,"UNIQUE");
				$parseStrReplace = substr($return, ($posIni-4),strlen($return));
				$parseStrReplace = substr($parseStrReplace, 0,(strpos($parseStrReplace,")")+1));
				$return = str_replace($parseStrReplace, "", $return);
			}
			return $return;
		}else{
			return false;
		}
	}
	public function exeQuery($query){
		$id = $this->connect();
		$sql = $query;
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			return true;
		}else{
			return false;
		}
	}
	public function truncateTable($table){
		$id = $this->connect();
		$sql = "TRUNCATE TABLE ".$table;
		$this->res = @mysql_query($sql,$this->id);
		if($this->res){
			return true;
		}else{
			return false;
		}
	}
	public function End(){
	}
}