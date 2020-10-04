<?php
# Table
class table extends generic {
	private $lines;
	private $cells;
	private $spaceBetweenCells;
	private $spaceBetweenLines;
	private $subLayer;
	private $father;
	private $objAction;
	private $border;
	private $Class;
	private $cellpadding;
	private $cellspacing;
	private $linesNoObj = array();
	private $cellsNoObj = array();
	private $numCellsNoObj = array();
	private $currentLine = false;
	private $loadJava = true;
	private $loadCss = true;
	private $resetAutoSave = false;
	private $outSideTableText = false;
	private $readOnly = false;
	private $uppercase = true;
	private $autoCompleteOff = true;
	public $line;
	public $obj;
	public $css;
	public $java;
	
	function __construct($father,$name,$class="",$border=0,$cellpadding=0,$cellspacing=0,$subLayer=0,$nivel=0){
		$this->border = $border;
		$this->father = $father;
		$this->subLayer = $subLayer;
		$this->type = "table";
		if($this->father!==false){
		    $this->layer = $this->father->getFatherLayer();
		    $this->nivel = $this->father->getNivel();
		    $this->table = $this->father->getTable();
		    $this->formName = $this->father->getFormName();
		    $this->loadJava = $this->father->getLoadJava();
		    $this->loadCss = $this->father->getLoadCss();
		    $this->resetAutoSave = $this->father->getResetAutoSave();
		    $this->readOnly = $this->father->getReadOnly();
		    $this->uppercase = $this->father->getUpperCase();
		    $this->autoCompleteOff = $this->father->getAutocompleteOff();
        }else{
            $this->nivel = $nivel;
        }
        $this->Class = $class;
        $this->cellpadding = $cellpadding;
        $this->cellspacing = $cellspacing;
		$this->name = $name;
		if($this->father->getLoadCss()===true){
			$this->css = new style($this->name);
			$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		}
		if($this->father->getLoadJava()===true){
			$this->java = new java();
			$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		}
		$this->newObj($this,$this->name,"table",$this->father->getName());
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
	public function setNoLoadCss(){
		$this->loadCss = false;
	}
	public function setNoLoadJava(){
		$this->loadJava = false;
	}
	public function getLoadCss(){
		return $this->loadCss;
	}
	
	public function getLoadJava(){
		return $this->loadJava;
	}
	
	public function newLine($class="",$border=0){
		$this->lines++;
		$this->line = new tr($this, $this->name."_LYT_LINE_".$this->lines,$class);
		if($border){
			$this->line->css->border();
		}
	}
	public function lineNoObj($class="",$border=0,$java=false){
		$id = count($this->linesNoObj);
		$this->currentLine = $id;
		$this->linesNoObj[$id]['ID'] = $id;
		$this->linesNoObj[$id]['NAME'] = $this->name."_LYT_LINE_NO_OBJ_".$id;
		$this->linesNoObj[$id]['CLASS'] = $class;
		$this->linesNoObj[$id]['BORDER'] = $border;
		$this->linesNoObj[$id]['JAVA'] = $border;
	}	
	public function newCell($class="",$width="",$align="left",$valign="",$colspan=0,$rowsPan=0,$border=0){
		$this->cells++;
		$father = $this->getObj($this->name."_LYT_LINE_".$this->lines);
		$this->obj = new td($father, $this->name."_LYT_LINE_".$this->lines."_CELL_".$this->cells,$class,$width,$align,$valign,$colspan,$rowsPan);
		if($border){
			$this->obj->css->border();
		}
	}
	public function cellNoObj($class=false,$width=false,$align="left",$valign=false,$colspan=false,$rowsPan=false,$border=false,$numLine=false,$java=false){
		if($numLine===false){
			$numLine = $this->currentLine;
		}
		if($numLine===false || $numLine==""){
			$numLine = 0;
		}
		if(isset($this->numCellsNoObj[$numLine])){
			$this->numCellsNoObj[$numLine]++;
		}else{
			$this->numCellsNoObj[$numLine] = 0;
		}
		$id = $this->numCellsNoObj[$numLine];
		$this->cellsNoObj[$numLine][$id]['ID'] = $id;
		$this->cellsNoObj[$numLine][$id]['NAME'] = $this->name."_LYT_LINE_NO_OBJ_".$numLine."_CELL_".$id;
		$this->cellsNoObj[$numLine][$id]['CLASS'] = $class;
		$this->cellsNoObj[$numLine][$id]['WIDTH'] = $width;
		$this->cellsNoObj[$numLine][$id]['ALIGN'] = $align;
		$this->cellsNoObj[$numLine][$id]['VALIGN'] = $valign;
		$this->cellsNoObj[$numLine][$id]['COLSPAN'] = " colspan=".$colspan;
		$this->cellsNoObj[$numLine][$id]['ROWSPAN'] = " rowspan=".$rowsPan;
		$this->cellsNoObj[$numLine][$id]['BORDER'] = $border;
		$this->cellsNoObj[$numLine][$id]['JAVA'] = $java;
		$this->cellsNoObj[$numLine][$id]['INSIDE'] = "";
	}
	public function inSideCell($text){
		$this->obj->inSide .= $text;
	}
	public function inSideCellNoObj($text){
		$id = $this->numCellsNoObj[$this->currentLine];
		$this->cellsNoObj[$this->currentLine][$id]['INSIDE'] .= $text;
	}
	public function inSideBoldCell($text){
		$this->obj->inSide .= "<b>".$text."</b>";
	}
	public function inSideBoldCellNoObj($text){
		$id = $this->numCellsNoObj[$this->currentLine];
		$this->cellsNoObj[$this->currentLine][$id]['INSIDE'] .= "<b>".$text."</b>";
	}
	public function inSideHiperLink($text,$href="",$target="",$serie=1,$tab=0){
		$text = "<a href=\"".$href."\" target=\"".$target."\">".$text;
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		if($serie){
			$this->obj->inSide .= $text."</a>";
		}else{
			return $text."</a>";
		}
	}
	public function setObjAction($obj){
		$this->objAction = $obj;
	}
	public function setTable($table){
		$this->table = $table;
	}
	public function getCellObj(){
		return $this->obj;
	}
    private function setObj($name,$type){
		$idObj = count($this->obj);
		$this->obj[$idObj]['name'] = $name;
		$this->obj[$idObj]['type'] = $type;
	}
	public function End(){
		if($this->loadJava===true){
			$this->e("<table id=\"".$this->name."\" name=\"".$this->name."\" border=\"".$this->border."\" cellpadding=\"".$this->cellpadding."\" cellspacing=\"".$this->cellspacing."\" class=\"".$this->Class."\"".$this->java->getLineCommand($this->objAction).">",$this->nivel);
		}else{
			$this->e("<table id=\"".$this->name."\" name=\"".$this->name."\" border=\"".$this->border."\" cellpadding=\"".$this->cellpadding."\" cellspacing=\"".$this->cellspacing."\" class=\"".$this->Class."\">",$this->nivel);
		}
		if(count($this->linesNoObj)>0){
			foreach ($this->linesNoObj as $key => $value){
				$this->e("<tr id=\"".$this->linesNoObj[$key]['NAME']."\" name=\"".$this->linesNoObj[$key]['NAME']."\" class=\"".$this->linesNoObj[$key]['CLASS']."\"".$this->linesNoObj[$key]['JAVA'].">",$this->nivel);
					foreach ($this->cellsNoObj[$key] as $keyB => $valueB){
						$this->e("<td id=\"".$this->cellsNoObj[$key][$keyB]['NAME']."\" name=\"".$this->cellsNoObj[$key][$keyB]['NAME']."\"".$this->cellsNoObj[$key][$keyB]['COLSPAN'].$this->cellsNoObj[$key][$keyB]['ROWSPAN']."\" width=\"".$this->cellsNoObj[$key][$keyB]['WIDTH']."\" align=\"".$this->cellsNoObj[$key][$keyB]['ALIGN']."\" valign=\"".$this->cellsNoObj[$key][$keyB]['VALIGN']."\" class=\"".$this->cellsNoObj[$key][$keyB]['CLASS']."\"".$this->cellsNoObj[$key][$keyB]['JAVA'].">",$this->nivel);
							$this->e($this->cellsNoObj[$key][$keyB]['INSIDE']);
							#$this->endObj($this->name);
						$this->e("</td>",$this->nivel);
					}
				$this->e("</tr>",$this->nivel);
			}
		}else{
			$this->endObj($this->name);
		}
		$this->e("</table>",$this->nivel);
		$this->e($this->outSideTableText,$this->nivel);
	}
	public function outSideTable($text){
		$this->outSideTableText = $text;
	}
}

# Tr
class tr extends generic {
	private $subLayer;
	private $father;
	private $objAction;
	private $Class;
	private $loadJava = true;
	private $loadCss = true;
	private $resetAutoSave = false;
	private $readOnly = false;
	private $uppercase = true;
	private $autoCompleteOff = true;
	public $css;
	public $java;

	function __construct($father,$name,$class="",$subLayer=0,$nivel=0){
		$this->father = $father;
		$this->subLayer = $subLayer;
		$this->type = "tr";
		if($this->father!==false){
			$this->layer = $this->father->getFatherLayer();
			$this->nivel = $this->father->getNivel();
			$this->table = $this->father->getTable();
			$this->formName = $this->father->getFormName();
			$this->loadJava = $this->father->getLoadJava();
			$this->loadCss = $this->father->getLoadCss();
			$this->resetAutoSave = $this->father->getResetAutoSave();
			$this->readOnly = $this->father->getReadOnly();
			$this->uppercase = $this->father->getUpperCase();
			$this->autoCompleteOff = $this->father->getAutocompleteOff();
		}else{
			$this->nivel = $nivel;
		}
		$this->Class = $class;
		$this->name = $name;
		if($this->father->getLoadCss()===true){
			$this->css = new style($this->name);
			$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		}
		if($this->father->getLoadJava()===true){
			$this->java = new java();
			$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		}
		$this->newObj($this,$this->name,"tr",$this->father->getName());
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
	public function setLoadCss(){
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
	}
	public function setLoadJava(){
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
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
	
	public function End(){
		if($this->loadJava===true){
			$this->e("<tr id=\"".$this->name."\" name=\"".$this->name."\" class=\"".$this->Class."\"".$this->java->getLineCommand($this->objAction).">",$this->nivel);
		}else{
			$this->e("<tr id=\"".$this->name."\" name=\"".$this->name."\" class=\"".$this->Class."\">",$this->nivel);
		}
		$this->endObj($this->name);
		$this->e("</tr>",$this->nivel);
	}
}

# Td
class td extends generic {
	private $subLayer;
	private $father;
	private $objAction;
	private $width;
	private $align;
	private $valign;
	private $Class;
	private $rowsPan;
	private $colsPan;
	private $styles;
	private $loadJava = true;
	private $loadCss = true;
	private $resetAutoSave = false;
	private $readOnly = false;
	private $uppercase = true;
	private $autoCompleteOff = true;
	public $inSide;
	public $css;
	public $java;

	function __construct($father,$name,$class,$width="",$align="left",$valign="",$colsPan=0,$rowsPan=0,$subLayer=0,$nivel=0){
		$this->father = $father;
		$this->subLayer = $subLayer;
		$this->type = "tr";
		$this->width = $width;
		$this->align = $align;
		$this->valign = $valign;
		if($this->father!==false){
			$this->layer = $this->father->getFatherLayer();
			$this->nivel = $this->father->getNivel();
			$this->table = $this->father->getTable();
			$this->formName = $this->father->getFormName();
			$this->loadJava = $this->father->getLoadJava();
			$this->loadCss = $this->father->getLoadCss();
			$this->resetAutoSave = $this->father->getResetAutoSave();
			$this->readOnly = $this->father->getReadOnly();
			$this->uppercase = $this->father->getUpperCase();
			$this->autoCompleteOff = $this->father->getAutocompleteOff();
		}else{
			$this->nivel = $nivel;
		}
		$this->Class = $class;
		$this->rowsPan = $rowsPan;
		$this->colsPan = $colsPan;
		$this->name = $name;
		if($this->father->getLoadCss()===true){
			$this->css = new style($this->name);
			$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		}
		if($this->father->getLoadJava()===true){
			$this->java = new java();
			$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		}
		$this->newObj($this,$this->name,"td",$this->father->getName());
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
	public function setLoadCss(){
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
	}
	public function setLoadJava(){
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
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
	
	public function setStyles($styles){
		$this->styles = $styles;
	}
	public function End(){
		if($this->colsPan){
			$this->colsPan = " colspan=\"".$this->colsPan."\"";
		}else{
			$this->colsPan = "";
		}
		if($this->rowsPan){
			$this->rowsPan = " rowspan=\"".$this->rowsPan."\"";
		}else{
			$this->rowsPan = "";
		}
		if($this->loadJava===true){
			$this->e("<td id=\"".$this->name."\" name=\"".$this->name."\"".$this->colsPan.$this->rowsPan." width=\"".$this->width."\" align=\"".$this->align."\" valign=\"".$this->valign."\" class=\"".$this->Class."\"".$this->java->getLineCommand($this->objAction)." bgcolor=\"".$this->styles."\">",$this->nivel);
		}else{
			$this->e("<td id=\"".$this->name."\" name=\"".$this->name."\"".$this->colsPan.$this->rowsPan." width=\"".$this->width."\" align=\"".$this->align."\" valign=\"".$this->valign."\" class=\"".$this->Class."\" bgcolor=\"".$this->styles."\">",$this->nivel);
		}
		$this->e($this->inSide);
		$this->endObj($this->name);
		$this->e("</td>",$this->nivel);
	}
}