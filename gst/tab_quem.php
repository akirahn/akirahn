<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tabela Quem";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 2;
$tab_div_colunas = 88;
$tab_tabela = "tab_quem";
$tab_colunas 			= array("Id", "Nome");
$tab_select 			= "select id, nm_pessoa from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (nm_pessoa) values ('".u8d($nm_pessoa)."')";
$tab_update 			= "update $tab_tabela set nm_pessoa = '".u8d($nm_pessoa)."' where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, nm_pessoa from $tab_tabela t where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id = $tabela[0];
		$nm_pessoa = u8($tabela[1]);
		$opTab = "A";
	} else {
		$id = "";
		$nm_pessoa = "";
		$opTab = "I";
	}	
?>
	<label>Descrição<br><input type="text" name="nm_pessoa" id="nm_pessoa" size=40 value="<?=$nm_pessoa?>" ></label>
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