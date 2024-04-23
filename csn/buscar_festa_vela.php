<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qFestaVela = "select fk_festa_anual, dt_venda, qt_vela, fk_membro, fk_fluxo, sn_doacao from festa_vela where id = $id_festa";
	$festaVela = pesquisa($qFestaVela);
	$txt = "";
	for($a=0;$a<count($festaVela);$a++) { $txt .= ";" . u8($festaVela[$a]); }
	e($txt);
?>