<?php
	// VARIÁVEIS E CONSTANTES GLOBAIS
	$dom_sim_nao = ["S", "Sim", "N", ("Não")];
	$dom_caixa_comp = array("X", "Caixa", "T", ("Competência"));
	$dom_sint_analit = array("S", "Sintético", "A", "Analítico");
	$dom_cabeca_grau = ["1", "Fraca", "2", "Média", "3", "Forte", "4", "Intensa"];
	$dom_cabeca_grau_alivio = ["1", "Total", "2", "Parcial", "3", "Nenhum"];
	
	// Ícones Coloridos
	$ico_incluir 		= "&#10133;";
	$ico_excluir 		= "&#10060;";
	$ico_editar  		= "&#9997;";
	$ico_gravar  		= "&#128190;";
	$ico_pesquisar 	= "&#128270;";
	$ico_voltar 		= "&#10094;";
	$ico_posterior  = "&#9193;";
	$ico_anterior  	= "&#9194;";
	
	// Ícone Apps AE
	$ico_ae 				= "&AElig;";
	
	// Ícones Font Awesome
	$ico_incluir 		= "<i class='fa fa-plus'></i>";
	$ico_excluir 		= "<i class='fa fa-trash'></i>";
	$ico_editar  		= "<i class='fa fa-pencil'></i>";
	$ico_gravar  		= "<i class='fa fa-save'></i>";
	$ico_pesquisar 	= "<i class='fa fa-search'></i>";
	$ico_voltar 		= "&#10094;";
	$ico_posterior  = "<i class='fa fa-caret-right'></i>";
	$ico_anterior  	= "<i class='fa fa-caret-left'></i>";
	$ico_fechar  		= "<i class='fa fa-close'></i>";
	$ico_entrar			= "<i class='fa fa-sign-in'></i>";
	$ico_sair  			= "<i class='fa fa-sign-out'></i>";
	$ico_menu  			= "<i class='fa fa-navicon'></i>";
	$ico_remedio 		= "<i class='fa fa-plus-square'></i>";
	$ico_credito 		= "<i class=''fa fa-plus-square-o''></i>";
	$ico_debito  		= "<i class=''fa fa-minus-square-o''></i>";
	$ico_rateio			= "<i class='fa fa-th-list'></i>";
	$ico_check			= "<i class='fa fa-check'></i>";
	$ico_proibido		= "<i class='fa fa-ban'></i>";
	$ico_abrir			= "<i class='fa fa-external-link'></i>";
	$ico_lista			= "<i class='fa fa-list'></i>";
/*
font awesome 4
<i class='fa fa-home'></i>
<i class='fa fa-bars'></i>
<i class='fa fa-close'></i>
<i class='fa fa-automobile'></i>
<i class='fa fa-bar-chart'></i>
<i class='fa fa-arrow-left'></i>
<i class='fa fa-arrow-right'></i>
<i class='fa fa-heart-o'></i>

<i class='fa fa-moon-o'></i>
<i class='fa fa-power-off'></i>
<i class='fa fa-share-alt'></i>

<i class='fa fa-star'></i>
<i class='fa fa-sun-o'></i>
<i class='fa fa-file-text-o'></i>
<i class='fa fa-table'></i>
<i class='fa fa-undo'></i>

<i class='fa fa-ellipsis-v'></i>
<i class='fa fa-plus-square'></i>

Google Material Icons

<i class="material-icons">accessibility</i>

*/

	// APPS 
	$apps = array();
	$apps["apps"]["tit"] = "Apps $ico_ae";
	$apps["cab"]["tit"] = "Dor de Cabeça";
	$apps["cab"]["app"] = "<i class='fa fa-medkit'></i> " . $apps["cab"]["tit"];
	$apps["cab"]["url"] = "cab/cad_cab_episodio.php";
	$apps["csn"]["tit"]	= "Tesouraria CSN";
	$apps["csn"]["app"]	= "<i class='fa fa-dollar'></i> ".$apps["csn"]["tit"];
	$apps["csn"]["url"]	= "csn/";
	$apps["uno"]["tit"]	= "Abastecer Uno";
	$apps["uno"]["app"]	= "<i class='fa fa-automobile'></i> ".$apps["uno"]["tit"];
	$apps["uno"]["url"]	= "uno/cad_combustivel.php";
	$apps["mae"]["tit"]	= "Mãe";
	$apps["mae"]["app"]	= "<i class='fa fa-heart'></i> ".$apps["mae"]["tit"];
	$apps["mae"]["url"]	= "mae/";
	$apps["app"]["tit"]	= "App";
	$apps["app"]["app"]	= "<i class='fa fa-mobile'></i> ".$apps["app"]["tit"];
	$apps["app"]["url"]	= "app/";
	$apps["rat"]["tit"]	= "Rateio";
	$apps["rat"]["app"]	= "<i class='fa fa-th'></i> ".$apps["rat"]["tit"];
	$apps["rat"]["url"]	= "rat/cad_rateio.php";
	$apps["gst"]["tit"]	= "Finanças";
	$apps["gst"]["app"]	= "<i class='fa fa-money'></i> ".$apps["gst"]["tit"];
	$apps["gst"]["url"]	= "gst/cad_financas.php";
	$apps["lst"]["tit"]	= "Lista";
	$apps["lst"]["app"]	= "<i class='fa fa-list'></i> ".$apps["lst"]["tit"];
	$apps["lst"]["url"]	= "lst/cad_lista.php";
	$apps["sai"]["tit"]	= "Sair";
	$apps["sai"]["app"]	= "<i class='fa fa-sign-out'></i> ".$apps["sai"]["tit"];
	$apps["sai"]["url"]	= "sair.php";
	
?>