<?php
$PATH = "../";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Página Inicial :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoadWithoutStyle.php';

if($page->session->getSession("PESQUISA_MUSICA",$PAGENAME)=="Pesquise Aqui"){
	$page->session->unSetSession("PESQUISA_MUSICA",$PAGENAME);
}

$sel = new iSelect($idss,"songs");
$sel->setAnd("statusSongs", "=", "1");
$sel->order("title");
$sel->columns("id,title");
$sel->like("title", $page->session->getSession("PESQUISA_MUSICA",$PAGENAME));
$sel->like("lyric", $page->session->getSession("PESQUISA_MUSICA",$PAGENAME));
$sel->limit(20);

$width = 296;

$ta = new iDataTableAdapter($page, "ta",$idss);
$ta->setSelect($sel);
$ta->setLimit(20);
$ta->setWithOutTitle();
$ta->width($width);
$ta->setColumnsFake("ID,TÍTULO");
$ta->setColumnHidden("id");
$ta->setActionOnClick("presenter/loadMusicaEscolhida.php", "MUSICA_ID", "id", "id,title",$PAGENAME,false,"objCoretdB0");
$ta->addButton("Editar","button","AÇÃO","editar.php","MUSICA_ID_EDITAR","id","@".$PAGENAME);

# Finaliza a pagina
$page->End("tdA");