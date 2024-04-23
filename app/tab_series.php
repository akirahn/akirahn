<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Séries";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 4;
$tab_div_colunas = 29;
$tab_tabela = "app_series";
$tab_colunas 			= array("Id", "Séries", "Temporada", "Episódio");
$tab_select 			= "select id_series, ds_series, nr_temporada, nr_episodio from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (ds_series, nr_temporada, nr_episodio) values ('".u8d($ds_series)."', $nr_temporada, $nr_episodio)";
$tab_update 			= "update $tab_tabela set ds_series = '".u8d($ds_series)."', nr_temporada = $nr_temporada, nr_episodio = $nr_episodio where id_series = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id_series = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "NÚMERO", "NÚMERO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qseries = "select id_series, ds_series, nr_temporada, nr_episodio from $tab_tabela t where id_series = $id_tab order by 2" ;
		$serie = pesquisa($qseries);
		$id_series = $serie[0];
		$ds_series = u8($serie[1]);
		$nr_temporada = $serie[2];
		$nr_episodio = $serie[3];
		$opTab = "A";
	} else {
		$id_series = "";
		$ds_series = "";
		$nr_temporada = "";
		$nr_episodio = "";
		$opTab = "I";
	}	
?>
	<label>Série <input type=text name="ds_series" id="ds_series" size=30 value="<?=$ds_series?>" ></label><br><br>
	<label>Temporada <input type="text" name="nr_temporada" size=2 inputmode="numeric" id="nr_temporada" value="<?=$nr_temporada?>"></label>
	<label>Episódio <input type="text" name="nr_episodio" size=2 inputmode="numeric" id="nr_episodio" value="<?=$nr_episodio?>"></label>
	<script>
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id_series?>";
	</script>
<?php	
	die;
}
include_once("../include/frm_dados.php");
?>