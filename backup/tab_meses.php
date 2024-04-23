<?php
$tab_qtd_colunas = 3;
$tab_div_colunas = 25;
$tab_colunas = array("Id", "Descrição");
$tab_nome = "Meses";
$tab_select = "select id, ds_mes, sg_mes from tab_meses t order by 2";
$tab_insert = "insert into tab_meses (ds_mes, sg_mes) values ('".u8d($ds_tab)."', '".u8d($sg_mes)."')";
$tab_update = "update tab_meses set ds_mes = '".u8d($ds_tab)."', sg_mes = '".u8d($sg_mes)."'  where id = $id_tab";
$tab_delete = "delete from tab_meses where  id = $id_tab";
$inputTab 				= "	<br><br><label>Sigla <input type=text name=sg_mes id=sg_mes value='$sg_mes'></label>";
$editarTab				= ", p_sg_mes";
$alteraTab				= "el('sg_mes').value = p_sg_mes;";
$incluiTab				= "el('sg_mes').value = '';";
include_once("tab_tabelas.php");
?>