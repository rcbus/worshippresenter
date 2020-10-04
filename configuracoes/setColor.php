<?php
$PATH = "../";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Página Inicial :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoadWithoutStyle.php';

$upd = new iUpdate($idss,"config");
$upd->where("id", "=", "1");
$upd->set("color", $page->session->getSession("COLOR",$PAGENAME));
$upd->exe();

$selB = new iSelect($idss,"config");
$selB->where("id", "=", "1");
$selB->exe();
$rowB = $selB->read();

$corpo = new table($page, "corpoC");
$corpo->newLine();
$corpo->newCell("","","center","center");
$corpo->obj->css->width(700);
$corpo->obj->css->backGroundColor($rowB['backgroundColor']);
$corpo->obj->css->color($rowB['color']);
$corpo->obj->css->fontSize($rowB['tamanhoTexto']);
$corpo->obj->css->border();
$corpo->obj->css->height(455);
$corpo->inSideBoldCell("COR E TAMANHO");

$page->End();