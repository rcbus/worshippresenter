<?php
# TIME
class time extends generic {
	private $arraySemana = array("","D","S","T","Q","Q","S","S");
	private $father;
	private $subLayer;
	private $title;
	private $java;
	private $javaB;
	private $javaC;
	private $javaD;
	private $base;
	private $error = false;
	private $tb;
	private $tbHidden;
	private $column;
	private $withOutTime = false;
	private $loadJava = true;
	private $loadCss = true;
	private $hourDefault;
	private $minuteDefault;
	private $secondDefault;
	private $dayDefault;
	private $monthDefault;
	private $yearDefault;
	private $resetAutoSave = false;
	private $readOnly = false;
	private $money = false;
	private $number = false;
	private $uppercase = true;
	private $autoCompleteOff = true;
	public $css;
	
	public function getNumber(){
		return $this->number;
	}
	
	function __construct($father,$name,$title=false,$withOutTime=false,$hourDefault=12,$minuteDefault=30,$secondDefault=0,$dayDefault=false,$monthDefault=false,$yearDefault=false,$subLayer=0,$nivel=0){
		$this->father = $father;
		$this->subLayer = $subLayer;
		$this->type = "table";
		if($this->father!==false){
			$this->layer = $this->father->getFatherLayer();
			$this->nivel = $this->father->getNivel();
			$this->table = $this->father->getTable();
			$this->formName = $this->father->getFormName();
			$this->uppercase = $this->father->getUpperCase();
			$this->autoCompleteOff = $this->father->getAutocompleteOff();
			# NUNCA DESCOMENTAR ESSES 2 PROCEDIMENTOS POIS CAUSA PROBLEMAS
			# $this->loadJava = $this->father->getLoadJava();
			# $this->loadCss = $this->father->getLoadCss();
			# FIM - NUNCA DESCOMENTAR ESSES 2 PROCEDIMENTOS POIS CAUSA PROBLEMAS
		}else{
			$this->nivel = $nivel;
		}
		$this->name = $name;
		$this->title = $title;
		$this->withOutTime = $withOutTime;
		$this->hourDefault = $hourDefault;
		$this->minuteDefault = $minuteDefault;
		$this->secondDefault = $secondDefault;
		if($dayDefault!==false){
			$this->dayDefault = $dayDefault;
		}else{
			$this->dayDefault = date("d");
		}
		if($monthDefault!==false){
			$this->monthDefault = $monthDefault;
		}else{
			$this->monthDefault = date("n");
		}
		if($yearDefault!==false){
			$this->yearDefault = $yearDefault;
		}else{
			$this->yearDefault = date("Y");
		}
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		$this->javaB = new java();
		$this->newObj($this->javaB,"JAVAB_".$this->name,"java",$this->name);
		$this->javaC = new java();
		$this->newObj($this->javaC,"JAVAC_".$this->name,"java",$this->name);
		$this->javaD = new java();
		$this->newObj($this->javaD,"JAVAD_".$this->name,"java",$this->name);
		$this->newObj($this,$this->name,"defineTime",$this->father->getName());
		$this->css->position("relative");
		
		global $PATH;
		global $page;
		global $PAGENAME;
		
		# DEFINE AÇÃO DO JAVA
		$this->java->setOnClick();
		$this->java->setFunctionGoToPage(THIS,"MES_".$this->name,false,false,"@".$PAGENAME."&DOI_".$this->name."=1@".$PAGENAME,false);
		$this->javaB->setOnClick();
		$this->javaB->setFunctionGoToPage(THIS,"DIA_ESCOLHIDO_".$this->name,false,false,"@".$PAGENAME."&VERSAO_ANO".$this->name."=@".$PAGENAME,false);
		$this->javaC->setOnClick();
		$this->javaC->setFunctionGoToPage(THIS,"VERSAO_ANO".$this->name,false,false,"@".$PAGENAME,false);
		$this->javaD->setOnClick();
		$this->javaD->setFunctionGoToPage(THIS,"ANO_".$this->name,false,false,"@".$PAGENAME."&DOI_".$this->name."=1@".$PAGENAME,false);
		# FIM - DEFINE AÇÃO DO JAVA
		
		# CARREGAMENTO INICIAL SE TIVER
		if($page->session->getSession("TIME_COMP_".$this->name,$PAGENAME) && $page->session->getSession("DOI_".$this->name,$PAGENAME)!=1){
			$tempoCompilado = $page->session->getSession("TIME_COMP_".$this->name,$PAGENAME);
			$page->session->setSession("ANO_SEL_".$this->name,date("Y",$tempoCompilado),$PAGENAME);
			$page->session->setSession("MES_SEL_".$this->name,date("n",$tempoCompilado),$PAGENAME);
			$page->session->setSession("DIA_SEL_".$this->name,date("d",$tempoCompilado),$PAGENAME);
			$page->session->setSession("HORA_SEL_".$this->name,date("H",$tempoCompilado),$PAGENAME);
			$page->session->setSession("MIN_SEL_".$this->name,date("i",$tempoCompilado),$PAGENAME);
			# ANO
			if(!$page->session->getSession("ANO_".$this->name,$PAGENAME)){
				$page->session->setSession("ANO_".$this->name,date("Y",$tempoCompilado),$PAGENAME);
			}
			# MÊS
			if(!$page->session->getSession("MES_".$this->name,$PAGENAME) && $page->session->getSession("MES_".$this->name,$PAGENAME)!=-1){
				$page->session->setSession("MES_".$this->name,date("n",$tempoCompilado),$PAGENAME);
			}
		}else if($page->session->getSession("DOI_".$this->name,$PAGENAME)!=1){
			$page->session->unSetSession("ANO_SEL_".$this->name,$PAGENAME);
			$page->session->unSetSession("MES_SEL_".$this->name,$PAGENAME);
			$page->session->unSetSession("DIA_SEL_".$this->name,$PAGENAME);
			$page->session->unSetSession("HORA_SEL_".$this->name,$PAGENAME);
			$page->session->unSetSession("MIN_SEL_".$this->name,$PAGENAME);
		}
		# FIM - CARREGAMENTO INICIAL SE TIVER
		
		# ANO
		if(!$page->session->getSession("ANO_".$this->name,$PAGENAME)){
			$page->session->setSession("ANO_".$this->name,$this->yearDefault,$PAGENAME);
		}
		$ano = $page->session->getSession("ANO_".$this->name,$PAGENAME);
		# FIM - ANO
		
		# MÊS
		if(!$page->session->getSession("MES_".$this->name,$PAGENAME) && $page->session->getSession("MES_".$this->name,$PAGENAME)!=-1){
			$page->session->setSession("MES_".$this->name,$this->monthDefault,$PAGENAME);
		}else if($page->session->getSession("MES_".$this->name,$PAGENAME)==-1){
			$page->session->setSession("MES_".$this->name,12,$PAGENAME);
			$page->session->setSession("ANO_".$this->name,($ano-1),$PAGENAME);
			$ano = $page->session->getSession("ANO_".$this->name,$PAGENAME);
		}else if($page->session->getSession("MES_".$this->name,$PAGENAME)==13){
			$page->session->setSession("MES_".$this->name,1,$PAGENAME);
			$page->session->setSession("ANO_".$this->name,($ano+1),$PAGENAME);
			$ano = $page->session->getSession("ANO_".$this->name,$PAGENAME);
		}
		$mes = $page->session->getSession("MES_".$this->name,$PAGENAME);
		# FIM - MÊS
		
		if($this->withOutTime===true){
			$page->session->setSession("HORA_SEL_".$this->name,"0",$PAGENAME);
			$page->session->setSession("MIN_SEL_".$this->name,"0",$PAGENAME);
		}
		
		# HORA E MINUTO
		if(!$page->session->getSession("HORA_SEL_".$this->name,$PAGENAME) && $page->session->getSession("HORA_SEL_".$this->name,$PAGENAME)!="0"){
			$page->session->setSession("HORA_SEL_".$this->name,$this->hourDefault,$PAGENAME);
		}
		$hora = $page->session->getSession("HORA_SEL_".$this->name,$PAGENAME);
		if(!$page->session->getSession("MIN_SEL_".$this->name,$PAGENAME) && $page->session->getSession("MIN_SEL_".$this->name,$PAGENAME)!="0"){
			$page->session->setSession("MIN_SEL_".$this->name,$this->minuteDefault,$PAGENAME);
		}
		$min = $page->session->getSession("MIN_SEL_".$this->name,$PAGENAME);
		if(!$page->session->getSession("SEC_SEL_".$this->name,$PAGENAME) && $page->session->getSession("SEC_SEL_".$this->name,$PAGENAME)!="0"){
			$page->session->setSession("SEC_SEL_".$this->name,$this->secondDefault,$PAGENAME);
		}
		$sec = $page->session->getSession("SEC_SEL_".$this->name,$PAGENAME);
		# FIM - HORA E MINUTO
		
		# DIA ESCOLHIDO
		if(!$page->session->getSession("DIA_SEL_".$this->name,$PAGENAME)){
			$page->session->setSession("DIA_SEL_".$this->name,$this->dayDefault,$PAGENAME);
			$page->session->setSession("MES_SEL_".$this->name,$this->monthDefault,$PAGENAME);
			$page->session->setSession("ANO_SEL_".$this->name,$this->yearDefault,$PAGENAME);
		}
		if($page->session->getSession("DIA_ESCOLHIDO_".$this->name,$PAGENAME)){
			$timestampEscolhido = $page->session->getSession("DIA_ESCOLHIDO_".$this->name,$PAGENAME);
			$page->session->setSession("DIA_SEL_".$this->name,date("d",$timestampEscolhido),$PAGENAME);
			$page->session->setSession("MES_SEL_".$this->name,date("n",$timestampEscolhido),$PAGENAME);
			$page->session->setSession("ANO_SEL_".$this->name,date("Y",$timestampEscolhido),$PAGENAME);
			$page->session->unSetSession("DIA_ESCOLHIDO_".$this->name,$PAGENAME);
		}
		$diaSel = $page->session->getSession("DIA_SEL_".$this->name,$PAGENAME);
		$mesSel = $page->session->getSession("MES_SEL_".$this->name,$PAGENAME);
		$anoSel = $page->session->getSession("ANO_SEL_".$this->name,$PAGENAME);
		# FIM - DIA ESCOLHIDO
		
		#$min = 44;
		# COMPILADOR TIMESTAMP
		$tempoCompilado = mktime($hora,$min,$sec,$mesSel,$diaSel,$anoSel);
		$page->session->setSession("TIME_COMP_".$this->name,$tempoCompilado,$PAGENAME);
		# FIM - COMPILADOR TIMESTAMP
		
		# FORM BASE
		$lytC = new table($this, "lytC".$this->name,"",0);
		
		$lytC->newLine();
		$lytC->newCell();
		$lytC->inSideBoldCell($this->title."<br>");
		
		$this->tbHidden = new textBox($lytC->getCellObj(), "tbHiddenBase".$this->name);
		$this->tbHidden->setValue($tempoCompilado);
		$this->tbHidden->css->setInvisible();
		
		$this->tb = new textBox($lytC->getCellObj(), "tbBase".$this->name);
		$this->tb->setAsNotRequired();
		if($this->withOutTime===false){
			$this->tb->setValue(date("d/m/Y H:i",$tempoCompilado));
		}else{
			$this->tb->setValue(date("d/m/Y",$tempoCompilado));
		}
		$this->tb->css->width(209);
		#$this->tb->css->height(19);
		$this->tb->css->textAlign("center");
		$this->tb->setReadOnly();
		$this->tb->css->cursor();
		$this->tb->java->setObjVisibleTogger("click", "tbBase".$this->name, "baseTimeSystem".$this->name);
				
		# BASE DO SISTEMA DE TEMPO
		$lytC->newLine();
		$lytC->newCell();
		$base = new space($lytC->getCellObj(),"baseTimeSystem".$this->name);
		$base->css->position("absolute");
		$base->css->marginTop(20);
		$base->css->zIndex(5000);
		$base->css->boxShadow(1,2,10,COLOR_BLACK);
		$base->css->width(225);
		if(!$page->session->getSession("DOI_".$this->name,$PAGENAME)){
			$base->css->setInvisible();
		}else{
			$base->css->setVisible();
			$page->session->unSetSession("DOI_".$this->name,$PAGENAME);
		}
		
		# CRIA A TABELA
		$lyt = new table($base, "lyt".$this->name,"",0);
		$lyt->css->width(225);
		
		# TITULO
		if($this->title!==false){
			$lyt->lineNoObj();
			$lyt->cellNoObj("stlLytData stlLytDataCellC","","center","",7);
			$lyt->inSideBoldCellNoObj($this->title);
		}
		# FIM - TITULO		
		
		if(!$page->session->getSession("VERSAO_ANO".$this->name,$PAGENAME)){
			$lyt->lineNoObj();
			if($mes>1){
				$command = $this->java->getLineCommand(($mes-1));
			}else{
				$command = $this->java->getLineCommand(-1);
			}
			$lyt->cellNoObj("stlLytData stlLytDataCellC",false,"center",false,false,false,false,false,$command);
			$lyt->inSideBoldCellNoObj("<");
			
			$commandC = $this->javaC->getLineCommand("1@".$PAGENAME."&DOI_".$this->name."=1");
			$lyt->cellNoObj("stlLytData stlLytDataCellC","","center","",5,false,false,false,$commandC);
			$lyt->inSideBoldCellNoObj($this->getMes($mes,"NORMAL")."/".$ano);
			
			$command = $this->java->getLineCommand(($mes+1));
			$lyt->cellNoObj("stlLytData stlLytDataCellC",false,"center",false,false,false,false,false,$command);
			$lyt->inSideBoldCellNoObj(">");
		}else{
			$lyt->lineNoObj();
			$commandD = $this->javaD->getLineCommand(($ano-1));
			
			$lyt->cellNoObj("stlLytData stlLytDataCellC",false,"center",false,false,false,false,false,$commandD);
			$lyt->inSideBoldCellNoObj("<");
			
			$commandC = $this->javaC->getLineCommand("0@".$PAGENAME."&DOI_".$this->name."=1");
			$lyt->cellNoObj("stlLytData stlLytDataCellC","","center","",4,false,false,false,$commandC);
			$lyt->inSideBoldCellNoObj($ano);
			
			$commandD = $this->javaD->getLineCommand(($ano+1));
			$lyt->cellNoObj("stlLytData stlLytDataCellC",false,"center",false,false,false,false,false,$commandD);
			$lyt->inSideBoldCellNoObj(">");
		}
		# FIM - MÊS
		
		if(!$page->session->getSession("VERSAO_ANO".$this->name,$PAGENAME)){
			$firstDay = $this->getFirstDayMes($mes,$ano);
			$weekDayFirstDay = $this->getWeekDay($firstDay);
			#$lyt->inSideCellNoObj("<br><br><br><br><br><br><br><br>D: ".$weekDayFirstDay);
			
			if($weekDayFirstDay==1){
				$nextDay = $firstDay - (86400 * ($weekDayFirstDay + 7));
			}else{
				$nextDay = $firstDay - (86400 * ($weekDayFirstDay - 1));
			}
			
			$cont = 0;
			for($i=1;$i<=7;$i++){
				$lyt->lineNoObj();
				for($j=1;$j<=7;$j++){
					if($i==1){
						$lyt->cellNoObj("stlLytData stlLytDataCellC");
						$lyt->inSideBoldCellNoObj($this->arraySemana[$j]);
					}else{
						if($weekDayFirstDay==1){
							$nextDay = $firstDay - (86400 * ($weekDayFirstDay + 6)) + ($cont * 86400);
						}else{
							$nextDay = $firstDay - (86400 * ($weekDayFirstDay - 1)) + ($cont * 86400);
						}
						$classAdd = "";
						if(date("d/n",$nextDay)==date("d/n",$tempoCompilado)){
							$classAdd = " stlLytDataCellD";
						}
						if(date("n",$nextDay)==date("n",$firstDay)){
							$commandB = $this->javaB->getLineCommand((mktime($hora,$min,$sec,date("n",$nextDay),date("d",$nextDay),$ano)));
							if(date("d/n",$nextDay)!=date("d/n")){
								$lyt->cellNoObj("stlLytData stlLytDataCellB".$classAdd,false,"center",false,false,false,false,false,$commandB);
							}else{
								$lyt->cellNoObj("stlLytData stlLytDataHoje".$classAdd,false,"center",false,false,false,false,false,$commandB);
							}
							$lyt->inSideBoldCellNoObj(date("d",$nextDay));
						}else{
							$commandB = $this->javaB->getLineCommand((mktime($hora,$min,$sec,date("n",$nextDay),date("d",$nextDay),$ano)));
							if(date("d/n",$nextDay)!=date("d/n")){
								$lyt->cellNoObj("stlLytData stlLytDataCellA".$classAdd,false,"center",false,false,false,false,false,$commandB);
							}else{
								$lyt->cellNoObj("stlLytData stlLytDataHoje".$classAdd,false,"center",false,false,false,false,false,$commandB);
							}
							$lyt->inSideCellNoObj(date("d",$nextDay));
						}
						$cont++;
					}
				}
			}
		}else{
			$firstDay = $this->getFirstDayMes($mes,$ano);
			$weekDayFirstDay = $this->getWeekDay($firstDay);
				
			if($weekDayFirstDay==1){
				$nextDay = $firstDay - (86400 * ($weekDayFirstDay + 7));
			}else{
				$nextDay = $firstDay - (86400 * ($weekDayFirstDay - 1));
			}
				
			$cont = 0;
			$vez = 1;
			for($i=1;$i<=5;$i++){
				$lyt->lineNoObj();
				for($j=1;$j<=6;$j++){
					if($i==1){
						$lyt->cellNoObj("stlLytData stlLytDataCellC","","","");
					}else if($i!=1){
						if($vez==1){
							$vez = $vez * (-1);
							$cont++;
							$commandB = $this->javaB->getLineCommand((mktime($hora,$min,$sec,$cont,date("d",$diaSel),$ano))."@".$PAGENAME."&DOI_".$this->name."=1@".$PAGENAME."&MES_".$this->name."=".$cont);
							$lyt->cellNoObj("stlLytData stlLytDataCellB",false,"center",false,2,false,false,false,$commandB);
							$lyt->inSideBoldCellNoObj($this->getMes($cont));
						}else{
							$vez = $vez * (-1);
						}
					}
				}
			}
		}
		
		# AJUSTE DE HORARIO
		$lytB = new table($base, "lytB".$this->name,"",0);
		$lytB->css->backGroundColor(COLOR_DARK_BLUE);
		$lytB->css->color(COLOR_WHITE);
		
		if($this->withOutTime===false){			
			$lytB->newLine();
			$lytB->newCell("",42,"center");
			$lytB->newCell("",70,"center");
			$padBot = 40;
			$lytB->obj->css->paddingBottom($padBot);
			$lytB->inSideBoldCell("<br>Hora<br>");
			$cb = new comboBox($lytB->getCellObj(), "cbHora".$this->name);
			for($i=0;$i<=23;$i++){
				$cb->setOption($i,$this->zeroLeft($i));
			}
			$cb->setSelectedIndex($page->session->getSession("HORA_SEL_".$this->name,$PAGENAME));
			$cb->java->setGoToPage("change", "cbHora".$this->name,THIS,"HORA_SEL_".$this->name,"this","","@".$PAGENAME."&DOI_".$this->name."=1@".$PAGENAME);
			
			$lytB->newCell("",70,"center");
			$lytB->obj->css->paddingBottom($padBot);
			$lytB->inSideBoldCell("<br>Minuto<br>");
			$cb = new comboBox($lytB->getCellObj(), "cbMin".$this->name);
			for($i=0;$i<=59;$i++){
				$cb->setOption($i,$this->zeroLeft($i));
			}
			$cb->setSelectedIndex($page->session->getSession("MIN_SEL_".$this->name,$PAGENAME));
			$cb->java->setGoToPage("change", "cbMin".$this->name,THIS,"MIN_SEL_".$this->name,"this","","@".$PAGENAME."&DOI_".$this->name."=1@".$PAGENAME);
			
			$lytB->newCell("",42,"center");
		}
		
		$lytB->newLine();
		$lytB->newCell("","","","",4);
		$bt = new button($lytB->getCellObj(), "btConcluir".$this->name, "Concluído");
		$bt->css->width(201);
		$bt->css->marginRight(0);
		$bt->css->marginTop(0);
		$bt->css->radius(0);
		$bt->java->setObjInvisible("click", "btConcluir".$this->name, "baseTimeSystem".$this->name);
		# FIM - AJUSTE DE HORARIO
		##### FIM - TESTE #####
	}
	
	public function getAutocompleteOff(){
		return $this->autoCompleteOff;
	}
	
	public function getMoney(){
		return $this->money;
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
	
	public function getLoadCss(){
		return $this->loadCss;
	}
	
	public function getLoadJava(){
		return $this->loadJava;
	}
	
	public function getTimestamp(){
		global $page;
		global $PAGENAME;
		
		return $page->session->getSession("TIME_COMP_".$this->name,$PAGENAME);
	}
	
	public function getRequired(){
		return false;
	}
	
	public function getUnique(){
		return false;
	}
	
	public function getTypeColumn(){
		return $this->typeColumn;
	}
		
	public function setColumn($column){
		$this->column = $column;
		$this->tbHidden->setColumn($column);
	}
	
	public function getColumn(){
		return $this->column;
	}
	
	public function setDisabled(){
		$this->tb->setDisabled();
	}
	
	public function reset($time=false){
		global $page;
		global $PAGENAME;
		
		if($time===false || strlen($time)==0 || $time==0){
			$novoTime = mktime(date("H")+1,date("i"),date("s"),date("n"),date("d"),date("Y"));
		}else{
			$novoTime = $time;
		}
		
		$page->session->setSession("TIME_COMP_".$this->name,$novoTime,$PAGENAME);
		$page->session->setSession("ANO_".$this->name,date("Y",$novoTime),$PAGENAME);
		$page->session->setSession("MES_".$this->name,date("n",$novoTime),$PAGENAME);
		$page->session->setSession("HORA_".$this->name,date("H",$novoTime),$PAGENAME);
		$page->session->setSession("MIN_".$this->name,0,$PAGENAME);
		$page->session->unSetSession("DIA_SEL_".$this->name,$PAGENAME);
		$page->session->unSetSession("MES_SEL_".$this->name,$PAGENAME);
		$page->session->unSetSession("ANO_SEL_".$this->name,$PAGENAME);
		$page->session->unSetSession("DIA_ESCOLHIDO_".$this->name,$PAGENAME);
		
		$page->goToPage(THIS);
	}
	
	public function setValue($value,$onlyOne=true){
		global $page;
		global $PAGENAME;
		
		if($onlyOne===false || ($onlyOne===true && !$page->session->getSession("FIRST_SET_VALUE",$PAGENAME))){
			if($onlyOne===true){
				$page->session->setSession("FIRST_SET_VALUE","1",$PAGENAME);
			}
			$page->session->setSession("TIME_COMP_".$this->name,$value,$PAGENAME);
			$tempoCompilado = $page->session->getSession("TIME_COMP_".$this->name,$PAGENAME);
			$page->session->setSession("HORA_SEL_".$this->name,date("H",$tempoCompilado),$PAGENAME);
			$page->session->setSession("MIN_SEL_".$this->name,date("i",$tempoCompilado),$PAGENAME);
			$page->session->setSession("DIA_SEL_".$this->name,date("d",$tempoCompilado),$PAGENAME);
			$page->session->setSession("MES_SEL_".$this->name,date("n",$tempoCompilado),$PAGENAME);
			$page->session->setSession("ANO_SEL_".$this->name,date("Y",$tempoCompilado),$PAGENAME);
			$objCbHora = $this->getObj("cbHora".$this->name);
			$objCbHora->setSelectedIndex(date("H",$tempoCompilado));
			$objCbMin = $this->getObj("cbMin".$this->name);
			$objCbMin->setSelectedIndex(date("i",$tempoCompilado));
			$this->tbHidden->setValue($tempoCompilado);
			if($this->withOutTime===false){
				$this->tb->setValue(date("d/m/Y H:i",$tempoCompilado));
			}else{
				$this->tb->setValue(date("d/m/Y",$tempoCompilado));
			}
		}
		
	}
	
	public function setFunctionSetValueLock(){
		$this->tbHidden->setFunctionSetValueLock();
	}
	
	public function setError($error=true){
		$this->error = $error;
		$this->tb->css->backGroundColor(COLOR_LIGHT_RED);
	}
	
	public function End(){		
		$this->endObj($this->name);
	}
}