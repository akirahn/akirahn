<?php
	if ($dt_fluxo <> "" and $vl_fluxo <> "" and $fluxo_movimento_id <> "" and $fluxo_tipo_id <> "") {
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
		echo $qFluxo;
		}
		$resultado = executa_sql($qFluxo, "Fluxo ".($opFluxo == "I" ? "incluído" : "alterado")." com sucesso");
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

<form name=editar_fluxo id=editar_fluxo method=post>
	<input type="hidden" name="opFluxo" id="opFluxo" value="<?=$opFluxo?>">
	<input type="hidden" name="op_menu" id="op_menu" value="4">
	<input type="hidden" name="id_fluxo" id="id_fluxo" value="<?=$id_fluxo?>">
	<table width=100% cellspacing="5">
		<td width=50% valign=top style="border-right: 1px solid var(--branco); padding-left: 2px;">
			<label>Data <input type="date" name="dt_fluxo" size=5 value="<?=$dt_fluxo?>"></label>
			<br><br>
			<div class=div_radio>
<?php
	$qFluxoMovimento = "SELECT id, ds_fluxo_movimento FROM fluxo_movimento f order by 2";
	if ($fluxo_movimento_id == "") { $fluxo_movimento_id = 1; }
	e(processaRadio($qFluxoMovimento, "fluxo_movimento_id", $fluxo_movimento_id));
?>			
			</div>
			<br><br>
			<label>Valor <input type="text" name="vl_fluxo" inputmode="numeric" size=10 onkeyup="formatarMoeda(this);"  value="<?=$vl_fluxo?>"></label>
			<br><br>
			<label>Obs:  <input type="text" name="obs" size=15  value="<?=$obs?>"></label>
			<br><br>
		</td>
		<td width=35% style="border: 1px solid var(--cor-titulo);">
		<div class=div_radio>
			<br>
<?php
	$qFluxoTipo = "SELECT id, ds_fluxo_tipo FROM fluxo_tipo f WHERE tp_fluxo_tipo = 'F' order by 2";
	if ($fluxo_tipo_id == "") { $fluxo_tipo_id = 10; }
	e(processaRadio($qFluxoTipo, "fluxo_tipo_id", $fluxo_tipo_id, 1));
?>			
		</div>
		</td>
		<td = valign="top">
			<input type=submit style="float: right;" value="Gravar">			
		</td>
	</table>
</form>

