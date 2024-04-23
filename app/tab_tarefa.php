<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tarefas";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 2;
$tab_div_colunas = 88;
$tab_tabela = "app_tarefas";
$tab_colunas 			= array("Id", "Descrição");
$tab_select 			= "select id_tarefa, ds_tarefa from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_tarefa) values ('".u8d($ds_tarefa)."')";
$tab_update 			= "update $tab_tabela set ds_tarefa = '".u8d($ds_tarefa)."' where id_tarefa = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id_tarefa = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTarefas = "select id_tarefa, ds_tarefa from $tab_tabela t where id_tarefa = $id_tab order by 2" ;
		$tarefa = pesquisa($qTarefas);
		$id_tarefa = $tarefa[0];
		$ds_tarefa = u8($tarefa[1]);
		$opTab = "A";
	} else {
		$id_tarefa = "";
		$ds_tarefa = "";
		$opTab = "I";
	}	
?>
	<label>Descrição<br><textarea type="text" name="ds_tarefa" id="ds_tarefa" style="width: 95%; height: 30%;"><?=$ds_tarefa?></textarea></label>
	<script>
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id_tarefa?>";
	</script>
<?php	
	die;
}
include_once("../include/frm_dados.php");
?>