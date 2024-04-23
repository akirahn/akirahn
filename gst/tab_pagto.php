<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 				= "Tabela Forma Pagto";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 6;
$tab_div_colunas = 16;
if ($opTab == "A" or $opTab == "I") {
	$ds_forma_pagto = u8d($ds_forma_pagto);
	$tp_pagto = u8d($tp_pagto);
	if ($dia_fechamento == "") { $dia_fechamento = 0; }
	if ($dia_vencimento == "") { $dia_vencimento = 0; }
}
$tab_tabela = "gst_tab_pagto";
$tab_colunas 			= array("Id", "Tipo", "Quem", "Descrição", "Vencimento", "Fechamento");
$tab_select 			= "SELECT g.id, if(tp_pagto = 'C', '". u8d("Crédito") . "', 'Conta'), q.nm_pessoa, f.ds_forma_pagto, dia_vencimento, dia_fechamento
FROM $tab_tabela g
inner join gst_tab_forma_pagto f on g.fk_forma_pagto = f.id
inner join tab_quem q on q.id = g.fk_quem
order by 2, 3, 4";
$tab_insert 			= "insert into $tab_tabela (fk_forma_pagto, dia_fechamento, dia_vencimento, tp_pagto, fk_quem) values ($fk_forma_pagto, $dia_fechamento, $dia_vencimento, '$tp_pagto', $fk_quem)";
$tab_update 			= "update $tab_tabela set fk_forma_pagto = '$fk_forma_pagto', dia_fechamento = $dia_fechamento, dia_vencimento = $dia_vencimento, tp_pagto = '$tp_pagto', fk_quem = $fk_quem where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "TEXTO", "TEXTO", "NÚMERO", "NÚMERO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, fk_forma_pagto, dia_fechamento, dia_vencimento, tp_pagto, fk_quem from $tab_tabela t where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id = $tabela[0];
		$fk_forma_pagto = u8($tabela[1]);
		$dia_fechamento = $tabela[2];
		$dia_vencimento = $tabela[3];
		$tp_pagto 			= $tabela[4];
		$fk_quem 			  = $tabela[5];
		$opTab = "A";
	} else {
		$id = "";
		$fk_forma_pagto = "";
		$dia_fechamento = "";
		$dia_vencimento = "";
		$tp_pagto 			= "";
		$fk_quem				= "";
		$opTab = "I";
	}	
?>
	<label>Tipo <select  name=tp_pagto id=tp_pagto>
		<option value="C">Crédito</option>
		<option value="D">Conta</option>
	</select></label>
	<label>Quem <select name="fk_quem" id="fk_quem">
	<?php
		$qQuem = "SELECT id, nm_pessoa FROM tab_quem order by 2";
		e(processaSelect($qQuem, "fk_quem", $fk_quem));
	?>	
	</select></label>
	<br><br>
	<label>Descrição <select name="fk_forma_pagto" id="fk_forma_pagto">
	<?php
		$qFormaPagto = "SELECT id, ds_forma_pagto FROM gst_tab_forma_pagto order by 2";
		e(processaSelect($qFormaPagto, "fk_forma_pagto", $fk_forma_pagto));
	?>	
	</select></label>
	<br><br>
	<label>Fechamento: <input type=text name=dia_fechamento id=dia_fechamento size=2 value="<?=$dia_fechamento?>" inputmode="numeric" ></label>
	<label>Vencimento: <input type=text name=dia_vencimento id=dia_vencimento size=2 value="<?=$dia_vencimento?>" inputmode="numeric" ></label>
	<script>
		selectPesquisaValor("tp_pagto", "<?=$tp_pagto?>");
		selectPesquisaValor("fk_forma_pagto", "<?=$fk_forma_pagto?>");
		selectPesquisaValor("fk_quem", "<?=$fk_quem?>");
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id?>";
	</script>
<?php	
	die;
}
include_once("../include/frm_dados.php");
?>