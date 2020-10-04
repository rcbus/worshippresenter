<?php
# Session
if(!isset($SESSION_NAME)){
	$SESSION_NAME = "RCD";
}
session_name($SESSION_NAME);
session_start();
class session {
	private $login_id;
	private $login_name;
	private $login_filial = 1;
	private $login_tipo;
	
	function __construct(){
		$this->login_id = @$_SESSION['LOGIN_ID'];
		$this->login_name = @$_SESSION['LOGIN_NAME'];
		$this->login_tipo = @$_SESSION['PF_USER_TIPO'];
		$this->login_filial = @$_SESSION['LOGIN_FILIAL'];
        $this->loadGetVariable();
	}
    private function loadGetVariable(){
    	global $REPEAT_FROM_GET;
    	if($REPEAT_FROM_GET===true){
    		$refresh = 1;
    	}else{
    		$refresh = 0;
    	}
        if(isset($_GET)){
            if(count($_GET)>0){
                foreach($_GET as $key => $value){
                	$pos = strpos($value, "@");
                	if($pos===false){
                    	$this->setSession($key,$value);
                	}else{
                		$this->setSession($key,substr($value,0,$pos),substr($value, ($pos+1), (strlen($value)-$pos-1)));
                	}
                    if($key=="noRefresh" && $value=="1"){
                    	$refresh = 0;
                    }
                }
                if($refresh==1){
                	$this->refresh();
                	exit;
                }
            }
        }
    }
    public function refresh(){
		header("Location: ".$_SERVER['SCRIPT_NAME']);
	}
	public function logOff($returnToPage){
		unset($_SESSION['LOGIN_ID']);
		unset($_SESSION['LOGIN_NAME']);
		unset($_SESSION['SECURITY_CODE']);
		$this->goToPage($returnToPage);
	}
	public function setThisPageAsLogged($code,$returnToPage){
		if(!isset($_SESSION['LOGIN_ID']) || !isset($_SESSION['SECURITY_CODE'])){
			$this->goToPage($returnToPage);
			return false;
		}else{
			if($_SESSION['SECURITY_CODE']!=$code || $this->login_id=="" || $this->login_id==0){
				$this->goToPage($returnToPage);
				return false;
			}else{
				return true;
			}
		}
	}
	public function setSecurityCode($code){
		$_SESSION['SECURITY_CODE'] = $code;
	}
	public function getSecurityCode(){
		if(isset($_SESSION['SECURITY_CODE'])){
			return $_SESSION['SECURITY_CODE'];
		}
	}
	public function setSession($name,$value="",$page=false,$withoutquotation=false){
		if($withoutquotation===false){
			if($page===false || $page==""){
				$_SESSION["'".$name."'"] = $value;
			}else{
				$_SESSION["'".$page."'"]["'".$name."'"] = $value;
			}
		}else{
			if($page===false || $page==""){
				$_SESSION[$name] = $value;
			}else{
				$_SESSION[$page][$name] = $value;
			}
		}
	}
	public function getSession($name,$page=false,$withoutquotation=false){
		if($withoutquotation===false){
			if($page===false || $page==""){
				return @$_SESSION["'".$name."'"];
			}else{
				return @$_SESSION["'".$page."'"]["'".$name."'"];
			}
		}else{
			if($page===false || $page==""){
				return @$_SESSION[$name];
			}else{
				return @$_SESSION[$page][$name];
			}
		}
	}
    public function unSetSession($name,$page=false,$withoutquotation=false){
    	if($withoutquotation===false){
	        if($page===false || $page==""){
				$_SESSION["'".$name."'"] = "";
			}else{
				$_SESSION["'".$page."'"]["'".$name."'"] = "";
			}
    	}else{
    		if($page===false || $page==""){
    			$_SESSION[$name] = "";
    		}else{
    			$_SESSION[$page][$name] = "";
    		}
    	}
    }
	public function setLoginName($name){
		$this->login_name = $name;
		$_SESSION['LOGIN_NAME'] = $this->login_name;
	}
	public function getLoginName(){
		return $this->login_name;
	}
	public function setLoginId($id){
		$this->login_id = $id;
		$_SESSION['LOGIN_ID'] = $this->login_id;
	}
	public function getLoginId(){
		return $this->login_id;
	}
	public function getLoginTipo(){
		return $this->login_tipo;
	}
	public function setLoginFilial($filial){
		$this->login_filial = $filial;
		$_SESSION['LOGIN_FILIAL'] = $this->login_filial;
	}
	public function getLoginFilial(){
		return $this->login_filial;
	}
	public function goToPage($page){
		header("Location: ".$page);
	}
	public function End(){
	}
}