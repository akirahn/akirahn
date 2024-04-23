<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tipo Hierarquia";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas 	= 2;
$tab_div_colunas 	= 88;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_tipo_hierarquia = u8d($ds_tipo_hierarquia);
}
$tab_tabela = "tipo_hierarquia";
$tab_colunas = array("Id", "Descrição");
$tab_select = "select id, ds_tipo_hierarquia from $tab_tabela t order by 2";
$tab_insert = "insert into $tab_tabela (ds_tipo_hierarquia) values ('$ds_tipo_hierarquia')";
$tab_update = "update $tab_tabela set ds_tipo_hierarquia = '$ds_tipo_hierarquia' where id = $id_tab";
$tab_delete = "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_tipo_hierarquia from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  			= $tabela[0];
		$ds_tipo_hierarquia 	= u8($tabela[1]);
		$opTab = "A";
	} else {
		$id				= "";
		$ds_tipo_hierarquia 	= "";
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_tipo_hierarquia" id="ds_tipo_hierarquia" size=40 value="<?=$ds_tipo_hierarquia?>" ></label><br><br>
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