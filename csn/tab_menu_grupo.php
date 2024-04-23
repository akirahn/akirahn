<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Menu Grupo";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas 	= 3;
$tab_div_colunas 	= 44;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_menu_grupo = u8d($ds_menu_grupo);
}
$tab_tabela = "menu_grupo";
$tab_colunas 			= array("Id", "Descrição", "Ordem");
$tab_select 			= "select id, ds_menu_grupo, nr_ordem FROM $tab_tabela t order by 3";
$tab_insert 			= "insert into $tab_tabela (ds_menu_grupo, nr_ordem) values ('$ds_menu_grupo', '$nr_ordem')";
$tab_update 			= "update $tab_tabela set ds_menu_grupo = '$ds_menu_grupo', nr_ordem = '$nr_ordem' where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "NÚMERO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_menu_grupo, nr_ordem from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  						= $tabela[0];
		$ds_menu_grupo 	= u8($tabela[1]);
		$nr_ordem  			= $tabela[2];
		$opTab = "A";
	} else {
		$id				 			= "";
		$ds_menu_grupo 	= "";
		$nr_ordem 			= "";
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_menu_grupo" id="ds_menu_grupo" size=40 value="<?=$ds_menu_grupo?>" 	></label><br><br>
	<label>Ordem 		<input type=text name="nr_ordem" 		id="nr_ordem" 	 size=2  value="<?=$nr_ordem?>" inputmode="numeric">
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