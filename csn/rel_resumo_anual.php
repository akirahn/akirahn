<?php
if (!isset($tp_regime)) {	$tp_regime = "X"; }

$tituloPagina = "Resumo Anual";
include_once("include.php");

$total_coluna = array();
$receitas = array();
$despesas = array();
//-----------------------------------------
function lista_meses($p_titulo) {
//-----------------------------------------
		e("<th>$p_titulo</th>");
		e("<th>Janeiro</th>");
		e("<th>Fevereiro</th>");
		e("<th>Março</th>");
		e("<th>Abril</th>");
		e("<th>Maio</th>");
		e("<th>Junho</th>");
		e("<th>Julho</th>");
		e("<th>Agosto</th>");
		e("<th>Setembro</th>");
		e("<th>Outubro</th>");
		e("<th>Novembro</th>");
		e("<th>Dezembro</th>");
		e("<th>Total</th>");
		e("</tr>");
}
//-----------------------------------------
function zera_coluna() {
//-----------------------------------------
	for ($a = 1; $a < 14; $a++) { $total_coluna[$a] = 0; }
	return $total_coluna;
}
//-----------------------------------------
function lista_linha($p_linha, $p_tipo_linha, $p_titulo = "Total") {
//-----------------------------------------
	if (($p_linha[13] > 0 and $p_tipo_linha <> "T") or ($p_tipo_linha == "T")) {
		if ($p_tipo_linha == "T") {
			e("<td><b>$p_titulo</b></td>");			
		} else {
			e("<td>". u8($p_linha[0]) . "</td>");
		}
		for($a=1;$a<14;$a++) {
			$classe = ($p_linha[$a] < 0 ? "class=negativo" : "");
			e("<td align=right $classe>");
			if ($p_tipo_linha == "T") {
				e("<b>" . nformat($p_linha[$a]) . "</b>");
			} else {
				e(nformat($p_linha[$a]));
			}
			e("</td>");				
		}
		e("</tr>");
	}
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
// e("Dispositivo: $deviceType");
e("<form name=frm_consulta_anual id=frm_consulta_anual method=post action=$self>");
e("<input type=hidden name=op_menu value=5>");
if ($p_ano == "") { $p_ano = date("Y"); }
campo_select_ano("p_ano");
e("$spc$spc");
montaRadio($dom_caixa_comp, "tp_regime", $tp_regime, "", "el('frm_terracap_anual').submit()");
e("$spc$spc<button type=submit>$ico_pesquisar</button>");
e("</form>");
if ($p_ano <> "") {
	$dt_tipo = ($tp_regime == "X" ? "f.dt_fluxo" : "f.dt_competencia");
	$qSaldoAnterior = "select coalesce(sum(if(fluxo_movimento_id = 1, 1, -1) * vl_fluxo), 0) 
from fluxo f 
where $dt_tipo < '$p_ano-01-01' 
and $dt_tipo >= '2018-01-01' 
and f.fluxo_tipo_id not in (13,14) ";
	$saldoAnterior = pesquisa($qSaldoAnterior, 0);
	$c = 0;
	$p_mov = 1;
	e("<table width=100% class=padrao>");
	while ($p_mov <> 0) {
		lista_meses($p_mov == 1 ? "Receitas" : "Despesas");
		$qAnual = "select t.tipo,
				 sum(t.mes01) sm01,
				 sum(t.mes02) sm02,
				 sum(t.mes03) sm03,
				 sum(t.mes04) sm04,
				 sum(t.mes05) sm05,
				 sum(t.mes06) sm06,
				 sum(t.mes07) sm07,
				 sum(t.mes08) sm08,
				 sum(t.mes09) sm09,
				 sum(t.mes10) sm10,
				 sum(t.mes11) sm11,
				 sum(t.mes12) sm12,
				 sum(t.total) total
	from (
	SELECT t.ds_fluxo_tipo tipo,
				 if(DATE_FORMAT($dt_tipo,'%m') = 01, f.vl_fluxo, 0) mes01,
				 if(DATE_FORMAT($dt_tipo,'%m') = 02, f.vl_fluxo, 0) mes02,
				 if(DATE_FORMAT($dt_tipo,'%m') = 03, f.vl_fluxo, 0) mes03,
				 if(DATE_FORMAT($dt_tipo,'%m') = 04, f.vl_fluxo, 0) mes04,
				 if(DATE_FORMAT($dt_tipo,'%m') = 05, f.vl_fluxo, 0) mes05,
				 if(DATE_FORMAT($dt_tipo,'%m') = 06, f.vl_fluxo, 0) mes06,
				 if(DATE_FORMAT($dt_tipo,'%m') = 07, f.vl_fluxo, 0) mes07,
				 if(DATE_FORMAT($dt_tipo,'%m') = 08, f.vl_fluxo, 0) mes08,
				 if(DATE_FORMAT($dt_tipo,'%m') = 09, f.vl_fluxo, 0) mes09,
				 if(DATE_FORMAT($dt_tipo,'%m') = 10, f.vl_fluxo, 0) mes10,
				 if(DATE_FORMAT($dt_tipo,'%m') = 11, f.vl_fluxo, 0) mes11,
				 if(DATE_FORMAT($dt_tipo,'%m') = 12, f.vl_fluxo, 0) mes12,
				 f.vl_fluxo total
	FROM fluxo f, fluxo_tipo t
	WHERE f.fluxo_tipo_id = t.id
  and DATE_FORMAT($dt_tipo,'%Y') = $p_ano
	and fluxo_tipo_id not in (13,14)
	and	fluxo_movimento_id = $p_mov
	) t
	group by tipo
	";
		$b1 = new bd;
		$b1->prepara($qAnual);
		$total_coluna = zera_coluna();
		while($row = $b1->consulta()){
			if ($row[13] > 0) {
				lista_linha($row, "L");
				for ($a = 1; $a < 14; $a++) { $total_coluna[$a] += $row[$a]; }
				$c++;
			}
		}
		if ($p_mov == 2) { $p_mov = 0; }
		if ($p_mov == 1) { 
			lista_linha($total_coluna, "T", "Total Receitas");
			$receitas = $total_coluna;
			$receitas[0] = "Receitas";
			$total_coluna = zera_coluna();
			$p_mov = 2; 
		}
		$b1->libera();
	}
	if ($c == 0) {
		e("<td colspan=14>Nenhum dado encontrado</td>");
	} else {
		lista_linha($total_coluna, "T", "Total Despesas");
		$despesas = $total_coluna;
		lista_meses("Resumo");
		$despesas[0] = "Despesas";
		$saldo_anterior = array();
		$saldo_mes = array();
		for ($a = 1; $a < 14; $a++) { 
			if ($a == 1 or $a == 13) {
				$saldo_anterior[$a] = $saldoAnterior;
			} else {
				$saldo_anterior[$a] = $totais[$a-1];					
			}
			$totais[$a] = $saldo_anterior[$a] + $receitas[$a] - $despesas[$a]; 
			$saldo_mes[$a] = $receitas[$a] - $despesas[$a]; 
		}
		lista_linha($saldo_anterior, "T", "Saldo Anterior");
		lista_linha($receitas, "L");
		lista_linha($despesas, "L");
		lista_linha($saldo_mes, "T", "Saldo Mês");
		lista_linha($totais, "T", "Total Geral");
	}
}
e("</table>");
desconectar();
?>