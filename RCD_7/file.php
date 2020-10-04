<?php
# File :: Form
class file extends generic {
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
	public $java;
	public $css;
	
	function __construct($father,$name,$class="textBox",$type="file",$value="",$disabled="",$br="",$subLayer=0){
		$this->father = $father;
		$this->name = $name;
		if($this->father!==false){
		    $this->layer = $this->father->getFatherLayer();
		    $this->nivel = $this->father->getNivel();
		    $this->table = $this->father->getTable();
		    $this->formName = $this->father->getFormName();
        }else{
            $this->nivel = $nivel;
        }
        $this->subLayer = $subLayer;
		$this->backGroundColorError = $this->father->getBackGroundColorError();
		$this->value = $value;
		$this->type = $type;
		$this->Class = $class;
		$this->disabled = $disabled;
		$this->br = $br;
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		$this->newObj($this,$this->name,"file",$this->father->getName());
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
    public function setAsUnique(){
        $this->unique = true;
    }
    public function setColumn($column){
    	$this->column = $column;
    }
    public function setDisabled(){
        $this->disabled = true;
    }
    public function setReadOnly(){
    	$this->readOnly = true;
    }
    public function setValue($value){
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
		$form = $this->getObj($this->formName);
		if($form){
			$objDataSet = $form->getDataSet();
		}else{
			$objDataSet = false;
		}
		if($objDataSet){
			$lc = $objDataSet->listColumn();
			$lc->set($this->table);
			$lc->setWhere("Field","=","'".$this->column."'");
			$lc->Exe();
			if(!$this->maxlen){
				$this->maxlen = $lc->getFieldSize();
			}
		}
		if(isset($_POST[$this->name])){
			if($_POST[$this->name]!=""){
				$this->value = $_POST[$this->name];
			}
		}
		if(isset($this->readOnly)){
			$this->readOnly = " readOnly=\"readOnly\"";
		}else{
			$this->readOnly = "";
		}
		if($this->disabled){ $this->disabled = " disabled=\"disabled\""; }
		if($this->br){ $this->br = "<br>"; }
		$this->e("<input type=\"".$this->type."\" id=\"".$this->name."\" name=\"".$this->name."\" value=\"".$this->value."\" class=\"".$this->Class."\" maxlength=\"".$this->maxlen."\"".$this->disabled.$this->readOnly.$this->java->getLineCommand()."/>".$this->br,$this->nivel);
	}
}