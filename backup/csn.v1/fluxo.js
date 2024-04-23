var anoAtual;
var membroCarona = Array("Akira", "Alba", "Rosa", "Claudia", "Estenio", "Jessica", "Lucas").sort();
var	opDB;
var	opCS;
//------ FUNÇÕES ESPECÍFICAS APP --------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
function menu(p_opcao) {
//--------------------------------------------------------------------------------------------------
	el("op_menu").value = p_opcao;
	el("frm_menu").submit();
}
//--------------------------------------------------------------------------------------------------
function pagarMP(pIndice) {
	el("indicePG").value = pIndice;
	el("dtPG").value = el('dtMP').value;
	el("editar_mp").submit();
}
//--------------------------------------------------------------------------------------------------
function cancelarMP(pIndice) {
	el("indiceCancelar").value = pIndice;
	el("cancelar_mp").submit();
}
//--------------------------------------------------------------------------------------------------
function preRecibo(pMembro, pValor, pData, pMesAno, pTipo) {
	sep = "\n"; 
	reciboPre = "Comprovante CSN"+sep+sep+"Recebi de " + pMembro + " a quantia de R$ "+pValor+" relativo à ";
	reciboPre += (pTipo =="M" ? " mensalidade " : " prestação da Terracap ")
	reciboPre += " de "+pMesAno+" no dia "+pData+".";
	return reciboPre;
}
//--------------------------------------------------------------------------------------------------
/*
function preparaRecibo(pIndice) {
	if (opCS == "M") { opDB = 1; } 
	if (opCS == "P") { opDB = 6; }
	db2 = dbConfig[opDB][1];
	vRecibo = db2[pIndice].split(";");
	vRecibo = preRecibo(vRecibo, opCS);
	mensagemRecibo(vRecibo);
}
*/
//--------------------------------------------------------------------------------------------------
function fecharEdicao() {
	escondeElementoClasse("div", "editor");
	esconde("telaEdicao");
}
//--------------------------------------------------------------------------------------------------
function mensagemRecibo(pRecibo) {
	mensagem("<textarea id=copiarRecibo rows=8 cols=35>"+pRecibo + "</textarea><br><br>Recibo Copiado"); 
	copiaId("copiarRecibo");
}
//--------------------------------------------------------------------------------------------------
async function enviarRecibo(pIndiceRecibo) {
	opDB = (op == "4" ? 1 : 6)
	db = dbConfig[opDB][1];
	vRecibo = db[pIndiceRecibo].split(";");
	recibo = preRecibo(vRecibo, (op == "4" ? "M" : "P"));	
	if (navigator.share === undefined) {
		alert("Neste ambiente, não é possível envio do Recibo de Prestação. Tente num smartphone com Whatsapp.\n\n"+recibo);
	} else {
		title = "Comprovante CSN";
		text = recibo;
		url = "/Recibo";
		try {
			await navigator.share({title, text, url});
		} catch (error) {
			Alert('Erro compartilhamento: ' + error);
			return;
		}
		alert('Recibo enviado com sucesso');
	}
	opDB = (op == "4" ? 0 : 5)
	db = dbConfig[opDB][1];
}
//----- INÍCIO PROGRAMA JAVASCRIPT --------------------------------------------------------------------------------------
//----- FIM JAVASCRIPT --------------------------------------------------------------------------------------------------
