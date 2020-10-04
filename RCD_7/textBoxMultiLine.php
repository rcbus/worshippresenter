<?php
# Text Box Multi Line :: Form
class textBoxMultiLine extends generic {
	private $dataSet;
	private $subLayer;
	private $father;
	private $column;
	private $value;
	private $Class;
	private $disabled;
	private $maxlen;
	private $br;
	private $required = true;
    private $unique = false;
    private $isNotEqual = false;
    private $loadJava = true;
    private $loadCss = true;
    private $width = false;
    private $height = false;
    private $money = false;
    private $number = false;
    private $resetAutoSave = false;
    private $readOnly = false;
    private $uppercase = true;
    private $Date = false;
    public $DateMode = "abb4";
    public $DateBy = "timestamp";
	public $java;
	public $css;
	
	function __construct($father,$name,$class="textBox",$value="",$disabled="",$br="",$subLayer=0){
		$this->father = $father;
		$this->name = $name;
		$this->subLayer = $subLayer;
		if($this->father!==false){
		    $this->layer = $this->father->getFatherLayer();
		    $this->nivel = $this->father->getNivel();
		    $this->table = $this->father->getTable();
		    $this->formName = $this->father->getFormName();
		    $this->loadJava = $this->father->getLoadJava();
		    $this->loadCss = $this->father->getLoadCss();
		    $this->resetAutoSave = $this->father->getResetAutoSave();
		    $this->readOnly = $this->father->getReadOnly();
        }else{
            $this->nivel = $nivel;
        }
        $this->backGroundColorError = $this->father->getBackGroundColorError();
		$this->value = $value;
		$this->Class = $class;
		$this->disabled = $disabled;
		$this->br = $br;
		if($this->father->getLoadCss()===true){
			$this->css = new style($this->name);
			$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		}
		if($this->father->getLoadJava()===true){
			$this->java = new java();
			$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		}
		$this->newObj($this,$this->name,"textBoxMultiLine",$this->father->getName());
	}
	public function unSetUppercase(){
		$this->uppercase = false;
	}
	public function getUppercase(){
		return $this->uppercase;
	}
	public function setAsNumber($decimal=2){
		$this->number = $decimal;
	}
	public function getNumber(){
		return $this->number;
	}
	public function setAsMoney(){
		$this->money = true;
	}
	public function getMoney(){
		return $this->money;
	}
	public function setAsDate($by="timestamp",$mode="abb4"){
		$this->Date = true;
		$this->DateMode = $mode;
		$this->DateBy = $by;
	}
	public function getDate(){
		return $this->Date;
	}
	public function width($value){
		$this->width = $value;
	}
	
	public function height($value){
		$this->height = $value;
	}
	
	public function getTypeColumn(){
		return $this->typeColumn;
	}
	public function setAutoSave($preValue=false){
		global $PATH;
		global $PAGENAME;
		global $page;
	
		$this->autoSave = true;
		
		if($this->resetAutoSave===true){
			$page->session->unSetSession("OBJ_".$this->name,$PAGENAME);
		}
		
		if($preValue!==false && !$page->session->getSession("OBJ_".$this->name,$PAGENAME)){
			$page->session->setSession("OBJ_".$this->name,$preValue,$PAGENAME);
		}
		$this->java->setReloadScript("keyup", $this->name, $this->name."XYZ", @$PATH."sistema/plugin/autoSave.php",$this->name,"VALUE","","UNIVERSAL&OBJ_NAME=".$this->name."@UNIVERSAL&PN=".$PAGENAME."@UNIVERSAL");
		$this->setValue($page->session->getSession("OBJ_".$this->name,$PAGENAME));
	}
	public function setReadOnly(){
		$this->readOnly = true;
	}
	public function getIsNotEqual(){
		return $this->isNotEqual;
	}
	public function setIsNotEqual($value){
		$this->isNotEqual = $value;
	}
    public function getUnique(){
        return $this->unique;
    }
	public function setAsUnique($whereForCheckUnique="status",$operatorForCheckUnique="=",$valueForCheckUnique="1"){
    	$this->whereForCheckUnique = $whereForCheckUnique;
    	$this->operatorForCheckUnique = $operatorForCheckUnique;
    	$this->valueForCheckUnique = $valueForCheckUnique;
        $this->unique = true;
    }
    public function setColumn($column){
    	$this->column = $column;
    	$form = $this->getObj($this->formName);
    	if($form){
    		$objDataSet = $form->getDataSet();
    	}else{
    		$objDataSet = false;
    	}
    	/*if($objDataSet){
    		$lc = $objDataSet->listColumn();
    		$lc->set($this->table);
    		$lc->setWhere("Field","=","'".$this->column."'");
    		$lc->Exe();
    		if(!$this->maxlen){
    			$this->maxlen = $lc->getFieldSize();
    		}
    		if(!$this->typeColumn){
    			$this->typeColumn = $this->stringToUpper($lc->getFieldType());
    			#$this->setValue($this->typeColumn);
    		}
    	}*/
    }
    public function setDisabled(){
        $this->disabled = true;
    }
    public function setValue($value){
    	$value = str_replace("\\n\\r", "&#10;", $value);
    	$value = str_replace("\\r\\n", "&#10;", $value);
    	#$value = "teste";
        $this->value = $value;
    }
	public function getCheck(){
		return $this->check;
	}
	public function getRequired(){
		return $this->required;
	}
	public function setAsNotRequired(){
		$this->required = false;
	}
	public function getColumn(){
		return $this->column;
	}
	public function setMaxLength($length){
		$this->maxlen = $length;
	}
	public function End(){
		if(isset($_POST[$this->name])){
			if($_POST[$this->name]!=""){
				$this->value = $_POST[$this->name];
			}
		}
		if(isset($this->readOnly)){
			if($this->readOnly!==false){
				$this->readOnly = " readOnly=\"readOnly\"";
			}else{
				$this->readOnly = "";
			}
		}else{
			$this->readOnly = "";
		}
		if($this->disabled){ $this->disabled = " disabled=\"disabled\""; }
		if($this->br){ $this->br = "<br>"; }
		$styles = "";
		if($this->width){
			if(is_numeric($this->width)){
				$styles .= "width:".$this->width."px;";
			}else{
				$styles .= "width:".$this->width;
			}
		}
		if($this->height){
			if(is_numeric($this->height)){
				$styles .= "height:".$this->height."px;";
			}else{
				$styles .= "height:".$this->height;
			}
		}
		$this->e("<textarea id=\"".$this->name."\" name=\"".$this->name."\" maxlength=\"".$this->maxlen."\" class=\"".$this->Class."\"".$this->disabled.$this->readOnly." style=\"".$styles."\">".$this->value."</textarea>".$this->br,$this->nivel);
	}
}