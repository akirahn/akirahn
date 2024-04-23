﻿<?php
$tituloPagina = "Cadastro";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_lista(p_id_lista) {
		$("#nome_frm_modal").val("frm_cad_lista");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_lista.php?p_edicao_opcao=PA&p_edicao_id="+p_id_lista);
	}
//--------------------------------------------------------------------------------------------------
	function incluir_lista() {
		$("#nome_frm_modal").val("frm_cad_lista");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_lista.php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
/*
	function abrir_lista(p_id_lista) {
		$("#nome_frm_modal").val("frm_cad_lista");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_parcelas.php?p_edicao_id="+p_id_lista);
	}
*/	
//--------------------------------------------------------------------------------------------------
	function excluir_lista(p_id_lista) {
		excluir_id(p_id_lista, 'lst_lista', 'frm_cad_lista');
	}
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $spc, $a, $ico_editar, $ico_excluir, $c, $ico_incluir, $subtotal, $p_tab_grupo, $ico_check, $ico_proibido, $ico_abrir;
	for($i=0; $i < $a; $i++) {
		if ($i == 0) {
			if ($p_tab_grupo == 99) {
				e("<th align=center colspan=4>".u8($linhas[$i][1])."</th>");	
				e("</tr>");				
			}
			e("<th align=center>Qtd</th>");
			e("<th align=center>Item</th>");
			e("<th align=center>Ativo</th>");
			e("<th class=acao>");
			e("<button onclick=\"incluir_lista();\">$ico_incluir</button>");
			e("</th>");
			e("</tr>");
		}
		e("<td align=center>".nformat($linhas[$i][2], 5)."</td>");
		e("<td align=center>".u8($linhas[$i][3])."</td>");
		$ativo = ($linhas[$i][4] == 1 ? $ico_check : "");
		e("<td align=center>".$ativo."</td>");
		e("<td class=acao><button class=btn onclick=\"editar_lista(".$linhas[$i][0].");\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_lista(".$linhas[$i][0].");\" align=center>$ico_excluir</button></td>");
		e("</tr>");
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

	e("<form name=frm_cad_lista id=frm_cad_lista method=post action=$self >");
	if ($p_tab_grupo == "") { $p_tab_grupo = 99; }
	e("<label>Grupo: </label>");
	e("<select name=p_tab_grupo id=p_tab_grupo onchange=\"el('frm_cad_lista').submit()\" >");
		e("<option ".($p_tab_grupo == 99 ? "selected" : "")." value=99>Todos</option>");
		$qTabTipo = "SELECT id, ". prepara_coluna("ds_grupo") . " FROM lst_tab_grupo g order by 2";
		e(processaSelect($qTabTipo, $p_tab_grupo));
	e("</select>");
	e("<br><br>");
	$qSimNao = array("", "Todos", "0", "Sim", "1", "Não");
	e("<label class=radio>Ativo: ");
	montaRadio($qSimNao, "p_sn_ativo", $p_sn_ativo);
	e("</label> ");
	e(" <button>$ico_pesquisar</button>");
	e("<button type=button onclick=\"incluir_lista();\">$ico_incluir</button>");
	e("</form><br>");
	$qlista = "
select 	l.id, 
				". prepara_coluna("g.ds_grupo") . ", 
				l.nr_qtd,
				". prepara_coluna("i.ds_item") . ",
				l.sn_ativo
from lst_lista l
inner join lst_tab_grupo g on g.id = l.fk_grupo
inner join lst_tab_item i on i.id = l.fk_item
WHERE 1 = 1
". ($p_tab_grupo <> 99 ? " and l.fk_grupo = $p_tab_grupo " : "") ."
". ($p_sn_ativo <> "" ? " and l.sn_ativo = $p_sn_ativo " : "") ."
order by ". prepara_coluna("g.ds_grupo") . ", ". prepara_coluna("i.ds_item") . ", id ";
// e($qlista);
	$b1 = new bd;
	$b1->prepara($qlista);
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
		$a++;
	}
	if ($c > 0) {
		imprimir_array();
	}
	$b1->libera();
	if ($c == 0) {
		e("<td colspan=5 align=center>Nenhum dado encontrado</td>");
	}
	e("</table>");
desconectar();

?>
