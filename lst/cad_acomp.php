﻿<?php
$tituloPagina = "Acompanhamento";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function check_lista(p_id_lista) {
		$("#p_edicao_opcao").val("C");
		$("#p_edicao_id").val(p_id_lista);
		$("#sn_ativo").val(1);
		$('#frm_check_lista').submit();
	}
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
	function listar() {
		$('#frm_cad_lista').submit();
	}
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
			e("<th align=center>$ico_check</th>");
			e("</tr>");
		}
		e("<td align=center>".nformat($linhas[$i][2], 2)."</td>");
		e("<td align=center>".u8($linhas[$i][3])."</td>");
		e("<td class=acao><button class=btn onclick=\"check_lista(".$linhas[$i][0].");\" align=center>$ico_check</button>");
		e("</tr>");
	}
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($p_edicao_opcao == "C" and $p_edicao_id <> "" ) {
	$qCheck = "update lst_lista set sn_ativo = $sn_ativo where id = $p_edicao_id";
	$resultado = executa_sql($qCheck, "Item ($p_edicao_id) removido da Lista ($p_edicao_id) com sucesso");
	resultado();
	if ($erro_sql == 0) {
		$p_edicao_id = "";
		$p_edicao_opcao = "";
	}
}

	e("<form name=frm_cad_lista id=frm_cad_lista method=post action=$self >");
	e("<label>Grupo: </label>");
	if ($p_tab_grupo == "") { $p_tab_grupo = 99; }
	$qTabTipo = "SELECT id, ". prepara_coluna("ds_grupo") . " FROM lst_tab_grupo g order by 2";
	e("<input type=radio name=p_tab_grupo id=rdp_tab_grupo onchange=\"listar();\" ".($p_tab_grupo == "" ? "checked" : "")." value=''><label for=rdp_tab_grupo>Nenhum Grupo</label><br>");
	e(processaRadio($qTabTipo, "p_tab_grupo", $p_tab_grupo, "", "listar();"));
	// e("<br><button>$ico_pesquisar</button>");
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
and coalesce(l.sn_ativo, 0) = 0
order by ". prepara_coluna("g.ds_grupo") . ", ". prepara_coluna("i.ds_item") . ", id ";
// e($qlista);
	$b1 = new bd;
	$b1->prepara($qlista);
	$inicio = "";
	e("<table width=100% class=padrao cellspacing=0>");
	$a = 0;
	$c = 0;
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
<form name=frm_check_lista id=frm_check_lista method=post action=<?=$self?> >
<?php
	campo_hidden("p_edicao_opcao"		, $p_edicao_opcao);
	campo_hidden("p_edicao_id"		, $p_edicao_id);
	campo_hidden("p_tab_grupo"		, $p_tab_grupo, "p_tab_grupo_ck");
	campo_hidden("nr_qtd"		, $nr_qtd);
	campo_hidden("fk_grupo"	, $fk_grupo);
	campo_hidden("fk_item"	, $fk_item);
	campo_hidden("sn_ativo"	, $sn_ativo);
?>			
</form>
