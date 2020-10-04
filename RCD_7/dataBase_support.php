<?php
# Support :: DataBase
class support extends generic {
	# ERROS
	# 0. Ocorreu uma falha na conexão
	# 1. Ocorreu uma falha na seleção do banco de dados
	# 2. Ocorreu uma falha na desconexão
	# 3. Ocorreu uma falha na pesquisa select
	# 4. Ocorreu uma falha na pesquisa de coluna
	# 5. Ocorreu uma falha na execução do insert
    # 6. Ocorreu uma falha na execução do update
	protected $msgError = array("Ocorreu uma falha na conexão","Ocorreu uma falha na seleção do banco de dados","Ocorreu uma falha na desconexão","Ocorreu uma falha na pesquisa select","Ocorreu uma falha na pesquisa de coluna","Ocorreu uma falha na execução do insert","Ocorreu uma falha na execução do update");
	protected $error = array();
	protected $id;
	protected $sql;
	protected $numRows;
	protected $lastMsg;
	public $port = false;
	
	public function getNumRows(){
		return $this->numRows;
	}
	public function getNumErrors(){
		return count($this->error);
	}
	public function getErrorMySql($numError){
		return $this->error[$numError];
	}
	public function getMsgErrorMysql(){
	    return $this->lastMsg;
	}
	public function getMsgError(){
		if(count($this->error)>0){
			return @$this->msgError[$this->error[count($this->error) - 1]];
		}else{
			return 0;
		}
	}
	public function getSql($access=false){
		if(strpos(strtoupper($_SERVER['SCRIPT_NAME']),"ENVIRONMENT") || $access===true){
			return $this->sql;
		}else{
			return null;
		}
	}
	protected function disconnect(){
		if(@mysql_close($this->id)){
			return 1;
		}else{
			$this->error[count($this->error)] = 3; 
			return 0;
		}
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
}