<?php
$PATH = "";
$PAGENAME = "paginaInicial";
$PAGETITLE = "Página Inicial :: Profiable";

# Carregamento do sistema
include_once @$PATH.'preLoad.php';

$page->session->setSession("MUSICA_ID_APRESENTACAO_A","*",$PAGENAME);

$menu->css->setInvisible();
$NO_REPOSITION_CORPO = true;
$widthPadding = 10;

$corpo = new space($page, "corpo");
$corpo->css->setPosition(20, 5);

$lyt = new newTable($corpo, "lyt");
$lyt->line();
$lyt->cell();
$lyt->button($name = "btNovaMusica", "Nova Musica");
$lyt->java->setGoToPage("click", $name,"editar.php?MUSICA_ID_EDITAR=@".$PAGENAME);

$lyt->button($name = "btConfiguracoes", "Configurações");
$lyt->java->setGoToPage("click", $name,"configuracoes.php");

$lyt->button($name = "btAbrirJanelaApresentacao", "Abrir Janela Apresentação");
$lyt->java->setGoToPage("click", $name,str_replace("index.php", "", THIS)."presenter.php","","","_blank","","");

$lyt = new newTable($corpo, "lytB");
$lyt->css->setPosition(0, 70);
$lyt->line("",false,true);
$lyt->cell("","","","top");
$lyt->css->borderTop(0);
$lyt->css->padding($widthPadding);

$lyt->inSideBold("Escolha a Musica Aqui<br>");
$lyt->textBox($name = "tbPesquisaMusica");
$lyt->addStyles($name,width."280px");
$lyt->placeHolder($name,"Pesquise Aqui");
$lyt->java->core("change",$name,"tdA","presenter/loadMusica.php",$name,"PESQUISA_MUSICA",$PAGENAME,false,false,true);

$lyt->line(tblLayOutSpcTr3);
$lyt->cell("","","","top");
$lyt->space($name = "tdA");

$lyt = new newTable($corpo, "lytC");
$lyt->css->setPosition(318, 70);
$lyt->css->padding($widthPadding);
$lyt->css->paddingRight(0);
$lyt->css->borderLeft(0);
$lyt->css->borderTop(0);

$lyt->line("",false,true);
$lyt->cell();
$lyt->inSideBold("Musicas Escolhidas<br>");

$lyt->button($name = "btRemoverTudo", "Remover Tudo");
$lyt->addStyles($name,width."275px");
$lyt->java->setGoToPage("click", $name,"presenter/loadMusicaEscolhida.php","REMOVER_TUDO","1","","@".$PAGENAME,"",false,"objCoretdB0");

$lyt->line("",false,true);
$lyt->cell(tblLayOutSpcTr3,"","","top");
$lyt->space($name = "tdB");
$lyt->java->core("keyup",$name,$name,"presenter/loadMusicaEscolhida.php","","","",false,false,false,true,false);

$lyt = new newTable($corpo, "lytD");
$lyt->css->setPosition(647, 70);
$lyt->css->padding($widthPadding);
$lyt->css->borderLeft(0);
$lyt->css->borderTop(0);
$lyt->css->minHeight(550);

$lyt->line("",false,true);
$lyt->cell(false,false,false,true);
$lyt->inSideBold("Apresentando<br>");
$lyt->textBox($name = "tbApresentando");
$lyt->addStyles($name,width."485px");
$lyt->readOnly($name);

$lyt->line("",false,true);
$lyt->cell(false,false,false,true);
$lyt->comboBox($name = "cbParagrafo",false,"","textBox comboBox",true);
$lyt->addStyles($name,width."500px");
$lyt->addStyles($name,height."420px");
$lyt->java->core("change",$name,$name,"presenter/setParagrafo.php",$name,"PARAGRAFO",$PAGENAME,false,false,false,true,false);

$descarta = new space($page,"descarta");

# Finaliza a pagina
$page->End();