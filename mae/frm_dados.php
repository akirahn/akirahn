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
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoTab");
		el("opTab").value = "Alterar";
		el("id_tab").value = p_id_tab;
		el("menu_off").value = 1;
		ajaxDivForm("", "frm_dados_div", "frm_editar_tab")
	}
//--------------------------------------------------------------------------------------------------
	function incluir_tab() {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoTab");
		el("opTab").value = "Incluir";
		el("id_tab").value = "";
		el("menu_off").value = 1;
		ajaxDivForm("", "frm_dados_div", "frm_editar_tab")
	}
//--------------------------------------------------------------------------------------------------
	function excluir_tab(pIndice) {
		el("opTab").value = "E";
		el("id_tab").value = pIndice;
		el("menu_off").value = 0;
		el("frm_editar_tab").submit();
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
	e("insert: $tab_insert");
	$resultado = executa_sql($tab_insert, "Dados $tab_nome incluído com sucesso");
	resultado();
	$id_tab = "";
}

if ($opTab == "A" and $id_tab <> "" ) {
	e($tab_update);
	$resultado = executa_sql($tab_update, "Dados $tab_nome ($id_tab) alterado com sucesso");
	resultado();
	$id_tab = "";
}

if ($opTab == "E" and $id_tab <> "" ) {
	$resultado = executa_sql($tab_delete, "Dados $tab_nome ($id_tab) excluido com sucesso");
	resultado();
	$id_tab = "";
}

?>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
	    <span class="close" onclick="fecharEdicao();">Fechar</span>
			<span class="close" id=gravar onclick="gravar_tab()">Gravar</span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaoTab class=editor>
			<div class=tituloEdicao><?=$tab_nome?></div><br>
			<form name=frm_editar_tab id=frm_editar_tab method=post>
				<input type="hidden" name="opTab" id="opTab" value="<?=$opTab?>">
				<input type="hidden" name="id_tab" id="id_tab" value="<?=$id_tab?>"><br>
				<input type="hidden" name="menu_off" id="menu_off" value="1"><br>
				<div id=frm_dados_div></div>
			</form>
		</div>
	</div>
</div>
<?php
	// e($tab_select);
	preparaSQL($tab_select);
		e("<div class=linha>");
		for($i=0; $i < $tab_qtd_colunas; $i++) {
			e("	<div class='coluna-$tab_div_colunas'><b>".$tab_colunas[$i]."</b></div>");
		}
		e("	<div class='coluna-$tab_div_colunas' align=right><input type=button value='+' onclick='incluir_tab()'></div>");
		e("</div>");		
		
		e("</tr>");
	$c = 0;
	while($row = consultaSQL()){
		e("<div class=linha>");
		for($i=0; $i < $tab_qtd_colunas; $i++) {
				e("	<div class='coluna-$tab_div_colunas'>".u8($row[$i])."</div>");
		}

		e("<div class='coluna-$tab_div_colunas' align=right>
				<input type=button value='A' name=edT$c onclick=\"editar_tab(".$row[0].");\">
				<input type=button value='E' name=exT$c onclick=\"excluir_tab(".$row[0].");\"></div>");
		e("</div>");		
		$c++;
	}
	liberaSQL();
	if ($c == 0) {
		msgModal("Nenhum dado encontrado!");
	}
desconectar();
?>