<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="ISO-8859-1">
<title>AEpps</title>
<style>
	td, th { border: 1px solid #000000; }
</style>
<?php
include_once("include.php");
// Return name of current default database
$qMensalidade = "SELECT nm_apelido, vl_ultima_mensalidade, dt_mensalidade_a_pagar FROM membro m
where m.tipo_situacao_id = 'A'
and  sn_mensalidade = 'S'
order by 1";

preparaSQL($qMensalidade);
?>
<table width=100% cellspacing =0>
	<th>Nome</th>
	<th>Valor</th>
	<th>À Pagar</th>
	<th>Próximo Mês</th>
	</tr>
<?php
	while($row = consultaSQL()){
		echo "<td>$row[0]</td>";
		echo "<td>$row[1]</td>";
		echo "<td>".substr($row[2], 5, 2)."/". substr($row[2], 0, 4)."</td>";
		echo "<td>".date('Y-m-d', strtotime($row[2] . " +1 month"))."</td>";
		echo "</tr>";
	}
	echo "</table>";
  liberaSQL();

preparaSQL("select nm_apelido, nm_membro, tipo_situacao_id from membro where tipo_situacao_id = 'A' order by nr_ordem");
?>
<br>
<table width=100% cellspacing =0>
	<th>Apelido</th>
	<th>Nome</th>
	<th>Situação</th>
	</tr>
<?php
	while($row = consultaSQL()){
		echo "<td>$row[0]</td>";
		echo "<td>$row[1]</td>";
		echo "<td>$row[2]</td>";
		echo "</tr>";
	}
	echo "</table>";
  libera();


preparaSQL("select * from csn_fluxo ");
?>
<br>
<table width=100% cellspacing =0>
	<th>Tipo</th>
	<th>Data Fluxo</th>
	<th>Membro</th>
	</tr>
<?php
	while($row = consultaSQL()){
		echo "<td>$row[0]</td>";
		echo "<td>$row[1]</td>";
		echo "<td>$row[2]</td>";
		echo "</tr>";
	}
	echo "</table>";
  libera();

	desconectar();

?>