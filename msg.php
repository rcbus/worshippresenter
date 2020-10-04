<?php
$opacity = 90;

# Mensagem
$baseMsg = new space($page,"baseMsg","center");
$baseMsg->css->zIndex(998);
$baseMsg->css->setInvisible();
$baseMsg->css->setPosition(0, 0,"fixed");
$baseMsg->css->width("100%");
$baseMsg->css->height("100%");
$baseMsg->css->overflow("auto");
$baseBaseMsg = new space($baseMsg,"baseBaseMsg","center");
$baseBaseMsg->css->zIndex(999);
$baseBaseMsg->css->setPosition(0, 0,"fixed");
$baseBaseMsg->css->width("100%");
$baseBaseMsg->css->height("100%");
$baseBaseMsg->css->opacity($opacity);
$baseBaseMsg->css->backGroundColor("rgb(10,40,80)");
$msg = new space($baseMsg, "msg","center","msg");
$msg->css->zIndex(1000);
$msg->css->position("relative");
$msg->css->marginTop(100);
$textoMsg = new space($msg, "textoMsg","center","textoMsg");
$textoMsg->css->marginTop(10);
$textoMsg->css->fontSize(36);

# Condicional
$condicional = new table($msg, "condicional");
$condicional->css->marginBottom(60);
$condicional->newLine();
$condicional->newCell();
$btYes = new button($condicional->getCellObj(),"btYes","Ok",btGreen);
$btYes->css->minWidth(40);
$btYes->css->fontSize(24);
$btYes->css->height(50);
$btYes->css->lineHeight(50);
$btYes->java->setOnClick();
$condicional->newCell("",20);
$condicional->newCell();
$btNo = new button($condicional->getCellObj(),"btNo","Cancelar",btYellow);
$btNo->css->minWidth(40);
$btNo->css->fontSize(24);
$btNo->css->height(50);
$btNo->css->lineHeight(50);
$btNo->java->setOnClick();

$space = new space($msg, "spaceB","center","textoMsg");

function showMsg($pxm=0,$pym=0,$myMsg="Nenhuma Mensagem",$pathCaseYes="",$pathCaseNo="",$type="n",$textAlign="center"){
	showMsgNovo($myMsg,$pathCaseYes,$pathCaseNo,$type,$textAlign);
}

function showMsgNovo($myMsg="Nenhuma Mensagem",$pathCaseYes="",$pathCaseNo="",$type="n",$textAlign="center",$objAffected=false){
	global $baseMsg;
	global $msg;
	global $textoMsg;
	global $btYes;
	global $btNo;
	global $PAGENAME;
	
	$baseMsg->css->setVisible();
	$msg->css->setVisible();
	$msg->css->position("relative");
	$textoMsg->inSide($myMsg);
	$textoMsg->css->textAlign($textAlign);
	if($msg->stringToUpper($type)=="N"){
		$btYes->setValue("Ok");
		$btNo->setValue("Cancelar");
	}else{
		$btYes->setValue("Sim");
		$btNo->setValue("Não");
	}
	if($pathCaseYes=="" && $pathCaseYes!==false){
		$pathCaseYes = $_SERVER['SCRIPT_NAME'];
		$btYes->java->setFunctionGoToPage($pathCaseYes);
		$btYes->java->setObjVisible("click", "btYes", "baseCarregando");
	}else if($pathCaseYes=="close"){
		$btYes->java->setFunctionCloseObj("baseMsg");
	}else if($pathCaseYes=="submitForm"){
		$btYes->java->setSubmitForm("click", "btYes", $objAffected);
		$btYes->java->setObjVisible("click", "btYes", "baseCarregando");
	}else if($pathCaseYes!==false){
		$btYes->java->setFunctionGoToPage($pathCaseYes);
		$btYes->java->setObjVisible("click", "btYes", "baseCarregando");
	}
	if($pathCaseNo==""){
		$pathCaseNo = $pathCaseYes;
		if($pathCaseNo=="" && $pathCaseNo!==false){
			$btNo->java->setFunctionGoToPage($pathCaseNo);
			$btNo->java->setObjVisible("click", "btNo", "baseCarregando");
		}else if($pathCaseNo=="close"){
			$btNo->java->setFunctionCloseObj("baseMsg");
		}else if($pathCaseNo!==false){
			$btNo->java->setFunctionGoToPage($pathCaseNo);
			$btNo->java->setObjVisible("click", "btNo", "baseCarregando");
		}
	}else if($pathCaseNo!==false){
		if($pathCaseNo=="close"){
			$btNo->java->setFunctionCloseObj("baseMsg");
		}else{
			$btNo->java->setFunctionGoToPage($pathCaseNo);
			$btNo->java->setObjVisible("click", "btNo", "baseCarregando");
		}
	}
	return true;
}

function refreshShowMsg($pageToGo=THIS,$myMsg="Nenhuma Mensagem",$pathCaseYes="",$pathCaseNo="",$type="n",$textAlign="center",$objAffected=false){
	global $page;
	global $PAGENAME;
	
	$page->session->setSession("SYSTEM_MSG",$myMsg,$PAGENAME);
	$page->session->setSession("SYSTEM_PATH_CASE_YES",$pathCaseYes,$PAGENAME);
	$page->session->setSession("SYSTEM_PATH_CASE_NO",$pathCaseNo,$PAGENAME);
	$page->session->setSession("SYSTEM_TYPE",$type,$PAGENAME);
	$page->session->setSession("SYSTEM_TEXT_ALIGN",$textAlign,$PAGENAME);
	$page->session->setSession("SYSTEM_OBJ_AFFECTED",$objAffected,$PAGENAME);
	
	$page->goToPage($pageToGo);
}

if($page->session->getSession("SYSTEM_MSG",$PAGENAME)){
	showMsgNovo($page->session->getSession("SYSTEM_MSG",$PAGENAME),$page->session->getSession("SYSTEM_PATH_CASE_YES",$PAGENAME),$page->session->getSession("SYSTEM_PATH_CASE_NO",$PAGENAME),$page->session->getSession("SYSTEM_TYPE",$PAGENAME),$page->session->getSession("SYSTEM_TEXT_ALIGN",$PAGENAME),$page->session->getSession("SYSTEM_OBJ_AFFECTED",$PAGENAME));

	$page->session->unSetSession("SYSTEM_MSG",$PAGENAME);
	$page->session->unSetSession("SYSTEM_PATH_CASE_YES",$PAGENAME);
	$page->session->unSetSession("SYSTEM_PATH_CASE_NO",$PAGENAME);
	$page->session->unSetSession("SYSTEM_TYPE",$PAGENAME);
	$page->session->unSetSession("SYSTEM_TEXT_ALIGN",$PAGENAME);
	$page->session->unSetSession("SYSTEM_OBJ_AFFECTED",$PAGENAME);
}

# Carregando
$baseCarregando = new space($page,"baseCarregando","center");
$baseCarregando->css->zIndex(998);
$baseCarregando->css->setInvisible();
$baseCarregando->css->setPosition(0, 0,"fixed");
$baseCarregando->css->width("100%");
$baseCarregando->css->height("100%");
$baseBaseCarregando = new space($baseCarregando,"baseBaseCarregando","center");
$baseBaseCarregando->css->zIndex(999);
$baseBaseCarregando->css->setPosition(0, 0,"fixed");
$baseBaseCarregando->css->width("100%");
$baseBaseCarregando->css->height("100%");
$baseBaseCarregando->css->opacity($opacity);
$baseBaseCarregando->css->backGroundColor("rgb(10,40,80)");
$carregando = new space($baseCarregando, "carregando","center","msg");
$carregando->css->zIndex(1000);
$carregando->css->position("relative");
$carregando->css->marginTop(120);
$textoCarregando = new space($carregando, "textoCarregando","center","textoMsg");
$textoCarregando->css->marginTop(10);
$textoCarregando->css->marginBottom(10);
$textoCarregando->css->fontSize(36);
$textoCarregando->inSideBold("Carregando... Por Favor, Aguarde!");

/*$textoCarregando->inSide("
	<script language=\"javascript\">
		var objBaseCarregando = document.getElementById('baseCarregando');
		var objTextoCarregando = document.getElementById('textoCarregando');
		var statusBaseCarregando = 0;
		var avisoDemora = 10;
		var avisoRecarregar = 60;

		setInterval(function(){
			if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando==0){
				statusBaseCarregando++;
			}else if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando==avisoDemora){
				statusBaseCarregando = statusBaseCarregando + 1;
				objTextoCarregando.innerHTML = '<b>Carregando... Desculpe-nos pela demora...</b>';
			}else if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando<avisoRecarregar){
				statusBaseCarregando = statusBaseCarregando + 1;
			}else if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando==avisoRecarregar){
				statusBaseCarregando = statusBaseCarregando + 1;
				objTextoCarregando.innerHTML = '<b>Carregando... Está demorando mais do que o normal...<br>Se preferir <a href=\"".THIS."\" style=\"color:".COLOR_ORANGE.";font-size:36px;\">clique aqui</a> para recarregar a página!</b>';
			}else if(objBaseCarregando.style.display!=\"block\"){
				statusBaseCarregando = 0;
				objTextoCarregando.innerHTML = '<b>Carregando... Por Favor, Aguarde!</b>';
			}
		},1000);
	</script>
");*/


$textoCarregando->inSide("
	<script language=\"javascript\">
		var objBaseCarregando = document.getElementById('baseCarregando');
		var objTextoCarregando = document.getElementById('textoCarregando');
		var statusBaseCarregando = 0;
		var avisoDemora = 10;
		var avisoRecarregar = 60;
		
		setInterval(function(){
			if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando==0){
				statusBaseCarregando++;
			}else if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando==avisoDemora){
				statusBaseCarregando = statusBaseCarregando + 1;
				objTextoCarregando.innerHTML = '<b>Carregando... Desculpe-nos pela demora...</b>';
			}else if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando<avisoRecarregar){
				statusBaseCarregando = statusBaseCarregando + 1;
			}else if(objBaseCarregando.style.display==\"block\" && statusBaseCarregando==avisoRecarregar){
				statusBaseCarregando = statusBaseCarregando + 1;
				objTextoCarregando.innerHTML = '<b>Carregando... Está demorando mais do que o normal...<br>Se preferir <a href=\"".THIS."\" style=\"color:".COLOR_ORANGE.";font-size:36px;\">clique aqui</a> para recarregar a página!</b>';
			}else if(objBaseCarregando.style.display!=\"block\"){
				statusBaseCarregando = 0;
				objTextoCarregando.innerHTML = '<b>Carregando... Por Favor, Aguarde!</b>';
			}
		},1000);
		
		var contOpen = 0;
		var contClose = 0;
		var contCloseB = 0;
		var timeoutClose = 10;
		contCloseB = timeoutClose;
		
		function openBaseCarregando(){
			contOpen = 1;
		}
		
		function closeBaseCarregando(){
			contOpen = 0;
		}
		
		setInterval(function(){
			if(contOpen==1 && contClose==0){
				contClose = 1;
				contCloseB = 0;
				objBaseCarregando.style.display = \"block\";
			}else if(contOpen==1 && contClose==1){
				contCloseB = 0;	
			}else if(contCloseB<timeoutClose){
				contCloseB = contCloseB + 1;
			}else{
				contClose = 0;
				contCloseB = 0;
				objBaseCarregando.style.display = \"none\";
			}
		},100);
	</script>
");

$stlCorpoZ = new style("stlCorpoZ","#","corpoZ",$page);
$stlCorpoZ->fontSize(24);
$stlCorpoZ->color(COLOR_WHITE);

$BASE_CARREGANDO_CONT = true;