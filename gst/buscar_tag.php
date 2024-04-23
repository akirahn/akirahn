<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qTabela = "SELECT concat(';',fk_tag) FROM gst_tab_subtipo s where fk_tipo = $fk_tipo";
	$txt = "";
	$b1 = new bd;
	$b1->prepara($qTabela);
	while($row = $b1->consulta()){
		$txt .= $row[0];
	}
	e($txt);
?>