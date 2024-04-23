<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tabela Tag";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 2;
$tab_div_colunas = 88;
$tab_tabela = "gst_tab_tag";
$tab_colunas 			= array("Id", "Descrição");
$tab_select 			= "select id, ds_tag from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_tag) values ('".u8d($ds_tag)."')";
$tab_update 			= "update $tab_tabela set ds_tag = '".u8d($ds_tag)."' where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_tag from $tab_tabela t where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id = $tabela[0];
		$ds_tag = u8($tabela[1]);
		$opTab = "A";
	} else {
		$id = "";
		$ds_tag = "";
		$opTab = "I";
	}	
?>
	<label>Descrição<br><input type="text" name="ds_tag" id="ds_tag" size=40 value="<?=$ds_tag?>" ></label>
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