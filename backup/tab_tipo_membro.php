<?php
$tab_qtd_colunas = 2;
$tab_div_colunas = 33;
$tab_colunas 			= array("Id", "Descrição");
$tab_nome 				= "Tipo Membro";
$tab_select 			= "select id, ds_tipo_membro from tipo_membro order by 2";
$tab_insert 			= "insert into tipo_membro (ds_tipo_membro) values ('".u8d($ds_tab)."')";
$tab_update 			= "update tipo_membro set ds_tipo_membro = '".u8d($ds_tab)."' where id = $id_tab";
$tab_delete 			= "delete from tipo_membro where  id = $id_tab";
$inputTab 				= "";
$editarTab				= "";
$alteraTab				= "";
$incluiTab				= "";
include_once("tab_tabelas.php");
?>