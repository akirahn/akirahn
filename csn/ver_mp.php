﻿<?php
if (!isset($opcaoPG)) {	$opcaoPG = ""; }
if ($opcaoMP == "M") {
	$p = "mensalidade";
	$op_menu = 1;
	$FluxoTipoMP = 1;
	$tituloMP = "Mensalidade";
} else {
	$p = "prestacao";
	$op_menu = 2;
	$FluxoTipoMP = 13;
	$tituloMP = "Prestação Terracap";
}

$qMP= "SELECT m.id, m.nm_apelido, m.vl_$p, m.proxima_$p from membro m where m.tipo_situacao_id = 1 and (m.vl_$p is not null and m.vl_$p <> 0) ";

if ($opcaoPG == "I" or $opcaoPG == "A") {
	include_once("incluir_mp.php");
}

$b1 = new bd;
$b1->prepara($qMP . "order by 2");
	echo "<center><label>Escolha data pagto: ";
	if ($dtMP == "") { $dtMP = DATE("Y-m-d"); }
	campo_data("dtMP");
	echo "</label><br><br>";
	while($row = $b1->consulta()){
		e("<div class=linha>");
		$txt_pagamento = u8($row[1])  . " - " . str_replace(".", ",", $row[2]) . " - ".substr($row[3], 5, 2)."/".substr($row[3], 0, 4);
		e("<div align=center class='coluna-97'>$txt_pagamento<button onclick=\"pagarMP($row[0]);\"><i class='fa fa-credit-card'></i> Pagar </button></div>");
		e("</div>");
	}
$b1->libera();

?>
<form name=editar_mp id=editar_mp method=post action="<?=$self?>">
	<input type=hidden name=indicePG id=indicePG>
	<input type=hidden name=dtPG id=dtPG>
	<input type=hidden name=opcaoPG value="I">
	<input type=hidden name=opcaoMP value=<?=$opcaoMP?>  >
	<input type=hidden name=op_menu value=<?=$op_menu?>  >
</form>
