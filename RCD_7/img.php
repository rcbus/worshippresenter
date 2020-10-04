<?php
# Img
class img extends generic {
	private $subLayer;
	private $father;
	private $value;
	private $Class;
	private $disabled;
	private $maxlen;
	private $objAction;
	private $src;
	private $text = array();
	public $java;
	public $css;
	
	function __construct($father,$name,$src="",$class="",$subLayer=0){
		$this->father = $father;
		$this->name = $name;
		$this->subLayer = $subLayer;
		if($this->father!==false){
		    $this->layer = $this->father->getFatherLayer();
		    $this->nivel = $this->father->getNivel();
		    $this->table = $this->father->getTable();
		    $this->formName = $this->father->getFormName();
		    $this->objAction = $this->father->getName();
        }else{
            $this->nivel = $nivel;
        }
		$this->Class = $class;
		$this->src = $src;
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		$this->newObj($this,$this->name,"button",$this->father->getName());
	}
	public function setObjAction($obj){
		$this->objAction = $obj;
	}
	public function End(){
        $this->e("<img id=\"".$this->name."\" name=\"".$this->name."\" class=\"".$this->Class."\" src=\"".$this->src."\"".$this->java->getLineCommand($this->objAction).">",$this->nivel);
		for($i=0;$i<count($this->text);$i++){
			$this->e($this->text[$i],$this->nivel + 1);
		}
		$this->endObj($this->name);
	}
	public function inSide($text,$tab=0){
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = $text;
	}
    public function inSideBold($text,$tab=0){
        $text = "<b>".$text;
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = $text."</b>";
	}
}