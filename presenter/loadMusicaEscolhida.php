<?php
$PATH = "../";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Página Inicial :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoadWithoutStyle.php';

$javaExe = new javaExe();

if($page->session->getSession("PESQUISA_MUSICA",$PAGENAME)=="Pesquise Aqui"){
	$page->session->unSetSession("PESQUISA_MUSICA",$PAGENAME);
}

# PROCESSO ESCOLHE MUSICA
if($page->session->getSession("MUSICA_ID",$PAGENAME)){
	$sel = new iSelect($idss,"songs_selected");
	$sel->where("idSongs", "=", $page->session->getSession("MUSICA_ID",$PAGENAME));
	$sel->setAnd("statusSongsSelected", "=", "1");
	if($sel->exe()!==false){	
		if($sel->getNumRows()==0){
			$ins = new iInsert($idss,"songs_selected");
			$ins->insert("idSongs", $page->session->getSession("MUSICA_ID",$PAGENAME));
			if($ins->exe()===false){
				$javaExe->showMsg(true,"","Houve uma falha ao tentar selecionar a musica(2)!<br>Por favor, tente novamente.","close");
			}else{
				$javaExe->focus("tbPesquisaMusica",true);
			}
		}else{
			$javaExe->showMsg(true,"","Você já escolheu essa musica!","close");
		}
	}else{
		$javaExe->showMsg(true,"","Houve uma falha ao tentar selecionar a musica(1)!<br>Por favor, tente novamente.","close");
	}
	
	$page->session->unSetSession("MUSICA_ID",$PAGENAME);
}
# FIM - PROCESSO ESCOLHE MUSICA

# PROCESSO REMOVER MUSICA ESCOLHIDA
if($page->session->getSession("MUSICA_ID_REMOVER",$PAGENAME)){
	$upd = new iUpdate($idss,"songs_selected");
	$upd->where("idSongsSelected", "=", $page->session->getSession("MUSICA_ID_REMOVER",$PAGENAME));
	$upd->set("statusSongsSelected", "0");
	
	if($upd->Exe()===false){
		$javaExe->showMsg(true,"","Houve uma falha ao tentar excluir a musica!<br>Por favor, tente novamente.","close");
	}

	$page->session->unSetSession("MUSICA_ID_REMOVER",$PAGENAME);
}
# FIM - PROCESSO REMOVER MUSICA ESCOLHIDA

# PROCESSO REMOVER TUDO
if($page->session->getSession("REMOVER_TUDO",$PAGENAME)){
	$upd = new iUpdate($idss,"songs_selected");
	$upd->where("statusSongsSelected", "=", "1");
	$upd->set("statusSongsSelected", "0");
	
	if($upd->Exe()===false){
		$javaExe->showMsg(true,"","Houve uma falha ao tentar remover todas as musicas!<br>Por favor, tente novamente.","close");
	}

	$page->session->unSetSession("REMOVER_TUDO",$PAGENAME);
}
# FIM - PROCESSO REMOVER TUDO

$sel = new iSelect($idss,"songs_selected");
$sel->columns("idSongsSelected");
$sel->setAnd("statusSongsSelected", "=", "1");
$sel->join("songs", "id", "=", "songs_selected.idSongs");
$sel->columnsJoin("id,title", "songs");
$sel->limit(20);

$ta = new iDataTableAdapter($page, "ta",$idss);
$ta->setSelect($sel);
$ta->setLimit(20);
$ta->setWithOutTitle();
$ta->width(300);
$ta->setColumnsFake("IDSS,ID,TÍTULO");
$ta->setColumnHidden("id");
$ta->setColumnHidden("idSongsSelected");
$ta->setColumnsWidth(",,,40");
$ta->addButton("Excluir","button","AÇÃO","presenter/loadMusicaEscolhida.php","MUSICA_ID_REMOVER","idSongsSelected","@".$PAGENAME,"","","","goToPage",false,"objCoretdB0");
$ta->setActionOnClick("presenter/setParagrafo.php", "MUSICA_ID_APRESENTACAO", "id", "title",$PAGENAME."&MUSICA_ID_APRESENTACAO_A=@".$PAGENAME,false,"objCorecbParagrafo0");

# Finaliza a pagina
$page->End("tdB");