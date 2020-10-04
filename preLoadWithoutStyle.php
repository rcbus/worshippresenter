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

$NO_BOTTOM = 1;

function showMsgWithoutStyle($msg,$success=true){
	global $page;
	
	if($success===true){
		$page->e("<span class=\"msgSuccess\">".$msg."</span>");
	}else{
		$page->e("<span class=\"msgErro\">".$msg."</span>");
	}
}

# DEFINE SE É PAGINA NORMAL OU SUBPAGINA
$isPaginaNormal = 0;