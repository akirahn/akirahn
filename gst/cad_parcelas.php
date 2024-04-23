<?php
$menu_off = 1;
include_once("../include/include_bd.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
/*
	function editar_financas(p_id_financas) {
		$("#nome_frm_modal").val("frm_cad_parcela");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_financas.php?p_edicao_opcao=PA&p_edicao_id="+p_id_financas);
	}
//--------------------------------------------------------------------------------------------------
	function incluir_financas() {
		$("#nome_frm_modal").val("frm_cad_parcela");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_financas.php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
	function abre_parcelas(p_id_financas) {
		$("#nome_frm_modal").val("frm_cad_parcela");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_parcelas.php?p_edicao_opcao=PA&p_edicao_id="+p_id_financas);
	}
//--------------------------------------------------------------------------------------------------
	function excluir_financas(p_id_financas) {
		excluir_id(p_id_financas, 'gst_parcelas', 'frm_cad_parcela');
	}
*/	
	tituloModalEdicao("Parcelas");
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $spc, $a, $ico_editar, $ico_excluir, $c, $ico_incluir, $ico_abrir, $subtotal;
	for($i=0; $i < $a; $i++) {
		$indice = $linhas[$i][0];
		if ($i == 0) {
/*			
			e("<th align=center colspan=4><b>".u8($linhas[$i][1])."</b></th>");
			$classe = ($subtotal < 0 ? "class=negativo" : "class=positivo");
			if ($subtotal < 0) { $subtotal = $subtotal * (-1); }
			e("<th align=center $classe>".nformat($subtotal)."</th>");
			e("<th></th>");
			e("</tr>");
			e("<th align=center>Tipo</th>");
			e("<th align=center>Quem</th>");
			e("<th class=acao>");
			e("<button onclick=\"incluir_financas();\">$ico_incluir</button>");
			e("</th>");
*/			
$xyz = 0;
		}
/*		
		$classe = ($linhas[$i][4] == 2 ? "class=negativo" : "");
		e("<td align=left>".u8($linhas[$i][3])."<br>".u8($linhas[$i][7])."</td>");
		e("<td align=center>".u8($linhas[$i][5])."</td>");
*/		
		e("<td align=center>".$linhas[$i][1]."</td>");
		e("<td align=center>".$linhas[$i][2]."</td>");
		e("<td align=right $classe>".nformat($linhas[$i][3])."</td>");
/*		
		e("<td class=acao><button class=btn onclick=\"editar_financas($indice);\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_financas($indice);\" align=center>$ico_excluir</button></td>");
*/		
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
	e("<td align=right colspan=2><b>Total$spc</b></th>");
	$classe = ($total < 0 ? "class=negativo" : "");
	if ($total < 0) { $total = $total * (-1); }
	e("<td align=right $classe><b>".nformat($total)."</b></th>");
	// e("<td></td>");
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($opparcela == "E" and $id_excluir_parcela <> "" ) {
	$qExcluirQuem = "delete from gst_parcelas_quem where fk_parcela = $id_excluir_parcela";
	$resultado = executa_sql($qExcluirQuem, "Pessoas ($id_excluir_parcela) excluidas com sucesso");
	resultado();
	if ($erro_sql == 0) {
		$qExcluirParcelas = "delete from gst_parcelas where fk_parcelas = $id_excluir_parcela";
		$resultado = executa_sql($qExcluirParcelas, "Parcelas do parcela ($id_excluir_parcela) excluidas com sucesso");
		resultado();
		if ($erro_sql == 0) {
			$qExcluir = "delete from gst_parcelas where id = $id_excluir_parcela";
			$resultado = executa_sql($qExcluir, "parcela ($id_excluir_parcela) excluido com sucesso");
			resultado();
		}
	}
	if ($erro_sql == 0) {
		$id_excluir_parcela = "";		
	}
}
/*
	e("<form name=frm_cad_parcela id=frm_cad_parcela method=post action=$self >");
	e("<input type=hidden name=opparcela value='P'>");
	if ($p_ano == "") { $p_ano = date("Y"); }
	if ($p_mes == "") { $p_mes = date("m"); }
	if ($p_tab_parcela == "") { $p_tab_parcela = 99; }
	botao_mes_ano(-1);
	campo_select_ano("p_ano");
	campo_select_mes("p_mes");
	botao_mes_ano(1);
	e("<select name=p_tab_parcela id=p_tab_parcela onchange=\"el('frm_cad_parcela').submit()\" >");
		e("<option ".($p_tab_parcela == 99 ? "selected" : "")." value=99>Todos</option>");
		$qTabparcela = "SELECT id, ds_tipo FROM gst_tab_tipo g order by 2";
		e(processaSelect($qTabparcela, $p_tab_parcela));
	e("</select>");
	e("<button>$ico_pesquisar</button>");
	e("</form><br>");
	//<input type="text" name="vl_parcela" id="vl_parcela" readonly inputmode="numeric" style="font-size: 16px;" size=8 onkeyup="formatarMoeda(this);"  value="">
if ($p_ano <> "" and $p_mes <> "") {
*/	
	$qparcela = "
select 	p.id
				,date_format(p.dt_pagto, '%d/%m/%Y')
				,p.nr_parcela
				,p.vl_parcela
from gst_parcelas p
where p.fk_gastos = $p_edicao_id
order by p.dt_pagto";
// e($qparcela);
	$b1 = new bd;
	$b1->prepara($qparcela);
	$inicio = "";
	e("<table width=100% cellspacing=0>");
	$a = 0;
	$c = 0;
	$subtotal = 0;
	$total = 0;
	e("<td align=center>Pagto</td>");
	e("<td align=center>Parc</td>");
	e("<td align=right>R$</td>");
	e("</tr>");
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
		$total +=  $row[3];			
/*		
		if ($row[4] == 2) {
			$subtotal -=  $row[2];			
			$total -=  $row[2];			
		} else {
			$subtotal +=  $row[2];			
			$total +=  $row[2];			
		}
*/		
		$a++;
	}
	if ($c > 0) {
		imprimir_array();
	}
	$b1->libera();
	if ($c == 0) {
		e("<td colspan=5 align=center>Nenhum dado encontrado</td>");
	} else {
		total_geral();
	}
	e("</table>");
//}
desconectar();

?>
