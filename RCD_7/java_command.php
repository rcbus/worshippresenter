<?php
$ONLYONE_COOKIE = false;

# Command :: Java
class command {
	private $Function = array();
	private $nivel = 0;
	
	public function formatTime(){
		$this->zeroLeft();
		$type = "formatTime";
		$this->setFunction($type,"function formatTime(timeSeconds,type){",$this->nivel);
		$this->setFunction($type,"if(type!=\"hour\"){",$this->nivel+1);
		$this->setFunction($type,"type = \"hour\";",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"var returnString = false;",$this->nivel+1);
		$this->setFunction($type,"if(type==\"hour\"){",$this->nivel+1);
		$this->setFunction($type,"timeSeconds = formatNumber(timeSeconds,0,\"DECIMAL\");",$this->nivel+1);
		$this->setFunction($type,"var hour = (timeSeconds / 3600);",$this->nivel+1);
		$this->setFunction($type,"hour = parseInt(hour);",$this->nivel+1);
		$this->setFunction($type,"var minute = ((timeSeconds - (hour * 3600)) / 60);",$this->nivel+1);
		$this->setFunction($type,"minute = parseInt(minute);",$this->nivel+1);
		$this->setFunction($type,"var second = Math.round((timeSeconds - (hour * 3600) - (minute * 60)));",$this->nivel+1);
		$this->setFunction($type,"returnString = zeroLeft(hour) + \":\" + zeroLeft(minute) + \":\" + zeroLeft(second);",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"return returnString;",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel+1);
	}
	public function zeroLeft(){
		$type = "zeroLeft";
		$this->setFunction($type,"function zeroLeft(value){",$this->nivel);
		$this->setFunction($type,"var tmp = value;",$this->nivel+1);
		$this->setFunction($type,"if(tmp<10){",$this->nivel+1);
		$this->setFunction($type,"tmp = \"0\" + String(tmp);",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"return tmp;",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function mathInterObj($event,$obj,$objA,$objB,$objAffected,$typeMath="SUM",$digit=2,$id=false){
		$this->formatNumber();
		$type = "mathInterObj".$obj.$id;
		$this->setFunction($type,"var obj".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"var obj".$objAffected.$id." = document.getElementById(\"".$objAffected."\");",$this->nivel);
		$this->setFunction($type,"var obj".$objA.$id." = document.getElementById(\"".$objA."\");",$this->nivel);
		$this->setFunction($type,"var obj".$objB.$id." = document.getElementById(\"".$objB."\");",$this->nivel);
		
		$this->setFunction($type,"obj".$obj.$id.".addEventListener(\"".$event."\", funcMathInterObj".$obj.$id.", true);",$this->nivel);
		$this->setFunction($type,"function funcMathInterObj".$obj.$id."() {",$this->nivel);
		$this->setFunction($type,"var resultMath;",$this->nivel+2);
		if(strtoupper($typeMath)=="SUM"){
			$this->setFunction($type,"resultMath = formatNumber(obj".$objA.$id.".value,".$digit.",\"DECIMAL\") + formatNumber(obj".$objB.$id.".value,2,\"DECIMAL\");",$this->nivel+2);
			$this->setFunction($type,"resultMath = formatNumber(resultMath,".$digit.",\"DECIMAL_PT\");",$this->nivel+2);
		}
		if(strtoupper($typeMath)=="MULTIPLY"){
			$this->setFunction($type,"resultMath = formatNumber(obj".$objA.$id.".value,".$digit.",\"DECIMAL\") * formatNumber(obj".$objB.$id.".value,2,\"DECIMAL\");",$this->nivel+2);
			$this->setFunction($type,"resultMath = formatNumber(resultMath,".$digit.",\"DECIMAL_PT\");",$this->nivel+2);
		}
		if(strtoupper($typeMath)=="DIVISION"){
			$this->setFunction($type,"resultMath = formatNumber(obj".$objA.$id.".value,".$digit.",\"DECIMAL\") / formatNumber(obj".$objB.$id.".value,2,\"DECIMAL\");",$this->nivel+2);
			$this->setFunction($type,"resultMath = formatNumber(resultMath,".$digit.",\"DECIMAL_PT\");",$this->nivel+2);
		}
		if($objAffected=="this"){
			$this->setFunction($type,"obj".$obj.$id.".value = resultMath;",$this->nivel+2);
		}else{
			$this->setFunction($type,"obj".$objAffected.$id.".value = resultMath;",$this->nivel+2);
		}
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function formatNumber(){
		$type = "formatNumber";
		$this->setFunction($type,"function formatNumber(value,digit,type){",$this->nivel);
		$this->setFunction($type,"if(type==\"DECIMAL\"){",$this->nivel+1);
		$this->setFunction($type,"var tmp = value;",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.replace(\"R$\",\"\");",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.replace(\" \",\"\");",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.replace(\".\",\"\");",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.replace(\",\",\".\");",$this->nivel+2);
		$this->setFunction($type,"tmp = (tmp * 1);",$this->nivel+2);
		$this->setFunction($type,"if(digit>=0){",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.toFixed(digit);",$this->nivel+2);
		$this->setFunction($type,"}else{",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.toFixed(2);",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"tmp = parseFloat(tmp);",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"if(type==\"DECIMAL_PT\"){",$this->nivel+1);
		$this->setFunction($type,"var tmp = String(value);",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.replace(\",\",\".\");",$this->nivel+2);
		$this->setFunction($type,"tmp = parseFloat(tmp);",$this->nivel+2);
		$this->setFunction($type,"if(digit){",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.toFixed(digit);",$this->nivel+2);
		$this->setFunction($type,"}else{",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.toFixed(2);",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"tmp = String(tmp);",$this->nivel+2);
		$this->setFunction($type,"tmp = tmp.replace(\".\",\",\");",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"return tmp;",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function clear($event,$obj,$onlyOne,$objAffected){
		$type = "clear".$obj;
		$this->setFunction($type,"var obj".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"var obj".$objAffected." = document.getElementById(\"".$objAffected."\");",$this->nivel);
		if($onlyOne===true){
			$this->setFunction($type,"var obj".$obj."First = 0;",$this->nivel);
		}
		$this->setFunction($type,"obj".$obj.".addEventListener(\"".$event."\", funcClear".$obj.", true);",$this->nivel);
		$this->setFunction($type,"function funcClear".$obj."() {",$this->nivel);
			if($onlyOne===true){
				$this->setFunction($type,"if(obj".$obj."First==0){",$this->nivel+1);
					$this->setFunction($type,"obj".$obj."First = 1;",$this->nivel+1);
					if($objAffected=="this"){
						$this->setFunction($type,"obj".$obj.".value = '';",$this->nivel+2);
					}else{
						$this->setFunction($type,"obj".$objAffected.".value = '';",$this->nivel+2);
					}
				$this->setFunction($type,"}",$this->nivel+1);
			}else{
				if($objAffected=="this"){
					$this->setFunction($type,"obj".$obj.".value = '';",$this->nivel+2);
				}else{
					$this->setFunction($type,"obj".$objAffected.".value = '';",$this->nivel+2);
				}
			}
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function toUpperCase($event,$obj){
		$type = "toUpperCase".$obj;
		$this->setFunction($type,"var obj".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"obj".$obj.".addEventListener(\"".$event."\", toUpperCase".$obj.", true);",$this->nivel);
		$this->setFunction($type,"function toUpperCase".$obj."() {",$this->nivel);
		$this->setFunction($type,"obj".$obj.".value = obj".$obj.".value.toUpperCase();",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function goToPageEvent($event,$obj,$pageDest="",$parameter="",$value=false,$target="",$addParameter="",$port="",$objToGetValue=false,$child=false,$execute=false,$timeout=false,$id=false){
		global $page;
		global $BASE_CARREGANDO_CONT;
		
		$type = "goToPageEvent".$obj.$id;
		
		if($timeout!==false){
			$this->setFunction($type,"var timeoutTarget".$obj.$id." = ".$timeout.";",$this->nivel);
			$this->setFunction($type,"var timeoutCount".$obj.$id." = timeoutTarget".$obj.$id.";",$this->nivel);
			if($execute===true){
				$this->setFunction($type,"var timeoutEnd".$obj.$id." = 0;",$this->nivel);
			}else{
				$this->setFunction($type,"var timeoutEnd".$obj.$id." = 1;",$this->nivel);
			}
			
			$this->setFunction($type,"function coreTimeout".$obj.$id."(){",$this->nivel);
			$this->setFunction($type,"if(timeoutTarget".$obj.$id."==timeoutCount".$obj.$id."){",$this->nivel+1);
			$this->setFunction($type,"timeoutCount".$obj.$id." = 0;",$this->nivel+2);
			$this->setFunction($type,"timeoutEnd".$obj.$id." = 0;",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"}",$this->nivel);
			
			$this->setFunction($type,"setInterval(",$this->nivel);
			$this->setFunction($type,"function(){",$this->nivel+1);
			$this->setFunction($type,"if(timeoutTarget".$obj.$id.">timeoutCount".$obj.$id."){",$this->nivel+2);
			$this->setFunction($type,"timeoutCount".$obj.$id."++;",$this->nivel+3);
			$this->setFunction($type,"}else{",$this->nivel+2);
			$this->setFunction($type,"if(timeoutEnd".$obj.$id."==0){",$this->nivel+3);
			$this->setFunction($type,"timeoutEnd".$obj.$id." = 1;",$this->nivel+4);
			$this->setFunction($type,"goToPageEvent".$obj.$id."();",$this->nivel+4);
			$this->setFunction($type,"}",$this->nivel+3);
			$this->setFunction($type,"}",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,",100);",$this->nivel);
		}
		
		$this->setFunction($type,"var obj".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		if($objToGetValue!=false){
			$this->setFunction($type,"var objToGetValue".$objToGetValue.$id." = document.getElementById(\"".$objToGetValue."\");",$this->nivel);
		}
		if($timeout===false){
			$this->setFunction($type,"obj".$obj.$id.".addEventListener(\"".$event."\", goToPageEvent".$obj.$id.", true);",$this->nivel);
		}else{
			$this->setFunction($type,"obj".$obj.$id.".addEventListener(\"".$event."\", coreTimeout".$obj.$id.", true);",$this->nivel);
		}
		$this->setFunction($type,"function goToPageEvent".$obj.$id."() {",$this->nivel);
		if(strlen($target)==0 && $page->getIsParent()===false){
			if($BASE_CARREGANDO_CONT===false){
				$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+1);
			}else{
				$this->setFunction($type,"openBaseCarregando();",$this->nivel+1);
			}
		}
		if(strtoupper($value)=="THIS"){
			if($target!='' && $target!='_parent' && $target!='_PARENT'){
				if($port){
					$pageDest = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME'].":".$port,$pageDest);
				}
				if($parameter!=''){
					if($objToGetValue===false){
						$this->setFunction($type,"window.open('http://' + '".$pageDest."' + '?' + '".$parameter."' + '=' + obj".$obj.$id.".value + '".$addParameter."','_blank');",$this->nivel+1);
					}else{
						$this->setFunction($type,"window.open('http://' + '".$pageDest."' + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."','_blank');",$this->nivel+1);
					}
				}else{
					$this->setFunction($type,"window.open('http://' + '".$pageDest."','_blank');",$this->nivel+1);
				}
			}else if($target=='_parent' || $target=='_PARENT'){
				if($parameter!=''){
					if($objToGetValue===false){
						$this->setFunction($type,"window.parent.location.href = '".$pageDest."' + '?' + '".$parameter."' + '=' + obj".$obj.$id.".value + '".$addParameter."';",$this->nivel+1);
					}else{
						$this->setFunction($type,"window.parent.location.href = '".$pageDest."' + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."';",$this->nivel+1);
					}
				}else{
					$this->setFunction($type,"window.parent.location.href = '".$pageDest."';",$this->nivel+1);
				}
			}else if($child!=false){
				if($pageDest!==false){
					if($parameter!=''){
						if($objToGetValue===false){
							$this->setFunction($type,"document.getElementById('".$child."').src = '".$pageDest."' + '?' + '".$parameter."' + '=' + obj".$obj.$id.".value + '".$addParameter."';",$this->nivel+1);
						}else{
							$this->setFunction($type,"document.getElementById('".$child."').src = '".$pageDest."' + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."';",$this->nivel+1);
						}
					}else{
						$this->setFunction($type,"document.getElementById('".$child."').src = '".$pageDest."';",$this->nivel+1);
					}
				}else{
					$this->setFunction($type,"var srcTmp = document.getElementById('".$child."').src;",$this->nivel+1);
					$this->setFunction($type,"if(srcTmp.indexOf(\"?\")>0){",$this->nivel+1);
					$this->setFunction($type,"srcTmp = srcTmp.substring(0, srcTmp.indexOf(\"?\"));",$this->nivel+2);
					$this->setFunction($type,"}",$this->nivel+1);
					if($parameter!=''){
						if($objToGetValue===false){
							$this->setFunction($type,"document.getElementById('".$child."').src = srcTmp + '?' + '".$parameter."' + '=' + obj".$obj.$id.".value + '".$addParameter."';",$this->nivel+1);
						}else{
							$this->setFunction($type,"document.getElementById('".$child."').src = srcTmp + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."';",$this->nivel+1);
						}
					}else{
						$this->setFunction($type,"document.getElementById('".$child."').src = srcTmp;",$this->nivel+1);
					}
				}
			}else{
				if($parameter!=''){
					if($objToGetValue===false){
						$this->setFunction($type,"document.location.href = '".$pageDest."' + '?' + '".$parameter."' + '=' + obj".$obj.$id.".value + '".$addParameter."';",$this->nivel+1);
					}else{
						$this->setFunction($type,"document.location.href = '".$pageDest."' + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."';",$this->nivel+1);
					}
				}else{
					$this->setFunction($type,"document.location.href = '".$pageDest."';",$this->nivel+1);
				}
			}
		}else{
			if($target!='' && $target!='_parent' && $target!='_PARENT'){
				if($port){
					$pageDest = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME'].":".$port,$pageDest);
				}
				if($parameter!=''){
					$this->setFunction($type,"window.open('http://' + '".$pageDest."' + '?' + '".$parameter."' + '=' + '".$value."' + '".$addParameter."','_blank');",$this->nivel+1);
				}else{
					$this->setFunction($type,"window.open('http://' + '".$pageDest."','_blank');",$this->nivel+1);
				}
			}else if($target=='_parent' || $target=='_PARENT'){
				if($parameter!=''){
					$this->setFunction($type,"window.parent.location.href = '".$pageDest."' + '?' + '".$parameter."' + '=' + '".$value."' + '".$addParameter."';",$this->nivel+1);
				}else{
					$this->setFunction($type,"window.parent.location.href = '".$pageDest."';",$this->nivel+1);
				}
			}else if($child!=false){
				if($pageDest!==false){
					if($parameter!=''){
						if($objToGetValue===false){
							$this->setFunction($type,"document.getElementById('".$child."').src = '".$pageDest."' + '?' + '".$parameter."' + '=' + '".$value."' + '".$addParameter."';",$this->nivel+1);
						}else{
							$this->setFunction($type,"document.getElementById('".$child."').src = '".$pageDest."' + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."';",$this->nivel+1);
						}
					}else{
						$this->setFunction($type,"document.getElementById('".$child."').src = '".$pageDest."';",$this->nivel+1);
					}
				}else{
					$this->setFunction($type,"var srcTmp = document.getElementById('".$child."').src;",$this->nivel+1);
					$this->setFunction($type,"if(srcTmp.indexOf(\"?\")>0){",$this->nivel+1);
					$this->setFunction($type,"srcTmp = srcTmp.substring(0, srcTmp.indexOf(\"?\"));",$this->nivel+2);
					$this->setFunction($type,"}",$this->nivel+1);
					if($parameter!=''){
						if($objToGetValue===false){
							$this->setFunction($type,"document.getElementById('".$child."').src = srcTmp + '?' + '".$parameter."' + '=' + '".$value."' + '".$addParameter."';",$this->nivel+1);
						}else{
							$this->setFunction($type,"document.getElementById('".$child."').src = srcTmp + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."';",$this->nivel+1);
						}
					}else{
						$this->setFunction($type,"document.getElementById('".$child."').src = srcTmp;",$this->nivel+1);
					}
				}
			}else{
				if($parameter!=''){
					if($objToGetValue===false){
						$this->setFunction($type,"document.location.href = '".$pageDest."' + '?' + '".$parameter."' + '=' + '".$value."' + '".$addParameter."';",$this->nivel+1);
					}else{
						$this->setFunction($type,"document.location.href = '".$pageDest."' + '?' + '".$parameter."' + '=' + objToGetValue".$objToGetValue.$id.".value + '".$addParameter."';",$this->nivel+1);
					}
				}else{
					$this->setFunction($type,"document.location.href = '".$pageDest."';",$this->nivel+1);
				}
			}
		}
		$this->setFunction($type,"}",$this->nivel);
		if($execute===true){
			$this->setFunction($type,"goToPageEvent".$obj.$id."();",$this->nivel);
		}
	}
	public function goToPage(){
		global $page;
		global $BASE_CARREGANDO_CONT;
		
		$type = "goToPage";
		$this->setFunction($type,"function goToPage(Page,Parameter,Value,Target,addParameter,Child){",$this->nivel);
		if($page->getIsParent()===false){
			$this->setFunction($type,"if(Target==''){",$this->nivel+1);
				if($BASE_CARREGANDO_CONT===false){
					$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+2);
				}else{
					$this->setFunction($type,"openBaseCarregando();",$this->nivel+2);
				}
			$this->setFunction($type,"}",$this->nivel+1);
		}
		$this->setFunction($type,"if(Child!=''){",$this->nivel+1);
			$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
				$this->setFunction($type,"document.getElementById(Child).src = Page + '?' + Parameter + '=' + Value + addParameter;",$this->nivel+3);
			$this->setFunction($type,"}else{",$this->nivel+2);
				$this->setFunction($type,"document.getElementById(Child).src = Page;",$this->nivel+3);
			$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}else if(Target!='' && Target!='_parent' && Target!='_PARENT'){",$this->nivel+1);
        	$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
				$this->setFunction($type,"window.open('http://' + Page + '?' + Parameter + '=' + Value + addParameter,'_blank');",$this->nivel+3);
        	$this->setFunction($type,"}else{",$this->nivel+2);
        		$this->setFunction($type,"window.open('http://' + Page,'_blank');",$this->nivel+3);
       		$this->setFunction($type,"}",$this->nivel+2);
       	$this->setFunction($type,"}else if(Target=='_parent' || Target=='_PARENT'){",$this->nivel+1);
	       	$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
	       		$this->setFunction($type,"window.parent.location.href = Page + '?' + Parameter + '=' + Value + addParameter;",$this->nivel+3);
	       	$this->setFunction($type,"}else{",$this->nivel+2);
	       		$this->setFunction($type,"window.parent.location.href = Page;",$this->nivel+3);
	       	$this->setFunction($type,"}",$this->nivel+2);
        $this->setFunction($type,"}else{",$this->nivel+1);
        	$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
				$this->setFunction($type,"document.location.href = Page + '?' + Parameter + '=' + Value + addParameter;",$this->nivel+3);
        	$this->setFunction($type,"}else{",$this->nivel+2);
        		$this->setFunction($type,"document.location.href = Page;",$this->nivel+3);
        	$this->setFunction($type,"}",$this->nivel+2);
        $this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function goToPageWithGetValue(){
		global $page;
		global $BASE_CARREGANDO_CONT;
	
		$type = "goToPageWithGetValue";
		$this->setFunction($type,"function goToPageWithGetValue(Page,Parameter,Value,ObjToGetValue,Target,addParameter,Child){",$this->nivel);
		if($page->getIsParent()===false){
			$this->setFunction($type,"if(Target==''){",$this->nivel+1);
			if($BASE_CARREGANDO_CONT===false){
				$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+2);
			}else{
				$this->setFunction($type,"openBaseCarregando();",$this->nivel+2);
			}
			$this->setFunction($type,"}",$this->nivel+1);
		}
		$this->setFunction($type,"if(ObjToGetValue!=''){",$this->nivel+1);
		$this->setFunction($type,"Value = document.getElementById(ObjToGetValue).value;",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"if(Child!=''){",$this->nivel+1);
		$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
		$this->setFunction($type,"document.getElementById(Child).src = Page + '?' + Parameter + '=' + Value + addParameter;",$this->nivel+3);
		$this->setFunction($type,"}else{",$this->nivel+2);
		$this->setFunction($type,"document.getElementById(Child).src = Page;",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}else if(Target!='' && Target!='_parent' && Target!='_PARENT'){",$this->nivel+1);
		$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
		$this->setFunction($type,"window.open('http://' + Page + '?' + Parameter + '=' + Value + addParameter,'_blank');",$this->nivel+3);
		$this->setFunction($type,"}else{",$this->nivel+2);
		$this->setFunction($type,"window.open('http://' + Page,'_blank');",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}else if(Target=='_parent' || Target=='_PARENT'){",$this->nivel+1);
		$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
		$this->setFunction($type,"window.parent.location.href = Page + '?' + Parameter + '=' + Value + addParameter;",$this->nivel+3);
		$this->setFunction($type,"}else{",$this->nivel+2);
		$this->setFunction($type,"window.parent.location.href = Page;",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}else{",$this->nivel+1);
		$this->setFunction($type,"if(Parameter!=''){",$this->nivel+2);
		$this->setFunction($type,"document.location.href = Page + '?' + Parameter + '=' + Value + addParameter;",$this->nivel+3);
		$this->setFunction($type,"}else{",$this->nivel+2);
		$this->setFunction($type,"document.location.href = Page;",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function setValue(){
		$type = "setValue";
		$this->setFunction($type,"function setValue(obj,value){",$this->nivel);
		$this->setFunction($type,"document.getElementById(obj).value = value;",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function resetComboBox(){
		$type = "resetComboBox";
		$this->setFunction($type,"function resetComboBox(obj,values,descriptions,selectedIndex){",$this->nivel);
		$this->setFunction($type,"var obj = document.getElementById(obj);",$this->nivel+1);
		$this->setFunction($type,"while (obj.length > 0) {",$this->nivel+1);
		$this->setFunction($type,"obj.remove(obj.length-1);",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"descriptions = descriptions.split(',');",$this->nivel+1);
		$this->setFunction($type,"values = values.split(',');",$this->nivel+1);
		#$this->setFunction($type,"var lastIndex = false;",$this->nivel+1);
		$this->setFunction($type,"values.forEach(createOptions);",$this->nivel+1);
		$this->setFunction($type,"function createOptions(item, index){",$this->nivel+1);
		$this->setFunction($type,"var option = document.createElement(\"option\");",$this->nivel+2);
		$this->setFunction($type,"option.text = descriptions[index];",$this->nivel+2);
		$this->setFunction($type,"option.value = item;",$this->nivel+2);
		$this->setFunction($type,"obj.add(option, obj[index]);",$this->nivel+2);
		#$this->setFunction($type,"lastIndex = index;",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		#$this->setFunction($type,"obj.selectedIndex = lastIndex;",$this->nivel+1);
		$this->setFunction($type,"obj.value = selectedIndex;",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function resetComboBoxEvent($event,$obj,$objAffected,$var=false,$varB=false,$varC=false,$id=false){
		$type = "resetComboBox".$obj.$id;
		
		$this->setFunction($type,"var resetComboBox".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"resetComboBox".$obj.$id.".addEventListener(\"".$event."\",function() { resetComboBoxEvent".$obj.$id."('".$objAffected."','".$var."','".$varB."','".$varC."');}, true);",$this->nivel);
				
		$this->setFunction($type,"function resetComboBoxEvent".$obj.$id."(obj,values,descriptions,selectedIndex){",$this->nivel);
		$this->setFunction($type,"var obj = document.getElementById(obj);",$this->nivel+1);
		$this->setFunction($type,"obj.disabled = true;",$this->nivel+1);
		$this->setFunction($type,"while (obj.length > 0) {",$this->nivel+1);
		$this->setFunction($type,"obj.remove(obj.length-1);",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"descriptions = descriptions.split(',');",$this->nivel+1);
		$this->setFunction($type,"values = values.split(',');",$this->nivel+1);
		#$this->setFunction($type,"var lastIndex = false;",$this->nivel+1);
		$this->setFunction($type,"values.forEach(createOptions);",$this->nivel+1);
		$this->setFunction($type,"function createOptions(item, index){",$this->nivel+1);
		$this->setFunction($type,"var option = document.createElement(\"option\");",$this->nivel+2);
		$this->setFunction($type,"option.text = descriptions[index];",$this->nivel+2);
		$this->setFunction($type,"option.value = item;",$this->nivel+2);
		$this->setFunction($type,"obj.add(option, obj[index]);",$this->nivel+2);
		#$this->setFunction($type,"lastIndex = index;",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		#$this->setFunction($type,"obj.selectedIndex = lastIndex;",$this->nivel+1);
		$this->setFunction($type,"obj.value = selectedIndex;",$this->nivel+1);
		$this->setFunction($type,"obj.disabled = false;",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function closeObjEvent($event,$obj,$objAffected,$id=false){
		$type = "closeObj".$obj.$id;
		$this->setFunction($type,"var closeObj".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"closeObj".$obj.$id.".addEventListener(\"".$event."\",function() { closeObjEvent".$obj.$id."('".$objAffected."');}, true);",$this->nivel);
		
		$this->setFunction($type,"function closeObjEvent".$obj.$id."(Objeto){",$this->nivel);
		$this->setFunction($type,"if(Objeto=='this'){",$this->nivel+1);
		$this->setFunction($type,"window.close();",$this->nivel+2);
		$this->setFunction($type,"}else{",$this->nivel+1);
		$this->setFunction($type,"document.getElementById(Objeto).style.display = \"none\";",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function setValueEvent($event,$obj,$objAffected,$value,$id=false){		
		$type = "setValue".$obj.$id;
		$this->setFunction($type,"var setValue".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"setValue".$obj.$id.".addEventListener(\"".$event."\",function() { setValueEvent".$obj.$id."('".$objAffected."','".$value."');}, true);",$this->nivel);
		
		$this->setFunction($type,"function setValueEvent".$obj.$id."(obj,value){",$this->nivel);
		$this->setFunction($type,"var setValueAffected".$objAffected.$id." = document.getElementById(obj);",$this->nivel+1);
		$this->setFunction($type,"setValueAffected".$objAffected.$id.".value = value;",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function setValueCopyEvent($event,$obj,$objOrigem,$objDest,$origemInnerHTML=false,$destInnerHTML=false,$id=false){
		$type = "setValueCopy".$obj.$id;
		$this->setFunction($type,"var setValueCopy".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"setValueCopy".$obj.$id.".addEventListener(\"".$event."\",function() { setValueCopyEvent".$obj.$id."('".$objOrigem."','".$objDest."');}, true);",$this->nivel);
	
		$this->setFunction($type,"function setValueCopyEvent".$obj.$id."(objOrigem,objDest){",$this->nivel);
		$this->setFunction($type,"var setValueObjOrigem".$objOrigem.$id." = document.getElementById(objOrigem);",$this->nivel+1);
		$this->setFunction($type,"var setValueObjDest".$objDest.$id." = document.getElementById(objDest);",$this->nivel+1);
		$this->setFunction($type,"setValueObjDest".$objDest.$id.".value = setValueObjOrigem".$objOrigem.$id.".value;",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function setCopyCommentEvent($event,$obj,$id=false){
		$type = "setCopyComment".$obj.$id;
		$this->setFunction($type,"var setCopyComment".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"setCopyComment".$obj.$id.".addEventListener(\"".$event."\",function() { setCopyCommentEvent".$obj.$id."();}, true);",$this->nivel);
	
		$this->setFunction($type,"function setCopyCommentEvent".$obj.$id."(){",$this->nivel);
		$this->setFunction($type,"var valueCopyCommentOrigem".$obj.$id." = document.getElementById('tbComment').value;",$this->nivel+1);
		$this->setFunction($type,"var formToSendComment".$obj.$id." = document.getElementById('formToSendComment').value;",$this->nivel+1);
		$this->setFunction($type,"document.getElementById('hdComment' + formToSendComment".$obj.$id.").value = valueCopyCommentOrigem".$obj.$id.";",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function setFocus($event=false,$obj="",$objAffected="this",$onlyOne=false,$execute=false){
		if($event===false){
			$type = "setFocus";
			$this->setFunction($type,"function setFocus(obj,value){",$this->nivel);
			$this->setFunction($type,"document.getElementById(obj).focus();",$this->nivel+1);
			$this->setFunction($type,"}\n",$this->nivel);
		}else{
			$type = "setFocus".$obj;
			$this->setFunction($type,"var obj".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
			$this->setFunction($type,"var objAff".$objAffected." = document.getElementById(\"".$objAffected."\");",$this->nivel);
			if($onlyOne===true){
				$this->setFunction($type,"var obj".$obj."First = 0;",$this->nivel);
			}
			$this->setFunction($type,"obj".$obj.".addEventListener(\"".$event."\", funcSetFocus".$obj.", true);",$this->nivel);
			$this->setFunction($type,"function funcSetFocus".$obj."() {",$this->nivel);
			if($onlyOne===true){
				$this->setFunction($type,"if(obj".$obj."First==0){",$this->nivel+1);
				$this->setFunction($type,"obj".$obj."First = 1;",$this->nivel+1);
				if($objAffected=="this"){
					$this->setFunction($type,"obj".$obj.".focus();",$this->nivel+2);
				}else{
					$this->setFunction($type,"objAff".$objAffected.".focus();",$this->nivel+2);
				}
				$this->setFunction($type,"}",$this->nivel+1);
			}else{
				if($objAffected=="this"){
					$this->setFunction($type,"obj".$obj.".focus();",$this->nivel+2);
				}else{
					$this->setFunction($type,"objAff".$objAffected.".focus();",$this->nivel+2);
				}
			}
			if($execute===true){
				$this->setFunction($type,"}",$this->nivel);
				$this->setFunction($type,"funcSetFocus".$obj."();",$this->nivel);
			}else{
				$this->setFunction($type,"}\n",$this->nivel);
			}
		}
	}
	public function timer($interval,$obj,$script,$func,$timeout=0,$limit=0,$target=false,$objA=false,$objB=false,$objAffected=false,$typeMath=false,$digit=2,$id=false){
		$type = "timer".$id;
		if($timeout){
			$this->setFunction($type,"setTimeout(",$this->nivel);
			$this->setFunction($type,"function(){",$this->nivel+1);
			if($func=="reloadScript" || $func=="reloadScriptValue"){	$this->setFunction($type,"reloadScript('".$obj."','".$script."','');",$this->nivel+2); }
			if($func=="reSize"){ $this->setFunction($type,"reSize('".$obj."');",$this->nivel+2); }
			if($func=="goToPage"){ $this->setFunction($type,"goToPage('".$script."','','','".$target."','','');",$this->nivel+2); }
			if($func=="mathInterObj"){ $this->setFunction($type,"funcMathInterObj".$obj.$id."();",$this->nivel+2); }
			if($func=="formatTime"){ 
				$this->setFunction($type,"var objFormatTime".$objA." = document.getElementById('".$objA."');",$this->nivel+2);
				$this->setFunction($type,"var objAffected".$objAffected." = document.getElementById('".$objAffected."');",$this->nivel+2);
				$this->setFunction($type,"objAffected".$objAffected.".value = formatTime(objFormatTime".$objA.".value,\"hour\");",$this->nivel+2); 
			}
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,",".$timeout.");",$this->nivel);
		}
		if($interval){
			if($limit){
				$this->setFunction($type,"var limit = ".$limit,$this->nivel);
			}
			$this->setFunction($type,"setInterval(",$this->nivel);
			$this->setFunction($type,"function(){",$this->nivel+1);
			if($limit){
				$this->setFunction($type,"if(limit>0){",$this->nivel+2);
				if($func=="reloadScript" || $func=="reloadScriptValue"){	$this->setFunction($type,"reloadScript('".$obj."','".$script."','');",$this->nivel+3); }
				if($func=="reSize"){ $this->setFunction($type,"reSize('".$obj."');",$this->nivel+3); }
				if($func=="goToPage"){ $this->setFunction($type,"goToPage('".$script."','','','".$target."','','');",$this->nivel+3); }
				if($func=="mathInterObj"){ $this->setFunction($type,"funcMathInterObj".$obj.$id."();",$this->nivel+3); }
				if($func=="formatTime"){
					$this->setFunction($type,"var objFormatTime".$objA." = document.getElementById('".$objA."');",$this->nivel+3);
					$this->setFunction($type,"var objAffected".$objAffected." = document.getElementById('".$objAffected."');",$this->nivel+3);
					$this->setFunction($type,"objAffected".$objAffected.".value = formatTime(objFormatTime".$objA.".value,\"hour\");",$this->nivel+3);
				}
				$this->setFunction($type,"limit--;",$this->nivel+3);
				$this->setFunction($type,"}",$this->nivel+2);
			}else{
				if($func=="reloadScript" || $func=="reloadScriptValue"){	$this->setFunction($type,"reloadScript('".$obj."','".$script."','');",$this->nivel+2); }
				if($func=="reSize"){ $this->setFunction($type,"reSize('".$obj."');",$this->nivel+2); }
				if($func=="goToPage"){ $this->setFunction($type,"goToPage('".$script."','','','".$target."','','');",$this->nivel+2); }
				if($func=="mathInterObj"){ $this->setFunction($type,"funcMathInterObj".$obj.$id."();",$this->nivel+2); }
				if($func=="formatTime"){
					$this->setFunction($type,"var objFormatTime".$objA." = document.getElementById('".$objA."');",$this->nivel+2);
					$this->setFunction($type,"var objAffected".$objAffected." = document.getElementById('".$objAffected."');",$this->nivel+2);
					$this->setFunction($type,"objAffected".$objAffected.".value = formatTime(objFormatTime".$objA.".value,\"hour\");",$this->nivel+2);
				}
			}
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,",".$interval.");",$this->nivel);
		}
		if($func=="reloadScript"){ $this->reloadScript(); }
		if($func=="reloadScriptValue"){ $this->reloadScript("","","","","","","","",false); }
		if($func=="reSize"){ $this->reSize(); }
		if($func=="goToPage"){ $this->goToPage(); }
		if($func=="mathInterObj"){ $this->mathInterObj("click",$obj,$objA,$objB,$objAffected,$typeMath,$digit,$id); }
		if($func=="formatTime"){ $this->formatTime(); }
	}
	public function loadSelect($event="",$obj="",$objToLoad="",$script="",$objToGetParameter="",$parameterName="",$pagename="",$columnIndex="",$columnText=""){
		global $BASE_CARREGANDO_CONT;
		
		$this->ajax();
		$type = "loadSelect".$obj;
		
		$this->setFunction($type,"var loadSelect".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
		if($objToGetParameter!=""){
			$this->setFunction($type,"var loadSelectObjGetParameter".$objToGetParameter." = document.getElementById(\"".$objToGetParameter."\");",$this->nivel);
		}
		$this->setFunction($type,"loadSelect".$obj.".addEventListener(\"".$event."\",function() { loadSelectEvent".$obj."('".$objToLoad."','".$script."');}, true);",$this->nivel);
			
		$type = "loadSelectEvent".$obj;
		$this->setFunction($type,"function loadSelectEvent".$obj."(Objeto,Script){",$this->nivel);
		
		if($objToGetParameter!=""){
			if($pagename==""){
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + loadSelectObjGetParameter".$objToGetParameter.".value;",$this->nivel+1);
			}else{
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + loadSelectObjGetParameter".$objToGetParameter.".value + '@".$pagename."';",$this->nivel+1);
			}
		}
		
		if($BASE_CARREGANDO_CONT===false){
			$this->setFunction($type,"document.getElementById('baseCarregando').style.display = 'block';",$this->nivel+1);
		}else{
			$this->setFunction($type,"openBaseCarregando();",$this->nivel+1);
		}
		$this->setFunction($type,"var objToLoad = document.getElementById(Objeto);",$this->nivel+1);
		$this->setFunction($type,"var ajax = AjaxF();",$this->nivel+1);
		$this->setFunction($type,"ajax.onreadystatechange = function(){",$this->nivel+1);
		$this->setFunction($type,"if(ajax.readyState == 4){",$this->nivel+2);
		$this->setFunction($type,"arrayResponse = JSON.parse(ajax.responseText);",$this->nivel+3);
		$this->setFunction($type,"while (objToLoad.length > 0) {",$this->nivel+3);
		$this->setFunction($type,"objToLoad.remove(objToLoad.length-1);",$this->nivel+4);
		$this->setFunction($type,"}",$this->nivel+3);
		$this->setFunction($type,"arrayResponse.forEach(loadSelectExe);",$this->nivel+3);
		$this->setFunction($type,"function loadSelectExe(item,index){",$this->nivel+3);
		$this->setFunction($type,"var option = document.createElement(\"option\");",$this->nivel+4);
		$this->setFunction($type,"option.text = arrayResponse[index]['".$columnText."'];",$this->nivel+4);
		$this->setFunction($type,"option.value = arrayResponse[index]['".$columnIndex."'];",$this->nivel+4);
		$this->setFunction($type,"objToLoad.add(option, objToLoad[index]);",$this->nivel+4);
		$this->setFunction($type,"}",$this->nivel+3);
		if($BASE_CARREGANDO_CONT===false){
			$this->setFunction($type,"document.getElementById('baseCarregando').style.display = 'none';",$this->nivel+3);
		}else{
			$this->setFunction($type,"closeBaseCarregando();",$this->nivel+3);
		}
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"ajax.open('GET', Script, false);",$this->nivel+1);
		$this->setFunction($type,"ajax.setRequestHeader('Content-Type', 'text/html');",$this->nivel+1);
		$this->setFunction($type,"ajax.send();",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function showMsg($event="",$obj="",$msg="",$pathCaseYes="",$pathCaseNo="",$typeButton="n",$objAffected=false,$target=false,$backGroundColor=COLOR_ULTRA_DARK_RED,$showComment=false,$formToSendComment=false,$id=false){
		#$this->goToPage();
		global $BASE_CARREGANDO_CONT;
		global $page;
		
		$type = "showMsg".$obj.$id;
		$this->setFunction($type,"try{",$this->nivel);
		$this->setFunction($type,"var gateShowMsg".$obj.$id." = 0;",$this->nivel+1);
		$this->setFunction($type,"var showMsg".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel+1);
		$this->setFunction($type,"showMsg".$obj.$id.".addEventListener(\"".$event."\",function() { showMsgEvent".$obj.$id."(); }, true);",$this->nivel+1);
		$this->setFunction($type,"function showMsgEvent".$obj.$id."(){",$this->nivel+1);
		$this->setFunction($type,"gateShowMsg".$obj.$id." = 1;",$this->nivel+2);
		if($showComment===true){
			$this->setFunction($type,"document.getElementById(\"tbComment\").value = \"\";",$this->nivel+2);
			$this->setFunction($type,"document.getElementById(\"baseComment\").style.display = \"block\";",$this->nivel+2);
		}
		if($formToSendComment!==false){
			$this->setFunction($type,"document.getElementById(\"formToSendComment\").value = \"".$formToSendComment."\";",$this->nivel+2);
		}
		$this->setFunction($type,"document.getElementById(\"baseMsg\").style.display = \"block\";",$this->nivel+2);
		$this->setFunction($type,"document.getElementById(\"baseBaseMsg\").style.display = \"block\";",$this->nivel+2);
		$this->setFunction($type,"document.getElementById(\"baseBaseMsg\").style.backgroundColor = '".$backGroundColor."';",$this->nivel+2);
		$this->setFunction($type,"document.getElementById(\"textoMsg\").innerHTML = '".$msg."';",$this->nivel+2);
		
		if($page->stringToUpper($typeButton)=="N"){
			$this->setFunction($type,"document.getElementById(\"btYes\").innerHTML = \"Ok\";",$this->nivel+2);
			$this->setFunction($type,"document.getElementById(\"btNo\").innerHTML = \"Cancelar\";",$this->nivel+2);
		}else{
			$this->setFunction($type,"document.getElementById(\"btYes\").innerHTML = \"Sim\";",$this->nivel+2);
			$this->setFunction($type,"document.getElementById(\"btNo\").innerHTML = \"Não\";",$this->nivel+2);
		}
		
		$this->setFunction($type,"}",$this->nivel+1);
		
		$this->setFunction($type,"var btYesShowMsg".$obj.$id." = document.getElementById(\"btYes\");",$this->nivel+1);
		$this->setFunction($type,"btYesShowMsg".$obj.$id.".addEventListener(\"click\",function() { btYesShowMsgEvent".$obj.$id."(); }, true);",$this->nivel+1);
		$this->setFunction($type,"function btYesShowMsgEvent".$obj.$id."(){",$this->nivel+1);
		$this->setFunction($type,"if(gateShowMsg".$obj.$id."==1){",$this->nivel+2);
		$this->setFunction($type,"gateShowMsg".$obj.$id." = 0;",$this->nivel+3);
		if($showComment===true){
			$this->setFunction($type,"var valueCopyCommentOrigem".$obj.$id." = document.getElementById('tbComment').value;",$this->nivel+3);
			$this->setFunction($type,"var formToSendComment".$obj.$id." = document.getElementById('formToSendComment').value;",$this->nivel+3);
			$this->setFunction($type,"document.getElementById('hdComment' + formToSendComment".$obj.$id.").value = valueCopyCommentOrigem".$obj.$id.";",$this->nivel+3);
			$this->setFunction($type,"document.getElementById(\"tbComment\").value = \"\";",$this->nivel+3);
			$this->setFunction($type,"document.getElementById(\"baseComment\").style.display = \"none\";",$this->nivel+3);
		}
		if($pathCaseYes=="" && $pathCaseYes!==false){
			$pathCaseYes = $_SERVER['SCRIPT_NAME'];
			if($BASE_CARREGANDO_CONT===false){
				$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+3);
			}else{
				$this->setFunction($type,"openBaseCarregando();",$this->nivel+3);
			}
			$this->setFunction($type,"goToPage('".$pathCaseYes."','','','','','');",$this->nivel+3);
		}else if($pathCaseYes=="close"){
			$this->setFunction($type,"document.getElementById(\"baseMsg\").style.display = \"none\";",$this->nivel+3);
			$this->setFunction($type,"document.getElementById(\"baseBaseMsg\").style.display = \"none\";",$this->nivel+3);
		/*}else if($pathCaseYes=="submitForm"){
			$btYes->java->setSubmitForm("click", "btYes", $objAffected);
			$btYes->java->setObjVisible("click", "btYes", "baseCarregando");*/
		}else if($pathCaseYes!==false && $objAffected===false){
			if($BASE_CARREGANDO_CONT===false){
				$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+3);
			}else{
				$this->setFunction($type,"openBaseCarregando();",$this->nivel+3);
			}
			$this->setFunction($type,"goToPage('".$pathCaseYes."','','','','','');",$this->nivel+3);
		}
		
		# SUBMIT FORM
		if($objAffected!==false){
			if($BASE_CARREGANDO_CONT===false){
				$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+3);
			}else{
				$this->setFunction($type,"openBaseCarregando();",$this->nivel+3);
			}
			$this->setFunction($type,"document.getElementById('".$objAffected."').action = '".$pathCaseYes."';",$this->nivel+3);
			if($target!=""){
				$this->setFunction($type,"document.getElementById('".$objAffected."').target = '".$target."';",$this->nivel+3);
			}
			$this->setFunction($type,"document.getElementById('".$objAffected."').submit();",$this->nivel+3);
			if($showComment===true){
				$this->setFunction($type,"document.getElementById('hdComment' + formToSendComment".$obj.$id.").value = \"\";",$this->nivel+3);
			}
		}
		# FIM - SUBMIT FORM
		
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		
		$this->setFunction($type,"var btNoShowMsg".$obj.$id." = document.getElementById(\"btNo\");",$this->nivel+1);
		$this->setFunction($type,"btNoShowMsg".$obj.$id.".addEventListener(\"click\",function() { btNoShowMsgEvent".$obj.$id."(); }, true);",$this->nivel+1);
		$this->setFunction($type,"function btNoShowMsgEvent".$obj.$id."(){",$this->nivel+1);
		$this->setFunction($type,"if(gateShowMsg".$obj.$id."==1){",$this->nivel+2);
		$this->setFunction($type,"gateShowMsg".$obj.$id." = 0;",$this->nivel+3);
		if($showComment){
			$this->setFunction($type,"document.getElementById(\"tbComment\").value = \"\";",$this->nivel+3);
			$this->setFunction($type,"document.getElementById(\"baseComment\").style.display = \"none\";",$this->nivel+3);
		}
		if($pathCaseNo==""){
			$pathCaseNo = $pathCaseYes;
			if($pathCaseNo=="" && $pathCaseNo!==false){
				if($BASE_CARREGANDO_CONT===false){
					$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+3);
				}else{
					$this->setFunction($type,"openBaseCarregando();",$this->nivel+3);
				}
				$this->setFunction($type,"goToPage('".$pathCaseNo."','','','','','');",$this->nivel+3);
			}else if($pathCaseNo=="close"){
				$this->setFunction($type,"document.getElementById(\"baseMsg\").style.display = \"none\";",$this->nivel+3);
				$this->setFunction($type,"document.getElementById(\"baseBaseMsg\").style.display = \"none\";",$this->nivel+3);
			}else if($pathCaseNo!==false){
				if($BASE_CARREGANDO_CONT===false){
					$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+3);
				}else{
					$this->setFunction($type,"openBaseCarregando();",$this->nivel+3);
				}
				$this->setFunction($type,"goToPage('".$pathCaseNo."','','','','','');",$this->nivel+3);
			}
		}else if($pathCaseNo=="close"){
			$this->setFunction($type,"document.getElementById(\"baseMsg\").style.display = \"none\";",$this->nivel+3);
			$this->setFunction($type,"document.getElementById(\"baseBaseMsg\").style.display = \"none\";",$this->nivel+3);
		}else if($pathCaseNo!==false){
			if($BASE_CARREGANDO_CONT===false){
				$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+3);
			}else{
				$this->setFunction($type,"openBaseCarregando();",$this->nivel+3);
			}
			$this->setFunction($type,"goToPage('".$pathCaseNo."','','','','','');",$this->nivel+3);
		}
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);	
		$this->setFunction($type,"}catch(e){",$this->nivel);
		$this->setFunction($type,"alert('Erro: showMsgEvent - ' + e);",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function reloadScript($event="",$obj="",$objToLoad="",$script="",$objToGetParameter="",$parameterName="",$parent="",$pagename="",$isInnerHTML=true,$id=false,$execute=false,$addParameter=false,$enableBeforeReult=false,$timeout=false){
		$this->ajax();
		if($obj==""){
			$type = "reloadScript";
			$this->setFunction($type,"function reloadScript(Objeto,Script,Parent){",$this->nivel);
			$this->setFunction($type,"var ajax = AjaxF();",$this->nivel+1);
			$this->setFunction($type,"ajax.onreadystatechange = function(){",$this->nivel+1);
			$this->setFunction($type,"if(ajax.readyState == 4){",$this->nivel+2);
			if($isInnerHTML===true){
				$this->setFunction($type,"if(Parent==''){",$this->nivel+3);
				$this->setFunction($type,"document.getElementById(Objeto).innerHTML = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}else{",$this->nivel+3);
				$this->setFunction($type,"windows.parent.getElementById(Objeto).innerHTML = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}",$this->nivel+3);
			}else{
				$this->setFunction($type,"if(Parent==''){",$this->nivel+3);
				$this->setFunction($type,"document.getElementById(Objeto).value = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}else{",$this->nivel+3);
				$this->setFunction($type,"windows.parent.getElementById(Objeto).value = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}",$this->nivel+3);
			}
			$this->setFunction($type,"}",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"ajax.open('GET', Script, false);",$this->nivel+1);
			$this->setFunction($type,"ajax.setRequestHeader('Content-Type', 'text/html');",$this->nivel+1);
			$this->setFunction($type,"ajax.send();",$this->nivel+1);
			$this->setFunction($type,"}",$this->nivel);
		}else{
			$type = "reloadScript".$obj.$id;
			$this->setFunction($type,"var reloadScript".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
			if($objToGetParameter!=""){
				$this->setFunction($type,"var reloadScriptObjGetParameter".$objToGetParameter.$id." = document.getElementById(\"".$objToGetParameter."\");",$this->nivel);
			}
			
			if($timeout===false){
				$this->setFunction($type,"reloadScript".$obj.$id.".addEventListener(\"".$event."\",function() { reloadScriptEvent".$obj.$id."('".$objToLoad."','".$script."','".$parent."','".$addParameter."');}, true);",$this->nivel);
			}else{
				$this->setFunction($type,"reloadScript".$obj.$id.".addEventListener(\"".$event."\",function() { reloadScriptTimeout".$obj.$id."();}, true);",$this->nivel);
				
				$this->setFunction($type,"var timeoutTarget".$obj.$id." = ".$timeout.";",$this->nivel);
				$this->setFunction($type,"var timeoutCount".$obj.$id." = timeoutTarget".$obj.$id.";",$this->nivel);
				$this->setFunction($type,"var timeoutEnd".$obj.$id." = 0;",$this->nivel);
				
				$this->setFunction($type,"function reloadScriptTimeout".$obj.$id."(){",$this->nivel);
				$this->setFunction($type,"if(timeoutTarget".$obj.$id."==timeoutCount".$obj.$id."){",$this->nivel+1);
				$this->setFunction($type,"timeoutCount".$obj.$id." = 0;",$this->nivel+2);
				$this->setFunction($type,"timeoutEnd".$obj.$id." = 0;",$this->nivel+2);
				$this->setFunction($type,"}",$this->nivel+1);
				$this->setFunction($type,"}",$this->nivel);
				
				$this->setFunction($type,"setInterval(",$this->nivel);
				$this->setFunction($type,"function(){",$this->nivel+1);
				$this->setFunction($type,"if(timeoutTarget".$obj.$id.">timeoutCount".$obj.$id."){",$this->nivel+2);
				$this->setFunction($type,"timeoutCount".$obj.$id."++;",$this->nivel+3);
				$this->setFunction($type,"}else{",$this->nivel+2);
				$this->setFunction($type,"if(timeoutEnd".$obj.$id."==0){",$this->nivel+3);
				$this->setFunction($type,"timeoutEnd".$obj.$id." = 1;",$this->nivel+4);
				$this->setFunction($type,"reloadScriptEvent".$obj.$id."('".$objToLoad."','".$script."','".$parent."','".$addParameter."');",$this->nivel+4);
				$this->setFunction($type,"}",$this->nivel+3);
				$this->setFunction($type,"}",$this->nivel+2);
				$this->setFunction($type,"}",$this->nivel+1);
				$this->setFunction($type,",100);",$this->nivel);
			}
			
			$type = "reloadScriptEvent".$obj;
			$this->setFunction($type,"function reloadScriptEvent".$obj.$id."(Objeto,Script,Parent,AddParameter){",$this->nivel);
			if($objToGetParameter!=""){
				$this->setFunction($type,"var trataValor = reloadScriptObjGetParameter".$objToGetParameter.$id.".value;",$this->nivel+1);
				$this->setFunction($type,"reloadScriptObjGetParameter".$objToGetParameter.$id.".value = trataValor;",$this->nivel+1);
				if($pagename==""){
					$this->setFunction($type,"Script = Script + '?".$parameterName."=' + trataValor + AddParameter;",$this->nivel+1);
				}else{
					$this->setFunction($type,"Script = Script + '?".$parameterName."=' + trataValor + '@".$pagename."' + AddParameter;",$this->nivel+1);
				}
			}
			$this->setFunction($type,"var ajax = AjaxF();",$this->nivel+1);
			$this->setFunction($type,"ajax.onreadystatechange = function(){",$this->nivel+1);
			$this->setFunction($type,"if(ajax.readyState == 4){",$this->nivel+2);
			if($enableBeforeReult===true){
				$this->setFunction($type,"beforeResult();",$this->nivel+3);
			}
			if($isInnerHTML===true){
				$this->setFunction($type,"if(Parent==''){",$this->nivel+3);
				$this->setFunction($type,"document.getElementById(Objeto).innerHTML = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}else{",$this->nivel+3);
				$this->setFunction($type,"windows.parent.getElementById(Objeto).innerHTML = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}",$this->nivel+3);
			}else{
				$this->setFunction($type,"if(Parent==''){",$this->nivel+3);
				$this->setFunction($type,"document.getElementById(Objeto).value = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}else{",$this->nivel+3);
				$this->setFunction($type,"windows.parent.getElementById(Objeto).value = ajax.responseText;",$this->nivel+4);
				$this->setFunction($type,"}",$this->nivel+3);
			}
			$this->setFunction($type,"}",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"ajax.open('GET', Script, false);",$this->nivel+1);
			$this->setFunction($type,"ajax.setRequestHeader('Content-Type', 'text/html');",$this->nivel+1);
			$this->setFunction($type,"ajax.send();",$this->nivel+1);
			$this->setFunction($type,"}",$this->nivel);
			if($execute===true){
				$this->setFunction($type,"reloadScriptEvent".$obj.$id."('".$objToLoad."','".$script."','".$parent."','".$addParameter."');",$this->nivel);
				$this->reloadScript();
			}
		}
	}
	public function core($event="",$obj="",$objToLoad="",$script="",$objToGetParameter="",$parameterName="",$pagename="",$addParameter=false,$timeout=false,$showLoading=true,$execute=true,$visible=false,$id=false){
		global $BASE_CARREGANDO_CONT;
		global $page;
		global $menuCore;
		
		$page->session->setSession("coreAndress".$obj.$id,$script);
		$page->session->setSession("coreAddParameter".$obj.$id,$addParameter);
		
		$objCore = new iframe($page, "objCore".$obj.$id);
		if($execute===true){
			$objCore->src = $script;
		}
		$objCore->css->width("35%");
		$objCore->css->height(500);
		$objCore->css->setPosition("50%", 100, "absolute");
		$objCore->css->zIndex(1100);
		if($visible===false){
			$objCore->css->setInvisible();
		}
		$objCore->scrolling = "yes";
		
		if(is_object($menuCore)){
			$menuCore->inSide("<div id=\"btViewCore".$obj.$id."\" name=\"btViewCore".$obj.$id."\" class=\"bigButton\" style=\"width:80%;text-align:center;margin-left:4%\">Core ".$obj." ".$id."</div>");
		}
		$this->setVisibleTogger("click","btViewCore".$obj.$id,"objCore".$obj.$id);
		
		$type = "core".$obj.$id;
		$this->setFunction($type,"var core".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"var objCore".$obj.$id." = document.getElementById(\"objCore".$obj.$id."\");",$this->nivel);
		if($objToGetParameter!=""){
			$this->setFunction($type,"var coreObjGetParameter".$objToGetParameter.$id." = document.getElementById(\"".$objToGetParameter."\");",$this->nivel);
		}
			
		if($timeout===false){
			if($event!==false){
				$this->setFunction($type,"core".$obj.$id.".addEventListener(\"".$event."\",function() { coreEvent".$obj.$id."('".$objToLoad."','".$script."','objCore".$obj.$id."','".$addParameter."');}, true);",$this->nivel);
			}
		}else{
			if($event!==false){
				$this->setFunction($type,"core".$obj.$id.".addEventListener(\"".$event."\",function() { coreTimeout".$obj.$id."();}, true);",$this->nivel);
			}

			$this->setFunction($type,"var timeoutTarget".$obj.$id." = ".$timeout.";",$this->nivel);
			$this->setFunction($type,"var timeoutCount".$obj.$id." = timeoutTarget".$obj.$id.";",$this->nivel);
			if($execute===true){
				$this->setFunction($type,"var timeoutEnd".$obj.$id." = 0;",$this->nivel);
			}else{
				$this->setFunction($type,"var timeoutEnd".$obj.$id." = 1;",$this->nivel);
			}

			$this->setFunction($type,"function coreTimeout".$obj.$id."(){",$this->nivel);
			$this->setFunction($type,"if(timeoutTarget".$obj.$id."==timeoutCount".$obj.$id."){",$this->nivel+1);
			$this->setFunction($type,"timeoutCount".$obj.$id." = 0;",$this->nivel+2);
			$this->setFunction($type,"timeoutEnd".$obj.$id." = 0;",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"}",$this->nivel);

			$this->setFunction($type,"setInterval(",$this->nivel);
			$this->setFunction($type,"function(){",$this->nivel+1);
			$this->setFunction($type,"if(timeoutTarget".$obj.$id.">timeoutCount".$obj.$id."){",$this->nivel+2);
			$this->setFunction($type,"timeoutCount".$obj.$id."++;",$this->nivel+3);
			$this->setFunction($type,"}else{",$this->nivel+2);
			$this->setFunction($type,"if(timeoutEnd".$obj.$id."==0){",$this->nivel+3);
			$this->setFunction($type,"timeoutEnd".$obj.$id." = 1;",$this->nivel+4);
			$this->setFunction($type,"coreEvent".$obj.$id."('".$objToLoad."','".$script."','objCore".$obj.$id."','".$addParameter."');",$this->nivel+4);
			$this->setFunction($type,"}",$this->nivel+3);
			$this->setFunction($type,"}",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,",100);",$this->nivel);
		}
			
		$this->setFunction($type,"function coreEvent".$obj.$id."(Objeto,Script,Parent,AddParameter){",$this->nivel);
		if($objToGetParameter!=""){
			$this->setFunction($type,"var trataValor = coreObjGetParameter".$objToGetParameter.$id.".value;",$this->nivel+1);
			$this->setFunction($type,"coreObjGetParameter".$objToGetParameter.$id.".value = trataValor;",$this->nivel+1);
			if($pagename==""){
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + trataValor + AddParameter;",$this->nivel+1);
			}else{
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + trataValor + '@".$pagename."' + AddParameter;",$this->nivel+1);
			}
		}else if($addParameter!==false){
			$this->setFunction($type,"Script = Script + '?' + AddParameter;",$this->nivel+1);
		}
		$this->setFunction($type,"objCore".$obj.$id.".src = Script;",$this->nivel+1);
		
		if($showLoading===true){
			if($BASE_CARREGANDO_CONT===false){
				$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+1);
			}else{
				$this->setFunction($type,"openBaseCarregando();",$this->nivel+1);
			}
		}
		$this->setFunction($type,"}",$this->nivel);
		
		if($execute===true){
			$this->setFunction($type,"coreEvent".$obj.$id."('".$objToLoad."','".$script."','objCore".$obj.$id."','".$addParameter."');",$this->nivel);
		}
	}
	public function setAutoSave($event="",$obj="",$preValue=false,$id=false){
		global $RESET_AUTOSAVE;
		$this->cookie();
		$type = "autoSave".$obj.$id;
		$this->setFunction($type,"var autoSave".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"autoSave".$obj.$id.".addEventListener(\"".$event."\",function() { autoSaveEvent".$obj."(autoSave".$obj.$id.",\"nameCookie".$type."\");}, true);",$this->nivel);
		if($RESET_AUTOSAVE===true){
			$this->setFunction($type,"unSetCookie(\"nameCookie".$type."\");", $this->nivel);
		}
		if($preValue!==false){
			$this->setFunction($type,"var tempCookie".$obj.$id." = getCookie(\"nameCookie".$type."\");", $this->nivel);
			$this->setFunction($type,"if(tempCookie".$obj.$id.".length==0){", $this->nivel);
			$this->setFunction($type,"setCookie(\"nameCookie".$type."\",\"".$preValue."\",1);", $this->nivel+1);
			$this->setFunction($type,"}", $this->nivel);
		}
		$this->setFunction($type,"autoSave".$obj.$id.".value = getCookie(\"nameCookie".$type."\");", $this->nivel);
		
		$type = "autoSaveEvent".$obj;
		$this->setFunction($type,"function autoSaveEvent".$obj."(Objeto,NameCookie){",$this->nivel);
		$this->setFunction($type,"setCookie(NameCookie,Objeto.value,1);",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function cookie(){
		global $ONLYONE_COOKIE;
		if($ONLYONE_COOKIE===false){
			$ONLYONE_COOKIE = true;
			$type = "Cookie";
			$this->setFunction($type,"function setCookie(cname, cvalue, exdays) {",$this->nivel);
			$this->setFunction($type,"var d = new Date();",$this->nivel+1);
			$this->setFunction($type,"d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));",$this->nivel+1);
			$this->setFunction($type,"var expires = \"expires=\"+d.toUTCString();",$this->nivel+1);
			$this->setFunction($type,"document.cookie = cname + \"=\" + cvalue + \";\" + expires + \";path=/\";",$this->nivel+1);
			$this->setFunction($type,"}",$this->nivel);
			
			$this->setFunction($type,"function unSetCookie(cname) {",$this->nivel);
			$this->setFunction($type,"var d = new Date();",$this->nivel+1);
			$this->setFunction($type,"d.setTime(d.getTime() + (-1 * 24 * 60 * 60 * 1000));",$this->nivel+1);
			$this->setFunction($type,"var expires = \"expires=\"+d.toUTCString();",$this->nivel+1);
			$this->setFunction($type,"document.cookie = cname + \"=\" + \";\" + expires + \";path=/\";",$this->nivel+1);
			$this->setFunction($type,"}",$this->nivel);
		
			$this->setFunction($type,"function getCookie(cname) {",$this->nivel);
			$this->setFunction($type,"var name = cname + \"=\";",$this->nivel+1);
			$this->setFunction($type,"var ca = document.cookie.split(';');",$this->nivel+1);
			$this->setFunction($type,"for(var i = 0; i < ca.length; i++) {",$this->nivel+1);
			$this->setFunction($type,"var c = ca[i];",$this->nivel+2);
			$this->setFunction($type,"while (c.charAt(0) == ' ') {",$this->nivel+2);
			$this->setFunction($type,"c = c.substring(1);",$this->nivel+3);
			$this->setFunction($type,"}",$this->nivel+2);
			$this->setFunction($type,"if (c.indexOf(name) == 0) {",$this->nivel+2);
			$this->setFunction($type,"return c.substring(name.length, c.length);",$this->nivel+3);
			$this->setFunction($type,"}",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"return \"\";",$this->nivel+1);
			$this->setFunction($type,"}",$this->nivel);
		}
	}
	public function reloadForm($event=false,$obj=false,$script=false,$objToGetParameter=false,$parameterName=false,$parent=false,$pagename=false,$id=false,$execute=false,$addParameter=false){
		global $BASE_CARREGANDO_CONT;
		
		$this->ajax();
		$type = "reloadForm".$obj.$id;
		$this->setFunction($type,"var reloadForm".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		if($objToGetParameter!==false){
			$this->setFunction($type,"var reloadFormObjGetParameter".$objToGetParameter.$id." = document.getElementById(\"".$objToGetParameter."\");",$this->nivel);
		}
		$this->setFunction($type,"var baseCarregandoBlock".$id." = 1;",$this->nivel);
		$this->setFunction($type,"var baseCarregandoBlockCont".$id." = 0;",$this->nivel);
		$this->setFunction($type,"var baseCarregandoTimer".$id." = setInterval(funcBaseCarregandoTimer".$id.", 100);",$this->nivel);
		$this->setFunction($type,"function funcBaseCarregandoTimer".$id."(){",$this->nivel);
		$this->setFunction($type,"if(baseCarregandoBlock".$id."==0){",$this->nivel+1);
		$this->setFunction($type,"if(baseCarregandoBlockCont".$id."<20){",$this->nivel+2);
		$this->setFunction($type,"baseCarregandoBlockCont".$id."++;",$this->nivel+3);
		$this->setFunction($type,"}else{",$this->nivel+2);
		if($BASE_CARREGANDO_CONT===false){
			$this->setFunction($type,"document.getElementById('baseCarregando').style.display = \"none\";",$this->nivel+3);
		}else{
			$this->setFunction($type,"closeBaseCarregando();",$this->nivel+3);
		}
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
		$this->setFunction($type,"reloadForm".$obj.$id.".addEventListener(\"".$event."\",function() { reloadFormEvent".$obj.$id."('".$script."','".$parent."','".$addParameter."');}, true);",$this->nivel);
		
		$type = "reloadFormEvent".$obj;
		$this->setFunction($type,"function reloadFormEvent".$obj.$id."(Script,Parent,AddParameter){",$this->nivel);
		if($objToGetParameter!==false){
			if($pagename===false){
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + reloadFormObjGetParameter".$objToGetParameter.$id.".value + AddParameter;",$this->nivel+1);
			}else{
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + reloadFormObjGetParameter".$objToGetParameter.$id.".value + '@".$pagename."' + AddParameter;",$this->nivel+1);
			}
		}else{
			if($addParameter!==false){
				$this->setFunction($type,"Script = Script + '?' + AddParameter;",$this->nivel+1);
			}
		}
		$this->setFunction($type,"baseCarregandoBlockCont".$id." = 0;",$this->nivel+1);
		if($BASE_CARREGANDO_CONT===false){
			$this->setFunction($type,"document.getElementById('baseCarregando').style.display = \"block\";",$this->nivel+1);
		}else{
			$this->setFunction($type,"openBaseCarregando();",$this->nivel+1);
		}
		$this->setFunction($type,"var ajax = AjaxF();",$this->nivel+1);
		$this->setFunction($type,"ajax.onreadystatechange = function(){",$this->nivel+1);
		$this->setFunction($type,"if(ajax.readyState == 4){",$this->nivel+2);
		#$this->setFunction($type,"alert(\"Teste\");",$this->nivel+1);
		# AQUI ACONTECE A MAGICA
		$this->setFunction($type,"if(Parent==''){",$this->nivel+3);
		$this->setFunction($type,"objJson = JSON.parse(ajax.responseText);",$this->nivel+4);
		$this->setFunction($type,"function distribuidor(row){",$this->nivel+4);
		$this->setFunction($type,"document.getElementById(row.objToLoad).style.backgroundColor = \"".COLOR_WHITE."\";",$this->nivel+5);
		$this->setFunction($type,"document.getElementById(row.objToLoad).value = row.value;",$this->nivel+5);
		$this->setFunction($type,"}",$this->nivel+4);
		$this->setFunction($type,"objJson.forEach(distribuidor);",$this->nivel+4);
		$this->setFunction($type,"}else{",$this->nivel+3);
		$this->setFunction($type,"objJson = JSON.parse(ajax.responseText);",$this->nivel+4);
		$this->setFunction($type,"function distribuidor(row){",$this->nivel+4);
		$this->setFunction($type,"windows.parent.getElementById(row.objToLoad).style.backgroundColor = \"".COLOR_WHITE."\";",$this->nivel+5);
		$this->setFunction($type,"windows.parent.getElementById(row.objToLoad).value = row.value;",$this->nivel+5);
		$this->setFunction($type,"}",$this->nivel+4);
		$this->setFunction($type,"objJson.forEach(distribuidor);",$this->nivel+4);
		$this->setFunction($type,"}",$this->nivel+3);
		# FIM - AQUI ACONTECE A MAGICA
		$this->setFunction($type,"baseCarregandoBlock".$id." = 0;",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"ajax.open('GET', Script, false);",$this->nivel+1);
		$this->setFunction($type,"ajax.setRequestHeader('Content-Type', 'text/html');",$this->nivel+1);
		$this->setFunction($type,"ajax.send();",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
		if($execute===true){
			$this->setFunction($type,"reloadFormEvent".$obj.$id."('".$script."','".$parent."','".$addParameter."');",$this->nivel);
		}
	}
	public function submitFormAjax($event=false,$obj=false,$script=false,$objToGetParameter=false,$parameterName=false,$parent=false,$pagename=false,$id=false,$execute=false,$addParameter=false){
		global $BASE_CARREGANDO_CONT;
		
		$this->ajax();
		$type = "submitFormAjax".$obj.$id;
		$this->setFunction($type,"var submitFormAjax".$obj.$id." = document.getElementById(\"".$obj."\");",$this->nivel);
		if($objToGetParameter!==false){
			$this->setFunction($type,"var submitFormAjaxObjGetParameter".$objToGetParameter.$id." = document.getElementById(\"".$objToGetParameter."\");",$this->nivel);
		}
		$this->setFunction($type,"var baseCarregandoBlock".$id." = 1;",$this->nivel);
		$this->setFunction($type,"var baseCarregandoBlockCont".$id." = 0;",$this->nivel);
		$this->setFunction($type,"var baseCarregandoTimer".$id." = setInterval(funcBaseCarregandoTimer".$id.", 100);",$this->nivel);
		$this->setFunction($type,"function funcBaseCarregandoTimer".$id."(){",$this->nivel);
		$this->setFunction($type,"if(baseCarregandoBlock".$id."==0){",$this->nivel+1);
		$this->setFunction($type,"if(baseCarregandoBlockCont".$id."<10){",$this->nivel+2);
		$this->setFunction($type,"baseCarregandoBlockCont".$id."++;",$this->nivel+3);
		$this->setFunction($type,"}else{",$this->nivel+2);
		if($BASE_CARREGANDO_CONT===false){
			$this->setFunction($type,"document.getElementById('baseCarregando').style.display = \"none\";",$this->nivel+3);
		}else{
			$this->setFunction($type,"closeBaseCarregando();",$this->nivel+3);
		}
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
		$this->setFunction($type,"submitFormAjax".$obj.$id.".addEventListener(\"".$event."\",function() { submitFormAjaxEvent".$obj.$id."('".$script."','".$parent."','".$addParameter."');}, true);",$this->nivel);
	
		$type = "submitFormAjaxEvent".$obj;
		$this->setFunction($type,"function submitFormAjaxEvent".$obj.$id."(Script,Parent,AddParameter){",$this->nivel);
		#$this->setFunction($type,"alert(\"OK\");",$this->nivel+4);
		/*if($objToGetParameter!==false){
			if($pagename===false){
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + submitFormAjaxObjGetParameter".$objToGetParameter.$id.".value + AddParameter;",$this->nivel+1);
			}else{
				$this->setFunction($type,"Script = Script + '?".$parameterName."=' + submitFormAjaxObjGetParameter".$objToGetParameter.$id.".value + '@".$pagename."' + AddParameter;",$this->nivel+1);
			}
		}else{*/
			if($addParameter!==false){
				$this->setFunction($type,"Script = Script + '?' + AddParameter;",$this->nivel+1);
			}
		#}
		$this->setFunction($type,"baseCarregandoBlockCont".$id." = 0;",$this->nivel+1);
		if($BASE_CARREGANDO_CONT===false){
			$this->setFunction($type,"document.getElementById('baseCarregando').style.display = \"block\";",$this->nivel+1);
		}else{
			$this->setFunction($type,"openBaseCarregando();",$this->nivel+1);
		}
		$this->setFunction($type,"var ajax = AjaxF();",$this->nivel+1);
		$this->setFunction($type,"ajax.onreadystatechange = function(){",$this->nivel+1);
		$this->setFunction($type,"if(ajax.readyState == 4){",$this->nivel+2);
		# AQUI ACONTECE A MAGICA
		$this->setFunction($type,"var result = ajax.responseText;",$this->nivel+3);
		$this->setFunction($type,"document.getElementById('baseMsg').style.display = \"block\";",$this->nivel+3);
		$this->setFunction($type,"document.getElementById('btYes').addEventListener(\"click\",function() { document.getElementById('baseMsg').style.display = \"none\"; }, true);",$this->nivel+3);
		$this->setFunction($type,"document.getElementById('btNo').addEventListener(\"click\",function() { document.getElementById('baseMsg').style.display = \"none\"; }, true);",$this->nivel+3);
		$this->setFunction($type,"if(result == \"1\"){",$this->nivel+3);
		$this->setFunction($type,"document.getElementById('textoMsg').innerHTML = \"Dados salvo com sucesso!\";",$this->nivel+4);	
		$this->setFunction($type,"}else if(result == \"0\"){",$this->nivel+3);
		$this->setFunction($type,"document.getElementById('textoMsg').innerHTML = \"Houve uma falha! Por favor, informe o administrador do sistema.\";",$this->nivel+4);
		$this->setFunction($type,"}else{",$this->nivel+3);
		global $page;
		if($page->session->getLoginId()=="1"){
			$this->setFunction($type,"document.getElementById('textoMsg').innerHTML = \"Os campos destacados em vermelho são inválidos!<br>\" + result;",$this->nivel+4);
		}else{
			$this->setFunction($type,"document.getElementById('textoMsg').innerHTML = \"Os campos destacados em vermelho são inválidos!<br>\";",$this->nivel+4);
		}
		$this->setFunction($type,"objJson = JSON.parse(result);",$this->nivel+4);
		$this->setFunction($type,"function distribuidor(row){",$this->nivel+4);
		$this->setFunction($type,"document.getElementById(row.objToLoad).style.backgroundColor = \"".COLOR_LIGHT_RED."\";",$this->nivel+5);
		$this->setFunction($type,"}",$this->nivel+4);
		$this->setFunction($type,"objJson.forEach(distribuidor);",$this->nivel+4);
		$this->setFunction($type,"}",$this->nivel+3);
		# FIM - AQUI ACONTECE A MAGICA
		$this->setFunction($type,"baseCarregandoBlock".$id." = 0;",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"var elementos = submitFormAjaxObjGetParameter".$objToGetParameter.$id.".elements;",$this->nivel+1);
		$this->setFunction($type,"var dados = [];",$this->nivel+1);
		$this->setFunction($type,"for(i=0;i<elementos.length;i++){",$this->nivel+1);
		$this->setFunction($type,"if(elementos[i].type==\"text\" || elementos[i].type==\"select-one\" || elementos[i].type==\"hidden\"){",$this->nivel+2);
		$this->setFunction($type,"elementos[i].style.backgroundColor = \"".COLOR_WHITE."\";",$this->nivel+3);
		$this->setFunction($type,"dados[i] = [elementos[i].name,elementos[i].value.replace(/,/g,\"#\")];",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"var stringJson = JSON.stringify(dados);",$this->nivel+1);
		#$this->setFunction($type,"alert(stringJson);",$this->nivel+1);
		$this->setFunction($type,"ajax.open('POST', Script, true);",$this->nivel+1);
		$this->setFunction($type,"ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');",$this->nivel+1);
		$this->setFunction($type,"ajax.send(\"stringJson=\" + stringJson);",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
		if($execute===true){
			$this->setFunction($type,"reloadFormEvent".$obj.$id."('".$script."','".$parent."','".$addParameter."');",$this->nivel);
		}
	}
	public function ajax(){
		$type = "AjaxF";
		$this->setFunction($type,"function AjaxF(){",$this->nivel);
		$this->setFunction($type,"var ajax;",$this->nivel+1);
		$this->setFunction($type,"try{",$this->nivel+1);
		$this->setFunction($type,"ajax = new XMLHttpRequest();",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"catch(e){",$this->nivel+1);
		$this->setFunction($type,"try{",$this->nivel+2);
		$this->setFunction($type,"ajax = new ActiveXObject('Msxml2.XMLHTTP');",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"catch(e){",$this->nivel+2);
		$this->setFunction($type,"try{",$this->nivel+3);
		$this->setFunction($type,"ajax = new ActiveXObject('Microsoft.XMLHTTP');",$this->nivel+4);
		$this->setFunction($type,"}",$this->nivel+3);
		$this->setFunction($type,"catch(e){",$this->nivel+3);
		$this->setFunction($type,"alert('Seu browser não da suporte a AJAX!');",$this->nivel+4);
		$this->setFunction($type,"return false;",$this->nivel+4);
		$this->setFunction($type,"}",$this->nivel+3);
		$this->setFunction($type,"}",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"return ajax;",$this->nivel+1);
		$this->setFunction($type,"}",$this->nivel);
	}
	public function refresh(){
		$type = "refresh";
		$this->setFunction($type,"function refresh(){",$this->nivel);
		$this->setFunction($type,"document.location.href = '".$_SERVER['SCRIPT_NAME']."';",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function reSize(){
		$type = "reSize";
		$this->setFunction($type,"function reSize(Objeto){",$this->nivel);
		$this->setFunction($type,"if(obj = parent.document.getElementById(Objeto)){",$this->nivel+1);
		$this->setFunction($type,"obj.height = document.body.scrollHeight;",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function closeObj(){
		$type = "closeObj";
		$this->setFunction($type,"function closeObj(Objeto){",$this->nivel);
		$this->setFunction($type,"if(Objeto=='this'){",$this->nivel+1);
		$this->setFunction($type,"window.close();",$this->nivel+2);
		$this->setFunction($type,"}else{",$this->nivel+1);
		$this->setFunction($type,"document.getElementById(Objeto).style.display = \"none\";",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function innerSrc(){
		$type = "innerSrc";
		$this->setFunction($type,"function innerSrc(Objeto,Src){",$this->nivel);
		$this->setFunction($type,"document.getElementById(Objeto).src = Src;",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function innerSrcEvent($event,$obj,$objToLoad,$src,$parameter=false,$value=false,$pagename=false,$addParameter=false){
		$type = "innerSrc".$obj;
		if($parameter!==false){
			$src .= "?".$parameter;
			if($value!==false){
				$src .= "=".$value;
				if($pagename!==false){
					$src .= "@".$pagename;
					if($addParameter!==false){
						$src .= $addParameter;
					}
				}
			}
		}
		$this->setFunction($type,"var obj".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"obj".$obj.".addEventListener(\"".$event."\", innerSrcEvent".$obj.", true);",$this->nivel);
		$this->setFunction($type,"function innerSrcEvent".$obj."(){",$this->nivel);
		$this->setFunction($type,"document.getElementById('".$objToLoad."').src = '".$src."';",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function submitFormEvent($event,$obj,$objAffected,$action,$target,$resetActionTarget){
		global $BASE_CARREGANDO_CONT;
		
		$type = "submitFormEvent".$obj;
		$this->setFunction($type,"var obj".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"obj".$obj.".addEventListener(\"".$event."\", submitFormEvent".$obj.", true);",$this->nivel);
		$this->setFunction($type,"function submitFormEvent".$obj."() {",$this->nivel);
		$this->setFunction($type,"try{",$this->nivel);
		if($BASE_CARREGANDO_CONT===false){
			$this->setFunction($type,"document.getElementById(\"baseCarregando\").style.display = \"block\";",$this->nivel+1);
		}else{
			$this->setFunction($type,"openBaseCarregando();",$this->nivel+1);
		}
		if($action!=""){
			$this->setFunction($type,"document.getElementById('".$objAffected."').action = '".$action."';",$this->nivel+1);
		}
		if($target!=""){
			$this->setFunction($type,"document.getElementById('".$objAffected."').target = '".$target."';",$this->nivel+1);
		}
		$this->setFunction($type,"document.getElementById('".$objAffected."').submit();",$this->nivel+1);
		$this->setFunction($type,"}catch(e){",$this->nivel);
		$this->setFunction($type,"alert(e);",$this->nivel);
		$this->setFunction($type,"}",$this->nivel);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function clearForm(){
		$type = "clearForm";
		$this->setFunction($type,"function clearForm(obj,clearAndSubmit){",$this->nivel);
		$this->setFunction($type,"document.getElementById(\"formPedido\").reset();",$this->nivel+1);
		$this->setFunction($type,"if(clearAndSubmit){",$this->nivel+1);
		$this->setFunction($type,"document.getElementById(obj).submit();",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function submitForm(){
		$type = "submitForm";
		$this->setFunction($type,"function submitForm(Objeto,Action){",$this->nivel);
		$this->setFunction($type,"if(Action!=''){",$this->nivel+1);
		$this->setFunction($type,"document.getElementById(Objeto).action = Action",$this->nivel+2);
		$this->setFunction($type,"}",$this->nivel+1);
		$this->setFunction($type,"document.getElementById(Objeto).submit();",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function getArrayFunction(){
		return $this->Function;
	}
	public function setInnerHtml($event,$obj,$objAffected,$html){
		$type = "setInnerHtml".$obj;
		$this->setFunction($type,"var obj".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"obj".$obj.".addEventListener(\"".$event."\", setInnerHtml".$obj.", true);",$this->nivel);
		$this->setFunction($type,"function setInnerHtml".$obj."() {",$this->nivel);
		$this->setFunction($type,"document.getElementById('".$objAffected."').innerHTML = '".$html."';",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function setPosition($event,$obj,$objAffected,$posX=0,$posY=0){
		$type = "setPosition".$obj;
		$this->setFunction($type,"var obj".$obj." = document.getElementById(\"".$obj."\");",$this->nivel);
		$this->setFunction($type,"obj".$obj.".addEventListener(\"".$event."\", setPosition".$obj.", true);",$this->nivel);
		$this->setFunction($type,"function setPosition".$obj."() {",$this->nivel);
		$this->setFunction($type,"document.getElementById('".$objAffected."').style.left = ".$posX." + 'px';",$this->nivel+1);
		$this->setFunction($type,"document.getElementById('".$objAffected."').style.top = ".$posY." + 'px';",$this->nivel+1);
		$this->setFunction($type,"}\n",$this->nivel);
	}
	public function setVisible($event="",$obj="",$objAffected="",$ns=""){
		if($event==""){
			$type = "setVisible";
			$this->setFunction($type,"try{",$this->nivel);
			$this->setFunction($type,"function setVisible(Objeto){",$this->nivel+1);
			$this->setFunction($type,"document.getElementById(Objeto).style.display = 'block';",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"}catch(e){",$this->nivel);
			$this->setFunction($type,"alert('Erro: setVisibleEvent - ' + e);",$this->nivel+1);
			$this->setFunction($type,"}\n",$this->nivel);
		}else{
			$type = "setVisible".$obj.$ns;
			$this->setFunction($type,"try{",$this->nivel);
			$this->setFunction($type,"var obj".$obj.$ns." = document.getElementById(\"".$obj."\");",$this->nivel+1);
			$this->setFunction($type,"obj".$obj.$ns.".addEventListener(\"".$event."\", setVisible".$obj.$ns.", true);",$this->nivel+1);
			$this->setFunction($type,"function setVisible".$obj.$ns."() {",$this->nivel+1);
			$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'block';",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"}catch(e){",$this->nivel);
			$this->setFunction($type,"alert('Erro: setVisible - ' + e);",$this->nivel+1);
			$this->setFunction($type,"}\n",$this->nivel);
		}
	}
	public function setInvisible($event="",$obj="",$objAffected="",$ns=""){
		if($event==""){
			$type = "setInvisible";
			$this->setFunction($type,"function setInvisible(Objeto){",$this->nivel);
			$this->setFunction($type,"document.getElementById(Objeto).style.display = 'none';",$this->nivel+1);
			$this->setFunction($type,"}\n",$this->nivel);
		}else{
			$type = "setInvisible".$obj.$ns;
			$this->setFunction($type,"var obj".$obj.$ns." = document.getElementById(\"".$obj."\");",$this->nivel);
			$this->setFunction($type,"obj".$obj.$ns.".addEventListener(\"".$event."\", setInvisible".$obj.$ns.", true);",$this->nivel);
			$this->setFunction($type,"function setInvisible".$obj.$ns."() {",$this->nivel);
			$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'none';",$this->nivel+1);
			$this->setFunction($type,"}\n",$this->nivel);
		}
	}
	public function setVisibleTogger($event="",$obj="",$objAffected="",$force=false,$ns=""){
		if($event==""){
			$type = "setVisibleTogger";
			$this->setFunction($type,"function setVisibleTogger(Objeto){",$this->nivel);
			$this->setFunction($type,"if(document.getElementById(Objeto).style.display=='block'){",$this->nivel+1);
			$this->setFunction($type,"document.getElementById(Objeto).style.display = 'none';",$this->nivel+2);
			$this->setFunction($type,"}else{",$this->nivel+1);
			$this->setFunction($type,"document.getElementById(Objeto).style.display = 'block';",$this->nivel+2);
			$this->setFunction($type,"}",$this->nivel+1);
			$this->setFunction($type,"}\n",$this->nivel);
		}else{
			$type = "setVisibleTogger".$obj.$ns;
			$this->setFunction($type,"var obj".$obj.$ns." = document.getElementById(\"".$obj."\");",$this->nivel);
			$this->setFunction($type,"obj".$obj.$ns.".addEventListener(\"".$event."\", setVisibleTogger".$obj.$ns.", true);",$this->nivel);
			$this->setFunction($type,"function setVisibleTogger".$obj.$ns."(){",$this->nivel);
			$this->setFunction($type,"if(document.getElementById('".$objAffected."').style.display=='block'){",$this->nivel+1);
			$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'none';",$this->nivel+2);
			if($force===false){
				$this->setFunction($type,"}else if(document.getElementById('".$objAffected."').style.display=='none'){",$this->nivel+1);
				$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'block';",$this->nivel+2);
				$this->setFunction($type,"}else{",$this->nivel+1);
				$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'none';",$this->nivel+2);
				$this->setFunction($type,"}",$this->nivel+1);
			}else if($force=="none"){
				$this->setFunction($type,"}else if(document.getElementById('".$objAffected."').style.display=='none'){",$this->nivel+1);
				$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'block';",$this->nivel+2);
				$this->setFunction($type,"}else{",$this->nivel+1);
				$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'none';",$this->nivel+2);
				$this->setFunction($type,"}",$this->nivel+1);
			}else if($force=="block"){
				$this->setFunction($type,"}else if(document.getElementById('".$objAffected."').style.display=='none'){",$this->nivel+1);
				$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'block';",$this->nivel+2);
				$this->setFunction($type,"}else{",$this->nivel+1);
				$this->setFunction($type,"document.getElementById('".$objAffected."').style.display = 'block';",$this->nivel+2);
				$this->setFunction($type,"}",$this->nivel+1);
			}
			$this->setFunction($type,"}\n",$this->nivel);
		}
	}
	private function setFunction($type,$Function,$nivel){
		$idFunction = count($this->Function);
		$this->Function[$idFunction]['function'] = $Function;
		$this->Function[$idFunction]['nivel'] = $nivel;
		$this->Function[$idFunction]['type'] = $type;
	}
}