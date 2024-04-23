﻿<?php
if (!isset($tp_regime)) {	$tp_regime = "X"; }

$tituloPagina = "Terracap Mensal";
include_once("include.php");

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
e("<form name=frm_terracap_mensal id=frm_terracap_mensal method=post action=$self>");
e("<input type=hidden name=op_menu value=21><div class=bloco_pesquisa><div>");
if ($p_ano == "") { $p_ano = date("Y"); }
if ($p_mes == "") { $p_mes = date("m"); }
botao_mes_ano(-1);
campo_select_ano("p_ano");
campo_select_mes("p_mes");
botao_mes_ano(1);
e("</div><div>");
montaRadio($dom_caixa_comp, "tp_regime", $tp_regime, "", "el('frm_terracap_mensal').submit()");
e("$spc$spc<button type=submit>$ico_pesquisar</button></div>");
e("</form>");
if ($p_ano <> "" and $p_mes <> "") {
		$dt_tipo = ($tp_regime == "X" ? "f.dt_fluxo" : "f.dt_competencia");
		$qSaldoAnterior = "select sum(case
		         when fluxo_tipo_id = 13 then vl_fluxo
		         when fluxo_tipo_id = 14 then -1 * vl_fluxo
		        end) valor
		 from fluxo f
                 where $dt_tipo < '$p_ano-$p_mes-01'";
		
		$qMensal = "select 'Receita', coalesce(m.nm_apelido, obs), vl_fluxo
from fluxo f
left join membro m on m.id = f.membro_id
where fluxo_tipo_id = 13
and date_format($dt_tipo, '%Y') = $p_ano
and date_format($dt_tipo, '%m') = $p_mes
union all
select 'Despesa', 'TERRACAP', -1 *vl_fluxo
from fluxo f
where fluxo_tipo_id = 14
and date_format($dt_tipo, '%Y') = $p_ano
and date_format($dt_tipo, '%m') = $p_mes
order by 1 desc, 2";
		$b1 = new bd;
		$b1->prepara($qMensal);
		e("<table width=100% class=padrao>");
		$c = 0;
		$total = 0;
		while($row = $b1->consulta()){
			if ($c == 0) {
				$saldoAnterior = pesquisa($qSaldoAnterior, 0);
				e("<th>Saldo Anterior</th>");
				$classe = ($saldoAnterior < 0 ? "class=negativo" : "");				
				e("<th $classe>".nformat($saldoAnterior)."</th>");
				e("</tr>");				
				// e("<th>Tipo</th>");
				e("<th>Nome</th>");
				e("<th>Valor</th>");
				e("</tr>");
			}
			// e("<td>". $row[0] ."</td>");
			e("<td>". u8($row[1]) ."</td>");
			$classe = ($row[0] == "Despesa" ? "class=negativo" : "");
			e("<td align=right $classe>". nformat($row[2]) ."</td>");
			e("</tr>");
			$total += $row[2];
			$c++;
		}
		$b1->libera();		
		if ($total == 0) {
			e("<td colspan=3>Nenhum dado encontrado</td>");
		} else {
			e("<th align=right>Saldo $p_mes/$p_ano$spc</th>");
			$classe = ($total < 0 ? "class=negativo" : "");
			e("<th align=right $classe>". nformat($total) ."</th>");
			e("</tr>");
			e("<th align=right>Saldo Atual</th>");
			$classe = (($total + $saldoAnterior) < 0 ? "class=negativo" : "");
		  e("<th align=right $classe>". nformat($total + $saldoAnterior) ."</th>");
			e("</tr>");
		}
		e("</table>");
	}
desconectar();
?>	