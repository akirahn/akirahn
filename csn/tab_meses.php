<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Meses";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas 	= 3;
$tab_div_colunas 	= 44;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_mes = u8d($ds_mes);
	$sg_mes = u8d($sg_mes);
}
$tab_tabela = "tab_meses";
$tab_colunas = array("Id", "Descrição", "Abreviado");
$tab_select = "select id, ds_mes, sg_mes from $tab_tabela t order by 1";
$tab_insert = "insert into $tab_tabela (ds_mes, sg_mes) values ('$ds_mes', '$sg_mes')";
$tab_update = "update $tab_tabela set ds_mes = '$ds_mes', sg_mes = '$sg_mes'  where id = $id_tab";
$tab_delete = "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_mes, sg_mes from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  			= $tabela[0];
		$ds_mes 	= u8($tabela[1]);
		$sg_mes  	= u8($tabela[2]);
		$opTab = "A";
	} else {
		$id				= "";
		$ds_mes 	= "";
		$sg_mes 	= "";
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_mes" id="ds_mes" size=40 value="<?=$ds_mes?>" ></label><br><br>
	<label>Abreviado 	<input type=text name="sg_mes" id="sg_mes" size=4  value="<?=$sg_mes?>" >
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