<script>
	function pagar(p_id) {
		el("indicePG").value = p_id;
		el("frm_cancelar_pagamento").submit();
	}
</script>

<?php
if (!isset($indicePG)) { $indicePG = "" ; }
if (!isset($opcaoCancelar)) { $opcaoCancelar = "" ; }

$tituloPagina = "Cancelar Pagamento";

include_once("include.php");

if ($indicePG <> "" and $opcaoCancelar == "C") {
	$pagamento = "update mae_parcela set dt_pagamento = null where id =  $indicePG";
	e($pagamento);
	$resultado = executa_sql("$pagamento", "Pagamento cancelado com sucesso");
	resultado();	
}
	
	$qParcela= "select p.id, concat(ps.nm_pessoa, ' ', a.ds_ajuda, ' (', p.nr_parcela, '/', a.parcelas, ')'), date_format(p.dt_vencimento, '%d/%m/%Y'), p.vl_parcela
from mae_parcela p, mae_ajuda a, mae_pessoa ps
where p.fk_ajuda = a.id_ajuda
and p.fk_Pessoa = ps.id_pessoa
and p.dt_pagamento is not null
and p.dt_vencimento in
(select max(p1.dt_vencimento)
 from mae_parcela p1
 where p1.fk_pessoa = p.fk_pessoa
 and p1.fk_ajuda = p.fk_ajuda
 and p1.dt_pagamento is not null)
order by 2, dt_vencimento desc";

	$b = new bd;
	$b->prepara($qParcela);
	echo "<center><div class='btn-group'>";
	while($r = $b->consulta()){
		e("<button onclick=\"pagar($r[0]);\">". u8($r[1])  . " - " . str_replace(".", ",", $r[2])." </button>");
	}
	e("</div>");

	$b->libera();

?>
<form name=frm_cancelar_pagamento id=frm_cancelar_pagamento method=post>
	<input type=hidden name=indicePG id=indicePG>
	<input type=hidden name=opcaoCancelar id=opcaoCancelar value="C">
</form>
