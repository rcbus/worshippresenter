<?php
# Data Table Adapter
class dataTableAdapter extends generic {
	private $subLayer;
	private $father;
    private $dataBase;
    private $select;
    private $numRowsTotal;
    private $row;
    private $button = array();
    private $textBox;
    private $columnButtonTitle;
    private $buttonActionScript;
    private $columns = array();
    private $columnsFake = array();
    private $columnsHidden = array();
    private $columnsWidth = array();
    private $columnsMask = array();
    private $columnsArrayToMask = array();
    private $columnsAddValue = array();
    private $columnsValue = array();
    private $columnsAddValueArray = array();
    private $columnsValueArray = array();
    private $columnsParameterArray = array();
    private $columnsParameterAdditionalArray = array();
    private $columnsNameObjInner = array();
    private $columnsParameter = array();
    private $columnsMathType = array();
    private $columnsMathBy = array();
    private $Class;
    private $formatCondition = array();
    private $formatConditionNew = array();
    private $objCondition;
    private $aligns;
    private $res;
    private $columnParameterGoToPage;
    private $columnParameterSetValue;
    private $orderBy = array();
    private $typeOrder = array();
    private $columnsThisTableActionOnClickAddPageColumn = false;
    private $columnsThisTableActionOnClick = array();
    private $columnsThisTableActionSetValue = array();
    private $columnsThisTableActionSetFocus = array();
    private $columnsThisTableActionSetClose = array();
    private $objActionSetValue = array();
    private $columnFilter;
    private $columnFilterValue;
    private $titleTable = "Title Data Table";
    private $limit = 100;
    private $page;
    private $label;
    private $labelPrevious = "Anterior";
    private $labelNext = "Próxima";
    private $numErrors;
    private $msgError;
    private $columnsAsFormatDate = array();
    private $columnsAsMoney = array();
    private $columnsAsNumber = array();
    private $columnsAsNumberDecimals = array();
    private $columnsAsNumTel = array();
    private $pathScriptCommand;
    private $standardColor = 1;
    private $isArray;
    private $numRead = 0;
    private $totalRowsArray = 0;
    private $columnsSumTotal = array();
    private $columnsMathColumn = array();
    private $contRowsArray = 0;
    private $columnsInfoPreviews = array();
    private $columnsInfoNext = array();
    private $checkBox = array();
    private $actionScriptStandard = false;
    private $commandReloadScript = false;
    private $commandReloadScriptObj = false;
    private $commandReloadScriptScript = false;
    private $orderColumns = false;
    private $columnsAsRgIe = array();
    private $columnsAsCpfCnpj = array();
    private $columnsAsPlaca = array();
    private $uppercase = true;
    public $showSql = false;
    public $sql;
    public $css;
    public $java;
    public $javaB;

    function __construct($father,$name,$dataSet=false,$class="",$subLayer=0){
        $this->father = $father;
		$this->subLayer = $subLayer;
		$this->name = $name;
		if($this->father!==false){
			$this->layer = $this->father->getFatherLayer();
			$this->nivel = $this->father->getNivel();
			$this->table = $this->father->getTable();
			$this->formName = $this->father->getFormName();
			$this->uppercase = $this->father->getUpperCase();
		}else{
			$this->nivel = $nivel;
		}
        $this->Class = $class;
        $this->css = new style($this->name);
		$this->newObj($this->css,"STYLE_".$this->name,"style",$this->name);
		$this->java = new java();
        $this->newObj($this->java,"JAVA_".$this->name,"java",$this->name);
        $this->javaB = new java();
        $this->newObj($this->javaB,"JAVAB_".$this->name,"java",$this->name);
        $this->javaC = new java();
        $this->newObj($this->javaC,"JAVAC_".$this->name,"java",$this->name);
        if($dataSet!=false){
			if($dataSet->versao=="old"){
				global $idsa;
				$this->dataBase = $idsa;
			}else{
				$this->dataBase = $dataSet;
			}
	        /*$this->dataBase = new dataBase("dataSet");
	        $this->dataBase = $dataSet;
	        $this->select = $this->dataBase->select();*/
        }else{
        	$this->dataBase = false;
        }
		$this->newObj($this,$this->name,"dataTableAdapter",$this->father->getName());
        $this->loadSetOrder();
        $this->loadSetFilter();
        $this->loadSetPage();
        $this->actionScriptStandard = $_SERVER['SCRIPT_NAME'];
    }
    
    public function getUpperCase(){
    	return $this->uppercase;
    }
    
    public function setCommandReloadScript($obj,$script){
    	$this->commandReloadScript = true;
    	$this->commandReloadScriptObj = $obj;
    	$this->commandReloadScriptScript = $script;
    }
    public function setActionScriptStandard($actionScript){
    	$this->actionScriptStandard = $actionScript;
    }
    public function setColumnsInfoPreviews($column,$parameter,$pagename=false){
    	$id = count($this->columnsInfoPreviews);
    	$this->columnsInfoPreviews[$id]['column'] = $column;
    	$this->columnsInfoPreviews[$id]['parameter'] = $parameter;
    	$this->columnsInfoPreviews[$id]['pagename'] = $pagename;
    }
    public function setColumnsSumTotal($columns){
    	$this->columnsSumTotal = explode(",", $columns);
    }
    public function setStandardColor($number){
    	$this->standardColor = $number;
    }
    public function setWithOutTitle(){
    	$this->withOutTitle = true;
    }
    public function setWithOutSubTitle(){
    	$this->withOutSubTitle = true;
    }
    public function setColumnsMath($column,$type,$by){
    	$id = count($this->columnsMathColumn);
    	$this->columnsMathColumn[$id] = $column;
    	$this->columnsMathType[$id] = $type;
    	$this->columnsMathBy[$id] = $by;
    }
    public function setColumnHidden($column){
    	$id = count($this->columnsHidden);
    	$this->columnsHidden[$id] = $column;
    }
    public function setColumnsAddValue($column,$value,$mathType=false,$valueOrColumnA=false,$valueOrColumnB=false,$valueType=false){
    	if($mathType===false){
    		$mathType = "sum";
    	}
    	$id = count($this->columnsAddValue);
    	$this->columnsAddValue[$id] = $column;
    	$this->columnsAddValueMathType[$id] = $mathType;
    	$this->columnsValueOrColumnA[$id] = $valueOrColumnA;
    	$this->columnsValueOrColumnB[$id] = $valueOrColumnB;
    	$this->columnsAddValueType[$id] = $valueType;
    	$this->columnsValue[$id] = $value;
    }
    public function setColumnsAddValueArray($column,$array,$columnParameter,$parameterAdditional=false){
    	$id = count($this->columnsAddValueArray);
    	$this->columnsAddValueArray[$id] = $column;
    	$this->columnsValueArray[$id] = $array;
    	$this->columnsParameterArray[$id] = $columnParameter;
    	$this->columnsParameterAdditionalArray[$id] = $parameterAdditional;
    }
    public function setPathScriptCommand($path){
    	$this->pathScriptCommand = $path;
    }
    public function getNumErrors(){
        return $this->numErrors;
    }
    public function getMsgError(){
        return $this->msgError;
    }
    public function getSql(){
        return $this->sql;
    }
    private function loadSetPage(){
    	global $page;
        if($page->session->getSession("formDataTableAdapterB".$this->getName()) || $page->session->getSession("formDataTableAdapterA".$this->getName())){
            $currentPage = $page->session->getSession("dataTableAdapterPage".$this->name,$page->getName());
            if($page->session->getSession("formDataTableAdapterB".$this->getName())){
            	$currentPage = $page->session->getSession("formDataTableAdapterB".$this->getName());
            	$page->session->unSetSession("formDataTableAdapterB".$this->getName());
            }
            if($page->session->getSession("formDataTableAdapterA".$this->getName())){
            	$currentPage = $page->session->getSession("formDataTableAdapterA".$this->getName());
            	$page->session->unSetSession("formDataTableAdapterA".$this->getName());
            }
            $page->session->setSession("dataTableAdapterPage".$this->name,$currentPage,$page->getName());
            $currentPage = $page->session->getSession("dataTableAdapterPage".$this->name,$page->getName());
            if($currentPage<1){
            	$this->page = 0;
            }else{
            	$this->page = ($currentPage - 1);
            }
        }else{
        	$currentPage = $page->session->getSession("dataTableAdapterPage".$this->name,$page->getName());
        	if($currentPage<1){
        		$this->page = 0;
        	}else{
        		$this->page = ($currentPage - 1);
        	}
        }
    }
    public function setColumnsAsRgIe($column){
    	$id = count($this->columnsAsRgIe);
    	$this->columnsAsRgIe[$id] = $column;
    }
    public function setColumnsAsCpfCnpj($column){
    	$id = count($this->columnsAsCpfCnpj);
    	$this->columnsAsCpfCnpj[$id] = $column;
    }
    public function setColumnsAsPlaca($column){
    	$id = count($this->columnsAsPlaca);
    	$this->columnsAsPlaca[$id] = $column;
    }
    public function setColumnsAsFormatDate($column,$by="",$mode=""){
    	$arrayColumns = explode(",", $column);
    	foreach ($arrayColumns as $key => $value){
	    	$id = count($this->columnsAsFormatDate);
	    	$this->columnsAsFormatDate[$id] = $arrayColumns[$key];
	    	$this->columnsAsFormatDateBy[$id] = $by;
	    	$this->columnsAsFormatDateMode[$id] = $mode;
    	}
    }
    public function setColumnsAsMoney($column){
    	$id = count($this->columnsAsMoney);
    	$this->columnsAsMoney[$id] = $column;
    }
    public function setColumnsAsNumber($column,$decimals=2){
    	$id = count($this->columnsAsNumber);
    	$this->columnsAsNumber[$id] = $column;
    	$this->columnsAsNumberDecimals[$id] = $decimals;
    }
    public function setColumnsAsNumTel($column){
    	$id = count($this->columnsAsNumTel);
    	$this->columnsAsNumTel[$id] = $column;
    }
    public function setColumnsMask($column,$arrayToMask){
    	$id = count($this->columnsMask);
    	$this->columnsMask[$id] = $column;
    	if(is_array($arrayToMask)){
    		$this->columnsArrayToMask[$id] = $arrayToMask;
    	}else if(isset($arrayToMask)){
    		$this->columnsArrayToMask[$id] = explode(",", $arrayToMask);
    	}else{
    		$this->columnsArrayToMask[$id] = array();
    	}
    }
    public function setLabel($previous,$next){
        $this->labelPrevious = $previous;
        $this->labelNext = $next;
    }
    public function setPositionLabel($x,$y,$colorText="rgb(0,0,0)"){
    	@$this->label->x = $x;
    	@$this->label->y = $y;
    	@$this->label->colorText = $colorText;
    }
    public function setLimit($limit,$page=1){
        if($page>0){
            $page--;
        }
        #$this->page = $page;
        $this->limit = $limit;
    }
    public function setTitle($title){
        $this->titleTable = $title;
    }
    public function setColumnFilter($column,$withQuotation=false){
        $this->columnFilter = $column;
        $this->filterWithQuotation = $withQuotation;
    }
    private function loadSetFilter(){
        global $HTML;
        $pageName = $HTML->pageName;
        $page = $HTML->$pageName;
        if($page->session->getSession("dataTableAdapterFilterColumn")!=""){
            $this->columnFilterValue = $page->session->getSession("dataTableAdapterFilterColumnA",$pageName);
            if($page->session->getSession("dataTableAdapterFilterColumn")==$this->columnFilterValue){
                $this->columnFilterValue = "";
            }else{
                $this->columnFilterValue = $page->session->getSession("dataTableAdapterFilterColumn");
            }
            $page->session->unSetSession("dataTableAdapterFilterColumn");
            $page->session->setSession("dataTableAdapterFilterColumnA",$this->columnFilterValue,$pageName);
            $this->refresh();
        }else{
            $this->columnFilterValue = $page->session->getSession("dataTableAdapterFilterColumnA",$pageName);
        }
    }
    private function unSetFilter(){
    	global $HTML;
    	$pageName = $HTML->pageName;
    	$page = $HTML->$pageName;
    	$page->session->unSetSession("dataTableAdapterFilterColumn");
    	$page->session->unSetSession("dataTableAdapterFilterColumnA",$pageName);
    }
    private function loadSetOrder(){
        global $HTML;
        $pageName = $HTML->pageName;
        $page = $HTML->$pageName;
        if($page->session->getSession("dataTableAdapterOrderBy".$this->name)!=""){
            $this->orderBy = explode(",",$page->session->getSession("dataTableAdapterOrderBy".$this->name,$pageName));
            $this->typeOrder = explode(",",$page->session->getSession("dataTableAdapterTypeOrder".$this->name,$pageName));
            $setted = 0;
            foreach($this->orderBy as $key => $value){
                #$this->e($value);
                if($page->session->getSession("dataTableAdapterOrderBy".$this->name)==$value){
                    $setted = 1;
                    if($this->typeOrder[$key]=="ASC"){
                    	$this->typeOrder[$key] = "DESC";
                    }else{
                    	unset($this->orderBy[$key]);
                    }
                }
            }
            if($setted==0){
            	$id = count($this->orderBy);
                $this->orderBy[$id] = $page->session->getSession("dataTableAdapterOrderBy".$this->name);
                $this->typeOrder[$id] = "ASC";
            }
            $delimiter = "";
            $implode = "";
            $implodeTypeOrder = "";
            foreach($this->orderBy as $key => $value){
                if($value!=""){
                    $implode .= $delimiter.$value;
                    $implodeTypeOrder .= $delimiter.$this->typeOrder[$key];
                    $delimiter = ",";
                }
            }
            $page->session->unSetSession("dataTableAdapterOrderBy".$this->name);
            $page->session->setSession("dataTableAdapterOrderBy".$this->name,$implode,$pageName);
            $page->session->setSession("dataTableAdapterTypeOrder".$this->name,$implodeTypeOrder,$pageName);
            $this->refresh();
        }else{
            $this->orderBy = explode(",",$page->session->getSession("dataTableAdapterOrderBy".$this->name,$pageName));
            $this->typeOrder = explode(",",$page->session->getSession("dataTableAdapterTypeOrder".$this->name,$pageName));
        }
    }
    private function getOrder(){
        $delimiter = "";
        $implode = "";
        foreach($this->orderBy as $key => $value){
            if($value!=""){
                $implode .= $delimiter.$value;
                $delimiter = ",";
            }
        }
        return $implode;
    }
    private function getTypeOrder(){
    	$delimiter = "";
    	$implode = "";
    	foreach($this->typeOrder as $key => $value){
    		if($value!=""){
    			$implode .= $delimiter.$value;
    			$delimiter = ",";
    		}
    	}
    	return $implode;
    }
    public function setActionOnClick($goToPage,$parameter,$column,$columnsThisTable,$pageName="",$addPageColumn=false){
        $this->columnsThisTableActionOnClick = explode(",",$columnsThisTable);
        $this->columnParameterGoToPage = $column;
        $this->columnsThisTableActionOnClickAddPageColumn = $addPageColumn;
        $this->java->setOnClick();
        if($addPageColumn===true){
        	$target = "_blank";
        }else{
        	$target = "";
        }
        if($pageName!=""){
        	$this->java->setFunctionGoToPage($goToPage,$parameter,false,$target,"@".$pageName,$addPageColumn);
        }else{
        	$this->java->setFunctionGoToPage($goToPage,$parameter,false,$target,"",$addPageColumn);
        }
    }
    public function setActionSetValue($event,$obj,$value="",$columnsThisTable){
    	$id = count($this->objActionSetValue);
    	$this->objActionSetValue[$id]['columnsThisTableActionSetValue'] = explode(",",$columnsThisTable);
    	$this->objActionSetValue[$id]['columnParameterSetValue'] = $value;
    	$this->objActionSetValue[$id]['objSetValue'] = $obj;
    	if($this->stringToUpper($event)=="CLICK"){
    		$this->java->setOnClick();
    	}
    	$this->java->setFunctionSetValue($obj,false,"@var".$id);
    }
    public function setActionSetFocus($event,$obj,$columnsThisTable){
    	$this->columnsThisTableActionSetFocus = explode(",",$columnsThisTable);
    	if($this->stringToUpper($event)=="CLICK"){
    		$this->java->setOnClick();
    	}
    	$this->java->setFunctionSetFocus($obj);
    }
    public function setActionSetClose($event,$obj,$columnsThisTable){
    	$this->columnsThisTableActionSetClose = explode(",",$columnsThisTable);
    	if($this->stringToUpper($event)=="CLICK"){
    		$this->java->setOnClick();
    	}
    	$this->java->setFunctionCloseObj($obj);
    }
    public function setColumnsAlign($aligns){
        $this->aligns = explode(",",$aligns);
    }
    public function setColumnsFake($columnsFake=""){
        $this->columnsFake = explode(",",$columnsFake);
    }
    public function setColumnsWidth($columnsWidth=""){
    	$this->columnsWidth = explode(",",$columnsWidth);
    }
    public function setSelect($select,$isArray=false){
    	$this->select = $select;
    	$this->isArray = $isArray;
    	if($isArray==true){
    		$contRows = 0;
    		foreach ($select as $key){
    			$contRows++;
    		}
    		#$this->e("Total ".$contRows);
    		$this->totalRowsArray = $contRows;
    	}
    }
    public function setFormatCondition($name,$whereCondition,$valueCondition,$backgroundColor="",$color="",$affectLine=false,$operator="=",$notNull=true,$operatorB="",$columnChangeOperator="",$repeat=false,$sendToColumn=false,$addClass=""){
    	$id = count($this->formatCondition);
    	$this->formatCondition[$id] = $name;
    	@$this->objCondition->$name->whereCondition = $whereCondition;
        $this->objCondition->$name->valueCondition = $valueCondition;
        $this->objCondition->$name->operator = $operator;
        $this->objCondition->$name->operatorB = $operatorB;
        $this->objCondition->$name->columnChangeOperator = $columnChangeOperator;
        if($backgroundColor!=""){
        	$this->objCondition->$name->backgroundColor = "background:".$backgroundColor.";";
        }else{
        	$this->objCondition->$name->backgroundColor = $backgroundColor;
        }
        if($color!=""){
        	$this->objCondition->$name->color = "color:".$color.";";
        }else{
        	$this->objCondition->$name->color = $color;
        }
        $this->objCondition->$name->affectLine = $affectLine;
        $this->objCondition->$name->notNull = $notNull;
        $this->objCondition->$name->repeat = $repeat;
        $this->objCondition->$name->sendToColumn = $sendToColumn;
        $this->objCondition->$name->addClass = $addClass;
    }
 	/*public function setFormatConditionNew($name,$whereCondition,$operator="=",$valueCondition,$backgroundColor="",$color="",$affectLine=false,$sendToColumn=false,$addClass=""){
    	$id = count($this->formatCondition);
    	$this->formatCondition[$id] = $name;
    	@$this->objCondition->$name->whereCondition = $whereCondition;
    	$this->objCondition->$name->valueCondition = $valueCondition;
    	$this->objCondition->$name->operator = $operator;
    	$this->objCondition->$name->operatorB = $operatorB;
    	$this->objCondition->$name->columnChangeOperator = $columnChangeOperator;
    	if($backgroundColor!=""){
    		$this->objCondition->$name->backgroundColor = "background:".$backgroundColor.";";
    	}else{
    		$this->objCondition->$name->backgroundColor = $backgroundColor;
    	}
    	if($color!=""){
    		$this->objCondition->$name->color = "color:".$color.";";
    	}else{
    		$this->objCondition->$name->color = $color;
    	}
    	$this->objCondition->$name->affectLine = $affectLine;
    	$this->objCondition->$name->notNull = $notNull;
    	$this->objCondition->$name->repeat = $repeat;
    	$this->objCondition->$name->sendToColumn = $sendToColumn;
    	$this->objCondition->$name->addClass = $addClass;
    }*/
    public function setOrderColumns($columns){
    	$this->orderColumns = explode(",", $columns);
    }
    public function read(){
    	if($this->isArray===false){
    		$row = $row = $this->res->fetch_assoc();
    		if($row){
	    		if($this->orderColumns!==false){
	    			$newRow = array();
	    			foreach ($this->orderColumns as $keyZA => $valueZA){
	    				$newRow[$valueZA] = $row[$valueZA];
	    			}
	    			return $newRow;
	    		}else{
					return $row;
	    		}
    		}else{
    			return false;	
    		}
    	}else{
    		if(count($this->select)){
    			if($this->contRowsArray<$this->limit){
    				$this->contRowsArray++;
	    			$erroReset = 0;
	    			for($erro=0;$erro<10;$erro++){
	    				foreach ($this->select as $keyZB => $valueZB){
	    					$row = $this->select[$keyZB];
	    					unset($this->select[$keyZB]);
	    					$erroReset = 1;
	    					break;
	    				}
	    				if($erroReset==1){
	    					break;
	    				}
	    			}
	    			if($erro==0 || $erroReset==1){
	    				if($this->orderColumns!==false){
	    					$newRow = array();
	    					foreach ($this->orderColumns as $key => $value){
	    						$newRow[$value] = @$row[$value];
	    					}
	    					return $newRow;
	    				}else{
	    					return $row;
	    				}
	    			}else{
	    				return false;
	    			}
    			}else{
    				return false;
    			}
    		}else{
    			return false;
    		}
    	}
	}
	public function addColumn($name,$title="Sem Nome",$nameObjInner="",$parameter=""){
		$id = count($this->columns);
		$this->columns[$id] = $name;
		$this->columnsTitle[$id] = $title;
		$this->columnsNameObjInner[$id] = $nameObjInner;
		$this->parameter[$id] = $parameter;
	}
	public function addButton($name,$class="",$title="Sem Título",$actionScript="",$parameter="",$column="",$arrayAddParameter="",$whereCondition="",$arrayValueCondition="",$target="",$javaType="goToPage",$objToLoad=false){
		$id = count($this->button);
		$this->button[$id]['enable'] = true;
		$this->button[$id]['name'] = explode(",",$name);
		$this->button[$id]['columnTitle'] = $title;
		$this->button[$id]['Class'] = $class;
		$this->button[$id]['parameter'] = $parameter;
		$this->button[$id]['column'] = $column;
		if($actionScript==""){
			$this->button[$id]['actionScript'] = $this->actionScriptStandard;
		}else{
			$this->button[$id]['actionScript'] = $actionScript;
		}
		$this->button[$id]['arrayAddParameter'] = explode(",", $arrayAddParameter);
		$this->button[$id]['whereCondition'] = $whereCondition;
		$this->button[$id]['arrayValueCondition'] = explode(",", $arrayValueCondition);
		$this->button[$id]['target'] = $target;
		$this->button[$id]['javaType'] = $javaType;
		$this->button[$id]['objToLoad'] = $objToLoad;
		if($javaType=="reloadScript"){
			$this->button[$id]['actionScript'] = $this->button[$id]['actionScript']."?".$parameter."=";
		}
	}
	public function addTextBox($name,$class="",$title="Sem Título",$column=""){
		@$this->textBox->enable = true;
		$this->textBox->name = explode(",",$name);
		$this->textBox->columnTitle = $title;
		$this->textBox->Class = $class;
		$this->textBox->column = $column;
	}
	public function addCheckBox($name,$title="Sem Título",$column=""){
		$id = count($this->checkBox);
		$this->checkBox[$id]['enable'] = true;
		$this->checkBox[$id]['name'] = $name;
		$this->checkBox[$id]['columnTitle'] = $title;
		$this->checkBox[$id]['column'] = $column;
	}
    private function exeFillData(){
        $this->javaB->setOnClick();
        if($this->pathScriptCommand){
        	$this->javaB->setFunctionGoToPage($this->pathScriptCommand,"dataTableAdapterOrderBy".$this->name);
        }else{
        	$this->javaB->setFunctionGoToPage($this->actionScriptStandard,"dataTableAdapterOrderBy".$this->name);
        }
        if($this->columnFilter){
            $this->javaC->setOnClick();
            if($this->pathScriptCommand){
            	$this->javaC->setFunctionGoToPage($this->pathScriptCommand,"dataTableAdapterFilterColumn");
            }else{
            	$this->javaC->setFunctionGoToPage($this->actionScriptStandard,"dataTableAdapterFilterColumn");
            }
        }
        $first = 0;
        $color = -1;
        $contRow = 0;
        $colspanAdd = 0;
        foreach ($this->button as $keyR => $valueR){
	        if($this->button[$keyR]['enable']===true){
	        	$colspanAdd++;
	        }
        }
        if(@$this->textBox->enable===true){
        	$colspanAdd++;
        }
        foreach ($this->checkBox as $keyX => $valueX){
        	if($this->checkBox[$keyX]['enable']===true){
        		$colspanAdd++;
        	}
        }
        $colspanAdd += count($this->columnsAddValueArray);
        foreach ($this->columnsAddValue as $keyN => $valueL){
        	if($this->columnsValueOrColumnA[$keyN]!==false || $this->columnsValueOrColumnB[$keyN]!==false){
        		$colspanAdd++;
        	}
        }
        /*$this->row = $this->read();
        $this->e("Teste - ".$this->row["code"]."<br><br>");
        $this->row = $this->read();
        $this->e("Teste - ".$this->row["code"]."<br><br>");*/
        $this->contRowsArray = 0;
        $this->numRead = $this->limit * $this->page;
        while($this->row = $this->read()){
            if($first==0){
                $useFake = count($this->columnsFake);
                if($this->numRowsTotal){
                	$numTotal = $this->numRowsTotal;
                }else{
                	$numTotal = $this->totalRowsArray;
                }
                if(!isset($this->withOutTitle) || ceil(($numTotal/$this->limit))>1){
	                $this->e("<tr class=\"table firstTr trTitle\">",$this->nivel+1);
	                $this->e("<td colspan=\"".(count($this->row)+count($this->columns)+$colspanAdd-count($this->columnsHidden))."\" align=\"right\" class=\"td titleTable\">",$this->nivel+2);
	                $this->e("<table width=\"100%\"><tr>",$this->nivel+3);
	                if($this->numRowsTotal>$this->limit || $this->totalRowsArray>$this->limit){
	                	$this->e("<td align=\"left\" style=\"min-width:200px;\">",$this->nivel+4);
	                    $baseForm = new space($this,"baseFormDataTableAdapter","","baseFormDataTableAdapter",0,$this->nivel+50);
	                    $baseForm->css->width("300px");
	                    $colorTextPages = "rgb(0,0,0)";
	                    if(isset($this->label->x)){
	                    	if($this->label->x!="" || $this->label->x==0){
	                    		$baseForm->css->position("absolute");
	                    		$baseForm->css->left($this->label->x);
	                    		$baseForm->css->top($this->label->y);
	                    		$colorTextPages = $this->label->colorText;
	                    	}
	                    }
                    	if($this->pathScriptCommand){
                    		$form = new form($baseForm,"formDataTableAdapterB","post",$this->pathScriptCommand,"",0,$this->nivel+5);
                    	}else{
                        	$form = new form($baseForm,"formDataTableAdapterB","post",$this->actionScriptStandard,"",0,$this->nivel+5);
                    	}
                        $buttonB = new button($form,"btPrevious",$this->labelPrevious,"btTable btTableA");
                        $buttonB->java->setOnClick();
                        if($this->page==0){
                        	$previousPage = ($this->page+1);
                        }else{
                        	$previousPage = $this->page;
                        }
                        if($this->commandReloadScript===false){
                        	$buttonB->java->setFunctionGoToPage($this->pathScriptCommand,"formDataTableAdapterB".$this->getName(),$previousPage);
                        }else{
                        	$buttonB->java->setFunctionReloadScript($this->commandReloadScriptObj, $this->commandReloadScriptScript."?formDataTableAdapterB".$this->getName()."=".$previousPage);
                        }
                        $textForm = new space($baseForm,"textFormDataTableAdapter","center","textContPage");
                        $textForm->css->color($colorTextPages);
                        $textForm->inSide(($this->page+1)."/".ceil(($numTotal/$this->limit)));
                        if($this->pathScriptCommand){
                        	$form = new form($baseForm,"formDataTableAdapterA","post",$this->pathScriptCommand,"",0,$this->nivel+5);
                        }else{
                        	$form = new form($baseForm,"formDataTableAdapterA","post",$this->actionScriptStandard,"",0,$this->nivel+5);
                        }
                        $form->setHidden("dataTableAdapterLimitPage",ceil(($numTotal/$this->limit)));
                        $buttonA = new button($form,"btNext",$this->labelNext,"btTable btTableB");
                        $buttonA->java->setOnClick();
                        if(($this->page+2)>ceil(($numTotal/$this->limit))){
                        	$nextPage = ($this->page+1);
                        }else{
                        	$nextPage = ($this->page+2);
                        }
                        if($this->commandReloadScript===false){
                        	$buttonA->java->setFunctionGoToPage($this->pathScriptCommand,"formDataTableAdapterA".$this->getName(),$nextPage);
                        }else{
                        	$buttonA->java->setFunctionReloadScript($this->commandReloadScriptObj, $this->commandReloadScriptScript."?formDataTableAdapterA".$this->getName()."=".$nextPage);
                        }
                        $baseForm->End();
                        $this->e("</td>",$this->nivel+4);
	                }
	                $this->e("<td align=\"right\" class=\"titleTable\">",$this->nivel+4);
	                $this->e("<div class=\"textTitle\">",$this->nivel+5);
	                if(!isset($this->withOutTitle)){
	                	$title = $this->titleTable;
	                }else{
	                	$title = "";
	                }
	                if($this->isArray==false){
	                	$title .= " (".$this->numRowsTotal.")";
	                }else{
	                	$title .= " (".$this->totalRowsArray.")";
	                }
	                $this->e($title,$this->nivel+6);
	                $this->e("</div>",$this->nivel+5);
	                $this->e("</td></tr></table>",$this->nivel+4);
	                $this->e("</td>",$this->nivel+2);
	                $this->e("</tr>",$this->nivel+1);
                }
                if(!isset($this->withOutSubTitle)){
	                $this->e("<tr class=\"table firstTr\">",$this->nivel+1);
	                $i = 0;
	                foreach($this->row as $key => $value){
	                	$hidden = 0;
	                	if(count($this->columnsHidden)>0){
	                		foreach ($this->columnsHidden as $valueL){
	                			if($key==$valueL){
	                				$hidden = 1;
	                			}
	                		}
	                	}
	                    $classCss = " class=\"td";
	                    $contOrderBy = 0;
	                    $orderThis = "";
	                    foreach($this->orderBy as $valueB){
	                        $contOrderBy++;
	                        if($valueB==$key){
	                            $classCss .= " orderByThisColumn";
	                            $orderThis = " (".$contOrderBy.")";
	                        }
	                    }
	                    if($this->columnFilterValue!="" && $key==$this->columnFilter){
	                    	$classCss .= " filteredColumn";
	                    	$commandB = $this->javaC->getLineCommand($this->columnFilterValue);
	                    }else{
	                    	$commandB = $this->javaB->getLineCommand($key);
	                    }
	                    $classCss .= "\" ";
	                    if($hidden==0){
		                    if(isset($this->columnsWidth[$i])){
		                    	$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
		                    }else{
		                    	$this->e("<td align='center' ".$classCss.$commandB.">",$this->nivel+2);
		                    }
		                    if($useFake>0){
		                        if(isset($this->columnsFake[$i])){
		                            $this->e($this->columnsFake[$i].$orderThis,$this->nivel+3);
		                        }else{
		                            $this->e("Sem nome".$orderThis,$this->nivel+3);
		                        }
		                    }else{
		                        $this->e($key.$orderThis,$this->nivel+3);
		                    }
		                    $this->e("</td>",$this->nivel+2);
	                    }
	                    $i++;
	                }
	                if(@$this->textBox->enable===true){
	                	$classCss = " class=\"td";
	                	$classCss .= "\" ";
	                	if(isset($this->columnsWidth[$i])){
	                		$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
	                	}else{
	                		$this->e("<td align='center' ".$classCss.">",$this->nivel+2);
	                	}
	                	$this->e($this->textBox->columnTitle,$this->nivel+3);
	                	$this->e("</td>",$this->nivel+2);
	                }
	                foreach ($this->checkBox as $keyY => $valueY){
		                if(@$this->checkBox[$keyY]['enable']===true){
		                	$classCss = " class=\"td";
		                	$classCss .= "\" ";
		                	if(isset($this->columnsWidth[$i])){
		                		$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
		                	}else{
		                		$this->e("<td align='center' ".$classCss.">",$this->nivel+2);
		                	}
		                	$this->e($this->checkBox[$keyY]['columnTitle'],$this->nivel+3);
		                	$this->e("</td>",$this->nivel+2);
		                }
	                }
	                foreach ($this->button as $keyS => $valueS){
		                if($this->button[$keyS]['enable']===true){
		                	$classCss = " class=\"td";
		                	$classCss .= "\" ";
		                	if(isset($this->columnsWidth[$i])){
		                		$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
		                	}else{
		                		$this->e("<td align='center' ".$classCss.">",$this->nivel+2);
		                	}
		                	$this->e($this->button[$keyS]['columnTitle'],$this->nivel+3);
		                	$this->e("</td>",$this->nivel+2);
		                }
	                }
	                if(count($this->columnsAddValue)>0){
	                	foreach ($this->columnsAddValue as $keyL => $valueL){
	                		if($this->columnsValueOrColumnA[$keyL]!==false || $this->columnsValueOrColumnB[$keyL]!==false){
		                		$classCss = " class=\"td";
		                		$classCss .= "\" ";
		                		if(isset($this->columnsWidth[$i])){
		                			$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
		                		}else{
		                			$this->e("<td align='center' ".$classCss.">",$this->nivel+2);
		                		}
		                		$this->e($valueL,$this->nivel+3);
	                		}
	                	}
	                }
	                if(count($this->columnsAddValueArray)>0){
	                	foreach ($this->columnsAddValueArray as $keyL => $valueL){
	                		$classCss = " class=\"td";
	                		$classCss .= "\" ";
	                		if(isset($this->columnsWidth[$i])){
	                			$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
	                		}else{
	                			$this->e("<td align='center' ".$classCss.">",$this->nivel+2);
	                		}
	                		$this->e($valueL,$this->nivel+3);
	                		$this->e("</td>",$this->nivel+2);
	                		$i++;
	                	}
	                }
	                $this->e("</tr>",$this->nivel+1);
	                $first = 1;
	                $firstForm = 0;
	                if(@$this->textBox->enable===true){
	                	$firstForm = 1;
	                	$this->e("<form id='FORM_table' name='FORM_table' method='POST' action='' enctype='multipart/form-data'>");
	                }
	                /*foreach ($thi->checkBox as $keyW => $valueW){
	                	if($this->checkBox[$keyW]['enable']===true && $firstForm==0){
	                		$firstForm = 1;
	                		$this->e("<form id='FORM_table' name='FORM_table' method='POST' action='' enctype='multipart/form-data'>");
	                		break;
	                	}
	                }*/
                }
            }
            $formatConditionEnable = false;
            $formatConditionLineEnable = false;
            $formatConditionSetted = false;
            $formatConditionColumn = false;
            if(count($this->formatCondition)>0){
            	foreach ($this->formatCondition as $valueI){
            		$true = false;
            		if(isset($this->row[$this->objCondition->$valueI->valueCondition])){
            			$valueCondition = $this->row[$this->objCondition->$valueI->valueCondition];
            		}else{
            			$valueCondition = $this->objCondition->$valueI->valueCondition;
            		}
            		$whereCondition = $this->row[$this->objCondition->$valueI->whereCondition];
            		
            		# OPERAÇÕES NUMÉRICAS
            		$whereCondition = str_replace(",", ".", $whereCondition);
            		$valueCondition = str_replace(",", ".", $valueCondition);
            		$operator = $this->objCondition->$valueI->operator;
            		if($this->objCondition->$valueI->operatorB!=""){
            			if(isset($this->row[$this->objCondition->$valueI->columnChangeOperator])){
            				if($this->row[$this->objCondition->$valueI->columnChangeOperator]==0){
            					$operator = $this->objCondition->$valueI->operatorB;
            				}
            			}
            		}
            		if($operator=="="){
            			if($whereCondition==$valueCondition){
            				$true = true;
            			}
            		}
            		if($operator=="!="){
            			if($whereCondition!=$valueCondition){
            				$true = true;
            			}
            		}
            		if($operator==">"){
            			if($whereCondition>$valueCondition){
            				$true = true;
            			}
            		}
            		if($operator=="<"){
            			if($whereCondition<$valueCondition){
            				$true = true;
            			}
            		}
            		if($operator==">="){
            			if($whereCondition>=$valueCondition){
            				$true = true;
            			}
            		}
            		if($operator=="<="){
            			if($whereCondition<=$valueCondition){
            				$true = true;
            			}
            		}
            		if($this->objCondition->$valueI->notNull==true && strlen($whereCondition)==0){
            			$true = false;
            		}
            		if($true===true){
            			if($this->objCondition->$valueI->sendToColumn===false){
            				$sendToColumn = $this->objCondition->$valueI->whereCondition;
            			}else{
            				$sendToColumn = $this->objCondition->$valueI->sendToColumn;
            			}
            			$formatConditionSetted[$sendToColumn] = $valueI;
            			$formatConditionColumn[$sendToColumn] = $sendToColumn;
            			$formatConditionEnableColumn[$sendToColumn] = true;
            			$formatConditionEnable = true;
            			if($this->objCondition->$valueI->affectLine===true){
            				$formatConditionLineEnable = true;
            			}
            			$formatConditionSettedStatic = $valueI;
            			/*$formatConditionEnable = true;
            			$formatConditionColumn = $this->objCondition->$valueI->whereCondition;
            			if($this->objCondition->$valueI->affectLine===true){
            				$formatConditionLineEnable = true;
            			}*/
            		}
            	}
            }
            if($formatConditionEnable===true && $formatConditionLineEnable===true){
            	$this->e("<tr style='".@$this->objCondition->$formatConditionSettedStatic->backgroundColor.@$this->objCondition->$formatConditionSettedStatic->color."' class='".$this->objCondition->$formatConditionSettedStatic->addClass."'>",$this->nivel+1);
            }else{
            	if($this->standardColor==1){
		            if($color){
		                $this->e("<tr class=\"colorTrB\">",$this->nivel+1);
		            }else{
		                $this->e("<tr class=\"colorTrA\">",$this->nivel+1);
		            }
            	}else{
            		if($color){
            			$this->e("<tr class=\"colorTrD\">",$this->nivel+1);
            		}else{
            			$this->e("<tr class=\"colorTrC\">",$this->nivel+1);
            		}
            	}
            }
            $color = !$color;
            $i = 0;
            $repeatCondition = false;
            $repeatConditionValue = 0;
            foreach($this->row as $key => $value){
            	$myColumns[$key] = 1;
            	$hidden = 0;
            	if(count($this->columnsHidden)>0){
            		foreach ($this->columnsHidden as $valueL){
            			if($key==$valueL){
            				$hidden = 1;
            			}
            		}
            	}
            	$valueParameterGoToPage = "";
            	if(isset($this->row[$this->columnParameterGoToPage])){
            		$valueParameterGoToPage = $this->row[$this->columnParameterGoToPage];
            	}
            	$valueParameterGoToPageC = "";
            	if(isset($this->row[$this->columnFilter])){
            		$valueParameterGoToPageC = $this->row[$this->columnFilter];
            	}
                $align = "left";
                if(isset($this->aligns[$i])){
                	if($this->aligns[$i]=="c"){
                		$this->aligns[$i] = "center";
                	}else if($this->aligns[$i]=="r"){
                		$this->aligns[$i] = "right";
                	}else if($this->aligns[$i]=="l"){
                		$this->aligns[$i] = "left";
                	}
                    $align = $this->aligns[$i];
                }
                $command = "";
                foreach($this->columnsThisTableActionOnClick as $valueB){
                    if($key==$valueB){
                        $command = $this->java->getLineCommand($valueParameterGoToPage);
                    }             
                }
                /*###
                $id = count($this->objActionSetValue);
                $this->objActionSetValue[$id]['columnsThisTableActionSetValue'] = explode(",",$columnsThisTable);
                $this->objActionSetValue[$id]['columnParameterSetValue'] = $value;
                if($this->stringToUpper($event)=="CLICK"){
                	$this->java->setOnClick();
                }
                $this->java->setFunctionSetValue($obj,false);
                ###*/
                $firstB = 1;
                foreach ($this->objActionSetValue as $keyZ => $valueZ){
	                foreach($this->objActionSetValue[$keyZ]['columnsThisTableActionSetValue'] as $valueB){
	                	if($key==$valueB){
	                		if($firstB==1){
	                			$firstB = 0;
	                			$command = $this->java->getLineCommand("@var".$keyZ,$this->row[$this->objActionSetValue[$keyZ]['columnParameterSetValue']],true);
	                		}else{
	                			$command = $this->java->getLineCommand("@var".$keyZ,$this->row[$this->objActionSetValue[$keyZ]['columnParameterSetValue']],true,$command);
	                		}
	                	}
	                }
                }
                foreach($this->columnsThisTableActionSetFocus as $valueB){
                	if($key==$valueB){
                		$command = $this->java->getLineCommand("",$value);
                	}
                }
                foreach($this->columnsThisTableActionSetClose as $valueB){
                	if($key==$valueB){
                		$command = $this->java->getLineCommand("",$value);
                	}
                }
                if($key==$this->columnFilter){
                    $command = $this->javaC->getLineCommand($valueParameterGoToPageC);
                }
                if($hidden==0){
                	# MATH - APLICA UMA FORMULA MATEMATICA
                	if(count($this->columnsMathColumn)>0){
                		foreach ($this->columnsMathColumn as $keyM => $valueM){
                			if($key==$valueM){
                				if($this->columnsMathType[$keyM]=="division"){
                					$value = @($value / $this->columnsMathBy[$keyM]);  
                				}
                				if($this->columnsMathType[$keyM]=="multiply"){
                					$value = @($value * $this->columnsMathBy[$keyM]);
                				}
                				if($this->columnsMathType[$keyM]=="sum"){
                					$value = @($value + $this->columnsMathBy[$keyM]);
                				}
                				if($this->columnsMathType[$keyM]=="media"){
                					$media = explode($this->columnsMathBy[$keyM], $value);
                					if(count($media)>0){
	                					$somaMedia = 0;
	                					foreach ($media as $keyU => $valueU){
	                						$somaMedia += $valueU;
	                					}
	                					$value = @($somaMedia/count($media));
                					}
                				}
                			}
                		}
                	}
                	$formatConditionEnableColumnSimple = false;
                	if(isset($formatConditionEnableColumn[$key])){
                		$formatConditionEnableColumnSimple = $formatConditionEnableColumn[$key];
                		if(!isset($formatConditionSetted[$key])){
                			$formatConditionEnableColumnSimple = false;
                		}else{
							$temp = $formatConditionSetted[$key];
	                		if(!isset($this->objCondition->$temp)){
	                			$formatConditionEnableColumnSimple = false;
	                		}
                		}
                	}
                	if($formatConditionEnableColumnSimple===true){
						$temp = $formatConditionSetted[$key];
                		if(isset($this->objCondition->$temp)){
		                	if($this->objCondition->$temp->repeat){
		                		$repeatCondition = $key;
		                		$repeatConditionValue = $this->objCondition->$temp->repeat;
		                	}
                		}
	                	$this->e("<td class=\"td\" align=\"".$align."\"".$command." style='".$this->objCondition->$temp->backgroundColor.$this->objCondition->$temp->color."'>",$this->nivel+2);
	                }else{
	                	if($repeatCondition && $repeatConditionValue){
	                		$repeatConditionValue--;
	                		$this->e("<td class=\"td\" align=\"".$align."\"".$command." style='".$this->objCondition->$formatConditionSetted[$repeatCondition]->backgroundColor.$this->objCondition->$formatConditionSetted[$repeatCondition]->color."'>",$this->nivel+2);
	                	}else{
	                		$repeatCondition = false;
	                		$repeatConditionValue = 0;
	                		$this->e("<td class=\"td\" align=\"".$align."\"".$command.">",$this->nivel+2);
	                	}
	                }
	                if(count($this->columnsAsRgIe)>0){
	                	if(strlen($value)>1){
		                	foreach ($this->columnsAsRgIe as $valueJ){
		                		if($key==$valueJ){
		                			if(strlen($value)>=12){
		                				$value = number_format($value,0,",",".");
		                			}else{
		                				$value = substr($value, 0, 2).".".substr($value, 2, 3).".".substr($value, 5, 3)."-".substr($value, 8);
		                			}
		                		}
		                	}
	                	}
	                }
	                if(count($this->columnsAsCpfCnpj)>0){
	                	if(strlen($value)>1){
		                	foreach ($this->columnsAsCpfCnpj as $valueJ){
		                		if($key==$valueJ){
		                			if(strlen($value)>=14){
		                				$value = substr($value, 0, 2).".".substr($value, 2, 3).".".substr($value, 5, 3)."/".substr($value, 8,4)."-".substr($value, 12);
		                			}else{
		                				$value = substr($value, 0, 3).".".substr($value, 3, 3).".".substr($value, 6, 3)."-".substr($value, 9);
		                			}
		                		}
		                	}
	                	}
	                }
	                if(count($this->columnsAsPlaca)>0){
	                	if(strlen($value)>1){
	                		foreach ($this->columnsAsPlaca as $valueJ){
	                			if($key==$valueJ){
	                				$value = substr($value, 0, 3)."-".substr($value, 3);
	                			}
	                		}
	                	}
	                }
	                if(count($this->columnsAsFormatDate)>0){
		                foreach ($this->columnsAsFormatDate as $keyC =>$valueC){
		                	if($key==$valueC){
		                		$value = $this->formatDate($value,$this->columnsAsFormatDateBy[$keyC],$this->columnsAsFormatDateMode[$keyC]);
		                	}
		                }
	                }
	                if(count($this->columnsAsMoney)>0){
	                	foreach ($this->columnsAsMoney as $valueJ){
	                		if($key==$valueJ){
	                			if(is_numeric($value)){
	                				$value = "R$ ".number_format($value,2,",",".");
	                			}else{
	                				$value = "";
	                			}
	                		}
	                	}
	                }
	                if(count($this->columnsAsNumber)>0){
	                	foreach ($this->columnsAsNumber as $keyK => $valueK){
	                		if($key==$valueK){
	                			$value = number_format($value,$this->columnsAsNumberDecimals[$keyK],",",".");
	                		}
	                	}
	                }
	                if(count($this->columnsAsNumTel)>0){
	                	foreach ($this->columnsAsNumTel as $keyQ => $valueQ){
	                		$numTel = "";
	                		if($key==$valueQ){
	                			$value = $this->formatAsNumTel($value);
	                		}
	                	}
	                }
	                if(count($this->columnsMask)>0){
	                	foreach ($this->columnsMask as $keyD => $valueD){
	                		if($key==$valueD){
	                			if($value==""){
	                				$value = 0;
	                			}
	                			if(isset($this->columnsArrayToMask[$keyD][$value])){
	                				$value = $this->columnsArrayToMask[$keyD][$value];
	                			}else{
	                				$value = "";
	                			}
	                		}
	                	}
	                }
	                if(count($this->columnsAddValue)>0){
	                	foreach ($this->columnsAddValue as $keyE => $valueE){
	                		if($this->columnsValueOrColumnA[$keyE]===false && $this->columnsValueOrColumnB[$keyE]===false){
	                			if($this->columnsAddValueMathType[$keyE]=="sum"){
	                				if($this->columnsAddValue[$keyE]==$key){
	                					# ESTAVA ASSIM ATÉ 15/12/2016
	                					# $this->columnsValue[$keyE] = $this->row[$this->columnsAddValue[$keyE]] + $this->columnsValue[$keyE];
	                					# $value = $this->columnsValue[$keyE];
	                					# FIM - ESTAVA ASSIM ATÉ 15/12/2016
	                					
	                					# AGORA ESTÁ ASSIM
	                					$value = $this->row[$this->columnsAddValue[$keyE]] + $this->columnsValue[$keyE];
	                					# FIM - AGORA ESTÁ ASSIM
	                				}
	                			}
	                		}else{
		                		if($this->columnsAddValueMathType[$keyE]=="division"){
		                			$this->columnsValue[$keyE] = @($this->row[$this->columnsValueOrColumnA[$keyE]]/$this->row[$this->columnsValueOrColumnB[$keyE]]);
		                		}
		                		if($this->columnsAddValueType[$keyE]=="percentage"){
		                			$this->columnsValue[$keyE] = number_format(($this->columnsValue[$keyE] * 100),2,",",".");
		                		}
		                		if($this->columnsAddValueMathType[$keyE]=="multiply"){
		                			$this->columnsValue[$keyE] = $this->formatNumber($this->row[$this->columnsValueOrColumnA[$keyE]]) * $this->formatNumber($this->columnsValueOrColumnA[$keyE]);
		                		}
	                		}
	                	}
	                }
	                $this->e($value,$this->nivel+3);
	                $this->e("</td>",$this->nivel+2);
	                foreach($this->columnsSumTotal as $keyP => $valueP){
	                	if($valueP==$key){
	                		if(isset($sumTotal[$key])){
	                			$sumTotal[$key] += $value;
	                		}else{
	                			$sumTotal[$key] = $value;
	                		}
	                	}
	                }
                }
                $i++;
            }
            foreach ($this->button as $keyT => $valueT){
	            if($this->button[$keyT]['enable']===true){
	            	$this->e("<td class=\"td\" align=\"center\">",$this->nivel+2);
	            	$index = 0;
	            	$printButton = 0;
	            	if($this->button[$keyT]['whereCondition']){
	            		foreach ($this->button[$keyT]['arrayValueCondition'] as $keyH => $valueH){
	            			if(@$this->row[$this->button[$keyT]['whereCondition']]==$valueH){
	            				$printButton = 1;
	            			}
	            		}
	            	}else{
	            		$printButton = 1;
	            	}
	            	foreach ($this->button[$keyT]['arrayValueCondition'] as $keyH => $valueH){
	            		if(@$this->row[$this->button[$keyT]['whereCondition']]==$valueH){
	            			$index = $keyH;
	            			break;
	            		}
	            	}
	            	$this->button[$keyT]['java'] = new java();
	            	$this->newObj($this->button[$keyT]['java'],"JAVA_".$this->button[$keyT]['name'][0]."_".@$contRow,"java",@$this->name);
	            	if($printButton){
		            	$this->button[$keyT]['java']->setOnClick();
		            	if($this->button[$keyT]['javaType']=="goToPage"){
		            		$this->button[$keyT]['java']->setFunctionGoToPage($this->button[$keyT]['actionScript'],$this->button[$keyT]['parameter'],$this->row[$this->button[$keyT]['column']],$this->button[$keyT]['target'],$this->button[$keyT]['arrayAddParameter'][$index]);
		            	}else if($this->button[$keyT]['javaType']=="reloadScript"){
		            		$this->button[$keyT]['java']->setFunctionReloadScript($this->button[$keyT]['objToLoad'],$this->button[$keyT]['actionScript'].$this->row[$this->button[$keyT]['column']].$this->button[$keyT]['arrayAddParameter'][0]);
		            	}else{
		            		$this->button[$keyT]['java']->setFunctionGoToPage($this->button[$keyT]['actionScript'],$this->button[$keyT]['parameter'],$this->row[$this->button[$keyT]['column']],$this->button[$keyT]['target'],$this->button[$keyT]['arrayAddParameter'][$index]);
		            	}
	            	
	            		$this->e("<div id=\"".$this->button[$keyT]['name'][$index]."_".$contRow."\" name=\"".$this->button[$keyT]['name'][$index]."_".$contRow."\" class=\"".$this->button[$keyT]['Class']."\" align=\"center\"".$this->button[$keyT]['java']->getLineCommand().">",$this->nivel+3);
		            	if(count($this->button[$keyT]['name'])==1){
		            		$this->e($this->button[$keyT]['name'][0],$this->nivel + 4);
		            	}else{
		            		$this->e($this->button[$keyT]['name'][$index],$this->nivel + 4);
		            	}
		            	$this->e("</div>",$this->nivel+3);
	            	}
	            	$this->e("</td>",$this->nivel+2);
	            }
            }
            if(@$this->textBox->enable===true){
            	$this->e("<td class=\"td\" align=\"center\">",$this->nivel+2);
            	$this->textBox->java = new java();
            	$this->newObj($this->textBox->java,"JAVA_".$this->textBox->name[0]."_".$contRow,"java",$this->name[0]);
            	$this->textBox->java->setOnClick();
            	$index = 0;
            	if(isset($this->textBox->arrayValueCondition)){
	            	foreach (@$this->textBox->arrayValueCondition as $keyH => $valueH){
	            		if($this->row[$this->textBox->whereCondition]==$valueH){
	            			$index = $keyH;
	            		}
	            	}
            	}
            	$this->textBox->java->setFunctionGoToPage(@$this->textBox->actionScript,@$this->textBox->parameter,@$this->row['idOrdemProducaoEmbalagem'],@$this->textBox->target,@$this->textBox->arrayAddParameter[$index]);
            	if($this->textBox->column==""){
            		$this->e("<input type=\"text\" id=\"".$this->textBox->name[0]."\" name=\"".$this->textBox->name[0]."[".$contRow."]\" value=\"\" class=\"".$this->textBox->Class."\" maxlength=\"\" />",$this->nivel+3);
            	}else{
            		$this->e("<input type=\"text\" id=\"".$this->textBox->name[0]."\" name=\"".$this->textBox->name[0]."[".$this->row[$this->textBox->column]."]\" value=\"\" class=\"".$this->textBox->Class."\" maxlength=\"\" />",$this->nivel+3);
            	}
                $this->e("</td>",$this->nivel+2);
            }
            /*foreach ($this->checkBox as $keyZ => $valueZ){
	            if($this->checkBox[$keyZ]['enable']===true){
	            	$this->e("<td class=\"td\" align=\"center\">",$this->nivel+2);
	            	$this->textBox->java = new java();
	            	$this->newObj($this->textBox->java,"JAVA_".$this->textBox->name[0]."_".$contRow,"java",$this->name[0]);
	            	$this->textBox->java->setOnClick();
	            	$index = 0;
	            	if(isset($this->textBox->arrayValueCondition)){
	            		foreach (@$this->textBox->arrayValueCondition as $keyH => $valueH){
	            			if($this->row[$this->textBox->whereCondition]==$valueH){
	            				$index = $keyH;
	            			}
	            		}
	            	}
	            	$this->textBox->java->setFunctionGoToPage(@$this->textBox->actionScript,@$this->textBox->parameter,@$this->row['idOrdemProducaoEmbalagem'],@$this->textBox->target,@$this->textBox->arrayAddParameter[$index]);
	            	if($this->textBox->column==""){
	            		$this->e("<input type=\"text\" id=\"".$this->textBox->name[0]."\" name=\"".$this->textBox->name[0]."[".$contRow."]\" value=\"\" class=\"".$this->textBox->Class."\" maxlength=\"\" />",$this->nivel+3);
	            	}else{
	            		$this->e("<input type=\"text\" id=\"".$this->textBox->name[0]."\" name=\"".$this->textBox->name[0]."[".$this->row[$this->textBox->column]."]\" value=\"\" class=\"".$this->textBox->Class."\" maxlength=\"\" />",$this->nivel+3);
	            	}
	            	$this->e("</td>",$this->nivel+2);
	            }
            }*/
            if(count($this->columnsAddValue)>0){
            	foreach ($this->columnsAddValue as $keyL => $valueL){
            		if($this->columnsValueOrColumnA[$keyL]!==false || $this->columnsValueOrColumnB[$keyL]!==false){
	            		$classCss = " class=\"td";
	            		$classCss .= "\" ";
	            		if(isset($this->columnsWidth[$i])){
	            			$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
	            		}else{
	            			$this->e("<td align='center' ".$classCss.">",$this->nivel+2);
	            		}
	            		$this->e($this->columnsValue[$keyL],$this->nivel+3);
	            		$this->e("</td>",$this->nivel+2);
            		}
            	}
            }
            if(count($this->columnsAddValueArray)>0){
            	foreach ($this->columnsAddValueArray as $keyL => $valueL){
            		$this->e("<td class=\"td\" align=\"center\">",$this->nivel+2);
            		if($this->columnsParameterAdditionalArray[$keyL]!==false){
            			$value = $this->columnsValueArray[$keyL][$this->row[$this->columnsParameterArray[$keyL]]][$this->columnsParameterAdditionalArray[$keyL]];
            		}else{
            			$value = $this->columnsValueArray[$keyL][$this->row[$this->columnsParameterArray[$keyL]]];
            		}
            		#$value = $this->columnsValueArray[$keyL][$this->row[$this->columnsParameterArray[$keyL]]][$this->columnsParameterAdditionalArray[$keyL]];
            		$this->e($value,$this->nivel+3);
            		$this->e("</td>",$this->nivel+2);
            	}
            }
            $this->e("</tr>",$this->nivel+1);
            $contRow++;
        }
        if(!isset($this->withOutTitle)){
        	$this->e("</form>");
        }
        if(count($this->columnsSumTotal)){
        	$this->e("<tr class=\"table firstTr\">",$this->nivel+1);
        	$colspan = 0;
        	foreach($myColumns as $key => $value){
        		foreach($this->columnsSumTotal as $keyO => $valueO){
        			if($valueO==$key){
        				if($colspan>0){
        					$this->e("<td class=\"td\" align=\"\" colspan=\"".$colspan."\">",$this->nivel+2);
        					$this->e("</td>",$this->nivel+2);
        					$colspan = 0;
        				}
		        		$this->e("<td class=\"td\" align=\"\">",$this->nivel+2);
		        		$this->e($sumTotal[$key],$this->nivel+3);
		        		$this->e("</td>",$this->nivel+2);
        			}else{
        				$hidden = 0;
        				if(count($this->columnsHidden)>0){
        					foreach ($this->columnsHidden as $valueL){
        						if($key==$valueL){
        							$hidden = 1;
        						}
        					}
        				}
        				if($hidden==0){
        					$colspan++;
        				}
        			}
        		}
        	}
        	if($colspan>0){
        		$this->e("<td class=\"td\" align=\"\" colspan=\"".$colspan."\">",$this->nivel+2);
        		$this->e("</td>",$this->nivel+2);
        		$colspan = 0;
        	}
        	$this->e("</tr>",$this->nivel+1);
        }
    }
    public function End(){
    	global $page;
    	$numRows = 0;
    	if($this->dataBase!=false){
			if($this->getOrder()!=""){
	            $this->select->order($this->getOrder(),$this->getTypeOrder());
	        }
	        if($this->columnFilterValue!=""){
	            $this->select->setAnd($this->select->getTableSetted().".".$this->columnFilter,"=",$this->columnFilterValue,$this->filterWithQuotation);
	        }
	        $res = $this->select->exe();
	        if($res===false){
	        	$this->e("Houve uma falha!(1)".administrador.$this->dataBase->getError(1));
	        }else{
		        $this->numRowsTotal = $this->select->getNumRows();
		        if($this->limit){
		        	if(!$this->page){
		        		$this->page = 0;
		        	}
		            $this->select->limit($this->limit,($this->limit * $this->page));
		        }else if($this->limit===false){
		        	if(!$this->page){
		        		$this->page = 0;
		        	}
		        	$this->select->limit($this->limit);
		        }
		        $this->res = $this->select->exe();
		        if($res===false){
		        	$this->e("Houve uma falha!".administrador.$this->dataBase->getError(1));
		        }else{
			        if($this->select->getNumRows()<1){
			        	$this->page = 0;
			        	$page->session->setSession("dataTableAdapterPage".$this->name,"0",$page->getName());
			        	if($this->limit){
			        		$this->select->limit($this->limit,($this->limit * $this->page));
			        	}else if($this->limit===false){
			        		$this->select->limit($this->limit);
			        	}
			        	$this->res = $this->select->exe();
			        }
			        $this->sql = $this->select->getSql();
			        if($this->showSql===true){
			        	$this->e("<br><br>".$this->sql." ".$this->getTypeOrder()."<br><br>");
			        }
			        $numRows = $this->select->getNumRows();
		        }
	        }
	        /*if($this->getOrder()!=""){
	            $this->select->setOrder($this->getOrder(),$this->getTypeOrder());
	        }
	        if($this->columnFilterValue!=""){
	            $this->select->setAnd($this->select->getTableSetted().".".$this->columnFilter,"=",$this->columnFilterValue,$this->filterWithQuotation);
	        }
	        $this->numRowsTotal = @mysql_num_rows($this->select->Exe());
	        if($this->limit){
	        	if(!$this->page){
	        		$this->page = 0;
	        	}
	            $this->select->setLimit($this->limit,($this->limit * $this->page));
	        }
	        $this->res = $this->select->Exe();
	        if($this->select->getNumRows()<1){
	        	$this->page = 0;
	        	$page->session->setSession("dataTableAdapterPage".$this->name,"0",$page->getName());
	        	$this->select->setLimit($this->limit,($this->limit * $this->page));
	        	$this->res = $this->select->Exe();
	        }
	        $this->numErrors = $this->select->getNumErrors();
	        $this->msgError = $this->select->getMsgError();
	        $this->sql = $this->select->getSql();
	        #$this->e($this->select->getSql());
	        if($this->showSql===true){
	        	$this->e("<br><br>".$this->sql." ".$this->getTypeOrder()."<br><br>");
	        }
	        $numRows = $this->select->getNumRows();*/
    	}else{
    		if($this->limit){
    			if(!$this->page){
    				$this->page = 0;
    			}
    		}
    		if($this->getOrder()!=""){
    			$orderExplode = explode(",", $this->getOrder());
    			$typeOrderExplode = explode(",", $this->getTypeOrder());
    			foreach ($orderExplode as $key => $value){
    				$this->select = $this->arraySort($this->select, $value, $typeOrderExplode[$key]);
    			}
    		}
    		if(($this->limit * $this->page)>=$this->totalRowsArray){
    			$this->page = 0;
    			$page->session->setSession("dataTableAdapterPage".$this->name,"0",$page->getName());
    		}
    		$numRows = $this->totalRowsArray;
    		$numIgnore = $this->limit * $this->page;
    		if($numIgnore>0){
    			$contIgnorado = 0;
    			foreach ($this->select as $keyZC => $valueZC){
    				if($contIgnorado<$numIgnore){
    					$contIgnorado++;
    					unset($this->select[$keyZC]);
    				}
    			}
    		}
    	}
		$this->e("<table cellspacing=\"0\" id=\"".$this->name."\" name=\"".$this->name."\" class=\"table\">",$this->nivel);
        if($numRows>0){
            $this->exeFillData();
        }else{
            global $HTML;
            $pageName = $HTML->pageName;
            $page = $HTML->$pageName;
            $currentPage = $page->session->getSession("dataTableAdapterPage".$this->name,$pageName);
            if($currentPage>=1){
                $page->session->setSession("dataTableAdapterPage".$this->name,0,$pageName);
                $this->refresh();
            }else{
            	if(!isset($this->withOutTitle)){
	                $this->e("<tr class=\"firstTr trTitle\">",$this->nivel+1);
	                $this->e("<td colspan=\"".(count($this->row)+count($this->columns))."\" align=\"center\" class=\"titleTable\">",$this->nivel+2);
	                $this->e($this->titleTable,$this->nivel+3);
	                $this->e("</td>",$this->nivel+2);
	                $this->e("</tr>",$this->nivel+1);
            	}
            }
        }
        $this->endObj($this->name);
		$this->e("</table>",$this->nivel);
	}
}