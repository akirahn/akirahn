<?php
$tituloPagina = "Tipo/Subtipo Mensal";
include_once("include.php");

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
e("<form name=frm_tipo_anual id=frm_tipo_anual method=post action=$self>");
if ($p_ano == "") { $p_ano = date("Y"); }
e("<select name=p_ano id=p_ano onchange=\"el('frm_tipo_anual').submit()\" >");
	e(" <option value=>Ano</option>");	
$qAno = "select date_format(CURRENT_DATE(), '%Y'), date_format(CURRENT_DATE(), '%Y')
union
select date_format(CURRENT_DATE(), '%Y') -1, date_format(CURRENT_DATE(), '%Y') -1
union
select date_format(CURRENT_DATE(), '%Y') -2, date_format(CURRENT_DATE(), '%Y') -2";
e(processaSelect($qAno, $p_ano));
e("</select>$spc$spc");
e("$spc$spc<button type=submit>$ico_pesquisar</button>");
e("</form>");
if ($p_ano <> "") {
		$qSaldoAnterior = "select sum(if(g.fk_movimento = 1, vl_gasto, -1 * vl_gasto)) valor
		 from gst_gastos g
     where date_format(dt_pagto, '%Y') < $p_ano ";		
		$qAnual = "select tipo, sub, sum(valor) valor
from (
select t.ds_tipo tipo
       ,tg.ds_tag sub
       ,if(g.fk_movimento = 1, vl_gasto, -1 * vl_gasto) valor
from gst_gastos g
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
inner join gst_tab_pagto p on p.id = g.fk_pagto
where date_format(dt_pagto, '%Y') = $p_ano
) t
group by  tipo, sub
order by 1, 2";
		$b1 = new bd;
		$b1->prepara($qAnual);
		e("<table width=100% class=padrao>");
		$c = 0;
		$total = 0;
		while($row = $b1->consulta()){
			if ($c == 0) {
				$saldoAnterior = pesquisa($qSaldoAnterior, 0);
				e("<th colspan=2>Saldo Anterior</th>");
				$classe = ($saldoAnterior < 0 ? "class=negativo" : "");				
				e("<th $classe>".nformat($saldoAnterior)."</th>");
				e("</tr>");				
				e("<th>Tipo</th>");
				e("<th>Subtipo</th>");
				e("<th>Valor</th>");
				e("</tr>");
			}
			e("<td>". u8($row[0]) ."</td>");
			e("<td>". u8($row[1]) ."</td>");
			$classe = ($row[2] < 0 ? "class=negativo" : "");
			$valor  = ($row[2] < 0 ? -1 : 1) * $row[2];
			e("<td align=right $classe>". nformat($valor) ."</td>");
			e("</tr>");
			$total += $row[2];
			$c++;
		}
		$b1->libera();		
		if ($total == 0) {
			e("<td colspan=3>Nenhum dado encontrado</td>");
		} else {
			e("<th align=right colspan=2>Saldo $p_ano$spc</th>");
			$classe = ($total < 0 ? "class=negativo" : "");
			e("<th align=right $classe>". nformat($total) ."</th>");
			e("</tr>");
			e("<th align=right colspan=2>Saldo Atual</th>");
			$classe = (($total + $saldoAnterior) < 0 ? "class=negativo" : "");
		  e("<th align=right $classe>". nformat($total + $saldoAnterior) ."</th>");
			e("</tr>");
		}
		e("</table>");
	}
desconectar();
?>	