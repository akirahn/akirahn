<div class=tituloPagina>Contas</div><br><br>
<?
	$fluxo_movimento_id = 2;
	if ($dt_fluxo <> "" and $vl_fluxo <> "" and $fluxo_tipo_id <> "") {
		$vl_fluxo = replace(replace($vl_fluxo, ".", ""), ",", ".");
		if ($opFluxo == "I") {
			$qFluxo = "insert into fluxo 
	(dt_fluxo, vl_fluxo, fluxo_movimento_id, fluxo_tipo_id, dt_competencia, Obs) values 
 	('$dt_fluxo', $vl_fluxo, $fluxo_movimento_id, $fluxo_tipo_id, '$dt_fluxo', '$obs') ";
		} else {
			$qFluxo = "update fluxo 
	set dt_fluxo = '$dt_fluxo', 
			vl_fluxo = $vl_fluxo, 
			fluxo_movimento_id =  $fluxo_movimento_id, 
			fluxo_tipo_id = $fluxo_tipo_id,
			dt_competencia = '$dt_fluxo', 
			Obs = '$obs'
  where id_fluxo = $id_fluxo ";
		// echo $qFluxo;
		}
		$resultado = executa_sql($qFluxo, "Conta ".($opFluxo == "I" ? "incluída" : "alterada")." com sucesso");
		echo "<script> el('Mensagem').innerHTML = '$resultado'; </script>";
	}
	if ($id_editar_fluxo <> "" and $opFluxo == "I") {
		$id_fluxo = $id_editar_fluxo;
		$qEditarFluxo = "select dt_fluxo, vl_fluxo, fluxo_movimento_id, fluxo_tipo_id, membro_id, dt_competencia, obs
from fluxo
where id_fluxo = $id_fluxo";
		preparaSQL($qEditarFluxo);
		while($row = consultaSQL()){
			$dt_fluxo = $row[0];
			$vl_fluxo = replace($row[1], ".", ",");
			$fluxo_movimento_id = $row[2];
			$fluxo_tipo_id = $row[3];
			$membro = $row[4];
			$dt_competencia = $row[5];
			$obs = $row[6];
			$opFluxo = "A";
		}
	}
	if ($dt_fluxo == "") { $dt_fluxo = date('Y-m-d'); }
	if ($opFluxo == "") { $opFluxo = "I"; }
?>

<form name=editar_contas id=editar_contas method=post action=<?=$self?> >
	<input type=submit style="float: right;" value="Gravar">
	<input type="hidden" name=opFluxo id=opFluxo value="I">
	<input type=hidden name=op_menu id=op_menu value=3>
	<input type="hidden" name="id_fluxo" id="id_fluxo" value="<?=$id_fluxo?>">
	<label>Data <input type="date" name="dt_fluxo" value="<?=$dt_fluxo;?>" ></label>
	<br><br>
	<div class=div_radio>
<?php
	if ($fluxo_tipo_id == "") { $fluxo_tipo_id = 4; }
	$qFluxoTipo = "SELECT id, ds_fluxo_tipo FROM fluxo_tipo f WHERE tp_fluxo_tipo = 'C' order by 2";
	e(processaRadio($qFluxoTipo, "fluxo_tipo_id", $fluxo_tipo_id));
?>			

	</div>
	<br><br>
	<label>Data <input type="month" name="dt_competencia" value="<?=$dt_competencia?>"></label>
	<br><br>
	<label>Valor <input type="text" name="vl_fluxo" inputmode="numeric"  onkeyup="formatarMoeda(this);" value="<?=$vl_fluxo?>"></label>
</form>
