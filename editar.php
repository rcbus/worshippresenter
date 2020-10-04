<?php
$PATH = "";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Editar :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoad.php';

$menu->css->setInvisible();
$NO_REPOSITION_CORPO = true;

if(!$page->session->getSession("MUSICA_ID_EDITAR",$PAGENAME)){
	# PROCESSO SALVAR
	if(@$_POST['FORM_form']){
		$ins = new iInsert($idss,"songs");
		$ins->insert("title", $_POST['tbTitulo']);
		$ins->insert("lyric", "");
		
		if($ins->exe()===false){
			showMsgNovo("Houve uma falha ao tentar cadastrar a nova musica!".administrador.$idss->getError(1,true),"close");
		}else{
			$page->session->setSession("MUSICA_ID_EDITAR",$ins->getNewId(),$PAGENAME);
			
			$page->goToPage(THIS);
		}
	}
	# FIM - PROCESSO SALVAR
	
	$corpo = new space($page, "corpo");
	$corpo->css->setPosition(20, 5);
	
	$form = new iForm($corpo, "form");
	
	$lyt = new newTable($form, "lyt");
	$lyt->line();
	$lyt->cell();
	$lyt->button($name = "btVoltarB", "Voltar", btYellow);
	$lyt->java->setGoToPage("click", $name,"index.php");
	
	$lyt->line();
	$lyt->cell();
	$lyt->inSide("<h3>Nova Musica</h3>");
	
	$lyt->line();
	$lyt->cell();
	$lyt->css->width(500);
	$lyt->inSideBold("Título<br>");
	$lyt->textBox($name = "tbTitulo");
	$lyt->addStyles($name,width."500px");
	$lyt->unSetUppercase($name);
	
	$lyt->cell(tblLayOut);
	$lyt->inSideBold("<br>");
	$lyt->button($name = "btSalvar", "Salvar",btGreen);
	$lyt->java->setSubmitForm("click", "btSalvar", "form");
}else{
	# PROCESSO SALVAR
	if(@$_POST['FORM_form']){
		$upd = new iUpdate($idss,"songs");
		$upd->where("id", "=", $page->session->getSession("MUSICA_ID_EDITAR",$PAGENAME));
		$upd->set("lyric", $_POST['tbLetraMusica']);
		
		if($upd->exe()===false){
			showMsgNovo("Houve uma falha ao tentar salvar as alterações!","close");
		}else{
			showMsgNovo("Alterações salva com sucesso!","close");
		}
	}
	# FIM - PROCESSO SALVAR

	# PROCESSO EXCLUIR
	if($page->session->getSession("EXCLUIR",$PAGENAME)){
		$page->session->unSetSession("EXCLUIR",$PAGENAME);
		$upd = new iUpdate($idss,"songs");
		$upd->where("id", "=", $page->session->getSession("MUSICA_ID_EDITAR",$PAGENAME));
		$upd->set("statusSongs", "0");
		
		if($upd->exe()===false){
			showMsgNovo("Houve uma falha ao tentar excluir essa música!","close");
		}else{
			refreshShowMsg("index.php","Música excluída com sucesso!","close");
		}
	}
	# FIM - PROCESSO EXCLUIR
	
	$selB = new iSelect($idss,"songs");
	$selB->where("id", "=", $page->session->getSession("MUSICA_ID_EDITAR",$PAGENAME));
	$selB->exe();

	$rowB = $selB->read();
	
	$corpo = new space($page, "corpo");
	$corpo->css->setPosition(20, 5);
	
	$form = new iForm($corpo, "form");
	
	$lyt = new newTable($form, "lyt");
	$lyt->line();
	$lyt->cell();
	$lyt->button($name = "btVoltarB", "Voltar", btYellow);
	$lyt->java->setGoToPage("click", "btVoltarB","index.php?MUSICA_ID_EDITAR=@".$PAGENAME);
	
	$lyt->line();
	$lyt->cell();
	$lyt->inSide("<h3>Editar Musica</h3>");
	
	$lyt->line();
	$lyt->cell();
	$lyt->css->width(500);
	$lyt->inSideBold("Título<br>");
	$lyt->textBox($name = "tbTitulo");
	$lyt->addStyles($name,width."500px");
	$lyt->readOnly($name);
	$lyt->value($name,$rowB['title']);
	$lyt->unSetUppercase($name);
	
	$lyt->cell(tblLayOut);
	$lyt->inSideBold("<br>");
	$lyt->button($name = "btSalvar", "Salvar",btGreen);
	$lyt->java->setSubmitForm("click", "btSalvar", "form");
	
	$lyt->button($name = "btExcluir", "Excluir",btRed);
	$lyt->java->showMsg("click",$name,"Deseja excluir essa música?",THIS."?EXCLUIR=1@".$PAGENAME,"close","c");
	
	$lyt->button($name = "btNovaMusica", "Nova Musica");
	$lyt->java->setGoToPage("click", "btNovaMusica","editar.php?MUSICA_ID_EDITAR=@".$PAGENAME);
	
	$lyt->line();
	$lyt->cell(tblLayOutSpcTr3,"","","",2);
	$lyt->inSideBold("Letra da Música<br>");
	$lyt->textBoxMultiLine($name = "tbLetraMusica");
	$lyt->addStyles($name,width."1000px");
	$lyt->addStyles($name,height."440px");
	$lyt->Value($name,$rowB['lyric']);
	$lyt->unSetUppercase($name);

	$lyt->line();
	$lyt->cell(tblLayOutSpcTr3);
	$lyt->inSide("<br><br><br>");
}

# Finaliza a pagina
$page->End();