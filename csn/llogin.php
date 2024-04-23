<!DOCTYPE html>
<title>Tesouraria CSN</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<meta charset="UTF-8">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
	include_once("../include/config_sv.php");
	include_once("../include/config.php");
	include_once("../include/funcoes.php");
	include_once("../include/globais.php");
	$app_padrao = "fluxo";
	include_once("../include/style_js.php");
?>
</head>
<div class="topnav" id="myTopnav">
  <a href="#home" class="active"><i class='fa fa-dollar'></i> Tesouraria CSN</a>
</div>
<br>
<br>
<br>
<br>
<center>
<form name=frm_login id=frm_login method=post action="<?=$self?>">
	<input type="hidden" name="PHPSESSID" value="<?=$valor_sessao?>">
	Informe a senha de acesso<br>
	<input type=password name=meuacesso id=meuacesso size=10 inputmode="numeric" autocomplete="off" readonly>
	<br><br>
<table class="table_teclado">
		<tbody><tr>
			<td>1</td>
			<td>2</td>
			<td>3</td>
		</tr>
		<tr>
			<td>4</td>
			<td>5</td>
			<td>6</td>
		</tr>
		<tr>
			<td>7</td>
			<td>8</td>
			<td>9</td>
		</tr>
		<tr>
			<td colspan="2">0</td>
			<td><?=$ico_excluir?></td>
		</tr>
		<tr>
		<td colspan=3 onclick="document.getElementById('frm_login').submit();">
			<?=$ico_entrar?> Entrar
		</td>
		</tr>
		<tr>
		<td colspan=3 onclick="window.close();">
			<?=$ico_fechar?> Fechar
		</td>
		</tr>
	</tbody></table>	
</form>
</center>
<script>
$(document).ready(function(){
	$('.table_teclado tr td').click(function(){
		var number = $(this).text();
		
		if (number == '')
		{
			$('#meuacesso').val($('#meuacesso').val().substr(0, $('#meuacesso').val().length - 1)).focus();
		}
		else
		{
			$('#meuacesso').val($('#meuacesso').val() + number).focus();
		}

	});
});
</script>
