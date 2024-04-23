<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome = "Fluxo Movimento";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas = 3;
$tab_div_colunas = 44;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_fluxo_movimento = u8d($ds_fluxo_movimento);
	$simbolo = u8d($simbolo);
}
$tab_tabela = "fluxo_movimento";
$tab_colunas = array("Id", "Descrição", "Símbolo");
$tab_select = "select id, ds_fluxo_movimento, simbolo from $tab_tabela order by 2";
$tab_insert = "insert into $tab_tabela (ds_fluxo_movimento, simbolo) values ('$ds_fluxo_movimento', '$simbolo')";
$tab_update = "update $tab_tabela set ds_fluxo_movimento = '$ds_fluxo_movimento', simbolo = '$simbolo' where id = $id_tab";
$tab_delete = "delete from $tab_tabela where id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_fluxo_movimento, simbolo from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  									= $tabela[0];
		$ds_fluxo_movimento 	= u8($tabela[1]);
		$simbolo  						= $tabela[2];
		$opTab = "A";
	} else {
		$id				 						= "";
		$ds_fluxo_movimento 	= "";
		$simbolo 							= "";
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_fluxo_movimento" id="ds_fluxo_movimento" size=40 value="<?=$ds_fluxo_movimento?>" 	></label><br><br>
	<label>Símbolo 		<input type=text name="simbolo" 		id="simbolo" 	 size=2  value="<?=$simbolo?>">
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