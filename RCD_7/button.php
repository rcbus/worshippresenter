<?php
# Button :: Form

class button extends generic {
	private $subLayer;
	private $father;
	private $value;
	private $Class;
	private $disabled;
	private $maxlen;
	private $objAction;
	private $active = false;
	private $br = false;
	public $java;
	public $css;
	
	function __construct($father,$name,$value,$class="bigButton",$disabled="",$subLayer=0){
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
		$this->value = $value;
		$this->Class = $class;
		$this->disabled = $disabled;
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		$this->newObj($this,$this->name,"button",$this->father->getName());
	}
	public function setBr($value){
		$this->br = $value;
	}
	public function setActive(){
		$this->active = true;
	}
	public function setValue($value){
		$this->value = $value;
	}
    public function setDisabled(){
        $this->disabled = true;
    }
	public function setObjAction($obj){
		$this->objAction = $obj;
	}
	public function End(){
		if($this->active===true){
			#global btActive;
			$this->Class = btActive;
		}
		if($this->br){
			if(is_numeric($this->br)){
				$counterI = $this->br;
				$this->br = "";
				for($i=0;$i<$counterI;$i++){
					$this->br .= "<br>";
				}
			}else{
				$this->br = "<br>";
			}
		}else{
			$this->br = "";
		}
        if($this->disabled){
		    $this->e("<div id=\"".$this->name."\" name=\"".$this->name."\" class=\"".$this->Class."\" align=\"center\">".$this->br,$this->nivel);
        }else{
            $this->e("<div id=\"".$this->name."\" name=\"".$this->name."\" class=\"".$this->Class."\" align=\"center\"".$this->java->getLineCommand($this->objAction).">".$this->br,$this->nivel);
        }
		$this->e($this->value,$this->nivel + 1);
		#$this->endObj($this->name);
		$this->e("</div>",$this->nivel);
	}
}
?>