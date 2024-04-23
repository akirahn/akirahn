<?php
$tab_qtd_colunas = 4;
$tab_div_colunas = 20;
$tab_colunas = array("Id", "Descrição", "Dia", "Mês");
$tab_nome = "Festas";
$tab_select = "select id, ds_festas, nr_dia, fk_mes from tab_festas order by 2";
$tab_insert = "insert into tab_festas (ds_festas, nr_dia, fk_mes) values ('".u8d($ds_tab)."', $nr_dia, $fk_mes)";
$tab_update = "update tab_festas set ds_festas = '".u8d($ds_tab)."', fk_mes = $fk_mes, nr_dia = $nr_dia  where id = $id_tab";
$tab_delete = "delete from tab_festas where  id = $id_tab";
$inputTab 				= "<br><br><label>Dia <input type=text name=nr_dia id=nr_dia value='$nr_dia'></label><br><br><label>Mês <input type=text name=fk_mes id=fk_mes value='$fk_mes'></label>";
$editarTab				= ", p_nr_dia, p_fk_mes";
$alteraTab				= "el('fk_mes').value = p_fk_mes;
										 el('nr_dia').value = p_nr_dia;";
$incluiTab				= "el('nr_dia').value = '';el('fk_mes').value = '';";
include_once("tab_tabelas.php");
?>