<?php
# Bloqueador de Include
$enableInclude = array();
for($i=1;$i<=32;$i++){
	$enableInclude[$i] = true;
}

# Carregamento do sistema
include_once @$PATH.'RCD_7/load.php';
include_once @$PATH.'../security/worshippresenter.php';

# Constroe a pagina
$PROCESSO = 0;
$page = new page($PAGENAME);
$page->setTitle($PAGETITLE);
$page->setPath(@$PATH);

# Conexão Sistema
$idss = new iDataBase("iDataSetS");
$idss->setConnection($_SECURITY[0]['host'], $_SECURITY[0]['user'], $_SECURITY[0]['pass'], $_SECURITY[0]['base']);
	
if($page->session->getSession("PRINT",$PAGENAME)!="1"){
	# Carrega o menu
	include_once @$PATH.'menu.php';
	
	# Carrega a msg
	include_once @$PATH.'msg.php';
}

include_once @$PATH.'class/styles.php';

# DEFINE SE É PAGINA NORMAL OU SUBPAGINA
$isPaginaNormal = 1;