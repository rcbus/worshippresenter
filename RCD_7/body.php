<?php
# Body
include_once 'generic.php';
class body extends generic {
	public $css;	
	public $onLoadFunction = false;
	public $java;
	public $objAction;
	private $imprimir = false;
	private $eventOnKeyPress = false;
	private $eventBySpecificKey = array();
	private $eventByEnter = false;
	private $submitByEnter = false;
	
	function __construct($name,$nivel=0){
		$this->nivel = $nivel;
		$this->name = $name;
		$this->css = new style($this->name,"","body");
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
	}
	
	public function eventBySpecificKey($key,$functionName,$arg=false){
		$this->eventOnKeyPress = true;
		$id = count($this->eventBySpecificKey);
		$this->eventBySpecificKey[$id] = $key."){ ".$functionName."(".$arg."); }";
	}
	public function eventByEnter($functionName,$arg=false){
		$this->eventOnKeyPress = true;
		$this->eventByEnter = $functionName."(".$arg.");";
	}
	public function submitByEnter($objName){
		$this->eventOnKeyPress = true;
		$this->submitByEnter = "document.getElementById('".$objName."').submit();";
	}
	public function imprimir(){
		$this->imprimir = true;
	}
	public function End(){
		global $NO_BOTTOM;
		global $NO_REPOSITION_CORPO;
		
		if($this->eventOnKeyPress===false){
			$eventOnKeyPress = "";
		}else{
			$eventOnKeyPress = " onKeyDown=\"exeEventKey(event);\"";
			#$eventOnKeyPress = "onKeyPress=\"javascript:return false;\" onKeyDown=\"exeEventKey(event);\"";
			#$eventOnKeyPress = " onKeyDown=\"exeEventKey(event);\"";
		}
		
		if($this->onLoadFunction!==false){
			$eventOnKeyPress .= " onLoad=\"".$this->onLoadFunction."\"";
		}
		
		if($this->imprimir===false){
			$this->e("<body".$this->java->getLineCommand($this->objAction).$eventOnKeyPress.">");
		}else{
			$this->e("<body".$this->java->getLineCommand($this->objAction).$eventOnKeyPress." onClick=\"window.close();\">");
		}
		$this->endObj($this->name);
		if(!@$NO_BOTTOM && $NO_REPOSITION_CORPO!==true){
			$this->e("<style>#corpo{ position:relative;left:3%;width:95%; }</style>");
			$this->e("<div style=\"width:100%;height:100px;\"></div>");
		}
		$this->e("</body>");
		if($this->eventOnKeyPress!==false){
			$this->e("<script language=\"javascript\">");
			$this->e("function exeEventKey(evt){");
			#$this->e("alert(\"teste\");");
			$this->e("var charCode = (evt.which) ? evt.which : evt.keyCode;",1);
			if($this->eventBySpecificKey){
				foreach ($this->eventBySpecificKey as $key => $value){
					$this->e("if(charCode == ".$value,1);
				}
			}
			if($this->eventByEnter){
				$this->e("if(charCode == 13){ ".$this->eventByEnter." }",1);
			}
			if($this->submitByEnter){
				$this->e("if(charCode == 13){ ".$this->submitByEnter." }",1);
			}
			$this->e("}");
			$this->e("</script>");
		}
	}
}