<?php
	// Transformar valores _POST em variável de mesmo nome
	reset($_POST);
	foreach($_POST as $key => $value) {
		$$key = $_POST[$key];
		$_POST[$key] = "";
	}
	// Exceção valores passados via _GET
	if ($_GET["p_sub"]  				<> "") { $p_sub  					= $_GET["p_sub"];  }
	if ($_GET["p_tipo"] 				<> "") { $p_tipo 					= $_GET["p_tipo"]; }
	if ($_GET["p_edicao_opcao"] <> "") { $p_edicao_opcao 	= $_GET["p_edicao_opcao"]; }
	if ($_GET["p_edicao_id"] 		<> "") { $p_edicao_id 		= $_GET["p_edicao_id"]; }
	// Bloquear valores passados via _GET
  reset($_GET);
	foreach($_GET as $key => $value) {
		$_GET[$key] = "";
	}
	$dirBase = "/apps/";
	$ArrPATH = explode("/",$_SERVER['SCRIPT_NAME']);
	$nome_pagina = $ArrPATH[count($ArrPATH)-1];
	$nome_pagina = str_replace(".php", "", $nome_pagina);
	$app_padrao = $ArrPATH[count($ArrPATH)-2];
	$dirApp = "$dirBase$app_padrao/";
?>	
