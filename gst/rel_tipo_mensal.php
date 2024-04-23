<?php
$tituloPagina = "Tipo/Subtipo Mensal";
include_once("include.php");

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
e("<form name=frm_tipo_mensal id=frm_tipo_mensal method=post action=$self>");
e("<center>");
e("<div class=bloco_pesquisa><div>");
if ($p_sin_ana == "") { $p_sin_ana = "S"; }
$qCompetencia = "SELECT dt_competencia, date_format(dt_competencia, '%m/%Y')
FROM gst_competencia g
order by 1 desc";
e("<select name='p_competencia' id='p_competencia' onchange=\"el('frm_tipo_mensal').submit()\" >");
	e(processaSelect($qCompetencia, $p_competencia));
e("</select>");

// if ($p_ano == "") { $p_ano = date("Y"); }
// if ($p_mes == "") { $p_mes = date("m"); }
// botao_mes_ano(-1);
// campo_select_ano("p_ano");
// campo_select_mes("p_mes");
// botao_mes_ano(1);
e("</div><div>");
montaRadio($dom_sint_analit, "p_sin_ana", $p_sin_ana);
e("<select name=p_pagto id=p_pagto onchange=\"el('frm_tipo_mensal').submit()\" >");
	e("<option value=>Forma Pagto</option>");
$qPagto = "SELECT g.id, coalesce(concat(if(tp_pagto = 'C', '" . u8d("Crédito") ."', 'Conta'), ' ', p.ds_forma_pagto, ' ', q.nm_pessoa), 'Dinheiro')
FROM gst_tab_pagto g
inner join gst_tab_forma_pagto p on g.fk_forma_pagto = p.id
left join tab_quem q on q.id = g.fk_quem
where g.id not in (14, 15)
union
select 88, concat('" . u8d("Crédito") ." ', f.ds_forma_pagto)
from gst_tab_forma_pagto f
where f.id = 3	
order by 2";
e(processaSelect($qPagto, $p_pagto));
e("</select>$spc$spc");
e("$spc$spc<button type=submit>$ico_pesquisar</button></div>");
e("</center>");
e("</form>");
if ($p_competencia <> "") { 
/*	
	$qBaseData = "
FROM gst_gastos g
where g.fk_pagto = 2
and g.fk_subtipo = 59
";
	$qInicio = "SELECT dt_gasto $qBaseData and date_format(dt_gasto, '%m/%Y') = '$p_mes/$p_ano'";
	// e("$qInicio<br>");	
	$dtInicio = pesquisa($qInicio, 0);
	if ($dtInicio == "") {
		$qInicio = "select max(dt_gasto) $qBaseData";
		$dtInicio = pesquisa($qInicio, 0);
	}
	$v_mes = $p_mes + 1;
	$v_ano = $p_ano;
	if ($v_mes > 12) {
		$v_mes = 1;
		$v_ano++;
	}
	if ($v_mes < 10) {
		$v_mes = "0$v_mes";
	}
	$qFim = "select date_format(dt_gasto-1, '%Y-%m-%d') $qBaseData and date_format(dt_gasto, '%m/%Y') = '$v_mes/$v_ano'";
	e($qFim);
	$dtFim = pesquisa($qFim, 0);
	if ($dtFim == "") {
		if (date("Y-m-d") < "$p_ano-$p_mes-24") {
			$dtFim = "$p_ano-$p_mes-24";
		} else {
			$dtFim = date("Y-m-d");			
		}
		
	}
/*	
	if (substr($dtFim, 0, 7) == "$p_ano-$p_mes") {
		$dtFim = "$v_ano-$v_mes-24";
	}
*/	
	
		$wPagto = ($p_pagto == "88" ? " in (14, 15) " : "");
		$wPagto = (($p_pagto <> "" and $p_pagto <> "88") ? " = $p_pagto " : "");

		$qVencimento = "select dia_vencimento from gst_tab_pagto where id $wPagto ";
		// e($qVencimento);
		$vencimento = pesquisa($qVencimento, 0);
		// e("vencimento: [$vencimento]");
		if ($vencimento == "" or $vencimento == 0) {
			$vencimento = " and date_format(dt_pagto, '%m/%Y') = '$p_mes/$p_ano' ";
		} else {
			$vencimento = " and dt_pagto = concat('$p_ano-$p_mes-$vencimento') ";			
		}
		$qSaldoAnterior = "select sum(if(g.fk_movimento = 1, vl_gasto, -1 * vl_gasto)) valor
		 from gst_gastos g
     where dt_gasto < '$dtInicio' ";
		 
// where dt_pagto between '$minReferencia' and '$maxReferencia'
	$tipo = ($p_sin_ana == "S" ? "t.ds_tipo" : "concat(t.ds_tipo, '/', tg.ds_tag)");
		$qMensal = "select grupo, tipo, parcela, sum(valor) valor 
 from (
select concat(if(g.fk_movimento = 1, 'Receita', 'Despesa'), '/', gp.ds_grupo) grupo
       ,$tipo tipo
       ,if(g.fk_movimento = 1, 1, -1) * vl_gasto valor
       ,f.ds_forma_pagto, g.dt_pagto, g.obs, '' parcela, g.dt_gasto, 'Q' tipo_linha, g.id
from gst_gastos g
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
inner join gst_tab_pagto p on p.id = g.fk_pagto
left join gst_tab_forma_pagto f on p.fk_forma_pagto = f.id
left join gst_tab_grupo gp on gp.id = s.fk_grupo
left join gst_gastos_quem q on q.fk_gasto = g.id
where 1 = 1
and s.id <> 9
and t.id <> 20
and g.nr_parcelas = 1
" . (($p_pagto <> "" and $p_pagto <> "88") ? " and g.fk_pagto = $p_pagto " : "")  . "
" . ($p_pagto == "88" ? " and g.fk_pagto in (14, 15) " : "")  . "
union
select concat(if(g.fk_movimento = 1, 'Receita', 'Despesa'), '/', gp.ds_grupo) grupo
       ,$tipo tipo
       ,if(g.fk_movimento = 1, 1, -1) * pc.vl_parcela
       ,f.ds_forma_pagto, pc.dt_pagto, g.obs, concat(pc.nr_parcela, '/', g.nr_parcelas), g.dt_gasto, 'P', pc.id
from gst_gastos g
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
inner join gst_tab_pagto p on p.id = g.fk_pagto
inner join gst_parcelas pc on pc.fk_gastos = g.id
left join gst_tab_forma_pagto f on p.fk_forma_pagto = f.id
left join gst_tab_grupo gp on gp.id = s.fk_grupo
left join gst_gastos_quem q on q.fk_gasto = g.id
where 1 = 1 
and s.id <> 9
and t.id <> 20
and g.nr_parcelas > 1
" . (($p_pagto <> "" and $p_pagto <> "88") ? " and g.fk_pagto = $p_pagto " : "")  . "
" . ($p_pagto == "88" ? " and g.fk_pagto in (14, 15) " : "")  . "
) t
inner join gst_competencia gc on gc.dt_competencia = '$p_competencia'
where t.dt_pagto between gc.dt_inicio and gc.dt_fim
group by grupo, tipo, parcela 
order by 1 desc, 2 ";
// e($qMensal);
		$b1 = new bd;
		$b1->prepara($qMensal);
		e("<table width=100% class=padrao>");
		$c = 0;
		$total = 0;
		$colunas = "3";
		$movimentoGrupo = "";
		$subMG = 0;
		$subMGp = 0;
		while($row = $b1->consulta()){
			if ($c == 0) {
				$saldoAnterior = pesquisa($qSaldoAnterior, 0);
				e("<th colspan=$colunas>Saldo Anterior</th>");
				$classe = ($saldoAnterior < 0 ? "class=negativo" : "");				
				e("<th $classe>".nformat($saldoAnterior)."</th>");
				e("</tr>");				
				e("<th>Grupo</th>");
				e("<th>Tipo</th>");
				e("<th>Parcela</th>");
				e("<th>Valor</th>");
				e("</tr>");
			}
			if ($movimentoGrupo <> $row[0]) {
				if ($movimentoGrupo <> "") {
					if ($subMGp <> 0) {						
						e("<th colspan=$colunas align=right>". u8($movimentoGrupo) ."/Parcelas</th>");
						e("<th align=right>". nformat($subMGp) ."</th>");
						e("</tr>");
					}
					e("<th colspan=$colunas align=right>". u8($movimentoGrupo) ."</th>");
					e("<th align=right>". nformat($subMG) ."</th>");
					e("</tr>");
					e("<th>Grupo</th>");
					e("<th>Tipo</th>");
					e("<th>Parcela</th>");
					e("<th>Valor</th>");
					e("</tr>");
				}
				$movimentoGrupo = $row[0];
				$subMG = 0;
				$subMGp = 0;
			}
			e("<td>". u8($row[0]) ."</td>");
			e("<td>". u8($row[1]) ."</td>");
			e("<td align=center>". u8($row[2]) ."</td>");
			$classe = ($row[3] < 0 ? "class=negativo" : "");
			$valor  = ($row[3] < 0 ? -1 : 1) * $row[3];
			e("<td align=right $classe>". nformat($valor) ."</td>");
			e("</tr>");
			$subMG += $row[3];
			if ($row[2] <> "") {
				$subMGp += $row[3];				
			}
			$total += $row[3];
			$c++;
		}
		if ($subMGp <> 0) {
			e("<th colspan=$colunas align=right>". u8($movimentoGrupo) ." / Parcelas </th>");
			e("<th align=right>". nformat($subMGp) ."</th>");
			e("</tr>");
		}
		if ($subMG <> 0) {
			e("<th colspan=$colunas align=right>". u8($movimentoGrupo) ."</th>");
			e("<th align=right>". nformat($subMG) ."</th>");
			e("</tr>");
		}
		$b1->libera();		
		if ($total == 0) {
			e("<td colspan=$colunas>Nenhum dado encontrado</td>");
		} else {
			e("<th align=right colspan=$colunas>Movimentação $p_mes/$p_ano$spc</th>");
			$classe = ($total < 0 ? "class=negativo" : "");
			e("<th align=right $classe>". nformat($total) ."</th>");
			e("</tr>");
			e("<th align=right colspan=$colunas>Saldo Atual</th>");
			$classe = (($total + $saldoAnterior) < 0 ? "class=negativo" : "");
		  e("<th align=right $classe>". nformat($total + $saldoAnterior) ."</th>");
			e("</tr>");
		}
		e("</table>");
	}
desconectar();
?>	