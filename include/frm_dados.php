<?php
include_once("include.php");

if (!isset($opTab)) { $opTab = "" ; }

?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_tab(p_id_tab) {
		mostra("telaEdicao");
		// escondeElementoClasse("div", "editor");
		mostra("telaEdicaoTab");
		el("opTab").value = "Alterar";
		el("id_tab").value = p_id_tab;
		el("menu_off").value = 1;
		ajaxDivForm("", "frm_dados_div", "frm_editar_tab")
	}
//--------------------------------------------------------------------------------------------------
	function incluir_tab() {
		mostra("telaEdicao");
		// escondeElementoClasse("div", "editor");
		mostra("telaEdicaoTab");
		el("opTab").value = "Incluir";
		el("id_tab").value = "";
		el("menu_off").value = 1;
		ajaxDivForm("", "frm_dados_div", "frm_editar_tab")
	}
//--------------------------------------------------------------------------------------------------
	function excluir_tab(pIndice) {
		excluir_id(pIndice, "<?=$tab_tabela?>", "<?=$tab_form?>");
	}
//--------------------------------------------------------------------------------------------------
	function gravar_tab() {
		el("frm_editar_tab").submit();
	}
</script>

<?php
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------
if ($opTab == "I" and $id_tab == "" ) {
	if (is_array($tab_insert) == 1) {
		$tam_insert = count($tab_insert);
		$resultado = "";
		for($i=0; $i < $tam_insert; $i++) {
			// e($tab_insert[$i]);
			$erro_sql = 0;
			$resultado .= executa_sql($tab_insert[$i], "X");
			if ($erro_sql <> 0) {
				break;
			}
		}
		if ($erro_sql == 0) {
			$resultado = "Dados2 $tab_nome incluído com sucesso";
		}
		resultado();
	} else {
		// e("insert: $tab_insert");
		$resultado = executa_sql($tab_insert, "Dados $tab_nome incluído com sucesso");
		resultado();
	}
	$id_tab = "";
}

if ($opTab == "A" and $id_tab <> "" ) {
	// e($tab_update);
	$resultado = executa_sql($tab_update, "Dados $tab_nome ($id_tab) alterado com sucesso");
	resultado();
	$id_tab = "";
}
/*
if ($opTab == "E" and $id_tab <> "" ) {
	$resultado = executa_sql($tab_delete, "Dados $tab_nome ($id_tab) excluido com sucesso");
	resultado();
	$id_tab = "";
}
*/
?>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
			<span class=tituloEdicao><?=$tab_nome?></span>
	    <span class="fechar" onclick="fecharEdicao();"><?=$ico_fechar?></span>
			<span class="gravar" id=gravar onclick="gravar_tab()"><?=$ico_gravar?></span>
    </center>
		<div id=telaEdicaoTab class=editor>
			<form name=frm_editar_tab id=frm_editar_tab method=post>
				<input type="hidden" name="opTab" id="opTab" value="<?=$opTab?>">
				<input type="hidden" name="id_tab" id="id_tab" value="<?=$id_tab?>"><br>
				<input type="hidden" name="menu_off" id="menu_off" value="1"><br>
				<input type="hidden" name="tp_tab" id="tp_tab" value="2"><br>
				<div id=frm_dados_div></div>
				<br>
				<button type=button class="botao botao_gravar" onclick="gravar_tab()"> <?=$ico_gravar?> Gravar </button>
			</form>
		</div>
	</div>
</div>

<?php
	if ($tab_form == "") {
		e("
<form name=frm_dados_pesquisa id=frm_dados_pesquisa method=post>
<input type=hidden name=opTab value='P'>
<button>$ico_pesquisar</button>
</form>
		");
	}
//e($tab_select);
	preparaSQL($tab_select);
		e("<div class=linha>");
		for($i=1; $i < $tab_qtd_colunas; $i++) {
			e("	<div class='coluna-$tab_div_colunas'><b>".$tab_colunas[$i]."</b></div>");
		}
		e("	<div class='coluna-12' align=right><button class=btn onclick='incluir_tab()'>$ico_incluir</button></div>");
		e("</div>");		
		
	$c = 0;
	if ($tab_tipo_dados == "") { $tab_tipo_dados = array(); }
	while($row = consultaSQL()){
		$bgcor = ($c % 2 == 0) ? "tr_odd" : "";
		e("<div class='linha $bgcor'>");
		for($i=1; $i < $tab_qtd_colunas; $i++) {
			$classe = "";
			switch($tab_tipo_dados[$i]) {
				case "TEXTO":
					$campo_tab = u8($row[$i]);
					break;
				case "NÚMERO":
					$campo_tab = nformat($row[$i], 0);
					break;
				case "DATA":
					$campo_tab = $row[$i];
					break;
				case "VALOR":
					$classe = ($row[$i] < 0 ? "negativo" : "");
					$valor = ($row[$i] < 0 ? -1 : 1) * $row[$i];					
					$campo_tab = nformat($valor);
					break;
				default:
					$campo_tab = u8($row[$i]);
					break;
			}
			e("	<div class='coluna-$tab_div_colunas $classe'>$campo_tab</div>");
		}

		e("<div class='coluna-12' align=right>");
		e("<button name=edT$c class=btn onclick=\"editar_tab(".$row[0].");\">$ico_editar</button>");
		e("<button name=exT$c class=btn onclick=\"excluir_tab(".$row[0].");\">$ico_excluir</button>");
		e("</div>");
		e("</div>");
		$c++;
	}
	liberaSQL();
	if ($c == 0) {
		msgModal("Nenhum dado encontrado!");
	}
// desconectar();
?>
