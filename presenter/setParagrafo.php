<?php
$PATH = "../";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Página Inicial :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoadWithoutStyle.php';

$javaExe = new javaExe();

if($page->session->getSession("MUSICA_ID_APRESENTACAO",$PAGENAME)!=$page->session->getSession("MUSICA_ID_APRESENTACAO_A",$PAGENAME)){
	$page->session->setSession("MUSICA_ID_APRESENTACAO_A",$page->session->getSession("MUSICA_ID_APRESENTACAO",$PAGENAME),$PAGENAME);
	
	$selB = new iSelect($idss,"songs");
	$selB->where("id", "=", $page->session->getSession("MUSICA_ID_APRESENTACAO",$PAGENAME));
    
    if($selB->exe()===false){
        $javaExe->showMsg(true,"","Houve uma falha ao tentar mudar a musica(1)!<br>Por favor, tente novamente.","close");
    }else{
        $rowB = $selB->read();
        
        $upd = new iUpdate($idss,"config");
        $upd->where("id", "=", "1");
        $upd->set("paragrafoAtual", "PRÓXIMO LOUVOR<br><br>".$page->stringToUpper($rowB['title']));
        
        if($upd->exe()===false){
            $javaExe->showMsg(true,"","Houve uma falha ao tentar mudar a musica(2)!<br>Por favor, tente novamente.","close");
        }else{
            $rowB['lyric'] = str_replace("'", "\'", $rowB['lyric']);
            $rowB['lyric'] = str_replace("\r\n\r\n", "#", $rowB['lyric']);
            $rowB['lyric'] = str_replace("\r\n", "$", $rowB['lyric']);

            $arrayLyric = explode("#", $rowB['lyric']);

            $arrayLyricB = array();
            foreach ($arrayLyric as $key => $value){
                $id = count($arrayLyricB);
                $arrayLyricB[$id]['value'] = $value;
                $arrayLyricB[$id]['text'] = str_replace("$", " ", $value);
            }

            $javaExe->value("tbApresentando",$rowB['title'],true);
            $javaExe->reloadComboBox("cbParagrafo",$arrayLyricB,false,true);
        }
    }

	$page->session->unSetSession("REMOVER_TUDO",$PAGENAME);
}else{
    $upd = new iUpdate($idss,"config");
    $upd->where("id", "=", "1");
    $upd->set("paragrafoAtual", $page->session->getSession("PARAGRAFO",$PAGENAME));
    $upd->Exe();
}

echo "
    <script>
        parent.closeBaseCarregando();
    </script>
";