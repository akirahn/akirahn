<?php
$tab_nome 		= "Dor de Cabeça";
$tituloPagina = "$tab_nome";
include_once("include.php");
if ($opCabeca == "I") {
	if ($nr_grau_alivio == "") { $nr_grau_alivio = "null" ;}
	$tab_insert = "insert into app_cabeca (dt_cabeca, hr_cabeca, nr_grau, fk_remedio, nr_grau_alivio, fk_quem) values ('$dt_cabeca', '$hr_cabeca', $nr_grau, '$fk_remedio', $nr_grau_alivio, $fk_quem)";
// e($tab_insert)	;
	$resultado = executa_sql($tab_insert, "$tab_nome incluído com sucesso");
	resultado();
	$qMaxUsoRemedio = "select coalesce(count(*), 0) from app_cabeca where fk_remedio = $fk_remedio";
	$maxUsoRemedio = pesquisa($qMaxUsoRemedio, 0);
	$update = "update app_cab_remedio set qtd_uso = $maxUsoRemedio where id = $fk_remedio ";
	$resultado = executa_sql($update, "");
	
	unset($dt_cabeca);
	unset($hr_cabeca);
	unset($nr_grau);
	unset($fk_remedio);
	unset($nr_grau_alivio);
	unset($fk_quem);
}
if (!isset($dt_cabeca)) { $dt_cabeca = date("Y-m-d"); }
if (!isset($hr_cabeca)) { $hr_cabeca = date('H:i'); }
?>
<form name=registrar_dor_de_cabeca method=post>
	<input type=hidden name=opCabeca value="I">
<?php
	$qQuem = "select id, nm_pessoa from tab_quem where id in (1, 4) ";
	e(processaRadio($qQuem, "fk_quem", $fk_quem));
?>				
	<br><br>	
	<label><input type=date name=dt_cabeca id=dt_cabeca value="<?=$dt_cabeca;?>" size=4></label>
	<label><input type=time name=hr_cabeca id=hr_cabeca value="<?=$hr_cabeca;?>" size=5></label>
	<br><br>
		<label>Dor 
<?php
			montaRadio($dom_cabeca_grau, "nr_grau", $nr_grau);
?>
	</label>
	<br><br>
	<label>Remédio</label><br><br>
<?php
	$qRemedio = "select id, ds_remedio from app_cab_remedio order by qtd_uso desc, ds_remedio";
	e(processaRadio($qRemedio, "fk_remedio", $fk_remedio));
?>			
	<br><br>
	<label>Alívio
<?php
	montaRadio($dom_cabeca_grau_alivio, "nr_grau_alivio", $nr_grau_alivio);
?>
	</label>
	<button class=btn type=submit><?=$ico_gravar?></button>
</form>