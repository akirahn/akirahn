<?php
$tab_qtd_colunas = 5;
$tab_div_colunas = 16;
$tab_colunas = array("Id", "Descrição", "Débito", "Crédito", "Tipo");
$tab_nome = "Fluxo Tipo";
// tp_debito, tp_credito,
$tab_select = "select id, ds_fluxo_tipo, 
											case when tp_debito  = 1 then 'Sim' else '".u8d("Não")."' end debito, 
											case when tp_credito = 1 then 'Sim' else '".u8d("Não")."' end credito,
        tp_fluxo_tipo from fluxo_tipo order by 2";
$tab_insert = "insert into fluxo_tipo (ds_fluxo_tipo, tp_debito, tp_credito, tp_fluxo_tipo) values ('".u8d($ds_tab)."', $tp_debito, $tp_credito, '".u8d($tp_fluxo_tipo)."')";
$tab_update = "update fluxo_tipo set ds_fluxo_tipo = '".u8d($ds_tab)."', tp_debito =  $tp_debito, tp_credito =  $tp_credito, tp_fluxo_tipo = '".u8d($tp_fluxo_tipo)."' where id = $id_tab";
$tab_delete = "delete from fluxo_tipo where id = $id_tab";
$inputTab 				= "	<br><br>
											<div class=div_radio>
												<span>Débito</span>										 
												<input type=radio name=tp_debito id=tp_debito1 value=1 ".($tp_debito == 1 ? "checked" : "")."><label for=tp_debito1> Sim </label>
												<input type=radio name=tp_debito id=tp_debito0 value=0 ".($tp_debito == 0 ? "checked" : "")."><label for=tp_debito0> Não </label>
											</div>
											<div class=div_radio>
												<span>Crédito</span>										 
												<input type=radio name=tp_credito id=tp_credito1 value=1 ".($tp_credito == 1 ? "checked" : "")."><label for=tp_credito1> Sim </label>
												<input type=radio name=tp_credito id=tp_credito0 value=0 ".($tp_credito == 0 ? "checked" : "")."><label for=tp_credito0> Não </label>
											</div>
											<br><br><label>Tipo<select name=tp_fluxo_tipo><option value='M'>Mensalidade</option><option value='F'>Fluxo</option><option value='C'>Contas</option></select></label>";
$editarTab				= ", p_tp_debito, p_tp_credito, p_tp_fluxo_tipo";
$alteraTab				= "el('tp_debito').value = p_tp_debito;
										 el('tp_credito').value = p_tp_credito;
										 el('tp_fluxo_tipo').value = p_tp_fluxo_tipo;";
$incluiTab				= "el('tp_debito').value = '';
										 el('tp_credito').value = '';
										 el('tp_fluxo_tipo').value = '';";
include_once("tab_tabelas.php");
?>
