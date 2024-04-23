<?php
	include_once("include.php");
	if (!isset($PHPSESSID)) { $PHPSESSID = "" ; }
	if (!isset($op_menu)) { $op_menu = "" ; }
	if (!isset($meuacesso)) { $meuacesso = "" ; }
	
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tesouraria CSN</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<meta charset="UTF-8">
<head>
	<link rel='stylesheet' href='/apps/arquivos/padrao.css' type='text/css'/>
	<link rel='stylesheet' href='fluxo.css' type='text/css'/>
	<script src="/apps/arquivos/jquery-3.6.1.min.js"></script>
	<script src="/apps/arquivos/padrao.js"></script>
	<script src="fluxo.js"></script>
</head>
<center>

<div id="barraMensagem" class="modal">
  <div class="modal-content">
    <span class="close" onclick="esconde('barraMensagem');">&times;</span>
    <div id=textoMensagem></div>
  </div>
</div>

<?php
	session_start();
	$valor_sessao = ($PHPSESSID == "" ? session_id() : $PHPSESSID);
	if ($op_menu == "999") { 
		$_SESSION["meuacesso"] = "";		
		session_destroy();
		session_start();
		$valor_sessao = (empty($PHPSESSID) ? session_id() : $PHPSESSID);
	} 
	if ($_SESSION["meuacesso"] == "" and $meuacesso <> "") {
		$qMembro = "select m.id from membro m where m.id = $meuacesso";
		$membro = pesquisa($qMembro, 0);
		if ($membro == "") {
			msgErro("Acesso inválido!");
		} else {
			$_SESSION["meuacesso"] = $meuacesso;			
		}
	}
	if ($_SESSION["meuacesso"] == "") {
		include_once("login.php");		
	} else {
		include_once("menu.php");			
	}
?>

</center>
