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
	$erro = false;
	$dadoRecebido = false;
	if(count(@$_POST)>0){
		$dadoRecebido = true;
		$iForm = false;
		foreach ($_POST as $key => $value){
			if(strpos($key,"iFormName")){
				$iForm = $_POST[$key];
				break;
			}
		}
		
		if($iForm!==false){
			$PAGENAME = $page->session->getSession($iForm."_PAGENAME");
			if($page->session->getSession($iForm."_DATASET")=="iDataSet"){
				$dataSet = $idsa;
			}else if($page->session->getSession($iForm."_DATASET")=="iDataSetS"){
				$dataSet = $idss;
			}else{
				$dataSet = $idsb;
			}
			$table = $page->session->getSession($iForm."_TABLE");
			$uppercase = $page->session->getSession($iForm."_UPPERCASE");
			$autoBuildColumns = $page->session->getSession($iForm."_AUTOBUILDCOLUMNS");
			
			#print_r($autoBuildColumns);
			
			$msgSuccess = $_POST[$iForm."MsgSuccess"];
			$msgFail = $_POST[$iForm."MsgFail"];
			
			$type = $_POST[$iForm."ButtonPress"];
			unset($_POST[$iForm."ButtonPress"]);
			
			if($type=="INS"){
				$ins = new iInsert($dataSet, $table);
				$ins->insert("dataCriacao", time());
				$ins->insert("dataModificacao", time());
				$ins->insert("filial", $page->session->getLoginFilial());
				$ins->insert("usuario", $page->session->getLoginId());
			}else if($type=="UPD"){
				$upd = new iUpdate($dataSet, $table);
				$upd->set("dataModificacao", time());
			}
			
			if($page->session->getSession($iForm."_INCLUDE_BEFORE")){
				$page->e("INCLUDE BEFORE<BR>");
				@include $page->session->getSession($iForm."_INCLUDE_BEFORE");
			}
			
			$fieldIdName = "id".str_replace(" ", "",ucwords(str_replace("_", " ",$table)));
			
			if($erro===false){
				if(count($autoBuildColumns)>0){					
					if($type=="INS"){	
						$executar = true;
						
						$alteracoes = "";
						$fieldId = false;
						$fieldStatus = false;
						$fieldStatusName = false;
						$autoBuildColumnsIdStatus = false;
						foreach ($autoBuildColumns as $key => $value){
							if($value['typeObj']=="textBox" || $value['typeObj']=="textBoxMultiLine" || $value['typeObj']=="textBoxNumber"){
								$field = "tb".ucwords($value['Field']);
							}else if($value['typeObj']=="comboBox"){
								$field = "cb".ucwords($value['Field']);
							}else if($value['typeObj']=="file"){
								$field = "fl".ucwords($value['Field']);
							}
							
							if($value['Field']==$fieldIdName){
								$fieldId = $field;
							}
							
							if(strpos($value['Field'],"status")!==false){
								$fieldStatus = $field;
								$fieldStatusName = $value['Field'];
								$autoBuildColumnsIdStatus = $key;
							}
							
							if($value['create']===true && $value['typeObj']!="file" && $value['Field']!=$fieldIdName && strpos($value['Field'],"status")===false){
								$javaExe->setBackgroundColor($field, COLOR_WHITE, true);
								if(isset($_POST[$field])){					
									if(strlen($_POST[$field])==0){
										if($value['require']===true){
											$executar = false;
											$page->e("REQUIRE TRUE - ".$field."<BR>");
											$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
											if(isset($value['param2']['msgFailNull'])){
												$javaExe->showMsg(true,$iForm,$value['param2']['msgFailNull'],"close","close","n",COLOR_ULTRA_DARK_RED);
											}else{
												$javaExe->showMsg(true,$iForm,"Os campos destacados em vermelho são obrigatório!","close","close","n",COLOR_ULTRA_DARK_RED);
											}
										}
									}
									
									# LIMPA CARACTERES NÃO NUMÉRICOS
									if(strpos($value['Type'],"bigint")!==false || strpos($value['Type'],"int")!==false){
										$valueSeg = $_POST[$field];
										$valueSegFinal = "";
										for($i=0;$i<strlen($valueSeg);$i++){
											$valueParcial = substr($valueSeg, $i, 1);
											if(is_numeric($valueParcial)){
												$valueSegFinal .= $valueParcial;
											}
										}
										$_POST[$field] = $valueSegFinal;
									}
									
									# VERIFICA SE CPF / CNPJ SÃO VÁLIDOS
									$verifyCpfCnpj = true;
									if(isset($value['cpfCnpj'])){
										if($value['cpfCnpj']===false){
											$verifyCpfCnpj = false;
										}
									}
									if($verifyCpfCnpj===true){
										if(strpos($page->stringToUpper($value['Field']),"CPF") || strpos($page->stringToUpper($value['Field']),"CNPJ")){
											if($page->verifyValue($_POST[$field], "CPF_CNPJ")===false){
												$executar = false;
												$page->e("VERIFY CPF/CNPJ - ".$field."<BR>");
												$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
												$javaExe->showMsg(true,$iForm,"CPF / CNPJ invalído!","close","close","n",COLOR_ULTRA_DARK_RED);
											}
										}
									}
									
									if(strlen($alteracoes)>0){
										$alteracoes .= ", ";
									}
									if($value['Field']!="dataCriacao" && $value['Field']!="dataModificacao"){
										if($uppercase===true){
											$ins->insert($value['Field'], $page->stringToUpper($_POST[$field]));
											if(isset($value['label'])){
												$alteracoes .= $value['label']."=".$page->stringToUpper($_POST[$field]);
											}else{
												$alteracoes .= $value['Field']."=".$page->stringToUpper($_POST[$field]);
											}
										}else{
											$ins->insert($value['Field'], $_POST[$field]);
											if(isset($value['label'])){
												$alteracoes .= $value['label']."=".$_POST[$field];
											}else{
												$alteracoes .= $value['Field']."=".$_POST[$field];
											}
										}
									}
								}
							}
							
							# PROCESSO FILE
							if($value['create']===true && $value['typeObj']=="file"){
								if((@$_FILES[$field]['name']=="Nenhum arquivo selecionado" || @$_FILES[$field]['name']=="")){
									if($value['require']===true){
										$executar = false;
										$page->e("REQUIRE FILE TRUE - ".$field."<BR>");
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										if(isset($value['param2']['msgFailNull'])){
											$javaExe->showMsg(true,$iForm,$value['param2']['msgFailNull'],"close","close","n",COLOR_ULTRA_DARK_RED);
										}else{
											$javaExe->showMsg(true,$iForm,"Falha arquivo nulo!","close","close","n",COLOR_ULTRA_DARK_RED);
										}
									}
								}else if(!isset($value['param2']['path'])){
									$executar = false;
									$page->e("PATH TO FILE - ".$field."<BR>");
									$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
									$javaExe->showMsg(true,$iForm,"Definir path!","close","close","n",COLOR_ULTRA_DARK_RED);
									break;
								}else{
									$PATHB = str_replace("ERP/", "", $PATH);
									$pasta = $PATHB.str_replace("../", "", $value['param2']['path']);
									$nome_temporario = $_FILES[$field]['tmp_name'];
									$nome_real = str_replace(" ", "_", $page->stringToUpper($_FILES[$field]['name']));
									$parts = pathinfo($nome_real);
									$ext = $parts['extension'];
									$ext = $page->stringToUpper($ext);
									$nome_final = time()."_".$page->session->getLoginFilial()."_".$page->session->getLoginId()."_".rand(100000,999999)."_".$nome_real;
									$dest = $pasta."/".$nome_final;
									$destFinal = $value['param2']['path']."/".$nome_final;
									
									$extPermitB = false;
									if(isset($value['param2']['ext'])){
										$extPermit = explode(",", $value['param2']['ext']);
										foreach ($extPermit as $keyC => $valueC){
											$extPermitB[$valueC] = true;
										}
									}
											
									if(strlen($dest)>1000){
										$executar = false;
										$page->e("NAME FILE TOO LONG - ".$field."<BR>");
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										$javaExe->showMsg(true,$iForm,"Nome do arquivo é muito grande!","close","close","n",COLOR_ULTRA_DARK_RED);
										break;
									}else if($extPermitB!==false && !isset($extPermitB[$ext])){
										$executar = false;
										$page->e("EXTENSION FALSE - ".$field."<BR>");
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										if(isset($value['param2']['msgFailExt'])){
											$javaExe->showMsg(true,$iForm,$value['param2']['msgFailExt'],"close","close","n",COLOR_ULTRA_DARK_RED);
										}else{
											$javaExe->showMsg(true,$iForm,"Falha de extensão!","close","close","n",COLOR_ULTRA_DARK_RED);
										}
										break;
									}else if(!copy($nome_temporario,$dest)){
										$errors = error_get_last();
										$executar = false;
										$page->e("COPY FILE FAIL - ".$field."<BR>");
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										$javaExe->showMsg(true,$iForm,"Houve uma falha ao tentar copiar o arquivo!".$errors['type']." - ".$errors['message'],"close","close","n",COLOR_ULTRA_DARK_RED);
										break;
									}else{
										$ins->insert($value['Field'], $destFinal);
										if(isset($value['label'])){
											$alteracoes .= $value['label']."=".$_POST[$field];
										}else{
											$alteracoes .= $value['Field']."=".$_POST[$field];
										}
									}
								}
							}
							# FIM - PROCESSO FILE
							
							if(@$value['unique']===true){
								$sel = new iSelect($dataSet,$table);
								$sel->where($value['Field'], "=", $_POST[$field],true);
								if(isset($value['param2']) && isset($value['value2'])){
									if(strlen($value['param2'])>0 && strlen($value['value2'])>0){
										$sel->setAnd($value['param2'], "=",$value['value2'],true);
									}
								}
								
								if($sel->exe()===false){
									$executar = false;
									$page->e("FALHA AO VERIFICAR CADASTRO - ".$field."<br><br>".$dataSet->getError(1)."<BR>");
									$javaExe->showMsg(true,$iForm,"Houve uma falha ao verificar cadastro existente!".administrador.$dataSet->getError(1),"close","close","n",COLOR_ULTRA_DARK_RED);
									break;	
								}else if($sel->getNumRows()>0){
									$executar = false;
									$page->e("UNIQUE TRUE - ".$field."<BR>");
									$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
									$javaExe->showMsg(true,$iForm,"Já existe um cadastro com esses dados!","close","close","n",COLOR_ULTRA_DARK_RED);
									break;
								}
							}
							
							if($executar===true && $value['create']===true && strpos($value['Field'],"id")===false && strpos($value['Field'],"status")===false){
								$javaExe->setBackgroundColor($field, COLOR_WHITE, true);
							}
						}
						
						if($executar===true){
							if(strlen($_POST['hdComment'.$iForm])==0){
								$ins->insert("historico", $page->getHistText()."<ul><li>REGISTROS: ".$page->stringToUpper($alteracoes)."</li></ul>");
							}else{
								$ins->insert("historico", $page->getHistText()."<ul><li>REGISTROS: ".$page->stringToUpper($alteracoes)."</li></ul>".$page->getComment($_POST['hdComment'.$iForm]));
							}
							if($ins->exe()===false){
								if(strlen($msgFail)>0){
									$page->e("FALHOU: ".$dataSet->getError(1));
									$javaExe->showMsg(true,$iForm,$msgFail.administrador.$dataSet->getError(1),"close","close","n",COLOR_ULTRA_DARK_RED);
								}else{
									$javaExe->showMsg(true,$iForm,"Houve uma falha no INS!".administrador.$dataSet->getError(1),"close","close","n",COLOR_ULTRA_DARK_RED);
								}
							}else{
								#$page->e($ins->getSql());
								
								$page->session->setSession("TYPE","FILL");
								$page->session->setSession("PAGENAME",$page->session->getSession($iForm."_PAGENAME"));
								$page->session->setSession("PARAMETER",$page->session->getSession($iForm."_ID"));
								$page->session->setSession("FORM",$iForm);
								$page->session->setSession($page->session->getSession($iForm."_ID"),$ins->getNewId(),$page->session->getSession($iForm."_PAGENAME"));
								
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_INS"),true);
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_DES"),true);
								$javaExe->visible($iForm."_group_".$page->session->getSession($iForm."_GROUP_UPD"),true);
								
								if($fieldId!==false){
									$javaExe->value($fieldId, $ins->getNewId(),true);
								}
								
								$iFormA = $iForm;
								
								if($page->session->getSession($iForm."_INCLUDE_AFTER")){
									$page->e("INCLUDE AFTER INS (".@$type.")<BR>");
									@include_once $page->session->getSession($iForm."_INCLUDE_AFTER");
								}
								
								if($fieldStatus!==false){
									if(isset($autoBuildColumns[$autoBuildColumnsIdStatus]["mask"])){
										$javaExe->value($fieldStatus, $autoBuildColumns[$autoBuildColumnsIdStatus]["mask"][1],true);
									}
									$javaExe->setBackgroundColor($fieldStatus, COLOR_GREEN, true);
								}
								if(strlen($msgSuccess)>0){
									$javaExe->showMsg(true,$iFormA,$msgSuccess,"close","close","n",COLOR_DARK_GREEN);
								}
							}
						}else{
							$erro = true;
							$page->e("NÃO EXECUTADO<BR>");
						}
					}else if($type=="UPD"){		
						$executar = true;
						
						$alteracoes = "";
						$fieldId = false;
						$fieldIdValue = false;
						$fieldStatus = false;
						$fieldStatusName = false;
						$autoBuildColumnsIdStatus = false;
						foreach ($autoBuildColumns as $key => $value){
							if($value['typeObj']=="textBox" || $value['typeObj']=="textBoxMultiLine" || $value['typeObj']=="textBoxNumber"){
								$field = "tb".ucwords($value['Field']);
							}else if($value['typeObj']=="comboBox"){
								$field = "cb".ucwords($value['Field']);
							}else if($value['typeObj']=="file"){
								$field = "fl".ucwords($value['Field']);
							}
							
							if($value['Field']==$fieldIdName){
								$fieldId = $field;
								$fieldIdName = $value['Field'];
								$fieldIdValue = $_POST[$field];
								
								$upd->where($value['Field'], "=", $_POST[$field]);
							}
							
							if(strpos($value['Field'],"status")!==false){
								$fieldStatus = $field;
								$fieldStatusName = $value['Field'];
								$autoBuildColumnsIdStatus = $key;
							}
							
							if($value['create']===true && $value['typeObj']!="file" && $value['Field']!=$fieldIdName && $value['Field']!=$fieldStatusName){
								if(isset($_POST[$field])){
									if(strlen($_POST[$field])>0){
										# LIMPA CARACTERES NÃO NUMÉRICOS
										if(strpos($value['Type'],"bigint")!==false || strpos($value['Type'],"int")!==false){
											$valueSeg = $_POST[$field];
											$valueSegFinal = "";
											for($i=0;$i<strlen($valueSeg);$i++){
												$valueParcial = substr($valueSeg, $i, 1);
												if(is_numeric($valueParcial)){
													$valueSegFinal .= $valueParcial;
												}
											}
											$_POST[$field] = $valueSegFinal;
										}
										
										# VERIFICA SE CPF / CNPJ SÃO VÁLIDOS
										$verifyCpfCnpj = true;
										if(isset($value['cpfCnpj'])){
											if($value['cpfCnpj']===false){
												$verifyCpfCnpj = false;
											}
										}
										if($verifyCpfCnpj===true){
											if(strpos($page->stringToUpper($value['Field']),"CPF") || strpos($page->stringToUpper($value['Field']),"CNPJ")){
												if($page->verifyValue($_POST[$field], "CPF_CNPJ")===false){
													$executar = false;
													$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
													$javaExe->showMsg(true,$iForm,"CPF / CNPJ invalído!","close","close","n",COLOR_ULTRA_DARK_RED);
												}
											}
										}
										
										if(strlen($alteracoes)>0){
											$alteracoes .= ", ";
										}
										if($value['Field']!="dataModificacao"){
											if($uppercase===true){
												$upd->set($value['Field'], $page->stringToUpper($_POST[$field]));
												if(isset($value['label'])){
													$alteracoes .= $value['label']."=".$page->stringToUpper($_POST[$field]);
												}else{
													$alteracoes .= $value['Field']."=".$page->stringToUpper($_POST[$field]);
												}
											}else{
												$upd->set($value['Field'], $_POST[$field]);
												if(isset($value['label'])){
													$alteracoes .= $value['label']."=".$_POST[$field];
												}else{
													$alteracoes .= $value['Field']."=".$_POST[$field];
												}
											}
										}
									}else{
										if($value['require']===true){
											$executar = false;
											$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
											if(isset($value['param2']['msgFailNull'])){
												$javaExe->showMsg(true,$iForm,$value['param2']['msgFailNull'],"close","close","n",COLOR_ULTRA_DARK_RED);
											}else{
												$javaExe->showMsg(true,$iForm,"Os campos destacados em vermelho são obrigatório!","close","close","n",COLOR_ULTRA_DARK_RED);
											}
										}
									}
								}
							}
							
							# PROCESSO FILE
							if($value['create']===true && $value['typeObj']=="file"){
								if((@$_FILES[$field]['name']=="Nenhum arquivo selecionado" || @$_FILES[$field]['name']=="")){
									if($value['require']===true){
										$executar = false;
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										if(isset($value['param2']['msgFailNull'])){
											$javaExe->showMsg(true,$iForm,$value['param2']['msgFailNull'],"close","close","n",COLOR_ULTRA_DARK_RED);
										}else{
											$javaExe->showMsg(true,$iForm,"Falha arquivo nulo!","close","close","n",COLOR_ULTRA_DARK_RED);
										}
										break;
									}
								}else if(!isset($value['param2']['path'])){
									$executar = false;
									$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
									$javaExe->showMsg(true,$iForm,"Definir path!","close","close","n",COLOR_ULTRA_DARK_RED);
									break;
								}else{
									$PATHB = str_replace("ERP/", "", $PATH);
									$pasta = $PATHB.str_replace("../", "", $value['param2']['path']);
									$nome_temporario = $_FILES[$field]['tmp_name'];
									$nome_real = str_replace(" ", "_", $page->stringToUpper($_FILES[$field]['name']));
									$parts = pathinfo($nome_real);
									$ext = $parts['extension'];
									$ext = $page->stringToUpper($ext);
									$nome_final = time()."_".$page->session->getLoginFilial()."_".$page->session->getLoginId()."_".rand(100000,999999)."_".$nome_real;
									$dest = $pasta."/".$nome_final;
									$destFinal = $value['param2']['path']."/".$nome_final;
										
									$extPermitB = false;
									if(isset($value['param2']['ext'])){
										$extPermit = explode(",", $value['param2']['ext']);
										foreach ($extPermit as $keyC => $valueC){
											$extPermitB[$valueC] = true;
										}
									}
										
									if(strlen($dest)>1000){
										$executar = false;
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										$javaExe->showMsg(true,$iForm,"Nome do arquivo é muito grande!","close","close","n",COLOR_ULTRA_DARK_RED);
										break;
									}else if($extPermitB!==false && !isset($extPermitB[$ext])){
										$executar = false;
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										if(isset($value['param2']['msgFailExt'])){
											$javaExe->showMsg(true,$iForm,$value['param2']['msgFailExt'],"close","close","n",COLOR_ULTRA_DARK_RED);
										}else{
											$javaExe->showMsg(true,$iForm,"Falha de extensão!","close","close","n",COLOR_ULTRA_DARK_RED);
										}
										break;
									}else if(!copy($nome_temporario,$dest)){
										$errors = error_get_last();
										$executar = false;
										$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
										$javaExe->showMsg(true,$iForm,"Houve uma falha ao tentar copiar o arquivo!".$errors['type']." - ".$errors['message'],"close","close","n",COLOR_ULTRA_DARK_RED);
										break;
									}else{
										$upd->set($value['Field'], $destFinal);
										
										if(strlen($alteracoes)>0){
											$alteracoes .= ", ";
										}
										if(isset($value['label'])){
											$alteracoes .= $value['label']."=".$_POST[$field];
										}else{
											$alteracoes .= $value['Field']."=".$_POST[$field];
										}
									}
								}
							}
							# FIM - PROCESSO FILE
							
							if(@$value['unique']===true){
								$sel = new iSelect($dataSet,$table);
								$sel->where($value['Field'], "=", $_POST[$field],true);
								if(isset($value['param2']) && isset($value['value2'])){
									if(strlen($value['param2'])>0 && strlen($value['value2'])>0){
										$sel->setAnd(@$value['param2'], "=",@$value['value2'],true);
									}
								}
								$sel->setAnd($fieldIdName, "!=", $fieldIdValue);
								
								if($sel->exe()===false){
									$executar = false;
									$javaExe->showMsg(true,$iForm,"Houve uma falha ao verificar cadastro existente!".administrador.$dataSet->getError(1),"close","close","n",COLOR_ULTRA_DARK_RED);
									break;	
								}else if($sel->getNumRows()>0){
									$executar = false;
									$javaExe->setBackgroundColor($field, COLOR_LIGHT_RED, true);
									$javaExe->showMsg(true,$iForm,"Já existe um cadastro com esses dados!","close","close","n",COLOR_ULTRA_DARK_RED);
									break;
								}
							}
							
							if($executar===true && $value['create']===true && strpos($value['Field'],"id")===false && strpos($value['Field'],"status")===false){
								$javaExe->setBackgroundColor($field, COLOR_WHITE, true);
							}
						}
						
						if($executar===true){
							if(strlen($_POST['hdComment'.$iForm])==0){
								$upd->setHist("historico", $page->getHistText("M")."<ul><li>ALTERAÇÕES: ".$page->stringToUpper($alteracoes)."</li></ul>");
							}else{
								$upd->setHist("historico", $page->getHistText("M")."<ul><li>ALTERAÇÕES: ".$page->stringToUpper($alteracoes)."</li></ul>".$page->getComment($_POST['hdComment'.$iForm]));
							}
							if($upd->exe()===false){
								if(strlen($msgFail)>0){
									$javaExe->showMsg(true,$iForm,$msgFail.administrador.$dataSet->getError(1),"close","close","n",COLOR_ULTRA_DARK_RED);
								}
							}else{
								#$page->e($upd->getSql());
								
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_INS"),true);
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_DES"),true);
								$javaExe->visible($iForm."_group_".$page->session->getSession($iForm."_GROUP_UPD"),true);
								
								$page->session->setSession("TYPE","FILL");
								$page->session->setSession("PAGENAME",$page->session->getSession($iForm."_PAGENAME"));
								$page->session->setSession("PARAMETER",$page->session->getSession($iForm."_ID"));
								$page->session->setSession("FORM",$iForm);
								
								$iFormA = $iForm;
								
								if($page->session->getSession($iForm."_INCLUDE_AFTER")){
									$page->e("INCLUDE AFTER UPD (".@$type.")<BR>");
									@include_once $page->session->getSession($iForm."_INCLUDE_AFTER");
								}
								
								if(strlen($msgSuccess)>0){
									$javaExe->showMsg(true,$iFormA,$msgSuccess,"close","close","n",COLOR_DARK_GREEN);
								}
							}
						}else{
							$erro = true;
							$page->e("NÃO EXECUTADO");
						}
					}else if($type=="DES"){
						$upd = new iUpdate($dataSet, $table);
						$upd->set("dataModificacao", time());
						if(strlen($_POST['hdComment'.$iForm])==0){
							$upd->setHist("historico", $page->getHistText("D"));
						}else{
							$upd->setHist("historico", $page->getHistText("D").$page->getComment($_POST['hdComment'.$iForm]));
						}
					
						$executarA = false;
						$executarB = false;
						
						foreach ($autoBuildColumns as $key => $value){
							if($value['typeObj']=="textBox"){
								$field = "tb".ucwords($value['Field']);
							}else if($value['typeObj']=="comboBox"){
								$field = "cb".ucwords($value['Field']);
							}
							if(strpos($value['Field'],"id")!==false && strpos($value['Field'],"Remoto")===false){
								$upd->where($value['Field'], "=", $_POST[$field]);
								$executarA = true;
							}
							if(strpos($value['Field'],"status")!==false){
								$fieldStatus = $field;
								$fieldStatusName = $value['Field'];
								$autoBuildColumnsIdStatus = $key;
								$upd->set($value['Field'], "0");
								$executarB = true;
							}
							if($executarA===true && $executarB===true){
								break;
							}
						}
					
						if($executarA===true && $executarB===true){
							if($upd->exe()===false){
								if(strlen($msgFail)>0){
									$javaExe->showMsg(true,$iForm,$msgFail.administrador.$dataSet->getError(1),"close","close","n",COLOR_ULTRA_DARK_RED);
								}
							}else{
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_INS"),true);
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_UPD"),true);
								$javaExe->visible($iForm."_group_".$page->session->getSession($iForm."_GROUP_DES"),true);
								
								$page->session->setSession("TYPE","FILL");
								$page->session->setSession("PAGENAME",$page->session->getSession($iForm."_PAGENAME"));
								$page->session->setSession("PARAMETER",$page->session->getSession($iForm."_ID"));
								$page->session->setSession("FORM",$iForm);
								
								$iFormA = $iForm;
								
								if($page->session->getSession($iForm."_INCLUDE_AFTER")){
									$page->e("INCLUDE AFTER DES (".@$type.")<BR>");
									@include_once $page->session->getSession($iForm."_INCLUDE_AFTER");
								}
								
								if($fieldStatus!==false){
									$javaExe->value($fieldStatus, $autoBuildColumns[$autoBuildColumnsIdStatus]["mask"][0],true);
									$javaExe->setBackgroundColor($fieldStatus, COLOR_RED, true);
								}
								if(strlen($msgSuccess)>0){
									$javaExe->showMsg(true,$iFormA,$msgSuccess,"close","close","n",COLOR_DARK_GREEN);
								}
							}
						}else{
							$page->e("Não executado");
						}
					}else if($type=="ACT"){
						$upd = new iUpdate($dataSet, $table);
						$upd->set("dataModificacao", time());
						if(strlen($_POST['hdComment'.$iForm])==0){
							$upd->setHist("historico", $page->getHistText("A"));
						}else{
							$upd->setHist("historico", $page->getHistText("A").$page->getComment($_POST['hdComment'.$iForm]));
						}
							
						$executarA = false;
						$executarB = false;
					
						foreach ($autoBuildColumns as $key => $value){
							if($value['typeObj']=="textBox"){
								$field = "tb".ucwords($value['Field']);
							}else if($value['typeObj']=="comboBox"){
								$field = "cb".ucwords($value['Field']);
							}
							if(strpos($value['Field'],"id")!==false && strpos($value['Field'],"Remoto")===false){
								$upd->where($value['Field'], "=", $_POST[$field]);
								$executarA = true;
							}
							if(strpos($value['Field'],"status")!==false){
								$fieldStatus = $field;
								$fieldStatusName = $value['Field'];
								$autoBuildColumnsIdStatus = $key;
								$upd->set($value['Field'], "1");
								$executarB = true;
							}
							if($executarA===true && $executarB===true){
								break;
							}
						}
							
						if($executarA===true && $executarB===true){
							if($upd->exe()===false){
								if(strlen($msgFail)>0){
									$javaExe->showMsg(true,$iForm,$msgFail.administrador.$dataSet->getError(1),"close","close","n",COLOR_ULTRA_DARK_RED);
								}
							}else{
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_INS"),true);
								$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_DES"),true);
								$javaExe->visible($iForm."_group_".$page->session->getSession($iForm."_GROUP_UPD"),true);
								
								$page->session->setSession("TYPE","FILL");
								$page->session->setSession("PAGENAME",$page->session->getSession($iForm."_PAGENAME"));
								$page->session->setSession("PARAMETER",$page->session->getSession($iForm."_ID"));
								$page->session->setSession("FORM",$iForm);
								
								$iFormA = $iForm;
								
								if($page->session->getSession($iForm."_INCLUDE_AFTER")){
									$page->e("INCLUDE AFTER ACT (".@$type.")<BR>");
									@include_once $page->session->getSession($iForm."_INCLUDE_AFTER");
								}
								
								if($fieldStatus!==false){
									$javaExe->value($fieldStatus, $autoBuildColumns[$autoBuildColumnsIdStatus]["mask"][1],true);
									$javaExe->setBackgroundColor($fieldStatus, COLOR_GREEN, true);
								}
								if(strlen($msgSuccess)>0){
									$javaExe->showMsg(true,$iFormA,$msgSuccess,"close","close","n",COLOR_DARK_GREEN);
								}
							}
						}else{
							$page->e("Não executado");
						}						
					}else{
						$page->e("Não Será Inserido!");
					}
				}else{
					$page->e("Formulario não criado!");
				}
			}else{
				$page->e("HOUVE UM ERRO!<BR>");
			}
		}else{
			$page->e("Formulario não encontrado!");
		}
	}
	
	if(@$_POST[$iForm."void"]=="1"){		
		if($page->session->getSession($iForm."_INCLUDE_AFTER")){
			$page->e("INCLUDE AFTER ANTES DO FILL (".@$type.")<BR>");
			@include $page->session->getSession($iForm."_INCLUDE_AFTER");
		}
	}
	
	if($dadoRecebido===false || $page->session->getSession("TYPE")=="FILL"){
		if(isset($type)){
			$typeA = $type;
		}else{
			$typeA = false;
		}
		$type = $page->session->getSession("TYPE");
		
		$page->e("NENHUM DADO RECEBIDO<BR><BR>");
		
		$iForm = $page->session->getSession("FORM");
		
		$c = $page->session->getSession("C");
		
		$table = $page->session->getSession($iForm."_TABLE");
			
		if($page->session->getSession($iForm."_DATASET")=="iDataSet"){
			$dataSet = $idsa;
		}else if($page->session->getSession($iForm."_DATASET")=="iDataSetS"){
			$dataSet = $idss;
		}else{
			$dataSet = $idsb;
		}
		
		$fieldIdName = "id".str_replace(" ", "",ucwords(str_replace("_", " ",$table)));
			
		$autoBuildColumns = $page->session->getSession($iForm."_AUTOBUILDCOLUMNS");
					
		if($page->session->getSession("RESET_THIS_FORM")){
			$page->session->unSetSession("RESET_THIS_FORM");
			$page->session->unSetSession("TYPE");
			$type = "RESET";
			
			$page->e("RESET<BR>");
			
			$javaExe->value($iForm."KeyAnt", "", true);
			$javaExe->value($iForm."KeyPro", "", true);
			$javaExe->setClass("btAnt".$iForm, "bigButtonB bigButtonDes", true);
			$javaExe->setClass("btPro".$iForm, "bigButtonB bigButtonDes", true);
			
			$autoBuildColumns = $page->session->getSession($iForm."_AUTOBUILDCOLUMNS");
			
			if(count($autoBuildColumns)>0){
				foreach ($autoBuildColumns as $key => $value){
					if($value['create']===true){
						if($value['typeObj']=="textBox"){
							$field = "tb".ucwords($value['Field']);
						}else if($value['typeObj']=="comboBox"){
							$field = "cb".ucwords($value['Field']);
						}else{
							$field = "tb".ucwords($value['Field']);
						}
							
						if(strpos($value['Field'],"status")!==false || $fieldIdName==$value['Field']){
							$javaExe->setBackgroundColor($field, COLOR_DARK_SILVER, true);
							$javaExe->setColor($field, COLOR_WHITE, true);
							$javaExe->value($field, "NOVO",true);
						}else if(strpos($value['Field'],"estado")!==false){
							$javaExe->selectedIndexComboBox($field,"",true,false);
						}else if(strpos($value['Field'],"cidade")!==false){
							$cidades[0]['value'] = "";
							$cidades[0]['text'] = "ESCOLHA PRIMEIRO O ESTADO";
							$javaExe->reloadComboBox($field, $cidades,false,true);
						}else{	
							$javaExe->setBackgroundColor($field, COLOR_WHITE, true);
							if(strlen($value['Default'])==0){
								if($value['typeObj']!="comboBox"){
									$javaExe->value($field, "",true);
								}else{
									$javaExe->selectedIndexComboBox($field,"",true,false);		
								}
							}else{
								if($value['typeObj']!="comboBox"){
									$javaExe->value($field, $value['Default'],true);
								}else{
									$javaExe->selectedIndexComboBox($field,$value['Default'],true,false);
								}
							}
						}
					}
				}
			}
			
			$javaExe->visible($iForm."_group_".$page->session->getSession($iForm."_GROUP_INS"),true);
			$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_DES"),true);
			$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_UPD"),true);
			$javaExe->value($iForm."SpcHist", "",true,true);
			
			$javaExe->valueReplace("c1_title0", "Modificar", "Cadastrar",true,true);
			
			if(strlen($page->session->getSession($iForm."_INCLUDE_RESET"))){
				$page->e("INCLUDE RESET<BR>");
				@include_once $page->session->getSession($iForm."_INCLUDE_RESET");
			}
		}else if($type=="FILL"){
			$page->e("FILL<br>");
						
			$selB = new iSelect($dataSet,$table);
			
			$page->e("PAGENAME: ".$page->session->getSession("PAGENAME")."<br>");
			$page->e("PARAMETER: ".$page->session->getSession("PARAMETER")."<br>");
			
			if($page->session->getSession("PAGENAME")){
				$selB->where($fieldIdName, "=", $page->session->getSession($page->session->getSession("PARAMETER"),$page->session->getSession("PAGENAME")));
			}else{
				$selB->where($fieldIdName, "=", $page->session->getSession($page->session->getSession("PARAMETER")));
			}
			
			if($selB->exe()!==false){
				if($selB->getNumRows()==0){
					$page->e("DADOS NÃO CARREGADOS<BR>".$selB->getSql()."<BR>");
				}else{
					$page->e("DADOS CARREGADOS 1<BR>");
					$rowB = $selB->read();
					$fieldId = false;
					#$fieldIdName = false;
					$fieldIdValue = false;
					$fieldStatus = false;
					$fieldStatusValue = false;
					$fieldStatusName = false;
					$fieldHistoricoValue = false;
					$autoBuildColumnsIdStatus = false;
					$estado = false;
					foreach ($autoBuildColumns as $key => $value){
						$value['value'] = $rowB[$value['Field']];
						
						if($value['create']===true){
							if($value['typeObj']=="textBox"){
								$field = "tb".ucwords($value['Field']);
							}else if($value['typeObj']=="comboBox"){
								$field = "cb".ucwords($value['Field']);
							}else{
								$field = "tb".ucwords($value['Field']);
							}
							
							if(strpos($value['Field'],"status")!==false){
								$fieldStatusValue = $value['value'];
								if(isset($value['maskBackGroundColor'])){
									if(isset($value['maskBackGroundColor'][$value['value']])){	
										$javaExe->setBackgroundColor($field, $value['maskBackGroundColor'][$value['value']], true);
									}
								}else{
									if($value['value']=="0"){
										$javaExe->setBackgroundColor($field, COLOR_RED, true);
									}else{
										$javaExe->setBackgroundColor($field, COLOR_GREEN, true);
									}
								}
								
								if(isset($value['maskColor'])){
									if(isset($value['maskColor'][$value['value']])){
										$javaExe->setColor($field, $value['maskColor'][$value['value']], true);
									}
								}
							}else if($fieldIdName==$value['Field']){
								$javaExe->setBackgroundColor($field, COLOR_DARK_SILVER, true);
							}else{
								# BACKGROUND COLOR
								if($dadoRecebido===false){
									$javaExe->setBackgroundColor($field, COLOR_WHITE, true);
								}
							}
							
							if(isset($value['mask'])){
								if(isset($value['mask'][$value['value']])){
									$value['value'] = @$value['mask'][$value['value']];
								}
							}
							
							if(isset($value['formatDate'])){
								if($value['formatDate']['enable']===true){
									$value['value'] = $page->formatDate($value['value'],$value['formatDate']['by'],$value['formatDate']['mode']);
								}
							}
							
							# PROCESSO ESTADO E CIDADE
							if(strpos($value['Field'],"estado")!==false){
								$estado = $value['value'];
							}
							if(strpos($value['Field'],"cidade")!==false && $estado!==false){
								if(strlen($estado)==2){
									$selC = new iSelect($idsa,"cidade");
									$selC->where("Uf", "=", $estado,true);
									$selC->order("Nome");
										
									if($selC->exe()===false){
										$page->e("FALHOU: ".$idsa->getError(1)."<BR>");
									}else if($selC->getNumRows()==0){
										$page->e("RETORNOU 0<BR>");
									}else{
										$options = array();
										while ($rowC = $selC->read()){
											$rowC['Nome']= $page->stringToUpper(addslashes($rowC['Nome']));
											$id = count($options);
											$options[$id]['value'] = $rowC['Nome'];
											$options[$id]['text'] = $rowC['Nome'];
										}
										$javaExe->reloadComboBox($field, $options,$value['value'],true);
									}
								}else{
									$cidades[0]['value'] = "";
									$cidades[0]['text'] = "ESCOLHA PRIMEIRO O ESTADO";
									$javaExe->reloadComboBox($field, $cidades,false,true);
								}
								$estado = false;
							}
							if($value['typeObj']=="comboBox"){
								if(strpos($value['Field'],"cidade")===false){
									$javaExe->selectedIndexComboBox($field,$value['value'],true,false);
								}
							}else{
								$formatCpfCnpj = true;
								if(isset($value['cpfCnpj'])){
									if($value['cpfCnpj']===false){
										$formatCpfCnpj = false;
									}
								}
								if($formatCpfCnpj===true){
									if(strpos($page->stringToUpper($value['Field']),"CPF")!==false || strpos($page->stringToUpper($value['Field']),"CNPJ")!==false){
										$value['value'] = $page->formatCpfCnpj($value['value']);
									}
								}
								if(strpos($page->stringToUpper($value['Field']),"CEP")!==false){
									$value['value'] = $page->formatCep($value['value']);
								}
								if(strpos($page->stringToUpper($value['Field']),"RGIE")!==false){
									$value['value'] = $page->formatRgIe($value['value']);
								}
								$javaExe->value($field, $value['value'],true);
							}
							
							# PROCESSO ARRAY KEY
							if($fieldIdName==$value['Field']){
								if(!$page->session->getSession("ARRAY_KEYS_".$page->session->getSession($iForm."_LISTNAME"))){
									$javaExe->setClass("btAnt".$iForm, "bigButtonB bigButtonDes", true);
									$javaExe->setClass("btPro".$iForm, "bigButtonB bigButtonDes", true);
								}else{
									$arrayKeys = $page->session->getSession("ARRAY_KEYS_".$page->session->getSession($iForm."_LISTNAME"));
									
									if(!isset($arrayKeys[$value['value']])){
										$javaExe->setClass("btAnt".$iForm, "bigButtonB bigButtonDes", true);
										$javaExe->setClass("btPro".$iForm, "bigButtonB bigButtonDes", true);
									}else{
										if($arrayKeys[$value['value']]['anterior']===false){
											$javaExe->setClass("btAnt".$iForm, "bigButtonB bigButtonDes", true);
										}else{
											$javaExe->value($iForm."KeyAnt", $arrayKeys[$value['value']]['anterior'], true);
											$javaExe->setClass("btAnt".$iForm, "bigButtonB bigBtBlueB", true);
										}
										
										if($arrayKeys[$value['value']]['proxima']===false){
											$javaExe->setClass("btPro".$iForm, "bigButtonB bigButtonDes", true);
										}else{
											$javaExe->value($iForm."KeyPro", $arrayKeys[$value['value']]['proxima'], true);
											$javaExe->setClass("btPro".$iForm, "bigButtonB bigBtBlueB", true);
										}
									}
								}
							}
							# FIM - PROCESSO ARRAY KEY
						}else{
							if(strpos($value['Field'],"status")!==false){
								$fieldStatusValue = $value['value'];
							}						
						}
						
						if($value['Field']=="historico"){
							$fieldHistoricoValue = $rowB[$value['Field']];
						}
					}
					
					if($typeA===false){
						if($fieldStatusValue==0){
							$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_INS"),true);
							$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_UPD"),true);
							$javaExe->visible($iForm."_group_".$page->session->getSession($iForm."_GROUP_DES"),true);						
						}else if($fieldStatusValue==1){
							$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_INS"),true);
							$javaExe->invisible($iForm."_group_".$page->session->getSession($iForm."_GROUP_DES"),true);
							$javaExe->visible($iForm."_group_".$page->session->getSession($iForm."_GROUP_UPD"),true);
						}
					}
					$javaExe->updateCore($page->session->getSession($iForm."_LISTNAME"));
					
					$javaExe->valueReplace("c1_title0", "Cadastrar", "Modificar",true,true);
				}
			}else{
				$page->e("FALHA: ".$dataSet->getError(1));
			}
		}
		
		if($page->session->getSession("PANEL") && $type!="INS" && $type!="UPD"){
			$page->e("PAINEL<BR>");
			$panel = $page->session->getSession("PANEL");
			$page->session->unSetSession("PANEL");
			
			$panel = explode(",", $panel);
			$panelB = array();
			foreach ($panel as $keyB => $valueB){
				$panelB[$valueB] = true;
			}
			
			foreach ($c as $key => $value){
				if(isset($panelB["c".$key])){
					$javaExe->visible("c".$key,true);
				}else{
					$javaExe->invisible("c".$key,true);
				}
			}
		}
	}else if($page->session->getSession("PANEL") && $type!="INS" && $type!="UPD"){
		$page->e("PAINEL<BR>");
		$panel = $page->session->getSession("PANEL");
		$page->session->unSetSession("PANEL");
		
		$panel = explode(",", $panel);
		$panelB = array();
		foreach ($panel as $keyB => $valueB){
			$panelB[$valueB] = true;
		}
		
		foreach ($c as $key => $value){
			if(isset($panelB["c".$key])){
				$javaExe->visible("c".$key,true);
			}else{
				$javaExe->invisible("c".$key,true);
			}
		}
	}
		
	if(isset($iForm)){
		if(isset($fieldHistoricoValue)){
			$page->e("HISTORICO<BR>");
			$historico = "";
			$fieldHistoricoValue = explode("#", $fieldHistoricoValue);
			foreach ($fieldHistoricoValue as $key => $value){
				$historico .= $value."<br>";
				/*if(strpos($value, "MODIFICADO")===false){
					$historico .= $value."<br>";
				}*/
			}
			
			$javaExe->value($iForm."SpcHist", $historico,true,true);
		}
		
		# PROCESSO CARREGA CIDADES
		if($page->session->getSession("TYPE")=="CID"){
			$page->e("CARREGA CIDADES (".@$type.")<BR>");
			
			$selC = new iSelect($idsa,"cidade");
			$selC->where("Uf", "=", $page->session->getSession($iForm."_ESTADO"),true);
			$selC->order("Nome");
			
			if($selC->exe()===false){
				$page->e("FALHOU: ".$idsa->getError(1)."<BR>");
			}else if($selC->getNumRows()==0){
				$page->e("RETORNOU 0<BR>");
			}else{
				$options = array();
				$meio = ceil($selC->getNumRows() / 2);
				$cont = 0;
				$selectedIndex = false;
				while ($rowC = $selC->read()){
					$rowC['Nome'] = $page->stringToUpper(addslashes($rowC['Nome']));
					$id = count($options);
					$options[$id]['value'] = $rowC['Nome'];
					$options[$id]['text'] = $rowC['Nome'];
					
					if($cont<$meio){
						$cont++;
					}else if($cont==$meio){
						$cont++;
						$selectedIndex = $rowC['Nome'];
					}
				}
				
				$javaExe->reloadComboBox($page->session->getSession($iForm."_FIELD"), $options,$selectedIndex,true);
			}
		}
		
		if($page->session->getSession($iForm."_INCLUDE_AFTER")){
			$page->e("INCLUDE AFTER FINAL (".@$type.")<BR>");
			@include $page->session->getSession($iForm."_INCLUDE_AFTER");
		}
	}
	
	$page->session->unSetSession("TYPE");
}else{
	$page->e("NÃO PASSOU NO SECURITY<BR>");
}

$javaExe->invisible("baseCarregando",true);

# Finaliza a pagina
$page->End();