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
function vlE(pId) { return valorE(pId); }
//--------------------------------------------------------------------------------------------------
function carregaUltimaMP() {
	el("opcaoMP").value = (op == "4" ? "M" : "P");
	ajaxDivForm("ver_mp", "telaConteudo", "frm_mp");
}
//--------------------------------------------------------------------------------------------------
function pagarMP(pIndice) {
	el("indicePG").value = pIndice;
	el("dtPG").value = el('dtMP').value;
	el("editar_mp").submit();
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
function preparaRecibo(pIndice) {
	if (opCS == "M") { opDB = 1; } 
	if (opCS == "P") { opDB = 6; }
	db2 = dbConfig[opDB][1];
	vRecibo = db2[pIndice].split(";");
	vRecibo = preRecibo(vRecibo, opCS);
	mensagemRecibo(vRecibo);
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
//--------------------------------------------------------------------------------------------------
function consulta() {
	hTxt = "";
	ph(br);
	opCS = radioValor("tipoRel");
	ph(br);
	pTable('width=100% class=padrao border=0 cellspacing=0');
		pth('Data', '');
		switch(opCS) {
			case "M":
				opDB = 1;
				pth('Membro', '');
				pth('Ref', '');
				pth('R$', '');
				break;
			case "F":
				opDB = 2;
				pth('Tipo', 'align=left');
				pth('Créd', 'align=right');
				pth('Déb' , 'align=right');
				break;
			case "C":
				opDB = 3;
				pth('Tipo', '');
				pth('Ref', '');
				pth('R$', '');
				break;
			case "P":
				opDB = 6;
				pth('Membro', '');
				pth('Ref', '');
				pth('R$', '');
				break;
			case "T":
				opDB = 7;
				pth('Ref', '');
				pth('R$', '');
				break;
		}
		db = dbConfig[opDB][1];
		ptr();
		for (i=0, mx = db.length; i < mx; i++) {
			membro = db[i].split(";");
			pValor = membro[2];
			valor = parseFloat(pValor);
			ptd(formatoData(membro[1]), '');
			switch(opCS) {
				case "M": ptd(membro[3], ''); break;
				case "P": ptd(membro[3], ''); break;
				case "C": ptd(membro[5], ''); break;
				case "F": ptd(membro[5], ''); break;
			}
			if (opCS == "F") {
				if (membro[4] == "C") {
					ptMoeda(pValor);
				} else {
					ptd("");
				}
			} else {
				ptd(formatoMesAno(membro[6]), 'align=center');
			}
			if (opCS == "F") {
				if (membro[4] == "D") {
					ptMoeda(pValor);
				} else {
					ptd("");
				}
			} else {
				ptMoeda(pValor);
			}
			ptd("&#9998;", "class=botao onclick=\"editar("+ i +")\" ");
			ptd("&times;", "class=botao onclick=\"excluir("+ i +")\" ");
			if (opCS == "M" || opCS == "P") {
				ptd("&#174;" , "class=botao onclick=\"preparaRecibo('"+i+"')\" ");
			}
			ptr();
		}
	pTable('');
	htmlId("telaConteudoConsulta");
	mostra("telaConsulta");
	esconde("telaConteudo");
}
//--------------------------------------------------------------------------------------------------
function mostra_membro(pObjeto) {
	hTxt = "";
	ph('<option value="0">Membro</option>');
	switch(op) {
		case "1": db = dbConfig[0][1]; break;
		case "5": db = membroCarona; break;
		case "7": db = dbConfig[6][1]; break;
	}
	for (i=0, mx = db.length; i < mx; i++) {
		membro = db[i].split(";");
		ph('<option value="' + membro[0] + '">'+ membro[0] +'</option>');
	}
	htmlId(pObjeto);
}	
//--------------------------------------------------------------------------------------------------
function fecharEdicao() {
	escondeElementoClasse("div", "editor");
	esconde("telaEdicao");
}
//--------------------------------------------------------------------------------------------------
function gravaDB() {
	ls.setItem(dbConfig[opDB][0], JSON.stringify(dbConfig[opDB][1]));
}
//--------------------------------------------------------------------------------------------------
function gravacao(pRegistro, pIndice) {
	db   = dbConfig[opDB][1];
	if (db.indexOf(pRegistro) != -1) {	
		mensagem("Registro já existe !");
		return -1;
	} else {
		if (pIndice != null) {
			db[pIndice] = pRegistro;
		} else {
			if (db == Array()) {
				db.Array(pRegistro);
			} else {		
				db.push(pRegistro);
			}				
		}
		gravaDB();
		fecharEdicao();
		switch(op) {
			case "2": op = "1"; el("menuAcao").value = op; el("rel"+opCS).checked = 'true'; mensagem("Gravado com sucesso !"); consulta(); break;
			case "3": op = "1"; el("menuAcao").value = op; el("rel"+opCS).checked = 'true'; mensagem("Gravado com sucesso !"); consulta(); break;
			case "8": op = "1"; el("menuAcao").value = op; el("rel"+opCS).checked = 'true'; mensagem("Gravado com sucesso !"); consulta(); break;
		}
		return 1;
	}
}
//--------------------------------------------------------------------------------------------------
function gravar(pIndice) {
	switch(op) {
		case "1":
			switch(radioValor('tipoRel')) {
				case "M":
					opDB = 1;
					registro = "M;"+vlE("mesDt")+";"+vlE("mesValor")+";"+vlE("mesMembro")+";C;Mensalidade;"+vlE("mesDtContas")+"-01;";
					break;
				case "F":
					opDB = 2;
					registro = "F;"+vlE("dtFluxo")+";"+vlE("vlFluxo")+";;"+vlE("movCadCD")+";"+vlE("tpCad")+";"+vlE("dtFluxo")+";"+vlE("obsFluxo");
					break;
				case "C":
					opDB = 3;
					registro = "C;"+vlE("dtPagtoContas")+";"+vlE("vlContas")+";;C;"+vlE("agua_luz")+";"+vlE("mesAnoContas")+"-01;";
					break;
				case "P":
					opDB = 6;
					registro = "P;"+vlE("prDt")+";"+vlE("prValor")+";"+vlE("prMembro")+";C;Prestação;"+vlE("prDtContas")+"-01;";
					break;
				case "T":
					opDB = 7;
					registro = "T;"+vlE("dtPrestacao")+";"+preparaValorLS("vlPrestacao")+";;C;Terracap;"+vlE("refPrestacao")+"-01;";
					break;
			}
			break;
		case "2":
			opDB = 3;
			registro = "C;"+vlE("dtPagtoContas")+";"+preparaValorLS("vlContas")+";;C;"+vlE("agua_luz")+";"+vlE("mesAnoContas")+"-01;";
			indiceAtualizacao = null;
			break;
		case "3":
			opDB = 2;
			registro = "F;"+vlE("dtFluxo")+";"+preparaValorLS("vlFluxo")+";;"+vlE("movCadCD")+";"+vlE("tpCad")+";"+vlE("dtFluxo")+";"+vlE("obsFluxo");
			indiceAtualizacao = null;
			break;
		case "4":
			opDB = 1;
			registro = "M;"+vlE("dtMP")+";"+valor+";"+membro+";C;Mensalidade;"+dtContas+";";
			break;
		case "5":
			opDB = 4;
			registro = vlE("carona_membro")+";"+vlE("carona_dt");
			break;
		case "7":
			opDB = 6;
			registro = "P;"+vlE("dtMP")+";"+valor+";"+membro+";C;Prestação;"+dtContas+";";
			break;
		case "8":
			opDB = 7;
			registro = "T;"+vlE("dtPrestacao")+";"+preparaValorLS("vlPrestacao")+";;C;Terracap;"+vlE("refPrestacao")+"-01;";
			alert(registro);
			indiceAtualizacao = null;
			break;
	}
	ok = gravacao(registro, indiceAtualizacao);
	if (ok != -1) {
		if (op == "5") { carregaCarona(); } 
		if (op == "1") { consulta(); }
	}
}
//--------------------------------------------------------------------------------------------------
function editar(pIndice) {
	mostra("telaEdicao");
	escondeElementoClasse("div", "editor");
	db = dbConfig[opDB][1];
	if (pIndice != null) { edt = db[pIndice].split(";"); indiceAtualizacao = pIndice; }	
	switch(opCS) {
		case "M":
			el("mesDt").value = edt[1];
			el("mesMembro").value = edt[3];
			el("mesValor").value = formatoMoeda(edt[2]);
			el("mesDtContas").value = edt[6].substr(0, 7);
			mostra("telaEdicaoMensalidade");
			break;
		case "F":
			if (pIndice != null) {
				el("dtFluxo").value = edt[1];
				radioPesquisa("tCRd", edt[5]);
				valorId("tpCad", edt[5]);
				radioPesquisa("fCDRd", edt[4]);
				valorId("movCadCD", edt[4]);
				el("vlFluxo").value = formatoMoeda(edt[2]);
				el("obsFluxo").value = edt[7];
			}
			mostra("telaFluxo");
			break;
		case "C":
			if (pIndice != null) {
				el("dtPagtoContas").value = edt[1];
				radioPesquisa("ctRd", edt[5]);
				valorId("agua_luz", edt[5]);
				el("mesAnoContas").value = edt[6].substr(0, 7);
				el("vlContas").value = formatoMoeda(edt[2]);
			}
			mostra("telaContas");
			break;
		case "P":
			el("prDt").value = edt[1];
			el("prMembro").value = edt[3];
			el("prValor").value = formatoMoeda(edt[2]);
			el("prDtContas").value = edt[6].substr(0, 7);
			mostra("telaEdicaoPrestacao");
			break;
		case "T":
			if (pIndice != null) {
				el("dtPrestacao").value = edt[1];
				el("vlPrestacao").value = formatoMoeda(edt[2]);
				el("refPrestacao").value = edt[6].substr(0, 7);
			}
			mostra("telaEdicaoTerracap");
			break;
	}
	mostra("telaEdicao");
}
//--------------------------------------------------------------------------------------------------
function edicaoCarona(pIndice) {
	opDB = 4;
	db 	= dbConfig[opDB][1];
	escondeElementoClasse("div", "editor");
	indiceAtualizacao = pIndice;
	mostra("telaEdicao");
	mostra("telaEdicaoCarona");
	mostra_membro("carona_membro");
	if (pIndice == null) {
		el("carona_membro").value = 0;
	} else {
		alert(db[pIndice]);
		vlAltera = db[pIndice].split(";");
		valorId("carona_membro", vlAltera[0]);
		valorId("carona_dt", vlAltera[1]);
	}
}
//--------------------------------------------------------------------------------------------------
function excluir(pIndice) {
	db.splice(pIndice, 1);
	gravaDB();
	if (op == "5") { carregaCarona();	} 
	if (op == "1") { consulta();	} 
}
//--------------------------------------------------------------------------------------------------
function carregaCarona() {
	hTxt = "";
	pTable("width=100% class='padrao consulta'");
		pth('Carona Chica', 'colspan=3');
		ptr();
		pth('Membro', '');
		pth('Data', '');
		ptd("Incluir", "onclick=\"edicaoCarona();\" class=botao colspan=2");
		ptr();
		db.sort();
		for (i=0, mx = db.length; i < mx; i++) {
			carona = db[i].split(";");
			ptd(carona[0], '');
			ptd(formatoData(carona[1]), 'align=center');
			ptd("&#9998;", "onclick=\"edicaoCarona("+ i +")\"  class=botao");
			ptd("&times;", "onclick=\"excluir("+ i +")\"  class=botao");
			ptr();
		}
	pTable('');
	htmlId("telaConteudo");
}
//--------------------------------------------------------------------------------------------------
function gera_dados_backup() {
	s = "\n";
	msg = "";
	for (x=0, mx=dbConfig.length; x < mx; x++) {
		aBase = dbConfig[x][1];
		if (aBase != "") {
			msg += dbConfig[x][2] + s;
			msg += aBase[0] + s;
		}
		for (h=1,mx=aBase.length; h < mx; h++) {
			msg += aBase[h] + s;
		}
	}
	return msg;
}

//--------------------------------------------------------------------------------------------------
async function backup() {
	texto = "";
	if (mobile == 0) {
		texto = gera_dados_backup();
		conteudo("telaConteudo", "<br><textarea id=textoBackup>"+texto+"</textarea><br>Dados Copiados");
		copiaId("textoBackup");
		return;
	} else {
		title	= "Backup Nuvem";
		s = "\n";
		texto = gera_dados_backup();
		url = "CSN_Backup_Nuvem";
		try {
			await navigator.share({title, texto, url});
		} catch (error) {
			mensagem('Erro no backup: ' + error);
			return;
		}
		mensagem("Backup em Nuvem efetuado com sucesso !");
	}
}	
//--------------------------------------------------------------------------------------------------
function frm_submit(p_pg_frm) {
	ajaxDivForm(p_pg_frm, "Mensagem", p_pg_frm);
}
//--------------------------------------------------------------------------------------------------
function acao() {
	hTxt = "";
	db = "";
	escondeElementoClasse("DIV", "tela");
	conteudo("telaConteudo", "");
	esconde("telaConsulta");
	// if (op != "1") { mostra("telaConteudo"); }
	switch(op) {
		case "1": consulta();
							break;
		case "2": mostra("telaContas");
							el("dtPagtoContas").value = valorHoje();
							el("mesAnoContas").value = valorHoje();
							break;
		case "3": mostra("telaFluxo");
							el("dtFluxo").value = valorHoje();
							break;
		case "4": mostra("telaConteudo");	
							carregaUltimaMP();
							break;
		case "5": opDB = 4;
							db 	= dbConfig[opDB][1];
							carregaCarona();
							break;
		case "6": backup();
							break;
		case "7": mostra("telaConteudo");	
							carregaUltimaMP();
							break;
	}	
}
//----- INÍCIO PROGRAMA JAVASCRIPT --------------------------------------------------------------------------------------
op = "";
escondeElementoClasse("DIV", "tela");
//----- FIM JAVASCRIPT --------------------------------------------------------------------------------------------------

// header('Access-Control-Allow-Origin: *');
