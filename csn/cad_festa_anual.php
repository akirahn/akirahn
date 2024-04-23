<?php
$tituloPagina = "Festa Anual";
include_once("include.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_festa_anual(p_id_festa) {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaofesta");
		el("opfesta").value = "A";
		el("id_festa").value = p_id_festa;
		var dados = $('#editar_festa').serialize();
		$.ajax({
				type : 'POST',
				dataType: 'TEXT',
				url  : "buscar_festa_anual.php",
				data: dados,
				success :  function(data){
					valores = data.split(";");
					selectPesquisaValor("fk_tab_festas", valores[1]);
					$("#nr_ano").val(valores[2]);
					$("#dt_pagto").val(valores[3]);
					$('#dt_festa').val(valores[4]);
					$("#vl_festa").val(valores[5]);
					$("#vl_vela_medium").val(valores[6]);
					$("#vl_vela_outros").val(valores[7]);
				}
		});
	}
//--------------------------------------------------------------------------------------------------
	function incluir_festa_anual() {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaofesta");
		el("opfesta").value = "I";
		el("id_festa").value = "";
		el("fk_tab_festas").value = "";
		var date = new Date();
		var year = date.getFullYear();
		el("nr_ano").value = year;
		el("dt_festa").value = valorHoje();
		el("dt_pagto").value = valorHoje();
		el("vl_festa").value = "";
		el("vl_vela_medium").value = "";
		el("vl_vela_outros").value = "";
	}
//--------------------------------------------------------------------------------------------------
	function excluir_festa_anual(pIndice) {
		el("id_excluir_festa").value = pIndice;
		el("excluir_festa").submit();
	}
//--------------------------------------------------------------------------------------------------
	function gravar_festa_anual() {
		el("editar_festa").submit();
	}
</script>

<?php
/*
if (!isset($p_ano)) {	$p_ano = ""; }
if (!isset($opfesta)) {	$opfesta = ""; }

if (!isset($id_festa)) {	$id_festa = ""; }
if (!isset($fk_tab_festas)) {	$fk_tab_festas = ""; }
if (!isset($nr_ano)) {	$nr_ano = ""; }
if (!isset($dt_festa)) {	$dt_festa = ""; }
if (!isset($dt_pagto)) {	$dt_pagto = ""; }
if (!isset($vl_festa)) {	$vl_festa = ""; }
if (!isset($vl_vela_medium)) {	$vl_vela_medium = ""; }
if (!isset($vl_vela_outros)) {	$vl_vela_outros = ""; }
*/

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $subtotal, $a, $ico_editar, $ico_excluir;
	for($i=0; $i < $a; $i++) {
		// e("<td align=center>".$linhas[$i][0]."</td>");
		e("<td align=center>".u8($linhas[$i][1])."</td>");
		e("<td align=center>".$linhas[$i][2]."</td>");
		e("<td align=center>".$linhas[$i][3]."</td>");
		e("<td align=right>".nformat($linhas[$i][4])."</td>");
		e("<td align=right>".nformat($linhas[$i][5])."</td>");
		e("<td align=right>".nformat($linhas[$i][6])."</td>");
		e("<td class=acao><button onclick=\"editar_festa_anual(".$linhas[$i][0].");\" align=center>$ico_editar</button>");
		e("<button onclick=\"excluir_festa_anual(".$linhas[$i][0].");\" align=center>$ico_excluir</button></td>");
		e("</tr>");
	}
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($opfesta == "E" and $id_excluir_festa <> "" ) {
	$qFesta = "delete from festa_anual where id = $id_excluir_festa";
	$resultado = executa_sql($qFesta, "Festa ($id_excluir_festa) excluido com sucesso");
	resultado();
	$id_excluir_festa = "";
}

if ($opfesta == "A" and $id_festa <> "" ) {
	$qFesta = "update festa_anual 
							set fk_tab_festas = $fk_tab_festas, 
									nr_ano = $nr_ano,
									dt_festa = '$dt_festa', 
									dt_pagto = '$dt_pagto',
									vl_festa = replace(replace('$vl_festa', '.', ''), ',', '.'),
									vl_vela_medium = replace(replace('$vl_vela_medium', '.', ''), ',', '.'),
									vl_vela_outros = replace(replace('$vl_vela_outros', '.', ''), ',', '.')
							where id = $id_festa";
	// e($qFesta);
	$resultado = executa_sql($qFesta, "Festa ($id_festa) alterado com sucesso");
	resultado();
	$id_editar_festa = "";
}

if ($opfesta == "I" and $id_festa == "" ) {
	$qFesta = "
insert into festa_anual 
	(fk_tab_festas, nr_ano, dt_festa, dt_pagto, vl_festa, vl_vela_medium, vl_vela_outros) values 
 	($fk_tab_festas, $nr_ano, '$dt_festa', '$dt_pagto', replace(replace('$vl_festa', '.', ''), ',', '.'), 
	 replace(replace('$vl_vela_medium', '.', ''), ',', '.'), replace(replace('$vl_vela_outros', '.', ''), ',', '.')) 
";
 // e($qFesta);
	$resultado = executa_sql($qFesta, "Festa incluído com sucesso");
	resultado();
	$id_editar_festa = "";
}

e("<form name=frm_festa_anual id=frm_festa_anual method=post action=$self >");
e("<input type=hidden name=op_menu value=6>");
if ($p_ano == "") { 
	$p_ano = date("Y");
}
$qAno = "select date_format(CURRENT_DATE(), '%Y'), date_format(CURRENT_DATE(), '%Y')
union
select date_format(CURRENT_DATE(), '%Y') -1, date_format(CURRENT_DATE(), '%Y') -1
union
select date_format(CURRENT_DATE(), '%Y') -2, date_format(CURRENT_DATE(), '%Y') -2";
e("<select name=p_ano>");
e(" <option value=>Ano</option>");	
e(processaSelect($qAno, $p_ano));
e("</select>");
e("<select name=p_festa>");
	e("<option value=>Festa</option>");
	$qFesta = "SELECT id, ds_festas FROM tab_festas order by 1";
	e(processaSelect($qFesta, $p_festa));		
e("</select>");
e("$spc$spc$spc");
e("<button type=submit>$ico_pesquisar</button>");
e("</form>");

?>

<form name=excluir_festa id=excluir_festa method=post action=<?=$self?> >
	<input type="hidden" name="opfesta" id="opfestaEx" value="E">
	<input type="hidden" name="op_menu" value="6">
	<input type="hidden" name="id_excluir_festa" id="id_excluir_festa" value="<?=$id_excluir_festa?>">
	<input type="hidden" name="p_ano" id="p_ano_ex" value="<?=$p_ano?>">
	<input type="hidden" name="p_festa" id="p_festa_ex" value="<?=$p_festa?>">
</form>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
	    <span class="close" onclick="fecharEdicao();"><?=$ico_fechar?></span>
			<span class="close" id=gravar onclick="gravar_festa_anual()"><?=$ico_gravar?></span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaofesta class=editor>
			<div class=tituloEdicao>Festa Anual</div><br>
			<form name=editar_festa id=editar_festa method=post action=<?=$self?> >
				<input type="hidden" name="p_ano" id="p_ano_ed" value="<?=$p_ano?>">
				<input type="hidden" name="p_festa" id="p_festa_ed" value="<?=$p_festa?>">
				<input type="hidden" name="opfesta" id="opfesta" value="<?=$opfesta?>">
				<input type="hidden" name="op_menu" id="op_menu" value="6">
				<input type="hidden" name="id_festa" id="id_festa" value="<?=$id_festa?>">
				<table width=100% cellspacing="5">
					<td width=50% valign=top style="border-right: 1px solid var(--branco); padding-left: 2px;">
						<select name=fk_tab_festas id=fk_tab_festas>
						<?php
							$qFesta = "SELECT id, ds_festas FROM tab_festas f order by fk_mes";
							e("<option value=>Festa</option>");
							e(processaSelect($qFesta, $fk_tab_festas));
						?>			
						</select>
						<br><br>
						<label>Ano <input type="text" name="nr_ano" id="nr_ano" inputmode="numeric" size=2 value="<?=date("Y");?>"></label><br><br>
						<label>Data <input type="date" name="dt_festa" id="dt_festa" size=5 value="<?=$dt_festa?>"></label><br><br>
						<label>Data Pagto <input type="date" name="dt_pagto" id="dt_pagto" value="<?=$dt_pagto?>"></label>
					</td>
					<td width=35%>
						<label>Valor Festa<input type="text" name="vl_festa" id="vl_festa" inputmode="numeric" size=5 onkeyup="formatarMoeda(this);"  value="<?=$vl_festa?>"></label>
						<br><br>
						<label>Valor Vela Médium<input type="text" name="vl_vela_medium" id="vl_vela_medium" inputmode="numeric" size=5 onkeyup="formatarMoeda(this);"  value="<?=$vl_vela_medium?>"></label>
						<br><br>
						<label>Valor Vela Outros<input type="text" name="vl_vela_outros" id="vl_vela_outros" inputmode="numeric" size=5 onkeyup="formatarMoeda(this);"  value="<?=$vl_vela_outros?>"></label>
						<br><br>
					</td>
				</table>
			</form>
		</div>
	</div>
</div>


<?php
if ($p_ano <> "") { // and $p_festa <> "") {
	$qFestaAnual = "
SELECT 	f.id, 
				t.ds_festas, 
				date_format(f.dt_festa, '%d/%m/%y'), 
				date_format(f.dt_pagto, '%d/%m/%y'), 
				f.vl_festa, 
				f.vl_vela_medium, 
				f.vl_vela_outros
FROM festa_anual f
inner join tab_festas t
on f.fk_tab_festas = t.id
WHERE f.nr_ano = $p_ano
and ('$p_festa' = '' or f.fk_tab_festas = '$p_festa')
order by 1";
// e($qFestaAnual);
		$b1 = new bd;
		$b1->prepara($qFestaAnual);
		$inicio = "";
		e("<table width=100% class=padrao>");
		$a = 0;
		$c = 0;
		$total = 0;
		$subtotal = 0;
		// e("<th align=center>ID</th>");
		e("<th align=center>Festa</th>");
		e("<th align=center>Dt</th>");
		e("<th align=center>Pagto</th>");
		e("<th align=center>R$</th>");
		e("<th align=center>Vela Méd</th>");
		e("<th align=center>Vela Out</th>");
		e("<th class=acao align=center><button onclick='incluir_festa_anual();'>$ico_incluir</button></th>");
		e("</tr>");
		while($row = $b1->consulta()){
			$linha = u8($row[0]);
			if ($inicio <> $linha) {
				if ($inicio <> "") { imprimir_array(); }
				$inicio = $linha;
				$a = 0;
				$subtotal = 0;
				$c++;
			}
			$linhas[$a] = $row;
			$a++;
			// echo $linhas[$a][1];
		}
		if ($c > 0) {
			imprimir_array();
		}
		$b1->libera();
		if ($c == 0) {
			e("<td colspan=6 align=center>Nenhum dado encontrado</td>");
		}
		e("</table>");
		
/*		
		e("<td></td>");
		e("");
*/		
}
desconectar();
?>