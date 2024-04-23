﻿<?php
	$tituloPagina = "Pagar Contas";
	include_once("include.php");
	
	if (!isset($dt_fluxo)) { $dt_fluxo = "" ; }
	if (!isset($id_editar_fluxo)) { $id_editar_fluxo = "" ; }
	if (!isset($opFluxo)) { $opFluxo = "" ; }
	if (!isset($p_ano)) { $p_ano = "" ; }
	if (!isset($fluxo_tipo_id)) { $fluxo_tipo_id = "" ; }
	if (!isset($vl_fluxo)) { $vl_fluxo = "" ; }
	if (!isset($membro)) { $membro = "" ; }
	if (!isset($dt_competencia)) { $dt_competencia = "" ; }
	if (!isset($obs)) { $obs = "" ; }

	$qFluxoTipo = "SELECT id, ds_fluxo_tipo FROM fluxo_tipo f WHERE tp_fluxo_tipo = 'C' ";
	
	$fluxo_movimento_id = 2;
	if ($dt_fluxo <> "" and $vl_fluxo <> "" and $fluxo_tipo_id <> "") {
		$vl_fluxo = valor_sql($vl_fluxo);
		
		if ($opFluxo == "I") {
			$tipo_fluxo = u8(pesquisa("$qFluxoTipo and id = $fluxo_tipo_id ", 1));
			$qFluxo = "insert into fluxo 
	(dt_fluxo, vl_fluxo, fluxo_movimento_id, fluxo_tipo_id, dt_competencia, Obs) values 
 	('$dt_fluxo', $vl_fluxo, $fluxo_movimento_id, $fluxo_tipo_id, '$dt_fluxo', '$obs') ";
		$dt_fluxo = date('Y-m-d');
		$id_editar_fluxo = "";
		$vl_fluxo = "";
		$fluxo_tipo_id = 4;
		} else {
			$qFluxo = "update fluxo 
	set dt_fluxo = '$dt_fluxo', 
			vl_fluxo = $vl_fluxo, 
			fluxo_movimento_id =  $fluxo_movimento_id, 
			fluxo_tipo_id = $fluxo_tipo_id,
			dt_competencia = '$dt_fluxo', 
			Obs = '$obs'
  where id_fluxo = $id_fluxo ";
		//echo $qFluxo;
		}
		$resultado = executa_sql($qFluxo, "Pagamento de Conta ($tipo_fluxo) ".($opFluxo == "I" ? "efetuada" : "alterada")." com sucesso");
		if (mb_strpos($resultado, "alterada") !== false) {
			$resultado .= "<button onclick='voltar_fluxo1()'>Voltar</button>";
		}
		echo "<script> el('Mensagem').innerHTML = '$resultado'; </script>";
	}
	if ($id_editar_fluxo <> "" and $opFluxo == "I") {
		$id_fluxo = $id_editar_fluxo;
		$qEditarFluxo = "select dt_fluxo, vl_fluxo, fluxo_movimento_id, fluxo_tipo_id, membro_id, date_format(dt_competencia, '%Y-%m'), obs
from fluxo
where id_fluxo = $id_fluxo";
		$b1 = new bd;
		$b1->prepara($qEditarFluxo);
		while($row = $b1->consulta()){
			$dt_fluxo = $row[0];
			$vl_fluxo = replace($row[1], ".", ",");
			$fluxo_movimento_id = $row[2];
			$fluxo_tipo_id = $row[3];
			$membro = $row[4];
			$dt_competencia = $row[5];
			$obs = $row[6];
			$opFluxo = "A";
		}
		$b1->libera();
	}
	if ($dt_fluxo == "") { $dt_fluxo = date('Y-m-d'); }
	if ($dt_competencia == "") { $dt_competencia = date('Y-m'); }
	if ($opFluxo == "") { $opFluxo = "I"; }

?>

<form name=editar_contas id=editar_contas method=post action=<?=$self?> >
	<input type=hidden name=opFluxo  id=opFluxo  value=<?=$opFluxo?> >
	<input type=hidden name=op_menu  id=op_menu  value=3>
	<input type=hidden name=id_fluxo id=id_fluxo value="<?=$id_fluxo?>">
	<label>Data 
	<?php campo_data("dt_fluxo"); ?>	
	</label>
	<br><br>
	<div class=div_radio>
<?php
	if ($fluxo_tipo_id == "") { $fluxo_tipo_id = 4; }
	e(processaRadio("$qFluxoTipo  order by 2", "fluxo_tipo_id", $fluxo_tipo_id), 1);
	desconectar();
?>			

	</div>
	<br><br>
	<label>Competência <br>
	<?php campo_mes("dt_competencia"); ?>				
	</label>
	<br><br>
	<label>Valor <input type="text" name="vl_fluxo" inputmode="numeric"  size=5 onkeyup="formatarMoeda(this);" value="<?=$vl_fluxo?>"></label>
	<button type=submit><?=$ico_gravar?></button>
</form>
