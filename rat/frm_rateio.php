<?php
$menu_off = 1;
include_once("../include/include_bd.php");
include_once("rat.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function modalGravar() {
		$("#vl_rateio").val($("#div_vl_rateio").html());
		gravarModalEdicao("frm_editar_rateios", "<?=$dirApp?>frm_rateio.php");
	}	
//--------------------------------------------------------------------------------------------------
	tituloModalEdicao("Edição rateio");
</script>

<?php

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($p_edicao_opcao == "A" or $p_edicao_opcao == "I") {
	$ds_rateio_msg = $ds_rateio;
	$ds_rateio = u8d($ds_rateio);
	$ds_detalhe = u8d($ds_detalhe);
	$vl_rateio = valor_sql($vl_rateio);
	$tp_pagamento = ($tp_pagamento == "" ? 0 : $tp_pagamento);
}

if ($p_edicao_opcao == "A" and $p_edicao_id <> "" ) {
	$qUpdate = "update rat_cadastro 
							set ds_rateio      = '$ds_rateio'    ,
									dt_rateio      = '$dt_rateio'    ,
									ds_detalhe     = '$ds_detalhe'   ,
									vl_rateio      = $vl_rateio      ,
									nr_parcelas    = $nr_parcelas    ,
									dia_vencimento = $dia_vencimento ,
									tp_pagamento   = $tp_pagamento   ,
									fk_tipo        = $fk_tipo        ,
									sn_ativo       = $sn_ativo       								
							where id = $p_edicao_id";
	// e($qUpdate);
	$erro_sql = 0;
	$resultado = executa_sql($qUpdate, "Rateio ($ds_rateio_msg) alterado com sucesso");
	e($resultado);
	if ($erro_sql == 0) {
		$p_edicao_id = "";
	}
	die;
}

if ($p_edicao_opcao == "I" and $p_edicao_id == "" ) {
	$vInsert = "
insert into rat_cadastro 
	(ds_rateio, dt_rateio, ds_detalhe, vl_rateio, nr_parcelas, dia_vencimento, tp_pagamento, fk_tipo, sn_ativo) values 
	('$ds_rateio', '$dt_rateio', '$ds_detalhe', $vl_rateio, $nr_parcelas, $dia_vencimento, $tp_pagamento, $fk_tipo, $sn_ativo) ";
	// e($vInsert);
	$ultimo_sql_id = "";
	$erro_sql = 0;
	$resultado = executa_sql($vInsert, "Rateio ($ds_rateio_msg) incluído com sucesso");
	e($resultado);
	die;
}

if ($p_edicao_opcao == "PI" and $p_edicao_id == "" ) {
	$p_edicao_opcao = "I";
	$dt_rateio 			= date("Y-m-d");
	$fk_tipo				= "";
}

$qTabTipo = "SELECT id, ds_tipo_rateio FROM rat_tab_tipo order by 2";

if ($p_edicao_opcao == "PA" and $p_edicao_id <> "" ) {
	$p_edicao_opcao = "A";
	$qRateio = "SELECT ds_rateio, dt_rateio, ds_detalhe, format(vl_rateio, 2, 'de_DE'), nr_parcelas, dia_vencimento, tp_pagamento, fk_tipo, sn_ativo
FROM rat_cadastro r
inner join rat_tab_tipo t on t.id = r.fk_tipo
where r.id = $p_edicao_id";
	$f = pesquisa($qRateio);
	$ds_rateio      = u8($f[0]);
	$dt_rateio      = $f[1];
	$ds_detalhe     = u8($f[2]);
	$vl_rateio      = $f[3];
	$nr_parcelas    = $f[4];
	$dia_vencimento = $f[5];
	$tp_pagamento   = $f[6];
	$fk_tipo        = $f[7];
	$sn_ativo       = $f[8];
}

if ($vl_rateio == "") {
	$vl_rateio = "0,00";
}

	//<input type="text" name="vl_rateio" id="vl_rateio" readonly inputmode="numeric" style="font-size: 16px;" size=8 onkeyup="formatarMoeda(this);"  value="">
?>
<center>
<form name=frm_editar_rateios id=frm_editar_rateios method=post action=<?=$self?> >
	<input type="hidden" name="p_edicao_opcao" 	id="p_edicao_opcao" value="<?=$p_edicao_opcao?>">
	<input type="hidden" name="p_edicao_id" 		id="p_edicao_id" 		value="<?=$p_edicao_id?>">
	<input type="hidden" name="id_rateio" 			id="id_rateio" 			value="<?=$p_edicao_id?>">
	<input type="hidden" name="vl_rateio" 			id="vl_rateio">
	<input type="hidden" name="ds_tipo_rateio" 	id="ds_tipo_rateio">
	</label>
	<?php
		monta_teclado_numerico(array("div_vl_rateio", "TD"));
		e("<script>$('#div_vl_rateio').html('$vl_rateio');</script>");
	?>
	
	<label>Descrição: </label><input type=text name=ds_rateio id=ds_rateio value="<?=$ds_rateio?>" size=40><br><br>
	
	
	<label><?php campo_data("dt_rateio"); ?></label><br><br>
	
	<label>Vencimento: </label><input type=number name=dia_vencimento id=dia_vencimento value="<?=$dia_vencimento?>" style="width: 40px; text-align: center; "><br><br>
	
	<label>Detalhe:<br><textarea name=ds_detalhe id=ds_detalhe rows=3 cols=40><?=$ds_detalhe?></textarea></label><br><br>
	
	<?php campo_parcelas("nr_parcelas", $nr_parcelas); ?>
	<br><br>
	
	<label>Tipo Pagamento<br>
	<?php
		montaRadio($qTpPagamento, "tp_pagamento", $tp_pagamento);
	?>
	</label><br><br>
	
	<label>Tipo<br>
<?php
	e(processaRadio($qTabTipo, "fk_tipo", $fk_tipo, "", ""));
?>			
	</label>
	<br><br>
	
	<?php campo_checkbox("sn_ativo", "1", "Ativo", $sn_ativo); ?>
	<br><br>
	
</form>
</center>
