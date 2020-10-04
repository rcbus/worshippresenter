<?php
$PATH = "../";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Página Inicial :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoadWithoutStyle.php';

$selB = new iSelect($idss,"config");
$selB->where("id", "=", "1");
$selB->exe();
$rowB = $selB->read();

$lyt = new table($page, "lyt");
$lyt->css->width("100%");
$lyt->css->height("100%");
$lyt->css->setPosition(0, 0);
$lyt->newLine();
$lyt->newCell("","","center","center");
$lyt->obj->css->backGroundColor($rowB['backgroundColor']);
$lyt->obj->css->width("100%");
$lyt->obj->css->height("100%");
$lyt->obj->css->fontSize($rowB['tamanhoTexto']);
$lyt->obj->css->color($rowB['color']);
$lyt->inSideBoldCell(str_replace("$", "<br>", $rowB['paragrafoAtual']));

# Finaliza a pagina
$page->End();