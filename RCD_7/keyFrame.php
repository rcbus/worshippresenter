<?php
# Keyframe
include_once 'generic.php';
include_once 'color.php';
class keyFrame extends generic {
	private $nameFake;
	
	function __construct($name="",$nameFake="",$father="",$nivel=0){
		$this->name = $name;
		$this->nameFake = $nameFake;
		if($father){
			$this->father = $father;
			$this->newObj($this,$this->name,"style",$this->father->getName());
		}
	}
	public function End(){
		$this->e("@keyframes ".$this->nameFake." {",$this->nivel);
		$this->endObj($this->name,"style");
		$this->e("}",$this->nivel);
	}
}