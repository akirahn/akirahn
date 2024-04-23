<?php
$tab_qtd_colunas = 5;
$tab_div_colunas = 16;
$tab_colunas 			= array("Id", "Descrição", "Ordem", "Grupo", "Página");
$tab_nome 				= "Menu";
$tab_select 			= "select id, ds_menu, nr_ordem, menu_grupo_id, pagina from menu t order by nr_ordem";
$tab_insert 			= "insert into menu (ds_menu, nr_ordem, menu_grupo_id, pagina) values ('".u8d($ds_tab)."', $nr_ordem, $menu_grupo_id, '".u8d($pagina)."')";
$tab_update 			= "update menu set ds_menu = '".u8d($ds_tab)."', nr_ordem = $nr_ordem, menu_grupo_id = $menu_grupo_id, pagina = '".u8d($pagina)."'  where id = $id_tab";
$tab_delete 			= "delete from menu where  id = $id_tab";
$qGrupo 					= "select id, ds_menu_grupo from menu_grupo order by nr_ordem";
//if ($menu_grupo_id == "") { $menu_grupo_id = 1; }
$inputTab 				= "<br><br><label>Ordem<input type=text name=nr_ordem id=nr_ordem inputmode=numeric size=3 value=$nr_ordem></label>
										 <br><br><select name=menu_grupo_id id=menu_grupo_id>".processaSelect($qGrupo, "menu_grupo_id", $menu_grupo_id)."</select><br><br>
										 <label>Página<input type=text name=pagina id=pagina size=30 value='$pagina'></label>";
$editarTab				= ", p_nr_ordem, p_menu_grupo_id, p_pagina";
$alteraTab				= "el('nr_ordem').value = p_nr_ordem; 
										 el('menu_grupo_id').value = p_menu_grupo_id; 
										 el('pagina').value = p_pagina;";
$incluiTab				= "el('nr_ordem').value = ''; 
										 el('menu_grupo_id').value = ''; 
										 el('pagina').value = '';";
include_once("tab_tabelas.php");
?>