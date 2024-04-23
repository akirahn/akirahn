<?php
/********************************************************
        include/config.inc
                                 
	OBJETIVO:
		Configuracao inicial do ambiente
		ChangeLog:
********************************************************/

//===========================//

//===========================//

	$spc = "&nbsp;";
  $self = "/csn/index.php";
  $server_name = $_SERVER['SERVER_NAME'];
  $nvl = "";
  $modulo_inicial = 0;
	$tamanho_padrao_foto = " height=140 width=120 ";

/*
http://example.com/Novo/adm/categoria/1-Nome_Categoria

http://example.com/Novo/adm.php?categoria=1
    $URL_ATUAL= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    echo $URL_ATUAL;

adm/categoria/1-Nome_Categoria

Novo/adm/categoria/1-Nome_Categoria

$url = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '/')+1);

echo basename( __FILE__ ) ."\n";
 
	$path_parts = pathinfo( __FILE__ );
	echo '1.'.$path_parts['dirname'], "\n";
	echo '2.'.$path_parts['basename'], "\n";
	echo '3.'.$path_parts['extension'], "\n";
	echo '4.'.$path_parts['filename'], "\n"; // desde o PHP 5.2.0

prog.php
1./home/eq1okH
2.prog.php
3.php
4.prog

*/
	
//===========================//

//===========================//

// exibir erros
error_reporting(E_ERROR | E_PARSE | E_WARNING);
ini_set("register_globals","off");
ini_set('max_execution_time', 100); 


// ini_set("include_path","$diretorio_include/include/apl:$diretorio_include:$diretorio_include/conf:$diretorio_include/include");


setlocale (LC_ALL, 'pt_BR');

header('Access-Control-Allow-Origin: *');

// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// always modified
header("Last-Modified: " . date("D, d M Y H:i:s") . " GMT");
 
// HTTP/1.1
header("Cache-Control: no-store, no-cache"); //, must-revalidate
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");

?>
