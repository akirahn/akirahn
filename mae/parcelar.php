<?php
if (!isset($opcaoParcelas)) { $opcaoParcelas = "" ; }
if (!isset($p_parcelar)) { $p_parcelar = "" ; }
if (!isset($p_excluir_parcelas)) { $p_excluir_parcelas = "" ; }

$tituloPagina = "Parcelar";

include_once("include.php");
if ($p_parcelar <> "" and $opcaoParcelas == "P") {
	
	$qAjuda= "select a.id_ajuda, date_format(a.dt_ajuda, '%m') mes, date_format(a.dt_ajuda, '%Y') ano, a.nr_vencimento, 
									 a.parcelas, round(a.vl_ajuda/a.parcelas/coalesce(count(p.id_pessoa), 1), 2)
from mae_ajuda a, mae_pessoa p
where a.id_ajuda = $p_parcelar
and p.sn_ativo = 1
";
	$pAjuda = pesquisa($qAjuda);
	$mes = $pAjuda[1];
	$ano = $pAjuda[2];
	$vencimento = $pAjuda[3];
	$parcelas = $pAjuda[4];
	$vl_parcela = $pAjuda[5];

	//id, fk_pessoa, fk_ajuda, dt_vencimento, dt_pagamento, nr_parcela, vl_parcela
	$qPessoas = "select p1.id_pessoa, p1.nm_pessoa from mae_pessoa p1 where p1.sn_ativo = 1";

	$b = new bd;
	$b->prepara($qPessoas);
	$insert = "insert into mae_parcela (fk_ajuda, fk_pessoa, dt_vencimento, nr_parcela, vl_parcela) values ";
	$c = 1;
	while($row = $b->consulta()){
		$m = $mes;
		$a = $ano;
		$p = 0;
		for($i=0; $i < $parcelas; $i++) {
			if ($m ==12) {
				$m = 1;
				$a++;
			} else {
				$m++;
			}
			$p++;
			if ($c == 1) {
				$c++;
			} else {
				$insert .= ",";
			}
			$insert .= "($pAjuda[0], $row[0], '$a-$m-$vencimento', $p, $vl_parcela)";
		}
	}
	$b->libera();
	// e($insert . "<br>");
	$resultado = executa_sql("$insert;", "Parcelas incluídas com sucesso");
	resultado();
	$update_dono_cartao = "update mae_parcela set dt_pagamento = dt_vencimento where fk_pessoa in (select id_pessoa from mae_pessoa where sn_cartao = 1) and fk_ajuda = $pAjuda[0]";
	$resultado = executa_sql("$update_dono_cartao", "Parcelas incluídas com sucesso");
}

if ($p_excluir_parcelas <> "" and $opcaoParcelas == "E") {
	$delete = "delete from mae_parcela where fk_ajuda = $p_excluir_parcelas";
	$resultado = executa_sql($delete, "Parcelas excluídas com sucesso");
	resultado();
}

?>
<form name=parcelar id=parcelar method=post>
	<input type=hidden name=opcaoParcelas id=opcaoParcelas value=P>
	<select name=p_parcelar id=p_parcelar>	
<?php
	$qParcelar = "select a.id_ajuda, concat(a.ds_ajuda, ' (', date_format(a.dt_ajuda, '%d/%m/%Y'), ')')
from mae_ajuda a
where not exists
(select null
 from mae_parcela p
 where fk_ajuda = a.id_ajuda)
order by 2";
	e(processaSelect($qParcelar, $p_parcelar));
?>
	</select>
	<input type=submit value=Parcelar>
</form>

<h1 align=center>Excluir Parcelas</h1>
<form name=excluir_parcelas id=excluir_parcelas method=post>
	<input type=hidden name=opcaoParcelas id=opcaoParcelas value=E>
	<select name=p_excluir_parcelas id=p_excluir_parcelas>	
<?php
	$qExcluirParcelar = "select a.id_ajuda, concat(a.ds_ajuda, ' (', date_format(a.dt_ajuda, '%d/%m/%Y'), ')')
from mae_ajuda a
where exists
(select null
 from mae_parcela p
 where fk_ajuda = a.id_ajuda)
order by 2";
	e(processaSelect($qExcluirParcelar, $p_excluir_parcelas));
?>
	</select>
	<input type=submit value="Excluir Parcelas">
</form>
