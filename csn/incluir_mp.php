<?php
$qIncluiMP = $qMP . " and m.id = '$indicePG'";

$b1= new bd;
$b1->prepara($qIncluiMP);
// e($qIncluiMP);
while($row = $b1->consulta()){
	$membroPG = u8($row[1]);
	$vlPG 		= $row[2];
	$dtMensal	= $row[3];
}
$b1->libera();

$iMensalidade = "insert into fluxo 
									(dt_fluxo, vl_fluxo, membro_id, fluxo_movimento_id, fluxo_tipo_id, dt_competencia, Obs) values 
									('$dtPG',  $vlPG, '$indicePG', 1, $FluxoTipoMP, '$dtMensal', '')";
// e($iMensalidade);
$dt_mes_seguinte = date('Y-m-d', strtotime($dtMensal . " +1 month"));
$uMembro = "update membro set proxima_$p = '$dt_mes_seguinte' where id = $indicePG ";

// echo $iMensalidade;
// echo $uMembro;

$resultado = executa_sql($iMensalidade, "$tituloMP paga com sucesso");
if ($resultado == "$tituloMP paga com sucesso") {
	$resultado = executa_sql($uMembro, "$tituloMP paga com sucesso");
}
if ($resultado == "$tituloMP paga com sucesso") {
	echo "<script> el('Mensagem').innerHTML = '$resultado'; </script>";
}
$recibo= "Comprovante CSN\n\nRecebi de $membroPG a quantia de R$ $vlPG relativo à ".
				 ($opcaoMP == "M" ? " mensalidade " : " prestação da Terracap ") . " de " . dformat($dt_mes_seguinte).
				 " no dia ".dformat($dtPG) . ".";
// echo $recibo;
e("<script>");
e("vRecibo = preRecibo('$membroPG', '".nformat($vlPG)."', '" . dformat($dtPG) . "', '".dmformat($dtMensal)."', '$opcaoMP');");
e("mensagemRecibo(vRecibo);");
e("</script>");
?>
