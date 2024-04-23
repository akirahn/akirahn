<head>
	<title>Rifa</title>
</head>
<?php
//-----------------------------------------
function dformat($p_data) {
// retorna um caracter $caracter repetido $qtd vezes
//-----------------------------------------
	$v_data = date_create($p_data);
  return date_format($v_data, "d/m/Y");
}

//-----------------------------------------
	function numeros($a) {
//-----------------------------------------
		global $valor;
?>
		<table width=100%>
			<td align=right><b>Números </b></td>
			<td class=hr><?=str_pad($a, 4, "0", STR_PAD_LEFT)?></td>
			<td class=hr><?=$a+2500?></td>
			<td class=hr><?=$a+5000?></td>
			<td class=hr><?=$a+7500?></td>
			<td align=right><b>R$ <?=$valor?></b></td>
		</table>
		<font size=-2><br></font>
<?php	
	}
	
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
	if (!isset($inicial)) { $inicial = ""; }
	if (!isset($final)) 	{ $final = ""; }
	if (!isset($sorteio)) { $sorteio = ""; }

	reset($_POST);
	foreach($_POST as $key => $val) {
		$$key = $_POST[$key];
	}
	$_POST = "";

	if ($inicial == "" or $final == "" or $sorteio == "") {
?>	
		<form name=numeracao method=post action="">
			<pre>
			Tipo Sorteio: <select name=tipo><option value=L>Loteria Federal</option><option value=S>Sorteio por Urna</option></select>
			
			Data Sorteio: <input name=sorteio type=date size=10 value="2024-06-08">

			Início......: <input name=inicial type=number>

			Fim.........: <input name=final 	type=number>

			Valor.......: <input name=valor 	type=text>
			<pre>
			<input type=submit value="Gerar Rifa">
		</form>
<?php		
	} else {
?>
		<style>
			.fim_td { border-bottom: 1px solid #000000; }
			.inicio_td { border-top: 1px solid #000000; }
			.hr { border: 1px solid #000000; text-align: center}
			.separador1 { border-right: 1px dashed #000; width: 2%; }
			.separador2 { width: 2%; }
			@media print {
			  .pula_pagina {page-break-before: always;}
			}		
		</style>
		<table width=100%>
<?php		
		$classe 		= "class=inicio_td";
		$s 					= "&nbsp;";
		$data_rifa 	= $sorteio; //str_replace("/",  "-", $sorteio);
		$texto 			= file_get_contents("./rifa-$data_rifa.txt", true);
		$separador1 = "<td class=separador1>$s</td>";
		$separador2 = "<td class=separador2>$s</td>";
		$fim_td_s 	= "<td class=fim_td align=center><b>Apenas R$ $valor</b></td>";
		$preco_l 		= " - <b>Apenas R$ $valor</b>";
		for($a=$inicial; $a <= $final; $a++) {
?>
			<tr>
<?php
				for($y=0; $y < 3; $y++) {
					if ($y == 1) {
						echo $separador1;
						echo $separador2;
					} else {
?>	
				<td width=48% align=center <?=$classe?>>
					<br><u>Rifa Beneficente Cocar Gabriel - <?=dformat($sorteio)?></u>
				</td>
<?php
					}
				}
?>	
			</tr>
			<tr>
				<td>
					Nome: 
					<br>
					<br>
					Telefone:
					<br>
					<br>
					Endereço:
					<br>
					<br>
				</td>
				<?=$separador1?>
				<?=$separador2?>
				<td valign=top align=justify>
					<?php echo $texto; //<font size=-1></font> ?>
				</td>
			</tr>
<?php
			if ($tipo == "L") {
?>			
			<tr>
				<td class=fim_td>
					<?php numeros($a);?>				
				</td>
				<?=$separador1?>
				<?=$separador2?>
				<td class=fim_td>
					<?php numeros($a);?>				
				</td>
			</tr>
<?php
			} else {
?>			
				
				<?=$fim_td_s?>
				<?=$separador1?>
				<?=$separador2?>
				<?=$fim_td_s?>
<?php				
			}
			if ((($a) % 4) == 0 and $a < $final) {
				echo "</table><p class=pula_pagina><table width=100% >";
				// echo "</table><table width=100% >";
				$classe = "class=inicio_td";
			} else {
				$classe = "";
			}
		}
		echo "</table>";
	}
?>