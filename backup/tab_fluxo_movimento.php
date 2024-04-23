<?php
$tab_qtd_colunas = 3;
$tab_div_colunas = 25;
$tab_colunas = array("Id", "Descrição", "Símbolo");
$tab_nome = "Fluxo Movimento";
$tab_select = "select id, ds_fluxo_movimento, simbolo from fluxo_movimento order by 2";
$tab_insert = "insert into fluxo_movimento (ds_fluxo_movimento, simbolo) values ('".u8d($ds_tab)."', '".u8d($simbolo)."')";
$tab_update = "update fluxo_movimento set ds_fluxo_movimento = '".u8d($ds_tab)."', simbolo = '".u8d($simbolo)."' where id = $id_tab";
$tab_delete = "delete from fluxo_movimento where id = $id_tab";
$inputTab 				= "<br><br><label>Símbolo<input type=text name=simbolo id=simbolo size=3 value=$simbolo></label>";
$editarTab				= ", p_simbolo";
$alteraTab				= "el('simbolo').value = p_simbolo;";
$incluiTab				= "el('simbolo').value = '';";
include_once("tab_tabelas.php");
?>