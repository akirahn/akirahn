<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qFluxoMensal = "select dt_fluxo, fluxo_tipo_id, fluxo_movimento_id, format(vl_fluxo, 2, 'de_DE'), membro_id, date_format(dt_competencia, '%Y-%m'), obs from fluxo where id_fluxo = $id_fluxo";
	$fluxoMensal = pesquisa($qFluxoMensal);
	$txt = "";
	for($a=0;$a<count($fluxoMensal);$a++) { $txt .= ";" . u8($fluxoMensal[$a]); }
	e($txt);
?>