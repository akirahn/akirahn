<?php
$servidor = $_SERVER["HTTP_HOST"];
switch($servidor) {
	case "serranegraimobil1.websiteseguro.com":
		$cfg_bd_sv = "centrocsn.mysql.dbaas.com.br";
		$cfg_bd_us = "centrocsn";
		$cfg_bd_pw = "pedro.costa01";
		$cfg_bd_nm = "centrocsn";
		$cfg_utf8  = "S";
		break;
	case "serranegraimobil1.hospedagemdesites.ws":
		$cfg_bd_sv = "centrocsn.mysql.dbaas.com.br";
		$cfg_bd_us = "centrocsn";
		$cfg_bd_pw = "pedro.costa01";
		$cfg_bd_nm = "centrocsn";
		$cfg_utf8  = "S";
		break;
	case "csn.orgfree.com":
		$cfg_bd_sv = "localhost";
		$cfg_bd_us = "331568";
		$cfg_bd_pw = "X1102pto";
		$cfg_bd_nm = "331568";
		$cfg_utf8  = "N";
		break;
	case "localhost:8080":
		$cfg_bd_sv = "localhost:3307";
		$cfg_bd_us = "root";
		$cfg_bd_pw = "";
		$cfg_bd_nm = "centrocsn";
		$cfg_utf8  = "S";
		break;
	case "localhost":
		$cfg_bd_sv = "localhost:3307";
		$cfg_bd_us = "root";
		$cfg_bd_pw = "";
		$cfg_bd_nm = "centrocsn";
		$cfg_utf8  = "S";
		break;
	case "csnae.byethost7.com":
		$cfg_bd_sv = "sql105.byethost7.com";
		$cfg_bd_us = "b7_34508612";
		$cfg_bd_pw = "@Serra7Negra";
		$cfg_bd_nm = "b7_34508612_csnae";
		$cfg_utf8  = "S";
		break;
}
?>