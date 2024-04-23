﻿<?php
$tituloPagina = "Cadastro de Fluxo";
include_once("include.php");
?>
<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_fluxo(p_id_fluxo) {
		$("#nome_frm_modal").val("frm_fluxo");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_fluxo.php?p_edicao_opcao=PA&p_edicao_id="+p_id_fluxo);
	}
//--------------------------------------------------------------------------------------------------
	function incluir_fluxo() {
		$("#nome_frm_modal").val("frm_fluxo");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_fluxo.php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
	function excluir_fluxo(p_id_fluxo) {
		excluir_id(p_id_fluxo, 'fluxo', 'frm_fluxo');
	}
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $subtotal, $a, $ico_excluir, $ico_incluir, $ico_editar;
	for($i=0; $i < $a; $i++) {
		if ($i == 0) {
			$classe = ($subtotal < 0 ? "tipo_fluxo_negativo" : "tipo_fluxo");
			e("<th class=tipo_fluxo align=left colspan=3><b>".u8($linhas[$i][0])."</b></th>");
			e("<th class='$classe' align=right>".nformat($subtotal)."</th>");
			e("<th class=acao><button onclick=\"incluir_fluxo();\">$ico_incluir</button></th>");			
			e("</tr>");
		}
		e("<td align=center>".u8($linhas[$i][1])."</td>");
		e("<td align=center>".$linhas[$i][4]."</td>");
		$v = u8($linhas[$i][2]);
		// $v = substr($v, 0, 14);
		e("<td onclick='' align=left>$v</td>");
		$class_cd = ($linhas[$i][3] == "C" ? "positivo" : "negativo");
		e("<td align=right class=$class_cd>".nformat($linhas[$i][5])."</td>");
		//p_opFluxo, p_id_fluxo, p_dt_fluxo, p_fluxo_tipo_id, p_fluxo_movimento_id, p_vl_fluxo, p_membro_id, p_obs
		//f.id_fluxo, f.dt_fluxo, f.fluxo_tipo_id, f.fluxo_movimento_id, f.vl_fluxo, f.membro_id, f.dt_competencia, f.obs
		e("<td class=acao><button class=btn onclick=\"editar_fluxo(".$linhas[$i][9].");\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_fluxo(".$linhas[$i][7].");\" align=center>$ico_excluir</button></td>");
		e("</tr>");
	}
}
//-----------------------------------------
function total() {
//-----------------------------------------
	global $subtotal, $spc;
	e("<th align=right colspan=2><b>Total$spc</b></th>");
	$classe = ($subtotal < 0 ? "negativo" : "positivo_total");
	e("<th align=right class=$classe><b>".nformat($subtotal)."</b></th>");
}
//-----------------------------------------
function total_geral() {
//-----------------------------------------
	global $total, $spc;
	e("<th align=right colspan=3><b>Total Mês$spc</b></th>");
	$classe = ($total < 0 ? "negativo" : "positivo_total");
	e("<th align=right class=$classe><b>".nformat($total)."</b></th>");
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

e("<form name=frm_fluxo id=frm_fluxo method=post action=$self >");
e("<input type=hidden name=op_menu value=6><div align=center class=bloco_pesquisa><div>");
if ($p_ano == "") { $p_ano = date("Y"); }
if ($p_mes == "") { $p_mes = date("m"); }
if ($p_subfluxo == "") { $p_subfluxo = 99; }
botao_mes_ano(-1);
campo_select_ano("p_ano");
campo_select_mes("p_mes");
botao_mes_ano(1);
e("</div><div>");
// e("<br><br>");
e("<select name=p_subfluxo onchange=\"el('frm_fluxo').submit()\" >");
	//e("<option value=>Tipo</option>");
	e("<option ".($p_subfluxo == 99 ? "selected" : "")." value=99>Todos</option>");
	$qSubFluxo = "SELECT id, ds_fluxo_tipo FROM fluxo_tipo f order by 2";
	e(processaSelect($qSubFluxo, $p_subfluxo));		
e("</select>");
e("<button type=submit>$ico_pesquisar</button></div></div>");
e("</form>");
?>

<?php
if ($p_ano <> "" and $p_mes <> "" and $p_subfluxo <> "") {
	$dt_tipo = ($tp_regime == "X" ? "f.dt_fluxo" : "f.dt_competencia");
	$qMensal = "
SELECT date_format(f.dt_fluxo, '%d/%m/%Y'),
       t.ds_fluxo_tipo,
				coalesce(m.nm_apelido, obs), 
				mv.simbolo, 
				date_format(dt_competencia, '%m/%Y'), 
				vl_fluxo, 
				m.id, 
				f.id_fluxo, 
				t.tp_fluxo_tipo,
				f.id_fluxo, 
				f.dt_fluxo, 
				f.fluxo_tipo_id, 
				f.fluxo_movimento_id, 
				replace(f.vl_fluxo, '.', ','), 
				f.membro_id, 
				date_format(f.dt_competencia, '%Y-%m'), 
				f.obs
FROM fluxo f
inner join fluxo_tipo t
on f.fluxo_tipo_id = t.id
inner join fluxo_movimento mv
on f.fluxo_movimento_id = mv.id
left join membro m
on f.membro_id = m.id
WHERE DATE_FORMAT($dt_tipo,'%Y') = $p_ano
and   DATE_FORMAT($dt_tipo,'%m') = $p_mes
and   ($p_subfluxo = 99 or t.id = $p_subfluxo)
and   t.id not in (13, 14)
order by f.dt_fluxo desc, 2, 3";
// e($qMensal);
		$b1 = new bd;
		$b1->prepara($qMensal);
		$inicio = "";
		e("<table width=100% class=padrao>");
		$a = 0;
		$c = 0;
		$total = 0;
		$subtotal = 0;
		while($row = $b1->consulta()){
			$linha = u8($row[0]);
			if ($inicio <> $linha) {
				if ($inicio <> "") { imprimir_array(); }
				$inicio = $linha;
				$a = 0;
				$subtotal = 0;
				$c++;
			}
			$linhas[$a] = $row;
			if ($linhas[$a][3] ==  "C") {
				$subtotal += $linhas[$a][5];
				$total += $linhas[$a][5];
			} else {
				$subtotal -= $linhas[$a][5];
				$total -= $linhas[$a][5];
			}
			$a++;
			// echo $linhas[$a][1];
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
		
/*		
		e("<td></td>");
		e("");
*/		
}
desconectar();
?>