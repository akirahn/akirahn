<script>
	function pagar(p_id) {
		el("dtPG").value = el("dtPagto").value;
		el("indicePG").value = p_id;
		el("frm_pagar").submit();
	}
</script>

<?php
if (!isset($indicePG)) { $indicePG = "" ; }
if (!isset($p_pessoa)) { $p_pessoa = "" ; }

$tituloPagina = "Pagar";

include_once("include.php");

if ($indicePG <> "" and $p_pessoa <> "") {
	$pagamento = "update mae_parcela set dt_pagamento = '$dtPG' where id =  $indicePG";
	$resultado = executa_sql("$pagamento", "Pagamento realizado com sucesso");
	resultado();	
}

?>
<form name=pesquisa_pessoa id=pesquisa_pessoa method=post>
	<select name=p_pessoa id=p_pessoa>
<?php
	$qPessoas = "SELECT distinct date_format(dt_vencimento, '%m/%Y'), date_format(dt_vencimento, '%m/%Y')
FROM mae_parcela m
order by dt_vencimento";
	e(processaSelect($qPessoas, $p_pessoa));
?>
	</select>
<?php
?>
	<input type=submit value=Pesquisar>
</form>

<?php
if ($p_pessoa <> "") {
	
	$qParcela= "select p.id, concat(ps.nm_pessoa, ' ' , a.ds_ajuda, ' (', p.nr_parcela, '/', a.parcelas, ')'), date_format(p.dt_vencimento, '%d/%m/%Y'), p.vl_parcela
from mae_parcela p, mae_ajuda a, mae_pessoa ps
where p.fk_ajuda = a.id_ajuda
and p.fk_pessoa = ps.id_pessoa
and date_format(p.dt_vencimento, '%m/%Y') = '$p_pessoa'
and p.dt_pagamento is null
order by dt_vencimento";
// e($qParcela);

	preparaSQL($qParcela);
	echo "<center><label>Escolha data pagto: <input type=date value='".DATE("Y-m-d")."' id=dtPagto name=dtPagto></label><br><br><div class='btn-group'>";
	while($row = consultaSQL()){
		e("<button onclick=\"pagar($row[0]);\">". u8($row[1])  . " - " . str_replace(".", ",", $row[2])." </button>");
	}
	e("</div>");

	liberaSQL();
}
?>
<form name=frm_pagar id=frm_pagar method=post>
	<input type=hidden name=indicePG id=indicePG>
	<input type=hidden name=dtPG id=dtPG>
	<input type=hidden name=p_pessoa value=<?=$p_pessoa?>  >
</form>
