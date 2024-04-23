<?php
$tab_qtd_colunas = 2;
$tab_div_colunas = 33;
$tab_colunas 			= array("Id", "Descrição");
$tab_nome 				= "Tipo Situação";
$tab_select 			= "select id, ds_tipo_situacao from tipo_situacao order by 2";
$tab_insert 			= "insert into tipo_situacao (ds_tipo_situacao) values ('".u8d($ds_tab)."')";
$tab_update 			= "update tipo_situacao set ds_tipo_situacao = '".u8d($ds_tab)."' where id = $id_tab";
$tab_delete 			= "delete from tipo_situacao where  id = $id_tab";
$inputTab 				= "";
$editarTab				= "";
$alteraTab				= "";
$incluiTab				= "";
include_once("tab_tabelas.php");
?>