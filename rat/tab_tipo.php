<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tabela Tipo";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 2;
$tab_div_colunas = 88;
$tab_tabela = "rat_tab_tipo";
$tab_colunas 			= array("Id", "Descrição");
$tab_select 			= "select id, ds_tipo_rateio from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_tipo_rateio) values ('".u8d($ds_tipo_rateio)."')";
$tab_update 			= "update $tab_tabela set ds_tipo_rateio = '".u8d($ds_tipo_rateio)."' where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_tipo_rateio from $tab_tabela t where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id = $tabela[0];
		$ds_tipo_rateio = u8($tabela[1]);
		$opTab = "A";
	} else {
		$id = "";
		$ds_tipo_rateio = "";
		$opTab = "I";
	}	
?>
	<label>Descrição<br><input type="text" name="ds_tipo_rateio" id="ds_tipo_rateio" size=40 value="<?=$ds_tipo_rateio?>" ></label>
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