<?php
# Config
$LOCAL = 1;
if(!@$REPORTING_ERROR){
	error_reporting(0);
}

session_save_path(@$PATH.@$PATHB."TMP");

#date_default_timezone_set("America/Sao_Paulo");# PARA HORARIO NORMAL

date_default_timezone_set("America/Fortaleza");# PARA HORARIO DE VER�O