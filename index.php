﻿<?php
	$app_padrao = "apps";
	include_once("include.php");
	// <button class=barra2 onclick="window.open('?=$apps["mae"]["url"];?');">?=$apps["mae"]["app"];?</button>
?>
<script>
//--------------------------------------------------------------------------------------------------
	function incluir_app(p_formulario) {
		mostra("modalEdicao");
		$("#tipo_modal").val(1);
		$('#modalConteudo').load("/apps/"+p_formulario+".php?p_edicao_opcao=PI");
	}
//--------------------------------------------------------------------------------------------------
var windowWidth = window.innerWidth;
var windowHeight = window.innerHeight;
var windowDpr = window.devicePixelRatio;

var screenWidth = screen.width;
var screenHeight = screen.height;

</script>
<center>
<span class="titulo font-effect-shadow-multiple" align=center><?=$apps["apps"]["tit"]?></span>
	<br>
	<button class=add onclick="incluir_app('gst/frm_financas');"><?=$ico_incluir?></button>	
	<button onclick="window.open('<?=$apps["gst"]["url"];?>');"><?=$apps["gst"]["app"];?></button>
	<br>
	<button class=add onclick="incluir_app('cab/frm_cabeca');"><?=$ico_incluir?></button>	
	<button onclick="window.open('<?=$apps["cab"]["url"];?>');"><?=$apps["cab"]["app"];?></button>
	<br>
	<button class=add onclick="incluir_app('uno/frm_combustivel');"><?=$ico_incluir?></button>	
	<button onclick="window.open('<?=$apps["uno"]["url"];?>');"><?=$apps["uno"]["app"];?></button>
	<br>
	<button class=add onclick="incluir_app('csn/frm_fluxo');"><?=$ico_incluir?></button>	
	<button onclick="window.open('<?=$apps["csn"]["url"];?>');"><?=$apps["csn"]["app"];?></button>
	<br>
	<button class=barra2 onclick="window.open('<?=$apps["mae"]["url"];?>');"><?=$apps["mae"]["app"];?></button>
	<button class=barra2 onclick="window.open('<?=$apps["rat"]["url"];?>');"><?=$apps["rat"]["app"];?></button>
	<br>
	<button class=barra2 onclick="window.open('<?=$apps["lst"]["url"];?>');"><?=$apps["lst"]["app"];?></button>
	<button class=barra2 onclick="window.open('<?=$apps["app"]["url"];?>');"><?=$apps["app"]["app"];?></button>
	<br>
	<button class="sair" onclick="location.href='<?=$apps["sai"]["url"];?>';"><?=$apps["sai"]["app"];?></button>
	<br>	
	<br>	
<?php

?>
<script>
document.writeln("Janela: " + windowWidth + "x" + windowHeight + " DPR: " + windowDpr + "<br>");
document.writeln("Tela: " + screenWidth + "x" + screenHeight);
</script>