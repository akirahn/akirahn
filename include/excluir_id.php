﻿<?php
	include_once("include_bd.php");

	/*
select concat('  $tabela_exclusao', rpad(concat('["', table_name,'"]'), 30, ' '), ' = "', column_name, '";') lista
from information_schema.columns c
where c.table_schema = 'centrocsn'
and c.column_key = 'PRI'
order by 1;	
	*/
	$tabela_exclusao["app_cabeca"]                 = "id_cabeca";
	$tabela_exclusao["app_cab_remedio"]            = "id";
	$tabela_exclusao["app_carro"]                  = "id_carro";
	$tabela_exclusao["app_combustivel"]            = "id_combustivel";
	$tabela_exclusao["app_series"]                 = "id_series";
	$tabela_exclusao["app_tarefas"]                = "id_tarefa";
	$tabela_exclusao["festa_anual"]                = "id";
	$tabela_exclusao["festa_vela"]                 = "id";
	$tabela_exclusao["fluxo"]                      = "id_fluxo";
	$tabela_exclusao["fluxo_conta"]                = "id";
	$tabela_exclusao["fluxo_movimento"]            = "id";
	$tabela_exclusao["fluxo_tipo"]                 = "id";
	$tabela_exclusao["gst_competencia"]            = "id";
	$tabela_exclusao["gst_gastos"]                 = "id";
	$tabela_exclusao["gst_gastos_quem"]            = "id";
	$tabela_exclusao["gst_gastos_tag"]             = "fk_gasto";
	$tabela_exclusao["gst_gastos_tag"]             = "fk_tag";
	$tabela_exclusao["gst_parcelas"]               = "id";
	$tabela_exclusao["gst_tab_forma_pagto"]        = "id";
	$tabela_exclusao["gst_tab_grupo"]              = "id";
	$tabela_exclusao["gst_tab_pagto"]              = "id";
	$tabela_exclusao["gst_tab_subtipo"]            = "id";
	$tabela_exclusao["gst_tab_tag"]                = "id";
	$tabela_exclusao["gst_tab_tipo"]               = "id";
	$tabela_exclusao["lst_lista"]               	 = "id";
	$tabela_exclusao["lst_tab_grupo"]              = "id";
	$tabela_exclusao["lst_tab_item"]               = "id";
	$tabela_exclusao["mae_ajuda"]                  = "id_ajuda";
	$tabela_exclusao["mae_parcela"]                = "id";
	$tabela_exclusao["mae_pessoa"]                 = "id_pessoa";
	$tabela_exclusao["membro"]                     = "id";
	$tabela_exclusao["menu"]                       = "id";
	$tabela_exclusao["menu_grupo"]                 = "id";
	$tabela_exclusao["rat_cadastro"]               = "id";
	$tabela_exclusao["rat_membro"]	               = "id";
	$tabela_exclusao["rat_parcela"]	               = "id";
	$tabela_exclusao["rat_parcela_gastos"]         = "id";
	$tabela_exclusao["rat_parcela_fluxo"]          = "id";
	$tabela_exclusao["rat_tab_tipo"]               = "id";
	$tabela_exclusao["rateio"]			               = "id";
	$tabela_exclusao["tab_cfg"]	                   = "id";
	$tabela_exclusao["tab_dias"]                   = "id_dia";
	$tabela_exclusao["tab_festas"]                 = "id";
	$tabela_exclusao["tab_meses"]                  = "id";
	$tabela_exclusao["tab_quem"]                   = "id";
	$tabela_exclusao["tipo_hierarquia"]            = "id";
	$tabela_exclusao["tipo_membro"]                = "id";
	$tabela_exclusao["tipo_situacao"]              = "id";
	
	if ($p_exclusao_opcao == "E" and $p_exclusao_id <> "" ) {
		switch($p_exclusao_tabela) {
			case "app_combustivel":
				$qExclusao = "delete from gst_gastos where id in (select fk_gastos from $p_exclusao_tabela where $tabela_exclusao[$p_exclusao_tabela] = $p_exclusao_id)";
				$resultado = executa_sql($qExclusao, "Exclusão Gastos/Comsbutível ($p_exclusao_id) efetuada com sucesso<br>");
				e($resultado);
				break;
		}
		$qExclusao = "delete from $p_exclusao_tabela where $tabela_exclusao[$p_exclusao_tabela] = $p_exclusao_id";
		$resultado = executa_sql($qExclusao, "Exclusão ($p_exclusao_id) efetuada com sucesso");
		e($resultado);
	}
?>