<?php
class javaExe extends generic {
	private $inPage = false;
	private $text = array();
	private $e = false;
	public $show = false;
	
	function __construct($inPage=false,$father=false,$name=false,$nivel=1){
		if($inPage===true){			
			$this->inPage = true;
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
				$this->newObj($this,$this->name,"javaExe",$this->father->getName());
			}else{
				$this->nivel = $nivel;
			}
		}
	}
	
	public function inSide($text,$tab=0){
		for($i=1;$i<=$tab;$i++){
			$text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text;
		}
		$this->text[count($this->text)] = $text;
	}
	
	public function exeAny($function,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent.$function."
			</script>
		";
	
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function refreshPage($pageDest,$timeout,$parent=false){		
		global $page;
		
		if($parent===true){
			$parent = "parent.";
		}else{
			$parent = "";
		}
		$e = "<script language=\"javascript\">";
		if($timeout==0){
			$e .= $parent."document.location.href = '".$pageDest."';";
		}else{
			$e .= "setTimeout(";
			$e .= "function(){";
			$e .= $parent."document.location.href = '".$pageDest."';";
			$e .= "}";
			$e .= ",".$timeout.");";
		}
		$e .= "</script>";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function setBorder($obj,$border,$parent=false){
		global $page;
		
		if($parent!==false){
			$parent = "parent.";
		}
		
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').style.border = '".$border."';
			</script>
		";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function setBackgroundColor($obj,$color,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').style.backgroundColor = '".$color."';
			</script>
		";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function setColor($obj,$color,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').style.color = '".$color."';
			</script>
		";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function setClass($obj,$class,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').className = '".$class."';
			</script>
		";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function setFontSize($obj,$fontSize,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').style.fontSize = '".$fontSize."';
			</script>
		";
	
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function showMsg($parent=false,$obj="",$msg="",$pathCaseYes="",$pathCaseNo="",$typeButton="n",$backGroundColor=COLOR_ULTRA_DARK_RED,$id=false){
		global $page;
		
		$msg = str_replace("'", "\'", $msg);
		
		if($parent!==false){
			$parent = "parent.";
		}
		
		$e = "
		<script language=\"javascript\">
			function showMsgEvent".$obj.$id."(){
				gateShowMsg".$obj.$id." = 1;
				".$parent."document.getElementById(\"baseMsg\").style.display = \"block\";
				".$parent."document.getElementById(\"baseBaseMsg\").style.display = \"block\";
				".$parent."document.getElementById(\"baseBaseMsg\").style.backgroundColor = '".$backGroundColor."';
				".$parent."document.getElementById(\"textoMsg\").innerHTML = '".$msg."';
		";
		
		if($page->stringToUpper($typeButton)=="N"){
			$e .= "
				".$parent."document.getElementById(\"btYes\").innerHTML = \"Ok\";
				".$parent."document.getElementById(\"btNo\").innerHTML = \"Cancelar\";
			";
		}else{
			$e .= "
				".$parent."document.getElementById(\"btYes\").innerHTML = \"Sim\";
				".$parent."document.getElementById(\"btNo\").innerHTML = \"Não\";
			";
		}	
		
		$e .= "
			}
			
			var btYesShowMsg".$obj.$id." = ".$parent."document.getElementById(\"btYes\");
			btYesShowMsg".$obj.$id.".addEventListener(\"click\",function() { btYesShowMsgEvent".$obj.$id."(); }, true);
			function btYesShowMsgEvent".$obj.$id."(){
				if(gateShowMsg".$obj.$id."==1){
					gateShowMsg".$obj.$id." = 0;
		";
		
		if($pathCaseYes=="" && $pathCaseYes!==false){
			$pathCaseYes = $_SERVER['SCRIPT_NAME'];
			$e .= "
					".$parent."openBaseCarregando();
					goToPage('".$pathCaseYes."','','','','','');
			";
		}else if($pathCaseYes=="close"){
			$e .= "
					".$parent."document.getElementById(\"baseMsg\").style.display = \"none\";
					".$parent."document.getElementById(\"baseBaseMsg\").style.display = \"none\";
			";
		}else if($pathCaseYes!==false){
			$e .= "
					".$parent."openBaseCarregando();
					goToPage('".$pathCaseYes."','','','','','');
			";
		}
		
		$e .= "
				}
			}
			
			var btNoShowMsg".$obj.$id." = ".$parent."document.getElementById(\"btNo\");
			btNoShowMsg".$obj.$id.".addEventListener(\"click\",function() { btNoShowMsgEvent".$obj.$id."(); }, true);
			function btNoShowMsgEvent".$obj.$id."(){
				if(gateShowMsg".$obj.$id."==1){
					gateShowMsg".$obj.$id." = 0;
		";
		
		if($pathCaseNo==""){
			$pathCaseNo = $pathCaseYes;
			if($pathCaseNo=="" && $pathCaseNo!==false){
				$e .= "
					".$parent."openBaseCarregando();
					goToPage('".$pathCaseNo."','','','','','');
				";
			}else if($pathCaseNo=="close"){
				$e .= "
					".$parent."document.getElementById(\"baseMsg\").style.display = \"none\";
					".$parent."document.getElementById(\"baseBaseMsg\").style.display = \"none\";
				";
			}else if($pathCaseNo!==false){
				$e .= "
					".$parent."openBaseCarregando();
					goToPage('".$pathCaseNo."','','','','','');
				";
			}
		}else if($pathCaseNo=="close"){
			$e .= "
					".$parent."document.getElementById(\"baseMsg\").style.display = \"none\";
					".$parent."document.getElementById(\"baseBaseMsg\").style.display = \"none\";
			";
		}else if($pathCaseNo!==false){
			$e .= "
					".$parent."openBaseCarregando();
					goToPage('".$pathCaseNo."','','','','','');
			";
		}
		
		$e .= "
				}
			}
			showMsgEvent".$obj.$id."();\n	
		";
		
		$e .= "</script>";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
		
		/*
		$e = "
		<script language=\"javascript\">
			var gateShowMsg".$obj.$id." = 0;
			var showMsg".$obj.$id." = document.getElementById(\"".$obj."\");
			showMsg".$obj.$id.".addEventListener(\"".$event."\",function() { showMsgEvent".$obj.$id."(); }, true);
			function showMsgEvent".$obj.$id."(){
				gateShowMsg".$obj.$id." = 1;
				document.getElementById(\"baseMsg\").style.display = \"block\";
				document.getElementById(\"baseBaseMsg\").style.display = \"block\";
				document.getElementById(\"textoMsg\").innerHTML = '".$msg."';
		";
		
		if($page->stringToUpper($typeButton)==N){
			$e .= "
				document.getElementById(\"btYes\").innerHTML = \"Ok\";
				document.getElementById(\"btNo\").innerHTML = \"Cancelar\";
			";
		}else{
			$e .= "
				document.getElementById(\"btYes\").innerHTML = \"Sim\";
				document.getElementById(\"btNo\").innerHTML = \"Não\";
			";
		}	
		
		$e .= "
			}
			
			var btYesShowMsg".$obj.$id." = document.getElementById(\"btYes\");
			btYesShowMsg".$obj.$id.".addEventListener(\"click\",function() { btYesShowMsgEvent".$obj.$id."(); }, true);
			function btYesShowMsgEvent".$obj.$id."(){
				if(gateShowMsg".$obj.$id."==1){
					gateShowMsg".$obj.$id." = 0;
		";
		
		if($pathCaseYes=="" && $pathCaseYes!==false){
			$pathCaseYes = $_SERVER['SCRIPT_NAME'];
			$e .= "
					document.getElementById(\"baseCarregando\").style.display = \"block\";
					goToPage('".$pathCaseYes."','','','','','');
			";
		}else if($pathCaseYes=="close"){
			$e .= "
					document.getElementById(\"baseMsg\").style.display = \"none\";
					document.getElementById(\"baseBaseMsg\").style.display = \"none\";
			";
		}else if($pathCaseYes!==false){
			$e .= "
					document.getElementById(\"baseCarregando\").style.display = \"block\";
					goToPage('".$pathCaseYes."','','','','','');
			";
		}
		
		$e .= "
				}
			}
			
			var btNoShowMsg".$obj.$id." = document.getElementById(\"btNo\");
			btNoShowMsg".$obj.$id.".addEventListener(\"click\",function() { btNoShowMsgEvent".$obj.$id."(); }, true);
			function btNoShowMsgEvent".$obj.$id."(){
				if(gateShowMsg".$obj.$id."==1){
					gateShowMsg".$obj.$id." = 0;
		";
		
		if($pathCaseNo==""){
			$pathCaseNo = $pathCaseYes;
			if($pathCaseNo=="" && $pathCaseNo!==false){
				$e .= "
					document.getElementById(\"baseCarregando\").style.display = \"block\";
					goToPage('".$pathCaseNo."','','','','','');
				";
			}else if($pathCaseNo=="close"){
				$e .= "
					document.getElementById(\"baseMsg\").style.display = \"none\";
					document.getElementById(\"baseBaseMsg\").style.display = \"none\";
				";
			}else if($pathCaseNo!==false){
				$e .= "
					document.getElementById(\"baseCarregando\").style.display = \"block\";
					goToPage('".$pathCaseNo."','','','','','');
				";
			}
		}else if($pathCaseNo=="close"){
			$e .= "
					document.getElementById(\"baseMsg\").style.display = \"none\";
					document.getElementById(\"baseBaseMsg\").style.display = \"none\";
			";
		}else if($pathCaseNo!==false){
			$e .= "
					document.getElementById(\"baseCarregando\").style.display = \"block\";
					goToPage('".$pathCaseNo."','','','','','');
			";
		}
		
		$e .= "
				}
			}\n
		";
		
		$e .= "</script>";
		*/
	}
	
	public function invisible($obj,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').style.display = 'none';
			</script>
		";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function updateCore($core,$byCoreAndress=true,$addParameter=false,$parent=true){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
		
		if($page->stringToUpper($core)=="THIS"){
			$e = "
				<script language=\"javascript\">
					".$parent."openBaseCarregando();
					document.src = '".THIS."' + '".$addParameter."';
				</script>
			";
		}else if($byCoreAndress===true){
			$e = "
				<script language=\"javascript\">
					".$parent."openBaseCarregando();
			";
			if($page->session->getSession("coreAddParameter".$core."0")){
				$e .= "
					".$parent."document.getElementById('objCore".$core."0').src = '".$page->session->getSession("coreAndress".$core."0")."' + '?' + '".$page->session->getSession("coreAddParameter".$core."0")."';
				";
			}else{
				$e .= "
					".$parent."document.getElementById('objCore".$core."0').src = '".$page->session->getSession("coreAndress".$core."0")."';
				";
			}
			$e .= "
				</script>
			";
		}else{		
			$e = "
				<script language=\"javascript\">
					".$parent."openBaseCarregando();
					".$parent."document.getElementById('objCore".$core."0').src = ".$parent."document.getElementById('objCore".$core."0').src + '".$addParameter."';
				</script>
			";
		}
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
		
		$eA = $e;
		
		$this->show($eA);
	}
	
	public function reloadComboBox($obj,$arrayValue,$selectedIndex=false,$parent=false){
		global $page;
		
		if($parent!==false){
			$parent = "parent.";
		}
		
		$e = "
			<script language=\"javascript\">
				var obj".$obj." = ".$parent."document.getElementById('".$obj."');
				while (obj".$obj.".length > 0) {
					obj".$obj.".remove(obj".$obj.".length-1);
				}
		";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
		
		$eA = $e;
		
		foreach ($arrayValue as $key => $value){
			$checked = false;

			if(is_array($selectedIndex)){
				foreach($selectedIndex as $k => $v){
					if($v==$value['value']){
						$checked = true;
					}
				}
			}

			$e = "
				var option = ".$parent."document.createElement(\"option\");
				option.text = '".$value['text']."';	
				option.value = '".$value['value']."';
				".($checked ? "option.selected = 'selected';" : "")."
				obj".$obj.".add(option, obj".$obj."[".$key."]);
			";
			
			if($this->inPage===false){
				$page->e($e);
			}else{
				$this->inSide($e);
			}
			
			$eA .= $e;
		}
		
		$e = "
			</script>
		";
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
		
		$eA .= $e;
		
		$this->show($eA);
		
		if(!is_array($selectedIndex)){
			$this->selectedIndexComboBox($obj,$selectedIndex,$parent);
		}
	}
	
	public function show($e){
		global $page;
		
		if($this->show!==false){
			if($this->inPage===false){
				$page->e("<textarea style=\"width:200px;height:400px\">".$e."</textarea>");
			}
		}
	}
	
	public function selectedIndexComboBox($obj,$selectedIndex=false,$parent=false,$bySelectedIndex=true){
		global $page;
		
		if($parent!==false){
			$parent = "parent.";
		}
	
		if(is_int($selectedIndex)){
			if($bySelectedIndex===true){
				$e = "
					<script language=\"javascript\">
						var obj".$obj." = ".$parent."document.getElementById('".$obj."');
						obj".$obj.".selectedIndex = \"".$selectedIndex."\";
					</script>
				";
			}else{
				$e = "
					<script language=\"javascript\">
						var obj".$obj." = ".$parent."document.getElementById('".$obj."');
						obj".$obj.".value = \"".$selectedIndex."\";
					</script>
				";
			}
			
			if($this->inPage===false){
				$page->e($e);
			}else{
				$this->inSide($e);
			}
			
			$eA = $e;
				
			$this->show($eA);
		}else{
			$e = "
				<script language=\"javascript\">
					var obj".$obj." = ".$parent."document.getElementById('".$obj."');
					var totalOptionsObj".$obj." = obj".$obj.".length;
					var selectedItem = 0;
					for (i = 0; i < totalOptionsObj".$obj."; i++) {
						if(obj".$obj.".options[i].value=='".$selectedIndex."'){
							selectedItem = i;
							break;
						}
					}
					obj".$obj.".selectedIndex = selectedItem;
				</script>
			";

			if($this->inPage===false){
				$page->e($e);
			}else{
				$this->inSide($e);
			}
			
			$eA = $e;
			
			$this->show($eA);
		}
	}
	
	public function src($obj,$src,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').src = '".$src."';
			</script>
		";

		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function value($obj,$value,$parent=false,$innerHTML=false,$addslashes=true){
		global $page;
		
		if($addslashes===true){
			$value = addslashes($value);
		}
		
		if($parent!==false){
			$parent = "parent.";
		}
		
		if($innerHTML===false){
			$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').value = '".$value."';
			</script>	
			";
		}else{
			$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').innerHTML = '".$value."';
			</script>
			";
		}

		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function readOnly($obj,$parent=false,$isComboBox=false){
		global $page;
		
		if($parent!==false){
			$parent = "parent.";
		}
	
		if($isComboBox===false){
			$e = "
				<script language=\"javascript\">
					".$parent."document.getElementById('".$obj."').readOnly = true;
				</script>
			";
		}else{
			$e = "
				<script language=\"javascript\">
					".$parent."document.getElementById('".$obj."').disabled = true;
				</script>
			";
		}
		
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function unSetReadOnly($obj,$parent=false,$isComboBox=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		if($isComboBox===false){
			$e = "
				<script language=\"javascript\">
					".$parent."document.getElementById('".$obj."').readOnly = false;
				</script>
			";
		}else{
			$e = "
				<script language=\"javascript\">
					".$parent."document.getElementById('".$obj."').disabled = false;
				</script>
			";
		}
	
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function valueCopy($objOrigem,$objDest,$parent=false,$origemInnerHTML=false,$destInnerHTML=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
		";
		
		if($origemInnerHTML===false){
			$e .= "
				var tmp = ".$parent."document.getElementById('".$objOrigem."').value;
			";
		}else{
			$e .= "
				var tmp = ".$parent."document.getElementById('".$objOrigem."').innerHTML;
			";
		}
		
		if($destInnerHTML===false){
			$e .= "
				".$parent."document.getElementById('".$objDest."').value = tmp;
			";
		}else{
			$e .= "
				".$parent."document.getElementById('".$objDest."').innerHTML = tmp;
			";
		}
		
		$e .= "
			</script>
		";
	
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function valueReplace($obj,$searched,$valueReplace,$parent=false,$innerHTML=false,$addslashes=true){
		global $page;
	
		if($addslashes===true){
			$valueReplace = addslashes($valueReplace);
		}
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		if($innerHTML===false){
			$e = "
			<script language=\"javascript\">
				var temp = ".$parent."document.getElementById('".$obj."').value;
				".$parent."document.getElementById('".$obj."').value = temp.replace(\"".$searched."\",\"".$valueReplace."\");
			</script>
			";
		}else{
			$e = "
			<script language=\"javascript\">
				var temp = ".$parent."document.getElementById('".$obj."').innerHTML;
				".$parent."document.getElementById('".$obj."').innerHTML = temp.replace(\"".$searched."\",\"".$valueReplace."\");
			</script>
			";
		}
	
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function visible($obj,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').style.display = 'block';
			</script>
		";

		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function focus($obj,$parent=false){
		global $page;
	
		if($parent!==false){
			$parent = "parent.";
		}
	
		$e = "
			<script language=\"javascript\">
				".$parent."document.getElementById('".$obj."').focus();
			</script>
		";
	
		if($this->inPage===false){
			$page->e($e);
		}else{
			$this->inSide($e);
		}
	}
	
	public function End(){
		for($i=0;$i<count($this->text);$i++){
			$this->e($this->text[$i],$this->nivel + 1);
		}
	}
}