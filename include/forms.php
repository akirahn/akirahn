<?php
//===========================//
// FORMULÁRIOS
//===========================//

//-----------------------------------------
// function 
// gera campo de formulário
//-----------------------------------------

//-----------------------------------------
function campo_data($nome_campo, $valor_campo = "", $id_campo = "") {
// Monta input tipo Data html
//-----------------------------------------
	global $$nome_campo;
	$valor_campo = $$nome_campo;
	if ($id_campo == "") { $id_campo = $nome_campo; }
	botao_dia($id_campo, -1);
	e("<input type=date name='$nome_campo' id='$id_campo' value='$valor_campo'> ");
	botao_dia($id_campo, 1);
}
//-----------------------------------------
function campo_select_ano($nome_campo, $valor_campo = "", $id_campo = "") {
// Monta input tipo Numérico Ano html
//-----------------------------------------
	global $$nome_campo;
	$valor_campo = $$nome_campo;
	if ($id_campo == "") { $id_campo = $nome_campo; }
	$at = date("Y");
	$qAno = "select $at + 1, $at + 1
	union
	select $at, $at
	union
	select $at -1, $at -1
	union
	select $at -2, $at -2";
	e("<select name='$nome_campo' id='$id_campo'>");
	// e(" <option value=>Ano</option>");	
	e(processaSelect($qAno, $valor_campo));
	e("</select>");
}
//-----------------------------------------
function campo_select_mes($nome_campo, $valor_campo = "", $id_campo = "") {
// Monta input tipo Numérico Ano html
//-----------------------------------------
	global $$nome_campo;
	$valor_campo = $$nome_campo;
	if ($id_campo == "") { $id_campo = $nome_campo; }
	e("<select name='$nome_campo' id='$id_campo'>");
	// e("<option value=>Mês</option>");
	$qMes = "SELECT lpad(id, 2, 0), ds_mes FROM tab_meses order by 1";
	e(processaSelect($qMes, $valor_campo));
	e("</select>");
}

//-----------------------------------------
function campo_mes($nome_campo, $valor_campo = "", $id_campo = "") {
// Monta input tipo Radio html
//-----------------------------------------
	global $$nome_campo;
	$valor_campo = $$nome_campo;
	if ($id_campo == "") { $id_campo = $nome_campo; }
	botao_mes($id_campo, -1);
	e("<input type=month name='$nome_campo' id='$id_campo' value='$valor_campo'> ");
	botao_mes($id_campo, 1);
}

//-----------------------------------------
function campo_hidden($p_nome, $p_valor = "", $p_id = "") {
// Monta input tipo Radio html
//-----------------------------------------
	if ($p_id == "") { $p_id = $p_nome;	}
	e("<input type='hidden' name='$p_nome' id='$p_id' value='$p_valor'>");
}

//-----------------------------------------
function montaRadio($p_array, $p_nome, $p_checked = "", $p_br = "", $p_onchange = "") {
// Monta input tipo Radio html
//-----------------------------------------
	$v_onchange = ($p_onchange <> "" ? "onchange=\"$p_onchange\"" : "") ;
	$v_qtd = count($p_array);
	$c = 0;
	while($c < $v_qtd){
		$u0 = $p_array[$c];
		$c++;
		$u1 = $p_array[$c];
		$c++;
    e("<input type=radio name=$p_nome id=rd$p_nome$c ".($u0 == $p_checked ? "checked" : "")." $v_onchange value=$u0><label for=rd$p_nome$c>$u1</label>". ($p_br <> "" ? "<br><br>" : ""));
  }
}

//-----------------------------------------
function campo_checkbox($p_nome, $p_valor, $p_label, $p_checked = "", $p_id="") {
// Monta input tipo checkbox html
//-----------------------------------------
	if ($p_id == "") { $p_id = $p_nome;	}
	e("<input class=toggle-checkbox type='checkbox' id='$p_id' name='$p_nome' value='$p_valor' " . ($p_checked == $p_valor ? "checked" : "") . " >");
	e("<label class=toggle-switch for='$p_id'>| $p_label</label>");
	// e("<label class=toggle-switch for='$p_id'></label><label class=texto for='$p_id'>$p_label</label>");
}

//-----------------------------------------
function botao_mes_ano($p_indice) {
// Mostra botão de Anterior ou Posterior conforme p_indice para mudar mês/ano de parãmetro de pesquisa
//-----------------------------------------
	global $ico_anterior, $ico_posterior;
	e("<button class=btn onclick=\"muda_mes_ano($p_indice);\"> ". ($p_indice == -1 ? $ico_anterior : $ico_posterior) ." </button>");		
}

//-----------------------------------------
function botao_dia($p_campo, $p_indice) {
// Mostra botão de Anterior ou Posterior conforme p_indice para mudar mês/ano de parãmetro de pesquisa
//-----------------------------------------
	global $ico_anterior, $ico_posterior;
	e("<button class=btn type=button onclick=\"muda_dia('$p_campo', $p_indice);return false;\"> ". ($p_indice == -1 ? $ico_anterior : $ico_posterior) ." </button>");
}

//-----------------------------------------
function botao_mes($p_campo, $p_indice) {
// Mostra botão de Anterior ou Posterior conforme p_indice para mudar mês/ano de parãmetro de pesquisa
//-----------------------------------------
	global $ico_anterior, $ico_posterior;
	e("<button class=btn type=button onclick=\"muda_mes('$p_campo', $p_indice);return false;\"> ". ($p_indice == -1 ? $ico_anterior : $ico_posterior) ." </button>");
}

//-----------------------------------------
function monta_teclado_numerico($p_array_sequencia = "", $p_vl_teclado = "") {
// Monta teclado numérico 
//-----------------------------------------
	global $ico_excluir, $ico_anterior, $ico_posterior, $ico_entrar, $deviceType;
	//-----------------------------------------
	function celula_teclado_numerico($p_valor) {
	//-----------------------------------------
	global $ico_excluir;
		e("<td onclick=\"teclado_numerico_clique('$p_valor')\" >".($p_valor == "excluir" ? $ico_excluir : $p_valor)."</td>");
	}
	e("<table class=table_teclado width=".($deviceType == "phone" ? "100%" : "200px")." >");
?>
<input type=hidden id=campo_teclado_numerico name=campo_teclado_numerico>
<input type=hidden id=tipo_valor_teclado_numerico name=tipo_valor_teclado_numerico>
<input type=hidden id=indice_teclado_numerico name=indice_teclado_numerico>
		<tbody>
<?php 
	$vi = $p_array_sequencia[1];
	if ($vi == "TD" or $vi == "P") {
		e("<tr>");
		if ($vi == "TD") {
			$p_array_sequencia[1] = "D";			
			e("<td colspan=3 class=class_input style='text-align: right; ' id='$p_array_sequencia[0]'></td>");
		} else {
			e("<td colspan=3><input type=password name=acesso_ae style='max-width: 100%; font-size: 40px; border: none; ' id='$p_array_sequencia[0]' autocomplete=off readonly></td>");
		}
		
		e("</tr>");
	}
		e("<tr>");
			celula_teclado_numerico(1);
			celula_teclado_numerico(2);
			celula_teclado_numerico(3);
		e("</tr>");
		e("<tr>");
			celula_teclado_numerico(4);
			celula_teclado_numerico(5);
			celula_teclado_numerico(6);
		e("</tr>");
		e("<tr>");
			celula_teclado_numerico(7);
			celula_teclado_numerico(8);
			celula_teclado_numerico(9);
		e("</tr>");
	if ($p_array_sequencia <> "") {
		e("<tr>");
			celula_teclado_numerico('excluir');
			celula_teclado_numerico("0");
			if ($vi == "P") {
				e(" <td></td>");				
			e("</tr>");
			e("</tr>");
			e("<tr>");
				e(" <td colspan=3 onclick=\"$('#frm_login').submit();\">$ico_entrar Entrar</td>");
			} else {
				e(" <td></td>");				
			}
		e("</tr>");
		$qtd = count($p_array_sequencia);
		if ($qtd > 2) {
			e("<tr>");
			e("	<td onclick=\"teclado_numerico_muda_seq(-1);return false;\">$ico_anterior</td>");
			e(" <td></td>");
			e("	<td onclick=\"teclado_numerico_muda_seq(1);return false;\">$ico_posterior</td>");
			e("</tr>");
		// } else {
			// e("<tr>");
			// celula_teclado_numerico('excluir');
			// celula_teclado_numerico("0");
			// e(" <td></td>");
			// e("</tr>");
		}
	} else {
		e("<tr>");
			celula_teclado_numerico('excluir');
			celula_teclado_numerico("0");
			e(" <td colspan=3 onclick=\"$('#frm_login').submit();\">$ico_entrar Entrar</td>");
		e("</tr>");		
	}
	e("</tbody>");
	e("</table>");
	if ($p_array_sequencia <> "") {
		$campos = "";
		$tipos = "";
		for($i=0; $i < $qtd; $i++) {
			if (($i % 2) == 0) {
				$campos .= "'". $p_array_sequencia[$i] ."',";
			} else {
				$tipos .= "'". $p_array_sequencia[$i] ."',";
			}
		}
		$campos = substr($campos, 0, strlen($campos)-1);
		$tipos = substr($tipos, 0, strlen($tipos)-1);
?>		
		<script>
		var campos_teclado_numerico = Array(<?=$campos?>);
		var tipos_teclado_numerico = Array(<?=$tipos?>);
		$('#indice_teclado_numerico').val(0);
		teclado_numerico_muda_seq(0);		
		</script>
<?php		
	}
}	
//-----------------------------------------
function RadioGrupoFormaPagto($p_nome, $p_checked) {
//-----------------------------------------
//SELECT tp_pagto, id,ds_forma_pagto FROM gst_tab_pagto g order by 1, 3
	$qPG = "SELECT g.id, q.nm_pessoa, tp_pagto, p.ds_forma_pagto, concat(q.nm_pessoa, tp_pagto)
FROM gst_tab_pagto g
inner join gst_tab_forma_pagto p on g.fk_forma_pagto = p.id
inner join tab_quem q on q.id = g.fk_quem
order by 2, 3, 4";
	$c = -1;
	$b = new bd;
	$b->prepara($qPG);
	$separa = "";
	$pagto = array();
	while($r = $b->consulta()){		
		$u0 = u8($r[0]);
		$u1 = u8($r[1]);
		$tp_pagto = u8($r[2]);
		$u3 = u8($r[3]);
		$u4 = u8($r[4]);
		if ($separa <> $u4) {
			$c++;
			$pagto[$c][0] = ($tp_pagto == "C" ? "Crédito" : "Conta");
			$separa = $u4;
		}
		$pagto[$c][1][] = "<input type=radio name=$p_nome id=rd$p_nome$u0 ".($u0 == $p_checked ? "checked" : "")." value=$u0><label style='width: 95%;'  for=rd$p_nome$u0>$u3</label><br>";
	}
	$b->libera();

	e("<table class=formaPagto border=0 cellspacing=0>");
		e("<th colspan=2>Akira</th>");
		e("<th colspan=2>Estela</th>");
		e("</tr>");
		$qtdPagto = count($pagto);
		for($c = 0; $c < $qtdPagto; $c++) {
			e("<th align=center>" . $pagto[$c][0] . "</th>");
		}
		e("</tr>");
		for($c = 0; $c < $qtdPagto; $c++) {
			$forma = $pagto[$c][1];
			$qtdForma = count($forma);
			e("<td valign=top align=center>");
			for($f = 0; $f < $qtdForma; $f++) {
				e($forma[$f]);
			}
			e("</td>");
		}
		e("</tr>");
		e("<th colspan=4 align=center style='background-color: var(--branco);'></th>");
		e("</tr>");
		e("<th>Crédito</th>");
		e("<td align=center>");
		$u0 = 14;
		$u2 = "Nanquim";
		e("<input type=radio name=$p_nome id=rd$p_nome$u0 ".($u0 == $p_checked ? "checked" : "")." value=$u0><label for=rd$p_nome$u0>$u2</label>");
		$u0 = 9;
		e("</td>");
		e("<td colspan=2 align=center>");			
		$u2 = "Dinheiro";
		e("<input type=radio name=$p_nome id=rd$p_nome$u0 ".($u0 == $p_checked ? "checked" : "")." value=$u0><label for=rd$p_nome$u0>$u2</label>");
		e("</td>");
	e("</table>");
}

//-----------------------------------------
function campo_parcelas($p_nome, $p_checked = "") {
//-----------------------------------------
	$inicial = ($p_checked == "" ? 1 : $p_checked);
	e("<label>Parcelas </label><span id=span_parcela class='class_input class_span' onclick='abre_parcela()'>$inicial</span>");
	e("<center><div id=div_parcelas style='display: none;'>");
	for($p=1; $p < 25; $p++) {
		e("<input type=radio name='$p_nome' id='rd$p_nome$p' ".($p == $p_checked ? "checked" : "")." onclick=\"seleciona_parcela($p);\" value=$p><label class=cb style='width: 50px; text-align: center; ' for='rd$p_nome$p'>$p</label>");
	}
	e("</div></center>");
}
?>
