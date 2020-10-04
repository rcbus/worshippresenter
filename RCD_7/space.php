<?php
# Space
include_once 'generic.php';

class space extends generic {
	private $subLayer;
	private $align;
	private $Class;
	private $text = array();
    private $objAction;
    private $loadJava = true;
    private $loadCss = true;
    private $resetAutoSave = false;
    private $readOnly = false;
    private $styles = false;
    private $autoCompleteOff = true;
    private $uppercase = true;
    private $br = false;
    private $title = array();
    private $panel = false;
    private $invisiblePanel = false;
	public $css;
    public $java;
	
	function __construct($father,$name,$align="",$class="",$subLayer=0,$nivel=0){
		$this->father = $father;
		$this->name = $name;
        if($this->father!==false){
		    $this->layer = $this->father->getFatherLayer();
		    $this->nivel = $this->father->getNivel();
		    $this->table = $this->father->getTable();
		    if($this->father->type=="form"){
		    	$this->formName = $this->father->getName();
		    	$this->resetAutoSave = $this->father->getResetAutoSave();
		    	$this->readOnly = $this->father->getReadOnly();
        	}else{
        		$this->formName = $this->father->getFormName();
        	}
        	$this->uppercase = $this->father->getUpperCase();
        }else{
            $this->nivel = $nivel;
        }
		$this->subLayer = $subLayer;
		$this->align = $align;
		$this->Class = $class;
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
        $this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		$this->newObj($this,$this->name,"space",$this->father->getName());
	}
	
	public function panel($invisiblePanel=true){
		if($invisiblePanel===true){
			$this->invisiblePanel = "display:none;";
		}
		$this->panel = true;
		$this->align = left;
		$this->css->zIndex(750);
		$this->css->position("fixed");
		$this->css->padding(50);
		$this->css->margin(50);
		#$this->css->backGroundColor(COLOR_ULTRA2_LIGHT_SILVER);
		#$this->css->color(COLOR_WHITE);
		#$this->css->boxShadow(0,0,10,COLOR_DARK_SILVER);
		#$this->css->border(3,"solid",COLOR_DARK_SILVER);
		#$this->css->minHeight(400);
	}
	
	public function invisible(){
		$this->styles .= "display:none;";
	}
	
	public function visible(){
		$this->styles .= "display:block;";
	}
	
	public function title($name,$title,$class="stlTitle",$styles=false,$align=false){
		$id = count($this->title);
		$this->title[$id]['name'] = $name;
		$this->title[$id]['title'] = $title;
		$this->title[$id]['class'] = $class;
		$this->title[$id]['styles'] = $styles;
		$this->title[$id]['align'] = $align;
		$this->title[$id]['anchor'] = array();
	}
	
	public function getNumTitle(){
		return count($this->title);
	}
	
	public function anchorInTitle($nameTitle,$stretch,$target,$core=false){
		$titleSearched = false;
		foreach ($this->title as $key => $value){
			if($value['name']==$nameTitle){
				$titleSearched = $key;
				break;
			}
		}
		if($titleSearched===false){
			$this->inSide("Titulo Não Encontrado!");
		}else{
			if(strpos($this->title[$titleSearched]['title'], $stretch)===false){
				$this->inSide("Trecho não encontrado!");
			}else{
				$id = count($this->title[$titleSearched]['anchor']);
				$this->title[$titleSearched]['anchor'][$id]['stretch'] = $stretch;
				$this->title[$titleSearched]['anchor'][$id]['target'] = $target;
				$this->title[$titleSearched]['anchor'][$id]['core'] = $core;
			}
		}
	}
	
	public function anchor($name,$position=0){
		$this->inSide("<a name=\"".$name."\" style=\"position:absolute;top:".$position."px;\"></a>");
	}
	
	public function brAfterObj($num = 1){
		$this->br = $num;
	}
	
	public function getAutocompleteOff(){
		return $this->autoCompleteOff;
	}
	
	public function getUpperCase(){
		return $this->uppercase;
	}
	
	public function style($styles){
		$this->styles = $styles;
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
	
	public function setNoLoadCss(){
		$this->loadCss = false;
	}
	
	public function setNoLoadJava(){
		$this->loadJava = false;
	}
	
    public function setObjAction($obj){
		$this->objAction = $obj;
	}
	public function End(){
		global $c;
		global $PATH;
		
		if($this->panel===true){
			$this->e("<div id=\"base".$this->name."\" name=\"base".$this->name."\" style=\"z-index:800;position:absolute;top:0px;left:0px;width:100%;height:100%;".$this->invisiblePanel."\" align=\"center\">",$this->nivel);
			$this->e("<div id=\"baseBase".$this->name."\" name=\"baseBase".$this->name."\" style=\"z-index:700;position:fixed;top:0px;left:0px;width:100%;height:100%;opacity:0.9;-moz-opacity:0.9;filter:alpha(opacity=90);background-color:".COLOR_DARK_BLUE_4.";\" align=\"center\">",$this->nivel);
			$this->e("</div>",$this->nivel);
		}
		$this->e("<div id=\"".$this->name."\" name=\"".$this->name."\" class=\"".$this->Class."\" style=\"".$this->styles."\" align=\"".$this->align."\"".$this->java->getLineCommand($this->objAction).">",$this->nivel);
		if(count($this->title)>0){
			foreach ($this->title as $key => $value){
				$this->e("<div id=\"".$this->name."_title".$key."\" name=\"".$this->name."_title".$key."\" class=\"".$this->title[$key]['class']."\" style=\"".$this->title[$key]['styles']."\" align=\"".$this->title[$key]['align']."\">",$this->nivel+1);
				$title = $this->title[$key]['title'];
				if(count($this->title[$key]['anchor'])>0){
					foreach ($this->title[$key]['anchor'] as $keyB => $valueB){
						if($valueB['core']===false){						
							$anchor = "";
							
							$panel = explode(",", $valueB['target']);
							$panelB = array();
							foreach ($panel as $keyC => $valueC){
								$panelB[$valueC] = true;
							}
							
							foreach ($c as $keyD => $valueD){
								if(isset($panelB["c".$keyD])){
									$anchor .= "document.getElementById('c".$keyD."').style.display = 'block';";
								}else{
									$anchor .= "document.getElementById('c".$keyD."').style.display = 'none';";
								}
							}
							$title = str_replace($valueB['stretch'], "<span class=\"stlTitleAnchor\" onClick=\"".$anchor."\"><u>".$valueB['stretch']."</u></span>",$title);
						}else{		
							/*$anchor = "";
							$anchor .= "document.getElementById('objCore".$valueB['core']."0').src = '".$PATH."../RCD_7/iFormScriptInsertUpdate.php?PANEL=".$valueB['target']."'";*/
							$title = str_replace($valueB['stretch'], "<span id=\"link".$this->name.$key."\" name=\"link".$this->name.$key."\" class=\"stlTitleAnchor\" onClick=\"goToPageEventlink".$this->name.$key."();\"><u>".$valueB['stretch']."</u></span>",$title);
							#$this->java->setGoToPage("click", "link".$this->name.$key, $PATH."../RCD_7/iFormScriptInsertUpdate.php","PANEL",$valueB['target'],"","","",false,"objCore".$valueB['core']."0");
							$this->java->setGoToPage("click", "link".$this->name.$key, $PATH."../RCD_7/iFormScriptInsertUpdate.php","PANEL",$valueB['target'],"","","",false,"objCore".$valueB['core']."0");
						}
					}
				}
				$this->e($title,$this->nivel+2);
				$this->e("</div>",$this->nivel+1);
			}
		}
		for($i=0;$i<count($this->text);$i++){
			$this->e($this->text[$i],$this->nivel + 1);
		}
		$this->endObj($this->name);
		$this->e("</div>",$this->nivel);
		if($this->panel===true){
			$this->e("</div>",$this->nivel);
		}
		
		if($this->br!==false){
			for ($i = 1;$i<=$this->br;$i++){
				$this->e("<br>",$this->nivel);
			}
		}
	}
	public function inSide($text,$tab=0){
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = $text;
	}
	public function inSideH($text,$number=1,$tab=0){
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = "<h3>".$text."</h3>";
	}
	public function inSideHB($text,$number=1,$tab=0){
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = "<h".$number.">".$text."</h".$number.">";
	}
	public function inSideP($text,$class="",$tab=0){
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = "<p class='".$class."'>".$text."</p>";
	}
    public function inSideBold($text,$tab=0){
        $text = "<b>".$text;
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = $text."</b>";
	}
    public function inSideSpan($text,$class="",$tab=0){
        if($class){
			$objHead = $this->getObj("head");
			#$objHead->linkCss("class/".$class.".css");
		}
        $text = "<span class=\"".$class."\">".$text;
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = $text."</span>";
	}
    public function inSideHiperLink($text,$href="",$target="",$tab=0){
        $text = "<a href=\"".$href."\" target=\"".$target."\" onClick=\"openBaseCarregando();\">".$text;
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		return $text."</a>";
	}
}