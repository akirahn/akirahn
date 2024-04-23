﻿<?php
$tituloPagina = "Cadastro";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_rateio(p_id_rateio) {
		$("#nome_frm_modal").val("frm_cad_rateio");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_rateio.php?p_edicao_opcao=PA&p_edicao_id="+p_id_rateio);
	}
//--------------------------------------------------------------------------------------------------
	function incluir_rateio() {
		$("#nome_frm_modal").val("frm_cad_rateio");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_rateio.php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
	function abrir_rateio(p_id_rateio) {
		$("#nome_frm_modal").val("frm_cad_rateio");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_parcelas.php?p_edicao_id="+p_id_rateio);
	}
//--------------------------------------------------------------------------------------------------
	function excluir_rateio(p_id_rateio) {
		excluir_id(p_id_rateio, 'rat_cadastro', 'frm_cad_rateio');
	}
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $spc, $a, $ico_editar, $ico_excluir, $c, $ico_incluir, $subtotal, $qTpPagamento, $ico_check, $ico_proibido, $ico_abrir;
	for($i=0; $i < $a; $i++) {
		if ($i == 0) {
/*			
			e("<th align=center colspan=4><b>".u8($linhas[$i][1])."</b></th>");
			$classe = ($subtotal < 0 ? "class=negativo" : "class=positivo");
			if ($subtotal < 0) { $subtotal = $subtotal * (-1); }
			e("<th align=center $classe>".nformat($subtotal)."</th>");
			e("<th></th>");
			e("</tr>");
*/			

			e("<th align=center>Data</th>");
			e("<th align=center>R$</th>");
			e("<th align=center>Parcela</th>");
			e("<th align=center>Conta</th>");
			e("<th class=acao>");
			e("<button onclick=\"incluir_rateio();\">$ico_incluir</button>");
			e("</th>");
			e("</tr>");
		}
		$ativo = ($linhas[$i][8] == 1 ? $ico_check : $ico_proibido);
		// $classe = ($linhas[$i][4] == 2 ? "class=negativo" : "");
		// e("<td align=center colspan=3>".u8($linhas[$i][1])."</td>");
		// e("<td align=center colspan=3>".u8($linhas[$i][2])."</td>");
		e("<td align=center colspan=4>".u8($linhas[$i][1])." / ".u8($linhas[$i][2])." $ativo</td>");
		e("<td align=center>");
		e("<button class=btn onclick=\"abrir_rateio(".$linhas[$i][0].");\" align=center>$ico_abrir</button></td>");
		e("</td>");
		e("</tr>");
		e("<td align=center>".$linhas[$i][4]."</td>");
		e("<td align=center>".nformat($linhas[$i][5]) . "</td>");
		e("<td align=center>".$linhas[$i][6]."x</td>");
		e("<td align=center colspan=>".$qTpPagamento[array_search($linhas[$i][3], $qTpPagamento)+1]."</td>");
		e("<td class=acao><button class=btn onclick=\"editar_rateio(".$linhas[$i][0].");\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_rateio(".$linhas[$i][0].");\" align=center>$ico_excluir</button></td>");
		e("</tr>");
		e("<td colspan=4>Vencimento dia: ".$linhas[$i][7]."</td>");
		e("</tr>");
/*		
		if ($linhas[$i][6] <> "") {
			e("<td align=left class=obs colspan=6><b>Obs: </b> ".u8($linhas[$i][6])."</td>");
			e("</tr>");			
		}
*/		
	}
}
//-----------------------------------------
function total_geral() {
//-----------------------------------------
	global $total, $spc;
	e("<th align=right colspan=4><b>Total Mês$spc</b></th>");
	$classe = ($total < 0 ? "class=negativo" : "");
	if ($total < 0) { $total = $total * (-1); }
	e("<th align=right $classe><b>".nformat($total)."</b></th>");
	e("<th></th>");
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($opRateio == "E" and $id_excluir_rateio <> "" ) {
/*	
	$qExcluirQuem = "delete from rat_cadastro_quem where fk_rateio = $id_excluir_rateio";
	$resultado = executa_sql($qExcluirQuem, "Pessoas ($id_excluir_rateio) excluidas com sucesso");
	resultado();
	if ($erro_sql == 0) {
		$qExcluirParcelas = "delete from gst_parcelas where fk_rateios = $id_excluir_rateio";
		$resultado = executa_sql($qExcluirParcelas, "Parcelas do rateio ($id_excluir_rateio) excluidas com sucesso");
		resultado();
		if ($erro_sql == 0) {
*/			
			$qExcluir = "delete from rat_cadastro where id = $id_excluir_rateio";
			$resultado = executa_sql($qExcluir, "rateio ($id_excluir_rateio) excluido com sucesso");
			resultado();
/*			
		}
	}
*/	
	if ($erro_sql == 0) {
		$id_excluir_rateio = "";		
	}
}
	e("<form name=frm_cad_rateio id=frm_cad_rateio method=post action=$self >");
	e("<input type=hidden name=opRateio value='P'>");
/*	
	if ($p_ano == "") { $p_ano = date("Y"); }
	if ($p_mes == "") { $p_mes = date("m"); }
	botao_mes_ano(-1);
	campo_select_ano("p_ano");
	campo_select_mes("p_mes");
	botao_mes_ano(1);
*/	
	if ($p_tab_tipo == "") { $p_tab_tipo = 99; }
	e("<select name=p_tab_tipo id=p_tab_tipo onchange=\"el('frm_cad_rateio').submit()\" >");
		e("<option ".($p_tab_tipo == 99 ? "selected" : "")." value=99>Todos</option>");
		$qTabTipo = "SELECT id, ds_tipo_rateio FROM rat_tab_tipo g order by 2";
		e(processaSelect($qTabTipo, $p_tab_tipo));
	e("</select>");
	e("<button>$ico_pesquisar</button>");
	e("<button type=button onclick=\"incluir_rateio();\">$ico_incluir</button>");
	e("</form><br>");
	//<input type="text" name="vl_rateio" id="vl_rateio" readonly inputmode="numeric" style="font-size: 16px;" size=8 onkeyup="formatarMoeda(this);"  value="">
// if ($p_ano <> "" and $p_mes <> "") {
	$qRateio = "
select 	r.id, 
				ds_rateio,
				t.ds_tipo_rateio, 
				r.tp_pagamento,
				date_format(r.dt_rateio, '%d/%m/%Y'), 
				r.vl_rateio,
				r.nr_parcelas,
				r.dia_vencimento,
				r.sn_ativo
from rat_cadastro r
inner join rat_tab_tipo t on t.id = r.fk_tipo
WHERE 1 = 1
". ($p_tab_tipo <> 99 ? " and r.fk_tipo = $p_tab_tipo " : "") ."
order by r.dt_rateio desc " . ($p_tab_tipo <> 99 ? ", t.ds_tipo_rateio" : "");
// e($qRateio);
	$b1 = new bd;
	$b1->prepara($qRateio);
	$inicio = "";
	e("<table width=100% class=padrao cellspacing=0>");
	$a = 0;
	$c = 0;
	$subtotal = 0;
	$total = 0;
	while($row = $b1->consulta()){
		$linha = u8($row[1]);
		if ($inicio <> $linha) {
			if ($inicio <> "") { imprimir_array(); }
			$inicio = $linha;
			$a = 0;
			$subtotal = 0;
			$c++;
		}
		$linhas[$a] = $row;
/*		
		if ($row[4] == 2) {
			$subtotal -=  $row[2];			
			$total -=  $row[2];			
		} else {
			$subtotal +=  $row[2];			
			$total +=  $row[2];			
		}		
		$qQuemrateio = "SELECT distinct t.nm_pessoa
FROM rat_cadastro_quem g
inner join tab_quem t on t.id = g.fk_quem
where fk_rateio = $row[0]
order by 1";
		$txt = "";
		$b2 = new bd;
		$b2->prepara($qQuemrateio);
		$ctg = 0;
		while($tg = $b2->consulta()){
			$txt .= ($ctg == 0 ? "" : ", ") . u8($tg[0]);
			$ctg++;
		}
		$linhas[$a][9] = ($txt <> "" ? $txt : ""); 
		// echo $linhas[$a][1];
		$b2->libera();
*/		
		$a++;
	}
	if ($c > 0) {
		imprimir_array();
	}
	$b1->libera();
	if ($c == 0) {
		e("<td colspan=5 align=center>Nenhum dado encontrado</td>");
	// } else {
		// total_geral();
	}
	e("</table>");
// }
desconectar();

?>
