<?php
include_once 'iSelect.php';
include_once 'iInsert.php';
include_once 'iUpdate.php';
include_once 'iDataTableAdapter.php';
include_once 'iForm.php';

# DataBase
class iDataBase extends generic {
	private $connected = false;
	private $dataSetName;
	private $server;
	private $user;
	private $pass;
	private $dataBase;
	private $port;
	private $mysqli;
	private $error = array();
	private $sql;
	public $sqlServer = false;
	public $sqlServerConn = false;
	public $versao = "i";

	function __construct($dataSetName,$sqlServer=false){
		$this->dataSetName = $dataSetName;
		if($sqlServer===true){
			$this->sqlServer = $sqlServer;
		}else if($sqlServer=="2"){
			$this->sqlServer = true;
		}else{
			$this->sqlServer = false;
		}
	}
	
	public function addColumnTable($table,$columnName,$type,$size=false,$after=false,$null=false,$default=false,$autoIncrement=false,$primaryKey=false){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$sql = "";
			$sizes = array("bigint" => "(20)","decimal" => "(11,4)","int" => "(11)","text" => "","varchar" => "(4096)","timestamp" => "","enum" => "","mediumtext" => "","blob" => "","mediumblob" => "");
			if($size==false || strlen($size)==0 || ($size==0 && is_numeric($size))){
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
			$lastDefault = false;
			if(strtoupper($default)=="NULL"){
				$default = "ALTER TABLE `".$table."` ALTER `".$columnName."` SET DEFAULT NULL";
			}else if($default || $default=="0"){
				$lastDefault = $default;
				$default = "ALTER TABLE `".$table."` ALTER `".$columnName."` SET DEFAULT '".$default."'";
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
			$sql .= "ALTER TABLE `".$table."` ADD `".$columnName."` ".$type.$size.$null.$autoIncrement.$after.$primaryKey;
			$this->sql = $sql;
			@$this->res = $this->mysqli->query($this->sql);
			
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				if(strlen($default)>0){
					$sql .= ";".$default.";";
					$this->sql = $sql;
					@$this->res = $this->mysqli->query($default);
					
					if($this->res===false){
						$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
						return false;
					}else{
						if($lastDefault!==false){
							$lastDefaultSql = "UPDATE ".$table." SET ".$columnName."='".$lastDefault."' WHERE 1";
							$sql .= $lastDefaultSql.";";
							$this->sql = $sql;
							@$this->res = $this->mysqli->query($lastDefaultSql);
							
							if($this->res===false){
								$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
								return false;
							}else{
								return true;
							}
						}else{
							return true;
						}
					}
				}else{
					return true;
				}
			}
		}
	}
	
	public function changeColumnTable($table,$columnName,$newColumnName,$type,$size=false,$after=false,$null=false,$default=false,$autoIncrement=false,$primaryKey=false){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$sql = "";
			$sizes = array("bigint" => "(20)","decimal" => "(11,4)","int" => "(11)","text" => "","varchar" => "(4096)","timestamp" => "","enum" => "");
			if($size==false || strlen($size)==0 || ($size==0 && is_numeric($size))){
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
			}else if($after!==false){
				$after = " AFTER ".$after;
			}
			if($null=="NO"){
				$null = " NOT NULL";
			}else{
				$null = "";
			}
			if(strtoupper($default)=="NULL"){
				$default = "ALTER TABLE `".$table."` ALTER `".$newColumnName."` SET DEFAULT NULL";
			}else if($default!==false && ($default || $default=="0")){
				$default = "ALTER TABLE `".$table."` ALTER `".$newColumnName."` SET DEFAULT '".$default."'";
			}else{
				$default = "";
			}
			if($autoIncrement!==false && strlen($autoIncrement)>0){
				$autoIncrement = " AUTO_INCREMENT";
			}else{
				$autoIncrement = "";
			}
			if($primaryKey!==false && strlen($primaryKey)>0){
				$primaryKey = "ADD PRIMARY KEY(".$newColumnName.")";
			}else{
				$primaryKey = "";
			}
			$sql .= "ALTER TABLE `".$table."` CHANGE `".$columnName."` `".$newColumnName."` ".$type.$size.$null.$autoIncrement.$after;
			$this->sql = $sql;
			
			@$this->res = $this->mysqli->query($this->sql);
				
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				$error = false;
				if(strlen($primaryKey)>0){
					$sql = ";".$primaryKey.";";
					$this->sql .= $sql;
					@$this->res = $this->mysqli->query($primaryKey);
						
					if($this->res===false){
						$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
						$error = true;
					}
				}
				if(strlen($default)>0){
					$sql = ";".$default.";";
					$this->sql .= $sql;
					@$this->res = $this->mysqli->query($default);
					
					if($this->res===false){
						$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
						$error = true;
					}
				}
				if($error===false){
					return true;
				}else{
					return false;
				}
			}
		}
	}
	
	public function connect(){
		if($this->sqlServer===false){
			if($this->connected===false){
				@$this->mysqli = new mysqli($this->server,$this->user,$this->pass,$this->dataBase,$this->port);
				if($this->mysqli->connect_error){
					$this->setError("(".$this->mysqli->connect_errno.") ".$this->mysqli->connect_error);
					return false;
				}else{
					$this->mysqli->query("SET NAMES 'utf8'");
					$this->mysqli->query("SET character_set_connection=utf8");
					$this->mysqli->query("SET character_set_client=utf8'");
					$this->mysqli->query("SET character_set_results=utf8'");
					return $this->mysqli;
				}
			}else{
				return $this->mysqli;
			}
		}else{
			if($this->connected===false){
				$this->sqlServerConn = sqlsrv_connect($this->server,array("Database" => $this->dataBase, "UID" => $this->user, "PWD" => $this->pass, "CharacterSet" => "UTF-8"));
				if(!$this->sqlServerConn){
					$errors = sqlsrv_errors();
					foreach ($errors as $error){
						$this->setError("(".$error['code'].") ".$error['message']);
					}
					return false;
				}else{
					return $this->sqlServerConn;
				}
			}else{
				return $this->sqlServerConn;
			}
		}
	}
	
	public function createDb($dataBaseName){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$this->sql = "CREATE DATABASE IF NOT EXISTS `".$dataBaseName."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			
			@$this->res = $this->mysqli->query($this->sql);
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				return true;
			}
		}
	}
	
	public function createTable($tableName){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$tableNameMdf = str_replace("_", " ", $tableName);
			$tableNameMdf = str_replace("-", " ", $tableNameMdf);
			$tableNameMdf = ucwords($tableNameMdf);
			$tableNameMdf = str_replace(" ", "", $tableNameMdf);
			
			$fields = "`id".$tableNameMdf."` int(11) NOT NULL AUTO_INCREMENT,";
			$fields .= "`dataCriacao` bigint(20) DEFAULT NULL,";
			$fields .= "`dataModificacao` bigint(20) DEFAULT NULL,";
			$fields .= "`historico` mediumtext,";
			$fields .= "`status".$tableNameMdf."` int(1) DEFAULT '1',";
			$fields .= "`filial` int(11) DEFAULT NULL,";
			$fields .= "`usuario` int(11) DEFAULT NULL,";
			$fields .= "PRIMARY KEY (`id".$tableNameMdf."`)";
		
			$this->sql = "CREATE TABLE `".$tableName."` (".$fields.") ENGINE=InnoDB DEFAULT CHARSET=utf8";
			
			@$this->res = $this->mysqli->query($this->sql);
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				return true;
			}
		}
	}
	
	public function dropColumnTable($table,$columnName){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$this->sql = "ALTER TABLE `".$table."` DROP COLUMN `".$columnName."`;";
				
			@$this->res = $this->mysqli->query($this->sql);
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				return true;
			}
		}
	}
	
	public function dropDb($dataBaseName){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$this->sql = "DROP DATABASE `".$dataBaseName."`;";
			
			@$this->res = $this->mysqli->query($this->sql);
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				return true;
			}
		}
	}
	
	public function dropTable($table){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$this->sql = "DROP TABLE `".$table."`";
			
			@$this->res = $this->mysqli->query($this->sql);
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				return true;
			}
		}
	}
	
	public function exeQuery($query){
		if($this->sqlServer===false){
			$this->mysqli = $this->connect();
			if($this->mysqli===false){
				return false;
			}else{
				$this->sql = $query;
				
				@$this->res = $this->mysqli->query($this->sql);
				if($this->res===false){
					$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
					return false;
				}else{
					return $this->res;
				}
			}
		}else{
			$this->sqlServerConn = $this->connect();
			if($this->sqlServerConn===false){
				return false;
			}else{
				$this->sql = $query;
			
				@$this->res = sqlsrv_query($this->sqlServerConn, $this->sql, array() ,array( "Scrollable" => SQLSRV_CURSOR_KEYSET));
				if($this->res===false){
					$errors = sqlsrv_errors();
					foreach ($errors as $error){
						$this->setError("(".$error['code'].") ".$error['message']);
					}
					return false;					
				}else{
					return $this->res;
				}
			}
		}
	}
	
	public function getDataBase(){
		return $this->dataBase;
	}
	
	public function getDataSetName(){
		return $this->dataSetName;
	}
	
	public function getError($n=false,$access=false){
		global $REPORTING_ERROR;
		global $page;
		
		if(($REPORTING_ERROR==1 && $page->session->getLoginId()==1) || $page->session->getLoginTipo()==2 || $access===true){
			if($n===false){
				$n = count($this->error);
				if(isset($this->error[$n])){
					return str_replace("@numError", $n."/".$n, $this->error[$n]);
				}else{
					return false;
				}
			}else{
				$t = count($this->error);
				if(isset($this->error[$n])){
					return str_replace("@numError", $n."/".$t, $this->error[$n]);
				}else{
					return false;
				}
			}
		}else{
			return "<br><br>Para mais detalhes do erro solicite ajuda ao suporte técnico<br><br>";
		}
	}
	
	public function getStringConnection(){
		return "This Connection: SERVER - ".$this->server." | USER - ".$this->user." | DATABASE - ".$this->dataBase." | PORT - ".$this->port;
	}
	
	public function renameTable($tableName,$newTableName){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$this->sql = "RENAME TABLE `".$tableName."` TO `".$newTableName."`";
				
			@$this->res = $this->mysqli->query($this->sql);
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				$sel = new iSelect($this,$newTableName);
				$sel->listColumn();
				$resSel = $sel->exe();
				
				if($resSel===false){
					$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
					return false;
				}else{
					$error = false;
					
					$lastField = "1";
					$arrayColumns = array();
					while($row = $sel->read()){
						$row['After'] = $lastField;
						$arrayColumns[$row['Field']] = $row;
						$lastField = $row['Field'];
					}
					
					$tableNameUcw = ucwords($tableName);
					$newTableNameUcw = ucwords($newTableName);
					
					$columnsVerifyName = array("id".$tableNameUcw => "id".$newTableNameUcw,"status".$tableNameUcw => "status".$newTableNameUcw,"id".$tableNameUcw."Remoto" => "id".$newTableNameUcw."Remoto");
					
					foreach ($columnsVerifyName as $key => $value){
						if(isset($arrayColumns[$key])){
							$type = $arrayColumns[$key]['Type'];
							$type = substr($type, 0, strpos($type, "("));
							$size = $arrayColumns[$key]['Type'];
							$size = $this->parseTextBetween("(", ")", $size);
							$resChangeColumnTable = $this->changeColumnTable($newTableName, $key, $value, $type, $size, false, $arrayColumns[$key]['Null'], false, $arrayColumns[$key]['Extra'], false);
						
							if($resChangeColumnTable===false){
								$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
								$error = true;
							}
						}else{
							$resAddColumnTable = $this->addColumnTable($newTableName, $value, $type, $size, $arrayColumns[$key]['After'], $arrayColumns[$key]['Null'], $arrayColumns[$key]['Default'], $arrayColumns[$key]['Extra'], $arrayColumns[$key]['Key']);
						
							if($resAddColumnTable===false){
								$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
								$error = true;
							}
						}
					}
					
					if(!isset($arrayColumns['dataCriacao'])){
						$resAddColumnTable = $this->addColumnTable($newTableName, "dataCriacao", "BIGINT", "20", "id".$newTableNameUcw, false, false, false, false);
				
						if($resAddColumnTable===false){
							$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
							$error = true;
						}
					}
					
					if(!isset($arrayColumns['dataModificacao'])){
						$resAddColumnTable = $this->addColumnTable($newTableName, "dataModificacao", "BIGINT", "20", "dataCriacao", false, false, false, false);
					
						if($resAddColumnTable===false){
							$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
							$error = true;
						}
					}
					
					if(!isset($arrayColumns['historico'])){
						$resAddColumnTable = $this->addColumnTable($newTableName, "historico", "TEXT", false, "dataModificacao", false, false, false, false);
					
						if($resAddColumnTable===false){
							$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
							$error = true;
						}
					}
					
					if(!isset($arrayColumns['filial'])){
						$resAddColumnTable = $this->addColumnTable($newTableName, "filial", "INT", "11", "id".$newTableNameUcw."Remoto", false, false, false, false);
					
						if($resAddColumnTable===false){
							$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
							$error = true;
						}
					}
					
					if(!isset($arrayColumns['usuario'])){
						$resAddColumnTable = $this->addColumnTable($newTableName, "usuario", "INT", "11", "filial", false, false, false, false);
					
						if($resAddColumnTable===false){
							$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error);
							$error = true;
						}
					}
					
					if($error===false){
						return true;
					}else{
						return false;
					}
				}
			}
		}
	}
	
	public function setConnection($server,$user,$pass,$dataBase=false,$port=false){
		$this->server = $server;
		$this->user = $user;
		$this->pass = $pass;
		$this->dataBase = $dataBase;
		$this->port = $port;
	}
	
	public function setDataBase($dataBase){
		$this->dataBase = $dataBase;
	}
	
	public function setError($msg){
		$id = count($this->error) + 1;
		$this->error[$id] = "<br><br>Error Mysql @numError: ".$msg."<br><br>";
	}
	
	public function setPort($port){
		$this->port = $port;
	}
	
	public function setServer($server){
		$this->server = $server;
	}
	
	public function showCreateTable($table,$autoIncrement=true,$engine=true,$charset=true){
		$this->mysqli = $this->connect();
		if($this->mysqli===false){
			return false;
		}else{
			$this->sql = "SHOW CREATE TABLE ".$table;
			
			@$this->res = $this->mysqli->query($this->sql);
			if($this->res===false){
				$this->setError("(".$this->mysqli->errno.") ".$this->mysqli->error."<br><br>{ ".$this->sql." }");
				return false;
			}else{
				$row = $this->res->fetch_assoc();
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
			}
		}
	}
}