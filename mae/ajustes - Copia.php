<?php
if (!isset($id_tab)) { $id_tab = "" ; }
if (!isset($ds_tab)) { $ds_tab = "" ; }
if (!isset($dt_ajuda)) { $dt_ajuda = "" ; }
if (!isset($ds_forma_pagto)) { $ds_forma_pagto = "" ; }
if (!isset($parcelas)) { $parcelas = "" ; }
if (!isset($vl_ajuda)) { $vl_ajuda = "" ; }
if (!isset($nr_vencimento)) { $nr_vencimento	 = "" ; }
if (!isset($p_pessoa)) { $p_pessoa	 = "" ; }
if (!isset($p_ajuda)) { $p_ajuda	 = "" ; }
if (!isset($opcao)) { $opcao	 = "" ; }
$tab_nome 				= "Ajustes";
$tituloPagina = "$tab_nome";
include_once("include.php");

if ($opcao == "A") {
	$vl_parcela = valor_sql($vl_parcela);
	$update = "update mae_parcela 
							 set 	dt_pagamento = '$dt_pagamento',
										dt_vencimento = '$dt_vencimento',
										nr_parcela = $nr_parcela,
										vl_parcela = $vl_parcela
							 where id =  $id_parcela";
	e($update);
	$resultado = executa_sql("$update", "Ajuste realizado com sucesso");
	resultado();	
}

?>
<form name=frm_pesquisa_ajuste id=frm_pesquisa_ajuste method=post>
	Pessoa <select name=p_pessoa id=p_pessoa>
<?php
	$qPessoas = "select p.id_pessoa, p.nm_pessoa from mae_pessoa p where p.sn_ativo = 1 order by 2";
	e(processaSelect($qPessoas, $p_pessoa));
?>
	</select>
	Ajuda <select name=p_ajuda id=p_ajuda>	
<?php
	$qAjuda = "select p.id_ajuda, p.ds_ajuda from mae_ajuda p order by 2";
	e(processaSelect($qAjuda, $p_ajuda));
?>
	</select>
	<input type=submit value=Pesquisar>
</form>
<?php
if ($p_pessoa <> "" or $p_ajuda <> "") {
	$tab_select = "select m.id, m.fk_pessoa, m.fk_ajuda, m.dt_vencimento, m.dt_pagamento, m.nr_parcela, replace(m.vl_parcela, '.', ',')
from mae_parcela m 
 where 1 = 1 " .
($p_ajuda  <> "" ? " and m.fk_ajuda  = $p_ajuda " : "") .
($p_pessoa <> "" ? " and m.fk_pessoa = $p_pessoa" : "") .
" order by 4";
	$i = 0;
	preparaSQL($tab_select);
	e("<table width=100% class=padrao border=1>
				<th>Vencimento</th>
				<th>Pagamento</th>
				<th>Parcela</th>
				<th>Valor</th>
				<th></th>
				</tr>");
	while($r = consultaSQL()){
		e("<form name=frm_linha$i id=frm_linha$i method=post>");
		e("<input type=hidden name=opcao value=A>");
		e("<input type=hidden name=p_pessoa value=$p_pessoa>");
		e("<input type=hidden name=p_ajuda value=$p_ajuda>");
		e("<input type=hidden name=id_parcela value=$r[0]>");
		e("<td><input type=date name=dt_vencimento value=$r[3]></td>");
		e("<td><input type=date name=dt_pagamento  value=$r[4]></td>");
		e("<td><input type=text name=nr_parcela id=nr_parcela$i size=3 value=$r[5]></td>");
		e("<td><input type=text name=vl_parcela id=vl_parcela$i inputmode=numeric size=10 onkeyup='formatarMoeda(this);' value=$r[6]></td>");
		e("<td><input type=submit value=Alterar> <input type=button value='Excluir' onclick=\"\"</td>");
		e("</tr>");
		e("<form>");
		$i++;
	}
	e("</table>");
	liberaSQL();
}
?>