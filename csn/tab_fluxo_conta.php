<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Fluxo Conta";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas 	= 2;
$tab_div_colunas 	= 88;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_conta = u8d($ds_conta);
}
$tab_tabela = "fluxo_conta";
$tab_colunas = array("Id", "Descrição");
$tab_select 			= "select id, ds_conta from $tab_tabela order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_conta) values ('$ds_conta')";
$tab_update 			= "update $tab_tabela set ds_conta = '$ds_conta' where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_conta from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  								= $tabela[0];
		$ds_conta 	= u8($tabela[1]);
		$opTab = "A";
	} else {
		$id									= "";
		$ds_conta 	= "";
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_conta" id="ds_conta" size=40 value="<?=$ds_conta?>" ></label><br><br>
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