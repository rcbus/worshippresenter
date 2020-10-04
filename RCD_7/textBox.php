<?php
# Text Box :: Form
class textBox extends generic {
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
    private $setValueLock = false;
    private $loadJava = true;
    private $loadCss = true;
    private $width = false;
    private $textInside = "";
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
	
	function __construct($father,$name,$class="textBox",$type="text",$value="",$disabled="",$br="",$subLayer=0){
		$this->father = $father;
		$this->name = $name;
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
        $this->subLayer = $subLayer;
		$this->backGroundColorError = $this->father->getBackGroundColorError();
		$this->value = $value;
		$this->type = $type;
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
		$this->newObj($this,$this->name,"textBox",$this->father->getName());
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
	public function inSide($text){
		$this->textInside .= $text;
	}
	public function setLoadCss(){
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
	}
	
	public function setLoadJava(){
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
	}
	
	public function width($value){
		$this->width = $value;
	}
	
	public function setAutoSave($preValue=false,$event="keyup"){
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
		$this->java->setReloadScript($event, $this->name, $this->name."XYZ", @$PATH."sistema/plugin/autoSave.php",$this->name,"VALUE","","UNIVERSAL&OBJ_NAME=".$this->name."@UNIVERSAL&PN=".$PAGENAME."@UNIVERSAL");
		$this->setValue($page->session->getSession("OBJ_".$this->name,$PAGENAME));
	}
	public function getTypeColumn(){
		return $this->typeColumn;
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
    public function setColumn($column,$onlyInfo=false){
		$this->column = $column;
		if($onlyInfo===false){
			$form = $this->getObj($this->formName);
			if($form){
				$objDataSet = $form->getDataSet();
			}else{
				$objDataSet = false;
			}
			/*if($objDataSet){
				if($objDataSet->versao=="old"){
					$lc = $objDataSet->listColumn();
					$lc->set($this->table);
					$lc->setWhere("Field","=","'".$this->column."'");
					$lc->Exe();
					if(!$this->maxlen){
						$this->maxlen = $lc->getFieldSize();
					}
					if(!$this->typeColumn){
						$this->typeColumn = $this->stringToUpper($lc->getFieldType());
						#$this->setValue($lc->getSql());
					}
				}else{
					$lc = new iSelect($objDataSet,$this->table);
					$lc->listColumn();
					$lc->where("Field","=",$this->column,true);
					$lc->exe();
					if(!$this->maxlen){
						$this->maxlen = $lc->getFieldSize();
					}
					if(!$this->typeColumn){
						$this->typeColumn = $this->stringToUpper($lc->getFieldType());
					}
				}
			}*/
		}
    }
    public function setDisabled(){
        $this->disabled = true;
    }
    public function setReadOnly(){
    	$this->readOnly = true;
    }
    public function setValue($value){
    	if($this->setValueLock===false){
        	$this->value = $value;
    	}
    }
    public function setFunctionSetValueLock(){
    	$this->setValueLock = true;
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
	public function setBr($value){
		$this->br = $value;
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
		#$this->readOnly = "";
		if($this->disabled){ $this->disabled = " disabled=\"disabled\""; }
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
		$styles = "";
		if($this->width){
			if(is_numeric($this->width)){
				$styles .= "width:".$this->width."px;";
			}else{
				$styles .= "width:".$this->width;
			}
		}
		if(strlen($this->textInside)>0){
			$this->e("<div id=\"".$this->name."_INSIDE\" name=\"".$this->name."_INSIDE\" style=\"float:left;\">",$this->nivel);
		}
		if($this->loadJava===true){
			$this->e($this->textInside."<input type=\"".$this->type."\" id=\"".$this->name."\" name=\"".$this->name."\" value=\"".$this->value."\" class=\"".$this->Class."\" maxlength=\"".$this->maxlen."\"".$this->disabled.$this->readOnly.$this->java->getLineCommand()." style=\"".$styles."\"/>".$this->br,$this->nivel);
		}else{
			$this->e($this->textInside."<input type=\"".$this->type."\" id=\"".$this->name."\" name=\"".$this->name."\" value=\"".$this->value."\" class=\"".$this->Class."\" maxlength=\"".$this->maxlen."\"".$this->disabled.$this->readOnly." style=\"".$styles."\"/>".$this->br,$this->nivel);
		}
		if(strlen($this->textInside)>0){
			$this->e("</div>",$this->nivel);
		}
	}
}