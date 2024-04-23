<?php
include_once("include.php");

if (!isset($opTab)) { $opTab = "" ; }
if (!isset($botaoTab)) { $botaoTab = "" ; }

/*
$inputTab 				= "";
$editarTab				= "";
$alteraTab				= "";
$incluiTab				= "";
*/
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_tab(p_id_tab, p_ds_tab<?=$editarTab?>) {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoTab");
		el("opTab").value = "A";
		el("id_tab").value = p_id_tab;
		el("ds_tab").value = p_ds_tab;
		<?=$alteraTab?>
	}
//--------------------------------------------------------------------------------------------------
	function incluir_tab() {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoTab");
		el("opTab").value = "I";
		el("id_tab").value = "";
		el("ds_tab").value = "";
		<?=$incluiTab?>
	}
//--------------------------------------------------------------------------------------------------
	function excluir_tab(pIndice) {
		el("opTab").value = "E";
		el("id_tab").value = pIndice;
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
	// e($tab_update);
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
			<!-- 
			<span class="close" id=excluir onclick="excluir()">Excluir</span> 
			<span class="close" id=gravar onclick="gravar()">Gravar</span>
			-->
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
				<label>Descrição <input type="text" name="ds_tab" id="ds_tab" size=30 value="<?=$ds_tab?>"></label>
				<?=$inputTab?>
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
		switch($nome_pagina) {
			case "tab_fluxo_movimento": $botaoTab	= ",'".$row[2]."'"; break;
			case "tab_fluxo_tipo": $botaoTab	= ",".$row[2].",".$row[3].",'".$row[4]."'"; break;
			case "tab_meses": $botaoTab	= ",'".$row[2]."'"; break;
			case "tab_menu": $botaoTab	= ",".$row[2].",".$row[3].",'".$row[4]."'"; break;
			case "tab_menu_grupo": $botaoTab	= ",".$row[2]; break;
			//dt_ajuda, vl_ajuda, ds_forma_pagto, parcelas, nr_vencimento
			case "ajuda": $botaoTab	= ",'".$row[2]."','".$row[3]."','".u8($row[4])."',".$row[5].",".$row[6]; break;
		}

		e("<div class='coluna-$tab_div_colunas' align=right>
				<input type=button value='A' name=edT$c onclick=\"editar_tab(".$row[0].", '".u8($row[1])."'$botaoTab);\">
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