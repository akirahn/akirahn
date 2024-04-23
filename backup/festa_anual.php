<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_festa(p_id_festa, p_fk_tab_festas, p_nr_ano, p_dt_pagto, p_dt_festa) {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoFestaAnual");
		el("opFesta").value 				= "A";
		el("id_festa").value 			= p_id_festa;
		el("fk_tab_festas").value = p_fk_tab_festas;
		el("nr_ano").value 				= p_nr_ano;
		el("dt_pagto").value 			= p_dt_pagto;
		el("dt_festa").value 			= p_dt_festa;
	}
//--------------------------------------------------------------------------------------------------
	function incluir_festa() {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoFestaAnual");
		el("opFesta").value 				= "I";
		el("id_festa").value 			= "";
		el("fk_tab_festas").value = "";
		el("nr_ano").value 				= "";
		el("dt_pagto").value 			= "";
		el("dt_festa").value 			= "";
	}
//--------------------------------------------------------------------------------------------------
	function excluir_festa(pIndice) {
		el("opFesta").value 		= "E";
		el("id_festa").value 	= pIndice;
		el("frm_editar_festa").submit();
	}
//--------------------------------------------------------------------------------------------------
	function gravar_festa() {
		el("frm_editar_festa").submit();
	}
</script>

<?php
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

$tab_qtd_colunas = 5;
$tab_div_colunas = 16;
$tab_colunas = array("Id", "Festa", "Ano", "Pagamento", "Dia Festa");
$tab_nome = "Festa Anual";
$tab_select = "select id, fk_tab_festas, nr_ano, dt_pagto, dt_festa from festa_anual order by 2";
$tab_insert = "insert into festa_anual (fk_tab_festas, nr_ano, dt_pagto, dt_festa) values ($fk_tab_festas, $nr_ano, '$dt_pagto', '$dt_festa')";
$tab_update = "update festa_anual set fk_tab_festas = $fk_tab_festas, nr_ano = $nr_ano, dt_pagto = '$dt_pagto', dt_festa = '$dt_festa' where id = $id_festa";
$tab_delete = "delete from festa_anual where  id = $id_festa";

//nr_ano, dt_pagto, dt_festa

if ($opFesta == "I" and $id_festa == "" ) {
	$resultado = executa_sql($tab_insert, "Dados $tab_nome incluído com sucesso");
	resultado();
	$id_festa = "";
}

if ($opFesta == "A" and $id_festa <> "" ) {
	$resultado = executa_sql($tab_update, "Dados $tab_nome ($id_festa) alterado com sucesso");
	resultado();
	$id_festa = "";
}

if ($opFesta == "E" and $id_festa <> "" ) {
	$resultado = executa_sql($tab_delete, "Dados $tab_nome ($id_festa) excluido com sucesso");
	resultado();
	$id_festa = "";
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
			<span class="close" id=gravar onclick="gravar_festa()">Gravar</span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaoFestaAnual class=editor>
			<div class=tituloEdicao><?=$tab_nome?></div><br>
			<form name=frm_editar_festa id=frm_editar_festa method=post>
				<input type="hidden" name="op_menu" id="op_menu" value="<?=$op_menu?>">
				<input type="hidden" name="opFesta" id="opFesta" value="<?=$opFesta?>">
				<input type="hidden" name="id_festa" id="id_festa" value="<?=$id_festa?>"><br>
				<select name=fk_tab_festas id=fk_tab_festas>
<?php
	$qFesta = "SELECT id, ds_festas FROM tab_festas f order by 2";
	e(processaSelect($qFesta, "fk_tab_festas", $fk_tab_festas));
				
?>				
				</select>
				<br><br><label>Ano<input type="text" name="nr_ano" id="nr_ano" size=4 value="<?=$nr_ano?>"></label>
				<br><br><label>Data Máxima Pagamento<input type="date" name="dt_pagto" id="dt_pagto" value="<?=$dt_pagto?>"></label>
				<br><br><label>Data Festa<input type="date" name="dt_festa" id="dt_festa" value="<?=$dt_festa?>"></label>
			</form>
		</div>
	</div>
</div>


<?php
	preparaSQL($tab_select);
		e("<div class=linha>");
		for($i=0; $i < $tab_qtd_colunas; $i++) {
			e("	<div class='coluna-$tab_div_colunas'><b>".$tab_colunas[$i]."</b></div>");
		}
		e("	<div class='coluna-$tab_div_colunas' align=right><input type=button value='+' onclick='incluir_festa()'></div>");
		e("</div>");		
		
		e("</tr>");
	$c = 0;
	while($row = consultaSQL()){
		e("<div class=linha>");
		for($i=0; $i < $tab_qtd_colunas; $i++) {
				e("	<div class='coluna-$tab_div_colunas'>".u8($row[$i])."</div>");
		}
		e("<div class='coluna-$tab_div_colunas' align=right>
				<input type=button value='A' name=edT$c onclick=\"editar_festa(".$row[0].", ".$row[1].", ".$row[2].", '".$row[3]."', '".$row[4]."');\">
				<input type=button value='E' name=exT$c onclick=\"excluir_festa(".$row[0].");\"></div>");
		e("</div>");		
		$c++;
	}
	liberaSQL();
	if ($c == 0) {
		msgModal("Nenhum dado encontrado!");
	}
desconectar();
?>