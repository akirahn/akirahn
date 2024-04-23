<?php
	include_once("../include/config_sv.php");
	include_once("../include/config.php");
	include_once("../include/funcoes.php");
	include_once("../include/bd.php");
	// include_once("");
	conectar("csn8");
	
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
  $self = "/apps/csn/index.php";
	
?>