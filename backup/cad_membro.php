<?php
	if ($dt_fluxo <> "" and $vl_fluxo <> "" and $fluxo_movimento_id <> "" and $fluxo_tipo_id <> "") {
		$vl_mensalidade = replace(replace($vl_mensalidade, ".", ""), ",", ".");
		$vl_prestacao 	= replace(replace($vl_prestacao, ".", ""), ",", ".");
		if ($opMembro == "I") {
			$qMembro = "insert into membro 
	(nr_ordem, nm_membro, nm_apelido, tipo_membro_id, tipo_hierarquia_id, tipo_situacao_id, 
	 email, nascimento, 
	 fone_residencial, fone_comercial, celular, celular2, 
	 endereco, bairro, cep, cidade, uf, 
	 cpf, rg, orgaorg, 
	 Pai, Mae, vl_mensalidade, proxima_mensalidade, vl_prestacao, proxima_prestacao, dt_ingresso) values 
 	($nr_ordem, '$nm_membro', '$nm_apelido', $tipo_membro_id, '$tipo_hierarquia_id', '$tipo_situacao_id', 
	 '$email', '$nascimento',	 $fone_residencial, $fone_comercial, $celular, $celular2, 
	 '$endereco', '$bairro', '$cep', '$cidade', '$uf', 
	 '$cpf', '$rg', '$orgaorg', 
	 '$Pai', '$Mae', $vl_mensalidade, '$proxima_mensalidade', $vl_prestacao, '$proxima_prestacao', '$dt_ingresso') ";
		} else {
			$qMembro = "update membro 
	set nr_ordem = $nr_ordem, 
			nm_membro = '$nm_membro', 
			nm_apelido = '$nm_apelido', 
			tipo_membro_id = '$tipo_membro_id', 
			tipo_hierarquia_id = '$tipo_hierarquia_id', 
			tipo_situacao_id = '$tipo_situacao_id', 
			email = '$email', 
			nascimento = '$nascimento',
			fone_residencial = $fone_residencial, 
			fone_comercial = $fone_comercial, 
			celular = $celular, 
			celular2 = $celular2,
			endereco = '$endereco', 
			bairro = '$bairro', 
			cep = $cep, 
			cidade = '$cidade', 
			uf = '$uf',
			cpf = '$cpf', 
			rg = '$rg', 
			orgaorg = '$orgaorg', 	 
			Pai = '$Pai', 
			Mae = '$Mae', 
			vl_mensalidade = $vl_mensalidade, 
			proxima_mensalidade = '$proxima_mensalidade', 
			vl_prestacao = $vl_prestacao, 
			proxima_prestacao = '$proxima_prestacao', 
			dt_ingresso = '$dt_ingresso'
  where id = $id_membro ";
		echo $qMembro;
		}
		$resultado = executa_sql($qMembro, "Membro ".($opMembro == "I" ? "incluído" : "alterado")." com sucesso");
		msgModal($resultado);
	}
?>
	<form name=pesquisa_membro id=pesquisa_membro method=post action=>
		<input type="hidden" name="op_menu" id="op_menu" value="8">
		<input type=hidden name=tipo_pesq id=tipo_pesq value="P">
		Situação
		<select name=opcao_pesq id=opcao_pesq>
<?php
			$qTipoSituacao = "SELECT id, ds_tipo_situacao FROM tipo_situacao order by 2";
			e(processaSelect($qTipoSituacao, "opcao_pesq", $opcao_pesq));	
?>			
		</select>
		<input type=submit value="Pesquisar">
		<!-- 
		<input type=button value="+" onclick="Incluir_membro();"> 
		-->
	</form>
<?php
	if ($tipo_pesq == "P") {
		$qMembro = "select m.nr_ordem, m.nm_membro, m.nm_apelido, m.tipo_membro_id, m.tipo_hierarquia_id, m.tipo_situacao_id,
	 m.email, m.nascimento,
	 m.fone_residencial, m.fone_comercial, m.celular, m.celular2,
	 m.endereco, m.bairro, m.cep, m.cidade, m.uf,
	 m.cpf, m.rg, m.orgaorg,
	 m.Pai, m.Mae, m.vl_mensalidade, m.proxima_mensalidade, m.vl_prestacao, m.proxima_prestacao, m.dt_ingresso,
   t.ds_tipo_membro, h.ds_tipo_hierarquia, s.ds_tipo_situacao
from membro m, tipo_membro t, tipo_hierarquia h, tipo_situacao s
where m.tipo_membro_id = t.id
and m.tipo_situacao_id = s.id
and m.tipo_hierarquia_id = h.id
and m.tipo_situacao_id = $opcao_pesq";
?>
	<table width=100% class=padrao>
		<th>Apelido</th>
		<th>Tipo</th>
		<th>Hierarquia</th>
		<th>Situação</th>
		<th></th>
		</tr>
<?php
/*
		<th>Próxima Mensalidade</th>
		<th>Valor Mensalidade</th>
		<th>Próxima Prestação</th>
		<th>valor Prestação</th>
*/
		preparaSQL($qMembro);
		while($row = consultaSQL()){
			$nr_ordem 						= $row[00];
			$nm_membro 						= u8($row[01]);
			$nm_apelido 					= u8($row[02]);
			$tipo_membro_id 			= $row[03];
			$tipo_hierarquia_id 	= $row[04];
			$tipo_situacao_id 		= $row[05];
			$email 								= u8($row[6]);
			$nascimento 					= dformat($row[7]);
			$fone_residencial 		= $row[8];
			$fone_comercial 			= $row[9];
			$celular 							= $row[10];
			$celular2 						= $row[11];
			$endereco 						= u8($row[12]);
			$bairro 							= u8($row[13]);
			$cep 									= u8($row[14]);
			$cidade 							= u8($row[15]);
			$uf 									= $row[16];
			$cpf 									= $row[17];
			$rg 									= $row[17];
			$orgaorg 							= $row[19];
			$Pai 									= u8($row[20]);
			$Mae 									= u8($row[21]);
			$vl_mensalidade 			= $row[22];
			$proxima_mensalidade 	= dformat($row[23]);
			$vl_prestacao 				= $row[24];
			$proxima_prestacao 		= $row[25];
			$dt_ingresso 					= dformat($row[26]);
			$ds_tipo_membro 			= u8($row[27]);
			$ds_tipo_hierarquia 	= u8($row[28]);
			$ds_tipo_situacao			= u8($row[29]);
			$opMembro = "A";
			e("<td>$nm_apelido</td>");
			e("<td align=center>$ds_tipo_membro</td>");
			e("<td align=center>$ds_tipo_hierarquia</td>");
			e("<td align=center>$ds_tipo_situacao</td>");
/*			
			e("<td align=center>".dformat($proxima_mensalidade)."</td>");
			e("<td align=center>$vl_mensalidade</td>");
			e("<td align=center>".dformat($proxima_prestacao)."</td>");
			e("<td align=center>$vl_prestacao</td>");
*/			
/*			
			e("<td align=center>");
			e("  <input type=button value=A onclick=\"editar_membro($id_membro,$nr_ordem 						,
'$nm_membro' 						,
'$nm_apelido' 					,
$tipo_membro_id 			,
$tipo_hierarquia_id 	,
$tipo_situacao_id 		,
'$email' 								,
'$nascimento' 					,
$fone_residencial 		,
$fone_comercial 			,
$celular 							, 
$celular2 						, 
'$endereco' 						, 
'$bairro' 							, 
$cep 									, 
'$cidade'								, 
'$uf' 								, 
$cpf 									, 
'$rg' 									, 
'$orgaorg' 							, 
'$Pai' 									, 
'$Mae' 									, 
$vl_mensalidade 			, 
'$proxima_mensalidade' 	, 
$vl_prestacao 				, 
'$proxima_prestacao' 		, 
'$dt_ingresso' 					);\" >");
			e("  <input type=button value=E onclick=\"excluir_membro($id_membro);\" >");
			e("</td>");
*/			
			e("</tr>");
		}
?>
	</table>
<?php
	}
	if ($opMembro == "") { $opMembro = "I"; }
?>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
	    <span class="close" onclick="fecharEdicao();">Fechar</span>
			<!-- 
			<span class="close" id=excluir onclick="excluir()">Excluir</span> 
			<span class="close" id=gravar onclick="gravar()">Gravar</span>
			-->
			<span class="close" id=gravar onclick="gravar_festa()">Gravar</span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaoFestaAnual class=editor>
			<div class=tituloEdicao><?=$tab_nome?></div><br>
			<form name=editar_membro id=editar_membro method=post>
				<input type="hidden" name="opMembro" id="opMembro" value="<?=$opMembro?>">
				<input type="hidden" name="op_menu" id="op_menu" value="8">
				<input type="hidden" name="id_membro" id="id_membro" value="<?=$id_membro?>">
				<table width=100% cellspacing=0 border=0  class=padrao>
					<td>
						<label>Nome <input type="text" name="nm_membro" size=30 value="<?=$nm_membro?>"></label>
					</td></tr><td>
						<label>Apelido <input type="text" name="nm_apelido" size=10 value="<?=$nm_apelido?>"></label>
						<label>CPF <input type="text" name="cpf" inputmode="numeric" size=15  value="<?=$cpf?>"></label>
					</td></tr><td>
						<label>RG <input type="text" name="rg" size=10 value="<?=$rg?>"></label>
						<label>Órgão <input type="text" name="orgaorg" size=15 value="<?=$orgaorg?>"></label>
					</td></tr><td>
						<label>Nasc. <input type="date" name="nascimento" size=4 value="<?=$nascimento?>"></label>
						<label>Ingresso <input type="date" name="dt_ingresso" size=4 value="<?=$dt_ingresso?>"></label>
					</td></tr><td>
						<label>E-mail <input type="text" name="email" size=25 value="<?=$email?>"></label>
					</td></tr><td>
						<div class=div_radio>
							<span>Situação</span>
							
			<?php
				$qTipoSituacao = "SELECT id, ds_tipo_situacao FROM tipo_situacao f order by 2";
				if ($tipo_situacao_id == "") { $tipo_situacao_id = 1; }
				e(processaRadio($qTipoSituacao, "tipo_situacao_id", $tipo_situacao_id));
			?>			
						</div>
					</td></tr><td>
						<div class=div_radio>
							<span>Hierarquia</span>
							<select name="tipo_hierarquia_id">
			<?php
				$qTipoHierarquia = "SELECT id, ds_tipo_hierarquia FROM tipo_hierarquia f order by 2";
				if ($tipo_hierarquia_id == "") { $tipo_hierarquia_id = 1; }
				e(processaSelect($qTipoHierarquia, "tipo_hierarquia_id", $tipo_hierarquia_id));
			?>			
							</select>
						</div>
					</td></tr><td>
						<div class=div_radio>
							<span>Tipo Membro</span>				
			<?php
				$qTipoMembro = "SELECT id, ds_tipo_membro FROM tipo_membro f order by 2";
				if ($tipo_membro_id == "") { $tipo_membro_id = 1; }
				e(processaRadio($qTipoMembro, "tipo_membro_id", $tipo_membro_id));
			?>			
						</div>
					</td></tr><td>
						<label>Celular <input type="text" name="celular" inputmode="numeric" size=10 value="<?=$celular?>"></label>
						<label>Celular2 <input type="text" name="celular2" inputmode="numeric" size=10 value="<?=$celular2?>"></label>
					</td></tr><td>
						<label>Endereço  <input type="text" name="endereco" size=30  value="<?=$endereco?>"></label>
					</td></tr><td>
						<label>Bairro  <input type="text" name="bairro" size=15  value="<?=$bairro?>"></label>
						<label>CEP <input type="text" name="cep" inputmode="numeric" size=10 value="<?=$cep?>"></label>
					</td></tr><td>
						<label>Cidade  <input type="text" name="cidade" size=25  value="<?=$cidade?>"></label>
						<label>UF <input type="text" name="uf" size=2 value="<?=$uf?>"></label>
					</td></tr><td>
						<label>Pai  <input type="text" name="pai" size=30  value="<?=$pai?>"></label>
					</td></tr><td>
						<label>Mãe <input type="text" name="mae" size=30 value="<?=$mae?>"></label>
					</td></tr><td>
						<center><label><b>Mensalidade</b></label></center><br>
						<label>Próxima <input type="date" name="proxima_mensalidade" size=5 value="<?=$proxima_mensalidade?>"></label>
						<label>Valor <input type="text" name="vl_mensalidade" inputmode="numeric"  onkeyup="formatarMoeda(this);" size=10 value="<?=$vl_mensalidade?>"></label>
					</td></tr><td>
						<center><label><b>Prestação Terracap</b></label></center><br>
						<label>Próxima <input type="date" name="proxima_prestacao" size=5 value="<?=$proxima_prestacao?>"></label>
						<label>Valor <input type="text" name="vl_prestacao" inputmode="numeric"  onkeyup="formatarMoeda(this);" size=10 value="<?=$vl_prestacao?>"></label>
					</td></tr>
				</table>
			</form>
		</div>
	</div>
</div>

