﻿<?php
$menu_off = 1;
include_once("../include/include_bd.php");

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($p_edicao_opcao == "A" and $p_edicao_id <> "" ) {
	if ($membro_id == "") { $membro_id = "null"; }
	$obs = u8d($obs);
	$qFluxo = "update fluxo 
							set dt_fluxo = '$dt_fluxo', 
									fluxo_tipo_id = $fluxo_tipo_id, 
									fluxo_movimento_id = $fluxo_movimento_id, 
									vl_fluxo = replace(replace('$vl_fluxo', '.', ''), ',', '.'), 
									membro_id = $membro_id, 
									dt_competencia = '$dt_competencia-01',
									obs = '$obs'
							where id_fluxo = $p_edicao_id";
	// e($qFluxo);
	$resultado = executa_sql($qFluxo, "Fluxo ($p_edicao_id) alterado com sucesso");
	e($resultado);
	die;
}

if ($p_edicao_opcao == "I" and $p_edicao_id == "" ) {
	if ($membro_id == "") { $membro_id = "null"; }
	$obs = u8d($obs);
	$qFluxo = "
insert into fluxo 
	(dt_fluxo, vl_fluxo, fluxo_movimento_id, fluxo_tipo_id, dt_competencia, Obs) values 
 	('$dt_fluxo', replace(replace('$vl_fluxo', '.', ''), ',', '.'), $fluxo_movimento_id, $fluxo_tipo_id, '$dt_fluxo', '$obs') ";
 // e($qFluxo);
	$resultado = executa_sql($qFluxo, "Fluxo incluído com sucesso");
	e($resultado);
	die;
}

if ($p_edicao_opcao == "PI" and $p_edicao_id == "" ) {
	$p_edicao_opcao = "I";
	$dt_fluxo = date("Y-m-d");
	$dt_competencia = date("Y-m");
}

if ($p_edicao_opcao == "PA" and $p_edicao_id <> "" ) {
	$p_edicao_opcao = "A";
	$qFluxoMensal = "select dt_fluxo, fluxo_tipo_id, fluxo_movimento_id, format(vl_fluxo, 2, 'de_DE'), membro_id, date_format(dt_competencia, '%Y-%m'), obs from fluxo where id_fluxo = $p_edicao_id";
	$f = pesquisa($qFluxoMensal);
	$dt_fluxo 						= $f[0];
	$fluxo_tipo_id 				= $f[1];
	$fluxo_movimento_id  	= $f[2];
	$vl_fluxo 						= $f[3];
	$membro_id 						= $f[4];
	$dt_competencia 			= $f[5];
	$obs 									= u8($f[6]);
}
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------
	function modalGravar() {
		gravarModalEdicao("frm_editar_fluxo", "<?=$dirApp?>frm_fluxo.php");
	}	
	tituloModalEdicao("Edição Fluxo");
</script>

<form name=frm_editar_fluxo id=frm_editar_fluxo method=post action=<?=$self?> >
	<input type="hidden" name="p_ano" id="p_ano_ed" value="<?=$p_ano?>">
	<input type="hidden" name="p_mes" id="p_mes_ed" value="<?=$p_mes?>">
	<input type="hidden" name="p_subfluxo" id="p_subfluxo_ed" value="<?=$p_subfluxo?>">
	<input type="hidden" name="p_edicao_opcao" id="p_edicao_opcao" value="<?=$p_edicao_opcao?>">
	<input type="hidden" name="p_edicao_id" id="p_edicao_id" value="<?=$p_edicao_id?>">
	<input type="hidden" name="membro_id" id="membro_id" value="<?=$membro_id?>">
			<?php campo_data("dt_fluxo"); ?>	
			<br><br>
			<?php
				$qFluxoMovimento = "SELECT id, ds_fluxo_movimento FROM fluxo_movimento f order by 1";
				e(processaRadio($qFluxoMovimento, "fluxo_movimento_id", $fluxo_movimento_id));
			?>			
			<br><br>
			<label>Competência <br>
			<?php campo_mes("dt_competencia"); ?>				
			</label>
			<br><br>
			<label>Tipo <select name=fluxo_tipo_id id=fluxo_tipo_id>
			<?php
				$qFluxoTipo = "SELECT id, ds_fluxo_tipo FROM fluxo_tipo f order by 2";
				e(processaSelect($qFluxoTipo, $fluxo_tipo_id));
			?>			
			</select></label>
			<br><br>
			<label>Valor <input type="text" name="vl_fluxo" id="vl_fluxo" inputmode="numeric" size=5 onkeyup="formatarMoeda(this);"  value="<?=$vl_fluxo?>"></label>
			<br><br>
			<label>Obs:  <input type="text" name="obs" id="obs" size=13  value="<?=$obs?>"></label>
			<br><br>
			<?php
				$qMembro = "SELECT id, nm_apelido FROM membro m where m.tipo_situacao_id = 1 order by 2";
				e(processaRadio($qMembro, "membro_id", $membro_id));
			?>			
			<br><br>
</form>
