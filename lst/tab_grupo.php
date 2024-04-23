<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 		= "Tabela Grupo";
$tituloPagina = "$tab_nome";
include_once("include.php");
if ($opTab == "I" or $opTab == "A") {
	$ds_grupo = prepara_coluna(u8d($ds_grupo), 1);
}
$tab_qtd_colunas = 2;
$tab_div_colunas = 88;
$tab_tabela = "lst_tab_grupo";
$tab_colunas 			= array("Id", "Descrição");
$tab_select 			= "select id, ". prepara_coluna("ds_grupo") . " from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_grupo) values ($ds_grupo)";
$tab_update 			= "update $tab_tabela set ds_grupo = $ds_grupo where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ". prepara_coluna("ds_grupo") . " from $tab_tabela t where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id = $tabela[0];
		$ds_grupo = u8($tabela[1]);
		$opTab = "A";
	} else {
		$id = "";
		$ds_grupo = "";
		$opTab = "I";
	}	
?>
	<label>Descrição<br><input type="text" name="ds_grupo" id="ds_grupo" size=40 value="<?=$ds_grupo?>" ></label>
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