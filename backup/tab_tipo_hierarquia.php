<?php
$tab_qtd_colunas = 2;
$tab_div_colunas = 33;
$tab_colunas = array("Id", "Descrição");
$tab_nome = "Tipo Hierarquia";
$tab_select = "select id, ds_tipo_hierarquia from tipo_hierarquia t order by 2";
$tab_insert = "insert into tipo_hierarquia (ds_tipo_hierarquia) values ('$ds_tab')";
$tab_update = "update tipo_hierarquia set ds_tipo_hierarquia = '".u8d($ds_tab)."' where id = $id_tab";
$tab_delete = "delete from tipo_hierarquia where  id = $id_tab";
$inputTab 				= "";
$editarTab				= "";
$alteraTab				= "";
$incluiTab				= "";
include_once("tab_tabelas.php");
?>