<?php
$tituloPagina = "Cadastro";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_financas(p_id_financas) {
		$("#nome_frm_modal").val("frm_cad_gasto");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_financas.php?p_edicao_opcao=PA&p_edicao_id="+p_id_financas);
	}
//--------------------------------------------------------------------------------------------------
	function incluir_financas() {
		$("#nome_frm_modal").val("frm_cad_gasto");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_financas.php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
	function abre_parcelas(p_id_financas) {
		// $("#nome_frm_modal").val("frm_cad_gasto");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>cad_parcelas.php?p_edicao_opcao=PA&p_edicao_id="+p_id_financas);
	}
//--------------------------------------------------------------------------------------------------
	function excluir_financas(p_id_financas) {
		excluir_id(p_id_financas, 'gst_gastos', 'frm_cad_gasto');
	}
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $spc, $a, $ico_editar, $ico_excluir, $c, $ico_incluir, $ico_abrir, $subtotal;
	for($i=0; $i < $a; $i++) {
		$indice = $linhas[$i][0];
		if ($i == 0) {
			e("<th align=center colspan=4><b>".u8($linhas[$i][1])."</b></th>");
			$classe = ($subtotal < 0 ? "class=negativo" : "class=positivo");
			if ($subtotal < 0) { $subtotal = $subtotal * (-1); }
			e("<th align=center $classe>".nformat($subtotal)."</th>");
			e("<th></th>");
			e("</tr>");
			e("<th align=center>Tipo</th>");
			e("<th align=center>Pagto</th>");
			e("<th align=center>Quem</th>");
			e("<th align=center>Parc</th>");
			e("<th align=center>R$</th>");
			e("<th class=acao>");
			e("<button onclick=\"incluir_financas();\">$ico_incluir</button>");
			e("</th>");
			e("</tr>");
		}
		$classe = ($linhas[$i][4] == 2 ? "class=negativo" : "");
		e("<td align=left>".u8($linhas[$i][3])."<br>".u8($linhas[$i][7])."</td>");
		e("<td align=center>".u8($linhas[$i][5])."</td>");
		e("<td align=center>".$linhas[$i][9]."</td>");
		if ($linhas[$i][8] <> "") {
			e("<td align=center><button class=btn onclick=\"abre_parcelas($indice);\" align=center>".$linhas[$i][8]." $ico_abrir</button></td>");
		} else {
			e("<td align=center>".$linhas[$i][8]."</td>");
		}
		e("<td align=center $classe>".nformat($linhas[$i][2])."</td>");
		e("<td class=acao><button class=btn onclick=\"editar_financas($indice);\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_financas($indice);\" align=center>$ico_excluir</button></td>");
		e("</tr>");
		if ($linhas[$i][6] <> "") {
			e("<td align=left class=obs colspan=6><b>Obs: </b> ".u8($linhas[$i][6])."</td>");
			e("</tr>");			
		}
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

if ($opGasto == "E" and $id_excluir_gasto <> "" ) {
	$qExcluirQuem = "delete from gst_gastos_quem where fk_gasto = $id_excluir_gasto";
	$resultado = executa_sql($qExcluirQuem, "Pessoas ($id_excluir_gasto) excluidas com sucesso");
	resultado();
	if ($erro_sql == 0) {
		$qExcluirParcelas = "delete from gst_parcelas where fk_gastos = $id_excluir_gasto";
		$resultado = executa_sql($qExcluirParcelas, "Parcelas do gasto ($id_excluir_gasto) excluidas com sucesso");
		resultado();
		if ($erro_sql == 0) {
			$qExcluir = "delete from gst_gastos where id = $id_excluir_gasto";
			$resultado = executa_sql($qExcluir, "Gasto ($id_excluir_gasto) excluido com sucesso");
			resultado();
		}
	}
	if ($erro_sql == 0) {
		$id_excluir_gasto = "";		
	}
}
	e("<form name=frm_cad_gasto id=frm_cad_gasto method=post action=$self >");
	e("<input type=hidden name=opGasto value='P'>");
	if ($p_ano == "") { $p_ano = date("Y"); }
	if ($p_mes == "") { $p_mes = date("m"); }
	if ($p_tab_gasto == "") { $p_tab_gasto = 99; }
	botao_mes_ano(-1);
	campo_select_ano("p_ano");
	campo_select_mes("p_mes");
	botao_mes_ano(1);
	e("<select name=p_tab_gasto id=p_tab_gasto onchange=\"el('frm_cad_gasto').submit()\" >");
		e("<option ".($p_tab_gasto == 99 ? "selected" : "")." value=99>Todos</option>");
		$qTabGasto = "SELECT id, ds_tipo FROM gst_tab_tipo g order by 2";
		e(processaSelect($qTabGasto, $p_tab_gasto));
	e("</select>");
	e("<button>$ico_pesquisar</button>");
	e("</form><br>");
	//<input type="text" name="vl_gasto" id="vl_gasto" readonly inputmode="numeric" style="font-size: 16px;" size=8 onkeyup="formatarMoeda(this);"  value="">
if ($p_ano <> "" and $p_mes <> "") {
	$qGasto = "
select 	g.id, 
				date_format(g.dt_gasto, '%d/%m/%Y'), 
				g.vl_gasto,
				t.ds_tipo, 
				g.fk_movimento, 
				concat(f.ds_forma_pagto, ' ', coalesce(q.nm_pessoa, ''), ' (', if(p.tp_pagto = 'C', 'Cr', 'Co'), ')'),
				g.obs, 
				tg.ds_tag, 
				if(g.nr_parcelas = 1, '', g.nr_parcelas),
				'' quem
from gst_gastos g
left join gst_tab_subtipo s on s.id = g.fk_subtipo
left join gst_tab_tipo t on t.id = s.fk_tipo
left join gst_tab_tag tg on tg.id = s.fk_tag
left join gst_tab_pagto p on p.id = g.fk_pagto
left join gst_tab_forma_pagto f on f.id = p.fk_forma_pagto
left join tab_quem q on q.id = p.fk_quem
WHERE DATE_FORMAT(g.dt_gasto,'%Y') = $p_ano
and   DATE_FORMAT(g.dt_gasto,'%m') = $p_mes 
". ($p_tab_gasto <> 99 ? " and s.fk_tipo = $p_tab_gasto " : "") ."
order by g.dt_gasto desc, t.ds_tipo";
// e($qGasto);
	$b1 = new bd;
	$b1->prepara($qGasto);
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
		if ($row[4] == 2) {
			$subtotal -=  $row[2];			
			$total -=  $row[2];			
		} else {
			$subtotal +=  $row[2];			
			$total +=  $row[2];			
		}
		$qQuemGasto = "SELECT distinct t.nm_pessoa
FROM gst_gastos_quem g
inner join tab_quem t on t.id = g.fk_quem
where fk_gasto = $row[0]
order by 1";
		$txt = "";
		$b2 = new bd;
		$b2->prepara($qQuemGasto);
		$ctg = 0;
		while($tg = $b2->consulta()){
			$txt .= ($ctg == 0 ? "" : ", ") . u8($tg[0]);
			$ctg++;
		}
		$linhas[$a][9] = ($txt <> "" ? $txt : ""); 
		// echo $linhas[$a][1];
		$b2->libera();
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
}
desconectar();

?>
