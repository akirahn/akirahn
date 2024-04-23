<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qFestaAnual = "select fk_tab_festas, nr_ano, dt_pagto, dt_festa, format(vl_festa, 2, 'de_DE'), format(vl_vela_medium, 2, 'de_DE'), format(vl_vela_outros, 2, 'de_DE') from festa_anual where id = $id_festa";
	$festaAnual = pesquisa($qFestaAnual);
	$txt = "";
	for($a=0;$a<count($festaAnual);$a++) { $txt .= ";" . u8($festaAnual[$a]); }
	e($txt);
?>