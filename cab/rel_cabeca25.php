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

$tab_nome 		= "Relatório Mensal 25";
$tituloPagina = "$tab_nome";
include_once("include.php");
e("<form name=frm_rel_cabeca id=frm_rel_cabeca method=post action=$self >");
botao_mes_ano(-1);
if ($p_ano == "") { $p_ano = date("Y"); }
if ($p_mes == "") { $p_mes = date("m"); }
campo_select_ano("p_ano");
campo_select_mes("p_mes");
botao_mes_ano(1);
$qQuem = "select id, nm_pessoa from tab_quem where id in (1, 4) ";
e(processaRadio($qQuem, "p_quem", $p_quem));
e("$spc$spc  <button class=btn>$ico_pesquisar</button>");
e("</form>");
if ($p_ano <> "" and $p_mes <> "") {
	$v_ano_antes = $p_ano;
	$v_mes_antes = $p_mes;
	if ($p_mes == 1) {
		$v_ano_antes--;
		$v_mes_antes = 12;
	} else {
		$v_mes_antes--;
	}
	$v_inicio =  "$v_ano_antes-$v_mes_antes-25";
	$v_fim = "$p_ano-$p_mes-24";
	$v_hoje = date("Y-m-d");
	
	$qFim = "select if('$v_hoje' < '$v_fim', '$v_hoje', '$v_fim')";
	$v_fim = pesquisa($qFim, 0);
/*	
	$ultimo_dia = $dias[0];
	$semana = ($dias[1] == 6 ? 1 : $dias[1] + 2);
*/	
	$qCabeca = "SELECT date_format(a.dt_cabeca, '%d/%m'), nr_grau, nr_grau_alivio, if(r.id=0, '', r.ds_remedio), r.id, q.nm_pessoa
FROM app_cabeca a
inner join app_cab_remedio r on r.id = a.fk_remedio
inner join tab_quem q on q.id = a.fk_quem
where a.dt_cabeca between '$v_inicio' and '$v_fim'
" . ($p_quem <> "" ? " and a.fk_quem = $p_quem " : "") ."
and a.nr_grau in
(select max(a1.nr_grau)
 from app_cabeca a1
 where a1.dt_cabeca = a.dt_cabeca
 and a1.hr_cabeca = a.hr_cabeca
 and a1.fk_quem = a.fk_quem
 and a1.hr_cabeca in
 (select max(a2.hr_cabeca)
  from app_cabeca a2
  where a2.dt_cabeca = a1.dt_cabeca
  and a2.nr_grau = a1.nr_grau
	and a2.fk_quem = a1.fk_quem
 )
)
order by q.nm_pessoa, a.dt_cabeca";
// e($qCabeca);
	$b1 = new bd;
	$b1->prepara($qCabeca);
	$qDias = "select TIMESTAMPDIFF(DAY,'$v_inicio','$v_fim')";
	$dias_mes = pesquisa($qDias, 0);
	e("<label>Período de " . dformat($v_inicio) . " à " . dformat($v_fim). "</label>");
	e("<table width=100% class=padrao>");
		if ($p_quem == "") {
			e("<th>Quem</th>");			
		}
		e("<th>Dia</th>");
		e("<th>Grau/Remédio</th>");
		e("</tr>");
	$dias = 0;
	$grau = array();
	$qtd_grau = count($dom_cabeca_grau)/2;
	$qtd_remedio = 0;
	for($i=1; $i < $qtd_grau; $i++ ) { $grau[$i] = 0; }
	while($row = $b1->consulta()){ 
		if ($p_quem == "") {
			e("<td align=center>".u8($row[5])."</td>");
		}
		e("<td align=center>$row[0] ".($row[4] <> 0 ? "$ico_remedio" : "")."</td>");
		e("<td class=grau_$row[1]>".u8($row[3])."</td>");
		e("</tr>");
		$grau[$row[1]]++;
		if ($row[4] <> 0) { $qtd_remedio++; }
		$dias++;
	}
	$b1->libera();
	if ($dias > 0) {
		$percentual = nformat($dias/$dias_mes *100);
		$percentual_remedio = nformat($qtd_remedio/$dias_mes*100);
		e("<th>Total: $dias/$dias_mes");
		if ($p_quem == "") {
			e("</th><th>");
		} else {
			e("<br>");
		}		
		e("Média: $percentual%</th>");
		e("<th>");
		for($i=1; $i < $qtd_grau; $i++ ) {
			if ($grau[$i] > 0) {
				$indice_dom = array_search($i, $dom_cabeca_grau)+1;
				e($dom_cabeca_grau[$indice_dom] .": " . $grau[$i] . "<br>"); 
			}
		}
		e("</th>");
		e("</tr>");
		e("<th>Total Remédio: $qtd_remedio/$dias_mes");
		if ($p_quem == "") {
			e("</th><th>");
		} else {
			e("<br>");
		}		
		e("Média: $percentual_remedio%</th>");
		e("<th>");
		e("Remédio: $qtd_remedio");
		e("</th>");
	}
	e("</table>");
	
}

?>