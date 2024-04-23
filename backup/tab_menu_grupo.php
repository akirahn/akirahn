<?php
$tab_qtd_colunas 	= 3;
$tab_div_colunas 	= 25;
$tab_colunas 			= array("Id", "Descrição", "Ordem");
$tab_nome 				= "Menu Grupo";
$tab_select 			= "select id, ds_menu_grupo, nr_ordem FROM menu_grupo t order by 2";
$tab_insert 			= "insert into menu_grupo (ds_menu_grupo, nr_ordem) values ('$ds_tab', '$nr_ordem')";
$tab_update 			= "update menu_grupo set ds_menu_grupo = '".u8d($ds_tab)."', nr_ordem = '$nr_ordem' where id = $id_tab";
$tab_delete 			= "delete from menu_grupo where  id = $id_tab";
$inputTab 				= "<br><br><label>Ordem <input type=text name=nr_ordem id=nr_ordem inputmode=numeric size=3 value=$nr_ordem></label>";
$editarTab				= ", p_nr_ordem";
$alteraTab				= "el('nr_ordem').value = p_nr_ordem;";
$incluiTab				= "el('nr_ordem').value = '';";
include_once("tab_tabelas.php");
?>