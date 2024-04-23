<?php
include_once("include.php");
if (!isset($inicio_gastos)) { $inicio_gastos = 1; }
include_once("cad_financas.php");
 if ($inicio_gastos == 1)  {
?>
<script>
	incluir_gasto();
</script>
<?php
 }
?>

