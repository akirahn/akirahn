<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Remédio";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas 	= 3;
$tab_div_colunas 	= 44;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_remedio = u8d($ds_remedio);
}
$tab_tabela = "app_cab_remedio";
$tab_colunas = array("Id", "Descrição", "QTD Uso");
$tab_select = "select id, ds_remedio, qtd_uso from $tab_tabela t order by 2";
$tab_insert = "insert into $tab_tabela (ds_remedio, qtd_uso) values ('$ds_remedio', $qtd_uso)";
$tab_update = "update $tab_tabela set ds_remedio = '$ds_remedio', qtd_uso = $qtd_uso where id = $id_tab";
$tab_delete = "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "NÚMERO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_remedio, qtd_uso from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  					= $tabela[0];
		$ds_remedio 	= u8($tabela[1]);
		$qtd_uso 			= $tabela[2];
		$opTab = "A";
	} else {
		$id						= "";
		$ds_remedio 	= "";
		$qtd_uso			= 0;
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_remedio" id="ds_remedio" size=40 value="<?=$ds_remedio?>" ></label><br><br>
	<label>Quantidade Uso <input type=text name="qtd_uso" id="qtd_uso" size=6 value="<?=$qtd_uso?>" inputmode="numeric" ></label><br><br>
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