<?php
$qCancelaMP = "select membro_id, dt_competencia, vl_fluxo from fluxo where id_fluxo = '$indiceCancelar' ";

$tituloMP = ($opcaoMP == "M" ? "Mensalidade" : "Prestação Terracap");
$FluxoTipoMP = ($opcaoMP == "M" ? 1 : 13);

$b1 = new bd;
$b1->prepara($qCancelaMP);
// e($qCancelaMP);
while($row = $b1->consulta()){
	$membro_id = u8($row[0]);
	$dt_competencia	= $row[1];
	$vl_fluxo	= $row[2];
}
$b1->libera();

$dCancela = "delete from fluxo where id_fluxo = $indiceCancelar";
$uMembro = "update membro set proxima_$p = '$dt_competencia', vl_$p = $vl_fluxo where id = $membro_id ";

// echo $dCancela;
// echo $uMembro;

$resultado = executa_sql($dCancela, "$tituloMP cancelada com sucesso");
if ($resultado == "$tituloMP cancelada com sucesso") {
	$resultado = executa_sql($uMembro, "$tituloMP cancelada com sucesso");
}
?>
