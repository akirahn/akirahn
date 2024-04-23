<?php
$menu_off = 1;
include_once("../include/include_bd.php");
$fk_carro = 1;
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
	function modalGravar() {
		$("#nr_km").val($("#td_nr_km").html());
		$("#nr_km_rod").val($("#td_nr_km_rod").html());
		$("#nr_litros").val($("#td_nr_litros").html());
		$("#nr_media").val($("#td_nr_media").html());
		$("#nr_valor").val($("#td_nr_valor").html());
		gravarModalEdicao("frm_editar_uno", "<?=$dirApp?>frm_combustivel.php");
	}
//--------------------------------------------------------------------------------------------------
	function atualizaRodado() {
		if (el("ultimoKm").value == "" || el("td_nr_km").innerHTML == "") {
			el("td_nr_km_rod").innerHTML = "0";
		} else {
			v = el("td_nr_km").innerHTML - el("ultimoKm").value;
			el("td_nr_km_rod").innerHTML = (v < 0 ? 0 : v);
		}
	}
//--------------------------------------------------------------------------------------------------
	function atualizaMedia() {
		if (el("td_nr_km_rod").innerHTML == 0) {
			el("td_nr_media").innerHTML = 0;
		} else {
			v_litros = el("td_nr_litros").innerHTML;
			v_litros = v_litros.replace(",", ".");
			vl = parseFloat(el("td_nr_km_rod").innerHTML / parseFloat(v_litros)).toFixed(2);
			el("td_nr_media").innerHTML = vl.replace(".", ",");
		}
	}
//--------------------------------------------------------------------------------------------------	
	tituloModalEdicao("Combustível Uno");
</script>
<?php
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($p_edicao_opcao == "A" or $p_edicao_opcao == "I") {
	$nr_km 			= valor_sql($nr_km);
	$nr_km_rod 	= valor_sql($nr_km_rod);
	$nr_litros 	= valor_sql($nr_litros);
	$nr_media 	= valor_sql($nr_media);
	$nr_valor 	= valor_sql($nr_valor);
}
if ($p_edicao_opcao == "A" and $p_edicao_id <> "" ) {
	$update_combustivel	= "update app_combustivel set fk_carro = '$fk_carro', nr_km = $nr_km, nr_km_rod = $nr_km_rod, " .
												"nr_litros = $nr_litros, nr_media = $nr_media, dt_abastecimento = '$dt_abastecimento', nr_valor = $nr_valor ".
												" where id_combustivel = $p_edicao_id";
	$resultado = executa_sql($update_combustivel, "Dados combustivel (". dformat($dt_abastecimento) .") alterado com sucesso");
	e($resultado);
	$p_edicao_id = "";
	die;
}

if ($p_edicao_opcao == "I" and $p_edicao_id == "" ) {
	$dt_pagto = calculaVencimento($fk_pagto, $dt_abastecimento);	
	$insert_gastos = "insert into gst_gastos  (dt_gasto, vl_gasto, fk_movimento, fk_pagto, obs, fk_subtipo, dt_pagto, nr_parcelas) values ".
									 " ('$dt_abastecimento', $nr_valor, 2, $fk_pagto, 'Abastecimento Uno', 15, '$dt_pagto', 1)";
	$resultado = executa_sql($insert_gastos, "Gasto com abastecimento em ". dformat($dt_abastecimento) ." incluído com sucesso");
	if ($erro_sql == 0) {		
		e($resultado);
		$fk_gastos = $ultimo_sql_id;
		$insert_combustivel	= "insert into app_combustivel (fk_carro, nr_km, nr_km_rod, nr_litros, nr_media, dt_abastecimento, nr_valor, fk_gastos) values ".
												  "	('$fk_carro', $nr_km, $nr_km_rod, $nr_litros, $nr_media, '$dt_abastecimento', $nr_valor, $fk_gastos)";
		$resultado = executa_sql($insert_combustivel, "Combustivel incluído com sucesso");
		e("<br>$resultado");
		$p_edicao_id = "";
	}
	die;
}

if ($p_edicao_opcao == "PI" and $p_edicao_id == "" ) {
	$p_edicao_opcao = "I";
	$dt_abastecimento = date("Y-m-d");
	$qMaxCombustivel = "select max(nr_km) from app_combustivel c where c.fK_carro = $fk_carro";
	$maxCombustivel = pesquisa($qMaxCombustivel, 0);
	$fk_carro 				= ($fk_carro <> "" ? $fk_carro : "");
	$nr_km_rod = 0;
	$nr_media = "0,00";
}

if ($p_edicao_opcao == "PA" and $p_edicao_id <> "" ) {
	$qCombustivel = "select id_combustivel, fk_carro, nr_km, ". my_nformat("nr_km_rod"). ", ". my_nformat("nr_litros").", ". my_nformat("nr_media").", dt_abastecimento, ".
									 my_nformat("nr_valor"). ", fk_gastos
									 from app_combustivel t where id_combustivel = $p_edicao_id order by nr_km desc" ;
	$combustivel = pesquisa($qCombustivel);
	$qMaxCombustivel = "select max(nr_km) from app_combustivel c where c.fK_carro = $fk_carro and dt_abastecimento <
											(select dt_abastecimento
											 from app_combustivel c1
											 where c1.id_combustivel = $p_edicao_id
											 and c1.fk_carro = c.fK_carro)";
	$maxCombustivel = pesquisa($qMaxCombustivel, 0);
	$id_combustivel 	= $combustivel[0];
	$fk_carro 				= $combustivel[1];
	$nr_km 						= $combustivel[2];
	$nr_km_rod 				= $combustivel[3];
	$nr_litros 				= $combustivel[4];
	$nr_media 				= $combustivel[5];
	$dt_abastecimento = $combustivel[6];
	$nr_valor 				= $combustivel[7];
	$fk_gastos 				= $combustivel[8];
	$qGasto = "select fk_pagto from gst_gastos where id = $fk_gastos";
	$fk_pagto = pesquisa($qGasto, 0);
	$p_edicao_opcao = "A";
}
	
?>
<form name=frm_editar_uno id=frm_editar_uno method=post action=<?=$self?> >
	<input type="hidden" name="fk_carro" 				id="fk_carro" value=1>
	<input type="hidden" name="ultimoKm" 				id="ultimoKm" value="<?=$maxCombustivel?>">
	<input type="hidden" name="p_edicao_opcao" 	id="p_edicao_opcao" value="<?=$p_edicao_opcao?>">
	<input type="hidden" name="p_edicao_id" 		id="p_edicao_id" value="<?=$p_edicao_id?>">
	<input type="hidden" name="nr_km" 					id="nr_km">
	<input type="hidden" name="nr_litros" 			id="nr_litros">
	<input type="hidden" name="nr_valor" 				id="nr_valor">
	<input type="hidden" name="nr_km_rod" 			id="nr_km_rod">
	<input type="hidden" name="nr_media" 				id="nr_media">
	<table width=100% border=1>
		<td colspan=2 align=center>
		<?php campo_data("dt_abastecimento"); ?>
		</td>
		</tr>
	<td width=50%>
		<table width=100%>
		<td width=20%>KM Rodado</td>
		<td align=right id="td_nr_km_rod" class=uno_descricao><?=$nr_km_rod?></td>
		</tr>
		<td>Média</td>
		<td align=right id="td_nr_media" class=uno_descricao><?=$nr_media?></td>
		</tr>
		<td>KM</td>
		<td align=right id="td_nr_km" class=uno><?=$nr_km?></td>
		</tr>
		<td>Litros</td>
		<td align=right id="td_nr_litros" class=uno><?=$nr_litros?></td>
		</tr>
		<td>R$</td>
		<td align=right id="td_nr_valor" class=uno><?=$nr_valor?></td>
		</tr>
		</table>
		</td>
		</tr>
		<td>
	<?php
		$campos_teclado_numerico = array("td_nr_km", "I", "td_nr_litros", "D", "td_nr_valor", "D");
		monta_teclado_numerico($campos_teclado_numerico);
	?>
		</td>
	</table>
<br><br>
<?php
	RadioGrupoFormaPagto("fk_pagto", $fk_pagto);
?>			
	</form>
<script>
	$(document).ready(function(){
		$("#indice_teclado_numerico").change(function(){
			var itn = $("#indice_teclado_numerico").val();
			if (itn == 1) { atualizaRodado(); }
			if (itn == 2) { atualizaMedia(); }
		});
	});
</script>