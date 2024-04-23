<?php
include_once("MobileDetect.php");
//===========================//
// FUNÇÕES PHP 	
//===========================//

//===========================//
// GENÉRICAS
//===========================//

$detect = new \Detection\MobileDetect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

//-----------------------------------------
function e($p_texto) {
// Imprime $p_texto na tela 
//-----------------------------------------
	echo $p_texto;
}

//-----------------------------------------
function script($p_texto) {
// Imprime script tags com $p_texto na tela 
//-----------------------------------------
	e("<script>$p_texto</script>");
}

//-----------------------------------------
function resultado() {
// mostra mensagem de resultado de processamento no banco de dados: $resultado
//-----------------------------------------
	global $resultado, $erro_sql;
	if ($erro_sql == 0 and $resultado <> "") {
		script("conteudo('Mensagem', '$resultado');");		
	}
}

//-----------------------------------------
function msgModal($texto) {
// Dispara javascript para mensagem Modal
//-----------------------------------------
	script("el('Mensagem').innerHTML = '$texto';");
}

//-----------------------------------------
function msgErro($texto) {
// Mostra mensagem de erro
//-----------------------------------------
	e("<center><span class=msgErro>$texto</span></center>");
}

//===========================//
// DATAS 	
//===========================//

//-----------------------------------------
function dformat($p_data) {
// retorna um caracter $caracter repetido $qtd vezes
//-----------------------------------------
	$v_data = date_create($p_data);
  return date_format($v_data, "d/m/Y");
}

//-----------------------------------------
function dmformat($p_data) {
// retorna um caracter $caracter repetido $qtd vezes
//-----------------------------------------
	$v_data = date_create($p_data);
  return date_format($v_data, "m/Y");
}

//===========================//
// STRINGS 	
//===========================//

//-----------------------------------------
function enl() {
// echoa <BR>
//-----------------------------------------
  e("<br>");
}

//-----------------------------------------
function espaco($caracter, $qtd) {
// retorna um caracter $caracter repetido $qtd vezes
//-----------------------------------------
  $retorno = "";
  for($a=1; $a <= $qtd; $a++) $retorno = $retorno . $caracter;
  return $retorno;
}

//----------------------------------
function nformat($valor, $decimais=2, $operacao_sql=0) {
// formatação de valor numérico para valores em R$
//----------------------------------
	if ($operacao_sql == 0) {
		return number_format($valor, $decimais, ',', '.');
	} else {
		return replace(replace($valor, "."), ",", ".");
	}
}	

//----------------------------------
function formataTXT($texto) {
// formatação do variável de autenticação
//----------------------------------
	global $cfg_utf8;
	if ($cfg_utf8 == "S") {
		if (is_utf8($texto)) {
			return utf8_decode($texto);
		} else {
			return $texto;
		} 
	} else {
		return $texto;			
	}
}	

//-----------------------------------------
function isUTF8($texto) {
//-----------------------------------------
	global $cfg_utf8;
	if ($cfg_utf8 == "S") {
		return (utf8_encode(utf8_decode($texto)) == $texto);		
	} else {
		return $texto;
	}
}

//-----------------------------------------
function replace($texto, $este, $poreste="") {
// COLOCA A PRIMEIRA LETRA EM CAIXA ALTA E O RESTANTE EM CAIXA BAIXA
//-----------------------------------------
	return str_replace($este, $poreste, $texto);
}

//-----------------------------------------
function valor_sql($p_valor) {
// COLOCA A PRIMEIRA LETRA EM CAIXA ALTA E O RESTANTE EM CAIXA BAIXA
//-----------------------------------------
	return 	replace(replace($p_valor, ".", ""), ",", ".");
}

//-----------------------------------------
function rpad($texto, $tamanho, $caracter="") {
// alinha o <texto> à direita preenchendo a string com <tamanho> com o caracter <caracter>
//-----------------------------------------
	return str_pad($texto, $tamanho, $caracter, STR_PAD_RIGHT);
}

//-----------------------------------------
function lpad($texto, $tamanho, $caracter="") {
// alinha o <texto> à esquerda preenchendo a string com <tamanho> com o caracter <caracter>
//-----------------------------------------
	return str_pad($texto, $tamanho, $caracter, STR_PAD_LEFT);
}

//-----------------------------------------
function u8($texto) {
// alinha o <texto> à esquerda preenchendo a string com <tamanho> com o caracter <caracter>
//-----------------------------------------
	global $cfg_utf8;
	if ($cfg_utf8 == "S") {
		return utf8_encode($texto);
	} else {
		return $texto;
	}
}

//-----------------------------------------
function u8d($texto) {
// alinha o <texto> à esquerda preenchendo a string com <tamanho> com o caracter <caracter>
//-----------------------------------------
	global $cfg_utf8;
	if ($cfg_utf8 == "S") {
		return utf8_decode($texto);
	} else {
		return $texto;
	}
}
//-----------------------------------------
function exclui_ultimo_car($texto) {
// Exclui o ultimo caracter do texto
//-----------------------------------------
	$texto = substr($texto, 0, strlen($texto)-1);
	// e($texto);
	return $texto;
}
//-----------------------------------------
function possui_texto($texto, $palavra) {
// Verificar se palavra está dentro de texto
//-----------------------------------------
	if (is_array($texto)) {
		return 0;
	} else {
		$resposta = strpos($texto, $palavra);
		return (($resposta === false) ? 0 : $resposta);
	}
}

//-----------------------------------------
function cap_texto($texto) {
// COLOCA A PRIMEIRA LETRA EM CAIXA ALTA E O RESTANTE EM CAIXA BAIXA
//-----------------------------------------
//	$texto = strtoupper(substr($texto, 0, 1)) . ucwords(strtolower(substr($texto, 1)));
	$texto = ucwords(strtolower($texto));
	$texto = str_replace("Des ", "des ", $texto);
  $texto = str_replace("De " , "de ", $texto);
  $texto = str_replace("Dos ", "dos ", $texto);
  $texto = str_replace("Do " , "do ", $texto);
  $texto = str_replace("Das ", "das ", $texto);
  $texto = str_replace("Da " , "da ", $texto);
  $texto = str_replace("E "  , "e ", $texto);
  $texto = str_replace("Trt"  , "TRT", $texto);
	return $texto;
}

//===========================//
// HTML
//===========================//

//-----------------------------------------
function calculaVencimento($p_pagto, $p_dt_gasto) {
//-----------------------------------------
	$qDatas = "SELECT dia_fechamento, dia_vencimento FROM gst_tab_pagto WHERE id = $p_pagto and tp_pagto = 'C' and dia_fechamento <> 0 ";
	$datas = pesquisa($qDatas);
	if ($datas == "") {
		$dt_pagto = $p_dt_gasto;
	} else {
		$diaF = $datas[0];
		$diaV = $datas[1];
		$fechamento = substr($p_dt_gasto, 0, 8) . $diaF;
		$vencimento = substr($p_dt_gasto, 0, 8) . $diaV;
		if ($diaF > $diaV) {
			if ($p_dt_gasto > $fechamento) {
				$dt_pagto = date("Y-m-d", strtotime("+2 month", strtotime($vencimento)));
			} else {
				$dt_pagto = date("Y-m-d", strtotime("+1 month", strtotime($vencimento)));
			}
		} else {
			if ($p_dt_gasto > $fechamento) {
				$dt_pagto = date("Y-m-d", strtotime("+1 month", strtotime($vencimento)));
			} else {
				$dt_pagto = $vencimento;
			}			
		}
	}
	return $dt_pagto;
}	
//-----------------------------------------

//===========================//
// Javascript
//===========================//
?>
