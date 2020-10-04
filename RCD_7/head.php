<?php
# Head
#include_once 'generic.php';
class head extends generic {
	private $ico;
	private $link = array();
    private $meta = array();
    private $path;
    private $author = "Cleiton Cavalcanti";
    private $property = "Profiable";
    private $robot = false;
    private $description = false;
    
	function __construct($name,$nivel = 0){
		$this->nivel = $nivel;
		$this->name = $name;
	}
	
    public function meta($arg1,$arg2="",$arg3=""){
        $idMeta = count($this->meta);
		$this->meta[$idMeta] = $arg1;
        if($arg2){
            $this->meta[$idMeta] .= " ".$arg2;
        }
        if($arg3){
            $this->meta[$idMeta] .= " ".$arg3;
        }
	}
	
	public function setAuthor($author){
		$this->author = $author;
	}
	
	public function setAutoRefresh($time,$url=false){
		if($url!==false){
			$this->meta("http-equiv=\"refresh\"","content=\"".$time.";URL=".$url."\"");
		}else{
			$this->meta("http-equiv=\"refresh\"","content=\"".$time."\"");
		}
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function setProperty($property){
		$this->property = $property;
	}
	
	public function setRobot(){
		$this->robot = true;
	}
	
	public function linkCss($address){
		$this->link[count($this->link)]['address'] = $this->path.$address;
	}
	public function linkIco($address){
		$this->ico = $this->path.$address;
	}
	public function setPath($path){
		$this->path = $path;
	}
	public function End(){
        global $version;
        global $PATH;
		#$this->e("<head prefix=\"og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#\">");
        $this->e("<head>");
		if($this->ico){
			#$this->e("<link rel=\"icon\" href=\"".$this->ico."\" type=\"image/png\" />",$this->nivel + 1);
			$this->e("<link rel=\"shortcut icon\" href=\"".$this->ico."favicon.ico\" />",$this->nivel + 1);
			$this->e("<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"".$this->ico."apple-touch-icon.png\" />", $this->nivel + 1);
			$this->e("<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"".$this->ico."favicon-32x32.png\" />", $this->nivel + 1);
			$this->e("<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"".$this->ico."favicon-16x16.png\" />", $this->nivel + 1);
		}
		if($this->robot===true){
			$this->e("<meta name=\"robots\" content=\"index, follow\">",$this->nivel + 1);
		}
		$this->e("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />",$this->nivel + 1);
        $this->e("<meta charset=\"UTF-8\" />",$this->nivel + 1);
		$this->e("<meta http-equiv=\"cache-control\" content=\"no-cache\" />",$this->nivel + 1);
		$this->e("<meta http-equiv=\"pragma\" content=\"no-cache\" />",$this->nivel + 1);
		$this->e("<meta name=\"author\" content=\"".$this->author."\" />",$this->nivel + 1);
		$this->e("<meta http-equiv=\"content-language\" content=\"pt-br\" />",$this->nivel + 1);
		$this->e("<meta name=\"copyright\" content=\"© ".date("Y")." ".$this->property."\" />",$this->nivel + 1);
		if($this->description!==false){
			$this->e("<meta name=\"description\" content=\"".$this->description."\" />",$this->nivel + 1);
		}
		$this->e("<meta http-equiv=\"expires\" content = \"-1\" />",$this->nivel + 1);
		$this->e("<meta name=\"viewport\" content=\"width=device-width, user-scalable=no\">",$this->nivel + 1);
        for($i=0;$i<count($this->meta);$i++){
			$this->e("<meta ".$this->meta[$i]." />",$this->nivel + 1);
		}
		$ADDRESS = array();
		for($i=0;$i<count($this->link);$i++){
			$linkSetted = 0;
			for($j=0;$j<count($ADDRESS);$j++){
				if($ADDRESS[$j]==$this->link[$i]['address']){
					$linkSetted = 1;
				}
			}
			if($linkSetted==0){
				$ADDRESS[] = $this->link[$i]['address'];
				$this->e("<link rel=\"stylesheet\" href=\"".$this->link[$i]['address']."\" />",$this->nivel + 1);
			}
		}
		$this->e("</head>");
	}
}