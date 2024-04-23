<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
//-----------------------------------------
	function link_script($p_arquivo, $p_tipo, $sem_versao="") {
//-----------------------------------------
		switch($p_tipo) {
			case "css/js" : 
				link_script_unico($p_arquivo, "css", $sem_versao);
				link_script_unico($p_arquivo, "js" , $sem_versao);
				break;
			case "css": link_script_unico($p_arquivo, $p_tipo, $sem_versao); break;
			case "js" : link_script_unico($p_arquivo, $p_tipo, $sem_versao); break;
		}
	}	
//-----------------------------------------
	function link_script_unico($p_arquivo, $p_tipo, $sem_versao="") {
//-----------------------------------------
		$v_arquivo = "/apps" . ($sem_versao == "" ? "/arquivos" : "") . "/$p_arquivo.$p_tipo";
		$v_arquivo_real = $_SERVER['DOCUMENT_ROOT'] . "$v_arquivo";
		$versao = (file_exists($v_arquivo_real) ? filemtime($v_arquivo_real) : "1");
		if ($p_tipo == "css") {
			e("<link rel='stylesheet' href='$v_arquivo?t=$versao' type='text/css'/>\n");
		} else {
			e("<script src='$v_arquivo?t=$versao'></script>\n");
		}		
	}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
	$fontes_google = array("Audiowide", "Roboto", "Russo One");
	$ft = 2;
	e("<link href='https://fonts.googleapis.com/css2?family=".$fontes_google[$ft]."&display=swap' rel='stylesheet'>\n");		
	e("<style> :root { 	--fonte-padrao: '".$fontes_google[$ft]."'; } </style>");

	link_script("padrao", "css/js");
	link_script("forms", "css/js");
	link_script("menu", "css");
	link_script("jquery-3.6.1.min", "js");
	link_script(($app_padrao == "apps" ? $app_padrao : "$app_padrao/$app_padrao"), "css/js", 1);
?>
