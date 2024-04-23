<?php
$tituloPagina = "Combustível Uno";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_combustivel(p_id_combustivel) {
		$("#nome_frm_modal").val("frm_combustivel");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_combustivel.php?p_edicao_opcao=PA&p_edicao_id="+p_id_combustivel);
	}
//--------------------------------------------------------------------------------------------------
	function incluir_combustivel() {
		$("#nome_frm_modal").val("frm_combustivel");
		mostra("modalEdicao");
		$('#modalConteudo').load("<?=$dirApp?>frm_combustivel.php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
	function excluir_combustivel(p_id_combustivel) {
		excluir_id(p_id_combustivel, 'app_combustivel', 'frm_combustivel');
	}
</script>

<?php
$tab_qtd_colunas = 4;
$tab_div_colunas = 29;
$tab_tabela = "app_combustivel";
$tab_colunas 			= array("Id", "", "", "");

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $subtotal, $a, $ico_excluir, $ico_incluir, $ico_editar;
	for($i=0; $i < $a; $i++) {
	}
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

e("<form name=frm_combustivel id=frm_combustivel method=post action=$self >");
e("<button type=submit>$ico_pesquisar</button>");
e("<button type=button onclick='incluir_combustivel();'>$ico_incluir</button>");
e("</form>");

$qCombustivel = "select id_combustivel, concat(" . my_nformat("nr_km", 0) ." , '<br>', " . my_nformat("nr_km_rod", 0)."), 
concat(".my_nformat("nr_litros").", '<br>', ".my_nformat("nr_media")."), 
concat(date_format(dt_abastecimento, '%d/%m/%Y'), '<br>', ".my_nformat("nr_valor"). ")
from app_combustivel t
inner join app_carro c on c.id_carro = fk_carro
where fk_carro = 1
order by dt_abastecimento desc";
// e($qMensal);
$b1 = new bd;
$b1->prepara($qCombustivel);
e("<table width=100% class=padrao>");
e("<th>KM/Rod</th>");
e("<th>Litros/<br>Média</th>");
e("<th>Data/R$</th>");
e("<th></th>");
e("</tr>");
$c = 0;
while($row = $b1->consulta()){
	e("<td align=center>$row[1]</td>");
	e("<td align=center>$row[2]</td>");
	e("<td align=center>$row[3]</td>");
	e("<td class=acao><button class=btn onclick=\"editar_combustivel(".$row[0].");\" align=center>$ico_editar</button>");
	e("<button class=btn onclick=\"excluir_combustivel(".$row[0].");\" align=center>$ico_excluir</button></td>");
	e("</tr>");
	$c++;
}
$b1->libera();
if ($c == 0) {
	e("<td colspan=5 align=center>Nenhum dado encontrado</td>");
}
e("</table>");
desconectar();
?>