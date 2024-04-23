<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qTabela = "SELECT g.id, dt_gasto, format(vl_gasto, 2, 'de_DE'), s.fk_tipo, fk_movimento, obs, fk_subtipo, fk_pagto
FROM gst_gastos g
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
where g.id = $id_gasto";
	$tabela = pesquisa($qTabela);
	$txt = "";
	for($a=0;$a<count($tabela);$a++) { $txt .= ";" . u8($tabela[$a]); }
	e($txt);
?>