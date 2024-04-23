<?php
if (!isset($id_tab)) { $id_tab = "" ; }

$tab_nome 		= "Fluxo Tipo";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");

$dom_tp_fluxo_tipo = array("M", "Mensalidade", "F", "Fluxo", "C", "Contas");
$dom_credito_debito_sn = array("0", "Sim", "1", ("Não"));

$tab_qtd_colunas = 5;
$tab_div_colunas = 22;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_fluxo_tipo = u8d($ds_fluxo_tipo);
	$tp_fluxo_tipo = u8d($tp_fluxo_tipo);
}
$tab_tabela = "fluxo_tipo";
$tab_colunas = array("Id", "Descrição", "Débito", "Crédito", "Tipo");
// tp_debito, tp_credito,
$tab_select = "select id, ds_fluxo_tipo, 
        case " . preparaCaseDominio("tp_debito", $dom_credito_debito_sn) . "end, 
        case " . preparaCaseDominio("tp_credito", $dom_credito_debito_sn) . "end, 
        case " . preparaCaseDominio("tp_fluxo_tipo", $dom_tp_fluxo_tipo) . "end 
				from $tab_tabela order by 2";
// e($tab_select);
$tab_insert = "insert into $tab_tabela (ds_fluxo_tipo, tp_debito, tp_credito, tp_fluxo_tipo) values ('$ds_fluxo_tipo', $tp_debito, $tp_credito, '$tp_fluxo_tipo')";
$tab_update = "update $tab_tabela set ds_fluxo_tipo = '$ds_fluxo_tipo', tp_debito =  $tp_debito, tp_credito =  $tp_credito, tp_fluxo_tipo = '$tp_fluxo_tipo' where id = $id_tab";
$tab_delete = "delete from $tab_tabela where id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "TEXTO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_fluxo_tipo, tp_debito, tp_credito, tp_fluxo_tipo from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  						= $tabela[0];
		$ds_fluxo_tipo 	= u8($tabela[1]);
		$tp_debito  		= $tabela[2];
		$tp_credito 		= $tabela[3];
		$tp_fluxo_tipo	= $tabela[4];
		$opTab = "A";
	} else {
		$id				 			= "";
		$ds_fluxo_tipo 	= "";
		$tp_debito 			= "";
		$tp_credito 		= "";
		$tp_fluxo_tipo	= "";
		$opTab = "I";
	}	
?>
	<label>Descrição 	<input type=text name="ds_fluxo_tipo" id="ds_fluxo_tipo" size=40 value="<?=$ds_fluxo_tipo?>" 	></label><br><br>
	<label>Débito
<?php
	montaRadio($dom_credito_debito_sn, "tp_debito", $tp_debito);
?>	
	</label><br><br>
	<label>Crédito
<?php
	montaRadio($dom_credito_debito_sn, "tp_credito", $tp_credito);
?>	
	</label><br><br>
	<label>Tipo
<?php
	montaRadio($dom_tp_fluxo_tipo, "tp_fluxo_tipo", $tp_fluxo_tipo);	
?>	
	</label><br><br>
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