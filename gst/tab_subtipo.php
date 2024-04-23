<?php
$tituloPagina = "SubTipo";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_subtipo(p_tipo, p_ds_tipo) {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoSubtipo");
		el("opSubtipo").value = "A";
		el("fk_tipo").value = p_tipo;
		$("#dsp_tipo").html("Tipo: " + p_ds_tipo);
		var dados = $('#frm_editar_subtipos').serialize();
		radioSemValor("tag[]");
		$.ajax({
				type : 'POST',
				dataType: 'TEXT',
				url  : "buscar_tag.php",
				data: dados,
				success :  function(data){
					valores = data.split(";");
					$("#tags_carga").val(data);
					for(i=1; i < valores.length; i++) {
						$("#tag"+valores[i]).prop( "checked", true );
					}
				}
		});
	}
//--------------------------------------------------------------------------------------------------
	function gravar_subtipo() {
		el("frm_editar_subtipos").submit();
	}
</script>

<?php

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $spc, $a, $ico_editar, $ico_excluir, $c, $ico_incluir, $subtotal;
	for($i=0; $i < $a; $i++) {
		e("<td align=center>".u8($linhas[$i][1])."</td>");
		e("<td align=center>".u8($linhas[$i][2])."</td>");
		e("<td class=acao><button class=btn onclick=\"editar_subtipo(".$linhas[$i][0].", '".u8($linhas[$i][1])."' );\" align=center>$ico_editar</button></td>");
		e("</tr>");
	}
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($opSubtipo == "A" and $fk_tipo <> "" ) {
	if ($tag <> "") {
		$qtd_tag = count($tag);
		$tags = "";
		$pre_insert = "insert into gst_tab_subtipo (fk_tipo, fk_tag) values ";
		for($i=0;$i < $qtd_tag; $i++) {
			if (($tag[$i] <> "")) {
				$tags .= $tag[$i] . ",";
			}
		}
		$tags = substr($tags, 0, strlen($tags)-1); 
		$qExcluirTags = "delete from gst_tab_subtipo where fk_tipo = $fk_tipo and not exists (select null from gst_gastos g where g.fk_subtipo = gst_tab_subtipo.id) and fk_tag not in ($tags)";
		// e($qExcluirTags);
		$resultado = executa_sql($qExcluirTags, "Excluídos");
		resultado();
		// e($tags);
		$aTags = explode(",", $tags);
		$aCarga = explode(";", $tags_carga);
		$qtd_tags = count($aTags);
		$vInsert = "";
		for($i=0;$i < $qtd_tags; $i++) {
			if ($tags_carga == "" or ($tags_carga <> "" and array_search($aTags[$i], $aCarga) === false)) {
				$vInsert .= "($fk_tipo, " . $aTags[$i] . "),";
			}
		}
		// e($vInsert);
		if ($vInsert <> "") {
			$vInsert = "$pre_insert " . substr($vInsert, 0, strlen($vInsert)-1);
			// e($vInsert);
			$resultado = executa_sql($vInsert, "Tags cadastradas");
			resultado();			
		}
	}
}

?>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
	    <span class="close" onclick="fecharEdicao();"><?=$ico_fechar?></span>
			<span class="close" id=gravar onclick="gravar_subtipo()"><?=$ico_gravar?></span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaoSubtipo class=editor>
			<div class=tituloEdicao><?=$apps["gst"]["app"]?></div><br>
			<form name=frm_editar_subtipos id=frm_editar_subtipos method=post action=<?=$self?> >
				<input type="hidden" name="opSubtipo" id="opSubtipo" value="A">
				<input type="hidden" name="fk_tipo" id="fk_tipo" value="<?=$fk_tipo?>">
				<input type="hidden" name="tags_carga" id="tags_carga" value="">
				<label id=dsp_tipo></label><br><br>
				<label>Subtipo<br><br>
<?php
	$qTag = "select id, ds_tag from gst_tab_tag order by 2";
	e(processaCheckBox($qTag, "tag[]"));
?>
				</label><br><br>
			</form>
		</div>
	</div>
</div>
<?php
	$qTipo = "
select 	t.id, t.ds_tipo
from gst_tab_tipo t
order by t.ds_tipo";
// e($qTipo);
	$b1 = new bd;
	$b1->prepara($qTipo);
	$inicio = "";
	e("<table width=100% class=padrao>");
		e("<th align=center>Tipo</th>");
		e("<th align=center>SubTipo</th>");
		e("<th class=acao>");
		e("</th>");
		e("</tr>");
	$c = 0;
	while($row = $b1->consulta()){
		$linha = u8($row[1]);
		if ($inicio <> $linha) {
			if ($inicio <> "") { imprimir_array(); }
			$inicio = $linha;
			$a = 0;
			$subtotal = 0;
			$c++;
		}
		$linhas[$a] = $row;
		$subtotal +=  $row[2];
		$qTag = "SELECT s.id, t.ds_tag
FROM gst_tab_subtipo s
inner join gst_tab_tag t on t.id = s.fk_tag
where fk_tipo = $row[0]
order by 2";
		$txt = "";
		$b2 = new bd;
		$b2->prepara($qTag);
		$ctg = 0;
		while($tg = $b2->consulta()){
			$txt .= ($ctg == 0 ? "" : ", ") . $tg[1];
			$ctg++;
		}
		if ($txt <> "") { $linhas[$a][2] = $txt; }
		// echo $linhas[$a][1];
		$b2->libera();
		$a++;
	}
	if ($c > 0) {
		imprimir_array();
	}
	$b1->libera();
	if ($c == 0) {
		e("<td colspan=5 align=center>Nenhum dado encontrado</td>");
	}
	e("</table>");
desconectar();
?>