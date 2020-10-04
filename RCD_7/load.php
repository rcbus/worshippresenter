<?php
#namespace RCD_7;

function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

$TIME_LOAD_START = microtime_float();  

$VERSAO = "7.18.02";
$PORT = ":8090";

if($_SERVER['SERVER_NAME']=="localhost" || $_SERVER['SERVER_NAME']=="192.168.1.5"){
	$REPORTING_ERROR = 1;
}else{
	$REPORTING_ERROR = 0;
}

ini_set('default_charset','UTF-8');

if(!isset($REPEAT_FROM_GET)){
	$REPEAT_FROM_GET = true;
}

$currentInclude = 1;

include_once 'config.php';
include_once 'generic.php';
include_once 'page.php';
include_once 'session.php';
include_once 'head.php';
include_once 'body.php';
include_once 'style.php';
include_once 'space.php';
include_once 'java.php';
include_once 'java_command.php';
include_once 'form.php';
include_once 'textBox.php';
include_once 'textBoxMultiLine.php';
include_once 'comboBox.php';
include_once 'button.php';
include_once 'dataBase.php';
include_once 'iDataBase.php';
include_once 'classTable.php';

# FULL LOAD
include_once 'color.php';
include_once 'newStyle.php';
include_once 'dataBase_support.php';
include_once 'dataBase_insert.php';
include_once 'dataBase_listColumn.php';
include_once 'dataBase_listDb.php';
include_once 'dataBase_listTable.php';
include_once 'dataBase_select.php';
include_once 'dataBase_update.php';
include_once 'dataBase_delete.php';
include_once 'dataTableAdapter.php';
include_once 'iframe.php';
include_once 'media.php';
include_once 'keyFrame.php';
include_once 'newClassTable.php';
include_once 'bootstrap.php';
include_once 'img.php';
include_once 'file.php';
include_once 'classTime.php';
include_once 'ftp.php';
# FIM - FULL LOAD