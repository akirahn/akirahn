<?php
	include_once("../include.php");
	
/*
	include_once("../include/config_sv.php");
	include_once("../include/config.php");
	include_once("../include/funcoes.php");
	include_once("../include/globais.php");
	include_once("../include/bd.php");
	// include_once("");
	conectar();
	$self = "";
	// Transformar valores _POST em variável de mesmo nome
	reset($_POST);
	foreach($_POST as $key => $value) {
		$$key = $_POST[$key];
		$_POST[$key] = "";
	}
	// Bloquear valores passados via _GET
  reset($_GET);
	foreach($_GET as $key => $value) {
		$_GET[$key] = "";
	}
	
	$ArrPATH = explode("/",$_SERVER['SCRIPT_NAME']);
	$nome_pagina = $ArrPATH[count($ArrPATH)-1];
	$nome_pagina = str_replace(".php", "", $nome_pagina);

	session_start();
	$valor_sessao = ($PHPSESSID == "" ? session_id() : $PHPSESSID);
	if ($sair == "S") { 
		$_SESSION["meuacesso"] = "";		
		session_destroy();
		session_start();
		$valor_sessao = (empty($PHPSESSID) ? session_id() : $PHPSESSID);
		header("location: index.php");
	} 
	if ($_SESSION["meuacesso"] == "" and $meuacesso <> "") {
		$qMembroLogin = "select m.id from membro m where m.id = $meuacesso";
		$membro = pesquisa($qMembroLogin, 0);
		if ($membro == "") {
			msgErro("Acesso inválido!");
		} else {
			$_SESSION["meuacesso"] = $meuacesso;		
		}
	}
	if ($_SESSION["meuacesso"] == "") {
		include_once("login.php");
		die;
	} else {
		if ($nome_pagina == "login" or $nome_pagina == "sair") {
			header("location: pag_mensalidade.php");
		}
		if ($menu_off == 0) {
			include_once("menu.php");		
		}
	}
*/	
		if ($menu_off == 0) {
			include_once("menu.php");		
		}
	
?>