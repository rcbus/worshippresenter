<?php
# Parâmetros
$PATH = "../ERP/";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoadWithoutStyle.php';

# Sistema de segurança
include_once @$PATH.'security.php';

$javaExe = new javaExe();

if($security==1){
	$name = @$_GET['SLT_NAME'];
	if($name){
		if($page->session->getSession($name."_DATASET")=="iDataSet"){
			$dataSet = $idsa;
		}else if($page->session->getSession($name."_DATASET")=="iDataSetS"){
			$dataSet = $idss;
		}else if($page->session->getSession($name."_DATASET")=="iDataSetB"){
			$dataSet = $idsb;
		}else{
			$dataSet = $idsa;
		}
		
		$table = $page->session->getSession($name."_TABLE");
		$obj = $page->session->getSession($name."_OBJ_".$name);
		
		$fieldIdName = false;
		
		if($dataSet->sqlServer===false){
			# CARREGA AS COLUNAS
			$sel = new iSelect($dataSet,$table);
			$sel->listColumn();
			
			if($sel->exe()===false){
				$page->e("Houve uma falha!".administrador.$dataSet->getError(1).$sel->getSql());
				$javaExe->showMsg(true,$name,"Houve uma falha!".administrador.$dataSet->getError(1),"close");
			}else{
				$fieldIdName = "id".str_replace(" ", "",ucwords(str_replace("_", " ",$table)));
				$fieldId = false;
				$fieldStatus = false;
				$columnsB = array();
				while ($row = $sel->read()){
					$columnsB[count($columnsB)] = $row['Field'];
					if(strpos($row['Field'],"status")!==false){
						$fieldStatus = $row['Field'];
						if(!isset($obj['mask'][$row['Field']])){
							$obj['mask'][$row['Field']] = array("0" => "DESATIVADO","1" => "ATIVO","2" => "LIBERADO","3" => "ESTORNADO","4" => "FINALIZADO","5" => "CONCLUÍD0");
						}
						
						$standardFormatConditionStatus = true;
						if(isset($obj['formatCondition'])){
							if(count($obj['formatCondition'])>0){
								foreach ($obj['formatCondition'] as $keyD => $valueD){
									if($valueD['where']==$row['Field']){
										$standardFormatConditionStatus = false;
									}
								}
							}
						}
						
						if($standardFormatConditionStatus===true){
							$id = count(@$obj['formatCondition']);
							$obj['formatCondition'][$row['Field'].$id]['where'] = $row['Field'];
							$obj['formatCondition'][$row['Field'].$id]['value'] = 0;
							$obj['formatCondition'][$row['Field'].$id]['sign'] = false;
							$obj['formatCondition'][$row['Field'].$id]['affectLine'] = false;
							$obj['formatCondition'][$row['Field'].$id]['operator'] = "=";
							
							$id = count(@$obj['formatCondition']);
							$obj['formatCondition'][$row['Field'].$id]['where'] = $row['Field'];
							$obj['formatCondition'][$row['Field'].$id]['value'] = 1;
							$obj['formatCondition'][$row['Field'].$id]['sign'] = true;
							$obj['formatCondition'][$row['Field'].$id]['affectLine'] = false;
							$obj['formatCondition'][$row['Field'].$id]['operator'] = "=";
						}
					}
					if(!isset($obj['hidden'][$row['Field']])){
						if(strpos($row['Field'],"dataModificacao")!==false || strpos($row['Field'],"historico")!==false || strpos($row['Field'],"Remoto")!==false || strpos($row['Field'],"filial")!==false || strpos($row['Field'],"usuario")!==false){
							$obj['hidden'][$row['Field']] = true;
						}else{
							$obj['hidden'][$row['Field']] = false;
						}
					}
					if(!isset($obj['date'][$row['Field']])){
						if(strpos($row['Field'],"data")!==false){
							$obj['date'][$row['Field']]['enable'] = true;
							$obj['date'][$row['Field']]['by'] = "timestamp";
							$obj['date'][$row['Field']]['mode'] = "abb4";
						}
					}
					if(!isset($obj['align'][$row['Field']])){
						$obj['align'][$row['Field']] = left;
						if(strpos($row['Field'],"data")!==false || $row['Field']==$fieldIdName || strpos($row['Field'],"status")!==false){
							$obj['align'][$row['Field']] = center;
						}else if(strpos($row['Type'], "enum")!==false || strpos($row['Type'], "int")!==false || strpos($row['Type'], "bigint")!==false){
							$obj['align'][$row['Field']] = center;
						}else if(strpos($row['Type'], "decimal")!==false){
							$obj['align'][$row['Field']] = right;
							if(!isset($obj['number'][$row['Field']])){
								$obj['number'][$row['Field']] = true;
							}
						}
					}
					
					# FAKE
					if(strpos($row['Field'], "dataCriacao")!==false && !isset($obj['fake'][$row['Field']])){
						$obj['fake'][$row['Field']] = "Data";
					}
					if($row['Field']==$fieldIdName && !isset($obj['fake'][$row['Field']])){
						$obj['fake'][$row['Field']] = "ID";
					}
					if(strpos($row['Field'], "status")!==false && !isset($obj['fake'][$row['Field']])){
						$obj['fake'][$row['Field']] = "Status";
					}
				}
			}
		}
			
		$sel = new iSelect($dataSet,$table);
		
		if(!$page->session->getSession($name."_ALL")){
			if(count(@$obj['limit'])){
				$sel->limit($obj['limit']['limit']);
			}else{
				$sel->limit(10);
			}
		}else{
			$sel->limit(100);
		}
		
		if($dataSet->sqlServer===false){
			$sel->order($fieldIdName,"DESC");
			if(!$page->session->getSession($name."_ALL")){
				$sel->where($fieldStatus, ">=", "1");
			}else{
				$sel->where($fieldStatus, ">=", "0");
			}
		}
		
		# COLUMNS
		$columnsActionOnClick = "";
		if(count(@$obj['columns'])){
			$sel->columns($obj['columns']);
			
			$columns = explode(",",$obj['columns']);
			
			foreach ($columns as $keyC => $valueC){
				if(!isset($obj['align'][$valueC])){
					$obj['align'][$valueC] = left;
				}
				
				if($page->session->getSession($name."SEARCH")){
					$sel->like($valueC, $page->session->getSession($name."SEARCH"));
				}
				
				if(strlen($columnsActionOnClick)>0){
					$columnsActionOnClick .= ",";
				}
				$columnsActionOnClick .= $valueC;
			}
		}else{
			foreach ($columnsB as $keyC => $valueC){
				if($page->session->getSession($name."SEARCH")){
					$sel->like($valueC, $page->session->getSession($name."SEARCH"));
				}
				
				if(strlen($columnsActionOnClick)>0){
					$columnsActionOnClick .= ",";
				}
				$columnsActionOnClick .= $valueC;
			}
		}
		
		# WHERE
		if(count(@$obj['where'])){
			if(!$page->session->getSession("SEARCH")){
				$sel->where($obj['where']['where'],$obj['where']['operator'],$obj['where']['value']);
			}else{
				$sel->setAnd($obj['where']['where'],$obj['where']['operator'],$obj['where']['value']);
			}
		}
		
		# JOIN
		if(count(@$obj['join'])){
			foreach ($obj['join'] as $keyB => $valueB){
				$sel->join($valueB['table'], $valueB['where'], $valueB['operator'], $valueB['value']);
			}
		}
		
		# JOIN COLUMNS
		if(count(@$obj['joinColumns'])){
			foreach ($obj['joinColumns'] as $keyB => $valueB){
				$sel->columnsJoin($valueB['columns'], $valueB['table'], $valueB['as']);
			}
		}
		
		# SET AND
		if(count(@$obj['and'])){
			foreach ($obj['and'] as $keyB => $valueB){
				$sel->setAnd($valueB['column'], $valueB['operator'], $valueB['value']);
			}
		}
		
		# SET EXPRESSION POST
		if(count(@$obj['expressionPost'])){
			foreach ($obj['expressionPost'] as $keyB => $valueB){
				$sel->setAnd("", $valueB);
			}
		}
		
		# SET AND ID KEY
		if(count(@$obj['idKey'])){
			foreach ($obj['idKey'] as $keyB => $valueB){
				if($page->session->getSession($valueB['parameter'],$valueB['pagename'])){
					$sel->setAnd($valueB['column'], $valueB['operator'], $page->session->getSession($valueB['parameter'],$valueB['pagename']));
				}
			}
		}
		
		if(!$page->session->getSession($name."_ALL")){
			# ORDER
			if(count(@$obj['order'])){
				$sel->order($obj['order']['order'],$obj['order']['type'],$obj['order']['table']);
			}
		}
		
		/*$sel->exe();
		$page->e($sel->getSql());*/
		
		$t = new iDataTableAdapter($page, "t".$name,$dataSet);
		$t->setPrimaryKey($fieldIdName);
		$t->setSessionNameArrayKeys("ARRAY_KEYS_".$name);
		$t->setTitleAlign(left);
		if(@$obj['width']!==false){
			$t->width($obj['width']);
		}
		#$t->showSql = true;
		$t->setAlignSubTitle(false);
		$t->setSelect($sel);
		
		if(!$page->session->getSession($name."_ALL")){
			if(count(@$obj['limit'])){
				$t->setLimit($obj['limit']['limit']);
			}else{
				$t->setLimit(10);
			}
		}else{
			$t->setLimit(100);
		}
		
		# TITULO
		if(@$obj['title']===false){
			$t->setWithOutTitle();
		}else{
			$t->setTitle(@$obj['title']);
		}
		
		# COLUMNS FAKE
		if(count(@$obj['fake'])){
			$t->setColumnsFakeArray($obj['fake']);
		}
		
		# COLUMNS HIDDEN
		if(count(@$obj['hidden'])){
			foreach (@$obj['hidden'] as $key => $value){
				if($value===true){
					$t->setColumnHidden($key,$value);
				}
			}
		}
		
		# COLUMNS DATE
		if(count(@$obj['date'])){
			foreach (@$obj['date'] as $key => $value){
				if($value['enable']===true){
					$t->setColumnsAsFormatDate($key,$value['by'],$value['mode']);
				}
			}
		}
		
		# COLUMNS ALIGN
		if(count(@$obj['align'])){
			$t->setColumnsAlignArray($obj['align']);
		}
		
		# COLUMNS WIDTH
		if(count(@$obj['widths'])){
			$t->setColumnsWidthArray($obj['widths']);
		}
		
		# COLUMNS MASK
		if(count(@$obj['mask'])){
			foreach ($obj['mask'] as $key => $value){
				$t->setColumnsMask($key, $value);
			}
		}
		
		# FORMAT CONDITION
		if(count(@$obj['formatCondition'])){
			$cont = 0;
			foreach ($obj['formatCondition'] as $key => $value){
				$backGround = COLOR_BLUE;
				$color = COLOR_WHITE;
				if($value['sign']===true){
					$backGround = COLOR_GREEN;
					$color = COLOR_WHITE;
				}else if($value['sign']===false){
					$backGround = COLOR_RED;
					$color = COLOR_WHITE;
				}else if($value['sign']=="2"){
					$backGround = COLOR_YELLOW;
					$color = COLOR_BLACK;
				}else if($value['sign']=="3"){
					$backGround = COLOR_ORANGE;
					$color = COLOR_BLACK;
				}else if($value['sign']=="4"){
					$backGround = COLOR_DARK_GREEN;
					$color = COLOR_WHITE;
				}else if($value['sign']=="5"){
					$backGround = COLOR_DARK_SILVER;
					$color = COLOR_ULTRA_LIGHT_SILVER;
				}
				$t->setFormatCondition($key, $value['where'], $value['value'],$backGround,$color,$value['affectLine'],$value['operator']);
				$cont++;
			}
		}
		
		# ACTION ON CLICK
		if(count(@$obj['actionOnClick'])){
			foreach ($obj['actionOnClick'] as $key => $value){
				$t->setActionOnClick($value['path']."../RCD_7/iFormScriptInsertUpdate.php", $value['parameter'], $value['column'], $value['columns'], $value['pagename'],false,"objCorelyt".$value['form']."0");
			}
		}else{
			if(strlen($columnsActionOnClick)==0){
				$columnsActionOnClick = $fieldIdName;
			}
			
			$t->setActionOnClick($obj['path']."../RCD_7/iFormScriptInsertUpdate.php", $obj['id'], $fieldIdName, $columnsActionOnClick, $obj['pagename']."&PAGENAME=".$obj['pagename']."&PARAMETER=".$obj['id']."&PANEL=".$obj['panelForm']."&TYPE=FILL&DATASET=".$obj['dataSetName']."&TABLE=".$obj['table']."&FORM=".$obj['form'],false,"objCorelyt".$obj['form']."0");
		}
		
		# COLUMNS NUMBER
		if(count(@$obj['number'])){
			foreach ($obj['number'] as $key => $value){
				$t->setColumnsAsNumber($key);
			}
		}
		
		# COLUMNS CPF/CNPJ
		if(count(@$obj['cpfCnpj'])){
			foreach ($obj['cpfCnpj'] as $key => $value){
				$t->setColumnsAsCpfCnpj($key);
			}
		}
		
		# LINK
		if(1){
			$t->setColumnLink("path", "@path",false,"font-size:16px;color:".COLOR_DARK_BLUE.";text-decoration: underline","path","","!=","ABRIR");
		}
		
		$page->End("td".$name);
	}else{
		$page->e("Não Passou");
	}
}