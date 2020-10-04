<?php
# Form

/*

@@@ CONFIGURAÇÃO INICIAL @@@

$form = new iForm($corpo, "formProcedimento");
$form->setDataSet($idsa, "procedimento");

@@@ FIM - CONFIGURAÇÃO INICIAL @@@



@@@ MODO DE USAR PARA INSERT @@@

if(cadastrar){
    $form->setInsert("dataCriacao", time());
    $form->setInsert("dataModificacao", time());
    $form->setInsert("historico", $page->getHistText());
    $form->setInsert("filial", $page->session->getLoginFilial());
    $form->setInsert("usuario", $page->session->getLoginId());
    $resForm = $form->exeFormInsert(true,false,$lyt);
 
    if($resForm===false){
        showMsgNovo("Houve uma falha ao tentar cadastrar o procedimento!".$form->getMsgErro(),"close");
    }else if($resForm===true){
 	   $page->session->setSession("action","modificar",$PAGENAME);
	   $page->session->setSession("PROCEDIMENTO_ID",$form->getNewId(),$PAGENAME);
 	   refreshShowMsg(THIS,"Procedimento cadastrado com sucesso!","close");
    }
}

@@@ FIM - MODO DE USAR PARA INSERT @@@



@@@ MODO DE USAR PARA UPDATE @@@

if(modificar){
    $form->setRow($row);
    $form->exeFillForm(false,$lyt);
 
    $form->setColumn("dataModificacao", time());
    $form->setColumn("historico", $page->getHistText("m",$row['historico']));
    $form->setWhereUpdate("idProcedimento", "=", $page->session->getSession("PROCEDIMENTO_ID",$PAGENAME));
    $resForm = $form->exeFormUpdate(true,false,$lyt);
 
    if($resForm===false){
 	    showMsgNovo("Houve uma falha ao tentar alterar o procedimento!".$form->getMsgErro(),"close");
    }else if($resForm===true){
   	    refreshShowMsg(THIS,"Procedimento alterado com sucesso!","close");
    }
}

@@@ FIM - MODO DE USAR PARA UPDATE @@@

*/


$RESET_AUTOSAVE = false;

define("msgErro1","Os campos destacados são de preenchimento obrigatório!");
define("msgErro2","Os campos destacados são inválidos!");
define("msgErro3","Já existe um cadastro com esses dados!");
define("msgErro4","Os campos destacados precisam ser mais detalhados!");
define("msgErro5","Falha interna, falta de where do update!");
# O DIFINE 6 É PARA ERRO RETORNADO PELO MYSQL

class iForm extends generic {
	private $line;
	private $lines;
	private $cells;
	private $spaceBetweenCells;
	private $spaceBetweenLines;
	private $obj;
	private $subLayer;
	private $father;
	private $method;
	private $action;
	private $target;
	private $resultAuthenticate = false;
	private $resultInsert = false;
    private $resultUpdate = false;
	private $row = false;
	private $numErrors;
	private $sql;
	private $errorForm = 0;
	private $msgError;
    private $hidden;
    private $column;
    private $disabled;
    private $whereUpdate;
    private $operatorUpdate;
    private $valueUpdate;
    private $newId;
    private $objAction;
    private $autoCompleteOff = true;
    private $exeInsert = false;
    private $exeUpdate = false;
    private $columnsMathColumn = array();
    private $columnsMathType = array();
    private $columnsMathBy = array();
    private $loadJava = true;
    private $loadCss = true;
    private $resetAutoSave = false;
    private $readOnly = false;
    private $uppercase = true;
    private $iMsgErro = array();
    private $historic = false;
    private $autoBuildColumns = array();
    private $autoBuildButtons = array();
    private $id = false;
    private $groupIns = "cadastrar";
    private $groupUpd = "modificar";
    private $groupDes = "desativado";
    private $status = false;
    private $listName = false;
    private $panel = false;
    private $autoBuildButtonCancel = array("func" => "setGoToPanel","panel" => "c0");
    private $titleDivision = false;
    public $backGroundColorError = "rgb(210,80,80)";
	public $css;
	public $java;
	public $dataSet;
	public $sel;
	public $ins;
	public $upd;
	
	function __construct($father,$name,$method="post",$action="",$target="_top",$subLayer=0,$nivel=0){
		$this->father = $father;
		$this->subLayer = $subLayer;
		$this->type = "form";
		if($this->father!==false){
		    $this->layer = $this->father->getFatherLayer();
		    $this->nivel = $this->father->getNivel();
        }else{
            $this->nivel = $nivel;
        }
		$this->name = $name;
        $this->formName = $this->name;
		$this->method = $method;
		$this->action = $action;
		$this->target = $target;
		$this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->java = new java();
		$this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
		$this->newObj($this,$this->name,"form",$this->father->getName());
		$this->setHidden("hdComment".$this->name, "");
	}
	
	public function setTitleDivision($title){
		$this->titleDivision = $title;
	}
	
	public function getMsgErro(){
		$msgFinal = "<br><br>";
		
		foreach ($this->iMsgErro as $key => $value){
			$msgFinal .= $this->iMsgErro[$key];
		}
		
		return $msgFinal."<br>";
	}
	
	public function getUpperCase(){
		return $this->uppercase;
	}
	
	public function setFillForm($objLyt,$where=false,$operator="=",$value=false){
		$sel = new iSelect($this->dataSet,$this->table);
		if($where!==false){
			$sel->where($where, $operator, $value);
		}
		$sel->limit(1);
		$resSel = $sel->exe();
		
		if($resSel===false){
			$this->setMsgErro(6, $this->dataSet->getError());
			return false;
		}else{
			$this->row = $sel->read();
			$this->exeFillForm(false,$objLyt);
			return true;
		}
	}
	
	public function setHistoric($type="m"){
		$this->historic = $type;
	}
	
	public function setMsgErro($n,$msg){
		$this->iMsgErro[$n] = "(".$n.") ".$msg."<br>";
	}
	
	public function unSetUpperCase(){
		global $textBoxStyle;
		$textBoxStyle->unSetUpperCase();
		$this->uppercase = false;
	}
	public function submitByEnter(){
		global $page;
		
		$page->body->submitByEnter($this->formName);
	}
	public function setReadOnly(){
		$this->readOnly = true;
	}
	public function getReadOnly(){
		return $this->readOnly;
	}
	public function setResetAutoSave(){
		$this->resetAutoSave = true;
	}
	public function resetAutoSave(){
		global $RESET_AUTOSAVE;
		$RESET_AUTOSAVE = true;
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
	
	public function setInsert($column,$value,$check=false,$multiInsert=false){
		$this->ins->insert($column,$value,$check,$multiInsert);
	}
	public function setColumn($column,$value,$withoutQuotation=false){
		$this->upd->set($column,$value,$withoutQuotation);
	}
	public function setJoin($table,$where,$operator,$value,$type="",$tableAs=""){
		$this->upd->join($table,$where,$operator,$value,$type,$tableAs);
	}
	public function setColumnsMath($column,$type,$by){
		$id = count($this->columnsMathColumn);
		$this->columnsMathColumn[$id] = $column;
		$this->columnsMathType[$id] = $type;
		$this->columnsMathBy[$id] = $by;
	}
	public function setInsertTimeCurrent($column){
		$this->columnInsertTimeCurrent = $column;
	}
	public function getDataSet(){
		return $this->dataSet;
	}
	public function layoutNewLine(){
		$this->lines++;
		$this->line = new space($this, $this->name."_LYT_LINE_".$this->lines);
	}
	public function layoutNewCell($label="",$float="",$width="",$align="left"){
		$this->cells++;
		$father = $this->getObj($this->name."_LYT_LINE_".$this->lines);
		$this->obj = new space($father, $this->name."_LYT_LINE_".$this->lines."_CELL_".$this->cells,$align);
		if($float){
			$this->obj->css->float($float);
		}
		if($width){
			$this->obj->css->width($width);
		}
		if($label!=""){
			$objLabel = new space($this->obj,$this->obj->getName()."_LABEL");
			$objLabel->inSide($label);
		}
		$this->obj = new space($this->obj, $this->obj->getName()."_OBJ");
	}
	public function layoutNewSpaceBetweenCell($space,$float="",$height=""){
		$this->spaceBetweenCells++;
		$this->obj = new space($this->line,$this->name."_SBC_".$this->spaceBetweenCells);
		$this->obj->css->width($space);
		if($float){
			$this->obj->css->float($float);
		}
		if($height){
			$this->obj->css->height($height);
		}
	}
	public function layoutNewSpaceBetweenLine($space){
		$this->spaceBetweenLines++;
		$this->obj = new space($this,$this->name."_SBL_".$this->spaceBetweenLines);
		$this->obj->css->width("100%");
		$this->obj->css->height($space);
	}
	public function setDataSet($dataSet,$table,$listName=false,$panel=false){
		$this->dataSet = $dataSet;
		$this->table = $table;
		$this->listName = $listName;
		$this->panel = $panel;
		$this->ins = new iInsert($this->dataSet, $this->table); 
		$this->upd = new iUpdate($this->dataSet, $this->table); 
	}
	public function autoBuild(){
		global $page;
		global $menuCore;
		global $PATH;
		global $PAGENAME;
		
		$this->css->marginTop(20);
		$this->css->marginBottom(20);
		
		# CORE DE INSERT E UPDATE
		$this->java->core(false, "lyt".$this->name, "lyt".$this->name, $PATH."../RCD_7/iFormScriptInsertUpdate.php","","parameter","",false,false,true,false);
		
		# HIDDEN DO TIPO DE BOTÃO E NOME DO FORM
		$this->setHidden($this->name."iFormName", $this->name);
		$this->setHidden($this->name."ButtonPress", "0");
		$this->setHidden($this->name."MsgSuccess", "");
		$this->setHidden($this->name."MsgFail", "");
		$this->setHidden($this->name."void", "");
		$this->setHidden($this->name."KeyAnt", "");
		$this->setHidden($this->name."KeyPro", "");
		
		# VARIAVEIS DE SESSÃO PARA BANCO DE DADOS
		$page->session->setSession($this->name,$this->name);
		$page->session->setSession($this->name."_ID",$this->id);
		$page->session->setSession($this->name."_PAGENAME",$PAGENAME);		
		$page->session->setSession($this->name."_DATASET",$this->dataSet->getDataSetName());
		$page->session->setSession($this->name."_TABLE",$this->table);
		$page->session->setSession($this->name."_LISTNAME",$this->listName);
		$page->session->setSession($this->name."_UPPERCASE",$this->uppercase);
		$page->session->setSession($this->name."_GROUP_INS",$this->groupIns);
		$page->session->setSession($this->name."_GROUP_UPD",$this->groupUpd);
		$page->session->setSession($this->name."_GROUP_DES",$this->groupDes);
		
		$sel = new iSelect($this->dataSet,$this->table);
		$sel->listColumn();
		
		$resSel = $sel->exe();
		
		$fieldHistoricoValue = false;
		
		if($resSel===false){
			showMsgWithoutStyle("Houve uma falha!".administrador.$this->dataSet->getError(1),false);
		}else{
			$fieldIdName = "id".str_replace(" ", "",ucwords(str_replace("_", " ",$this->table)));
			while ($row = $sel->read()){
				if($row['Field']==$fieldIdName && strlen($page->session->getSession($this->id,$PAGENAME))>0){
					# CARREGA OS DADOS
					$selB = new iSelect($this->dataSet,$this->table);
					$selB->where($row['Field'], "=", $page->session->getSession($this->id,$PAGENAME));
					
					if($selB->exe()!==false && $selB->getNumRows()>0){
						$this->row = $selB->read();
					}
				}				
				
				# CREATE
				$row['create'] = true;
				$row['require'] = false;
				if(strpos($row['Field'], "data")!==false || strpos($row['Field'], "historico")!==false || strpos($row['Field'], "Remoto")!==false || strpos($row['Field'], "filial")!==false || strpos($row['Field'], "usuario")!==false){
					$row['create'] = false;
					$row['require'] = false;
				}
				
				# LABEL
				if($row['Field']==$fieldIdName){
					$row['label'] = "ID";
				}else if(strpos($row['Field'], "status")!==false){
					$row['label'] = "Status";
				}else if(strpos($row['Field'], "dataCriacao")!==false){
					$row['label'] = "Data Cadastro";
				}else if(strpos($row['Field'], "dataModificacao")!==false){
					$row['label'] = "Data Modificação";
				}else{
					$row['label'] = $row['Field'];
				}
				
				# TYPE OBJ
				$row['typeObj'] = "textBox";
				if(strpos($row['Type'], "int")!==false || strpos($row['Type'], "varchar")!==false){
					$row['typeObj'] = "textBox";
				}else if(strpos($row['Type'], "text")!==false){
					$row['typeObj'] = "textBoxMultiLine";
				}else if(strpos($row['Type'], "decimal")!==false){
					$row['typeObj'] = "textBoxNumber";
				}
				if(strpos($row['Field'],"estado")!==false || strpos($row['Field'],"cidade")!==false){
					$row['typeObj'] = "comboBox";
				}
				
				# CREATE LINE
				$row['createLine'] = false;
				
				# TYPE LINE
				$row['typeLine'] = false;#tblLayOutSpcTr;
				
				# TYPE CELL
				$row['typeCell'] = tblLayOut;
				
				# TAMANHO DO CAMPO
				$tamanhoField = $this->parseTextBetween("(", ")", $row['Type']);
				if($tamanhoField<100){
					if(strpos($row['Field'], "status")!==false){
						$row['sizeField'] = 140;
					}else if(strpos($row['Field'], "data")!==false){
						$row['sizeField'] = 140;
					}else if(strpos($page->stringToUpper($row['Field']), "CPF")!==false || strpos($page->stringToUpper($row['Field']), "CNPJ")!==false || strpos($page->stringToUpper($row['Field']), "RGIE")!==false || strpos($page->stringToUpper($row['Field']), "INSCRICAOMUNICIPAL")!==false){
						$row['sizeField'] = 150;
					}else if($row['typeObj']=="textBox" || $row['typeObj']=="textBoxNumber"){
						$row['sizeField'] = 80;
					}else if($row['typeObj']!="comboBox"){
						$row['sizeField'] = 410;
					}else{
						$row['sizeField'] = false;
					}
				}else if($row['typeObj']!="comboBox"){
					if(strpos($row['Field'], "bairro")!==false){
						$row['sizeField'] = 250;
					}else if($tamanhoField<=400){
						$row['sizeField'] = $tamanhoField;
					}else{
						$row['sizeField'] = 400;
					}
				}else{
					if(strpos($row['Field'], "cidade")!==false){
						$row['sizeField'] = 300;
					}else{
						$row['sizeField'] = false;
					}
				}
				
				# ALIGN
				if($row['Field']==$fieldIdName || strpos($row['Field'], "status")!==false){
					$row['align'] = center;
				}else if(strpos($row['Type'], "decimal")!==false){
					$row['align'] = right;
				}else if(strpos($row['Type'], "int")!==false){
					$row['align'] = center;
				}else{
					$row['align'] = left;
				}
				
				# READ ONLY
				if($row['Field']==$fieldIdName || strpos($row['Field'], "status")!==false || strpos($row['Field'], "dataCriacao")!==false || strpos($row['Field'], "dataModificacao")!==false){
					$row['readOnly'] = true;
				}else{
					$row['readOnly'] = false;
				}
				
				# COMBO BOX CREATE
				$row['optionsComboBox'] = array();
				if(strpos($row['Field'],"estado")!==false){
					$selC = new iSelect($this->dataSet,"estado");
					$selC->where("statusEstado", "=", "1");
					$selC->order("estado");
					
					if($selC->exe()!==false){
						$row['optionsComboBox'][''] = "";
						while ($rowC = $selC->read()){
							$row['optionsComboBox'][$rowC['estado']] = $rowC['estado'];
						}
					}
				}
				if(strpos($row['Field'],"cidade")!==false){
					$row['optionsComboBox'] = array("" => "ESCOLHA UM ESTADO PRIMEIRO");
				}
				
				# VALUE
				if($this->row===false){
					if($row['Field']==$fieldIdName || strpos($row['Field'], "status")!==false || strpos($row['Field'], "dataCriacao")!==false || strpos($row['Field'], "dataModificacao")!==false){
						$row['value'] = "NOVO";
					}else if(strlen($row['Default'])==0){
						$row['value'] = "";
					}else{
						$row['value'] = $row['Default'];
					}
				}else if(isset($this->row[$row['Field']])){
					if(strpos($row['Field'], "status")!==false){
						$this->status = $this->row[$row['Field']];
					}
					$row['value'] = $this->row[$row['Field']];
				}else{
					$row['value'] = "";
				}
				
				# IS DATE
				if(strpos($row['Field'], "data")!==false){
					$row['formatDate']['enable'] = true;
					$row['formatDate']['by'] = "timestamp";
					$row['formatDate']['mode'] = "abb4";
				}
				
				# BACKGROUND COLOR
				if($row['Field']==$fieldIdName || strpos($row['Field'], "status")!==false || strpos($row['Field'], "dataCriacao")!==false || strpos($row['Field'], "dataModificacao")!==false){
					if($this->row!==false && strpos($row['Field'], "status")!==false){
						if($this->row[$row['Field']]==0){
							$row['backgroundColor'] = COLOR_RED;
						}else{
							$row['backgroundColor'] = COLOR_GREEN;
						}
					}else{
						$row['backgroundColor'] = COLOR_DARK_SILVER;
					}
				}else{
					$row['backgroundColor'] = false;
				}
				
				# TEXT COLOR
				if($row['Field']==$fieldIdName || strpos($row['Field'], "status")!==false || strpos($row['Field'], "dataCriacao")!==false || strpos($row['Field'], "dataModificacao")!==false){
					$row['color'] = COLOR_WHITE;
				}else{
					$row['color'] = false;
				}
				
				# CURSOR HAND
				$row['cursor'] = false;
				
				# STATUS
				if(strpos($row['Field'], "status")!==false){
					$row["mask"] = array("NOVO" => "NOVO","0" => "DESATIVADO","1" => "ATIVO","2" => "LIBERADO","3" => "ESTORNADO","4" => "FINALIZADO","5" => "CONCLUÍD0");
					$row["maskBackGroundColor"] = array("NOVO" => COLOR_DARK_SILVER,"0" => COLOR_RED,"1" => COLOR_GREEN,"2" => COLOR_YELLOW,"3" => COLOR_ORANGE,"4" => COLOR_DARK_GREEN,"5" => COLOR_DARK_SILVER);
					$row["maskColor"] = array("NOVO" => COLOR_WHITE,"0" => COLOR_WHITE,"1" => COLOR_WHITE,"2" => COLOR_BLACK,"3" => COLOR_BLACK,"4" => COLOR_WHITE,"5" => COLOR_ULTRA_LIGHT_SILVER);
				}
				
				# HISTORICO
				if(strpos($row['Field'], "historico")!==false && $this->row!==false){
					$fieldHistoricoValue = $this->row['historico'];
				}
				
				$id = count($this->autoBuildColumns);
				$this->autoBuildColumns[$id] = $row;
			}
		}
		
		$this->createButtonInAutoBuild($this->name."btAutoSalvarA","Salvar",btGreen,$this->groupIns);
		$this->submit($this->name."btAutoSalvarA", "INS", "Cadastro realizado com sucesso!","Houve uma falha ao tentar realizar o cadastro!");
		$this->createButtonInAutoBuild($this->name."btAutoCancelarA","Cancelar",btYellow,$this->groupIns);
				
		$this->createButtonInAutoBuild($this->name."btAutoSalvarB","Salvar Alterações",btGreen,$this->groupUpd);
		$this->submit($this->name."btAutoSalvarB", "UPD", "Alterações realizadas com sucesso!","Houve uma falha ao tentar realizar as alterações!");
		$this->createButtonInAutoBuild($this->name."btAutoCancelarB","Cancelar",btYellow,$this->groupUpd);
		$this->createButtonInAutoBuild($this->name."btAutoDesativarB","Desativar",btRed,$this->groupUpd);
		$this->desactive($this->name."btAutoDesativarB", "Deseja realmente desativar esse cadastro?","Cadastro desativado com sucesso!","Houve uma falha ao tentar desativar esse cadastro!",true);
		$this->createButtonInAutoBuild($this->name."btAutoCadastrarNovoB","Cadastrar Novo","bigButton",$this->groupUpd);
		$this->reset($this->name."btAutoCadastrarNovoB");
		$this->createButtonInAutoBuild($this->name."btAutoHistoricoB","Historico","bigButton",$this->groupUpd);
		$this->java->setObjVisibleTogger("click", $this->name."btAutoHistoricoB", $this->name."LytHist","block");
		
		$this->createButtonInAutoBuild($this->name."btAutoCancelarC","Cancelar",btYellow,$this->groupDes);
		$this->createButtonInAutoBuild($this->name."btAutoHistoricoC","Historico","bigButton",$this->groupDes);
		$this->java->setObjVisibleTogger("click", $this->name."btAutoHistoricoC", $this->name."LytHist","block");
		$this->createButtonInAutoBuild($this->name."btAutoCadastrarNovoC","Cadastrar Novo","bigButton",$this->groupDes);
		$this->reset($this->name."btAutoCadastrarNovoC");
		
		$lyt = new newTable($this->father, $this->name."LytHist");
		$lyt->css->setInvisible();
		$lyt->line();
		$lyt->cell();
		$lyt->inSideSpan("Histórico","msgInfo");
		$lyt->line();
		$lyt->cell(division,2000);
		$lyt->line();
		$lyt->cell();
		$lyt->space($this->name."SpcHist");
		if($fieldHistoricoValue!==false){
			$historico = "";
			$fieldHistoricoValue = explode("#", $fieldHistoricoValue);
			foreach ($fieldHistoricoValue as $key => $value){
				$historico .= $value."<br>";
				/*if(strpos($value, "MODIFICADO")===false){
					$historico .= $value."<br>";
				}*/
			}
			$lyt->value($this->name."SpcHist", $historico);
		}
		$lyt->line(tblLayOutSpcTr3);
	}
	public function createButtonInAutoBuild($name,$label,$class,$group,$createLine=false){
		if(isset($this->autoBuildButtons[$group])){
			$id = count($this->autoBuildButtons[$group]);
		}else{
			$id = 0;
		}
		$this->autoBuildButtons[$group][$id]['name'] = $name;
		$this->autoBuildButtons[$group][$id]['label'] = $label;
		$this->autoBuildButtons[$group][$id]['class'] = $class;
		$this->autoBuildButtons[$group][$id]['group'] = $group;
		$this->autoBuildButtons[$group][$id]['createLine'] = $createLine;
	}
	public function changeAutoBuild($field,$param,$value,$param2=false,$value2=false){
		foreach ($this->autoBuildColumns as $keyB => $valueB){
			if($valueB['Field']==$field){
				$this->autoBuildColumns[$keyB][$param] = $value;
				if($param2!==false && !isset($this->autoBuildColumns[$keyB]['param2'])){
					$this->autoBuildColumns[$keyB]['param2'] = $param2;
					$this->autoBuildColumns[$keyB]['value2'] = $value2;
				}
				break;
			}
		}
		/*if($field=="statusSistemaTransacao"){
			echo $field."<br><br>";
			print_r($this->autoBuildColumns);
		}*/
	}
	
	public function changeAutoBuildButtonCancel($func,$panel=false){
		$this->autoBuildButtonCancel = array("func" => $func,"panel" => $panel);
	}
	public function changeAutoBuildFormatData($field,$enable=true,$by="timestamp",$mode="abb4"){
		foreach ($this->autoBuildColumns as $keyB => $valueB){
			if($valueB['Field']==$field){
				$this->autoBuildColumns[$keyB]['formatDate']['enable'] = $enable;
				$this->autoBuildColumns[$keyB]['formatDate']['by'] = $by;
				$this->autoBuildColumns[$keyB]['formatDate']['mode'] = $mode;
			}
		}
	}
	public function setObjAction($obj){
		$this->objAction = $obj;
	}
	public function setTable($table){
		$this->table = $table;
	}
	public function includeBefore($include){
		global $page;
		global $FOLDER;
		
		$preInclude = substr(THIS, 0,(strrpos(THIS,"/")+1));
		$preInclude = str_replace("/".$FOLDER."/", "../", $preInclude);
		
		$page->session->setSession($this->name."_INCLUDE_BEFORE",$preInclude.$include);
	}
	public function includeAfter($include){
		global $page;
		global $FOLDER;
		
		$preInclude = substr(THIS, 0,(strrpos(THIS,"/")+1));
		$preInclude = str_replace("/".$FOLDER."/", "../", $preInclude);
	
		$page->session->setSession($this->name."_INCLUDE_AFTER",$preInclude.$include);
	}
	public function includeReset($include){
		global $page;
		global $FOLDER;
	
		$preInclude = substr(THIS, 0,(strrpos(THIS,"/")+1));
		$preInclude = str_replace("/".$FOLDER."/", "../", $preInclude);
	
		$page->session->setSession($this->name."_INCLUDE_RESET",$preInclude.$include);
	}
	public function id($id){		
		$this->id = $id;
	}
	public function groupButton($groupIns,$groupUpd,$groupDes=false){
		$this->groupIns = $groupIns;
		$this->groupUpd = $groupUpd;
		$this->groupDes = $groupDes;
	}
	public function groupButtonDesactive($group){
		$this->groupDesactive = $group;
	}
	public function submit($button,$type,$msgSuccess=false,$msgFail=false){
		global $page;
		global $PATH;
		global $PAGANAME;
		
		$type = $page->stringToUpper($type);
		
		$this->java->setValue("click", $button, $this->name."iFormName", $this->name);
		$this->java->setValue("click", $button, $this->name."ButtonPress", $type);
		$this->java->setValue("click", $button, $this->name."MsgSuccess", $msgSuccess);
		$this->java->setValue("click", $button, $this->name."MsgFail", $msgFail);
		$this->java->setSubmitForm("click", $button, $this->name,$PATH."../RCD_7/iFormScriptInsertUpdate.php","objCorelyt".$this->name."0");
	}
	public function void($button,$action,$question,$msgSuccess=false,$msgFail=false,$showComment=false){
		global $page;
		global $PATH;
		global $PAGANAME;
	
		$this->java->setValue("click", $button, $this->name."iFormName", $this->name);
		$this->java->setValue("click", $button, $this->name."ButtonPress", $action);
		$this->java->setValue("click", $button, $this->name."MsgSuccess", $msgSuccess);
		$this->java->setValue("click", $button, $this->name."MsgFail", $msgFail);
		$this->java->setValue("click", $button, $this->name."void", "1");
		$this->java->showMsg("click", $button, $question, $PATH."../RCD_7/iFormScriptInsertUpdate.php","close","C",$this->name,"objCorelyt".$this->name."0",COLOR_DARK_BLUE,$showComment,$this->name);
	}
	public function desactive($button,$question,$msgSuccess=false,$msgFail=false,$showComment=false){
		global $page;
		global $PATH;
		global $PAGANAME;
	
		$this->java->setValue("click", $button, $this->name."iFormName", $this->name);
		$this->java->setValue("click", $button, $this->name."ButtonPress", "DES");
		$this->java->setValue("click", $button, $this->name."MsgSuccess", $msgSuccess);
		$this->java->setValue("click", $button, $this->name."MsgFail", $msgFail);
		$this->java->showMsg("click", $button, $question, $PATH."../RCD_7/iFormScriptInsertUpdate.php","close","C",$this->name,"objCorelyt".$this->name."0",COLOR_DARK_BLUE,$showComment,$this->name);
	}
	public function active($button,$question,$msgSuccess=false,$msgFail=false,$showComment=false){
		global $page;
		global $PATH;
		global $PAGANAME;
	
		$this->java->setValue("click", $button, $this->name."iFormName", $this->name);
		$this->java->setValue("click", $button, $this->name."ButtonPress", "ACT");
		$this->java->setValue("click", $button, $this->name."MsgSuccess", $msgSuccess);
		$this->java->setValue("click", $button, $this->name."MsgFail", $msgFail);
		$this->java->showMsg("click", $button, $question, $PATH."../RCD_7/iFormScriptInsertUpdate.php","close","C",$this->name,"objCorelyt".$this->name."0",COLOR_DARK_BLUE,$showComment,$this->name);
	}
	public function target($button,$target){
		global $c;
		
		$panel = explode(",", $target);
		$panelB = array();
		foreach ($panel as $keyB => $valueB){
			$panelB[$valueB] = true;
		}
		
		foreach ($c as $key => $value){
			if(isset($panelB["c".$key])){
				$this->java->setObjVisible("click", $button, "c".$key);
			}else{
				$this->java->setObjInvisible("click", $button, "c".$key);
			}
		}
		
		/*$this->java->setObjInvisible("click", $button, $this->father->getName());
		$this->java->setObjVisible("click", $button, $target);*/
	}
	public function setGoToPanel($button,$panel,$includeReset=false){
		global $page;
		global $PATH;
		global $c;
		global $FOLDER;
	
		$page->session->setSession("C",$c);
	
		$preInclude = substr(THIS, 0,(strrpos(THIS,"/")+1));
		$preInclude = str_replace("/".$FOLDER."/", "../", $preInclude);
		
		if($includeReset!==false){
			$this->java->setGoToPage("click", $button,$PATH."../RCD_7/iFormScriptInsertUpdate.php","RESET_THIS_FORM",$preInclude.$includeReset,false,"&PANEL=".$panel,false,false,"objCorelyt".$this->name."0");
		}else{
			$this->java->setGoToPage("click", $button,$PATH."../RCD_7/iFormScriptInsertUpdate.php","RESET_THIS_FORM","",false,"&PANEL=".$panel,false,false,"objCorelyt".$this->name."0");
		}
	}
	public function reset($button,$panel=false){
		global $page;
		global $PATH;
		global $c;
		global $FOLDER;
		global $PAGENAME;
		
		if($panel===false){
			$panel = "";
		}
	
		$page->session->setSession("C",$c);
	
		$this->java->setGoToPage("click", $button,$PATH."../RCD_7/iFormScriptInsertUpdate.php",$this->id,"",false,"@".$PAGENAME."&PANEL=".$panel."&RESET_THIS_FORM=1&FORM=".$this->name,false,false,"objCorelyt".$this->name."0");
	}
	public function getCellObj(){
		return $this->obj;
	}
    public function getNewId(){
        return $this->newId;
    }
    public function setHidden($name,$value,$column=""){
        $this->hidden[$name] = $value;
        $this->column[$name] = $column;
    }
	public function getErrorForm(){
		return $this->errorForm;
	}
	public function getMsgError(){
		return $this->msgError;
	}
    public function getNumErrors(){
		return $this->numErrors;
	}
    public function setBackGroundColorError($value){
		$this->backGroundColorError = $value;
	}
	private function setObj($name,$type){
		$idObj = count($this->obj);
		$this->obj[$idObj]['name'] = $name;
		$this->obj[$idObj]['type'] = $type;
	}
	public function getRow(){
		return $this->row;
	}
	public function getResultAuthenticate(){
		return $this->resultAuthenticate;
	}
	public function getResultInsert(){
		return $this->resultInsert;
	}
    public function getResultUpdate(){
		return $this->resultUpdate;
	}
	protected function changeBackgroundColor($obj,$multiObj=true,$objFather=false){
		if($multiObj===true){
			if($this->backGroundColorError){
				$obj->css->backGroundColor($this->backGroundColorError);
			}
		}else{
			$objFather->addStyles($obj,backGroundColor.$this->backGroundColorError);
		}
	}
    public function setDisabled(){
        $this->disabled = true;
    }
    public function setRow($row){
        $this->row = $row;
    }
    public function setWhereUpdate($where,$operator,$value){
        $this->whereUpdate = $where;
        $this->operatorUpdate = $operator;
        $this->valueUpdate = $value;
    }
    public function setWhereForCheckUnique($where,$operator,$value){
    	$this->whereForCheckUnique = $where;
    	$this->operatorForCheckUnique = $operator;
    	$this->valueForCheckUnique = $value;
    }
    public function exeFillForm($multiObj=true,$objFather=false){
    	if($multiObj===true){
	        global $OBJ;
	        for($i=0;$i<count($OBJ);$i++){
	            if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine" || $OBJ[$i]['type']=="comboBox")){
	                $name = $this->getObj($OBJ[$i]['name']);
	                if($name->formName==$this->name){
	                    if($this->disabled===true){
	                        $name->setDisabled();
	                    }
	                    if(isset($this->row)){
	                        foreach($this->row as $key => $value){
	                            if($key==$name->getColumn()){
	                                if($OBJ[$i]['type']=="comboBox"){
	                                	if(strlen($value)>0){
	                                    	$name->setSelectedIndex($value);
	                                	}
	                                }else{
	                                	if(strlen($value)>0){
		                                	if(count($this->columnsMathColumn)>0){
		                                		for($j=0;$j<count($this->columnsMathColumn);$j++){
		                                			if($this->columnsMathColumn[$j]==$key){
		                                				if($this->columnsMathType[$j]=="division"){
		                                					$value = @($value / $this->columnsMathBy[$j]);
		                                				}
		                                				if($this->columnsMathType[$j]=="multiply"){
		                                					$value = @($value * $this->columnsMathBy[$j]);
		                                				}
		                                			}
		                                		}
		                                	}
		                                	if($name->getMoney()===true){
		                                		$value = $this->formatNumber($value,2,"MONEY");
		                                	}else if($name->getNumber()!==false){
		                                		$value = $this->formatNumber($value,$name->getNumber(),"DECIMAL_PT");
		                                	}else if($name->getDate()===true){
		                                		$value = $this->formatDate($value,$name->DateBy,$name->DateMode);
		                                	}
		                                    $name->setValue($value);
	                                	}
	                                }
	                            }
	                        }
	                    }
	                }
	            }
	        }
    	}else{
    		foreach ($objFather->comboBox as $keyB => $valueB){
    			if($this->disabled===true){
    				$objFather->comboBox[$keyB]['disabled'] = true;
    			}
    			if(isset($this->row)){
    				foreach($this->row as $key => $value){
    					if($key==$objFather->comboBox[$keyB]['column']){
    						if(strlen($value)>0){
    							$objFather->comboBox[$keyB]['selectedIndex'] = $value;
    						}
    					}
    				}
    			}
    		}
    		foreach ($objFather->textBox as $keyB => $valueB){
    			if($this->disabled===true){
    				$objFather->textBox[$keyB]['disabled'] = true;
    			}
    			if(isset($this->row)){
    				foreach($this->row as $key => $value){
    					if($key==$objFather->textBox[$keyB]['column']){
    						if(strlen($value)>0){
    							if(isset($objFather->asMoney[$objFather->textBox[$keyB]['name']]['name'])){
    								$value = $this->formatNumber($value,2,"MONEY");
    							}else if(isset($objFather->asNumber[$objFather->textBox[$keyB]['name']]['name'])){
    								$value = $this->formatNumber($value,$objFather->asNumber[$objFather->textBox[$keyB]['name']]['digit'],"DECIMAL_PT");
    							}
    							$objFather->textBox[$keyB]['value'] = $value;
    						}
    					}
    				}
    			}
    		}
    		foreach ($objFather->textBoxMultiLine as $keyB => $valueB){
    			if($this->disabled===true){
    				$objFather->textBoxMultiLine[$keyB]['disabled'] = true;
    			}
    			if(isset($this->row)){
    				foreach($this->row as $key => $value){
    					if($key==$objFather->textBoxMultiLine[$keyB]['column']){
    						if(strlen($value)>0){
    							if(isset($objFather->asMoney[$objFather->textBoxMultiLine[$keyB]['name']]['name'])){
    								$value = $this->formatNumber($value,2,"MONEY");
    							}else if(isset($objFather->asNumber[$objFather->textBoxMultiLine[$keyB]['name']]['name'])){
    								$value = $this->formatNumber($value,$objFather->asNumber[$objFather->textBoxMultiLine[$keyB]['name']]['digit'],"DECIMAL_PT");
    							}
    							$objFather->textBoxMultiLine[$keyB]['value'] = $value;
    						}
    					}
    				}
    			}
    		}
    	}
    }
	public function exeFormAuthenticate(){
        if(isset($_POST["FORM_".$this->name])){
			$objDataSet = $this->dataSet;
			$this->sel = $objDataSet->select();
			$this->sel->set($this->table);
			$this->sel->setWhere("status","=","1");
			global $OBJ;
			for($i=0;$i<count($OBJ);$i++){
				if($OBJ[$i]['type']=="textBox"){
					$name = $this->getObj($OBJ[$i]['name']);
                    if($name->formName==$this->name){
					    $_POST[$OBJ[$i]['name']] = $this->fillText(@$_POST[$OBJ[$i]['name']]);
					    $this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
                    }
				}
			}
			$this->sel->Exe();
			$this->row = $this->sel->read();
            $this->msgError = $this->sel->getMsgError();
            $this->numErrors = $this->sel->getNumErrors();
            $this->sql = $this->sel->getSql();
			$this->resultAuthenticate = $this->sel->getNumRows();
		}
	}
	public function exeFormInsert($now=true,$multiObj=true,$objFather=false){
		if($now===true){
			return $this->exeFormInsertEnd($multiObj,$objFather);
		}else{
			$this->exeInsert = true;
		}
	}
	public function exeFormUpdate($now=true,$multiObj=true,$objFather=false){
		if($now===true){
			return $this->exeFormUpdateEnd($multiObj,$objFather);
		}else{
			$this->exeUpdate = true;
		}
	}
	public function exeFormInsertEnd($multiObj=true,$objFather=false){
		if(@$_POST["FORM_".$this->name]){	
			if($multiObj===true){

	            if(isset($this->hidden) && count($this->hidden)>0){
	                foreach($this->hidden as $key => $value){
	                    if($value=="auto"){
	                        $value = substr(time(),-8);
	                        $value = strrev($value);
	                    }
	                    $this->hidden[$key] = $value;
	                    $this->ins->insert($this->column[$key],$value);
	                }
	            }
	            if(isset($this->columnInsertTimeCurrent)){
	            	$this->ins->insert($this->columnInsertTimeCurrent,time());
	            }
				$this->errorForm = 0;
				global $OBJ;
				for($i=0;$i<count($OBJ);$i++){
					if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine" || $OBJ[$i]['type']=="comboBox")){
	                    $name = $this->getObj($OBJ[$i]['name']);
	                    if($name->formName==$this->name){
						    if($name->getMoney()===true){
						    	$_POST[$OBJ[$i]['name']] = $this->formatNumber($_POST[$OBJ[$i]['name']],2,"DECIMAL");
						    }else if($name->getNumber()!==false){
						    	$_POST[$OBJ[$i]['name']] = $this->formatNumber($_POST[$OBJ[$i]['name']],$name->getNumber(),"DECIMAL");
						    }else{
						    	$_POST[$OBJ[$i]['name']] = $this->fillText(@$_POST[$OBJ[$i]['name']]);
						    }
						    if($name->getRequired()===true && @$_POST[$OBJ[$i]['name']]==""){
							    $this->changeBackgroundColor($name);
							    $this->errorForm = 1;
							    $this->setMsgErro(1, msgErro1);
						    }else{ 
							    if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine")){
								    if($name->getCheck() && $this->verifyValue($_POST[$OBJ[$i]['name']],$name->check)===false){
									    $this->changeBackgroundColor($name);
									    $this->errorForm = 2;
									    $this->setMsgErro(2, msgErro2);
								    }
							    }
						    }
	                        if($name->getUnique()===true){
	                            if($this->dataSet->versao=="old"){
									$this->sel = $this->dataSet->select();
									$this->sel->set($this->table);
									if(is_numeric(@$_POST[$OBJ[$i]['name']])){
										$this->sel->setAnd($name->getColumn(),"=",@$_POST[$OBJ[$i]['name']]);
									}else{
										$this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
									}
									$this->sel->Exe();
									if($this->sel->getNumRows()>0){
										$this->changeBackgroundColor($name);
										$this->errorForm = 3;
										$this->setMsgErro(3, msgErro3);
									}
								}else{
									$this->sel = new iSelect($this->dataSet,$this->table);
	                            	$this->sel->where($name->whereForCheckUnique,$name->operatorForCheckUnique,$name->valueForCheckUnique);
									if(is_numeric(@$_POST[$OBJ[$i]['name']])){
										$this->sel->setAnd($name->getColumn(),"=",@$_POST[$OBJ[$i]['name']]);
									}else{
										$this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
									}
									$this->sel->exe();
									if($this->sel->getNumRows()>0){
										$this->changeBackgroundColor($name);
										$this->errorForm = 3;
										$this->setMsgErro(3, msgErro3);
									}
								}
	                        }
	                        if($name->getIsNotEqual()!==false){
	                        	if($name->getIsNotEqual()==@$_POST[$OBJ[$i]['name']]){
	                        		$this->changeBackgroundColor($name);
	                        		$this->errorForm = 4;
	                        		$this->setMsgErro(4, msgErro4);
	                        	}
	                        }
	                        if($name->getColumn()){
	                        	if($name->check=="NUM_TEL"){
	                        		$_POST[$OBJ[$i]['name']] = str_replace("(", "", $_POST[$OBJ[$i]['name']]);
	                        		$_POST[$OBJ[$i]['name']] = str_replace(")", "", $_POST[$OBJ[$i]['name']]);
	                        		$_POST[$OBJ[$i]['name']] = str_replace("-", "", $_POST[$OBJ[$i]['name']]);
	                        		$_POST[$OBJ[$i]['name']] = str_replace(" ", "", $_POST[$OBJ[$i]['name']]);
	                        	}
	                        	if($name->getTypeColumn()){
	                        		$typeColumn = $name->getTypeColumn();
	                        		if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
	                        			if($name->getUppercase()===true){
	                        				$_POST[$OBJ[$i]['name']] = $this->stringToUpper($_POST[$OBJ[$i]['name']]);
	                        			}
	                        		}
	                        	}
	                        	if(strlen(@$_POST[$OBJ[$i]['name']])>0){
						    		$this->ins->insert($name->getColumn(),@$_POST[$OBJ[$i]['name']]);
	                        	}
	                        }
	                    }
					}
				}
				if($this->errorForm==0){
					if($this->ins->exe()){
						$this->sql = $this->ins->getSql();
						$this->resultInsert = $this->ins->getNumRows();
		                $this->newId = $this->ins->getNewId();
						return true;
					}else{
						$this->setMsgErro(6, $this->dataSet->getError());
						$this->sql = $this->ins->getSql();
						return false;
					}
				}else{
					return false;
				}
			}else{
				$name = $objFather;
				if(isset($this->hidden) && count($this->hidden)>0){
	                foreach($this->hidden as $key => $value){
	                    if($value=="auto"){
	                        $value = substr(time(),-8);
	                        $value = strrev($value);
	                    }
	                    $this->hidden[$key] = $value;
	                    if(strlen($this->column[$key])>0){
	                    	$this->ins->insert($this->column[$key],$value);
	                    }
	                }
	            }
	            if(isset($this->columnInsertTimeCurrent)){
	            	$this->ins->insert($this->columnInsertTimeCurrent,time());
	            }
				$this->errorForm = 0;				
				#for($i=0;$i<count($OBJ);$i++){
				#if($OBJ[$i]['type']=="newTable"){
				#$name = $this->getObj($OBJ[$i]['name']);
				if($name->formName==$this->name){
					/*if($name->getMoney()===true){
					 $_POST[$OBJ[$i]['name']] = $this->formatNumber($_POST[$OBJ[$i]['name']],2,"DECIMAL");
					 }else if($name->getNumber()!==false){
					 $_POST[$OBJ[$i]['name']] = $this->formatNumber($_POST[$OBJ[$i]['name']],$name->getNumber(),"DECIMAL");
					 }else{
					 $_POST[$OBJ[$i]['name']] = $this->fillText(@$_POST[$OBJ[$i]['name']]);
					 }*/
					foreach ($name->comboBox as $keyB => $valueB){
						if($name->comboBox[$keyB]['column']){
							$typeColumn = $name->comboBox[$keyB]['typeColumn'];
							if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
								if($name->comboBox[$keyB]['uppercase']===true){
									$_POST[$name->comboBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->comboBox[$keyB]['name']]);
								}
							}
							if(isset($_POST[$name->comboBox[$keyB]['name']])){
								if($name->comboBox[$keyB]['unique']===true){
									$this->sel = new iSelect($this->dataSet,$this->table);
									$this->sel->where($name->comboBox[$keyB]['whereForCheckUnique'], $name->comboBox[$keyB]['operatorForCheckUnique'], $name->comboBox[$keyB]['valueForCheckUnique'], true);
									$this->sel->setAnd($name->comboBox[$keyB]['column'],"=",$_POST[$name->comboBox[$keyB]['name']],true);
									$this->sel->exe();
								 	if($this->sel->getNumRows()>0){
								 		$this->changeBackgroundColor($name->comboBox[$keyB]['name'],false,$objFather);
								 		$this->errorForm = 3;
								 		$this->setMsgErro(3, msgErro3);
								 	}
								}
								if($name->comboBox[$keyB]['require']===true && strlen($_POST[$name->comboBox[$keyB]['name']])==0){
								    $this->changeBackgroundColor($name->comboBox[$keyB]['name'],false,$objFather);
									$this->errorForm = 1;
									$this->setMsgErro(1, msgErro1);
								}
								if($name->comboBox[$keyB]['minLen']!==false){
									if(strlen($_POST[$name->comboBox[$keyB]['name']])<$name->comboBox[$keyB]['minLen']){
								 		$this->changeBackgroundColor($name->comboBox[$keyB]['name'],false,$objFather);
								 		$this->errorForm = 4;
								 		$this->setMsgErro(4, msgErro4);
								 	}
								}
								$this->ins->insert($name->comboBox[$keyB]['column'],$_POST[$name->comboBox[$keyB]['name']]);
							}
						}
					}
					foreach ($name->textBox as $keyB => $valueB){
						if($name->textBox[$keyB]['column']){
							$typeColumn = $name->textBox[$keyB]['typeColumn'];
							if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
								if($name->textBox[$keyB]['uppercase']===true){
									$_POST[$name->textBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->textBox[$keyB]['name']]);
								}
							}
							if(isset($_POST[$name->textBox[$keyB]['name']])){
								if($name->textBox[$keyB]['unique']===true){
									$this->sel = new iSelect($this->dataSet,$this->table);
									$this->sel->where($name->textBox[$keyB]['whereForCheckUnique'], $name->textBox[$keyB]['operatorForCheckUnique'], $name->textBox[$keyB]['valueForCheckUnique'], true);
									$this->sel->setAnd($name->textBox[$keyB]['column'],"=",$_POST[$name->textBox[$keyB]['name']],true);
									$this->sel->exe();
									if($this->sel->getNumRows()>0){
										$this->changeBackgroundColor($name->textBox[$keyB]['name'],false,$objFather);
										$this->errorForm = 3;
										$this->setMsgErro(3, msgErro3);
									}
								}
								if($name->textBox[$keyB]['require']===true && strlen($_POST[$name->textBox[$keyB]['name']])==0){
									$this->changeBackgroundColor($name->textBox[$keyB]['name'],false,$objFather);
									$this->errorForm = 1;
									$this->setMsgErro(1, msgErro1);
								}
								if($name->textBox[$keyB]['minLen']!==false){
									if(strlen($_POST[$name->textBox[$keyB]['name']])<$name->textBox[$keyB]['minLen']){
										$this->changeBackgroundColor($name->textBox[$keyB]['name'],false,$objFather);
										$this->errorForm = 4;
										$this->setMsgErro(4, msgErro4);
									}
								}
								$this->ins->insert($name->textBox[$keyB]['column'],$_POST[$name->textBox[$keyB]['name']]);
							}
						}
					}
					foreach ($name->textBoxMultiLine as $keyB => $valueB){
						if($name->textBoxMultiLine[$keyB]['column']){
							$typeColumn = $name->textBoxMultiLine[$keyB]['typeColumn'];
							if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
								if($name->textBoxMultiLine[$keyB]['uppercase']===true){
									$_POST[$name->textBoxMultiLine[$keyB]['name']] = $this->stringToUpper($_POST[$name->textBoxMultiLine[$keyB]['name']]);
								}
							}
							if(isset($_POST[$name->textBoxMultiLine[$keyB]['name']])){
								if($name->textBoxMultiLine[$keyB]['unique']===true){
									$this->sel = new iSelect($this->dataSet,$this->table);
									$this->sel->where($name->textBoxMultiLine[$keyB]['whereForCheckUnique'], $name->textBoxMultiLine[$keyB]['operatorForCheckUnique'], $name->textBoxMultiLine[$keyB]['valueForCheckUnique'], true);
									$this->sel->setAnd($name->textBoxMultiLine[$keyB]['column'],"=",$_POST[$name->textBoxMultiLine[$keyB]['name']],true);
									$this->sel->exe();
									if($this->sel->getNumRows()>0){
										$this->changeBackgroundColor($name->testBoxMultiLine[$keyB]['name'],false,$objFather);
										$this->errorForm = 3;
										$this->setMsgErro(3, msgErro3);
									}
								}
								if($name->textBoxMultiLine[$keyB]['require']===true && strlen($_POST[$name->textBoxMultiLine[$keyB]['name']])==0){
									$this->changeBackgroundColor($name->textBoxMultiLine[$keyB]['name'],false,$objFather);
									$this->errorForm = 1;
									$this->setMsgErro(1, msgErro1);
								}
								if($name->textBoxMultiLine[$keyB]['minLen']!==false){
									if(strlen($_POST[$name->textBoxMultiLine[$keyB]['name']])<$name->textBoxMultiLine[$keyB]['minLen']){
										$this->changeBackgroundColor($name->textBoxMultiLine[$keyB]['name'],false,$objFather);
										$this->errorForm = 4;
										$this->setMsgErro(4, msgErro4);
									}
								}
								$this->ins->insert($name->textBoxMultiLine[$keyB]['column'],$_POST[$name->textBoxMultiLine[$keyB]['name']]);
							}
						}
					}
				}
				#}
				#}
				if($this->errorForm==0){
					if($this->resultInsert = $this->ins->exe()){
						$this->sql = $this->ins->getSql();
						$this->newId = $this->ins->getNewId();
						return true;
					}else{
						$this->setMsgErro(6, $this->dataSet->getError());
						$this->sql = $this->ins->getSql();
						return false;
					}
				}else{
					return false;
				}
			}
		}
	}
    public function exeFormUpdateEnd($multiObj=true,$objFather=false){
    	if(@$_POST["FORM_".$this->name]){
    		if($multiObj===true){
	            if($this->whereUpdate){
	                $this->upd->where($this->whereUpdate,$this->operatorUpdate,$this->valueUpdate);
		            if(isset($this->hidden) && count($this->hidden)>0){
		                foreach($this->hidden as $key => $value){
		                    $this->upd->set($this->column[$key],$value);
		                }
		            }
					$this->errorForm = 0;
					global $OBJ;
					for($i=0;$i<count($OBJ);$i++){
						if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine" || $OBJ[$i]['type']=="comboBox" || $OBJ[$i]['type']=="defineTime")){
							$name = $this->getObj($OBJ[$i]['name']);
		                    if($name->formName==$this->name){
		                    	if($name->getMoney()===true){
		                    		$_POST[$OBJ[$i]['name']] = $this->formatNumber($_POST[$OBJ[$i]['name']],2,"DECIMAL");
	                    		}else if($name->getNumber()!==false){
	                    			$_POST[$OBJ[$i]['name']] = $this->formatNumber($_POST[$OBJ[$i]['name']],$name->getNumber(),"DECIMAL");
		                    	}else{
		                    		$_POST[$OBJ[$i]['name']] = $this->fillText(@$_POST[$OBJ[$i]['name']]);
		                    	}
							    if($name->getRequired()===true && @$_POST[$OBJ[$i]['name']]==""){
								    $this->changeBackgroundColor($name);
								    $this->errorForm = 1;
								    $this->setMsgErro(1, msgErro1);
							    }else{ 
								    if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine")){
									    if($name->getCheck() && $this->verifyValue($_POST[$OBJ[$i]['name']],$name->check)===false){
										    $this->changeBackgroundColor($name);
										    $this->errorForm = 2;
										    $this->setMsgErro(2, msgErro2);
									    }
								    }
							    }
		                        if($name->getUnique()===true){
		                            if($this->dataSet->versao=="old"){
    		                            $this->sel = $this->dataSet->select();
    		                            $this->sel->set($this->table);
    		                            $this->sel->setWhere($name->whereForCheckUnique,$name->operatorForCheckUnique,$name->valueForCheckUnique,true,true);
    		                            $this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
    		                            $this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
    		                            $this->sel->Exe();
    		                            if($this->sel->getNumRows()>0){
    		                                $this->changeBackgroundColor($name);
    		                                $this->errorForm = 3;
    		                                $this->setMsgErro(3, msgErro3);
    		                            }
		                            }else{
		                                $this->sel = new iSelect($this->dataSet,$this->table);
		                                $this->sel->where($name->whereForCheckUnique,$name->operatorForCheckUnique,$name->valueForCheckUnique,true,true);
		                                $this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
		                                $this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
		                                $this->sel->exe();
		                                if($this->sel->getNumRows()>0){
		                                    $this->changeBackgroundColor($name);
		                                    $this->errorForm = 3;
		                                    $this->setMsgErro(3, msgErro3);
		                                }
		                            }
		                        }
		                        if($name->getMinimumLength()){
		                            if(strlen(@$_POST[$OBJ[$i]['name']])<$name->getMinimumLength()){
		                                $this->changeBackgroundColor($name);
		                                $this->errorForm = 4;
		                                $this->setMsgErro(4, msgErro4);
		                            }
		                        }
		                        if($name->getColumn()){
		                        	if($name->getTypeColumn()){
		                        		$typeColumn = $name->getTypeColumn();
		                        		if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
		                        			if($name->getUppercase()===true){
		                        				$_POST[$OBJ[$i]['name']] = $this->stringToUpper($_POST[$OBJ[$i]['name']]);
		                        			}
		                        		}
		                        	}
		                        	if(strlen(@$_POST[$OBJ[$i]['name']])>0){
		                            	$this->upd->set($name->getColumn(),$_POST[$OBJ[$i]['name']]);
		                        	}
		                        }
		                    }
						}
					}
	            }else{
	            	$this->errorForm = 5;
	            	$this->setMsgErro(5, msgErro5);
	            }
				if($this->errorForm==0){
					if($this->resultUpdate = $this->upd->exe()){
						$this->sql = $this->upd->getSql();
						return true;
					}else{
						$this->setMsgErro(6, $this->dataSet->getError());
						$this->sql = $this->upd->getSql();
						return false;
					}
				}else{
					return false;
				}
    		}else{
    			$name = $objFather;
    			if($this->whereUpdate){
    				$this->upd->where($this->whereUpdate,$this->operatorUpdate,$this->valueUpdate);
    				if($this->historic!==false){
    					$selB = new iSelect($this->dataSet,$this->table);
    					$selB->where($this->whereUpdate, $this->operatorUpdate, $this->valueUpdate);
    					$selB->exe();
    					
    					$rowB = $selB->read();
    					if(isset($rowB['historico'])){
    						$this->upd->set("historico",$this->getHistText($this->historic,$rowB['historico']));
    					}
    				}
    				if(isset($this->hidden) && count($this->hidden)>0){
    					foreach($this->hidden as $key => $value){
    						if(strlen($this->column[$key])>0){
    							$this->upd->set($this->column[$key],$value);
    						}
    					}
    				}
    				$this->errorForm = 0;
    				global $OBJ;
    						if($name->formName==$this->name){
    							foreach ($name->comboBox as $keyB => $valueB){
    								if($name->comboBox[$keyB]['column']){
    									$typeColumn = $name->comboBox[$keyB]['typeColumn'];
    									if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
    										if($name->comboBox[$keyB]['uppercase']===true){
    											$_POST[$name->comboBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->comboBox[$keyB]['name']]);
    										}
    									}
    									if(isset($_POST[$name->comboBox[$keyB]['name']])){
    										if($name->comboBox[$keyB]['unique']===true){
    											$this->sel = new iSelect($this->dataSet,$this->table);
    											$this->sel->where($name->comboBox[$keyB]['whereForCheckUnique'], $name->comboBox[$keyB]['operatorForCheckUnique'], $name->comboBox[$keyB]['valueForCheckUnique'], true);
    											$this->sel->setAnd($name->comboBox[$keyB]['column'],"=",$_POST[$name->comboBox[$keyB]['name']],true);
    											$this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
    											$this->sel->exe();
    											if($this->sel->getNumRows()>0){
    												$this->changeBackgroundColor($name->comboBox[$keyB]['name'],false,$objFather);
    												$this->errorForm = 3;
    												$this->setMsgErro(3, msgErro3);
    											}
    										}
    										if($name->comboBox[$keyB]['require']===true && strlen($_POST[$name->comboBox[$keyB]['name']])==0){
    											$this->changeBackgroundColor($name->comboBox[$keyB]['name'],false,$objFather);
    											$this->errorForm = 1;
    											$this->setMsgErro(1, msgErro1);
    										}
    										if($name->comboBox[$keyB]['minLen']!==false){
    											if(strlen($_POST[$name->comboBox[$keyB]['name']])<$name->comboBox[$keyB]['minLen']){
    												$this->changeBackgroundColor($name->comboBox[$keyB]['name'],false,$objFather);
    												$this->errorForm = 4;
    												$this->setMsgErro(4, msgErro4);
    											}
    										}
    										$this->upd->set($name->comboBox[$keyB]['column'],$_POST[$name->comboBox[$keyB]['name']]);
    									}
    								}
    							}
    							foreach ($name->textBox as $keyB => $valueB){
    								if($name->textBox[$keyB]['column']){
    									$typeColumn = $name->textBox[$keyB]['typeColumn'];
    									if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
    										if($name->textBox[$keyB]['uppercase']===true){
    											$_POST[$name->textBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->textBox[$keyB]['name']]);
    										}
    									}
    									if(isset($_POST[$name->textBox[$keyB]['name']])){
    										if($name->textBox[$keyB]['unique']===true){
    											$this->sel = new iSelect($this->dataSet,$this->table);
    											$this->sel->where($name->textBox[$keyB]['whereForCheckUnique'], $name->textBox[$keyB]['operatorForCheckUnique'], $name->textBox[$keyB]['valueForCheckUnique'], true);
    											$this->sel->setAnd($name->textBox[$keyB]['column'],"=",$_POST[$name->textBox[$keyB]['name']],true);
    											$this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
    											$this->sel->exe();
    											if($this->sel->getNumRows()>0){
    												$this->changeBackgroundColor($name->textBox[$keyB]['name'],false,$objFather);
    												$this->errorForm = 3;
    												$this->setMsgErro(3, msgErro3);
    											}
    										}
    										if($name->textBox[$keyB]['require']===true && strlen($_POST[$name->textBox[$keyB]['name']])==0){
    											$this->changeBackgroundColor($name->textBox[$keyB]['name'],false,$objFather);
    											$this->errorForm = 1;
    											$this->setMsgErro(1, msgErro1);
    										}
    										if($name->textBox[$keyB]['minLen']!==false){
    											if(strlen($_POST[$name->textBox[$keyB]['name']])<$name->textBox[$keyB]['minLen']){
    												$this->changeBackgroundColor($name->textBox[$keyB]['name'],false,$objFather);
    												$this->errorForm = 4;
    												$this->setMsgErro(4, msgErro4);
    											}
    										}
    										$this->upd->set($name->textBox[$keyB]['column'],$_POST[$name->textBox[$keyB]['name']]);
    									}
    								}
    							}
    							foreach ($name->textBoxMultiLine as $keyB => $valueB){
    								#if($name->textBoxMultiLine[$keyB]['name']==$OBJ[$i]['name']){
    									if($name->textBoxMultiLine[$keyB]['column']){
    										$typeColumn = $name->textBoxMultiLine[$keyB]['typeColumn'];
    										if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
    											if($name->textBoxMultiLine[$keyB]['uppercase']===true){
    												$_POST[$name->textBoxMultiLine[$keyB]['name']] = $this->stringToUpper($_POST[$name->textBoxMultiLine[$keyB]['name']]);
    											}
    										}
    										if(isset($_POST[$name->textBoxMultiLine[$keyB]['name']])){
    											if($name->textBoxMultiLine[$keyB]['unique']===true){
    												$this->sel = new iSelect($this->dataSet,$this->table);
    												$this->sel->where($name->textBoxMultiLine[$keyB]['whereForCheckUnique'], $name->textBoxMultiLine[$keyB]['operatorForCheckUnique'], $name->textBoxMultiLine[$keyB]['valueForCheckUnique'], true);
    												$this->sel->setAnd($name->textBoxMultiLine[$keyB]['column'],"=",$_POST[$name->textBoxMultiLine[$keyB]['name']],true);
    												$this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
    												$this->sel->exe();
    												if($this->sel->getNumRows()>0){
    													$this->changeBackgroundColor($name->testBoxMultiLine[$keyB]['name'],false,$objFather);
    													$this->errorForm = 3;
    													$this->setMsgErro(3, msgErro3);
    												}
    											}
    											if($name->textBoxMultiLine[$keyB]['require']===true && strlen($_POST[$name->textBoxMultiLine[$keyB]['name']])==0){
    												$this->changeBackgroundColor($name->textBoxMultiLine[$keyB]['name'],false,$objFather);
    												$this->errorForm = 1;
    												$this->setMsgErro(1, msgErro1);
    											}
    											if($name->textBoxMultiLine[$keyB]['minLen']!==false){
    												if(strlen($_POST[$name->textBoxMultiLine[$keyB]['name']])<$name->textBoxMultiLine[$keyB]['minLen']){
    													$this->changeBackgroundColor($name->textBoxMultiLine[$keyB]['name'],false,$objFather);
    													$this->errorForm = 4;
    													$this->setMsgErro(4, msgErro4);
    												}
    											}
    											$this->upd->set($name->textBoxMultiLine[$keyB]['column'],$_POST[$name->textBoxMultiLine[$keyB]['name']]);
    										}
    									}
    								#}
    							}
    						}
    					#}
    				#}
    			}else{
    				$this->errorForm = 5;
    				$this->setMsgErro(5, msgErro5);
    			}
    			if($this->errorForm==0){
    				if($this->resultUpdate = $this->upd->exe()){
    					$this->sql = $this->upd->getSql();
    					return true;
    				}else{
    					$this->setMsgErro(6, $this->dataSet->getError());
    					$this->sql = $this->upd->getSql();
    					return false;
    				}
    			}else{
    				return false;
    			}
    		}
		}else{
			return null;
		}
	}
	public function getSql(){
		return $this->sql;
	}
	public function getAutocompleteOff(){
		return $this->autoCompleteOff;
	}
	public function setAutocompleteOff(){
		$this->autoCompleteOff = false;
	}
	public function End(){	
		global $page;
		global $PATH;
		global $PAGENAME;
		
		if($this->autoCompleteOff===true){
			$this->autoCompleteOff = " autocomplete=\"off\"";
		}else{
			$this->autoCompleteOff = "";
		}
		if($this->target===false){
			$this->e("<form id=\"".$this->name."\" name=\"".$this->name."\" method=\"".$this->method."\" action=\"".$this->action."\" enctype=\"multipart/form-data\"".$this->java->getLineCommand($this->objAction).$this->autoCompleteOff.">",$this->nivel);
		}else{
			$this->e("<form id=\"".$this->name."\" name=\"".$this->name."\" method=\"".$this->method."\" action=\"".$this->action."\" target=\"".$this->target."\" enctype=\"multipart/form-data\"".$this->java->getLineCommand($this->objAction).$this->autoCompleteOff.">",$this->nivel);
		}
		$this->e("<input type=\"hidden\" id=\"FORM_".$this->name."\" name=\"FORM_".$this->name."\" value=\"1\" />",$this->nivel+1);
        if(isset($this->hidden) && count($this->hidden)>0){
            foreach($this->hidden as $key => $value){
                $this->e("<input type=\"hidden\" id=\"".$key."\" name=\"".$key."\" value=\"".$value."\" />",$this->nivel+1);
            }
        }
        # AUTO BUILD
        if(count($this->autoBuildColumns)>0){
        	$page->session->setSession($this->name."_AUTOBUILDCOLUMNS",$this->autoBuildColumns);
        	
        	# SET FUNCTION BUTTON CANCEL
        	if($this->autoBuildButtonCancel['func']=="setGoToPanel"){
        		$this->setGoToPanel($this->name."btAutoCancelarA", $this->autoBuildButtonCancel['panel']);
        		$this->setGoToPanel($this->name."btAutoCancelarB", $this->autoBuildButtonCancel['panel']);
        		$this->setGoToPanel($this->name."btAutoCancelarC", $this->autoBuildButtonCancel['panel']);
        	}else if($this->autoBuildButtonCancel['func']=="reset"){
        		$this->reset($this->name."btAutoCancelarA");
        		$this->reset($this->name."btAutoCancelarB");
        		$this->reset($this->name."btAutoCancelarC");
        	}
        	
        	if($this->titleDivision!==false){
        		$lyt = new newTable($this, "lytDiv".$this->name);
        		$lyt->line();
        		$lyt->cell();
        		$lyt->inSideSpan($this->titleDivision,"msgInfo");
        		$lyt->line();
        		$lyt->cell("division",2000);
        		$lyt->line(tblLayOutSpcTr);
        	}
        	
        	$lyt = new newTable($this, "lyt".$this->name);
        	$lyt->setWithoutCell();
        	
        	$first = true;
        	$firstCell = true;
        	foreach ($this->autoBuildColumns as $key => $value){
        		if($value['create']===true){
        			if($first===true){
        				$first = false;
        				$lyt->line($value['typeLine']);
        			}else{
        				if($value['createLine']===true){
        					$firstCell = true;
        					$lyt->line($value['typeLine']);
        				}
        			}
        			if($firstCell===true){
        				$firstCell = false;
        				$lyt->cell();
        			}else{
        				$lyt->cell($value['typeCell']);
        			}
        			$lyt->inSideBold($value['label']."<br>");
        			if($value['typeObj']=="textBox" || $value['typeObj']=="textBoxMultiLine" || $value['typeObj']=="textBoxNumber"){
        				if($value['Field']=="id".str_replace(" ", "",ucwords(str_replace("_", " ",$this->table))) && $value['typeObj']=="textBox"){
        					$lyt->inSide("<div id=\"btAnt".$this->name."\" class=\"bigButtonB bigButtonDes\"><</div>");
        					$lyt->inSide("<div id=\"btPro".$this->name."\" class=\"bigButtonB bigButtonDes\" style=\"float:right;margin-left:5px;margin-right:-1px;\">></div>");
        					$lyt->java->setGoToPage("click", "btAnt".$this->name, $PATH."../RCD_7/iFormScriptInsertUpdate.php",$this->id,false,"","@".$PAGENAME."&PAGENAME=".$PAGENAME."&PARAMETER=".$this->id."&PANEL=".$this->panel."&TYPE=FILL&DATASET=".$this->dataSet->getDataSetName()."&TABLE=".$this->table."&FORM=".$this->name,"",$this->name."KeyAnt","objCorelyt".$this->name."0");
        					$lyt->java->setGoToPage("click", "btPro".$this->name, $PATH."../RCD_7/iFormScriptInsertUpdate.php",$this->id,false,"","@".$PAGENAME."&PAGENAME=".$PAGENAME."&PARAMETER=".$this->id."&PANEL=".$this->panel."&TYPE=FILL&DATASET=".$this->dataSet->getDataSetName()."&TABLE=".$this->table."&FORM=".$this->name,"",$this->name."KeyPro","objCorelyt".$this->name."0");
        				}
        				if($value['typeObj']=="textBox"){
        					$lyt->textBox("tb".ucwords($value['Field']),$value['Field']);
        				}else if($value['typeObj']=="textBoxNumber"){
        					$lyt->textBox("tb".ucwords($value['Field']),$value['Field'],"textBox","number");
        				}else{
        					$lyt->textBoxMultiLine("tb".ucwords($value['Field']),$value['Field']);
        				}
        				if(strpos($value['sizeField'], "x")!==false){
        					$value['sizeField'] = str_replace("x", "px;height:", $value['sizeField']);
        				}
        				$lyt->addStyles("tb".ucwords($value['Field']), width.$value['sizeField']."px");
        				$lyt->addStyles("tb".ucwords($value['Field']), textAlign.$value['align']);
        				if($value['backgroundColor']!==false){
        					$lyt->addStyles("tb".ucwords($value['Field']), backGroundColor.$value['backgroundColor']);
        				}
        				if($value['color']!==false){
        					$lyt->addStyles("tb".ucwords($value['Field']), color.$value['color']);
        				}
        				if($value['cursor']!==false){
        					$lyt->addStyles("tb".ucwords($value['Field']), cursor);
        				}
        				if($value['readOnly']===true){
        					$lyt->readOnly("tb".ucwords($value['Field']));
        				}
        				
        				if(isset($value['mask'])){
        					$value['value'] = @$value['mask'][$value['value']];
        				}
        				
        				if(isset($value['formatDate'])){
        					if($value['formatDate']['enable']===true){
        						$value['value'] = $page->formatDate($value['value'],$value['formatDate']['by'],$value['formatDate']['mode']);
        					}
        				}
        				
        				$lyt->value("tb".ucwords($value['Field']), $value['value']);
        				if(strpos($value['Field'],"id")!==false){
        					#$lyt->cell();
        					
        				}
        			}else if($value['typeObj']=="comboBox"){
        				$lyt->comboBox("cb".ucwords($value['Field']),$value['Field']);
        				if(is_array($value['optionsComboBox'])){
	        				foreach ($value['optionsComboBox'] as $keyB => $valueB){
	        					$lyt->optionComboBox("cb".ucwords($value['Field']), $keyB, $valueB);
	        				}
        				}else{
        					if(isset($value['value2'])){
        						if($value['value2']===true){
        							$lyt->optionComboBox("cb".ucwords($value['Field']), "", "");
        						}
        					}
        					$tableComboBox = $value['optionsComboBox'];
        					$fieldIdNameTableComboBox = "id".str_replace(" ", "",ucwords(str_replace("_", " ",$tableComboBox)));
        					$fieldStatusNameTableComboBox = "status".str_replace(" ", "",ucwords(str_replace("_", " ",$tableComboBox)));
        					$lyt->setFillComboBox("cb".ucwords($value['Field']), $fieldIdNameTableComboBox, $value['param2'], $this->dataSet, $tableComboBox, $fieldStatusNameTableComboBox, "=", "1",$value['param2']);
        				}
        				$lyt->value("cb".ucwords($value['Field']), $value['value']);
        				if($value['sizeField']!==false){
        					if(strpos($value['sizeField'], "x")!==false){
        						$value['sizeField'] = str_replace("x", "px;height:", $value['sizeField']);
        					}
        					$lyt->addStyles("cb".ucwords($value['Field']), width.$value['sizeField']."px");
        				}
        				if(strpos($value['Field'], "estado")!==false){
        					$lyt->java->setGoToPage("change", "cb".ucwords($value['Field']),$PATH."../RCD_7/iFormScriptInsertUpdate.php",$this->name."_ESTADO",false,false,"&FORM=".$this->name."&TYPE=CID&".$this->name."_FIELD=cb".ucwords(str_replace("estado", "cidade", $value['Field'])),false,"cb".ucwords($value['Field']),"objCorelyt".$this->name."0");
        				}
        			}else if($value['typeObj']=="file"){
        				$lyt->file("fl".ucwords($value['Field']),$value['Field']);
        			}
        		}
        	}
        	 
        	# CONSTROE OS BOTÕES
        	if(count($this->autoBuildButtons)>0){
        		$lyt->line(tblLayOutSpcTr);
        		$lyt->cell();
        		$lastGroup = false;
        		if($this->status===false){
        			$group = $this->groupIns;
        		}else if($this->status=="1"){
        			$group = $this->groupUpd;
        		}else{
        			$group = $this->groupDes;
        		}
        		foreach ($this->autoBuildButtons as $keyC => $valueC){
        			foreach ($valueC as $keyD => $valueD){
	        			if($lastGroup!=$keyC){
	        				if($lastGroup!==false){
	        					$lyt->inSide("</div>");
	        				}
	        				$lastGroup = $keyC;
	        				
	        				if($keyC!=$group){
		        				$lyt->inSide("<div id=\"".$this->name."_group_".$keyC."\" style=\"display:none\">");
	        				}else{
	        					$lyt->inSide("<div id=\"".$this->name."_group_".$keyC."\" style=\"display:block\">");
	        				}
	        			}
        			
        				$lyt->button($valueD['name'], $valueD['label'], $valueD['class'],false,false,$valueD['createLine']);
        			}
        		}
        		$lyt->inSide("</div>");
        	}
        }
        # FIM - AUTO BUILD
        $this->endObj($this->name);
		$this->e("</form>",$this->nivel);
		if($this->exeInsert===true){
			$this->exeFormInsertEnd();
		}
		if($this->exeUpdate===true){
			$this->exeFormUpdateEnd();
		}
	}
}