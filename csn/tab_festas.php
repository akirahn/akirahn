<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 		= "Festas";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas = 4;
$tab_div_colunas = 29;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_festas = u8d($ds_festas);
}
$tab_tabela = "tab_festas";
$tab_colunas 			= array("Id", "Descrição", "Dia", "Mês");
$tab_select = "select f.id, f.ds_festas, f.nr_dia, m.ds_mes
from $tab_tabela f
inner join tab_meses m on m.id = f.fk_mes
order by f.fk_mes";
// e($tab_select);
$tab_insert = "insert into $tab_tabela (ds_festas, nr_dia, fk_mes) values ('$ds_festas', $nr_dia, $fk_mes)";
$tab_update = "update $tab_tabela set ds_festas = '$ds_festas', fk_mes = $fk_mes, nr_dia = $nr_dia  where id = $id_tab";
$tab_delete = "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_festas, nr_dia, fk_mes from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  				= $tabela[0];
		$ds_festas 	= u8($tabela[1]);
		$nr_dia  		= $tabela[2];
		$fk_mes 		= $tabela[3];
		$opTab = "A";
	} else {
		$id				 	= "";
		$ds_festas 	= "";
		$nr_dia 		= "";
		$fk_mes 		= "";
		$opTab = "I";
	}	
?>
	<label>Festa 	<input type=text name="ds_festas" id="ds_festas" size=40 value="<?=$ds_festas?>" 	></label><br><br>
	<label>Dia 		<input type=text name="nr_dia" 		id="nr_dia" 	 size=2  value="<?=$nr_dia?>" 		inputmode="numeric"></label><br><br>
	<label>Mês
<?php
	e("<select name=fk_mes id=fk_mes>");
		e("<option value=>Mês</option>");
		$qMes = "SELECT id, ds_mes FROM tab_meses order by 1";
		e(processaSelect($qMes, $fk_mes));		
	e("</select>");
?>	
	</label>
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