<?php
$title = new style("title",".","title",$page);
$title->fontSize(24);
$title->fontWeight("bold");
$title->color(COLOR_BLUE);

$msgErro = new style("msgErro",".","msgErro",$page);
$msgErro->color(COLOR_RED);
$msgErro->fontWeight("bold");
$msgErro->fontSize(20);

$msgSuccess = new style("msgSuccess",".","msgSuccess",$page);
$msgSuccess->color(COLOR_GREEN);
$msgSuccess->fontWeight("bold");
$msgSuccess->fontSize(20);

$msgInfo = new style("msgInfo",".","msgInfo",$page);
$msgInfo->color(COLOR_BLUE);
$msgInfo->fontWeight("bold");
$msgInfo->fontStyle("italic");
$msgInfo->fontSize(20);

$msgWarning = new style("msgWarning",".","msgWarning",$page);
$msgWarning->color(COLOR_ORANGE);
$msgWarning->fontWeight("bold");
$msgWarning->fontSize(20);

$btLayOut = new style("btLayOut",".","bigButton",$page);
$btLayOut->float("left");
$btLayOut->marginRight(20);

$tblLayOut = new style("tblLayOut",".","tblLayOut",$page);
$tblLayOut->paddingLeft(20);
define("tblLayOut","tblLayOut");

$tblLayOutB = new style("tblLayOutB",".","tblLayOutB",$page);
$tblLayOutB->paddingLeft(5);
define("tblLayOutB","tblLayOutB");

$tblLayOutSpcTr = new style("tblLayOutSpcTr",".","tblLayOutSpcTr",$page);
$tblLayOutSpcTr->paddingTop(15);
define("tblLayOutSpcTr","tblLayOutSpcTr");

$tblLayOutSpcTr2 = new style("tblLayOutSpcTr2",".","tblLayOutSpcTr2",$page);
$tblLayOutSpcTr2->paddingTop(15);
$tblLayOutSpcTr2->paddingRight(20);
define("tblLayOutSpcTr2","tblLayOutSpcTr2");

$tblLayOutSpcTr3 = new style("tblLayOutSpcTr3",".","tblLayOutSpcTr3",$page);
$tblLayOutSpcTr3->paddingTop(30);
define("tblLayOutSpcTr3","tblLayOutSpcTr3");

$division = new style("division",".","division",$page);
$division->backGroundColor(COLOR_BLUE);
$division->height(8);
$division->radius(3);
$division->boxShadow(2,2,8);
define("division","division");

$stlLytMenuSimple = new style("stlLytMenuSimple",".","tblLayOutMenuSimple",$page);
$stlLytMenuSimple->width(500);
$stlLytMenuSimple->paddingLeft(20);
$stlLytMenuSimple->borderLeft(3,"solid",COLOR_LIGHT_BLUE);
define("tblLayOutMenuSimple", "tblLayOutMenuSimple");

$bodyStyle = new style("bodyStyle","","body",$page);
$bodyStyle->setWebkitPrintColorAdjust();

# CLASS CSS - TEXTBOX
$textBoxStyle = new style("textBoxStyle",".","textBox",$page);
$textBoxStyle->position("relative");
$textBoxStyle->top(6);
$textBoxStyle->fontSize(14);
$textBoxStyle->radius(5);
$textBoxStyle->padding(8);
$textBoxStyle->color("rgb(0,60,120)");
$textBoxStyle->boxShadow(0,0,5,"rgb(150,150,150)");
$textBoxStyle->border(1,"solid","rgb(100,100,100)");
$textBoxStyle->setUpperCase();

$textBoxForTableStyle = new style("textBoxForTableStyle",".","textBoxForTable",$page);
$textBoxForTableStyle->margin(3);
$textBoxForTableStyle->top(0);

$textBoxExcelStyle = new style("textBoxExcelStyle",".","textBoxExcel",$page);
$textBoxExcelStyle->position("relative");
$textBoxExcelStyle->fontSize(14);
$textBoxExcelStyle->padding(5);
$textBoxExcelStyle->color("rgb(0,60,120)");
$textBoxExcelStyle->marginRight(-5);
$textBoxExcelStyle->marginTop(-1);
$textBoxExcelStyle->boxShadow();
$textBoxExcelStyle->border(1,"solid","rgb(120,120,120)");
$textBoxExcelStyle->outline(0);

$textBoxExcelTitleStyle = new style("textBoxExcelTitleStyle",".","textBoxExcelTitle",$page);
$textBoxExcelTitleStyle->position("relative");
$textBoxExcelTitleStyle->fontSize(14);
$textBoxExcelTitleStyle->padding(5);
$textBoxExcelTitleStyle->color("rgb(0,60,120)");
$textBoxExcelTitleStyle->marginRight(-5);
$textBoxExcelTitleStyle->marginTop(-1);
$textBoxExcelTitleStyle->boxShadow();
$textBoxExcelTitleStyle->border(1,"solid","rgb(120,120,120)");
$textBoxExcelTitleStyle->outline(0);
$textBoxExcelTitleStyle->fontWeight("bold");
$textBoxExcelTitleStyle->textAlign("center");

$textBoxForPrintStyle = new style("textBoxForPrintStyle",".","textBoxForPrint",$page);
$textBoxForPrintStyle->position("relative");
$textBoxForPrintStyle->fontSize(14);
$textBoxForPrintStyle->padding(8);
$textBoxForPrintStyle->color("rgb(255,255,255)");
$textBoxForPrintStyle->top(6);
$textBoxForPrintStyle->radius(3);
$textBoxForPrintStyle->backGroundColor("rgb(0,0,0)");
# FIM - CLASS CSS - TEXTBOX

# CLASS CSS - textBoxMultiLineMULTILINE
$textBoxMultiLineStyle = new style("textBoxMultiLineMultiLineStyle",".","textBoxMultiLine",$page);
$textBoxMultiLineStyle->position("relative");
$textBoxMultiLineStyle->top(6);
$textBoxMultiLineStyle->fontSize(14);
$textBoxMultiLineStyle->radius(3);
$textBoxMultiLineStyle->padding(8);
$textBoxMultiLineStyle->color("rgb(0,60,120)");
$textBoxMultiLineStyle->boxShadow(0,0,6,"rgb(80,80,80)");
$textBoxMultiLineStyle->border(0);
$textBoxMultiLineStyle->setUpperCase();

$textBoxMultiLineForTableStyle = new style("textBoxMultiLineForTableStyle",".","textBoxMultiLineForTable",$page);
$textBoxMultiLineForTableStyle->margin(3);
$textBoxMultiLineForTableStyle->top(0);

$textBoxMultiLineExcelStyle = new style("textBoxMultiLineExcelStyle",".","textBoxMultiLineExcel",$page);
$textBoxMultiLineExcelStyle->position("relative");
$textBoxMultiLineExcelStyle->fontSize(14);
$textBoxMultiLineExcelStyle->padding(5);
$textBoxMultiLineExcelStyle->color("rgb(0,60,120)");
$textBoxMultiLineExcelStyle->marginRight(-5);
$textBoxMultiLineExcelStyle->marginTop(-1);
$textBoxMultiLineExcelStyle->boxShadow();
$textBoxMultiLineExcelStyle->border(1,"solid","rgb(120,120,120)");
$textBoxMultiLineExcelStyle->outline(0);

$textBoxMultiLineExcelTitleStyle = new style("textBoxMultiLineExcelTitleStyle",".","textBoxMultiLineExcelTitle",$page);
$textBoxMultiLineExcelTitleStyle->position("relative");
$textBoxMultiLineExcelTitleStyle->fontSize(14);
$textBoxMultiLineExcelTitleStyle->padding(5);
$textBoxMultiLineExcelTitleStyle->color("rgb(0,60,120)");
$textBoxMultiLineExcelTitleStyle->marginRight(-5);
$textBoxMultiLineExcelTitleStyle->marginTop(-1);
$textBoxMultiLineExcelTitleStyle->boxShadow();
$textBoxMultiLineExcelTitleStyle->border(1,"solid","rgb(120,120,120)");
$textBoxMultiLineExcelTitleStyle->outline(0);
$textBoxMultiLineExcelTitleStyle->fontWeight("bold");
$textBoxMultiLineExcelTitleStyle->textAlign("center");

$textBoxMultiLineForPrintStyle = new style("textBoxMultiLineForPrintStyle",".","textBoxMultiLineForPrint",$page);
$textBoxMultiLineForPrintStyle->position("relative");
$textBoxMultiLineForPrintStyle->fontSize(14);
$textBoxMultiLineForPrintStyle->padding(8);
$textBoxMultiLineForPrintStyle->color("rgb(255,255,255)");
$textBoxMultiLineForPrintStyle->top(6);
$textBoxMultiLineForPrintStyle->radius(3);
$textBoxMultiLineForPrintStyle->backGroundColor("rgb(0,0,0)");
# FIM - CLASS CSS - TEXTBOXMULTILINE

# STANDARD
$htmlStyle = new style("htmlStyle","","html",$page);
$htmlStyle->height("100%");

$fontFace = new style("fontFace","@","font-face",$page);
$fontFace->fontFamily("myCalibri");
$fontFace->srcMulti("url('".@$PATH.@$PATHB."class/font/calibri/Calibri.ttf'),url('".@$PATH.@$PATHB."class/font/calibri/CALIBRIB.ttf'),url('".@$PATH.@$PATHB."class/font/calibri/CALIBRII.ttf'),url('".@$PATH.@$PATHB."class/font/calibri/CALIBRIZ.ttf')");

$bodyStyleB = new style("bodyStyleB","","body",$page);
$bodyStyleB->fontFamily("Calibri,myCalibri");
$bodyStyleB->fontSize(18);
#$bodyStyleB->color("rgb(80,80,80)");
$bodyStyleB->margin(0);

$aStyle = new style("aStyle","","a",$page);
$aStyle->textDecoration();
$aStyle->fontSize(22);

$aLinkStyle = new style("aLinkStyle","","a:link",$page);
$aLinkStyle->color("rgb(30,60,130)");

$aVisitedStyle = new style("aVisitedStyle","","a:visited",$page);
$aVisitedStyle->color("rgb(30,60,130)");

$aHoverStyle = new style("aHoverStyle","","a:hover",$page);
$aHoverStyle->color("rgb(50,150,255)");

$aBstyle = new style("aBstyle",".","ab",$page);
$aBstyle->textDecoration();
$aBstyle->color("rgb(50,150,200)");

$aBhoverStyle = new style("aBhoverStyle",".","ab:hover",$page);
$aBhoverStyle->textDecoration();
$aBhoverStyle->color("rgb(100,200,255)");

$h1h2h3h4h5Style = new style("h1h2h3h4h5Style","","h1,h2,h3,h4,h5",$page);
$h1h2h3h4h5Style->color("rgb(0,102,255)");

$questionStyle = new style("questionStyle",".","question",$page);
$questionStyle->color("rgb(220,20,20)");
$questionStyle->fontWeight("bold");
$questionStyle->fontSize(20);

$graficoBarraStyle = new style("graficoBarraStyle",".","graficoBarra",$page);
$graficoBarraStyle->width(50);
$graficoBarraStyle->radius(3);
$graficoBarraStyle->position("absolute");
$graficoBarraStyle->fontSize(14);
$graficoBarraStyle->cursor();
# FIM - STANDARD

# STYLE BOTÃO MENU
$btMenuStyle = new style("btMenuStyle",".","btMenu",$page);
$btMenuStyle->fontFamily("arial");
$btMenuStyle->height(35);
$btMenuStyle->lineHeight(35);
$btMenuStyle->cursor();
$btMenuStyle->float("left");
#$btMenuStyle->backGround(@$PATH."imagens/botao10.bmp");
$btMenuStyle->backGroundColor(COLOR_ULTRA_LIGHT_SILVER);
$btMenuStyle->color("rgb(50,50,50)");
$btMenuStyle->fontSize(14);
$btMenuStyle->fontWeight("bold");
$btMenuStyle->boxShadow(0,1,2,COLOR_DARK_SILVER);

$btMenuHoverStyle = new style("btMenuHoverStyle",".","btMenu:hover",$page);
$btMenuHoverStyle->color(COLOR_WHITE);
#$btMenuHoverStyle->backGround(@$PATH."imagens/botao11.bmp");
$btMenuHoverStyle->backGroundColor(COLOR_LIGHT_BLUE);
$btMenuHoverStyle->boxShadow(0,1,2,COLOR_DARK_BLUE);

$btMenuHomeStyle = new style("btMenuHomeStyle",".","btMenuHome",$page);
$btMenuHomeStyle->fontFamily("arial");
$btMenuHomeStyle->height(35);
$btMenuHomeStyle->lineHeight(35);
$btMenuHomeStyle->cursor();
$btMenuHomeStyle->float("left");
#$btMenuHomeStyle->backGround(@$PATH."imagens/botao08.bmp");
$btMenuHomeStyle->backGroundColor(COLOR_GREEN);
$btMenuHomeStyle->color("rgb(0,80,30)");
$btMenuHomeStyle->fontSize(14);
$btMenuHomeStyle->fontWeight("bold");
$btMenuHomeStyle->boxShadow(0,1,2,COLOR_DARK_GREEN);

$btMenuHomeHoverStyle = new style("btMenuHomeHoverStyle",".","btMenuHome:hover",$page);
$btMenuHomeHoverStyle->color(COLOR_WHITE);
$btMenuHomeHoverStyle->backGroundColor(COLOR_LIGHT_BLUE);
$btMenuHomeHoverStyle->boxShadow(0,1,2,COLOR_DARK_BLUE);

$btMenuVoltarStyle = new style("btMenuVoltarStyle",".","btMenuVoltar",$page);
$btMenuVoltarStyle->fontFamily("arial");
$btMenuVoltarStyle->height(35);
$btMenuVoltarStyle->lineHeight(35);
$btMenuVoltarStyle->cursor();
$btMenuVoltarStyle->float("left");
#$btMenuVoltarStyle->backGround(@$PATH."imagens/botao12.bmp");
$btMenuVoltarStyle->backGroundColor("rgb(255,205,30)");
$btMenuVoltarStyle->color("rgb(140,90,5)");
$btMenuVoltarStyle->fontSize(14);
$btMenuVoltarStyle->fontWeight("bold");
$btMenuVoltarStyle->boxShadow(0,1,2,COLOR_DARK_ORANGE);

$btMenuVoltarHoverStyle = new style("btMenuVoltarHoverStyle",".","btMenuVoltar:hover",$page);
$btMenuVoltarHoverStyle->color(COLOR_WHITE);
$btMenuVoltarHoverStyle->backGroundColor(COLOR_LIGHT_BLUE);
$btMenuVoltarHoverStyle->boxShadow(0,1,2,COLOR_DARK_BLUE);

$btMenuSairStyle = new style("btMenuSairStyle",".","btMenuSair",$page);
$btMenuSairStyle->fontFamily("arial");
$btMenuSairStyle->height(35);
$btMenuSairStyle->lineHeight(35);
$btMenuSairStyle->cursor();
$btMenuSairStyle->float("left");
#$btMenuSairStyle->backGround(@$PATH."imagens/botao09.bmp");
$btMenuSairStyle->backGroundColor(COLOR_RED);
$btMenuSairStyle->color("rgb(120,5,5)");
$btMenuSairStyle->fontSize(14);
$btMenuSairStyle->fontWeight("bold");
$btMenuSairStyle->boxShadow(0,1,2,"rgb(120,5,5)");

$btMenuSairHoverStyle = new style("btMenuSairHoverStyle",".","btMenuSair:hover",$page);
$btMenuSairHoverStyle->color(COLOR_WHITE);
$btMenuSairHoverStyle->backGroundColor(COLOR_LIGHT_BLUE);
$btMenuSairHoverStyle->boxShadow(0,1,2,COLOR_DARK_BLUE);
# FIM - STYLE BOTÃO MENU

# STYLE MSG BOX
$msgStyle = new style("msgStyle",".","msg",$page);
#$msgStyle->backGroundColor("rgb(10,40,60)");
#$msgStyle->boxShadow(0,4,20,"rgb(15,35,55)");
#$msgStyle->border(1,"solid","rgb(50,70,150)");

$msgCaptionStyle = new style("msgCaptionStyle",".","msgCaption",$page);
#$msgCaptionStyle->backGround(@$PATH."imagens/botao11.bmp");
$msgCaptionStyle->backGroundColor(COLOR_LIGHT_BLUE);
$msgCaptionStyle->backGroundSize("1px 40px");
$msgCaptionStyle->padding(5);
$msgCaptionStyle->radiusTopLeft(2);
$msgCaptionStyle->radiusTopRight(2);
$msgCaptionStyle->boxShadow(0,0,2,"rgb(70,70,70)");
$msgCaptionStyle->border(0,"solid","rgb(150,150,150)");
$msgCaptionStyle->color("rgb(240,240,240)");

$textoMsgStyle = new style("textoMsgStyle",".","textoMsg",$page);
$textoMsgStyle->padding(10);
$textoMsgStyle->paddingLeft(30);
$textoMsgStyle->paddingRight(30);
$textoMsgStyle->color("rgb(235,235,255)");
$textoMsgStyle->fontSize(28);
# FIM - STYLE MSG BOX

# STYLE BUTTON
$buttonStyle = new style("buttonStyle",".","button",$page);
$buttonStyle->position("relative");
$buttonStyle->fontFamily("arial");
$buttonStyle->radius(3);
$buttonStyle->height(28);
$buttonStyle->lineHeight(28);
$buttonStyle->cursor();
#$buttonStyle->backGround(@$PATH."imagens/btStandard01.bmp");
$buttonStyle->backGroundColor(COLOR_ULTRA_LIGHT_SILVER);
$buttonStyle->backGroundSize("1px 25px");
$buttonStyle->color("rgb(50,50,50)");
$buttonStyle->fontSize(14);
$buttonStyle->fontWeight("bold");
$buttonStyle->paddingLeft(12);
$buttonStyle->paddingRight(12);
$buttonStyle->boxShadow(0,0,5,"rgb(120,120,120)");
$buttonStyle->marginTop(1);
$buttonStyle->marginBottom(1);

$buttonHoverStyle = new style("buttonHoverStyle",".","button:hover",$page);
$buttonHoverStyle->color(COLOR_WHITE);
#$buttonHoverStyle->backGround(@$PATH."imagens/botao11.bmp");
$buttonHoverStyle->backGroundColor(COLOR_LIGHT_BLUE);
$buttonHoverStyle->boxShadow(0,0,1,"rgb(0,150,255)");

$bigButtonStyle = new style("bigButtonStyle",".","bigButton",$page);
$bigButtonStyle->position("relative");
$bigButtonStyle->fontFamily("arial");
$bigButtonStyle->radius(5);
$bigButtonStyle->height(34);
$bigButtonStyle->lineHeight(34);
$bigButtonStyle->cursor();
#$bigButtonStyle->backGround(@$PATH."imagens/btStandard01.bmp");
$bigButtonStyle->backGroundColor(COLOR_ULTRA_LIGHT_SILVER);
$bigButtonStyle->backGroundSize("1px 40px");
$bigButtonStyle->color("rgb(50,50,50)");
$bigButtonStyle->fontSize(14);
$bigButtonStyle->fontWeight("bold");
$bigButtonStyle->paddingLeft(12);
$bigButtonStyle->paddingRight(12);
$bigButtonStyle->boxShadow(0,0,5,"rgb(80,80,80)");
$bigButtonStyle->top(6);

$bigButtonHoverStyle = new style("bigButtonHoverStyle",".","bigButton:hover",$page);
$bigButtonHoverStyle->color(COLOR_WHITE);
#$bigButtonHoverStyle->backGround(@$PATH."imagens/botao11.bmp");
$bigButtonHoverStyle->backGroundColor(COLOR_LIGHT_BLUE);
$bigButtonHoverStyle->backGroundSize("1px 40px");
#$bigButtonHoverStyle->boxShadow(0,0,6,"rgb(0,150,255)");

$bigButtonDesStyle = new style("bigButtonDesStyle",".","bigButtonDes",$page);
$bigButtonDesStyle->position("relative");
$bigButtonDesStyle->fontFamily("arial");
$bigButtonDesStyle->radius(3);
$bigButtonDesStyle->height(34);
$bigButtonDesStyle->lineHeight(34);
$bigButtonDesStyle->cursor();
#$bigButtonDesStyle->backGround(@$PATH."imagens/btStandard01.bmp");
$bigButtonDesStyle->backGroundColor(COLOR_ULTRA_LIGHT_SILVER);
$bigButtonDesStyle->backGroundSize("1px 40px");
$bigButtonDesStyle->color("rgb(180,180,180)");
$bigButtonDesStyle->fontSize(14);
$bigButtonDesStyle->fontWeight("bold");
$bigButtonDesStyle->paddingLeft(12);
$bigButtonDesStyle->paddingRight(12);
$bigButtonDesStyle->boxShadow(0,0,1,"rgb(70,70,70)");
$bigButtonDesStyle->top(6);

$bigButtonDesHoverStyle = new style("bigButtonDesHoverStyle",".","bigButtonDes:hover",$page);
$bigButtonDesHoverStyle->color("rgb(180,180,180)");
#$bigButtonDesHoverStyle->backGround(@$PATH."imagens/btStandard01.bmp");
$bigButtonDesHoverStyle->backGroundColor(COLOR_ULTRA_LIGHT_SILVER);
$bigButtonDesHoverStyle->backGroundSize("1px 40px");
$bigButtonDesHoverStyle->boxShadow(0,0,1,"rgb(70,70,70)");

$buttonDisStyle = new style("buttonDisStyle",".","buttonDis",$page);
$buttonDisStyle->marginRight(10);

$buttonAtivoStyle = new style("buttonAtivoStyle",".","buttonAtivo",$page);
#$buttonAtivoStyle->backGround(@$PATH."imagens/botao12.bmp");
$buttonAtivoStyle->backGroundColor(COLOR_ORANGE);
$buttonAtivoStyle->backGroundSize("1px 40px");
$buttonAtivoStyle->color(COLOR_WHITE);
$buttonAtivoStyle->boxShadow(0,0,6,"rgb(255,150,0)");

$btGreenStyle = new style("btGreenStyle",".","btGreen",$page);
#$btGreenStyle->backGround(@$PATH."imagens/botao08.bmp");
$btGreenStyle->backGroundColor(COLOR_GREEN);
$btGreenStyle->backGroundSize("1px 25px");
$btGreenStyle->color("rgb(0,80,30)");

$btBlueStyle = new style("btBlueStyle",".","btBlue",$page);
$btBlueStyle->backGroundColor(COLOR_BLUE);
$btBlueStyle->backGroundSize("1px 25px");
$btBlueStyle->color(COLOR_DARK_BLUE);

$btYellowStyle = new style("btYellowStyle",".","btYellow",$page);
#$btYellowStyle->backGround(@$PATH."imagens/botao12.bmp");
$btYellowStyle->backGroundColor(COLOR_YELLOW);
$btYellowStyle->backGroundSize("1px 25px");
$btYellowStyle->color(COLOR_DARK_YELLOW_4);

$btRedStyle = new style("btRedStyle",".","btRed",$page);
#$btRedStyle->backGround(@$PATH."imagens/botao09.bmp");
$btRedStyle->backGroundColor(COLOR_RED);
$btRedStyle->backGroundSize("1px 25px");
$btRedStyle->color("rgb(120,5,5)");

$bigBtGreenStyle = new style("bigBtGreenStyle",".","bigBtGreen",$page);
#$bigBtGreenStyle->backGround(@$PATH."imagens/botao08.bmp");
$bigBtGreenStyle->backGroundColor(COLOR_GREEN);
$bigBtGreenStyle->backGroundSize("1px 33px");
$bigBtGreenStyle->color("rgb(0,80,30)");
#$bigBtGreenStyle->boxShadow(0,0,2,"rgb(70,170,70)");

$bigBtGreenHoverStyle = new style("bigBtGreenHoverStyle",".","bigBtGreen:hover",$page);
#$bigBtGreenHoverStyle->backGround(@$PATH."imagens/botao08.bmp");
#$bigBtGreenHoverStyle->backGroundColor(COLOR_LIGHT_GREEN);
$bigBtGreenHoverStyle->backGroundSize("1px 33px");
$bigBtGreenHoverStyle->color("rgb(255,255,255)");
#$bigBtGreenHoverStyle->boxShadow(2,3,18,"rgb(50,150,100)");

$bigBtBlueStyle = new style("bigBtBlueStyle",".","bigBtBlue",$page);
$bigBtBlueStyle->backGroundColor(COLOR_BLUE);
$bigBtBlueStyle->backGroundSize("1px 33px");
$bigBtBlueStyle->color(COLOR_WHITE);
$bigBtBlueStyle->border(1,"solid",COLOR_BLUE);

$bigBtBlueHoverStyle = new style("bigBtBlueHoverStyle",".","bigBtBlue:hover",$page);
$bigBtBlueHoverStyle->backGroundSize("1px 33px");
$bigBtBlueHoverStyle->color("rgb(255,255,255)");

$bigBtYellowStyle = new style("bigBtYellowStyle",".","bigBtYellow",$page);
#$bigBtYellowStyle->backGround(@$PATH."imagens/botao12.bmp");
$bigBtYellowStyle->backGroundColor(COLOR_YELLOW);
$bigBtYellowStyle->backGroundSize("1px 33px");
$bigBtYellowStyle->color(COLOR_DARK_YELLOW_4);
#$bigBtYellowStyle->boxShadow(0,0,6,"rgb(200,200,70)");

$bigBtYellowHoverStyle = new style("bigBtYellowHoverStyle",".","bigBtYellow:hover",$page);
#$bigBtYellowHoverStyle->backGround(@$PATH."imagens/botao12.bmp");
$bigBtYellowHoverStyle->backGroundSize("1px 33px");
$bigBtYellowHoverStyle->color("rgb(255,255,255)");
#$bigBtYellowHoverStyle->boxShadow(2,3,10,"rgb(150,150,0)");

$bigBtRedStyle = new style("bigBtRedStyle",".","bigBtRed",$page);
#$bigBtRedStyle->backGround(@$PATH."imagens/botao09.bmp");
$bigBtRedStyle->backGroundColor(COLOR_RED);
$bigBtRedStyle->backGroundSize("1px 33px");
$bigBtRedStyle->color("rgb(120,5,5)");
#$bigBtRedStyle->boxShadow(0,0,2,"rgb(200,10,10)");

$bigBtRedHoverStyle = new style("bigBtRedHoverStyle",".","bigBtRed:hover",$page);
#$bigBtRedHoverStyle->backGround(@$PATH."imagens/botao09.bmp");
$bigBtRedHoverStyle->backGroundSize("1px 33px");
$bigBtRedHoverStyle->color("rgb(255,255,255)");
#$bigBtRedHoverStyle->boxShadow(0,0,1,COLOR_DARK_BLUE);
# FIM - STYLE BUTTON

# STYLE TABLE
$tableStyle = new style("tableStyle",".","table",$page);
$tableStyle->borderRight(1,"solid","rgb(210,210,250)");
$tableStyle->borderBottom(1,"solid","rgb(210,210,250)");
$tableStyle->boxShadow(0,0,5);
$tableStyle->cursor();

$tdStyle = new style("tdStyle",".","td",$page);
$tdStyle->borderLeft(1,"solid","rgb(210,210,250)");
$tdStyle->paddingLeft(10);
$tdStyle->paddingRight(10);
$tdStyle->borderTop(1,"solid","rgb(210,210,250)");
#$tdStyle->boxShadow(1,1,1,"rgb(190,190,250)");

$firstTrStyle = new style("firstTrStyle",".","firstTr",$page);
$firstTrStyle->height(30);
$firstTrStyle->textAlign("center");
$firstTrStyle->fontWeight("bold");
$firstTrStyle->backGroundColor("rgb(30,100,140)");
$firstTrStyle->color("rgb(239,238,238)");

$trTitleStyle = new style("trTitleStyle",".","trTitle",$page);
$trTitleStyle->height(50);

$colorTrAStyle = new style("colorTrAStyle",".","colorTrA",$page);
$colorTrAStyle->backGroundColor("rgb(240,240,250)");

$colorTrAHoverStyle = new style("colorTrAHoverStyle",".","colorTrA:hover",$page);
$colorTrAHoverStyle->backGroundColor("rgb(40,120,220)");
$colorTrAHoverStyle->color(COLOR_WHITE);

$colorTrBStyle = new style("colorTrBStyle",".","colorTrB",$page);
$colorTrBStyle->backGroundColor("rgb(220,220,250)");

$colorTrBHoverStyle = new style("colorTrBHoverStyle",".","colorTrB:hover",$page);
$colorTrBHoverStyle->backGroundColor("rgb(40,120,220)");
$colorTrBHoverStyle->color(COLOR_WHITE);

$colorTrCStyle = new style("colorTrCStyle",".","colorTrC",$page);
$colorTrCStyle->backGroundColor("rgb(120,180,240)");
$colorTrCStyle->color("rgb(55,55,55)");

$colorTrCHoverStyle = new style("colorTrCHoverStyle",".","colorTrC:hover",$page);
$colorTrCHoverStyle->backGroundColor("rgb(40,120,220)");
$colorTrCHoverStyle->color(COLOR_WHITE);

$colorTrDStyle = new style("colorTrDStyle",".","colorTrD",$page);
$colorTrDStyle->backGroundColor("rgb(80,140,220)");
$colorTrDStyle->color("rgb(55,55,55)");

$colorTrDHoverStyle = new style("colorTrDHoverStyle",".","colorTrD:hover",$page);
$colorTrDHoverStyle->backGroundColor("rgb(40,120,220)");
$colorTrDHoverStyle->color(COLOR_WHITE);

$orderByThisColumnStyle = new style("orderByThisColumnStyle",".","orderByThisColumn",$page);
$orderByThisColumnStyle->backGroundColor("rgb(80,200,100)");

$titleTableStyle = new style("titleTableStyle",".","titleTable",$page);
$titleTableStyle->fontSize(24);
$titleTableStyle->color(COLOR_WHITE);
#$titleTableStyle->paddingRight(30);
#$titleTableStyle->paddingLeft(30);

$baseFormDataTableAdapterStyle = new style("baseFormDataTableAdapterStyle",".","baseFormDataTableAdapter",$page);
$baseFormDataTableAdapterStyle->position("relative");
#$baseFormDataTableAdapterStyle->left(10);
$baseFormDataTableAdapterStyle->top(0);

$filteredColumnStyle = new style("filteredColumnStyle",".","filteredColumn",$page);
$filteredColumnStyle->backGroundColor("rgb(220,40,20)");

$textContPageStyle = new style("textContPageStyle",".","textContPage",$page);
$textContPageStyle->color(COLOR_WHITE);
$textContPageStyle->left(80);
$textContPageStyle->width(80);
$textContPageStyle->fontSize(18);
$textContPageStyle->float("left");

$btTableStyle = new style("btTableStyle",".","btTable",$page);
#$btTableStyle->position("relative");
#$btTableStyle->top(8);
$btTableStyle->fontFamily("arial");
$btTableStyle->radius(3);
$btTableStyle->height(25);
$btTableStyle->lineHeight(25);
$btTableStyle->cursor();
#$btTableStyle->backGround(@$PATH."imagens/btStandard01.bmp");
$btTableStyle->backGroundColor(COLOR_ULTRA_LIGHT_SILVER);
$btTableStyle->backGroundSize("1px 25px");
$btTableStyle->color("rgb(50,50,50)");
$btTableStyle->fontSize(14);
$btTableStyle->fontWeight("bold");
$btTableStyle->boxShadow(0,0,2,"rgb(70,70,70)");
$btTableStyle->width(80);
$btTableStyle->float("left");

$btTableHoverStyle = new style("btTableHoverStyle",".","btTable:hover",$page);
$btTableHoverStyle->color(COLOR_WHITE);
#$btTableHoverStyle->backGround(@$PATH."imagens/botao11.bmp");
$btTableHoverStyle->backGroundColor(COLOR_LIGHT_BLUE);
$btTableHoverStyle->boxShadow(0,0,6,"rgb(0,150,255)");

$btTableAStyle = new style("btTableAStyle",".","btTableA",$page);

$btTableBStyle = new style("btTableBStyle",".","btTableB",$page);

$dpStyle = new style("dpStyle",".","dp",$page);
$dpStyle->paddingRight(30);
$dpStyle->paddingBottom(30);

$tdrStyle = new style("tdrStyle",".","tdr",$page);
$tdrStyle->paddingRight(20);
# FIM - STYLE TABLE

# ESTILO DA TABELA DE DATA
# CLASSE BASE
$stl = new style("stlLytData",".","stlLytData",$page);
$tamPadrao = 30;
$stl->width($tamPadrao);
$stl->height($tamPadrao);
$stl->textAlign("center");
$stl->border(1,"solid",COLOR_WHITE);
# FIM CLASSE BASE

# ESTILO DA CELULA DE HOJE
$stl = new style("stlLytDataHoje",".","stlLytDataHoje",$page);
$stl->backGroundColor(COLOR_ORANGE);
$stl->cursor();

$stl = new style("stlLytDataHojeHover",".","stlLytDataHoje:hover",$page);
$stl->border(1,"solid",COLOR_DARK_RED);
$stl->boxShadow(0,0,2,COLOR_RED);
# FIM - ESTILO DA CELULA DE HOJE

# ESTILO DAS DEMAIS CELULAS A
$stl = new style("stlLytDataCellA",".","stlLytDataCellA",$page);
$stl->backGroundColor(COLOR_ULTRA_LIGHT_SILVER);
$stl->cursor();

$stl = new style("stlLytDataCellAHover",".","stlLytDataCellA:hover",$page);
$stl->border(1,"solid",COLOR_SILVER);
$stl->boxShadow(0,0,2,COLOR_DARK_SILVER);
# FIM - ESTILO DAS DEMAIS CELULAS A

# ESTILO DAS DEMAIS CELULAS B
$stl = new style("stlLytDataCellB",".","stlLytDataCellB",$page);
$stl->backGroundColor(COLOR_LIGHT_SILVER);
$stl->cursor();

$stl = new style("stlLytDataCellBHover",".","stlLytDataCellB:hover",$page);
$stl->border(1,"solid",COLOR_DARK_SILVER);
$stl->boxShadow(0,0,2,COLOR_BLACK);
# FIM - ESTILO DAS DEMAIS CELULAS B

# ESTILO DAS DEMAIS CELULAS C
$stl = new style("stlLytDataCellC",".","stlLytDataCellC",$page);
$stl->backGroundColor(COLOR_DARK_BLUE);
$stl->color(COLOR_WHITE);
$stl->cursor();
# FIM - ESTILO DAS DEMAIS CELULAS C

# ESTILO DAS DEMAIS CELULAS D
$stl = new style("stlLytDataCellD",".","stlLytDataCellD",$page);
$stl->backGroundColor(COLOR_GREEN);
$stl->cursor();

$stl = new style("stlLytDataCellDHover",".","stlLytDataCellD:hover",$page);
$stl->border(1,"solid",COLOR_LIGHT_GREEN);
$stl->boxShadow(0,0,2,COLOR_DARK_GREEN);
# FIM - ESTILO DAS DEMAIS CELULAS B
# FIM - ESTILO DA TABELA DE DATA

$stlAta = new style("stlAta",".","ata",$page);
$stlAta->width("95%");

$stlSpc = new style("stlSpc",".","spc",$page);
$stlSpc->height(2);
$stlSpc->width("95%");
$stlSpc->backGroundColor("rgb(70,70,70)");

$piscaKeyFrame = new style("piscaKeyFrameStyle","","@-webkit-keyframes pisca",$page);
$piscaKeyFrame->keyframePisca();

$pisca = new style("piscaStyle",".","pisca",$page);
$pisca->webkitTransition(".5s");
$pisca->webkitAnimation("pisca 1s alternate infinite linear");

$bom = new style("bom",".","bom",$page);
$bom->backGroundColor(COLOR_GREEN);
$bom->color(COLOR_WHITE);

$medio = new style("medio",".","medio",$page);
$medio->backGroundColor(COLOR_ORANGE);
$medio->color(COLOR_BLACK);

$ruim = new style("ruim",".","ruim",$page);
$ruim->backGroundColor(COLOR_RED);
$ruim->color(COLOR_WHITE);