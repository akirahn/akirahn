<?php
//-----------------------------------------
function celula($p_dia, $p_linha, $p_coluna) {
//-----------------------------------------
	global $cabeca;
	$v_dia = ($p_dia < 10 ? "0$p_dia" : $p_dia);
	$cab = $cabeca[$v_dia];
	if ($cab[0] == $v_dia) {
		$classe = "class=grau_". $cab[2];
	} else {
		$classe = "";		
	}
	e("<td align=center id=cal_".$p_linha."_".$p_coluna." $classe>$p_dia</td>");
}

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

$tab_nome 		= "Relatório Mensal";
$tituloPagina = "$tab_nome";
include_once("include.php");
e("<form name=frm_rel_cabeca id=frm_rel_cabeca method=post action=$self >");
botao_mes_ano(-1);
if ($p_ano == "") { $p_ano = date("Y"); }
if ($p_mes == "") { $p_mes = date("m"); }
if ($p_quem == "") { $p_quem = 1; }
campo_select_ano("p_ano");
campo_select_mes("p_mes");
botao_mes_ano(1);
$qQuem = "select id, nm_pessoa from tab_quem where id in (1, 4) ";
e(processaRadio($qQuem, "p_quem", $p_quem));
e("$spc$spc  <button class=btn>$ico_pesquisar</button>");
e("</form>");
if ($p_ano <> "" and $p_mes <> "") {
	$qDias = "select date_format(last_day('$p_ano-$p_mes-01'), '%d'), weekday('$p_ano-$p_mes-01')";
	$dias = pesquisa($qDias);
	$ultimo_dia = $dias[0];
	$semana = ($dias[1] == 6 ? 1 : $dias[1] + 2);
	$qCabeca = "SELECT date_format(a.dt_cabeca, '%d'), hr_cabeca, nr_grau, nr_grau_alivio, fk_remedio, q.nm_pessoa
FROM app_cabeca a
inner join tab_quem q on q.id = a.fk_quem
where date_format(a.dt_cabeca, '%Y-%m') = '$p_ano-$p_mes'
" . ($p_quem <> "" ? " and a.fk_quem = $p_quem " : "") ."
order by a.dt_cabeca, hr_cabeca";
	$b1 = new bd;
	$b1->prepara($qCabeca);
	$cabeca = array();
	while($row = $b1->consulta()){ 
		$dia_cab = $row[0];
		$cabeca[$dia_cab] = $row; 
	}
	$b1->libera();
	e("<table width=100% class=padrao>");
		e("<th>Dom</th>");
		e("<th>Seg</th>");
		e("<th>Ter</th>");
		e("<th>Qua</th>");
		e("<th>Qui</th>");
		e("<th>Sex</th>");
		e("<th>Sáb</th>");
		e("</tr>");		
		$linha = 1;
		$coluna = 1;
		$dia = 1;
		for($l=1; $l < 7;$l++) {
			for($d=1; $d < 8;$d++) {
				if ($d == 1 and $dia == "") {
					break;
				}
				if ($l == 1 and $semana == $d) {
					celula($dia, $l, $d);
					$dia++;
				} else {
					if ($dia > 1 and $dia <= $ultimo_dia) {
						celula($dia, $l, $d);	
						$dia++;
					} else {
						if ($dia > $ultimo_dia) {
							$dia = "";							
						}
						celula("", $l, $d);
					}
				}
			}
			e("</tr>");
		}
	e("</table>");
	
	e("<table width=100% class=padrao>");
	e("<th colspan=2>Estatística</th></tr>");
	e("<td width=50% align=center>");
	$qCountGrau= "SELECT count(distinct date_format(a.dt_cabeca, '%d')), nr_grau, last_day(a.dt_cabeca)
FROM app_cabeca a
where date_format(a.dt_cabeca, '%m/%Y') = '$p_mes/$p_ano'
group by nr_grau
order by 2";
// e($qCountGrau);
	$b2 = new bd;
	$b2->prepara($qCountGrau);
	e("<br><table class=hr><th>Dor</th><th>Qtd</th></tr>");
	$dias_dor = 0;
	while($r2 = $b2->consulta()){ 
		$indice = array_search($r2[1], $dom_cabeca_grau) + 1;
		e("<td class=grau_" . $r2[1] . ">".$dom_cabeca_grau[$indice]."</td>");
		e("<td>". $r2[0]."</td>");
		e("</tr>");
		$dias_dor += $r2[0];
	}
	if (date("m/Y") == "$p_mes/$p_ano") {
		$dias_mes = date("d");		
	} else {
		$dias_mes = $ultimo_dia;
	}
	$percentual = $dias_dor/$dias_mes*100;
	e("<td><b>SubTotal</td><td>$dias_dor</td></tr>");
	e("<td><b>Dias Mês</td><td>$dias_mes</td></tr>");
	e("<td><b>Total</td><td><b>".nformat($percentual)."%</td></tr>");
	e("</table>");
	$b2->libera();
	e("</td><td width=50% align=center>");
	$qCountGrauAlivio = "SELECT count(distinct date_format(a.dt_cabeca, '%d')), nr_grau_alivio, r.ds_remedio
FROM app_cabeca a
inner join app_cab_remedio r on a.fk_remedio = r.id
where date_format(a.dt_cabeca, '%m/%Y') = '$p_mes/$p_ano'
and a.fk_remedio <> 0
group by nr_grau_alivio, ds_remedio
order by 2";
// e($qCountGrau);
	$b3 = new bd;
	$b3->prepara($qCountGrauAlivio);
	e("<br><table class=hr><th>Alívio</th><th>Remédio</th><th>Qtd</th></tr>");
	while($r3 = $b3->consulta()){ 
		$indice = array_search($r3[1], $dom_cabeca_grau_alivio) + 1;
		e("<td class=grau_" . $r3[1] . ">".$dom_cabeca_grau_alivio[$indice]."</td>");
		e("<td>".u8($r3[2])."</td>");
		e("<td>". $r3[0]."</td>");
		e("</tr>");
	}
	e("</table>");
	$b3->libera();
	e("</td>");
	e("</table>");
	
}

?>