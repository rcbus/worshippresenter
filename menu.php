<?php
include_once @$PATH.'../version.php';

# Base do menu
$menu = new space($page, "menu");
$menu->css->zIndex(20);
$menu->css->setPosition(0,0,"fixed");
$menu->css->width("100%");
$menu->css->height(0);
$menu->css->backGroundImage(@$PATH."imagens/top5.png");
$menu->css->boxShadow(0,1,3,$page->color->darkGray());

$totalBotoes = 7;

# Base dos botões do menu
$baseBt = new space($menu,"baseBt");
$baseBt->css->setPosition(0,35);
$baseBt->css->width("100%");
$baseBt->css->height(35);

# Botão menu produção
$bt = new space($baseBt,"btProducao","center","btMenu");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Produção");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/producao.php?ACTION=@producao");

# Botão menu estoque
$bt = new space($baseBt,"btEstoque","center","btMenu");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Estoque");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/estoque.php");

# Botão menu contabil
$bt = new space($baseBt,"btContabil","center","btMenu");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Comercial");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/comercial.php");

# Botão menu administrativos
$bt = new space($baseBt,"btAdministrativo","center","btMenu");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Administrativo");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/administrativo.php");

# Botão menu manutenção
$bt = new space($baseBt,"btManutencao","center","btMenu");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Manutenção");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/manutencao.php");

# Botão menu expedição
$bt = new space($baseBt,"btExpedicao","center","btMenu");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Expedição");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/expedicao.php");

# Botão menu sistema
$bt = new space($baseBt,"btSistema","center","btMenu");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Sistema");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/sistema.php");

# Base dos botões do menu B
$baseBtB = new space($menu,"baseBtB");
$baseBtB->css->setPosition(0,0);
$baseBtB->css->width("100%");
$baseBtB->css->height(35);

# Botão menu voltar
$btVoltar = new space($baseBtB,"btVoltar","center","btMenuVoltar");
$btVoltar->css->width((100 / $totalBotoes)."%");
$btVoltar->inSide("Voltar");
$btVoltar->java->setOnClick();
if(isset($PATHVOLTAR)){
	$btVoltar->java->setFunctionGoToPage($PATHVOLTAR);
}

# Botão menu home
$bt = new space($baseBtB,"btHome","center","btMenuHome");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Home");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/paginaInicial.php","page","home");

# Nome do usuário
$user = new space($baseBtB, "user", "center");
$user->css->width(((100 / $totalBotoes) * 3)."%");
$user->css->float("left");
$user->css->lineHeight(35);
$user->css->backGroundColor(COLOR_DARK_BLUE);
$user->css->fontSize(18);
$user->css->color(COLOR_LIGHT_BLUE);
$user->inSideBold($page->session->getLoginName()." @ ".$page->session->getSession("NOME_FILIAL"));
$user->css->boxShadow(0,1,2,COLOR_DARK_BLUE);
$user->css->cursor();
$user->java->setObjVisible("click", "user", "versao");
$user->java->setObjInvisible("click", "user", "user");

# Versão
$versao = new space($baseBtB, "versao", "center");
$versao->css->width(((100 / $totalBotoes) * 3)."%");
$versao->css->float("left");
$versao->css->lineHeight(35);
$versao->css->backGroundColor(COLOR_DARK_BLUE);
$versao->css->fontSize(18);
$versao->css->color(COLOR_LIGHT_BLUE);
$versao->inSideBold("PROFIABLE &copy ".date("Y")." - VERSÃO ".$_VERSION);
$versao->css->boxShadow(0,1,2,COLOR_DARK_BLUE);
$versao->css->cursor();
$versao->css->setInvisible();
$versao->java->setObjVisible("click", "versao", "user");
$versao->java->setObjInvisible("click", "versao", "versao");

# Botão menu home
$bt = new space($baseBtB,"btAjuda","center","btMenuHome");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Ajuda");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/ajuda.php","page","home");

# Botão menu sair
$bt = new space($baseBtB,"btSair","center","btMenuSair");
$bt->css->width((100 / $totalBotoes)."%");
$bt->inSide("Sair");
$bt->java->setOnClick();
$bt->java->setFunctionGoToPage(@$PATH."../PROFIABLE/sair.php");

# Menu do Core
$menuCore = new space($page, "menuCore");
$menuCore->css->zIndex(1100);
$menuCore->css->width("25%");
$menuCore->css->height(500);
$menuCore->css->setPosition("4%", 100, "absolute");
$menuCore->css->border(5);
$menuCore->css->backGroundColor(COLOR_BLUE);
$menuCore->css->setInvisible();

if($page->session->getLoginTipo()=="2"){
	$page->body->eventBySpecificKey("113", "exibirOcultarMenuCore");
	$page->body->eventBySpecificKey("115", "exibirOcultarMenu");
	
	$menu->inSide("
	    <script language=\"javascript\">
			var statusMenu = 1;
			function exibirOcultarMenu(){
				if(statusMenu==1){
					statusMenu = 0;
					document.getElementById('menu').style.display = \"none\";
				}else{
					statusMenu = 1;
					document.getElementById('menu').style.display = \"block\";
				}
			}
			var statusMenuCore = 0;
			function exibirOcultarMenuCore(){
				if(statusMenuCore==1){
					statusMenuCore = 0;
					document.getElementById('menuCore').style.display = \"none\";
				}else{
					statusMenuCore = 1;
					document.getElementById('menuCore').style.display = \"block\";
				}
			}
		</script>
	");
}