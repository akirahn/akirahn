<?php
if (!isset($id_tab)) { $id_tab = "" ; }
if (!isset($ds_ajuda)) { $ds_ajuda = "" ; }
if (!isset($dt_ajuda)) { $dt_ajuda = "" ; }
if (!isset($ds_forma_pagto)) { $ds_forma_pagto = "" ; }
if (!isset($parcelas)) { $parcelas = "" ; }
if (!isset($vl_ajuda)) { $vl_ajuda = "" ; }
if (!isset($nr_vencimento)) { $nr_vencimento	 = "" ; }
$tab_nome 				= "Ajuda";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 6;
$tab_div_colunas = 16;
$tab_colunas 			= array("Id", "Descrição", "Data", "Valor", "Parcelas", "Vencimento");
$tab_select 			= "select id_ajuda, ds_ajuda, date_format(dt_ajuda, '%d/%m/%Y'), format(vl_ajuda, 2, 'de_DE'), parcelas, nr_vencimento from mae_ajuda t order by 2, 3";
if ($opTab == "A" or $opTab == "I")  {
	$vl_ajuda = valor_sql($vl_ajuda);
	$ds_ajuda = u8d($ds_ajuda);
	$ds_forma_pagto = u8d($ds_forma_pagto);
}
$tab_insert 			= "insert into mae_ajuda (ds_ajuda, dt_ajuda, parcelas, vl_ajuda, ds_forma_pagto, nr_vencimento) values ('$ds_ajuda', '$dt_ajuda', $parcelas, $vl_ajuda, '$ds_forma_pagto', $nr_vencimento)";
$tab_update 			= "update mae_ajuda set ds_ajuda = '$ds_ajuda', dt_ajuda = '$dt_ajuda', parcelas = $parcelas, vl_ajuda = $vl_ajuda, ds_forma_pagto = '$ds_forma_pagto', nr_vencimento = $nr_vencimento  where id_ajuda = $id_tab";
$tab_delete 			= "delete from mae_ajuda where  id_ajuda = $id_tab";
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qAjuda = "select id_ajuda, ds_ajuda, dt_ajuda, replace(vl_ajuda, '.', ','), ds_forma_pagto, parcelas, nr_vencimento from mae_ajuda t where id_ajuda = $id_tab order by 2, 3";
		$ajuda = pesquisa($qAjuda);
		$id_ajuda = $ajuda[0];
		$ds_ajuda = $ajuda[1];
		$dt_ajuda = $ajuda[2];
		$vl_ajuda = nformat($ajuda[3]);
		$ds_forma_pagto = u8($ajuda[4]);
		$parcelas = $ajuda[5];
		$nr_vencimento = $ajuda[6];
		$opTab = "A";
	} else {
		$id_ajuda = "";
		$ds_ajuda = "";
		$dt_ajuda  = date("Y-m-d");
		$vl_ajuda = "";
		$ds_forma_pagto = "";
		$parcelas = "";
		$nr_vencimento = "";
		$opTab = "I";
	}	
?>
	<label>Descrição <input type="text" name="ds_ajuda" id="ds_ajuda" size=30 value="<?=$ds_ajuda?>"></label>
	<br><br><label>Data<input type=date name=dt_ajuda id=dt_ajuda inputmode=numeric size=3 value="<?=$dt_ajuda?>"></label>
	<label>Valor <input type=text name=vl_ajuda id=vl_ajuda inputmode=numeric size=10 onkeyup='formatarMoeda(this);' value="<?=$vl_ajuda?>"></label><br><br>
	<label>Forma Pagto:  <input type=text name=ds_forma_pagto id=ds_forma_pagto size=30 value="<?=$ds_forma_pagto?>"></label><br><br>
	<label>Parcelas<input type=text name=parcelas id=parcelas inputmode=numeric id=parcelas size=3 value="<?=$parcelas?>"></label>
	<label>Vencimento<input type=text name=nr_vencimento id=nr_vencimento inputmode=numeric id=nr_vencimento size=3 value="<?=$nr_vencimento?>"></label>
	<script>
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id_ajuda?>";
	</script>
<?php	
	die;
}
include_once("frm_dados.php");
?>