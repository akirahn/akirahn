<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qTabela = "SELECT concat(';',fk_quem) FROM gst_gastos_quem g where fk_gasto = $id_gasto";
	$txt = "";
	$b1 = new bd;
	$b1->prepara($qTabela);
	while($row = $b1->consulta()){
		$txt .= $row[0];
	}
	e($txt);
?>