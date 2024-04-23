<!DOCTYPE html>
<title><?=$tit_gst?></title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<meta charset="UTF-8">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
if (!isset($dt_cabeca)) { $dt_cabeca = date("Y-m-d"); }
if (!isset($hr_cabeca)) { $hr_cabeca = date('H:i'); }
?>
	<label><input type=date name=dt_cabeca id=dt_cabeca value="<?=$dt_cabeca;?>" size=4></label>
	<label><input type=time name=hr_cabeca id=hr_cabeca value="<?=$hr_cabeca;?>" size=5></label>
<?php
		$cfg_bd_sv = "localhost:3306";
		$cfg_bd_us = "aemyhoos_admin";
		$cfg_bd_pw = "S6[gU#r3YM+^";
		$cfg_bd_nm = "aemyhoos_csn";

	$conexao = new mysqli("$cfg_bd_sv","$cfg_bd_us","$cfg_bd_pw","$cfg_bd_nm");
	echo "ok1";
	if ($conexao->connect_errno) {
		echo "Erro de conexão: " . $conexao->connect_error();
		exit();
	}
	echo "ok";

?>