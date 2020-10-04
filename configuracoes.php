<?php
$PATH = "";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Configurações :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoad.php';

$selB = new iSelect($idss,"config");
$selB->where("id", "=", "1");
$selB->exe();
$rowB = $selB->read();

$menu->css->setInvisible();
$NO_REPOSITION_CORPO = true;
$widthPadding = 20;

$corpo = new space($page, "corpo");
$corpo->css->setPosition(20, 5);

$lyt = new table($corpo, "lyt");
$lyt->newLine();
$lyt->newCell();
$bt = new button($lyt->getCellObj(), "btVoltarB", "Voltar");
$bt->java->setGoToPage("click", "btVoltarB","index.php");

$lyt->newLine();
$lyt->newCell();
$lyt->inSideCell("<h3>Configurações</h3>");

$lyt->newLine();
$lyt->newCell();
$lyt->inSideBoldCell("Tamanho do Texto<br>");
$cb = new comboBox($lyt->getCellObj(), "cbTamanhoTexto");
$cb->setOption(12,"12");
$cb->setOption(14,"14");
$cb->setOption(16,"16");
$cb->setOption(18,"18");
$cb->setOption(20,"20");
$cb->setOption(22,"22");
$cb->setOption(24,"24");
$cb->setOption(26,"26");
$cb->setOption(28,"28");
$cb->setOption(36,"36");
$cb->setOption(42,"42");
$cb->setOption(48,"48");
$cb->setOption(60,"60");
$cb->setOption(72,"72");
$cb->setOption(80,"80");
$cb->setOption(90,"90");
$cb->setOption(100,"100");
$cb->setOption(110,"110");
$cb->setOption(120,"120");
$cb->setOption(130,"130");
$cb->setOption(140,"140");
$cb->setOption(150,"150");
$cb->setSelectedIndex($rowB['tamanhoTexto']);
$cb->java->setReloadScript("change", "cbTamanhoTexto", "simulador", "configuracoes/setTamanhoTexto.php","cbTamanhoTexto","TAMANHO_TEXTO","",$PAGENAME);

$lyt->newLine();
$lyt->newCell(tblLayOutSpcTr3);

$lytA = new table($lyt->getCellObj(), "lytA");
$lytA->css->border();
$lytA->css->padding(5);
$lytA->newLine();
$lytA->newCell();
$lytA->inSideBoldCell("Cor do Fundo<br>");

$lytB = new table($lytA->getCellObj(), "lytB");
$lytB->css->width(200);
$lytB->css->border();
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_BLACK);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_BLACK."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_DARK_SILVER);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_DARK_SILVER."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_WHITE);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_WHITE."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_DARK_RED);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_DARK_RED."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_RED);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_RED."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_DARK_GREEN);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_DARK_GREEN."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_GREEN);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_GREEN."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_DARK_BLUE);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_DARK_BLUE."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_BLUE);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_BLUE."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_DARK_ORANGE);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_DARK_ORANGE."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_ORANGE);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_ORANGE."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_DARK_YELLOW);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_DARK_YELLOW."@".$PAGENAME);
$lytB->newLine();
$lytB->newCell();
$lytB->obj->css->height(35);
$lytB->obj->css->backGroundColor(COLOR_YELLOW);
$lytB->obj->css->cursor();
$lytB->obj->java->setReloadScript("click", $lytB->obj->getName(), "simulador", "configuracoes/setBackgroundColor.php?COLOR=".COLOR_YELLOW."@".$PAGENAME);

$lytA->newCell(tblLayOut);
$lytA->inSideBoldCell("Cor do Texto<br>");

$lytC = new table($lytA->getCellObj(), "lytC");
$lytC->css->width(200);
$lytC->css->border();
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("PRETO");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_BLACK);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_BLACK."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("CINZA");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_DARK_SILVER);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_DARK_SILVER."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("BRANCO");
$lytC->obj->css->height(33);
$lytC->obj->css->backGroundColor(COLOR_BLACK);
$lytC->obj->css->color(COLOR_WHITE);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_WHITE."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("VERMELHO 1");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_DARK_RED);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_DARK_RED."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("VERMELHO 2");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_RED);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_RED."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("VERDE 1");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_DARK_GREEN);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_DARK_GREEN."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("VERDE 2");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_GREEN);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_GREEN."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("AZUL 1");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_DARK_BLUE);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_DARK_BLUE."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("AZUL 2");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_BLUE);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_BLUE."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("LARANJA 1");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_DARK_ORANGE);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_DARK_ORANGE."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("LARANJA 2");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_ORANGE);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_ORANGE."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("AMARELO 1");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_DARK_YELLOW);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_DARK_YELLOW."@".$PAGENAME);
$lytC->newLine();
$lytC->newCell("","","center");
$lytC->inSideBoldCell("AMARELO 2");
$lytC->obj->css->height(33);
$lytC->obj->css->color(COLOR_YELLOW);
$lytC->obj->css->cursor();
$lytC->obj->css->border();
$lytC->obj->java->setReloadScript("click", $lytC->obj->getName(), "simulador", "configuracoes/setColor.php?COLOR=".COLOR_YELLOW."@".$PAGENAME);

$lytA->newCell(tblLayOut,"","","top");
$lytA->inSideBoldCell("Simulador<br>");
$simulador = new space($lytA->getCellObj(), "simulador");

$corpo = new table($simulador, "corpoC");
$corpo->newLine();
$corpo->newCell("","","center","center");
$corpo->obj->css->width(700);
$corpo->obj->css->backGroundColor($rowB['backgroundColor']);
$corpo->obj->css->color($rowB['color']);
$corpo->obj->css->fontSize($rowB['tamanhoTexto']);
$corpo->obj->css->border();
$corpo->obj->css->height(455);
$corpo->inSideBoldCell("COR E TAMANHO");

$descarta = new space($page, "descarta");

# Finaliza a pagina
$page->End();