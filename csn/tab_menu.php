<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 		= "Menu";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas = 5;
$tab_div_colunas = 22;
if ($opTab == "Alterar" or $opTab == "Incluir" or $opTab == "A" or $opTab == "I") {
	$ds_menu = u8d($ds_menu);
	$pagina = u8d($pagina);
}
$qGrupo = "select id, ds_menu_grupo from menu_grupo order by nr_ordem";
if (!($opTab == "Alterar" or $opTab == "Incluir")) {
	$tab_form = "frm_tab_menu";
	e("<form name=$tab_form id=$tab_form method=post action=$self >");
	if ($p_menu_grupo == "") { $p_menu_grupo = 99; }
	e("<select name=p_menu_grupo id=p_menu_grupo onchange=\"el('$tab_form').submit();\">");
		e("<option ".($p_menu_grupo == 99 ? "selected" : "")." value=99>Grupo</option>");
		e(processaSelect($qGrupo, $p_menu_grupo));
	e("</select> ");
	e("<button type=submit>Pesquisar</button>");
	e("</form>");
}	
$tab_tabela = "menu";
$tab_colunas 			= array("Id", "Descrição", "Ordem", "Grupo", "Página");
$tab_select 			= "select m.id, m.ds_menu, m.nr_ordem, g.ds_menu_grupo, m.pagina
from $tab_tabela m
inner join menu_grupo g on g.id = m.menu_grupo_id
where 1 = 1
". ($p_menu_grupo == 99 ? "" : " and menu_grupo_id = $p_menu_grupo ") ."
order by m.menu_grupo_id, m.nr_ordem";
$tab_insert 			= "insert into $tab_tabela (ds_menu, nr_ordem, menu_grupo_id, pagina) values ('$ds_menu', $nr_ordem, $menu_grupo_id, '$pagina')";
$tab_update 			= "update $tab_tabela set ds_menu = '$ds_menu', nr_ordem = $nr_ordem, menu_grupo_id = $menu_grupo_id, pagina = '$pagina'  where id = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "NÚMERO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qTabela = "select id, ds_menu, nr_ordem, menu_grupo_id, pagina from $tab_tabela where id = $id_tab order by 2" ;
		$tabela = pesquisa($qTabela);
		$id  						= $tabela[0];
		$ds_menu 				= u8($tabela[1]);
		$nr_ordem  			= $tabela[2];
		$menu_grupo_id 	= $tabela[3];
		$pagina 				= u8($tabela[4]);
		$opTab = "A";
	} else {
		$id				 			= "";
		$ds_menu 				= "";
		$nr_ordem 			= "";
		$menu_grupo_id 	= "";
		$pagina					= "";
		$opTab = "I";
	}	
	e("<input type=hidden name=p_menu_grupo value='$menu_grupo_id'>");
?>
	<label>Descrição 	<input type=text name="ds_menu" id="ds_menu" size=40 value="<?=$ds_menu?>" 	></label><br><br>
	<label>Ordem 		<input type=text name="nr_ordem" 		id="nr_ordem" 	 size=2  value="<?=$nr_ordem?>" 		inputmode="numeric"></label><br><br>
	<label>Grupo
<?php
	e("<select name=menu_grupo_id id=menu_grupo_id onchange=\"el('p_menu_grupo').value=el('menu_grupo_id').value;\">");
		// e("<option value=>Grupo</option>");
		e(processaSelect($qGrupo, $menu_grupo_id));		
	e("</select>");
?>	
	</label><br><br>
	<label>Página 	<input type=text name="pagina" id="pagina" size=40 value="<?=$pagina?>" 	>.php</label><br><br>
	<script>
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id?>";
	</script>
<?php	
	die;
}
include_once("../include/frm_dados.php");
?>