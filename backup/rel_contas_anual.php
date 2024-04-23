<?php
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
	if ($p_linha[13] > 0) {
		if ($p_tipo_linha == "T") {
			e("<td><b>$p_titulo</b></td>");			
		} else {
			e("<td>". u8($p_linha[0]) . "</td>");
		}
		for($a=1;$a<14;$a++) {
			e("<td align=right>");
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
e("<form name=frm_contas_anual id=frm_contas_anual method=post action=$self>");
e("<input type=hidden name=op_menu value=7>");
e("<select name=p_ano onchange=\"el('frm_contas_anual').submit()\" >");
	e(" <option value=>Ano</option>");	
$qAno = "select date_format(CURRENT_DATE(), '%Y'), date_format(CURRENT_DATE(), '%Y')
union
select date_format(CURRENT_DATE(), '%Y') -1, date_format(CURRENT_DATE(), '%Y') -1
union
select date_format(CURRENT_DATE(), '%Y') -2, date_format(CURRENT_DATE(), '%Y') -2";
e(processaSelect($qAno, $p_ano));
e("</select>");
e("<input type=submit value=Pesquisar>");
e("</form>");
if ($p_ano <> "") {
	$c = 0;
	$p_mov = 1;
	e("<table width=100% class=padrao>");
		lista_meses("Despesas");
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
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 01, f.vl_fluxo, 0) mes01,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 02, f.vl_fluxo, 0) mes02,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 03, f.vl_fluxo, 0) mes03,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 04, f.vl_fluxo, 0) mes04,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 05, f.vl_fluxo, 0) mes05,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 06, f.vl_fluxo, 0) mes06,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 07, f.vl_fluxo, 0) mes07,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 08, f.vl_fluxo, 0) mes08,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 09, f.vl_fluxo, 0) mes09,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 10, f.vl_fluxo, 0) mes10,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 11, f.vl_fluxo, 0) mes11,
				 if(DATE_FORMAT(f.dt_fluxo,'%m') = 12, f.vl_fluxo, 0) mes12,
				 f.vl_fluxo total
	FROM fluxo f, fluxo_tipo t
	WHERE f.fluxo_tipo_id = t.id
  and DATE_FORMAT(f.dt_fluxo,'%Y') = $p_ano
	and t.tp_fluxo_tipo = 'C'
	) t
	group by tipo
	";
		preparaSQL($qAnual);
		$total_coluna = zera_coluna();
		while($row = consultaSQL()){
			if ($row[13] > 0) {
				lista_linha($row, "L");
				for ($a = 1; $a < 14; $a++) { $total_coluna[$a] += $row[$a]; }
				$c++;
			}
		}
		liberaSQL();		
	
	if ($c == 0) {
		e("<td colspan=14>Nenhum dado encontrado</td>");
	} else {
		lista_linha($total_coluna, "T", "Total Despesas");
		$despesas = $total_coluna;
/*		
		lista_meses("Resumo");
		$despesas[0] = "Despesas";
		lista_linha($receitas, "L");
		lista_linha($despesas, "L");
		for ($a = 1; $a < 14; $a++) { $totais[$a] = $receitas[$a] - $despesas[$a]; }
		lista_linha($totais, "T", "Total Geral");
*/		
	}
}
e("</table>");
desconectar();
?>