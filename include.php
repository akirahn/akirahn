<?php
	include_once("include/config_sv.php");
	include_once("include/config.php");
	include_once("include/funcoes.php");
	include_once("include/forms.php");
	include_once("include/globais.php");
	include_once("include/bd.php");
	include_once("");
	conectar();
	
	include_once("include/variaveis.php");
	
	if (!isset($menu_off)) { $menu_off = 0 ; }
	
?>	
<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$apps[$app_padrao]["tit"]?></title>
<?php
	include_once("include/style_js.php");
?>
</head>
<center>

<div id="barraMensagem" class="modal">
  <div class="modal-content" style="max-width: 95%; max-height: 95%; width: 50%; height: 10%; overlfow: auto;">
    <span class="close" onclick="esconde('barraMensagem');"><?=$ico_fechar?></span>
    <div id=textoMensagem></div>
  </div>
</div>

<div id="barraAviso" class="modal">
  <div id=contentAviso class="modal-content" style="position: relative; top: 39%; max-width: 95%; max-height: 95%; width: 70%; height: 20%; overlfow: auto;">
		<span class="botao" style="float: right;" onclick="esconde('barraAviso');"><?=$ico_fechar?></span>
    <div id=textoAviso></div>
  </div>
</div>

<div id="modalEdicao" class="modal">
  <div class="modal-content">
  	<center>
			<div class=modalTitulo id=modalTituloConteudo></div>
	    <span class="fechar" onclick="modalFechar();"><?=$ico_fechar?></span>
			<span class="gravar" onclick="modalGravar()"><?=$ico_gravar?></span>
			<input type=hidden id=nome_frm_modal name=nome_frm_modal>
			<input type=hidden id=tipo_modal name=tipo_modal value=2>
    </center>
		<br>
		<br>
		<div id=modalConteudo class=editor></div>
		<button type=button class="botao botao_gravar" onclick="modalGravar()"> <?=$ico_gravar?> Gravar </button>
	</div>
</div>

<form name=frm_exclusao id=frm_exclusao method=post style="display: none;">
	<input type="hidden" name="p_exclusao_opcao" 	id="p_exclusao_opcao">
	<input type="hidden" name="p_exclusao_id" 		id="p_exclusao_id">
	<input type="hidden" name="p_exclusao_tabela" id="p_exclusao_tabela">
</form>

<?php	
	session_start();
	$valor_sessao = ($PHPSESSID == "" ? session_id() : $PHPSESSID);
	if ($sair == "S") { 
		$_SESSION["acesso_ae"] = "";		
		session_destroy();
		session_start();
		$valor_sessao = (empty($PHPSESSID) ? session_id() : $PHPSESSID);
		header("location: index.php");
	} 
	if ($_SESSION["acesso_ae"] == "" and $acesso_ae <> "") {
		$qLoginAcesso = "SELECT m.id FROM membro m where id in (60, 61, 65, 91)
and date_format(nascimento, '%Y') = '$acesso_ae'";
		$loginAcesso = pesquisa($qLoginAcesso, 0);
		if ($loginAcesso == "") {
			msgErro("Acesso inválido!");
		} else {
			$_SESSION["acesso_ae"] = $acesso_ae;		
		}
	}
	if ($_SESSION["acesso_ae"] == "") {
		include_once("login.php");
		die;
	} else {
		if ($nome_pagina == "login" or $nome_pagina == "sair") {
			header("location: index.php");
		}
	}
	
?>
