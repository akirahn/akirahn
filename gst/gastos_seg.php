<?php
// if (!isset($inicio_gastos)) { $inicio_gastos = 1; }
// include_once("cad_financas_seg.php");
$menu_off = 1;
include_once("ed_financas.php");
 // if ($inicio_gastos == 1)  {
?>
<script>
	// incluir_gasto();
</script>
<?php
 // }
?>
<script>
		el("opEdicao").value = "I";
		el("id_edicao").value = "";
		el("dt_gasto").value = valorHoje();
		el("vl_gasto").value = "";
		el("fk_tab_tipo").value = "";
		radioSemValor("fk_movimento");
		el("fk_subtipo").value = "";
		radioSemValor("fk_pagto");
		el("obs").value = "";
</script>

