<?php
	include_once("include.php");
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tesouraria CSN</title>
<meta charset="UTF-8">
<head>
	<link rel='stylesheet' href='padrao.css' type='text/css'/>
	<link rel='stylesheet' href='fluxo.css' type='text/css'/>
	<script src="zepto.min.js"></script>
	<script src="padrao.js"></script>
	<script src="fluxo.js"></script>
</head>
<body>
<div id=tituloCSN class="titulo">
	<table width=100% border=0>
		<td rowspan=1 class=csn >CSN</td>
		<td align="right">
			<button onclick="acao();conteudo('mensagem', '');">Atualizar</button>
			<select id=menuAcao onchange="op=this.value;acao()">
				<option value="">Menu</option>
				<option value=4>Mensalidade</option>
				<option value=2>Contas</option>
				<option value=3>Fluxo</option>
				<option value=1>Consulta</option>
				<option value=7>Prestação</option>
			</select>
		</td>
	</table>
</div>

<form name=frm_mp id=frm_mp method=post><input type=hidden name=opcaoMP id=opcaoMP value="M"></form>

<form name=frm_pagar id=frm_pagar method=post>
	<input type=hidden name=opcaoPG 	id=opcaoPG 	value="">
	<input type=hidden name=dtPG 			id=dtPG 		value="">
	<input type=hidden name=indicePG 	id=indicePG value="">
</form>

<div id=Mensagem></div>

<div id=telaConteudo class=tela></div>

<div id=telaEdicaoMensalidade class=tela>
	<div class=tituloEdicao>Mensalidade</div><br>
	<form name=edtMensalidade id=edtMensalidade method=post action="ajaxDivForm('', 'telaConteudo', 'edtMensalidade')">
	<label>Data: <input type="date" id="mesDt"></label><br>			
	<input type=text 	disabled id=mesMembro><br>
	<input type=text 	disabled id=mesValor><br>
	<input type=month disabled id=mesDtContas><br>
	<submit>
	</form>
</div>

<div id=telaConsulta class=tela>
	<div class=div_radio>
		<input type=radio name=tipoRel value='M' checked id=relM onchange='consulta();'><label class=rel3p for=relM> Mensalidade </label>
		<input type=radio name=tipoRel value='F' id=relF onchange='consulta();'><label class=rel3p for=relF> Fluxo </label>
		<input type=radio name=tipoRel value='C' id=relC onchange='consulta();'><label class=rel3p for=relC> Contas </label>
		<input type=radio name=tipoRel value='P' id=relP onchange='consulta();'><label class=rel3p for=relP> Prestação</label>
		<input type=radio name=tipoRel value='T' id=relT onchange='consulta();'><label class=rel3p for=relT> Terracap</label>
	</div>
	<div id=telaConteudoConsulta class=tela></div>
</div>
<div id=telaContas class=tela>
	<form name=inc_contas id=inc_contas method=post>
	<label>Data <input type="date" id="dtPagtoContas"></label>
	<input type="hidden" id="agua_luz">
	<input type="hidden" id="opContas" value="I">
	<br><br>
	<div class=div_radio>
		<input type=radio name=ctRd id=fAgua checked 	value="Água" 			onclick="valorId('agua_luz','Água')"			><label for=fAgua> Água </label>
		<input type=radio name=ctRd id=fLuz  					value="Luz" 			onclick="valorId('agua_luz','Luz') "			><label for=fLuz > Luz  </label>
		<input type=radio name=ctRd id=fFed  					value="Federação" onclick="valorId('agua_luz','Federação') "><label for=fFed > Federação </label>
		<input type=radio name=ctRd id=fTer  					value="Terracap" 	onclick="valorId('agua_luz','Terracap') "	><label for=fTer > Terracap </label>
	</div>
	<br><br>
	<label>Data <input type="month" id="mesAnoContas"></label>
	<br><br>
	<label>Valor <input type="text" id="vlContas" inputmode="numeric"  onkeyup="formatarMoeda(this);"></label>
	</form>
	<button onclick="frm_submit('editar_contas');">Gravar</button>
</div>
<div id=telaEdicaoPrestacao class=tela>
	<div class=tituloEdicao>Prestação</div><br>
	<label>Data: <input type="date" id="prDt"></label><br>			
	<input type=text 	disabled id=prMembro><br>
	<input type=text 	disabled id=prValor><br>
	<input type=month disabled id=prDtContas><br>
</div>
<div id=telaEdicaoTerracap class=tela>
	<div class=tituloEdicao>Terracap</div><br>
	<label>Data <input type="date" id="dtPrestacao"></label>
	<br><br>
	<label>Referência <input type="month" id="refPrestacao"></label>
	<br><br>
	<label>Valor <input type="text" id="vlPrestacao" inputmode="numeric"  onkeyup="formatarMoeda(this);"></label>
</div>
<div id=telaFluxo class=tela>
	<table width=100% cellspacing="5">
		<form name=editar_fluxo id=editar_fluxo method=post>
			<input type="hidden" id="opFluxo" value="I">
		<td width=50% valign=top style="border-right: 1px solid var(--branco); padding-left: 2px;">
			<label>Data <input type="date" id="dtFluxo" size=5></label>
			<br><br>
			<input type="hidden" id="movCadCD">
			<div class=div_radio>
				<input type=radio name=fCDRd id=mCred checked value="C" onclick="valorId('movCadCD', 'C')"><label for=mCred>Crédito</label>
				<input type=radio name=fCDRd id=mDeb  value="D" onclick="valorId('movCadCD', 'D')"><label for=mDeb >Débito</label>
			</div>
			<br><br>
			<label>Valor <input type="text" id="vlFluxo" inputmode="numeric" size=10 onkeyup="formatarMoeda(this);"></label>
			<br><br>
			<label>Obs:  <input type="text" id="obsFluxo" size=15></label>
			<br><br>
		</td>
		<td>
		<div class=div_radio>
			<input type="hidden" id="tpCad">
			Tipo<br><br>
			<input type=radio name=tCRd id=tcVL  value="Velas" checked 	onclick="valorId('tpCad', 'Velas') "		 ><label for=tcVL >Velas			</label><br><br>
			<input type=radio name=tCRd id=tcMT  value="Material" 			onclick="valorId('tpCad', 'Material')	"  ><label for=tcMT >Material		</label><br><br>
			<input type=radio name=tCRd id=tcMN  value="Manutenção" 		onclick="valorId('tpCad', 'Manutenção') "><label for=tcMN >Manutenção	</label><br><br>
			<input type=radio name=tCRd id=tcOU  value="Outros" 				onclick="valorId('tpCad', 'Outros')	"	 	 ><label for=tcOU >Outros			</label><br><br>
			<input type=radio name=tCRd id=tcDO  value="Doação" 				onclick="valorId('tpCad', 'Doação')	"	   ><label for=tcDO >Doação			</label><br><br>
			<input type=radio name=tCRd id=tcGA  value="Gás" 						onclick="valorId('tpCad', 'Gás')		"	   ><label for=tcGA >Gás				</label><br><br>
			<input type=radio name=tCRd id=tcBC  value="Banco" 					onclick="valorId('tpCad', 'Banco')	"	   ><label for=tcBC >Banco			</label><br><br>
		</div>
		</td>
	</table>
	</form>
	<button onclick="frm_submit('editar_fluxo');">Gravar</button>
</div>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
	    <span class="close" onclick="fecharEdicao();">Fechar</span>
			<span class="close" id=excluir onclick="excluir()">Excluir</span>
			<span class="close" id=gravar onclick="gravar()">Gravar</span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaoCarona class=editor>
			<div class=tituloEdicao>Carona Chica</div><br>
			<label>Membro <select id="carona_membro"></select></label><br>
			<label>Data: <input type="date" id="carona_dt"></label> 
		</div>
	</div>
</div>
</body>
<?php
desconectar();
?>