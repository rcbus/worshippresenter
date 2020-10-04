<?php
$PATH = "";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Apresentação :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoad.php';

$menu->css->setInvisible();

$corpo = new space($page, "corpoB");
$corpo->css->setPosition(0, 0);
$corpo->css->width("100%");
$corpo->css->height("100%");
$corpo->java->setFunctionTimer(500, "corpoB", "presenter/loadParagrafo.php", "reloadScript",100);

# Finaliza a pagina
$page->End();