<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tipo Situação";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas 	= 2;
$tab_div_colunas 	= 88;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_tipo_situacao = u8d($ds_tipo_situacao);
}
$tab_tabela = "tipo_situacao";
$tab_colunas = array("Id", "Descrição");
$tab_select 			= "select id, ds_tipo_situacao from $tab_tabela order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_tipo_situacao) values ('$ds_tipo_situacao')";
$tab_update 			= "update $tab_tabela set ds_tipo_situacao = '$ds_tipo_situacao' where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_tipo_situacao from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  								= $tabela[0];
		$ds_tipo_situacao 	= u8($tabela[1]);
		$opTab = "A";
	} else {
		$id									= "";
		$ds_tipo_situacao 	= "";
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_tipo_situacao" id="ds_tipo_situacao" size=40 value="<?=$ds_tipo_situacao?>" ></label><br><br>
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