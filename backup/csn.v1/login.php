<span class=csn>Tesouraria CSN</span>&nbsp;
<br>
<br>
<br>
<br>
<center>
<form name=frm_login id=frm_login method=post action="<?=$self?>">
	<input type="hidden" name="PHPSESSID" value="<?=$valor_sessao?>">
	<input type=text name=meuacesso size=10 inputmode="numeric" autocomplete="off"><br><br>
	<div class='btn-group'>
		<button onclick="document.getElementById('frm_login').submit();">Entrar</button>
		<button onclick="window.close();">Fechar</button>
	</div>
</form>
</center>
