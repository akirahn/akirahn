<?php
if (!isset($opcaoCancelar)) {	$opcaoCancelar = ""; }
if ($opcaoMP == "M") {
	$p = "mensalidade";
	$op_menu = 1;
	$fluxo_tipo_id = 1;
} else {
	$p = "prestacao";
	$op_menu = 2;
	$fluxo_tipo_id = 13;
}

$qMP= "select m.id, max(dt_competencia), m.nm_apelido, date_format(max(dt_competencia), '%m/%Y') 
from fluxo f, membro m
where fluxo_tipo_id = $fluxo_tipo_id
and f.membro_id = m.id
and m.vl_$p <> 0
group by nm_apelido 
order by 3";
// e($qMP);

if ($opcaoCancelar == "C") {
	include_once("cancelar_mp.php");
}

$b1 = new bd;
$b1->prepara($qMP);
	echo "<center>";//<div class='btn-group'>";
	while($row = $b1->consulta()){
		$qFluxo = "select id_fluxo, date_format(dt_fluxo, '%d/%m/%Y')
from fluxo f
where f.fluxo_tipo_id = $fluxo_tipo_id
and f.dt_competencia = '$row[1]'
and f.membro_id = $row[0]";
		$fluxo = pesquisa($qFluxo);
		e("<div class=linha>");
		$txt_pagamento = u8($row[2])  . " - " . $row[3] . " - " . $fluxo[1];
		e("<div align=center class='coluna-97'>$txt_pagamento<button onclick=\"cancelarMP($fluxo[0]);\"><i class='fa fa-ban'></i> Cancelar</button></div>");
		e("</div>");
		// e("<button onclick=\"cancelarMP($fluxo[0]);\">". u8($row[2])  . " - " . $row[3] . " - " . $fluxo[1] .  " </button>");
	}
	// e("</div>");
$b1->libera();

?>
<form name=cancelar_mp id=cancelar_mp method=post action="<?="$self"?>">
	<input type=hidden name=indiceCancelar id=indiceCancelar>
	<input type=hidden name=opcaoCancelar value="C">
	<input type=hidden name=opcaoMP value=<?=$opcaoMP?>  >
	<input type=hidden name=op_menu value=<?=$op_menu?>  >
</form>
