<div id=tituloCSN class="titulo">
	<table width=100% border=0>
		<!--<td rowspan=1 class=csn >CSN</td>-->
		<td align="left">
				<span class=csn>Tesouraria CSN</span> <select id=opcao_menu onchange="menu(this.value)">
					<option value=0>Menu Principal</option>
<?php
	$qMenuGrupo = "SELECT m.id, m.ds_menu, g.ds_menu_grupo, m.pagina
FROM menu m, menu_grupo g
where m.menu_grupo_id = g.id
order by g.nr_ordem, m.nr_ordem";
	processaSelectGrupo($qMenuGrupo, $op_menu);
?>
					<option value=999>Sair</option>
				</select>
		</td>
		<td id=Mensagem>
			<?=$mensagem?>
		</td>
		
	</table>
</div>
<form name=frm_menu id=frm_menu method=post action="<?=$self?>">
	<input type="hidden" name="PHPSESSID" value="<?=$valor_sessao?>">
	<input type=hidden name=op_menu id=op_menu>
</form>
</center>
<div id=conteudo>
<?php
	if ($op_menu == "") { $op_menu = 0; } //else { script("el('menuAcao').value = $op_menu;"); }	
	$paginaMenu = "";
	$qPaginaMenu = "select m.pagina from menu m where m.id = $op_menu";
	preparaSQL($qPaginaMenu);
	while($row = consultaSQL()){
		$paginaMenu = $row[0];
	}
	if ($paginaMenu <> "") { include("../csn.v2/$paginaMenu.php"); }
?>

</div>
