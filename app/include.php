<?php
	include_once("../include.php");
	if (!isset($menu_off)) { $menu_off = 0 ; }
	if ($menu_off == 0)  {
		include_once("menu.php");		
	}
	$dom_cabeca_grau = ["1", "Fraca", "2", u8("Média"), "3", "Forte", "4", "Intensa"];
	$dom_cabeca_grau_alivio = ["1", "Total", "2", "Parcial", "3", "Nenhum"];
?>

