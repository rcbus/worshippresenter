<?php
# Data Table Adapter
class iDataTableAdapter extends generic {
	private $subLayer;
	private $father;
    private $dataBase;
    private $select;
    private $numRowsTotal;
    private $row;
    private $button = array();
    private $textBox = array();
    private $columnButtonTitle;
    private $buttonActionScript;
    private $columns = array();
    private $columnsFake = array();
    private $columnsFakeArray = array();
    private $columnsHidden = array();
    private $columnsLink = array();
    private $columnsLimitCharacter = array();
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
    private $columnsClassAdd = array();
    private $Class = false;
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
    private $objActionReset = array();
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
    private $columnsAsCnae = array();
    private $columnsAsPlaca = array();
    private $uppercase = true;
    private $columnsAsFormatTime = array();
    private $objCore = false;
    private $command = false;
    private $titleAlign = right;
    private $width = false;
    private $columnsAsImage = array();
    private $columnsAlignArray = array();
    private $columnsWidthArray = array();
    private $alignSubTitle = center;
    private $primaryKey = false;
	private $sessionNameArrayKeys = false;
	private $rowMemory = array();
    public $showSql = false;
    public $sql;
    public $css;
    public $java;
    public $javaB;

    function __construct($father,$name,$dataSet=false,$class="",$subLayer=0,$nivel=false){
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
	        $this->dataBase = $dataSet;
        }else{
        	$this->dataBase = false;
        }
		$this->newObj($this,$this->name,"dataTableAdapter",$this->father->getName());
        $this->loadSetOrder();
        $this->loadSetFilter();
        $this->loadSetPage();
        $this->actionScriptStandard = $_SERVER['SCRIPT_NAME'];
    }
    
    public function setPrimaryKey($column){
    	$this->primaryKey = $column;
    }
    
    public function setSessionNameArrayKeys($sessionName){
    	$this->sessionNameArrayKeys = $sessionName;
    }
    
    public function setAlignSubTitle($align){
    	$this->alignSubTitle = $align;
    }
    
    public function setColumnsAsImage($column,$class=false,$width=false,$height=false,$path=false){
    	$this->columnsAsImage[$column]['column'] = $column;
    	$this->columnsAsImage[$column]['class'] = $class;
    	$this->columnsAsImage[$column]['width'] = $width;
    	$this->columnsAsImage[$column]['height'] = $height;
    	$this->columnsAsImage[$column]['path'] = $path;
    }
    
    public function enableCommand(){
    	$this->command = true;
    }
    
    public function getUpperCase(){
    	return $this->uppercase;
    }
    
    public function setCommandReloadScript($obj,$script){
    	$this->commandReloadScript = true;
    	$this->commandReloadScriptObj = $obj;
    	$this->commandReloadScriptScript = $script;
    }
    
    public function setObjCore($objCore){
    	$this->objCore = $objCore;
    }
    
    public function setTitleAlign($align){
    	$this->titleAlign = $align;
    }
    
    public function width($width){
    	$this->width = $width;
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
    public function setColumnClassAdd($column,$class){
    	$id = count($this->columnsClassAdd);
    	$this->columnsClassAdd[$id]['column'] = $column;
    	$this->columnsClassAdd[$id]['class'] = $class;
    }
    public function setColumnHidden($column){
    	$id = count($this->columnsHidden);
    	$this->columnsHidden[$id] = $column;
    }
    public function setColumnLink($column,$link,$class=false,$styles=false,$whereCondition=false,$valueCondition=false,$operator="=",$fake=false){
    	$id = count($this->columnsLink);
    	$this->columnsLink[$id]['column'] = $column;
    	$this->columnsLink[$id]['link'] = $link;
    	$this->columnsLink[$id]['class'] = $class;
    	$this->columnsLink[$id]['styles'] = $styles;
    	$this->columnsLink[$id]['whereCondition'] = $whereCondition;
    	$this->columnsLink[$id]['valueCondition'] = $valueCondition;
    	$this->columnsLink[$id]['operator'] = $operator;
    	$this->columnsLink[$id]['fake'] = $fake;
    }
    public function setColumnLimitCharacter($column,$limit){
    	$id = count($this->columnsLimitCharacter);
    	$this->columnsLimitCharacter[$id]['column'] = $column;
    	$this->columnsLimitCharacter[$id]['limit'] = $limit;
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
    	$setted = false;
    	foreach ($this->columnsAsCpfCnpj as $key => $value){
    		if($value==$column){
    			$setted = true;
    		}
    	}
    	if($setted===false){
	    	$id = count($this->columnsAsCpfCnpj);
	    	$this->columnsAsCpfCnpj[$id] = $column;
    	}
    }
    public function setColumnsAsCnae($column){
    	$setted = false;
    	foreach ($this->columnsAsCnae as $key => $value){
    		if($value==$column){
    			$setted = true;
    		}
    	}
    	if($setted===false){
    		$id = count($this->columnsAsCnae);
    		$this->columnsAsCnae[$id] = $column;
    	}
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
    public function setColumnsAsFormatTime($column,$type="hour"){
    	$arrayColumns = explode(",", $column);
    	foreach ($arrayColumns as $key => $value){
    		$id = count($this->columnsAsFormatTime);
    		$this->columnsAsFormatTime[$id] = $arrayColumns[$key];
    		$this->columnsAsFormatTimeType[$id] = $type;
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
    public function setColumnsMask($column,$arrayToMak){
    	$id = count($this->columnsMask);
    	$this->columnsMask[$id] = $column;
    	if(is_array($arrayToMak)){
			$newArray = array();
			foreach($arrayToMak as $kA => $vA){
				if(is_array($vA)){
					$newArray[$kA] = $vA[0];
				}else{
					break;
				}
			}
			if(count($newArray)==0){
				$this->columnsArrayToMask[$id] = $arrayToMak;
			}else{
				$this->columnsArrayToMask[$id] = $newArray;
			}
    	}else{
    		$this->columnsArrayToMask[$id] = explode(",", $arrayToMak);
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
    public function setActionOnClick($goToPage,$parameter,$column,$columnsThisTable,$pageName="",$addPageColumn=false,$core=false){
    	global $page;
        $this->columnsThisTableActionOnClick = explode(",",$columnsThisTable);
        $this->columnParameterGoToPage = $column;
        $this->columnsThisTableActionOnClickAddPageColumn = $addPageColumn;
        $this->java->setOnClick();
        if($addPageColumn===true){
			$addPageColumn = false;
        	$target = "_blank";
        }else{
        	$target = "";
        }
        if($page->stringToUpper($goToPage)=="COLUMN"){
        	$goToPage = "@COLUMN";
        }
        if($pageName!=""){
        	$this->java->setFunctionGoToPage($goToPage,$parameter,false,$target,"@".$pageName,$addPageColumn,$core);
        }else{
        	$this->java->setFunctionGoToPage($goToPage,$parameter,false,$target,"",$addPageColumn,$core);
        }
    }
    public function setActionSetValue($event,$obj,$value="",$columnsThisTable,$valueB=false,$valueC=false){
    	$id = count($this->objActionSetValue);
    	$this->objActionSetValue[$id]['columnsThisTableActionSetValue'] = explode(",",$columnsThisTable);
    	$this->objActionSetValue[$id]['columnParameterSetValue'] = $value;
    	$this->objActionSetValue[$id]['columnParameterSetValueB'] = $valueB;
    	$this->objActionSetValue[$id]['columnParameterSetValueC'] = $valueC;
    	$this->objActionSetValue[$id]['objSetValue'] = $obj;
    	if($this->stringToUpper($event)=="CLICK"){
    		$this->java->setOnClick();
    	}
    	$this->java->setFunctionSetValue($obj,false,"@var".$id);
    }
    public function setActionReset($event,$obj,$columnsThisTable,$typeObj="textBox",$value="",$valueB=false,$valueC=false,$valueD=false){
    	$id = count($this->objActionReset);
    	$this->objActionReset[$id]['columnsThisTableActionReset'] = explode(",",$columnsThisTable);
    	$this->objActionReset[$id]['columnParameterReset'] = $value;
    	$this->objActionReset[$id]['columnParameterResetB'] = $valueB;
    	$this->objActionReset[$id]['columnParameterResetC'] = $valueC;
    	$this->objActionReset[$id]['columnParameterResetD'] = $valueD;
    	$this->objActionReset[$id]['objReset'] = $obj;
    	$this->objActionReset[$id]['typeObj'] = $typeObj;
    	if($this->stringToUpper($event)=="CLICK"){
    		$this->java->setOnClick();
    	}
    	$this->java->setFunctionReset($obj,$typeObj,"@varA".$id,"@varB".$id,"@varC".$id);
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
    public function setColumnsAlignArray($columnsAlignArray){
    	$this->columnsAlignArray = $columnsAlignArray;
    }
    public function setColumnsWidthArray($columnsWidthArray){
    	$this->columnsWidthArray = $columnsWidthArray;
    }
    public function setColumnsFake($columnsFake=""){
        $this->columnsFake = explode(",",$columnsFake);
    }
    public function setColumnsFakeArray($columnsFakeArray){
    	$this->columnsFakeArray = $columnsFakeArray;
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
    		if($this->dataBase->sqlServer===false){
    			$row = $this->res->fetch_assoc();
    		}else{
    			$row = sqlsrv_fetch_array( $this->res, SQLSRV_FETCH_ASSOC);
    		}
    		if($row){
	    		if($this->orderColumns!==false){
	    			$newRow = array();
	    			foreach ($this->orderColumns as $keyZA => $valueZA){
	    				$newRow[$valueZA] = @$row[$valueZA];
					}
					$this->rowMemory[count($this->rowMemory)] = $newRow;
	    			return $newRow;
	    		}else{
					$this->rowMemory[count($this->rowMemory)] = $row;
					return $row;
	    		}
    		}else{
    			return false;	
    		}
    	}else{
    		if(count($this->select)){
    			if($this->limit===false){
    				if($this->numRowsTotal){
    					$limit = $this->numRowsTotal;
    				}else{
    					$limit = $this->totalRowsArray;
    				}
    			}else{
    				$limit = $this->limit;
    			}
    			if($this->contRowsArray<$limit){
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
							$this->rowMemory[count($this->rowMemory)] = $newRow;
	    					return $newRow;
	    				}else{
							$this->rowMemory[count($this->rowMemory)] = $row;
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
	public function addButton($name,$class="",$title="Sem Título",$actionScript="",$parameter="",$column="",$arrayAddParameter="",$whereCondition="",$arrayValueCondition="",$target="",$javaType="goToPage",$objToLoad=false,$child=false,$anchor=false,$showLoading=true,$operator="="){
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
		$this->button[$id]['operator'] = $operator;
		$this->button[$id]['arrayValueCondition'] = explode(",", $arrayValueCondition);
		$this->button[$id]['target'] = $target;
		$this->button[$id]['javaType'] = $javaType;
		$this->button[$id]['objToLoad'] = $objToLoad;
		$this->button[$id]['child'] = $child;
		$this->button[$id]['anchor'] = $anchor;
		$this->button[$id]['showLoading'] = $showLoading;
		if($javaType=="reloadScript"){
			$this->button[$id]['actionScript'] = $this->button[$id]['actionScript']."?".$parameter."=";
		}
	}
	public function addTextBox($name,$class="",$title="Sem Título",$column=""){
		$id = count($this->textBox);
		@$this->textBox[$id]['enable'] = true;
		$this->textBox[$id]['name'] = $name;
		$this->textBox[$id]['columnTitle'] = $title;
		$this->textBox[$id]['Class'] = $class;
		$this->textBox[$id]['column'] = $column;
	}
	public function addCheckBox($name,$title="Sem Título",$column=""){
		$id = count($this->checkBox);
		$this->checkBox[$id]['enable'] = true;
		$this->checkBox[$id]['name'] = $name;
		$this->checkBox[$id]['columnTitle'] = $title;
		$this->checkBox[$id]['column'] = $column;
	}
    private function exeFillData(){
		global $page;
		global $PAGENAME;
		if(!isset($sumTotal)){
			$sumTotal = array();
		}

    	if($this->command===true){
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
        foreach ($this->textBox as $keyAE => $valueAE){
	        if($this->textBox[$keyAE]['enable']===true){
	        	$colspanAdd++;
	        }
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
        
        if($this->limit===false){
        	if($this->numRowsTotal){
        		$limit = $this->numRowsTotal;
        	}else{
        		$limit = $this->totalRowsArray;
        	}
        }else{
        	$limit = $this->limit;
        }
        $this->numRead = $limit * $this->page;
        $keyAnt = false;
        $arrayKeys = array();
        while($this->row = $this->read()){
        	# PROCESSO DE CAPTURA DO ARRAY DE KEYS
        	if($this->primaryKey!==false && $this->sessionNameArrayKeys!==false){
        		if(isset($this->row[$this->primaryKey])){
	        		if($keyAnt===false){
	        			$keyAnt = $this->row[$this->primaryKey];
	        			$arrayKeys[$this->row[$this->primaryKey]]['anterior'] = false;
	        			$arrayKeys[$this->row[$this->primaryKey]]['proxima'] = false;
	        		}else{
	        			$arrayKeys[$this->row[$this->primaryKey]]['anterior'] = $keyAnt;
	        			$arrayKeys[$this->row[$this->primaryKey]]['proxima'] = false;
	        			$arrayKeys[$keyAnt]['proxima'] = $this->row[$this->primaryKey];
	        			$keyAnt = $this->row[$this->primaryKey];
	        		}
        		}
        	}
        	# FIM - PROCESSO DE CAPTURA DO ARRAY DE KEYS
        	
            if($first==0){
                $useFake = count($this->columnsFake);
                if($useFake==0){
                	$useFake = count($this->columnsFakeArray);
                }
                if($this->numRowsTotal){
                	$numTotal = $this->numRowsTotal;
                }else{
                	$numTotal = $this->totalRowsArray;
                }
                if(!isset($this->withOutTitle) || ceil(($numTotal/$limit))>1){
	                $this->e("<tr class=\"table firstTr trTitle\">",$this->nivel+1);
	                $this->e("<td colspan=\"".(count($this->row)+count($this->columns)+$colspanAdd-count($this->columnsHidden))."\" align=\"".$this->titleAlign."\" class=\"td titleTable\">",$this->nivel+2);
	                $this->e("<table width=\"100%\"><tr>",$this->nivel+3);
	                if($this->numRowsTotal>$limit || $this->totalRowsArray>$limit){
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
                        	$buttonB->java->setFunctionGoToPage($this->pathScriptCommand,"formDataTableAdapterB".$this->getName(),$previousPage,false,false,false,$this->objCore);
                        }else{
                        	$buttonB->java->setFunctionReloadScript($this->commandReloadScriptObj, $this->commandReloadScriptScript."?formDataTableAdapterB".$this->getName()."=".$previousPage);
                        }
                        $textForm = new space($baseForm,"textFormDataTableAdapter","center","textContPage");
                        $textForm->css->color($colorTextPages);
                        $textForm->inSide(($this->page+1)."/".ceil(($numTotal/$limit)));
                        if($this->pathScriptCommand){
                        	$form = new form($baseForm,"formDataTableAdapterA","post",$this->pathScriptCommand,"",0,$this->nivel+5);
                        }else{
                        	$form = new form($baseForm,"formDataTableAdapterA","post",$this->actionScriptStandard,"",0,$this->nivel+5);
                        }
                        $form->setHidden("dataTableAdapterLimitPage",ceil(($numTotal/$limit)));
                        $buttonA = new button($form,"btNext",$this->labelNext,"btTable btTableB");
                        $buttonA->java->setOnClick();
                        if(($this->page+2)>ceil(($numTotal/$limit))){
                        	$nextPage = ($this->page+1);
                        }else{
                        	$nextPage = ($this->page+2);
                        }
                        if($this->commandReloadScript===false){
                        	$buttonA->java->setFunctionGoToPage($this->pathScriptCommand,"formDataTableAdapterA".$this->getName(),$nextPage,false,false,false,$this->objCore);
                        }else{
                        	$buttonA->java->setFunctionReloadScript($this->commandReloadScriptObj, $this->commandReloadScriptScript."?formDataTableAdapterA".$this->getName()."=".$nextPage);
                        }
                        $baseForm->End();
                        $this->e("</td>",$this->nivel+4);
	                }
	                $this->e("<td align=\"".$this->titleAlign."\" class=\"titleTable\">",$this->nivel+4);
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
	                    
	                    # ADICIONA CLASS EM COLUNA ESPECÍFICA
	                    foreach ($this->columnsClassAdd as $keyAA => $valueAA){
	                    	if($valueAA['column']==$key){
	                    		$classCss .= " ".$valueAA['class'];
	                    		break;
	                    	}
	                    }
	                    # FIM - ADICIONA CLASS EM COLUNA ESPECÍFICA
	                    
	                    $contOrderBy = 0;
	                    $orderThis = "";
	                    foreach($this->orderBy as $valueB){
	                        $contOrderBy++;
	                        if($valueB==$key){
	                            $classCss .= " orderByThisColumn";
	                            $orderThis = " (".$contOrderBy.")";
	                        }
	                    }
	                    $commandB = "";
	                    if($this->columnFilterValue!="" && $key==$this->columnFilter){
	                    	$classCss .= " filteredColumn";
	                    	if($this->command===true){
	                    		$commandB = $this->javaC->getLineCommand($this->columnFilterValue);
	                    	}
	                    }else{
	                    	if($this->command===true){
	                    		$commandB = $this->javaB->getLineCommand($key);
	                    	}
	                    }
	                    $classCss .= "\" ";
	                    if($hidden==0){
	                    	$width = "";
	                    	if(isset($this->columnsWidthArray[$key])){
	                    		$width = " width='".$this->columnsWidthArray[$key]."'";
	                    	}
		                    if(isset($this->columnsWidth[$i])){
		                    	$this->e("<td width='".$this->columnsWidth[$i]."' align='".$this->alignSubTitle."' ".$classCss.$commandB.">",$this->nivel+2);
		                    }else if($this->alignSubTitle!==false){
		                    	$this->e("<td align='".$this->alignSubTitle."' ".$classCss.$commandB.$width.">",$this->nivel+2);
		                    }else{
		                    	$alignSubTitle = @$this->columnsAlignArray[$key];
		                    	$this->e("<td align='".$alignSubTitle."' ".$classCss.$commandB.$width.">",$this->nivel+2);
		                    }
		                    if($useFake>0){
		                    	if(count($this->columnsFakeArray)>0){
		                    		if(isset($this->columnsFakeArray[$key])){
		                    			$this->e($this->columnsFakeArray[$key],$this->nivel+3);
		                    		}else{
		                    			$this->e($key,$this->nivel+3);
		                    		}
		                    	}else{
			                        if(isset($this->columnsFake[$i])){
			                            $this->e($this->columnsFake[$i].$orderThis,$this->nivel+3);
			                        }else{
			                            $this->e("Sem nome".$orderThis,$this->nivel+3);
			                        }
		                    	}
		                    }else{
		                        $this->e($key.$orderThis,$this->nivel+3);
		                    }
		                    $this->e("</td>",$this->nivel+2);
	                    }
	                    $i++;
	                }
	                foreach ($this->textBox as $keyAF => $valueAF){
		                if(@$this->textBox[$keyAF]['enable']===true){
		                	$classCss = " class=\"td";
		                	$classCss .= "\" ";
		                	if(isset($this->columnsWidth[$i])){
		                		$this->e("<td width='".$this->columnsWidth[$i]."' align='center' ".$classCss.$commandB.">",$this->nivel+2);
		                	}else{
		                		$this->e("<td align='center' ".$classCss.">",$this->nivel+2);
		                	}
		                	$this->e($this->textBox[$keyAF]['columnTitle'],$this->nivel+3);
		                	$this->e("</td>",$this->nivel+2);
		                }
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
	                foreach ($this->textBox as $keyAG => $valueAG){
		                if($this->textBox[$keyAG]['enable']===true && $firstForm==0){
		                	$firstForm = 1;
		                	$this->e("<form id='FORM_table' name='FORM_table' method='POST' action='' enctype='multipart/form-data'>");
		                }
	                }
	                /*foreach ($this->checkBox as $keyW => $valueW){
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
            	if(@$this->objCondition->$formatConditionSettedStatic->backgroundColor!=""){
            		$this->e("<tr style='".@$this->objCondition->$formatConditionSettedStatic->backgroundColor.@$this->objCondition->$formatConditionSettedStatic->color."' class='".$this->objCondition->$formatConditionSettedStatic->addClass."'>",$this->nivel+1);
            	}else{
            		if(@$this->objCondition->$formatConditionSettedStatic->addClass!=""){
            			$this->objCondition->$formatConditionSettedStatic->addClass = " ".$this->objCondition->$formatConditionSettedStatic->addClass;
            		}
            		if($this->standardColor==1){
            			if($color){
            				$this->e("<tr class=\"colorTrB".@$this->objCondition->$formatConditionSettedStatic->addClass."\">",$this->nivel+1);
            			}else{
            				$this->e("<tr class=\"colorTrA".@$this->objCondition->$formatConditionSettedStatic->addClass."\">",$this->nivel+1);
            			}
            		}else{
            			if($color){
            				$this->e("<tr class=\"colorTrD".@$this->objCondition->$formatConditionSettedStatic->addClass."\">",$this->nivel+1);
            			}else{
            				$this->e("<tr class=\"colorTrC".@$this->objCondition->$formatConditionSettedStatic->addClass."\">",$this->nivel+1);
            			}
            		}
            	}
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
            	$alignOwner = false;
            	if(strpos($this->stringToUpper($key),"CPF")!==false || strpos($this->stringToUpper($key),"CNPJ")!==false){
            		$this->setColumnsAsCpfCnpj($key);
            		$alignOwner = "right";
            	}
            	if($this->stringToUpper($key)=="CODIGOCNAE"){
            		$this->setColumnsAsCnae($key);
            		$alignOwner = "center";
            	}
            	# VERIFICA SE O VALOR RETORNADO NÃO É UM OBJETO
            	if(is_object($value)){
					$columnsAsFormatDateSetted = false;
					if(count($this->columnsAsFormatDate)>0){
		                foreach ($this->columnsAsFormatDate as $keyC =>$valueC){
		                	if($key==$valueC){
		                		$columnsAsFormatDateSetted = true;
		                	}
		                }
					}
					
					if($columnsAsFormatDateSetted===false){
						$value = $value->format("d/m/Y_H:i:s");
					}
            	}
            	# FIM - VERIFICA SE O VALOR RETORNADO NÃO É UM OBJETO
            	$myColumns[$key] = 1;
            	$hidden = 0;
            	if(count($this->columnsHidden)>0){
            		foreach ($this->columnsHidden as $valueL){
            			if($key==$valueL){
            				$hidden = 1;
            			}
            		}
            	}
            	if(count($this->columnsLink)>0){
            		foreach ($this->columnsLink as $valueAC){
            			if($key==$valueAC['column']){
            				$true = true;
            				if($valueAC['whereCondition']!==false){
            					$true = false;
	            				if(isset($this->row[$valueAC['valueCondition']])){
	            					$valueCondition = $this->row[$valueAC['valueCondition']];
	            				}else{
	            					$valueCondition = $valueAC['valueCondition'];
	            				}
	            				$whereCondition = $this->row[$valueAC['whereCondition']];
	            				
	            				# OPERAÇÕES NUMÉRICAS
	            				$whereCondition = str_replace(",", ".", $whereCondition);
	            				$valueCondition = str_replace(",", ".", $valueCondition);
	            				$operator = $valueAC['operator'];
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
            				}
            				if($true===true){
            					if($valueAC['fake']!==false){
            						$value = $valueAC['fake']; 
            					}
	            				if(strpos($valueAC['link'], "@")===false){
	            					$value = "<a href=\"".$valueAC['link']."\" target=\"_blank\" style=\"".$valueAC['styles']."\">".$value."</a>";
	            				}else{
	            					$valueAC['link'] = str_replace("@", "", $valueAC['link']);
	            					$value = "<a href=\"".$this->row[$valueAC['link']]."\" target=\"_blank\" style=\"".$valueAC['styles']."\">".$value."</a>";
	            				}
            				}
            			}
            		}
            	}
            	if(count($this->columnsLimitCharacter)>0){
            		foreach ($this->columnsLimitCharacter as $keyAB => $valueAB){
            			if($key==$valueAB['column']){
            				if(strlen($value)>$valueAB['limit']){
            					$value = substr($value, 0, $valueAB['limit'])."...";
            				}
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
            	if($alignOwner===false){
                	$align = "left";
            	}else{
            		$align = $alignOwner;
            	}
                if(isset($this->aligns[$i])){
                	if($this->aligns[$i]=="c"){
                		$this->aligns[$i] = "center";
                	}else if($this->aligns[$i]=="r"){
                		$this->aligns[$i] = "right";
                	}else if($this->aligns[$i]=="l"){
                		$this->aligns[$i] = "left";
                	}
                	if($alignOwner===false){
                    	$align = $this->aligns[$i];
                	}else{
                		$align = $alignOwner;
                	}
                }
                if(count($this->columnsAlignArray)>0){
                	if($alignOwner===false){
                		$align = @$this->columnsAlignArray[$key];
                	}else{
                		$align = $alignOwner;
                	}
                }
                $width = "";
                if(count($this->columnsWidthArray)>0){
                	if(isset($this->columnsWidthArray[$key])){
                		$width = " width=\"".$this->columnsWidthArray[$key]."\"";
                	}
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
	                		$temp = $this->row[$this->objActionSetValue[$keyZ]['columnParameterSetValue']];
	                		if($this->objActionSetValue[$keyZ]['columnParameterSetValueB']!==false){
	                			$temp .= " - ".$this->row[$this->objActionSetValue[$keyZ]['columnParameterSetValueB']];
	                		}
	                		if($this->objActionSetValue[$keyZ]['columnParameterSetValueC']!==false){
	                			if(strpos($this->objActionSetValue[$keyZ]['columnParameterSetValueC'],"cpf")!==false){
	                				$tempB = $this->formatCpfCnpj($this->row[$this->objActionSetValue[$keyZ]['columnParameterSetValueC']]);
	                			}else{
	                				$tempB = $this->row[$this->objActionSetValue[$keyZ]['columnParameterSetValueC']];
	                			}
	                			$temp .= " - ".$tempB;
	                		}
	                		if($firstB==1){
	                			$firstB = 0;
	                			$command = $this->java->getLineCommand("@var".$keyZ,$temp,true);
	                		}else{
	                			$command = $this->java->getLineCommand("@var".$keyZ,$temp,true,$command);
	                		}
	                	}
	                }
                }
                foreach ($this->objActionReset as $keyZ => $valueZ){
                	foreach($this->objActionReset[$keyZ]['columnsThisTableActionReset'] as $valueB){
                		if($key==$valueB){
                			
                			/*$this->objActionReset[$id]['columnParameterReset'] = $value;
                			$this->objActionReset[$id]['columnParameterResetB'] = $valueB;
                			$this->objActionReset[$id]['columnParameterResetC'] = $valueC;
                			$this->objActionReset[$id]['columnParameterResetD'] = $valueD;
                			
                			$this->java->setFunctionReset($obj,$typeObj,"@varA".$id,"@varB".$id,"@varC".$id);*/
                			
                			if($firstB==1){
                				$firstB = 0;
                				$command = $this->java->getLineCommand("@varA".$keyZ,$this->row[$this->objActionReset[$keyZ]['columnParameterReset']],true);
                			}else{
                				$command = $this->java->getLineCommand("@varA".$keyZ,$this->row[$this->objActionReset[$keyZ]['columnParameterReset']],true,$command);
                			}
                			if($this->objActionReset[$keyZ]['columnParameterResetB']=="codigoCnae"){
                				$temp = $this->formatCnae($this->row[$this->objActionReset[$keyZ]['columnParameterResetB']]);
                			}else{
                				$temp = $this->row[$this->objActionReset[$keyZ]['columnParameterResetB']];
                			}
                			if($this->objActionReset[$keyZ]['columnParameterResetC']!==false){
                				$temp .= " - ".$this->row[$this->objActionReset[$keyZ]['columnParameterResetC']];
                			}
                			if($this->objActionReset[$keyZ]['columnParameterResetD']!==false){
                				if(strpos($this->objActionReset[$keyZ]['columnParameterResetD'],"cpf")!==false){
                					$tempB = $this->formatCpfCnpj($this->row[$this->objActionReset[$keyZ]['columnParameterResetD']]);
                				}else{
                					$tempB = $this->row[$this->objActionReset[$keyZ]['columnParameterResetD']];
                				}
                				$temp .= " - ".$tempB;
                			}
                			$command = $this->java->getLineCommand("@varB".$keyZ,$temp,true,$command);
                			$command = $this->java->getLineCommand("@varC".$keyZ,$this->row[$this->objActionReset[$keyZ]['columnParameterReset']],true,$command);
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
                		if($firstB==1){
                			$command = $this->java->getLineCommand("",$value);
                		}else{
                			$command = $this->java->getLineCommand("",$value,true,$command);
                		}
                	}
                }
                if($key==$this->columnFilter){
                	if($this->command===true){
                    	$command = $this->javaC->getLineCommand($valueParameterGoToPageC);
                	}
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
							$tempFormatConditionSetted = $formatConditionSetted[$key];
	                		if(!isset($this->objCondition->$tempFormatConditionSetted)){
	                			$formatConditionEnableColumnSimple = false;
	                		}
                		}
                	}
                	
                	$classCss = "class=\"td";
                	
                	# ADICIONA CLASS EM COLUNA ESPECÍFICA
                	foreach ($this->columnsClassAdd as $keyAA => $valueAA){
                		if($valueAA['column']==$key){
                			$classCss .= " ".$valueAA['class'];
                			break;
                		}
                	}
                	# FIM - ADICIONA CLASS EM COLUNA ESPECÍFICA
                	
                	$classCss .= "\"";
                	
                	if($formatConditionEnableColumnSimple===true){
						$tempFormatConditionSetted = $formatConditionSetted[$key];
                		if(isset($this->objCondition->$tempFormatConditionSetted)){
		                	if($this->objCondition->$tempFormatConditionSetted->repeat){
		                		$repeatCondition = $key;
		                		$repeatConditionValue = $this->objCondition->$tempFormatConditionSetted->repeat;
		                	}
                		}
	                	$this->e("<td ".$classCss." align=\"".$align."\"".$width.$command." style='".$this->objCondition->$tempFormatConditionSetted->backgroundColor.$this->objCondition->$tempFormatConditionSetted->color."'>",$this->nivel+2);
	                }else{
	                	if($repeatCondition && $repeatConditionValue){
	                		$repeatConditionValue--;
	                		$this->e("<td ".$classCss." align=\"".$align."\"".$width.$command." style='".$this->objCondition->$formatConditionSetted[$repeatCondition]->backgroundColor.$this->objCondition->$formatConditionSetted[$repeatCondition]->color."'>",$this->nivel+2);
	                	}else{
	                		$repeatCondition = false;
	                		$repeatConditionValue = 0;
	                		$this->e("<td ".$classCss." align=\"".$align."\"".$width.$command.">",$this->nivel+2);
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
		                			$value = $page->formatCpfCnpj($value);
		                		}
		                	}
	                	}
	                }
	                if(count($this->columnsAsCnae)>0){
	                	if(strlen($value)>1){
	                		foreach ($this->columnsAsCnae as $valueJ){
	                			if($key==$valueJ){
	                				$value = $page->formatCnae($value);
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
	                if(count($this->columnsAsFormatTime)>0){
	                	foreach ($this->columnsAsFormatTime as $keyC =>$valueC){
	                		if($key==$valueC){
	                			$value = $this->formatTime($value,$this->columnsAsFormatTimeType[$keyC]);
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
	                			if($value!==false){
		                			if(strlen($value)==0){
		                				$value = 0;
		                			}
		                			$value = number_format($value,$this->columnsAsNumberDecimals[$keyK],",",".");
	                			}
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
	                
	                /*
	                 * TRANSFORMA COLUMA EM IMAGEM
	                 */
	                if(isset($this->columnsAsImage[$key])){
	                	if(strpos($value, ",")===false){
		                	if(strpos($value, ".")===false){
		                		$value = $value.".png";
		                	}
		                	if($this->columnsAsImage[$key]['path']===false){
		                		if(strlen(base64_encode(file_get_contents($value)))==0){
		                			$value = str_replace(".png", ".jpg", $value);
		                		}
		                		$value = "<img src=\"".$value."\" class=\"".$this->columnsAsImage[$key]['class']."\" style=\"";
		                	}else{
		                		if(strlen(base64_encode(file_get_contents($this->columnsAsImage[$key]['path'].$value)))==0){
		                			$value = str_replace(".png", ".jpg", $value);
		                		}
		                		$value = "<img src=\"".$this->columnsAsImage[$key]['path'].$value."\" class=\"".$this->columnsAsImage[$key]['class']."\" style=\"";
		                	}
		                	if($this->columnsAsImage[$key]['width']!==false){
		                		$value .= "width:".$this->columnsAsImage[$key]['width'].";";
		                	}
		                	if($this->columnsAsImage[$key]['height']!==false){
		                		$value .= "height:".$this->columnsAsImage[$key]['height'].";";
		                	}
		                	$value .= "\" />";
	                	}else{
	                		$imagens = explode(",", $value);
	                		$value = "";
	                		foreach ($imagens as $keyAD => $valueAD){
	                			if(strpos($valueAD, ".")===false){
	                				$valueAD = $valueAD.".png";
	                			}
	                			if($this->columnsAsImage[$key]['path']===false){
	                				if(strlen(base64_encode(file_get_contents($valueAD)))==0){
	                					$valueAD = str_replace(".png", ".jpg", $valueAD);
	                				}
	                				$value .= "<img src=\"".$valueAD."\" class=\"".$this->columnsAsImage[$key]['class']."\" style=\"float:left;margin-right:5px;";
	                			}else{
	                				if(strlen(base64_encode(file_get_contents($this->columnsAsImage[$key]['path'].$valueAD)))==0){
	                					$valueAD = str_replace(".png", ".jpg", $valueAD);
	                				}
	                				$value .= "<img src=\"".$this->columnsAsImage[$key]['path'].$valueAD."\" class=\"".$this->columnsAsImage[$key]['class']."\" style=\"float:left;margin-right:5px;";
	                			}
	                			if($this->columnsAsImage[$key]['width']!==false){
	                				$value .= "width:".$this->columnsAsImage[$key]['width'].";";
	                			}
	                			if($this->columnsAsImage[$key]['height']!==false){
	                				$value .= "height:".$this->columnsAsImage[$key]['height'].";";
	                			}
	                			$value .= "\" />";
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
	            			if($this->button[$keyT]['operator']=="="){
		            			if(@$this->row[$this->button[$keyT]['whereCondition']]==$valueH){
		            				$printButton = 1;
		            			}
	            			}else if($this->button[$keyT]['operator']==">"){
	            				if(@$this->row[$this->button[$keyT]['whereCondition']]>$valueH){
	            					$printButton = 1;
	            				}
	            			}else if($this->button[$keyT]['operator']=="<="){
	            				if(@$this->row[$this->button[$keyT]['whereCondition']]<=$valueH){
	            					$printButton = 1;
	            				}
	            			}
	            		}
	            	}else{
	            		$printButton = 1;
	            	}
	            	foreach ($this->button[$keyT]['arrayValueCondition'] as $keyH => $valueH){
	            		if($this->button[$keyT]['operator']=="="){
		            		if(@$this->row[$this->button[$keyT]['whereCondition']]==$valueH){
		            			$index = $keyH;
		            			break;
		            		}
		            	}else if($this->button[$keyT]['operator']=="<="){
		            		if(@$this->row[$this->button[$keyT]['whereCondition']]<=$valueH){
		            			$index = $keyH;
		            			break;
		            		}
	            		}
	            	}
	            	$this->button[$keyT]['java'] = new java();
	            	$this->newObj($this->button[$keyT]['java'],"JAVA_".$this->button[$keyT]['name'][0]."_".@$contRow,"java",@$this->name);
	            	if($printButton){
		            	$this->button[$keyT]['java']->setOnClick();
		            	if($this->button[$keyT]['javaType']=="goToPage"){
		            		$this->button[$keyT]['java']->setFunctionGoToPage($this->button[$keyT]['actionScript'],$this->button[$keyT]['parameter'],$this->row[$this->button[$keyT]['column']],$this->button[$keyT]['target'],$this->button[$keyT]['arrayAddParameter'][$index],false,$this->button[$keyT]['child']);
		            	}else if($this->button[$keyT]['javaType']=="reloadScript"){
		            		$this->button[$keyT]['java']->setFunctionReloadScript($this->button[$keyT]['objToLoad'],$this->button[$keyT]['actionScript'].$this->row[$this->button[$keyT]['column']].$this->button[$keyT]['arrayAddParameter'][0]);
		            	}else{
		            		$this->button[$keyT]['java']->setFunctionGoToPage($this->button[$keyT]['actionScript'],$this->button[$keyT]['parameter'],$this->row[$this->button[$keyT]['column']],$this->button[$keyT]['target'],$this->button[$keyT]['arrayAddParameter'][$index],false,$this->button[$keyT]['child']);
		            	}
		            	
		            	$anchorOpen = "";
		            	$anchorClose = "";
	            		if($this->button[$keyT]['anchor']!==false){
	            			$anchorOpen = "<a href=\"#".$this->button[$keyT]['anchor']."\">";
	            			$anchorClose = "</a>";
	            		}
		            	
	            		$this->e($anchorOpen."<div id=\"".$this->button[$keyT]['name'][$index]."_".$contRow."\" name=\"".$this->button[$keyT]['name'][$index]."_".$contRow."\" class=\"".$this->button[$keyT]['Class']."\" align=\"center\"".$this->button[$keyT]['java']->getLineCommand().">",$this->nivel+3);
		            	if(count($this->button[$keyT]['name'])==1){
		            		$this->e($this->button[$keyT]['name'][0],$this->nivel + 4);
		            	}else{
		            		$this->e($this->button[$keyT]['name'][$index],$this->nivel + 4);
		            	}
		            	$this->e("</div>".$anchorClose,$this->nivel+3);
	            	}
	            	$this->e("</td>",$this->nivel+2);
	            }
            }
            foreach ($this->textBox as $keyAH => $valueAH){
	            if($this->textBox[$keyAH]['enable']===true){
	            	$this->e("<td class=\"td\" align=\"center\">",$this->nivel+2);
	            	$this->textBox[$keyAH]['java'] = new java();
	            	$this->newObj($this->textBox[$keyAH]['java'],"JAVA_".$this->textBox[$keyAH]['name']."_".$contRow,"java",$this->name[0]);
	            	$this->textBox[$keyAH]['java']->setOnClick();
	            	$index = 0;
	            	/*if(isset($this->textBox->arrayValueCondition)){
		            	foreach (@$this->textBox->arrayValueCondition as $keyH => $valueH){
		            		if($this->row[$this->textBox->whereCondition]==$valueH){
		            			$index = $keyH;
		            		}
		            	}
	            	}*/
	            	#$this->textBox[$keyAH]['java']->setFunctionGoToPage(@$this->textBox->actionScript,@$this->textBox->parameter,@$this->row['idOrdemProducaoEmbalagem'],@$this->textBox->target,@$this->textBox->arrayAddParameter[$index]);
	            	if($this->textBox[$keyAH]['column']==""){
	            		$this->e("<input type=\"text\" id=\"".$this->textBox[$keyAH]['name']."\" name=\"".$this->textBox[$keyAH]['name']."[".$contRow."]\" value=\"\" class=\"".$this->textBox[$keyAH]['Class']."\" maxlength=\"\" />",$this->nivel+3);
	            	}else{
	            		$this->e("<input type=\"text\" id=\"".$this->textBox[$keyAH]['name']."\" name=\"".$this->textBox[$keyAH]['name']."[".$this->row[$this->textBox[$keyAH]['column']]."]\" value=\"\" class=\"".$this->textBox[$keyAH]['Class']."\" maxlength=\"\" />",$this->nivel+3);
	            	}
	                $this->e("</td>",$this->nivel+2);
	            }
            }
            foreach ($this->checkBox as $keyZ => $valueZ){
	            if($this->checkBox[$keyZ]['enable']===true){
	            	$this->e("<td class=\"td\" align=\"center\">",$this->nivel+2);
	            	if($this->checkBox[$keyZ]['column']==""){
	            		$this->e("<input type=\"checkbox\" id=\"".$this->checkBox[$keyZ]['name']."\" name=\"".$this->checkBox[$keyZ]['name']."[".$contRow."]\" checked />",$this->nivel+3);
	            	}else{
	            		$this->e("<input type=\"checkbox\" id=\"".$this->checkBox[$keyZ]['name']."\" name=\"".$this->checkBox[$keyZ]['name']."[".$this->row[$this->checkBox[$keyZ]['column']]."]\" checked />",$this->nivel+3);
	            	}
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
        
        # PROCESSO ARRAY KEYS
        if($this->primaryKey!==false && $this->sessionNameArrayKeys!==false){
        	$page->session->setSession($this->sessionNameArrayKeys,$arrayKeys);
        }
        # FIM - PROCESSO ARRAY KEYS
        
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
		$page->session->setSession("tableMemory_".$this->name,$this->rowMemory,$PAGENAME);
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
    	}else{
    		if($this->limit===false){
    			$limit = $this->totalRowsArray;
    		}else{
    			$limit = $this->limit;
    		}
    		if($limit){
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
    		if(($limit * $this->page)>=$this->totalRowsArray){
    			$this->page = 0;
    			$page->session->setSession("dataTableAdapterPage".$this->name,"0",$page->getName());
    		}
    		$numRows = $this->totalRowsArray;
    		$numIgnore = $limit * $this->page;
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
		$this->e("<table cellspacing=\"0\" id=\"".$this->name."\" name=\"".$this->name."\" width=\"".$this->width."\" class=\"table ".$this->Class."\">",$this->nivel);
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
					if(!is_array($this->row)){
						$this->row = array();
					}
					if(!is_array($this->columns)){
						$this->columns = array();
					}
	                $this->e("<tr class=\"firstTr trTitle\">",$this->nivel+1);
	                $this->e("<td colspan=\"".(count($this->row)+count($this->columns))."\" align=\"".$this->titleAlign."\" class=\"titleTable\">",$this->nivel+2);
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