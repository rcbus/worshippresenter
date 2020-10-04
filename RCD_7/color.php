<?php
class color {
	public function black(){
		return $this->rgb(0,0,0);
	}
	public function darkGray(){
		return $this->rgb(70,70,70);
	}
	public function mediumBlue(){
		return $this->rgb(0,128,255);
	}
	public function lightGray(){
		return $this->rgb(240,240,240);
	}
	public function white(){
		return $this->rgb(255,255,255);
	}
	private function rgb($r=0,$g=0,$b=0){
		return "rgb(".$r.",".$g.",".$b.")";
	}
}