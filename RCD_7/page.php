<?php
# Page
include_once 'color.php';
include_once 'session.php';
include_once 'head.php';
include_once 'body.php';

$NO_REPOSITION_CORPO = false;

class page extends generic {
	private $title = "SEM TÍTULO";
	private $loadJava = true;
	private $loadCss = true;
	private $resetAutoSave = false;
	private $readOnly = false;
	private $imprimir = false;
	private $autoCompleteOff = true;
	private $uppercase = true;
	private $isParent = false;
	private $bootstrap = false;
	public $head;
	public $color;
	public $body;
	public $session;
	public $linksJs = array();
	public $path;
	
	function __construct($name){
		global $PATH;
		global $PATHB;
		
		$this->name = $name;
		$this->newObj($this,"PAGE_".$this->name,"page","html");
		$name = "session";
		$this->session = new session();
		$this->newObj($this->session,$name,"session","PAGE_".$this->name);
		$name = "head";
		$this->head = new head($name);
		$this->newObj($this->head,$name,"head","PAGE_".$this->name);
		$this->head->linkIco(@$PATH.@$PATHB."imagens/fav/");
		$name = "body";
		$this->body = new body($this->name);
		$this->newObj($this->body,$this->name,"body","PAGE_".$this->name);
		$this->color = new color();
		$this->nivel = -1;
		global $PAGENAME;
		if($this->session->getSession("PRINT",$PAGENAME)){
			$this->imprimir = true;
			$this->body->imprimir();
		}
	}
	
	public function useBootstrap(){
		$this->bootstrap = true;
	}
	
	public function getIsParent(){
		return $this->isParent;
	}
	
	public function setAsParent(){
		$this->isParent = true;
	}
	
	public function imprimir(){
		$this->imprimir = true;
	}
	public function getAutocompleteOff(){
		return $this->autoCompleteOff;
	}
	
	public function getUpperCase(){
		return $this->uppercase;
	}
	
	public function setReadOnly(){
		$this->readOnly = true;
	}
	public function getReadOnly(){
		return $this->readOnly;
	}
	public function getResetAutoSave(){
		return $this->resetAutoSave;
	}
	public function getLoadCss(){
		return $this->loadCss;
	}
	public function getLoadJava(){
		return $this->loadJava;
	}
	public function setOnLoadFunction($obj){
		$this->body->java->setOnLoad();
		$this->body->java->setFunctionObjInvisible();
		$this->body->objAction = $obj;
	}
    public function getPageName(){
        return "PAGE_".$this->name;
    }
    public function meta($arg1,$arg2="",$arg3=""){
        $this->head->meta($arg1,$arg2,$arg3);
	}
	public function setPath($path){
		$this->head->setPath($path);
	}
	public function linkIco($address){
		$this->head->linkIco($address);
	}
	public function linkCss($address){
		$this->head->linkCss($address);
	}
	public function linkJs($address){
		$this->linksJs[count($this->linksJs)]['address'] = $this->path.$address;
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function getStatus(){
		global $REPORTING_ERROR;
		if($REPORTING_ERROR){
			return "?".time();
		}else{
			return "";
		}
	}
	public function End($parent=false,$isCore=false){
		global $page;
		global $PAGENAME;
		global $NO_REPOSITION_CORPO;
		global $CURL_EXECTED;
		global $PATH;
		global $REPORTING_ERROR;
				
		$corpo = $this->getObj("corpo");
		if($corpo!==false && $this->imprimir!==true && !$this->session->getSession("PRINT",$PAGENAME) && !$NO_REPOSITION_CORPO){
			if($this->bootstrap){
				$corpo->css->setPosition(0, 100);
			}else{
				$corpo->css->setPosition(px, py);
			}
		}
		#$this->e("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");
		#$this->e("<html xmlns=\"http://www.w3.org/1999/xhtml\">");
		$this->e("<!doctype html>");
		$this->e("<html lang=\"pt-BR\">");
		$this->e("<title>".$this->title."</title>");
		global $NO_GET_WIDTH;
		/*if(!@$NO_GET_WIDTH){
			if($this->session->getSession("MANUTENCAO")){
				$this->e("<script language=\"javascript\">");
				$this->e("var width = screen.width;");
				$this->e("document.location.href = 'http://www.meucartaovisita.com.br/indexB.html';");
				$this->e("</script>");
			}else{
				if(!$this->session->getSession("SW")){
					$this->e("<script language=\"javascript\">");
					$this->e("var width = screen.width;");
					$this->e("document.location.href = '".$_SERVER['SCRIPT_NAME']."?SW=' + width;");
					$this->e("</script>");
				}
			}
		}*/
		if($this->bootstrap){
			$this->head->linkCss("../RCD_7/bootstrap/css/bootstrap.css".$this->getStatus());
			$this->head->linkCss("class/generic.css".$this->getStatus());
		}
		$this->endObj("PAGE_".$this->name,"head");
		$this->e("<style>");
		$this->endObj("","style");
		$this->e("</style>");
		#$this->endObj("PAGE_".$this->name,"iframe");
		$this->endObj("PAGE_".$this->name);
		if(isset($this->linksJs)){
			foreach ($this->linksJs as $key => $value){
				$this->e("<script language=\"JavaScript\" src=\"".$this->linksJs[$key]['address']."\"  charset=\"UTF-8\"></script>");
			}
		}
		$this->e("<script language=\"javascript\">");
		$this->endObj("","java");
		$this->e("</script>");
		if($this->bootstrap){
			$this->e("<script src=\"".$PATH."../RCD_7/bootstrap/js/jquery-3.3.1.slim.min.js".$this->getStatus()."\"></script>",$this->nivel + 1);
			$this->e("<script src=\"".$PATH."../RCD_7/bootstrap/js/popper.min.js".$this->getStatus()."\"></script>",$this->nivel + 1);
			$this->e("<script src=\"".$PATH."../RCD_7/bootstrap/js/bootstrap.min.js".$this->getStatus()."\"></script>",$this->nivel + 1);
		}
		$this->e("<head>");
		$this->e("<meta http-equiv=\"cache-control\" content=\"no-cache\" />",$this->nivel + 1);
		$this->e("<meta http-equiv=\"pragma\" content=\"no-cache\" />",$this->nivel + 1);
		$this->e("</head>");
		if($this->imprimir===true){
			$this->e("
			<SCRIPT LANGUAGE=\"JavaScript\">
				window.print();
			</SCRIPT>
			");
			//window.close();
		}
		if($parent){
			if($isCore===false){
				$this->e("
				<SCRIPT LANGUAGE=\"JavaScript\">
					parent.document.getElementById('".$parent."').innerHTML = document.body.innerHTML;
					parent.closeBaseCarregando();
				</SCRIPT>
				");
			}else{
				$this->e("
				<SCRIPT LANGUAGE=\"JavaScript\">
					parent.document.getElementById('".$parent."').innerHTML = document.body.innerHTML;
					parent.closeBaseCarregandoCore();
				</SCRIPT>
				");
			}
		}else{
			$this->e("
				<SCRIPT LANGUAGE=\"JavaScript\">
					var globalActionYes;
					var globalActionNo;
					var msgGate = false;
					function msg(msg,type,actionYes,actionNo,condition,msgB){
						try{
							msgGate = true;
							var baseMsgId = document.getElementById('baseMsg');
							var baseBaseMsgId = document.getElementById('baseBaseMsg');
							var msgId = document.getElementById('msg');
							var textoMsgId = document.getElementById('textoMsg');
							var textoMsgBid = document.getElementById('textoMsgB');
							var yesId = document.getElementById('btYes');
							var noId = document.getElementById('btNo');
							/*var botoesMsgId = document.getElementById('botoesMsg');
						
							botoesMsgId.style.display = 'block';*/
							
							if(typeof condition!=='undefined'){
								if(condition!=false){
									yesId.innerHTML = 'Sim';
									noId.innerHTML = 'Não';
								}else{
									yesId.innerHTML = 'Ok';
									noId.innerHTML = 'Cancelar';
								}
							}else{
								yesId.innerHTML = 'Ok';
								noId.innerHTML = 'Cancelar';
							}
						
							textoMsgId.innerHTML = msg;
							
							/*if(typeof msgB!=='undefined'){
								textoMsgBid.innerHTML = msgB;
							}else{
								textoMsgBid.innerHTML = '';
							}*/
						
							if(type==1){
								baseBaseMsgId.style.backgroundColor = 'rgb(20,100,20)';
							}else if(type==-1){
								baseBaseMsgId.style.backgroundColor = 'rgb(120,10,10)';
							}else{
								baseBaseMsgId.style.backgroundColor = 'rgb(0,40,70)';
							}
						
							baseMsgId.style.display = 'block';
							msgId.style.display = 'block';
						
							if(typeof actionNo==='undefined'){
								actionNo = actionYes;
							}
							
							globalActionYes = actionYes;
							globalActionNo = actionNo;
						}catch(e){
							alert('msg: ' + e);
						}
					}
					function exeActionYes(){
						if(globalActionYes=='close'){
							msgClose();
						}else if(globalActionYes=='aprovar'){
							aprovar();
						}else if(globalActionYes=='ativar'){
							ativar();
						}else if(globalActionYes=='desativar'){
							desativar();
						}else if(globalActionYes=='desaprovar'){
							desaprovar();
						}else if(globalActionYes=='desfaturar'){
							desfaturar();
						}else if(globalActionYes=='faturar'){
							faturar();
						}else if(globalActionYes=='bloquear'){
							bloquear();
						}else if(globalActionYes=='resetar'){
							resetar();
						}else if(globalActionYes=='liberar'){
							liberar();
						}else if(globalActionYes=='estornar'){
							estornar();
						}else if(globalActionYes=='concluir'){
							concluir();
						}else if(globalActionYes=='alterar'){
							alterar();
						}else if(globalActionYes=='naoAlterar'){
							naoAlterar();
						}else if(globalActionYes=='forcado'){
							forcado();
						}else{
							go(globalActionYes);
						}
					}
					
					function exeActionNo(){
						if(globalActionNo=='close'){
							msgClose();
						}else if(globalActionNo=='ativar'){
							ativar();
						}else if(globalActionNo=='desativar'){
							desativar();
						}else if(globalActionNo=='bloquear'){
							bloquear();
						}else if(globalActionNo=='resetar'){
							resetar();
						}else if(globalActionNo=='liberar'){
							liberar();
						}else if(globalActionNo=='estornar'){
							estornar();
						}else if(globalActionNo=='concluir'){
							concluir();
						}else if(globalActionNo=='alterar'){
							alterar();
						}else if(globalActionNo=='naoAlterar'){
							naoAlterar();
						}else if(globalActionNo=='forcado'){
							forcado();
						}else{
							go(globalActionNo);
						}
					}

					function msgClose(){
						var msgId = document.getElementById('baseMsg');
						msgId.style.display = 'none';
					}

					document.getElementById('btYes').addEventListener('click', function(){
						if(msgGate===true){
							msgGate = false;
							exeActionYes();
						}
					}, true);

					document.getElementById('btNo').addEventListener('click', function(){
						if(msgGate===true){
							msgGate = false;
							exeActionNo();
						}
					}, true);
				</SCRIPT>
			");
		}
		$this->e("</html>");
		$this->e("<!-- SCREEN WIDTH: ".$this->session->getSession("SW")." -->",0,0);
        
        if(1){
        #if($REPORTING_ERROR){
		    global $OBJ;
		    global $HTML;
		    for($i=0;$i<count($OBJ);$i++){
			    $name = $OBJ[$i]['name'];
			    $type = $OBJ[$i]['type'];
			    $father = $OBJ[$i]['father'];
                #if($type=="style" || $type=="java"){
			        $this->e("<!-- OBJ ".$i." - TYPE: ".$type." - FATHER: ".$father." - NAME: ".$name." -->");
                #}
		    }
	        global $TYPE_SETTED;
	        for($i=0;$i<count($TYPE_SETTED);$i++){
	        	$this->e("<!-- TYPE.: ".$TYPE_SETTED[$i]." -->");
	        }
	        $this->e("<!-- MEMORY.: ".$this->memoryUsage()." -->");
	        $this->e("<!-- BYTES PAGE.: ".$this->getBytesPage()." -->");
	        
	        global $TIME_LOAD_START;
	        $TIME_LOAD_END = microtime_float();
	        
	        $this->e("<!-- TIME.: ".($TIME_LOAD_END - $TIME_LOAD_START)." -->");
        }
        
        if($page->session->getSession("PRINT",$PAGENAME)){
        	$page->session->unSetSession("PRINT",$PAGENAME);
        }
	}
    public function memoryUsage() {
 
        $memory = memory_get_usage();
        
        if($memory < 1024){
            $textMemory = $memory." Bytes";
        }elseif ($memory < 1048576){
            $textMemory = round($memory / 1024, 2)." KB";
        }else{
            $textMemory = round($memory / 1048576, 2) . " MB";
        }

        return $textMemory;
    }
}