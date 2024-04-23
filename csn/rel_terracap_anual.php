﻿<?php
if (!isset($tp_regime)) {	$tp_regime = "X"; }

$tituloPagina = "Terracap Anual";
include_once("include.php");

//-----------------------------------------
function vl_mes($p_mes, $p_tipo) {
//-----------------------------------------
	global $tp_regime, $p_ano, $total_receita, $total_despesa, $dt_tipo;
	$qValor = "select sum(f.vl_fluxo)
from fluxo f
where date_format($dt_tipo, '%m') = $p_mes
and   date_format($dt_tipo, '%Y') = $p_ano
and f.fluxo_tipo_id = $p_tipo";
	$valor = pesquisa($qValor, 0);
	if ($p_tipo == 13) {
		$total_receita += $valor;
		$classe = "";
	} else {
		$total_despesa += $valor;		
		$classe = "class=negativo";
	}
	e("<td align=right $classe>". nformat($valor) . "</td>");
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
e("<form name=frm_terracap_anual id=frm_terracap_anual method=post action=$self>");
e("<input type=hidden name=op_menu value=22>");
if ($p_ano == "") { $p_ano = date("Y"); }
campo_select_ano("p_ano");
e("$spc$spc");
montaRadio($dom_caixa_comp, "tp_regime", $tp_regime, "", "el('frm_terracap_anual').submit()");
e("$spc$spc<button type=submit>$ico_pesquisar</button>");
e("</form>");
if ($p_ano <> "") {
	$dt_tipo = ($tp_regime == "X" ? "f.dt_fluxo" : "f.dt_competencia");
	$qSaldoAnterior = "select sum(case
	         when fluxo_tipo_id = 13 then vl_fluxo
	         when fluxo_tipo_id = 14 then -1 * vl_fluxo
	        end) valor
	 from fluxo f
         where $dt_tipo < '$p_ano-01-01'";
	$c = 0;
	$total_receita = 0;
	$total_despesa = 0;
	$saldo = 0;
	e("<table width=100% class=padrao>");
	$qMeses = "select id, ds_mes from tab_meses order by id";
	$b1 = new bd;
	$b1->prepara($qMeses);
	while ($r = $b1->consulta()) {
		if ($c == 0) {
			$saldoAnterior = pesquisa($qSaldoAnterior, 0);
			e("<th colspan=2 align=right>Saldo Anterior $spc</th>");
			$classe = ($saldoAnterior < 0 ? "class=negativo" : "");
			e("<th $classe>".nformat($saldoAnterior)."</th>");
			e("</tr>");
			e("<th>Mês</th>");
			e("<th>Receita</th>");
			e("<th>Despesa</th>");
			e("</tr>");			
		}
		e("<td>". u8($r[1]) . "</td>");
		vl_mes($r[0], 13);
		vl_mes($r[0], 14);
		e("</tr>");
		$c++;
	}
	if ($c == 0) {
		e("<td colspan=3>Nenhum dado encontrado</td>");
	} else {
		$saldo = $total_receita - $total_despesa;
		e("<th align=right>Total$spc</th>");
		e("<th align=right>".nformat($total_receita)."</th>");
		e("<th align=right class=negativo>".nformat($total_despesa)."</th>");
		e("</tr>");			
		e("<th colspan=2 align=right>Saldo $p_ano $spc</th>");
		$classe = ($saldo < 0 ? "class=negativo" : "");
		e("<th align=right $classe>".nformat($saldo)."</th>");
		e("</tr>");
		e("<th align=right colspan=2>Saldo Atual $spc</th>");
		$classe = (($saldo + $saldoAnterior) < 0 ? "class=negativo" : "");
		e("<th align=right $classe>". nformat($saldo + $saldoAnterior) ."</th>");
	}
}
e("</table>");
desconectar();
?>	