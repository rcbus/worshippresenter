<?php
include_once 'java_command.php';
include_once 'java_exe.php';

define("onClick","onClick");
define("blur","blur");
define("change","change");
define("focus","focus");
define("keyup","keyup");
define("keydown","keydown");
define("onLoad","onLoad");
define("onMouseOver","onMouseOver");
define("onMouseOut","onMouseOut");

$TYPE_SETTED = array();
$FIRST_OBJ_JAVA = true;

# Java
class java {
	private $nivel = 0;
	private $Function = array();
	private $onClick;
	private $blur;
	private $change = array();
	private $focus;
	private $onLoad;
	private $onMouseOver;
	private $onMouseOut;
	private $obj;
	private $lineCommand;
	private $keyup;
	private $keyupArray = array();
	private $keydown;
	private $click;
	private $clickArray = array();
	private $port = "8090";
	private $arrayObj = array();
	
	function __construct(){
		$this->onClick = new command();
		$this->click = new command();
		$this->blur = new command();
		$this->focus = new command();
		$this->keyup = new command();
		$this->keydown = new command();
		$this->onLoad = new command();
		$this->onMouseOver = new command();
		$this->onMouseOut = new command();
	}
	public function stringToUpper($text){
		$text = strtoupper(strtr($text,"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"));
		return $text;
	}
	public function addLineCommand($lineCommand){
		if(strlen($this->lineCommand)>0){
			$this->lineCommand .= "\"";
		}
		$this->lineCommand .= $lineCommand;
	}
	public function setOnClick(){
		if(!$this->obj){
			$this->addLineCommand(" onClick=\"");
			$this->obj = $this->onClick;
		}
	}
	public function setOnFocus(){
		$this->addLineCommand(" onFocus=\"");
		$this->obj = $this->focus;
	}
	public function setOnLoad(){
		$this->addLineCommand(" onLoad=\"");
		$this->obj = $this->onLoad;
	}
	public function setOnMouseOver(){
		$this->addLineCommand(" onMouseOver=\"");
		$this->obj = $this->onMouseOver;
	}
	public function setOnMouseOut(){
		$this->addLineCommand(" onMouseOut=\"");
		$this->obj = $this->onMouseOut;
	}
	public function setObjInnerHtml($event,$obj,$objAffected,$html=""){
		if($this->stringToUpper($event)=="CLICK"){
			$this->obj = $this->click;
		}
		$this->obj->setInnerHtml($event,$obj,$objAffected,$html);
	}
	public function setObjPosition($event,$obj,$objAffected,$posX=0,$posY=0){
		if($this->stringToUpper($event)=="CLICK"){
			$this->obj = $this->click;
		}
		$this->obj->setPosition($event,$obj,$objAffected,$posX,$posY);
	}
	public function setObjVisible($event,$obj,$objAffected){
		$this->obj = new command();
		$this->obj->setVisible($event,$obj,$objAffected,count($this->arrayObj));
		$this->arrayObj[count($this->arrayObj)] = $this->obj;
		# FUNCIONAVA ASSIM ATÉ 14/01/2017
		/*if($this->stringToUpper($event)=="CLICK"){
			$this->obj = $this->click;
		}
		$this->obj->setVisible($event,$obj,$objAffected);*/
	}
	public function setObjInvisible($event,$obj,$objAffected){
		$this->obj = new command();
		$this->obj->setInvisible($event,$obj,$objAffected,count($this->arrayObj));
		$this->arrayObj[count($this->arrayObj)] = $this->obj;
		# FUNCIONAVA ASSIM ATÉ 14/01/2017
		/*if($this->stringToUpper($event)=="CLICK"){
			$this->obj = $this->click;
		}
		$this->obj->setInvisible($event,$obj,$objAffected);*/
	}
	public function setObjVisibleTogger($event,$obj,$objAffected,$force=false){
		$this->obj = new command();
		$this->obj->setVisibleTogger($event,$obj,$objAffected,$force,count($this->arrayObj));
		$this->arrayObj[count($this->arrayObj)] = $this->obj;
	}
	public function setClear($event,$obj,$onlyOne=false,$objAffected="this"){
		$this->obj = $this->focus;
		$this->obj->clear($event,$obj,$onlyOne,$objAffected);
	}
	public function setMathInterObj($event,$obj,$objA,$objB,$objAffected="this",$typeMath="SUM",$digit=2,$id=false){
		$this->obj = $this->blur;
		$this->obj->mathInterObj($event,$obj,$objA,$objB,$objAffected,$typeMath,$digit,$id);
	}
	public function setToUpperCase($event,$obj){
		$this->obj = $this->keyup;
		$this->obj->toUpperCase($event, $obj);
	}
	public function setGoToPage($event,$obj,$page="",$parameter="",$value=false,$target="",$addParameter="",$port="",$objToGetValue=false,$child=false,$execute=false,$timeout=false){
		$id = false;
		if($event=="change"){
			$id = count($this->change);
			$this->change[$id] = new command();
			$this->obj = $this->change[$id];
		}else if($event=="click"){
			if(!is_array($this->clickArray)){
				$this->clickArray = array();
			}
			$id = count($this->clickArray);
			$this->clickArray[$id] = new command();
			$this->obj = $this->clickArray[$id];
		}else{
			$this->obj = $this->$event;
		}
		if($this->stringToUpper($target)=="_BLANK" || $this->stringToUpper($target)=="BLANK"){
			$page = $_SERVER['SERVER_NAME'].$page;
		}
		$this->obj->goToPageEvent($event,$obj,$page,$parameter,$value,$target,$addParameter,$port,$objToGetValue,$child,$execute,$timeout,$id);
	}
	public function setFunctionGoToPage($page="",$parameter="",$value=false,$target="",$addParameter="",$addPageColumn=false,$child=false){
		if($page==""){
			$page = $_SERVER['SCRIPT_NAME'];
		}
		if($addPageColumn===true){
			$page = $page."@varA";
		}
        if($value!==false && $value!=""){
		    $this->lineCommand .= "goToPage('".$page."','".$parameter."','".$value."','".$target."','".$addParameter."','".$child."');";
        }else if($value!==false){
        	$this->lineCommand .= "goToPage('".$page."','".$parameter."','','".$target."','".$addParameter."','".$child."');";
        }else{
        	$addParameter = $addParameter.$addPageColumn;
            $this->lineCommand .= "goToPage('".$page."','".$parameter."','@varA','".$target."','".$addParameter."','".$child."');";
        }
		$this->obj->goToPage();
	}
	public function setFunctionGoToPageWithGetValue($page="",$parameter="",$value=false,$objToGetValue=false,$target="",$addParameter="",$addPageColumn=false,$child=false){
		if($page==""){
			$page = $_SERVER['SCRIPT_NAME'];
		}
		if($addPageColumn===true){
			$page = $page."@varA";
		}
		
		if($value!==false && $value!=""){
			$this->lineCommand .= "goToPageWithGetValue('".$page."','".$parameter."','".$value."','".$objToGetValue."','".$target."','".$addParameter."','".$child."');";
		}else if($objToGetValue!==false && $objToGetValue!=""){
			$this->lineCommand .= "goToPageWithGetValue('".$page."','".$parameter."','".$value."','".$objToGetValue."','".$target."','".$addParameter."','".$child."');";
		}else if($objToGetValue!==false){
			$this->lineCommand .= "goToPageWithGetValue('".$page."','".$parameter."','".$value."','','".$target."','".$addParameter."','".$child."');";
		}else{
			$this->lineCommand .= "goToPageWithGetValue('".$page."','".$parameter."','".$value."','@varA','".$target."','".$addParameter."','".$child."');";
		}
		$this->obj->goToPageWithGetValue();
	}
	public function setFunctionSetValue($obj="",$value="",$var=false){
 		if($value!==false && !$value){
			$value = "";
		}else if(!$value){
			$value = "@varB";
		}else{
			$value = "@varA";
		}
		if($obj!==false && !$obj){
			$obj = "";
		}else if(!$obj){
			$obj = "@varA";
		}
		if($var!==false){
			$value = $var;
		}
		$this->lineCommand .= "setValue('".$obj."','".$value."');";
		$this->obj->setValue();
	}
	public function setFunctionReset($obj=false,$typeObj=false,$var=false,$varB=false,$varC=false){
		if($obj!==false && !$obj){
			$obj = "";
		}else if(!$obj){
			$obj = "@varA";
		}
		if($typeObj==="textBox"){
			$this->lineCommand .= "reset('".$obj."','".$value."');";
			$this->obj->setValue();
		}else if($typeObj==="comboBox"){
			$this->lineCommand .= "resetComboBox('".$obj."','".$var."','".$varB."','".$varC."');";
			$this->obj->resetComboBox();
		}
	}
	public function setReset($event,$obj,$objAffected,$typeObj=false,$var=false,$varB=false,$varC=false){
		if($typeObj=="comboBox"){
			$this->obj->resetComboBoxEvent($event,$obj,$objAffected,$var,$varB,$varC);
		}
	}
	public function closeObj($event,$obj,$objAffected){
		$this->obj = $this->$event;
		$this->obj->closeObjEvent($event,$obj,$objAffected);
	}
	public function setValue($event,$obj,$objAffected,$value){
		$this->obj = $this->$event;
		$this->obj->setValueEvent($event,$obj,$objAffected,$value);
	}
	public function setValueCopy($event,$obj,$objOrigem,$objDest,$origemInnerHTML=false,$destInnerHTML=false){
		$this->obj = $this->$event;
		$this->obj->setValueCopyEvent($event,$obj,$objOrigem,$objDest,$origemInnerHTML,$destInnerHTML);
	}
	public function setCopyComment($event,$obj){
		$this->obj = $this->$event;
		$this->obj->setCopyCommentEvent($event,$obj);
	}
	public function setFunctionSetFocus($obj=""){
		if($obj!==false && !$obj){
			$obj = "";
		}else if(!obj){
			$obj = "@varA";
		}
		$this->lineCommand .= "setFocus('".$obj."');";
		$this->obj->setFocus();
	}
	public function setFocus($event,$obj,$objAffected="this",$onlyOne=false,$execute=false){
		$this->obj = $this->focus;
		$this->obj->setFocus($event,$obj,$objAffected,$onlyOne,$execute);
	}
	public function setFunctionTimer($interval,$obj,$script,$func,$timeout=0,$limit=0,$target=false,$objA=false,$objB=false,$objAffected=false,$typeMath="SUM",$digit=2){
		$id = count($this->clickArray);
		$this->clickArray[$id] = new command();
		$this->obj = $this->clickArray[$id];
		$this->obj->timer($interval, $obj, $script, $func, $timeout,$limit,$target,$objA,$objB,$objAffected,$typeMath,$digit,$id);
		#$this->obj = $this->click;
		#$this->obj->timer($interval, $obj, $script, $func, $timeout,$limit,$target,$objA,$objB,$objAffected,$typeMath);
	}
	public function setFunctionClearForm($obj,$clearAndSubmit=false){
		$this->lineCommand .= "clearForm('".$obj."','".$clearAndSubmit."');";
		$this->obj->clearForm();
	}
	public function setFunctionClear($obj="",$onlyOne=false){
		if($obj==""){
			$obj = "this";
		}
		if($onlyOne===false){
			$this->lineCommand .= $obj.".value=''";
		}else{
			$this->lineCommand .= "var clear".$obj." = 0;if(clear".$obj."==0){ clear".$obj." = 1; ".$obj.".value=''}";
		}
	}
				   #loadSelect($event="",$obj="",$objToLoad="",$script="",$objToGetParameter="",$parameterName="",$pagename="",$columnIndex="",$columnText=""){
	public function setLoadSelect($event,$obj,$objToLoad,$script,$objToGetParameter="",$parameterName="parameter",$pagename="",$columnIndex="",$columnText=""){
		$id = false;
		if($event=="change"){
			$id = count($this->change);
			$this->change[$id] = new command();
			$this->obj = $this->change[$id]; 
		}else{
			$this->obj = $this->$event;
		}
		$this->obj->loadSelect($event,$obj,$objToLoad,$script,$objToGetParameter,$parameterName,$pagename,$columnIndex,$columnText);
	}
	public function setReloadScript($event,$obj,$objToLoad,$script,$objToGetParameter="",$parameterName="parameter",$parent="",$pagename="",$isInnerHTML=true,$execute=false,$addParameter=false,$enableBeforeReult=false,$timeout=false){
		$id = false;
		if($event=="change"){
			$id = count($this->change);
			$this->change[$id] = new command();
			$this->obj = $this->change[$id]; 
		}else if($event=="keyup"){
			$id = count($this->keyupArray);
			$this->keyupArray[$id] = new command();
			$this->obj = $this->keyupArray[$id];
		}else{
			$this->obj = $this->$event;
		}
		$this->obj->reloadScript($event,$obj,$objToLoad,$script,$objToGetParameter,$parameterName,$parent,$pagename,$isInnerHTML,$id,$execute,false,$enableBeforeReult,$timeout);
	}
	public function core($event,$obj,$objToLoad,$script,$objToGetParameter="",$parameterName="parameter",$pagename="",$addParameter=false,$timeout=false,$showLoading=true,$execute=true,$visible=false){
		$id = false;
		if($event!==false){
			if($event=="change"){
				$id = count($this->change);
				$this->change[$id] = new command();
				$this->obj = $this->change[$id];
			}else if($event=="keyup"){
				$id = count($this->keyupArray);
				$this->keyupArray[$id] = new command();
				$this->obj = $this->keyupArray[$id];
			}else if($event=="click"){
				$id = count($this->clickArray);
				$this->clickArray[$id] = new command();
				$this->obj = $this->clickArray[$id];
			}else{
				$this->obj = $this->$event;
			}
		}else{
			$id = count($this->change);
			$this->change[$id] = new command();
			$this->obj = $this->change[$id];
		}
		$id = 0; # PROVISÓRIO APENAS PARA RESOLVER PROBLEMA NO ERP
		$this->obj->core($event,$obj,$objToLoad,$script,$objToGetParameter,$parameterName,$pagename,$addParameter,$timeout,$showLoading,$execute,$visible,$id);
	}
	public function showMsg($event,$obj,$msg="Nenhuma Mensagem!",$pathCaseYes="",$pathCaseNo="",$type="n",$objAffected=false,$target=false,$backGroundColor=COLOR_ULTRA_DARK_RED,$showComment=false,$formToSendComment=false){
		$id = false;
		if($event=="click"){
			$id = count($this->clickArray);
			$this->clickArray[$id] = new command();
			$this->obj = $this->clickArray[$id];
		}
		
		$this->obj->showMsg($event,$obj,$msg,$pathCaseYes,$pathCaseNo,$type,$objAffected,$target,$backGroundColor,$showComment,$formToSendComment,$id);
	}
	public function autoSave($event,$obj,$preValue=false){
		$id = false;
		if($event=="change"){
			$id = count($this->change);
			$this->change[$id] = new command();
			$this->obj = $this->change[$id];
		}else if($event=="keyup"){
			$id = count($this->keyupArray);
			$this->keyupArray[$id] = new command();
			$this->obj = $this->keyupArray[$id];
		}else{
			$this->obj = $this->$event;
		}
		$this->obj->setAutoSave($event,$obj,$preValue,$id);
	}
	public function setFunctionReloadScript($obj,$script,$parent=""){
		$this->lineCommand .= "reloadScript('".$obj."','".$script."','".$parent."');";
		$this->obj->reloadScript();
	}
	public function setReloadForm($event,$obj,$script,$objToGetParameter=false,$parameterName=false,$parent=false,$pagename=false,$execute=false,$addParameter=false){
		$id = false;
		if($event=="change"){
			$id = count($this->change);
			$this->change[$id] = new command();
			$this->obj = $this->change[$id];
		}else if($event=="keyup"){
			$id = count($this->keyupArray);
			$this->keyupArray[$id] = new command();
			$this->obj = $this->keyupArray[$id];
		}else{
			$this->obj = $this->$event;
		}
		$this->obj->reloadForm($event,$obj,$script,$objToGetParameter,$parameterName,$parent,$pagename,$id,$execute,$addParameter);
	}
	public function submitFormAjax($event,$obj,$script,$objToGetParameter=false,$parameterName=false,$parent=false,$pagename=false,$execute=false,$addParameter=false){
		$id = false;
		if($event=="change"){
			$id = count($this->change);
			$this->change[$id] = new command();
			$this->obj = $this->change[$id];
		}else if($event=="keyup"){
			$id = count($this->keyupArray);
			$this->keyupArray[$id] = new command();
			$this->obj = $this->keyupArray[$id];
		}else{
			$this->obj = $this->$event;
		}
		$this->obj->submitFormAjax($event,$obj,$script,$objToGetParameter,$parameterName,$parent,$pagename,$id,$execute,$addParameter);
	}
	public function setFunctionInnerSrc($obj,$src){
		$this->lineCommand .= "innerSrc('".$obj."','".$src."');";
		$this->obj->innerSrc();
	}
	public function setInnerSrc($event,$obj,$objToLoad,$src,$parameter=false,$value=false,$pagename=false,$addParameter=false){
		if(!$this->obj){
			$this->obj = $this->$event;
		}
		$this->obj->innerSrcEvent($event,$obj,$objToLoad,$src,$parameter,$value,$pagename,$addParameter);
	}
	public function setFunctionReSize($obj){
		$this->lineCommand .= "reSize('".$obj."');";
		$this->obj->reSize();
	}
	public function setFunctionRefresh(){
		$this->lineCommand .= "refresh();";
		$this->obj->refresh();
	}
	public function setSubmitForm($event,$obj,$objAffected,$action="",$target="",$resetActionTarget=false){
		$this->obj = $this->click;
		$this->obj->submitFormEvent($event, $obj, $objAffected, $action, $target, $resetActionTarget);
	}
	public function setFunctionSubmitForm($action=""){
		$this->lineCommand .= "submitForm('@varA','".$action."');";
		$this->obj->submitForm();
	}
	public function setFunctionCloseObj($obj=""){
		if($obj==""){
			$this->lineCommand .= "closeObj('@varA');";
		}else{
			$this->lineCommand .= "closeObj('".$obj."');";
		}
		$this->obj->closeObj();
	}
	public function setFunctionObjVisible($obj=""){
		if($obj){
			$this->lineCommand .= "setVisible('".$obj."');";
		}else{
			$this->lineCommand .= "setVisible('@varA');";
		}
		$this->obj->setVisible();
	}
	public function setFunctionObjVisibleTogger($obj=""){
		if($obj){
			$this->lineCommand .= "setVisibleTogger('".$obj."');";
		}else{
			$this->lineCommand .= "setVisibleTogger('@varA');";
		}
		$this->obj->setVisibleTogger();
	}
	public function setFunctionObjInvisible($obj=""){
		if($obj){
			$this->lineCommand .= "setInvisible('".$obj."');";
		}else{
			$this->lineCommand .= "setInvisible('@varA');";
		}
		$this->obj->setInvisible();
	}
	public function getLineCommand($varA="",$varB="",$dinamicVar=false,$repeatLineComand=false){
		if($this->lineCommand!=""){
			if($repeatLineComand===false){
	        	$lineCommand = $this->lineCommand;
			}else{
				$lineCommand = $repeatLineComand;
			}
	        if($dinamicVar===false){
				if($varA!=""){ 
					$lineCommand = str_replace("@varA",$varA,$this->lineCommand."\""); 
				}
				if($varB!=""){
					$lineCommand = str_replace("@varB",$varB,$this->lineCommand."\"");
				}
	        }else{
	        	$lineCommand = str_replace($varA,$varB,$lineCommand);
	        	#$this->lineCommand = $lineCommand;
	        }
			return $lineCommand."\"";
		}else{
			return $this->lineCommand;
		}
	}
	private function generate($obj){
		global $TYPE_SETTED;
		$arrayFunction = $obj->getArrayFunction();
		$break = 0;
		$type = 0;
		for($i=0;$i<count($arrayFunction);$i++){
			$type = $arrayFunction[$i]['type'];
			for($j=0;$j<count($TYPE_SETTED);$j++){
				if($TYPE_SETTED[$j]==$arrayFunction[$i]['type']){
					$break = 1;
				}
			}
			if($break==0){
				$this->setFunction($arrayFunction[$i]['function'],$arrayFunction[$i]['nivel']);
                if($arrayFunction[$i]['function']=="}\n" || $arrayFunction[$i]['function']=="\n"){
                    $break = 2;
                }
			}
            if($break==2){
                $break = 0;
                $TYPE_SETTED[count($TYPE_SETTED)] = $type;
            }
		}
	}
	private function setFunction($Function,$nivel){
		$idFunction = count($this->Function);
		$this->Function[$idFunction]['function'] = $Function;
		$this->Function[$idFunction]['nivel'] = $nivel;
	}
	public function e($texto,$estrutura = 0,$n = 1){
		$textoN = "";
		for($i=1;$i<=$estrutura;$i++){
        	$textoN .= "    ";                          
    	}     
    	if($n) $texto .= "\n";
		$textoN .= $texto;
		echo $textoN;
	}
    public function getTypeSettedChanged(){
        return $this->typeSetted;
    }
	public function End($typeSetted){
		global $FIRST_OBJ_JAVA;
		
		if($FIRST_OBJ_JAVA===true){
			$FIRST_OBJ_JAVA = false;
			$this->onClick->goToPage();
			$this->onClick->goToPageWithGetValue();
		}
		
        $this->typeSetted = $typeSetted;
        $this->generate($this->click);
		$this->generate($this->onClick);
		foreach ($this->clickArray as $keyB => $valueB){
			$this->generate($valueB);
		}
		foreach ($this->change as $keyB => $valueB){
			$this->generate($valueB);
		}
		$this->generate($this->focus);
		$this->generate($this->onLoad);
		$this->generate($this->onMouseOver);
		$this->generate($this->onMouseOut);
		$this->generate($this->keyup);
		foreach ($this->keyupArray as $keyB => $valueB){
			$this->generate($valueB);
		}
		$this->generate($this->keydown);
		$this->generate($this->blur);
		foreach ($this->arrayObj as $key => $value){
			$this->generate($value);
		}
		for($i=0;$i<count($this->Function);$i++){
			$this->e($this->Function[$i]['function'],$this->Function[$i]['nivel']);
		}
	}
}