<?php
# Form
$RESET_AUTOSAVE = false;

class form extends generic {
	private $dataSet;
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
	private $sel;
	private $ins;
	private $upd;
	private $resultAuthenticate = false;
	private $resultInsert = false;
    private $resultUpdate = false;
	private $row;
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
    public $backGroundColorError = "rgb(210,80,80)";
	public $css;
	public $java;
	
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
	}
	public function getAutocompleteOff(){
		return $this->autoCompleteOff;
	}
	
	public function getUpperCase(){
		return $this->uppercase;
	}
	
	public function unSetUpperCase(){
		global $textBoxStyle;
		$textBoxStyle->unSetUpperCase();
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
		$this->ins->setInsert($column,$value,$check,$multiInsert);
	}
	public function setColumn($column,$value,$withoutQuotation=false){
		$this->upd->setColumn($column,$value,$withoutQuotation);
	}
	public function setJoin($table,$where,$operator,$value,$type="",$tableAs=""){
		$this->upd->setJoin($table,$where,$operator,$value,$type,$tableAs);
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
	public function setDataSet($dataSet){
		$this->dataSet = $dataSet;
		$this->ins = $this->dataSet->insert();
		$this->upd = $this->dataSet->update();
	}
	public function setObjAction($obj){
		$this->objAction = $obj;
	}
	public function setTable($table){
		$this->table = $table;
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
				$this->ins->set($this->table);
	            if(isset($this->hidden) && count($this->hidden)>0){
	                foreach($this->hidden as $key => $value){
	                    if($value=="auto"){
	                        $value = substr(time(),-8);
	                        $value = strrev($value);
	                    }
	                    $this->hidden[$key] = $value;
	                    $this->ins->setInsert($this->column[$key],$value);
	                }
	            }
	            if(isset($this->columnInsertTimeCurrent)){
	            	$this->ins->setInsert($this->columnInsertTimeCurrent,time());
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
						    }else{ 
							    if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine")){
								    if($name->getCheck() && $this->verifyValue($_POST[$OBJ[$i]['name']],$name->check)===false){
									    $this->changeBackgroundColor($name);
									    $this->errorForm = 2;
								    }
							    }
						    }
	                        if($name->getUnique()===true){
	                            $this->sel = $this->dataSet->select();
	                            $this->sel->set($this->table);
	                            $this->sel->setWhere($name->whereForCheckUnique,$name->operatorForCheckUnique,$name->valueForCheckUnique);
	                            if(is_numeric(@$_POST[$OBJ[$i]['name']])){
	                            	$this->sel->setAnd($name->getColumn(),"=",@$_POST[$OBJ[$i]['name']]);
	                            }else{
	                            	$this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
	                            }
	                            $this->sel->Exe();
	                            if($this->sel->getNumRows()>0){
	                                $this->changeBackgroundColor($name);
	                                $this->errorForm = 3;
	                            }
	                        }
	                        if($name->getIsNotEqual()!==false){
	                        	if($name->getIsNotEqual()==@$_POST[$OBJ[$i]['name']]){
	                        		$this->changeBackgroundColor($name);
	                        		$this->errorForm = 4;
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
						    		$this->ins->setInsert($name->getColumn(),@$_POST[$OBJ[$i]['name']]);
	                        	}
	                        }
	                    }
					}
				}
				if($this->errorForm==0){
					$this->ins->Exe();
					$this->msgError = $this->ins->getMsgError();
					$this->numErrors = $this->ins->getNumErrors();
					$this->sql = $this->ins->getSql();
					$this->resultInsert = $this->ins->getNumRows();
	                $this->newId = $this->ins->getNewId();
					return true;
				}else{
					return false;
				}
			}else{
				$name = $objFather;
				$this->ins->set($this->table);
				if(isset($this->hidden) && count($this->hidden)>0){
	                foreach($this->hidden as $key => $value){
	                    if($value=="auto"){
	                        $value = substr(time(),-8);
	                        $value = strrev($value);
	                    }
	                    $this->hidden[$key] = $value;
	                    $this->ins->setInsert($this->column[$key],$value);
	                }
	            }
	            if(isset($this->columnInsertTimeCurrent)){
	            	$this->ins->setInsert($this->columnInsertTimeCurrent,time());
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
						/*if($name->getRequired()===true && @$_POST[$OBJ[$i]['name']]==""){
						 $this->changeBackgroundColor($name);
						 $this->errorForm = 1;
						 }else{
						 if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine")){
						 if($name->getCheck() && $this->verifyValue($_POST[$OBJ[$i]['name']],$name->check)===false){
						 $this->changeBackgroundColor($name);
						 $this->errorForm = 2;
						 }
						 }
						 }*/
						/*if($name->getUnique()===true){
						 $this->sel = $this->dataSet->select();
						 $this->sel->set($this->table);
						 $this->sel->setWhere($name->whereForCheckUnique,$name->operatorForCheckUnique,$name->valueForCheckUnique,true,true);
						 $this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
						 $this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
						 $this->sel->Exe();
						 if($this->sel->getNumRows()>0){
						 $this->changeBackgroundColor($name);
						 $this->errorForm = 3;
						 }
						 }*/
						/*if($name->getMinimumLength()){
						 if(strlen(@$_POST[$OBJ[$i]['name']])<$name->getMinimumLength()){
						 $this->changeBackgroundColor($name);
						 $this->errorForm = 4;
						 }
						 }*/
						foreach ($name->comboBox as $keyB => $valueB){
							#if($name->comboBox[$keyB]['name']==$OBJ[$i]['name']){
							if($name->comboBox[$keyB]['column']){
								$typeColumn = $name->comboBox[$keyB]['typeColumn'];
								if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
									if($name->comboBox[$keyB]['uppercase']===true){
										$_POST[$name->comboBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->comboBox[$keyB]['name']]);
									}
								}
								if(isset($_POST[$name->comboBox[$keyB]['name']])){
									$this->ins->setInsert($name->comboBox[$keyB]['column'],$_POST[$name->comboBox[$keyB]['name']]);
								}
							}
							#}
						}
						foreach ($name->textBox as $keyB => $valueB){
							#if($name->textBox[$keyB]['name']==$OBJ[$i]['name']){
							if($name->textBox[$keyB]['column']){
								$typeColumn = $name->textBox[$keyB]['typeColumn'];
								if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
									if($name->textBox[$keyB]['uppercase']===true){
										$_POST[$name->textBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->textBox[$keyB]['name']]);
									}
								}
								if(isset($_POST[$name->textBox[$keyB]['name']])){
									$this->ins->setInsert($name->textBox[$keyB]['column'],$_POST[$name->textBox[$keyB]['name']]);
								}
							}
							#}
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
									$this->ins->setInsert($name->textBoxMultiLine[$keyB]['column'],$_POST[$name->textBoxMultiLine[$keyB]['name']]);
								}
							}
							#}
						}
					}
					#}
					#}
				if($this->errorForm==0){
					if($this->resultUpdate = $this->ins->Exe()){
						$this->msgError = $this->ins->getMsgError();
						$this->numErrors = $this->ins->getNumErrors();
						$this->sql = $this->ins->getSql();
						$this->newId = $this->ins->getNewId();
						return true;
					}else{
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
				#$objDataSet = $this->getObj("dataSet");
				$this->upd->set($this->table);
	            if($this->whereUpdate){
	                $this->upd->setWhere($this->whereUpdate,$this->operatorUpdate,$this->valueUpdate);
		            if(isset($this->hidden) && count($this->hidden)>0){
		                foreach($this->hidden as $key => $value){
		                    $this->upd->setColumn($this->column[$key],$value);
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
							    }else{ 
								    if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine")){
									    if($name->getCheck() && $this->verifyValue($_POST[$OBJ[$i]['name']],$name->check)===false){
										    $this->changeBackgroundColor($name);
										    $this->errorForm = 2;
									    }
								    }
							    }
		                        if($name->getUnique()===true){
		                            $this->sel = $this->dataSet->select();
		                            $this->sel->set($this->table);
		                            $this->sel->setWhere($name->whereForCheckUnique,$name->operatorForCheckUnique,$name->valueForCheckUnique,true,true);
		                            $this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
		                            $this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
		                            $this->sel->Exe();
		                            if($this->sel->getNumRows()>0){
		                                $this->changeBackgroundColor($name);
		                                $this->errorForm = 3;
		                            }
		                        }
		                        if($name->getMinimumLength()){
		                            if(strlen(@$_POST[$OBJ[$i]['name']])<$name->getMinimumLength()){
		                                $this->changeBackgroundColor($name);
		                                $this->errorForm = 4;
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
		                            	$this->upd->setColumn($name->getColumn(),$_POST[$OBJ[$i]['name']]);
		                        	}
		                        }
		                    }
						}
					}
	            }else{
	            	$this->errorForm = 5;
	            }
				if($this->errorForm==0){
					if($this->resultUpdate = $this->upd->Exe()){
						$this->msgError = $this->upd->getMsgError();
						$this->numErrors = $this->upd->getNumErrors();
						$this->sql = $this->upd->getSql();
						return true;
					}else{
						$this->msgError = $this->upd->getMsgError();
						$this->numErrors = $this->upd->getNumErrors();
						$this->sql = " SQL: " . $this->upd->getSql(true);
						return false;
					}
				}else{
					return false;
				}
    		}else{
    			$name = $objFather;
    			$this->upd->set($this->table);
    			if($this->whereUpdate){
    				$this->upd->setWhere($this->whereUpdate,$this->operatorUpdate,$this->valueUpdate);
    				if(isset($this->hidden) && count($this->hidden)>0){
    					foreach($this->hidden as $key => $value){
    						$this->upd->setColumn($this->column[$key],$value);
    					}
    				}
    				$this->errorForm = 0;
    				global $OBJ;
    				
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
    							/*if($name->getRequired()===true && @$_POST[$OBJ[$i]['name']]==""){
    								$this->changeBackgroundColor($name);
    								$this->errorForm = 1;
    							}else{
    								if(($OBJ[$i]['type']=="textBox" || $OBJ[$i]['type']=="textBoxMultiLine")){
    									if($name->getCheck() && $this->verifyValue($_POST[$OBJ[$i]['name']],$name->check)===false){
    										$this->changeBackgroundColor($name);
    										$this->errorForm = 2;
    									}
    								}
    							}*/
    							/*if($name->getUnique()===true){
    								$this->sel = $this->dataSet->select();
    								$this->sel->set($this->table);
    								$this->sel->setWhere($name->whereForCheckUnique,$name->operatorForCheckUnique,$name->valueForCheckUnique,true,true);
    								$this->sel->setAnd($this->whereUpdate,"<>",$this->valueUpdate);
    								$this->sel->setAnd($name->getColumn(),"=","'".@$_POST[$OBJ[$i]['name']]."'");
    								$this->sel->Exe();
    								if($this->sel->getNumRows()>0){
    									$this->changeBackgroundColor($name);
    									$this->errorForm = 3;
    								}
    							}*/
    							/*if($name->getMinimumLength()){
    								if(strlen(@$_POST[$OBJ[$i]['name']])<$name->getMinimumLength()){
    									$this->changeBackgroundColor($name);
    									$this->errorForm = 4;
    								}
    							}*/
    							foreach ($name->comboBox as $keyB => $valueB){
    								#if($name->comboBox[$keyB]['name']==$OBJ[$i]['name']){
	    								if($name->comboBox[$keyB]['column']){
	    									$typeColumn = $name->comboBox[$keyB]['typeColumn'];
	    									if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
	    										if($name->comboBox[$keyB]['uppercase']===true){
	    											$_POST[$name->comboBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->comboBox[$keyB]['name']]);
	    										}
	    									}
	    									if(isset($_POST[$name->comboBox[$keyB]['name']])){
	    										$this->upd->setColumn($name->comboBox[$keyB]['column'],$_POST[$name->comboBox[$keyB]['name']]);
	    									}
	    								}
    								#}
    							}
    							foreach ($name->textBox as $keyB => $valueB){
    								#if($name->textBox[$keyB]['name']==$OBJ[$i]['name']){
	    								if($name->textBox[$keyB]['column']){
	    									$typeColumn = $name->textBox[$keyB]['typeColumn'];
	    									if($typeColumn=="VARCHAR" || $typeColumn=="TEXT"){
	    										if($name->textBox[$keyB]['uppercase']===true){
	    											$_POST[$name->textBox[$keyB]['name']] = $this->stringToUpper($_POST[$name->textBox[$keyB]['name']]);
	    										}
	    									}
	    									if(isset($_POST[$name->textBox[$keyB]['name']])){
	    										$this->upd->setColumn($name->textBox[$keyB]['column'],$_POST[$name->textBox[$keyB]['name']]);
	    									}
	    								}
    								#}
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
    											$this->upd->setColumn($name->textBoxMultiLine[$keyB]['column'],$_POST[$name->textBoxMultiLine[$keyB]['name']]);
    										}
    									}
    								#}
    							}
    						}
    					#}
    				#}
    			}else{
    				$this->errorForm = 5;
    			}
    			if($this->errorForm==0){
    				if($this->resultUpdate = $this->upd->Exe()){
    					$this->msgError = $this->upd->getMsgError();
    					$this->numErrors = $this->upd->getNumErrors();
    					$this->sql = $this->upd->getSql();
    					return true;
    				}else{
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
	public function setAutocompleteOff(){
		$this->autoCompleteOff = false;
	}
	public function End(){
		if(isset($this->autoCompleteOff)){
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