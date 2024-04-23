﻿<?php
$tituloPagina = "Episódio";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_cabeca(p_id_cabeca) {
		$("#nome_frm_modal").val("frm_cabeca");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_cabeca.php?p_edicao_opcao=PA&p_edicao_id="+p_id_cabeca);
	}
//--------------------------------------------------------------------------------------------------
	function incluir_cabeca() {
		$("#nome_frm_modal").val("frm_cabeca");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_cabeca.php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
	function excluir_cabeca(p_id_cabeca) {
		excluir_id(p_id_cabeca, 'app_cabeca', 'frm_cabeca');
	}
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $spc, $a, $ico_editar, $ico_excluir, $c, $botao_incluir, $p_quem;
	for($i=0; $i < $a; $i++) {
		if ($i == 0) {
			$colunas =($p_quem == "") ? 6 : 5;
			e("<th align=center colspan=$colunas><b>".u8($linhas[$i][1])."</b>"); 
			e("</td>");
			e("</tr>");
			if ($p_quem == "") {
				e("<th align=center>Quem</th>");
			}
			e("<th align=center>Hora</th>");
			e("<th align=center>Dor</th>");
			e("<th align=center>Remédio</th>");
			e("<th align=center>Alívio</th>");
			e("<th class=acao>");
			e($botao_incluir);
			e("</th>");
			e("</tr>");
			
		}
		if ($p_quem == "") {
			e("<td align=center>".u8($linhas[$i][6])."</td>");
		}
		e("<td align=center>".$linhas[$i][2]."</td>");
		e("<td align=center>".u8($linhas[$i][3])."</td>");
		e("<td align=center>".u8($linhas[$i][4])."</td>");
		e("<td align=center>".$linhas[$i][5]."</td>");
		e("<td class=acao><button class=btn onclick=\"editar_cabeca(".$linhas[$i][0].");\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_cabeca(".$linhas[$i][0].");\" align=center>$ico_excluir</button></td>");
		e("</tr>");
	}
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

$botao_incluir = "<button type=button onclick=\"incluir_cabeca();\">$ico_incluir</button>";

e("<form name=frm_cabeca id=frm_cabeca method=post action=$self >");
if ($p_ano == "") { $p_ano = date("Y"); }
if ($p_mes == "") {	$p_mes = date("m"); }
e("<button class=btn onclick=\"muda_mes_ano(-1)\">$ico_anterior</button>");
campo_select_ano("p_ano");
campo_select_mes("p_mes");
e("<button class=btn onclick=\"muda_mes_ano(1)\">$ico_posterior</button> ");
$qQuem = "select id, nm_pessoa from tab_quem where id in (1, 4) ";
e(processaRadio($qQuem, "p_quem", $p_quem));
e("$spc$spc  <button class=btn>$ico_pesquisar</button>");
// e("$spc$spc$spc<input type=button style='font-size: 18px; ' onclick=\"incluir_cabeca();\" value='+' >");
e($botao_incluir);
e("</form>"); 

if ($p_ano <> "" and $p_mes <> "") {
	$qCabeca = "
select 	c.id_cabeca, date_format(c.dt_cabeca, '%d/%m/%Y'), time_format(c.hr_cabeca, '%H:%i'), 
				case " . preparaCaseDominio("c.nr_grau", $dom_cabeca_grau) . " end, 
				r.ds_remedio, 
				case " . preparaCaseDominio("c.nr_grau_alivio", $dom_cabeca_grau_alivio) . "end,
				q.nm_pessoa
from app_cabeca c
inner join app_cab_remedio r on r.id = c.fk_remedio
inner join tab_quem q on q.id = c.fk_quem
WHERE DATE_FORMAT(dt_cabeca,'%Y') = $p_ano
and   DATE_FORMAT(dt_cabeca,'%m') = $p_mes
" . ($p_quem <> "" ? " and fk_quem = $p_quem " : "") ."
order by c.dt_cabeca desc, c.hr_cabeca desc";
// e($qCabeca);
	$b1 = new bd;
	$b1->prepara($qCabeca);
	$inicio = "";
	e("<table width=100% class=padrao>");
	$a = 0;
	$c = 0;
	while($row = $b1->consulta()){
		$linha = u8($row[1]);
		if ($inicio <> $linha) {
			if ($inicio <> "") { imprimir_array(); }
			$inicio = $linha;
			$a = 0;
			$c++;
		}
		$linhas[$a] = $row;
		// echo $linhas[$a][1];
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
}
desconectar();
?>