﻿<?php
$menu_off = 1;
include_once("../include/include_bd.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function modalGravar() {
		$("#vl_gasto").val($("#div_vl_gasto").html());
		gravarModalEdicao("frm_editar_gastos", "<?=$dirApp?>frm_financas.php");
	}	
//--------------------------------------------------------------------------------------------------
	function carrega_subtipo_radio(p_tipo, p_sub) {
		var qtd_as = ar_subtipo[p_tipo].length;
		var str_subtipo = "";
		var tem = -1;
		for(i = 0; i < qtd_as; i++) {
			if (p_sub != "" &p_sub == ar_subtipo[p_tipo][i][0]) {
				tem = i;
			}
			str_subtipo += "<input type=radio name=fk_subtipo id=fk_subtipo"+i+" value="+ar_subtipo[p_tipo][i][0]+" ><label for='fk_subtipo"+i+"'>"+ar_subtipo[p_tipo][i][1]+"</label>";
		}
		if (str_subtipo != "") {
			$('#fk_subtipo').html(str_subtipo);
		}
		if (tem != -1) {
			$("#fk_subtipo"+tem).prop( "checked", true );			
		}
	}
//--------------------------------------------------------------------------------------------------
	tituloModalEdicao("Edição Finanças");
</script>

<?php

//-----------------------------------------
function parcelamento() {
//-----------------------------------------
	global $vl_gasto, $fk_gastos, $dt_pagto, $parcelas, $resultado;
	$vl_parcela = round($vl_gasto / $parcelas, 2);
	$vl_soma = $vl_parcela * $parcelas;
	$vl_diferenca = round($vl_gasto - $vl_soma, 2);
	$dt_parcela = $dt_pagto;
	$vInsertParcela = "
insert into gst_parcelas
	(dt_pagto, vl_parcela, nr_parcela, fk_gastos) values ";
	$vInsertMultiplo = "";
	for($i=1; $i <= $parcelas; $i++) {
		$vl_parcela_ins = ($i == 1 ? ($vl_parcela + $vl_diferenca) : $vl_parcela );
		$vInsertMultiplo .= " ('$dt_parcela', $vl_parcela_ins, $i, $fk_gastos),";
		$dt_parcela = date("Y-m-d", strtotime("+1 month", strtotime($dt_parcela)));
	}
	if ($vInsertMultiplo <> "") {
		$vInsertMultiplo = exclui_ultimo_car($vInsertMultiplo) . ";";
		$vInsertParcela .= $vInsertMultiplo;
 // e($vInsertParcela);
		$erro_sql = 0;
		$resultado = executa_sql($vInsertParcela, "");
	} else {
		$erro_sql = 1;
		$resultado = "Parcelas não encontradas";
	}
	resultado();
	return $erro_sql;
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($p_edicao_opcao == "A" and $p_edicao_id <> "" ) {
	$vl_gasto = valor_sql($vl_gasto);
	$obs = u8d($obs);
	if ($fk_subtipo == "") { $fk_subtipo = "null"; }
	$dt_pagto = calculaVencimento($fk_pagto, $dt_gasto);
	$qUpdate = "update gst_gastos 
							set dt_gasto = '$dt_gasto', 
									vl_gasto = $vl_gasto, 
									fk_movimento = $fk_movimento, 
									fk_pagto = $fk_pagto, 
									fk_subtipo = $fk_subtipo, 
									dt_pagto = '$dt_pagto',
									obs = '$obs'
							where id = $p_edicao_id";
	// e($qUpdate);
	$erro_sql = 0;
	$resultado = executa_sql($qUpdate, "Finança (". dformat($dt_gasto). " $vl_gasto) alterado com sucesso");
	if ($p_edicao_id <> "" and $erro_sql == 0) {
		e($resultado);
		$qExcluirQuem = "delete from gst_gastos_quem where fk_gasto = $p_edicao_id";
		$resultado = executa_sql($qExcluirQuem, "");		
		if ($erro_sql == 0) {
			$erro_sql = quem_insert($p_edicao_id, $quem);
			if ($erro_sql == 0) { e("<br>Quem alterado com sucesso"); }
		}
	}
	if ($erro_sql == 0) {
		$p_edicao_id = "";
	}
	die;
}

if ($p_edicao_opcao == "I" and $p_edicao_id == "" ) {
	$obs = u8d($obs);
	$vl_gasto = valor_sql($vl_gasto);
	if ($fk_subtipo == "") { $fk_subtipo = "null"; }
	$dt_pagto = calculaVencimento($fk_pagto, $dt_gasto);
	$vInsert = "
insert into gst_gastos 
	(dt_gasto, vl_gasto, fk_movimento, fk_pagto, obs, fk_subtipo, dt_pagto, nr_parcelas) values 
 	('$dt_gasto', $vl_gasto, $fk_movimento, $fk_pagto, '$obs', $fk_subtipo, '$dt_pagto', '$parcelas') ";
	// e($vInsert);
	$ultimo_sql_id = "";
	$erro_sql = 0;
	$resultado = executa_sql($vInsert, "Gasto (". dformat($dt_gasto). " $vl_gasto) incluído com sucesso");
	if ($erro_sql == 0) {
		e($resultado);
		$fk_gastos = $ultimo_sql_id;			
		if ($parcelas > 1) {
			$erro_sql = parcelamento();
		} else {
			if ($quem <> "" and $fk_gastos <> "") {
				$erro_sql = quem_insert($fk_gastos, $quem);
				if ($erro_sql == 0) { e("<br>Quem incluído com sucesso."); }
			}
		}
		if ($erro_sql == 0) {		
			$p_edicao_id = "";
		}
	}
	die;
}

if ($p_edicao_opcao == "PI" and $p_edicao_id == "" ) {
	$p_edicao_opcao = "I";
	$dt_gasto 			= date("Y-m-d");
	$fk_movimento 	= "";
	$fk_tab_tipo		= "";
}

$qTabTipo = "SELECT id, ds_tipo FROM gst_tab_tipo order by 2";
$qSubTipo = "SELECT s.fk_tipo, s.id, tg.ds_tag
FROM gst_tab_subtipo s
inner join gst_tab_tag tg on tg.id = s.fk_tag
order by 1, 3";
$bst = new bd;
$bst->prepara($qSubTipo);
$c = 0;
$st = 0;
while($rst = $bst->consulta()){
	if ($st <> $rst[0]) {
		if ($c == 0) {
			e("<script>");
			e(" var ar_subtipo = []; \n");
		}
		e(" ar_subtipo[".$rst[0]."] = [];\n");
		$st = $rst[0];
		$c = 0;
		$s = 0;
	}
	e(" ar_subtipo[".$rst[0]."][$s] = [".$rst[1].",'".u8($rst[2])."'];\n");
	$s++;
	$c++;
}
$bst->libera();
if ($c > 0) {
	e("</script>");		
}


if ($p_edicao_opcao == "PA" and $p_edicao_id <> "" ) {
	$p_edicao_opcao = "A";
	$qFinancas = "SELECT dt_gasto, format(vl_gasto, 2, 'de_DE'), s.fk_tipo, fk_movimento, obs, fk_subtipo, fk_pagto, fk_tipo
FROM gst_gastos g
left join gst_tab_subtipo s on s.id = g.fk_subtipo
where g.id = $p_edicao_id";
	$f = pesquisa($qFinancas);
	$dt_gasto				= $f[0];
	$vl_gasto				= $f[1];
	$fk_tab_tipo		= $f[2];
	$fk_movimento		= $f[3];
	$obs						= u8($f[4]);
	$fk_subtipo			= $f[5];
	$fk_pagto				= $f[6];
	$fk_tipo				= $f[7];
	$qTabQuem = "SELECT concat(';',fk_quem) FROM gst_gastos_quem g where fk_gasto = $p_edicao_id";
	$txt = "";

	$b1 = new bd;
	$b1->prepara($qTabQuem);
	while($row = $b1->consulta()){
		$txt .= $row[0];
	}
}
	if ($vl_gasto == "") {
		$vl_gasto = "0,00";
	}
	//<input type="text" name="vl_gasto" id="vl_gasto" readonly inputmode="numeric" style="font-size: 16px;" size=8 onkeyup="formatarMoeda(this);"  value="">
?>
<center>
<form name=frm_editar_gastos id=frm_editar_gastos method=post action=<?=$self?> >
	<input type="hidden" name="p_edicao_opcao" 	id="p_edicao_opcao" value="<?=$p_edicao_opcao?>">
	<input type="hidden" name="p_edicao_id" 		id="p_edicao_id" 		value="<?=$p_edicao_id?>">
	<input type="hidden" name="id_gasto" 				id="id_gasto" 			value="<?=$p_edicao_id?>">
	<input type="hidden" name="vl_gasto" 				id="vl_gasto">
	<input type="hidden" name="temp_subtipo" 		id="temp_subtipo">
	</label>
	<?php
		// <label>R$ <div id="div_vl_gasto" class=class_input style="font-size: 16px; text-align: right; width: 40px; float: right;"><=$vl_gasto></div>
		// monta_teclado_numerico(array("div_vl_gasto", "D"));
		monta_teclado_numerico(array("div_vl_gasto", "TD"));
		e("<script>$('#div_vl_gasto').html('$vl_gasto');</script>");
	// <br><br>
	?>
	<br><br>
	<label>
<?php campo_data("dt_gasto"); ?>	
	</label>
	<br><br>
<?php
	$qFluxoMovimento = "SELECT id, ds_fluxo_movimento FROM fluxo_movimento f order by 2 desc";
	e(processaRadio($qFluxoMovimento, "fk_movimento", $fk_movimento, "", "", "radio2"));
	enl();
	enl();
	campo_parcelas("parcelas", 1);
?>
	<br><br>
	<label>Tipo<br>
<?php
	e(processaRadio($qTabTipo, "fk_tab_tipo", $fk_tab_tipo, "", "carrega_subtipo_radio(this.value, '');"));
?>			
	</label>
	<br><br>
	<label>SubTipo <br>
		<div id=fk_subtipo class=div_radio></div>
	</label>
	<br><br>
<?php
	RadioGrupoFormaPagto("fk_pagto", $fk_pagto);
?>			
				<label>Quem<br>
				<div class=radio>
<?php
	$qQuem = "select id, nm_pessoa from tab_quem order by 2";
	e(processaCheckBox($qQuem, "quem[]"));
?>
				</div>
				</label><br><br>
				<label>Obs <input type=text name=obs id=obs value="<?=$obs;?>"></label>
			</form>
			</center>
			
<script>
	if ($("#id_gasto").val() != "") {
		<?php 
			if ($p_edicao_id <> "") {
				e("carrega_subtipo_radio($fk_tab_tipo, $fk_subtipo);");
			}
		?>
		var dados = $('#frm_editar_gastos').serialize();
		$.ajax({
				type : 'POST',
				dataType: 'TEXT',
				url  : "buscar_quem.php",
				data: dados,
				success :  function(data){
					valores = data.split(";");
					for(i=1; i < valores.length; i++) {
						$("#quem"+valores[i]).prop( "checked", true );
					}
				}
		});
	}
</script>