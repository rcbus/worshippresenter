<?php
# ComboBox :: Form
class comboBox extends generic {
	private $subLayer;
	private $father;
	private $Class;
	private $multiple;
	private $options = array();
	private $selectedIndex;
	private $required = true;
    private $disabled = false;
    private $unique = false;
    private $column;
    private $isNotEqual = false;
    private $autoSave = false;
    private $loadJava = true;
    private $loadCss = true;
    private $width = false;
    private $money = false;
    private $number = false;
    private $resetAutoSave = false;
    private $readOnly = false;
    private $uppercase = true;
    private $Date = false;
    public $DateMode = "abb4";
    public $DateBy = "timestamp";
    public $temp = "";
	public $css;
	public $java;
	
	function __construct($father,$name,$class="textBox",$multiple="",$disabled="",$subLayer=0){
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
		$this->Class = $class;
		if($this->Class){
			$objHead = $this->getObj("head");
			#$objHead->linkCss("class/".$this->Class.".css");
		}
		$this->multiple = $multiple;
		$this->disabled = $disabled;
		if($this->father->getLoadCss()===true){
			$this->css = new style($this->name);
			$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		}
		if($this->father->getLoadJava()===true){
			$this->java = new java();
			$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		}
		$this->newObj($this,$this->name,"comboBox",$this->father->getName());
	}
	public function setReadOnly(){
		$this->readOnly = true;
	}
	public function unSetUppercase(){
		$this->uppercase = false;
	}
	public function getUppercase(){
		return $this->uppercase;
	}
	public function setAsNotRequired(){
		$this->required = false;
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
	public function setLoadJava(){
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
	}
	
	public function width($value){
		$this->width = $value;
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
		
		if($preValue!==false && strlen($page->session->getSession("OBJ_".$this->name,$PAGENAME))==0){
			$page->session->setSession("OBJ_".$this->name,$preValue,$PAGENAME);
		}
		$this->java->setReloadScript("change", $this->name, $this->name."XYZ", @$PATH."sistema/plugin/autoSave.php",$this->name,"VALUE","","UNIVERSAL&OBJ_NAME=".$this->name."@UNIVERSAL&PN=".$PAGENAME."@UNIVERSAL");
		$this->setSelectedIndex($page->session->getSession("OBJ_".$this->name,$PAGENAME));
	}
	public function setFill($columnId,$columnDesc,$dataSet,$table,$where,$operator,$value,$order=false,$orderType="ASC",$limit=false,$and=false,$or=false){
		global $PAGENAME;
		global $page;
		
		if($dataSet->versao=="i"){
			$sel = new iSelect($dataSet,$table);
			if($and!==false){
				$sel->setAnd("", $and);
			}
			if($or!==false){
				$sel->setOr("", "", $or);
			}
			$sel->where($where,$operator,$value,true);
			if($order!==false){
				$sel->order($order,$orderType);
			}
			if($limit!==false){
				$sel->limit($limit);
			}
			$res = $sel->Exe();
			
			if($res===false){
				return $res;
			}else{
				$firstRow = false;
				while($row = $sel->read()){
					$this->setOption($row[$columnId],$row[$columnDesc]);
					if($firstRow===false){
						$firstRow = true;
						if($this->autoSave===true){
							if(!$page->session->getSession("OBJ_".$this->name,$PAGENAME)){
								$page->session->setSession("OBJ_".$this->name,$row[$columnId],$PAGENAME);
								$this->setSelectedIndex($page->session->getSession("OBJ_".$this->name,$PAGENAME));
							}
						}
					}
				}
				return $sel->getSql();
			}
		}else{
			$sel = $dataSet->select($table);
			if($and!==false){
				$sel->setAnd("", $and);
			}
			if($or!==false){
				$sel->setOr("", "", $or);
			}
			$sel->setWhere($where,$operator,$value,true);
			if($order!==false){
				$sel->setOrder($order,$orderType);
			}
			if($limit!==false){
				$sel->setLimit($limit);
			}
			$res = $sel->Exe();
				
			if($res===false){
				return $res;
			}else{
				$firstRow = false;
				while($row = $sel->read()){
					$this->setOption($row[$columnId],$row[$columnDesc]);
					if($firstRow===false){
						$firstRow = true;
						if($this->autoSave===true){
							if(!$page->session->getSession("OBJ_".$this->name,$PAGENAME)){
								$page->session->setSession("OBJ_".$this->name,$row[$columnId],$PAGENAME);
								$this->setSelectedIndex($page->session->getSession("OBJ_".$this->name,$PAGENAME));
							}
						}
					}
				}
				return $sel->getSql();
			}
		}
	}
	public function getIsNotEqual(){
		return $this->isNotEqual;
	}
	public function setIsNotEqual($value){
		$this->isNotEqual = $value;
	}
	public function setOption($value,$desc=""){
		if($desc){
			$this->options[$value] = $desc;
		}else{
			$this->options[$value] = $value;
		}
	}
	public function setColumn($column){
		$this->column = $column;
	}
    public function getUnique(){
        return $this->unique;
    }
    public function setAsUnique(){
        $this->unique = true;
    }
    public function setDisabled(){
        $this->disabled = true;
    }
	public function getRequired(){
		return $this->required;
	}
	public function getColumn(){
		return $this->column;
	}
	public function setSelectedIndex($index){
		$this->selectedIndex = $index;
	}
	public function setAsState(){
		unset($this->options);
		$this->options = $this->state;
	}
	public function End(){
		if($this->multiple){ $this->multiple = " multiple=\"multiple\""; }else{ $multiple = ""; }
		if(@$_POST[$this->name]){
			$this->selectedIndex = $_POST[$this->name];
		}	
		if(isset($this->readOnly)){
			if($this->readOnly!==false){
				$this->readOnly = " disabled";
			}else{
				$this->readOnly = "";
			}
		}else{
			$this->readOnly = "";
		}
        if($this->disabled===true){
            $this->disabled = " disabled";
        }
        $styles = "";
        if($this->width){
        	if(is_numeric($this->width)){
        		$styles .= "width:".$this->width."px;";
        	}else{
        		$styles .= "width:".$this->width;
        	}
        }
		$this->e("<select id=\"".$this->name."\" name=\"".$this->name."\" class=\"".$this->Class."\"".$this->multiple.$this->disabled.$this->readOnly." style=\"".$styles."word-wrap:initial;\" ".$this->temp.">",$this->nivel);
		foreach($this->options as $chave => $valor){
			$selected = "";
			if($chave==$this->selectedIndex){ $selected = " selected"; }
			$this->e("<option value=\"".$chave."\"".$selected.">".$valor."</option>",$this->nivel+1);
		}
		$this->e("</select>",$this->nivel);	
	}
}