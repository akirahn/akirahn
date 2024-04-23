<?php
$menu_off = 1;
include_once("../include/include_bd.php");
include_once("lst.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function modalGravar() {
		$("#nr_qtd").val($("#div_qtd").html());
		gravarModalEdicao("frm_editar_lista", "<?=$dirApp?>frm_lista.php");
	}	
//--------------------------------------------------------------------------------------------------
	tituloModalEdicao("Edição Lista");
</script>

<?php

//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($p_edicao_opcao == "A" or $p_edicao_opcao == "I") {
	$ds_item  = prepara_coluna(u8d($ds_item), 1);
	$ds_grupo = prepara_coluna(u8d($ds_grupo), 1);
	$nr_qtd 	= valor_sql($nr_qtd);
	$sn_ativo = ($sn_ativo == "" ? 0 : $sn_ativo);
}

if ($p_edicao_opcao == "A" and $p_edicao_id <> "" ) {
	$qUpdate = "update lst_lista 
							set fk_item 	= $fk_item,
									fk_grupo 	= $fk_grupo,
									nr_qtd    = $nr_qtd,
									sn_ativo  = $sn_ativo       								
							where id = $p_edicao_id";
	// e($qUpdate);
	$erro_sql = 0;
	$resultado = executa_sql($qUpdate, "Lista ($fk_item/$fk_grupo) alterado com sucesso");
	e($resultado);
	if ($erro_sql == 0) {
		$p_edicao_id = "";
	}
	die;
}

if ($p_edicao_opcao == "I" and $p_edicao_id == "" ) {
	$vInsert = "
insert into lst_lista 
	(nr_qtd, fk_item, fk_grupo, sn_ativo) values 
	($nr_qtd, $fk_item, $fk_grupo, $sn_ativo) ";
	// e($vInsert);
	$ultimo_sql_id = "";
	$erro_sql = 0;
	$resultado = executa_sql($vInsert, "Lista ($fk_item/$fk_grupo) incluído com sucesso");
	e($resultado);
	die;
}

if ($p_edicao_opcao == "PI" and $p_edicao_id == "" ) {
	$p_edicao_opcao = "I";
	$nr_qtd					= 0;
	$fk_item				= "";
	$fk_grupo				= "";
	$sn_ativo				= "";
}

$qTabItem  = "SELECT id, ". prepara_coluna("ds_item")  . " FROM lst_tab_item  order by 2";
$qTabGrupo = "SELECT id, ". prepara_coluna("ds_grupo") . " FROM lst_tab_grupo order by 2";

if ($p_edicao_opcao == "PA" and $p_edicao_id <> "" ) {
	$p_edicao_opcao = "A";
	$qLista = "select 	l.id, 
				format(l.nr_qtd, 5, 'de_DE'),
				l.fk_item, 
				l.fk_grupo,
				l.sn_ativo
from lst_lista l
inner join lst_tab_grupo g on g.id = l.fk_grupo
inner join lst_tab_item i on i.id = l.fk_item
where l.id = $p_edicao_id";
	$f = pesquisa($qLista);
	$nr_qtd					= $f[1];
	$fk_item				= $f[2];
	$fk_grupo				= $f[3];
	$sn_ativo				= $f[4];
}

	//<input type="text" name="nr_qtd" id="nr_qtd" readonly inputmode="numeric" style="font-size: 16px;" size=8 onkeyup="formatarMoeda(this);"  value="">
?>
<center>
<form name=frm_editar_lista id=frm_editar_lista method=post action=<?=$self?> >
	<input type="hidden" name="p_edicao_opcao" 	id="p_edicao_opcao" value="<?=$p_edicao_opcao?>">
	<input type="hidden" name="p_edicao_id" 		id="p_edicao_id" 		value="<?=$p_edicao_id?>">
	<input type="hidden" name="id_lista" 				id="id_lista" 			value="<?=$p_edicao_id?>">
	<input type="hidden" name="nr_qtd" 					id="nr_qtd">
	
	<label>Quantidade</label>
<?php	
	// <label>Quantidade: </label><input type=number name=nr_qtd id=nr_qtd class=direita value="?=$nr_qtd?" size=5><br><br>
		monta_teclado_numerico(array("div_qtd", "TD"));
		e("<script>$('#div_qtd').html('$nr_qtd');</script>");
?>	
	<label>Grupo<br>
	<div style="text-align: justify">
<?php
	e(processaRadio($qTabGrupo, "fk_grupo", $fk_grupo, "", ""));
?>			
	</div></label>
	<br><br>
	
	<label>Item <select name=fk_item id=fk_item>
		
<?php
	// e(processaRadio($qTabItem, "fk_item", $fk_item, "", ""));
	e(processaSelect($qTabItem, $fk_item));
?>			
	</select></label>
	<br><br>
	
	<?php campo_checkbox("sn_ativo", "1", "Ativo", $sn_ativo); ?>
	<br><br>
	
</form>
</center>
