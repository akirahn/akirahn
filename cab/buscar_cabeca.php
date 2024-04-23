<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qTabela = "SELECT id_cabeca, dt_cabeca, time_format(hr_cabeca,'%H:%i'), nr_grau, fk_remedio, nr_grau_alivio, fk_quem FROM app_cabeca a where id_cabeca = $id_cabeca";
	$tabela = pesquisa($qTabela);
	$txt = "";
	for($a=0;$a<count($tabela);$a++) { $txt .= ";" . u8($tabela[$a]); }
	e($txt);
?>