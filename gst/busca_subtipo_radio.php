<?php
$menu_off = 1;
include_once("../include/include_bd.php");
$qTabela = "SELECT s.id, tg.ds_tag
FROM gst_tab_subtipo s
inner join gst_tab_tag tg on tg.id = s.fk_tag
where s.fk_tipo = $p_tipo";
// $result = array();
$b1 = new bd;
$b1->prepara($qTabela);
$c = 0;
while($row = $b1->consulta()){
	echo "<input type=radio name=fk_subtipo id=fk_subtipo$c value=$row[0] ". ($p_sub == $row[0] ? "selected" : "") ."><label for='fk_subtipo$c'>" . u8($row[1]) . "</label>\n";
	$c++;
}
$b1->libera();
?>