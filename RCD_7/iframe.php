<?php
# Iframe
class iframe extends generic {
	public $src;
	public $java;
	public $css;
	public $frameborder = 5;
	public $scrolling = "no";
	
	function __construct($father,$name,$class="",$src="",$disabled=""){
		$this->father = $father;
		$this->name = $name;
		if($this->father!==false){
		    $this->nivel = $this->father->getNivel();   
        }
		$this->Class = $class;
		$this->disabled = $disabled;
		$this->src = $src;
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->css->border($this->frameborder);
		$this->css->backGroundColor(COLOR_WHITE);
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		$this->newObj($this,$this->name,"iframe",$this->father->getName());
	}
	public function End(){
		if($this->disabled){ $this->disabled = " disabled=\"disabled\""; }
		$this->e("<iframe id=\"".$this->name."\" name=\"".$this->name."\" src=\"".$this->src."\" class=\"".$this->Class."\" scrolling=\"".$this->scrolling."\" frameborder=\"".$this->frameborder."\"".$this->disabled.$this->java->getLineCommand()."></iframe>",$this->nivel);
	}
}