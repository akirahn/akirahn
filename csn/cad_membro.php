﻿<?php
	$tituloPagina = "Membro";
	include_once("include.php");
?>
<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_membro(p_id_membro) {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoMembro");
		el("opMembro").value 				= "A";
		el("id_membro").value 			= p_id_membro;
		var dados = $('#frm_editar_membro').serialize();
		$.ajax({
				type : 'POST',
				dataType: 'TEXT',
				url  : "buscar_membro.php",
				data: dados,
				success :  function(data){
					valores = data.split(";");
					$('#nr_ordem').val(valores[1]);
					$('#nm_membro').val(valores[2]);
					$('#nm_apelido').val(valores[3]);
					radioPesquisa("tipo_membro_id", valores[4]);
					selectPesquisaValor("tipo_hierarquia_id", valores[5]);
					radioPesquisa("tipo_situacao_id", valores[6]);
					$('#email').val(valores[7]);
					$('#nascimento').val(valores[8]);
					$('#fone_residencial').val(valores[9]);
					$('#fone_comercial').val(valores[10]);
					$('#celular').val(valores[11]);
					$('#celular2').val(valores[12]);
					$('#endereco').val(valores[13]);
					$('#bairro').val(valores[14]);
					$('#cep').val(valores[15]);
					$('#cidade').val(valores[16]);
					$('#uf').val(valores[17]);
					$('#cpf').val(valores[18]);
					$('#rg').val(valores[19]);
					$('#orgaorg').val(valores[20]);
					$('#pai').val(valores[21]);
					$('#mae').val(valores[22]);
					$('#vl_mensalidade').val(valores[23]);
					$('#proxima_mensalidade').val(valores[24]);
					$('#vl_prestacao').val(valores[25]);
					$('#proxima_prestacao').val(valores[26]);
					$('#dt_ingresso').val(valores[27]);
				}
		});
	}
//--------------------------------------------------------------------------------------------------
	function incluir_membro() {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoMembro");
		el("opMembro").value 				= "I";
		el("id_membro").value 			= "";
		el("nr_ordem").value 			= "99";
		$('#nm_membro').val("");
		$('#nm_apelido').val("");
		$('#tipo_membro_id').val("");
		$('#tipo_hierarquia_id').val("");
		$('#tipo_situacao_id').val("");
		$('#email').val("");
		$('#nascimento').val("");
		$('#fone_residencial').val("");
		$('#fone_comercial').val("");
		$('#celular').val("");
		$('#celular2').val("");
		$('#endereco').val("");
		$('#bairro').val("");
		$('#cep').val("");
		$('#cidade').val("");
		$('#uf').val("");
		$('#cpf').val("");
		$('#rg').val("");
		$('#orgaorg').val("");
		$('#pai').val("");
		$('#mae').val("");
		$('#vl_mensalidade').val("");
		$('#proxima_mensalidade').val("");
		$('#vl_prestacao').val("");
		$('#proxima_prestacao').val("");
		$('#dt_ingresso').val("");
	}
//--------------------------------------------------------------------------------------------------
	function excluir_membro(pIndice) {
		el("opMembro").value 		= "E";
		el("id_membro").value 	= pIndice;
		el("frm_editar_membro").submit();
	}
//--------------------------------------------------------------------------------------------------
	function gravar_membro() {
		el("frm_editar_membro").submit();
	}
</script>

<?php
	// Variáveis
/*	
	if (!isset($dt_fluxo)) {	$dt_fluxo = ""; }
	if (!isset($tipo_pesq)) {	$tipo_pesq = ""; }
	if (!isset($opMembro)) {	$opMembro = ""; }
*/	
	if ($nm_membro <> "" and $nm_apelido <> "" and $opMembro <> "P") {
		// e("vl_mensalidade: $vl_mensalidade vl_prestacao: $vl_prestacao");
		if ($vl_mensalidade == "") { $vl_mensalidade = "null"; } else { $vl_mensalidade = "'". valor_sql($vl_mensalidade) . "'"; }
		if ($vl_prestacao == "") { $vl_prestacao = "null"; } else { $vl_prestacao 	= "'". valor_sql($vl_prestacao) . "'"; }
		if ($fone_residencial == "") {$fone_residencial = "null"; }
		if ($fone_comercial == "") {$fone_comercial = "null"; }
		if ($celular == "") {$celular = "null"; }
		if ($celular2 == "") {$celular2 = "null"; }
		if ($nascimento == "") {$nascimento = "null"; } else { $nascimento = "'$nascimento'"; }
		if ($proxima_mensalidade == "") {$proxima_mensalidade = "null"; } else { $proxima_mensalidade = "'$proxima_mensalidade-01'"; }
		if ($proxima_prestacao == "") {$proxima_prestacao = "null"; } else { $proxima_prestacao = "'$proxima_prestacao-01'"; }
		if ($dt_ingresso == "") {$dt_ingresso = "null"; } else { $dt_ingresso = "'$dt_ingresso'"; }
		$nm_membro 						= u8d($nm_membro);
		$nm_apelido 					= u8d($nm_apelido);
		$endereco 						= u8d($endereco);
		$bairro 							= u8d($bairro);
		$cidade 							= u8d($cidade);
		$pai 									= u8d($pai);
		$mae 									= u8d($mae);
		if ($opMembro == "I") {
			$qMembro = "insert into membro 
	(nr_ordem, nm_membro, nm_apelido, tipo_membro_id, tipo_hierarquia_id, tipo_situacao_id, 
	 email, nascimento, 
	 fone_residencial, fone_comercial, celular, celular2, 
	 endereco, bairro, cep, cidade, uf, 
	 cpf, rg, orgaorg, 
	 Pai, Mae, vl_mensalidade, proxima_mensalidade, vl_prestacao, proxima_prestacao, dt_ingresso) values 
 	($nr_ordem, '$nm_membro', '$nm_apelido', $tipo_membro_id, '$tipo_hierarquia_id', '$tipo_situacao_id', 
	 '$email', $nascimento,	 $fone_residencial, $fone_comercial, $celular, $celular2, 
	 '$endereco', '$bairro', '$cep', '$cidade', '$uf', 
	 '$cpf', '$rg', '$orgaorg', 
	 '$Pai', '$Mae', $vl_mensalidade, $proxima_mensalidade, $vl_prestacao, $proxima_prestacao, $dt_ingresso) ";
		} else {
			$qMembro = "update membro 
	set nr_ordem = $nr_ordem, 
			nm_membro = '$nm_membro', 
			nm_apelido = '$nm_apelido', 
			tipo_membro_id = '$tipo_membro_id', 
			tipo_hierarquia_id = '$tipo_hierarquia_id', 
			tipo_situacao_id = '$tipo_situacao_id', 
			email = '$email', 
			nascimento = $nascimento,
			fone_residencial = $fone_residencial, 
			fone_comercial = $fone_comercial,
			celular = $celular, 
			celular2 = $celular2,
			endereco = '$endereco', 
			bairro = '$bairro', 
			cep = '$cep', 
			cidade = '$cidade', 
			uf = '$uf',
			cpf = '$cpf', 
			rg = '$rg', 
			orgaorg = '$orgaorg', 	 
			Pai = '$pai', 
			Mae = '$mae', 
			vl_mensalidade = $vl_mensalidade, 
			proxima_mensalidade = $proxima_mensalidade, 
			vl_prestacao = $vl_prestacao, 
			proxima_prestacao = $proxima_prestacao, 
			dt_ingresso = $dt_ingresso
  where id = $id_membro ";
		}
		// echo $qMembro;
		$resultado = executa_sql($qMembro, "Membro ".($opMembro == "I" ? "incluído" : "alterado")." com sucesso");
		msgModal($resultado);
	}
	if ($opcao_pesq == "") { $opcao_pesq = 1; }
?>
	<form name=frm_pesquisa_membro id=frm_pesquisa_membro method=post>
		<input type=hidden name=tipo_pesq id=tipo_pesq value="P">
		<label>Situação
		<select name=opcao_pesq id=opcao_pesq>
<?php
			$qTipoSituacao = "SELECT id, ds_tipo_situacao FROM tipo_situacao order by 2";
			e(processaSelect($qTipoSituacao, $opcao_pesq));	
?>			
		</select></label>
		<!--<button onclick="el('pesquisa_membro').submit();"><?=$ico_pesquisar?></button>-->
		<button type=submit><?=$ico_pesquisar?></button>
	</form>
<?php
	// if ($tipo_pesq == "P") {
		$qMembro = "select m.nr_ordem, m.nm_membro, m.nm_apelido, m.tipo_membro_id, m.tipo_hierarquia_id, m.tipo_situacao_id,
	 m.email, m.nascimento,
	 m.fone_residencial, m.fone_comercial, m.celular, m.celular2,
	 m.endereco, m.bairro, m.cep, m.cidade, m.uf,
	 m.cpf, m.rg, m.orgaorg,
	 m.Pai, m.Mae, m.vl_mensalidade, m.proxima_mensalidade, m.vl_prestacao, m.proxima_prestacao, m.dt_ingresso,
   t.ds_tipo_membro, h.ds_tipo_hierarquia, s.ds_tipo_situacao, m.id
from membro m, tipo_membro t, tipo_hierarquia h, tipo_situacao s
where m.tipo_membro_id = t.id
and m.tipo_situacao_id = s.id
and m.tipo_hierarquia_id = h.id
and m.tipo_situacao_id = $opcao_pesq
order by nm_apelido";
// e($qMembro);
?>
		<div class=linha>
			<div class='coluna-25'><b>Apelido</b></div>
			<div class='coluna-25'><b>Tipo</b></div>
			<div class='coluna-25'><b>Hierarquia</b></div>
			<div class='coluna-25' align=center><button onclick='incluir_membro()'><?=$ico_incluir?></button></div>
		</div>
<?php
		$b1 = new bd;
		$b1->prepara($qMembro);
		while($row = $b1->consulta()){
			$nr_ordem 						= $row[0];
			$nm_membro 						= u8($row[1]);
			$nm_apelido 					= u8($row[2]);
			$tipo_membro_id 			= $row[3];
			$tipo_hierarquia_id 	= $row[4];
			$tipo_situacao_id 		= $row[5];
			$email 								= $row[6];
			$nascimento 					= dformat($row[7]);
			$fone_residencial 		= $row[8];
			$fone_comercial 			= $row[9];
			$celular 							= $row[10];
			$celular2 						= $row[11];
			$endereco 						= u8($row[12]);
			$bairro 							= u8($row[13]);
			$cep 									= $row[14];
			$cidade 							= u8($row[15]);
			$uf 									= $row[16];
			$cpf 									= $row[17];
			$rg 									= $row[18];
			$orgaorg 							= $row[19];
			$pai 									= u8($row[20]);
			$mae 									= u8($row[21]);
			$vl_mensalidade 			= $row[22];
			$proxima_mensalidade 	= dformat($row[23]);
			$vl_prestacao 				= $row[24];
			$proxima_prestacao 		= $row[25];
			$dt_ingresso 					= dformat($row[26]);
			$ds_tipo_membro 			= u8($row[27]);
			$ds_tipo_hierarquia 	= u8($row[28]);
			$ds_tipo_situacao			= u8($row[29]);
			$id_membro						= $row[30];
			$opMembro = "A";
			e("<div class=linha>");
				e("<div class='coluna-25'>$nm_apelido</div>");
				e("<div class='coluna-25'>$ds_tipo_membro</div>");
				e("<div class='coluna-25'>$ds_tipo_hierarquia</div>");
				e("<div class='coluna-25' align=center>");
				e("  <button onclick=\"editar_membro($id_membro);\" >$ico_editar</button>");
				e("  <button onclick=\"excluir_membro($id_membro);\" >$ico_excluir</button>");
				e("</div>");
			e("</div>");
		}
		$b1->libera();
		// </div>
?>
<?php
	// }
	if ($opMembro == "") { $opMembro = "I"; }
?>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
	    <span class="close" onclick="fecharEdicao();"><?=$ico_fechar?></span>
			<span class="close" id=gravar onclick="gravar_membro()"><?=$ico_gravar?></span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaoMembro class=editor>
			<div class=tituloEdicao><?=$tab_nome?></div><br>
			<form name=frm_editar_membro id=frm_editar_membro method=post action=<?=$self?> >
				<input type=hidden name=tipo_pesq value="P">
				<input type=hidden name=opcao_pesq  value="<?=$opcao_pesq?>">
				<input type="hidden" name="opMembro" id="opMembro" value="<?=$opMembro?>">
				<input type="hidden" name="op_menu" id="op_menu" value="8">
				<input type="hidden" name="nr_ordem" id="nr_ordem">
				<input type="hidden" name="id_membro" id="id_membro" value="<?=$id_membro?>">
				<table width=100% cellspacing=0 border=0  class=padrao>
					<td>
						<label>Nome <input type="text" name="nm_membro" id="nm_membro" size=30></label>
					</td></tr><td>
						<label>Apelido <input type="text" name="nm_apelido" id="nm_apelido" size=20></label><br>
						<label>CPF <input type="text" name="cpf" id="cpf" inputmode="numeric" size=15></label>
					</td></tr><td>
						<label>RG <input type="text" name="rg" id="rg" size=10></label><br>
						<label>Órgão <input type="text" name="orgaorg" id="orgaorg" size=15></label>
					</td></tr><td>
						<label>Nasc. <input type="date" name="nascimento" id="nascimento" size=4></label><br>
						<label>Ingresso <input type="date" name="dt_ingresso" id="dt_ingresso" size=4></label>
					</td></tr><td>
						<label>E-mail <input type="text" name="email" id="email" size=25></label>
					</td></tr><td>
					<label>Situação<br><br>
							
			<?php
				$qTipoSituacao = "SELECT id, ds_tipo_situacao FROM tipo_situacao f order by 2";
				if ($tipo_situacao_id == "") { $tipo_situacao_id = 1; }
				e(processaRadio($qTipoSituacao, "tipo_situacao_id", $tipo_situacao_id));
			?>			
					</label>
					</td></tr><td>
					<label>Hierarquia
							<select name="tipo_hierarquia_id" id="tipo_hierarquia_id">
			<?php
				$qTipoHierarquia = "SELECT id, ds_tipo_hierarquia FROM tipo_hierarquia f order by 2";
				e(processaSelect($qTipoHierarquia, "tipo_hierarquia_id", $tipo_hierarquia_id));
			?>			
							</select>
					</label>
					</td></tr><td>
					<label>Tipo Membro
			<?php
				$qTipoMembro = "SELECT id, ds_tipo_membro FROM tipo_membro f order by 2";
				if ($tipo_membro_id == "") { $tipo_membro_id = 1; }
				e(processaRadio($qTipoMembro, "tipo_membro_id", $tipo_membro_id));
			?>			
					</label>
					</td></tr><td>
						<label>Celular <input type="text" name="celular" id="celular" inputmode="numeric" size=10> /
						<input type="text" name="celular2" id="celular2" inputmode="numeric" size=10 ></label>
					</td></tr><td>
						<label>Endereço  <input type="text" name="endereco" id="endereco" size=30></label>
					</td></tr><td>
						<label>Bairro  <input type="text" name="bairro" id="bairro" size=15></label><br>
						<label>CEP <input type="text" name="cep" id="cep" inputmode="numeric" size=10></label>
					</td></tr><td>
						<label>Cidade  <input type="text" name="cidade" id="cidade" size=20></label>
						<label>UF <input type="text" name="uf" id="uf" size=1></label>
					</td></tr><td>
						<label>Pai  <input type="text" name="pai" id="pai" size=30></label>
					</td></tr><td>
						<label>Mãe <input type="text" name="mae" id="mae" size=30></label>
					</td></tr><td>
						<center><label><b>Mensalidade</b></label></center><br>
						<label>Próxima <input type="month" name="proxima_mensalidade" id="proxima_mensalidade" size=5></label><br>
						<label>Valor <input type="text" name="vl_mensalidade" id="vl_mensalidade" inputmode="numeric"  onkeyup="formatarMoeda(this);" size=5></label>
					</td></tr><td>
						<center><label><b>Prestação Terracap</b></label></center><br>
						<label>Próxima <input type="month" name="proxima_prestacao" id="proxima_prestacao" size=5></label><br>
						<label>Valor <input type="text" name="vl_prestacao" id="vl_prestacao" inputmode="numeric"  onkeyup="formatarMoeda(this);" size=5></label>
					</td></tr>
				</table>
			</form>
		</div>
	</div>
</div>

