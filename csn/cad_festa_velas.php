﻿<?php
$tituloPagina = "Velas Festa";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_festa_vela(p_id_festa) {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaofesta");
		el("opfesta").value = "A";
		el("id_festa").value = p_id_festa;
		var dados = $('#editar_festa').serialize();
		$.ajax({
				type : 'POST',
				dataType: 'TEXT',
				url  : "buscar_festa_vela.php",
				data: dados,
				success :  function(data){
					valores = data.split(";");
					selectPesquisaValor("fk_festa_anual", valores[1]);
					$('#dt_venda').val(valores[2]);
					$("#qt_vela").val(valores[3]);
					selectPesquisaValor("fk_membro", valores[4]);
					radioPesquisa("sn_doacao", valores[6]);
					// selectPesquisaValor("fk_fluxo", valores[5]);
				}
		});
	}
//--------------------------------------------------------------------------------------------------
	function incluir_festa_vela() {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaofesta");
		el("opfesta").value = "I";
		el("id_festa").value = "";
		el("fk_festa_anual").value = "";
		el("dt_venda").value = valorHoje();
		radioSemValor("sn_doacao");
		el("qt_vela").value = "";
		el("fk_membro").value = "";
		// el("fk_fluxo").value = "";
	}
//--------------------------------------------------------------------------------------------------
	function excluir_festa_vela(pIndice) {
		excluir_id(pIndice, 'festa_vela', 'frm_festa_vela');
	}
//--------------------------------------------------------------------------------------------------
	function gravar_festa_vela() {
		el("editar_festa").submit();
	}
//--------------------------------------------------------------------------------------------------
	function marcar_pagto(p_id, p_valor) {
		el("vl_vela"+p_id).value = p_valor;
		vlr = 0;
		v_id = "";
		vl = document.getElementsByName("vl_vela");
		vid = document.getElementsByName("id_vela");
		for(var i=0; i < vl.length; i++) {
			tmp = vl[i].value;
			tmp2 = vid[i].value+",";
			if (tmp != "") { 
				vlr += parseInt(tmp); 
				v_id += tmp2;
			}
		}
		el("bt_pagar").innerHTML = "Pagar ("+ vlr+ ")";
		el("pg_valor").value = vlr;
		el("pg_festa").value = v_id;
}
//--------------------------------------------------------------------------------------------------
	function pagar_festa_vela() {
		el("pg_dt_pagto").value = (el("p_dt_pagto").value == "") ? valorHoje() : el("p_dt_pagto").value;
		el("pagar_velas").submit();
	}
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $subtotal, $a, $p_membro, $p_festa, $ico_editar, $ico_excluir;
	for($i=0; $i < $a; $i++) {
		// e("<td align=center>".$linhas[$i][0]."</td>");
		$indice = $linhas[$i][0];
		if ($p_festa == "") {
			e("<td align=center>".u8($linhas[$i][1])."</td>");			
		}
		if ($p_membro == "") {
			e("<td align=center>".u8($linhas[$i][2])."</td>");			
		}
		// e("<td align=center>".$linhas[$i][3]."</td>");
		e("<td align=center>".$linhas[$i][4]."</td>");
		$doacao = $linhas[$i][7];
		e("<td align=center>".($doacao == 1 ? "X": "")."</td>");
		$pago = $linhas[$i][5];
		$vl_vela = $linhas[$i][6];
		if ($pago == "" and $doacao == 2) {
			if ($p_membro <> "") {				
				e("<td align=center>");
					e("<input onchange='marcar_pagto($indice, $vl_vela)' type=radio name=marcar$indice id=msim$indice value=$vl_vela><label for=msim$indice>".nformat($vl_vela)."</label>");
					e("<input onchange='marcar_pagto($indice, 0)' type=radio name=marcar$indice id=mnao$indice value=0><label for=mnao$indice>".nformat(0)."</label>");
				e("</td>");
			} else {
				e("<td align=center>".nformat($vl_vela)."</td>");
			}
		} else {
			e("<td align=center>".$linhas[$i][5]."</td>");			
		}
		e("<td class=acao><button class=btn onclick=\"editar_festa_vela(".$linhas[$i][0].");\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_festa_vela(".$linhas[$i][0].");\" align=center>$ico_excluir</button></td>");
		e("</tr>");
	}
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($opfesta == "A" and $id_festa <> "" ) {
	if ($fk_fluxo == "") { $fk_fluxo = "null"; }
	$qFesta = "update festa_vela 
							set fk_festa_anual = $fk_festa_anual, 
									dt_venda = '$dt_venda', 
									qt_vela = $qt_vela,
									fk_membro = $fk_membro,
									fk_fluxo = $fk_fluxo,
									sn_doacao = $sn_doacao
							where id = $id_festa";
	// e($qFesta);
	$resultado = executa_sql($qFesta, "Vela Festa ($id_festa) alterado com sucesso");
	resultado();
	$id_editar_festa = "";
}

if ($opfesta == "I" and $id_festa == "" ) {
	if ($fk_fluxo == "") { $fk_fluxo = "null"; }
	$qFesta = "
insert into festa_vela 
	(fk_festa_anual, dt_venda, qt_vela, fk_membro, fk_fluxo) values 
 	($fk_festa_anual, '$dt_venda', $qt_vela, $fk_membro, $fk_fluxo) 
";
 // e($qFesta);
	$resultado = executa_sql($qFesta, "Vela Festa incluído com sucesso");
	resultado();
	$id_editar_festa = "";
}

if ($opfesta == "P" and $pg_festa <> "" and $pg_membro <> "") {
	$pg_dt_comp = substr($pg_dt_pagto, 0, 8) . "01";
	$qFesta = "
insert into fluxo
	(dt_fluxo, fluxo_tipo_id, fluxo_movimento_id, vl_fluxo, membro_id, dt_competencia, obs) values 
 	('$pg_dt_pagto', 6, 1, replace(replace('$pg_valor', '.', ''), ',', '.'), $pg_membro, '$pg_dt_comp', 'Acerto velas') 
";
// e($qFesta);
	$resultado = executa_sql($qFesta, "Pagamento de Velas (Fluxo) feito com sucesso");
	resultado();
	$pg_festa = substr($pg_festa, 0, strlen($pg_festa)-1);
// e($pg_festa);
	$qFluxoPago = "select f.id_fluxo, m.nm_apelido	
		from fluxo f
		inner join membro m on m.id = f.membro_id
		where f.dt_fluxo = '$pg_dt_pagto' 
		and membro_id = $pg_membro 
		and fluxo_tipo_id = 6 
		and fluxo_movimento_id = 1 
		and vl_fluxo = replace(replace('$pg_valor', '.', ''), ',', '.') 
		and dt_competencia = '$pg_dt_comp' ";
// e($qFluxoPago);
	$fluxoPago = pesquisa($qFluxoPago);
	$qFestaVela = "update festa_vela set fk_fluxo = $fluxoPago[0] where id in ($pg_festa) ";
// e($qFestaVela);
	$resultado = executa_sql($qFestaVela, "Pagamento de Velas finalizado com sucesso");
	resultado();
	$qVelas = "SELECT  concat(t.ds_festas, '(', f.nr_ano, ') - (',v.qt_vela,') R$ ', format(round(f.vl_vela_medium) * v.qt_vela, 2, 'de_DE'), ';')
FROM festa_vela v
inner join festa_anual f on v.fk_festa_anual = f.id
inner join tab_festas t on f.fk_tab_festas = t.id
WHERE v.id in ($pg_festa)
order by f.nr_ano desc";
	$bv = new bd;
	$bv->prepara($qVelas);
	$velas_pagas = "";
	while($rv = $bv->consulta()){ $velas_pagas .= u8($rv[0]); }
	$bv->libera();
	e("<script>");
	e("vRecibo = preReciboVelas('$fluxoPago[1]', '".nformat($pg_valor)."', '" . dformat($pg_dt_pagto) . "', '$velas_pagas');");
	e("mensagemRecibo(vRecibo);");
	e("</script>");
	$pg_festa = "";
}

e("<form name=frm_festa_vela id=frm_festa_vela method=post action=$self >");
e("<input type=hidden name=op_menu value=6>");
e("<select name=p_festa>");
	e("<option value=>Festa</option>");
	$qFesta = "SELECT  f.id, concat(f.nr_ano, ' - ', t.ds_festas)
FROM festa_anual f
inner join tab_festas t on f.fk_tab_festas = t.id
order by f.nr_ano desc, t.fk_mes desc";
	e(processaSelect($qFesta, $p_festa));		
e("</select>");
e("<select name=p_membro>");
	e("<option value=>Membro</option>");
	$qMembro = "SELECT m.id, m.nm_apelido FROM membro m where m.tipo_situacao_id in (1, 3)
and exists
(select null
 from festa_vela v
 where v.fk_membro = m.id)
order by m.nm_apelido";
	e(processaSelect($qMembro, $p_membro));		
e("</select><br><br>");
e("<label> À pagar  </span>");
montaRadio($dom_sim_nao, "p_a_pagar", $p_a_pagar);
e("</label>");
e("<button class=btn type=submit>$ico_pesquisar</button>");
e("$spc$spc$spc");
e("</form>");
e("<button class=btn id=bt_pagar onclick='pagar_festa_vela()'>Pagar</button>");
if ($p_dt_pagto == "") { $p_dt_pagto = DATE("Y-m-d"); }
campo_data("p_dt_pagto");
// e("<input type=date name=p_dt_pagto id=p_dt_pagto value=valorHoje()>");
?>

<form name=excluir_festa id=excluir_festa method=post action=<?=$self?> >
	<input type="hidden" name="opfesta" id="opfestaEx" value="E">
	<input type="hidden" name="op_menu" value="6">
	<input type="hidden" name="id_excluir_festa" id="id_excluir_festa" value="<?=$id_excluir_festa?>">
	<input type="hidden" name="p_festa" id="p_festa_ex" value="<?=$p_festa?>">
</form>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
	    <span class="close" onclick="fecharEdicao();"><?=$ico_fechar?></span>
			<span class="close" id=gravar onclick="gravar_festa_vela()"><?=$ico_gravar?></span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaofesta class=editor>
			<div class=tituloEdicao>Vela Festa</div><br>
			<form name=editar_festa id=editar_festa method=post action=<?=$self?> >
				<input type="hidden" name="p_festa" id="p_festa_ed" value="<?=$p_festa?>">
				<input type="hidden" name="p_membro" id="p_membro_ed" value="<?=$p_festa?>">
				<input type="hidden" name="opfesta" id="opfesta" value="<?=$opfesta?>">
				<input type="hidden" name="op_menu" id="op_menu" value="6">
				<input type="hidden" name="id_festa" id="id_festa" value="<?=$id_festa?>">
				<select name=fk_festa_anual id=fk_festa_anual>
				<?php
					$qFesta = "SELECT  f.id, concat(f.nr_ano, ' - ', t.ds_festas)
FROM festa_anual f
inner join tab_festas t on f.fk_tab_festas = t.id
order by f.nr_ano desc, t.fk_mes desc";
					e("<option value=>Festa</option>");
					e(processaSelect($qFesta, $fk_festa_anual));
				?>			
				</select>
				<br><br>
				<label>Data <input type="date" name="dt_venda" id="dt_venda" size=5 value="<?=$dt_venda?>"></label><br><br>
				<select name=fk_membro id=fk_membro>
				<?php
					e("<option value=>Membro</option>");
					if ($opfesta == "I") {
						$qMembro = "SELECT m.id, m.nm_apelido FROM membro m where m.tipo_situacao_id in (1, 3)
order by m.nm_apelido";
					}
					e(processaSelect($qMembro, $fk_membro));
				?>			
				</select>
				<br><br>
				<label>Quantidade <input type="textt" name="qt_vela" id="qt_vela" size=2></label><br><br>
				<br><br>
				<div class=div_radio>
					<span>Doação</span>										 
					<input type=radio name=sn_doacao id=sn_doacao_1 value=1><label for=sn_doacao_1> Sim </label>
					<input type=radio name=sn_doacao id=sn_doacao_2 value=2><label for=sn_doacao_2> Não </label>
				</div>
			</form>
		</div>
	</div>
</div>


<?php
	$qFestaVela = "
SELECT 	v.id,
				concat(f.nr_ano, ' - ', t.ds_festas),
        m.nm_apelido,
				date_format(v.dt_venda, '%d/%m/%Y'),
				v.qt_vela,
				date_format(x.dt_fluxo, '%d/%m/%Y'),
				if(v.fk_fluxo is null, round(f.vl_vela_medium) * v.qt_vela, 0),
				v.sn_doacao
FROM festa_vela v
inner join festa_anual f on v.fk_festa_anual = f.id
inner join tab_festas t on f.fk_tab_festas = t.id
inner join membro m on v.fk_membro = m.id
left join fluxo x on v.fk_fluxo = x.id_fluxo
WHERE ('$p_festa' = '' or v.fk_festa_anual = '$p_festa')
and ('$p_membro' = '' or v.fk_membro = '$p_membro')
and ('$p_a_pagar' = '' or ('$p_a_pagar' = 'S' and (v.sn_doacao = 2 and v.fk_fluxo is null)) or ('$p_a_pagar' = 'N' and (v.fk_fluxo is not null or v.sn_doacao = 1)))
order by f.nr_ano desc, t.id desc, m.nm_apelido";
// e($qFestaVela);
		$b1 = new bd;
		$b1->prepara($qFestaVela);
		$inicio = "";
		$a = 0;
		$c = 0;
		$total = 0;
		$subtotal = 0;
		$total_vl = 0;
		$total_qt = 0;
		$total_qt_doacao = 0;
		$linhas = array();
		$input_pagar = "";
		e("<table width=100% class=padrao>");
		// e("<th align=center>ID</th>");
		if ($p_festa == "") {
			e("<th align=center>Festa</th>");
		}
		if ($p_membro == "") {
			e("<th align=center>Membro</th>");
		}
		// e("<th align=center>Venda</th>");
		e("<th align=center>QTD</th>");
		e("<th align=center>Doação</th>");
		e("<th align=center>A Pagar</th>");
		e("<th class=acao align=center><button onclick='incluir_festa_vela()'>$ico_incluir</button></th>");
		e("</tr>");
		while($row = $b1->consulta()){
			$linha = u8($row[0]);
			if ($inicio <> $linha) {
				if ($inicio <> "") { imprimir_array(); }
				$inicio = $linha;
				$a = 0;
				$subtotal = 0;
				$c++;
			}
			$linhas[$a] = $row;
			$total_qt += $row[4];
			if ($row[7] == 1) {
				$total_qt_doacao += $row[4];
			} else {
				$total_vl += $row[6];				
			}
			if ($p_membro <> "" and $p_festa == "") {
				$v_id = $linhas[$a][0];
				e("<input type='hidden' name=id_vela id=pg_vela$v_id value=$v_id>");
				e("<input type='hidden' name=vl_vela id=vl_vela$v_id>");
			}
			$a++;
		}
		if ($c > 0) {
			imprimir_array();
			if ($p_festa == "") {
				e("<th align=center>Total</th>");
			}
			if ($p_membro == "") {
				e("<th align=center>Total</th>");
			}
			// e("<th align=center></th>");
			e("<th align=center>$total_qt</th>");
			e("<th align=center>$total_qt_doacao</th>");
			if ($total_vl > 0)  {
				e("<th align=center>(".($total_qt - $total_qt_doacao). ") ".nformat($total_vl)."</th>");
			} else {
				e("<th align=center></th>");				
			}
			// e("<th class=acao align=center></th>");
			// e("<th class=acao align=center> </th>");
			e("</tr>");
		}
		$b1->libera();
		if ($c == 0) {
			e("<td colspan=5 align=center>Nenhum dado encontrado</td>");
			e("</table>");
		} else {
			e("</table>");
			if ($p_membro <> "" and $p_festa == "") {
				e("<form name=pagar_velas id=pagar_velas method=post action='$self'>");
					e("<input type=hidden name=opfesta id=opfesta value='P'>");
					e("<input type=hidden name=pg_festa id=pg_festa>");
					e("<input type=hidden name=pg_membro value=$p_membro>");
					e("<input type=hidden name=p_membro value=$p_membro>");
					e("<input type=hidden name=pg_valor id=pg_valor>");
					e("<input type=hidden name=pg_dt_pagto id=pg_dt_pagto>");
				e("</form>");
			}
		}
		
// desconectar();
?>
<script>
	if (el("p_dt_pagto").value == "") {
		el("p_dt_pagto").value = valorHoje();		
	}
</script>