<center>
<form name=frm_login id=frm_login method=post action="<?=$self?>">
	<input type="hidden" name="PHPSESSID" value="<?=$valor_sessao?>">
	Informe a senha de acesso<br>
	<?php
		monta_teclado_numerico(array("acesso_ae", "P"));
	?>
</form>
</center>
<script>
// tela externa 470 x 286
// Tela principal 376 x 777
var windowWidth = window.innerWidth;
var windowHeight = window.innerHeight;

var screenWidth = screen.width;
var screenHeight = screen.height;
document.writeln("Janela: " + windowWidth + "x" + windowHeight + "<br>");
document.writeln("Tela: " + screenWidth + "x" + screenHeight);
</script>
