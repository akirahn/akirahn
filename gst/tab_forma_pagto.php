<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tabela Forma Pagto";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 3;
$tab_div_colunas = 33;
if ($opTab == "A" or $opTab == "I") {
	$ds_forma_pagto = u8d($ds_forma_pagto);
}
$tab_tabela = "gst_tab_forma_pagto";
$tab_colunas 			= array("Id", "Descrição");
$tab_select 			= "select id, ds_forma_pagto from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_forma_pagto) values ('$ds_forma_pagto')";
$tab_update 			= "update $tab_tabela set ds_forma_pagto = '$ds_forma_pagto' where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_forma_pagto from $tab_tabela t where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id = $tabela[0];
		$ds_forma_pagto = u8($tabela[1]);
		$opTab = "A";
	} else {
		$id = "";
		$ds_forma_pagto = "";
		$opTab = "I";
	}	
?>
	<label>Descrição<br><input type="text" name="ds_forma_pagto" id="ds_forma_pagto" size=40 value="<?=$ds_forma_pagto?>" ></label>
	<script>
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id?>";
	</script>
<?php	
	die;
}
include_once("../include/frm_dados.php");
?>