<?php
$menu_off = 1;
include_once("../include/include_bd.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------
	function modalGravar() {
		gravarModalEdicao("frm_editar_cabeca", "<?=$dirApp?>frm_cabeca.php");
	}	
	tituloModalEdicao("Edição Dor de Cabeça");
</script>

<?php

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($p_edicao_opcao == "A" and $p_edicao_id <> "" ) {
	if ($nr_grau_alivio == "") { $nr_grau_alivio = "null"; }
	$qUpdate = "update app_cabeca 
							set dt_cabeca = '$dt_cabeca', 
									hr_cabeca = '$hr_cabeca', 
									nr_grau = $nr_grau, 
									fk_remedio = $fk_remedio, 
									nr_grau_alivio = $nr_grau_alivio, 
									fk_quem = $fk_quem
							where id_cabeca = $p_edicao_id";
	// e($qUpdate);
	$resultado = executa_sql($qUpdate, "Episódio (". dformat($dt_cabeca). " $hr_cabeca) alterado com sucesso");
	e($resultado);
	if ($erro_sql == 1) {
		die;
	}
}

if ($p_edicao_opcao == "I" and $p_edicao_id == "" ) {
	if ($nr_grau_alivio == "") { $nr_grau_alivio = "null"; }
	$qInsert = "
insert into app_cabeca 
	(dt_cabeca, hr_cabeca, nr_grau, fk_remedio, nr_grau_alivio, fk_quem) values 
 	('$dt_cabeca', '$hr_cabeca', $nr_grau, $fk_remedio, $nr_grau_alivio, $fk_quem) ";
 // e($qInsert);
	$ultimo_sql_id = "";
	$erro_sql = 0;
	$resultado = executa_sql($qInsert, "Episódio (". dformat($dt_cabeca). " $hr_cabeca) incluído com sucesso");
	e($resultado);
	if ($erro_sql == 1) {
		die;
	}
}
if ($p_edicao_opcao == "I" or $p_edicao_opcao == "A" or $p_edicao_opcao == "E") {
	$qMaxUsoRemedio = "select coalesce(count(*), 0) from app_cabeca where fk_remedio = $fk_remedio";
	$maxUsoRemedio = pesquisa($qMaxUsoRemedio, 0);
	$update = "update app_cab_remedio set qtd_uso = $maxUsoRemedio where id = $fk_remedio ";
	$resultado = executa_sql($update, "");
	die;
}
if ($p_edicao_opcao == "PI" and $p_edicao_id == "" ) {
	$p_edicao_opcao = "I";
	$dt_cabeca = date("Y-m-d");
	$hr_cabeca = date("H:i");
}

if ($p_edicao_opcao == "PA" and $p_edicao_id <> "" ) {
	$p_edicao_opcao = "A";
	$qTabela = "SELECT id_cabeca, dt_cabeca, time_format(hr_cabeca,'%H:%i'), nr_grau, fk_remedio, nr_grau_alivio, fk_quem FROM app_cabeca a where id_cabeca = $p_edicao_id";
	$tabela = pesquisa($qTabela);
	$id_cabeca 			= $tabela[0];
	$dt_cabeca 			= $tabela[1];
	$hr_cabeca  		= $tabela[2];
	$nr_grau 				= $tabela[3];
	$fk_remedio 		= $tabela[4];
	$nr_grau_alivio = $tabela[5];
	$fk_quem 				= $tabela[6];
}
?>

<form name=frm_editar_cabeca id=frm_editar_cabeca method=post action=<?=$self?> >
	<input type="hidden" name="p_ano" id="p_ano_ed" value="<?=$p_ano?>">
	<input type="hidden" name="p_mes" id="p_mes_ed" value="<?=$p_mes?>">
	<input type="hidden" name="id_cabeca" id="id_cabeca" value="<?=$p_edicao_opcao?>">
	<input type="hidden" name="p_edicao_id" id="p_edicao_id" value="<?=$p_edicao_id?>">
	<label>Quem </label>
<?php
	$qQuem = "select id, nm_pessoa from tab_quem where id in (1, 4) ";
	e(processaRadio($qQuem, "fk_quem", $fk_quem));
?>				
	<br><br>
	<?php campo_data("dt_cabeca"); ?>	
	<input type=time name=hr_cabeca id=hr_cabeca value="<?=$hr_cabeca;?>" size=5>
	<br><br>
	<label>Dor </label>
<?php
	montaRadio($dom_cabeca_grau, "nr_grau", $nr_grau);
?>
	<br><br>
	<label>Remédio</label><br><br>
<?php
	$qRemedio = "select id, ds_remedio from app_cab_remedio order by qtd_uso desc, ds_remedio";
	e(processaRadio($qRemedio, "fk_remedio", $fk_remedio));
?>			
	<br><br>
	<label>Alívio</label>
<?php
	montaRadio($dom_cabeca_grau_alivio, "nr_grau_alivio", $nr_grau_alivio);
?>
</form>
