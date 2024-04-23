﻿<?php
$tituloPagina = "Fluxo Mensal";
include_once("include.php");
?>
<script>
//--------------------------------------------------------------------------------------------------
// Funções
//--------------------------------------------------------------------------------------------------
	function editar_fluxo_mensal(p_id_fluxo) {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoFluxo");
		el("opFluxo").value = "A";
		el("id_fluxo").value = p_id_fluxo;
		var dados = $('#editar_fluxo').serialize();
		$.ajax({
				type : 'POST',
				dataType: 'TEXT',
				url  : "buscar_fluxo_mensal.php",
				data: dados,
				success :  function(data){
					valores = data.split(";");
					$('#dt_fluxo').val(valores[1]);
					$("#dt_competencia").val(valores[6]);
					selectPesquisaValor("fluxo_tipo_id", valores[2]);
					radioPesquisa("fluxo_movimento_id", valores[3]);
					$("#vl_fluxo").val(valores[4]);
					$("#membro_id").val(valores[5]);
					$("#obs").val(valores[7]);
				}
		});
	}
//--------------------------------------------------------------------------------------------------
	function incluir_fluxo_mensal() {
		mostra("telaEdicao");
		escondeElementoClasse("div", "editor");
		mostra("telaEdicaoFluxo");
		el("opFluxo").value = "I";
		el("id_fluxo").value = "";
		el("dt_fluxo").value = valorHoje();
		selectPesquisaValor("fluxo_tipo_id", "");
		radioSemValor("fluxo_movimento_id");
		el("vl_fluxo").value = "";
		el("membro_id").value = "";
		el("dt_competencia").value = mesHoje();
		el("obs").value = p_obs;
	}
//--------------------------------------------------------------------------------------------------
	function excluir_fluxo_mensal(pIndice) {
		el("id_excluir_fluxo").value = pIndice;
		el("excluir_fluxo").submit();
	}
//--------------------------------------------------------------------------------------------------
	function gravar_fluxo_mensal() {
		el("editar_fluxo").submit();
	}
</script>

<?php
/*
if (!isset($p_ano)) {	$p_ano = ""; }
if (!isset($p_mes)) {	$p_mes = ""; }
if (!isset($p_subfluxo)) {	$p_subfluxo = ""; }
if (!isset($opFluxo)) {	$opFluxo = ""; }

if (!isset($id_fluxo)) {	$id_fluxo = ""; }
if (!isset($membro_id)) {	$membro_id = ""; }
if (!isset($dt_fluxo)) {	$dt_fluxo = ""; }
if (!isset($dt_competencia)) {	$dt_competencia = ""; }
if (!isset($fluxo_movimento_id)) {	$fluxo_movimento_id = ""; }
if (!isset($fluxo_tipo_id)) {	$fluxo_tipo_id = ""; }
if (!isset($vl_fluxo)) {	$vl_fluxo = ""; }
if (!isset($obs)) {	$obs = ""; }
if (!isset($tp_regime)) {	$tp_regime = "X"; }
*/

//-----------------------------------------
function imprimir_array() {
//-----------------------------------------
global $linhas, $subtotal, $a, $ico_excluir, $ico_incluir, $ico_editar;
	for($i=0; $i < $a; $i++) {
		if ($i == 0) {
			$classe = ($subtotal < 0 ? "tipo_fluxo_negativo" : "tipo_fluxo");
			e("<th class=tipo_fluxo align=left colspan=3><b>".u8($linhas[$i][0])."</b></th>");
			e("<th class='$classe' align=right>".nformat($subtotal)."</th>");
			e("<th class=acao><button onclick=\"incluir_fluxo_mensal();\">$ico_incluir</button></th>");			
			e("</tr>");
		}
		e("<td align=center>".$linhas[$i][1]."</td>");
		e("<td align=center>".$linhas[$i][4]."</td>");
		$v = u8($linhas[$i][2]);
		// $v = substr($v, 0, 14);
		e("<td onclick='' align=left>$v</td>");
		$class_cd = ($linhas[$i][3] == "C" ? "positivo" : "negativo");
		e("<td align=right class=$class_cd>".nformat($linhas[$i][5])."</td>");
		//p_opFluxo, p_id_fluxo, p_dt_fluxo, p_fluxo_tipo_id, p_fluxo_movimento_id, p_vl_fluxo, p_membro_id, p_obs
		//f.id_fluxo, f.dt_fluxo, f.fluxo_tipo_id, f.fluxo_movimento_id, f.vl_fluxo, f.membro_id, f.dt_competencia, f.obs
		e("<td class=acao><button class=btn onclick=\"editar_fluxo_mensal(".$linhas[$i][9].");\" align=center>$ico_editar</button>");
		e("<button class=btn onclick=\"excluir_fluxo_mensal(".$linhas[$i][7].");\" align=center>$ico_excluir</button></td>");
		e("</tr>");
	}
}
//-----------------------------------------
function total() {
//-----------------------------------------
	global $subtotal, $spc;
	e("<th align=right colspan=2><b>Total$spc</b></th>");
	$classe = ($subtotal < 0 ? "negativo" : "positivo_total");
	e("<th align=right class=$classe><b>".nformat($subtotal)."</b></th>");
}
//-----------------------------------------
function total_geral() {
//-----------------------------------------
	global $total, $spc;
	e("<th align=right colspan=3><b>Total Mês$spc</b></th>");
	$classe = ($total < 0 ? "negativo" : "positivo_total");
	e("<th align=right class=$classe><b>".nformat($total)."</b></th>");
}
//-----------------------------------------
// PROGRAMA PRINCIPAL
//-----------------------------------------

if ($opFluxo == "E" and $id_excluir_fluxo <> "" ) {
	$qFluxo = "delete from fluxo where id_fluxo = $id_excluir_fluxo";
	$resultado = executa_sql($qFluxo, "Fluxo ($id_excluir_fluxo) excluido com sucesso");
	resultado();
	$id_excluir_fluxo = "";
}

if ($opFluxo == "A" and $id_fluxo <> "" ) {
	if ($membro_id == "") { $membro_id = "null"; }
	$obs = u8d($obs);
	$qFluxo = "update fluxo 
							set dt_fluxo = '$dt_fluxo', 
									fluxo_tipo_id = $fluxo_tipo_id, 
									fluxo_movimento_id = $fluxo_movimento_id, 
									vl_fluxo = replace(replace('$vl_fluxo', '.', ''), ',', '.'), 
									membro_id = $membro_id, 
									dt_competencia = '$dt_competencia-01',
									obs = '$obs'
							where id_fluxo = $id_fluxo";
	// e($qFluxo);
	$resultado = executa_sql($qFluxo, "Fluxo ($id_fluxo) alterado com sucesso");
	resultado();
	$id_editar_fluxo = "";
}

if ($opFluxo == "I" and $id_fluxo == "" ) {
	if ($membro_id == "") { $membro_id = "null"; }
	$obs = u8d($obs);
	$qFluxo = "
insert into fluxo 
	(dt_fluxo, vl_fluxo, fluxo_movimento_id, fluxo_tipo_id, dt_competencia, Obs) values 
 	('$dt_fluxo', replace(replace('$vl_fluxo', '.', ''), ',', '.'), $fluxo_movimento_id, $fluxo_tipo_id, '$dt_fluxo', '$obs') ";
 // e($qFluxo);
	$resultado = executa_sql($qFluxo, "Fluxo ($id_fluxo) incluído com sucesso");
	resultado();
	$id_editar_fluxo = "";
}

e("<form name=frm_fluxo_mensal id=frm_fluxo_mensal method=post action=$self >");
e("<input type=hidden name=op_menu value=6><div align=center class=bloco_pesquisa><div>");
if ($p_ano == "") { $p_ano = date("Y"); }
if ($p_mes == "") { $p_mes = date("m"); }
if ($p_subfluxo == "") { $p_subfluxo = 99; }
botao_mes_ano(-1);
campo_select_ano("p_ano");
campo_select_mes("p_mes");
botao_mes_ano(1);
e("</div><div>");
// e("<br><br>");
montaRadio($dom_caixa_comp, "tp_regime", $tp_regime, "", "el('frm_fluxo_mensal').submit()");
e("</div><div>");
// e("<br><br>");
e("<select name=p_subfluxo onchange=\"el('frm_fluxo_mensal').submit()\" >");
	//e("<option value=>Tipo</option>");
	e("<option ".($p_subfluxo == 99 ? "selected" : "")." value=99>Todos</option>");
	$qSubFluxo = "SELECT id, ds_fluxo_tipo FROM fluxo_tipo f order by 2";
	e(processaSelect($qSubFluxo, $p_subfluxo));		
e("</select>");
e("<button type=submit>$ico_pesquisar</button></div></div>");
e("</form>");
?>

<form name=excluir_fluxo id=excluir_fluxo method=post action=<?=$self?> >
	<input type="hidden" name="opFluxo" id="opFluxoEx" value="E">
	<input type="hidden" name="op_menu" value="6">
	<input type="hidden" name="id_excluir_fluxo" id="id_excluir_fluxo" value="<?=$id_excluir_fluxo?>">
	<input type="hidden" name="p_ano" id="p_ano_ex" value="<?=$p_ano?>">
	<input type="hidden" name="p_mes" id="p_mes_ex" value="<?=$p_mes?>">
	<input type="hidden" name="p_subfluxo" id="p_subfluxo_ex" value="<?=$p_subfluxo?>">
</form>

<div id="telaEdicao" class="modal">
  <div class="modal-content">
  	<center>
			<div class=tituloEdicao>Fluxo de Caixa</div>
	    <span class="close" onclick="fecharEdicao();"><?=$ico_fechar?></span>
			<span class="close" id=gravar onclick="gravar_fluxo_mensal()"><?=$ico_gravar?></span>
    </center>
		<br>
		<br>
		<br>
		<div id=telaEdicaoFluxo class=editor>
			<form name=editar_fluxo id=editar_fluxo method=post action=<?=$self?> >
				<input type="hidden" name="p_ano" id="p_ano_ed" value="<?=$p_ano?>">
				<input type="hidden" name="p_mes" id="p_mes_ed" value="<?=$p_mes?>">
				<input type="hidden" name="p_subfluxo" id="p_subfluxo_ed" value="<?=$p_subfluxo?>">
				<input type="hidden" name="opFluxo" id="opFluxo" value="<?=$opFluxo?>">
				<input type="hidden" name="op_menu" id="op_menu" value="6">
				<input type="hidden" name="id_fluxo" id="id_fluxo" value="<?=$id_fluxo?>">
				<input type="hidden" name="membro_id" id="membro_id" value="<?=$membro_id?>">
				<table width=100% cellspacing="5">
					<td width=50% valign=top style="border-right: 1px solid var(--branco); padding-left: 2px;">
						<label>Data <input type="date" name="dt_fluxo" id="dt_fluxo" size=5 value="<?=$dt_fluxo?>"></label>
						<br><br>
						<?php
						// <div class=div_radio>
							$qFluxoMovimento = "SELECT id, ds_fluxo_movimento FROM fluxo_movimento f order by 1";
							// if ($fluxo_movimento_id == "") { $fluxo_movimento_id = 1; }
							e(processaRadio($qFluxoMovimento, "fluxo_movimento_id", $fluxo_movimento_id));
						// </div>
						?>			
						<br><br>
						<label>Competência <input type="month" name="dt_competencia" id="dt_competencia" value="<?=$dt_competencia?>"></label>
					</td>
					<td width=35%>
						<select name=fluxo_tipo_id id=fluxo_tipo_id>
			<?php
				$qFluxoTipo = "SELECT id, ds_fluxo_tipo FROM fluxo_tipo f order by 2";
				e(processaSelect($qFluxoTipo, $fluxo_tipo_id));
			?>			
						</select>
						<br><br>
						<label>Valor <input type="text" name="vl_fluxo" id="vl_fluxo" inputmode="numeric" size=5 onkeyup="formatarMoeda(this);"  value="<?=$vl_fluxo?>"></label>
						<br><br>
						<label>Obs:  <input type="text" name="obs" id="obs" size=13  value="<?=$obs?>"></label>
						<br><br>
					</td>
				</table>
			</form>
		</div>
	</div>
</div>


<?php
if ($p_ano <> "" and $p_mes <> "" and $p_subfluxo <> "") {
	$dt_tipo = ($tp_regime == "X" ? "f.dt_fluxo" : "f.dt_competencia");
	$qMensal = "
SELECT 	t.ds_fluxo_tipo, 
				date_format(f.dt_fluxo, '%d/%m/%Y'), 
				coalesce(m.nm_apelido, obs), 
				mv.simbolo, 
				date_format(dt_competencia, '%m/%Y'), 
				vl_fluxo, 
				m.id, 
				f.id_fluxo, 
				t.tp_fluxo_tipo,
				f.id_fluxo, 
				f.dt_fluxo, 
				f.fluxo_tipo_id, 
				f.fluxo_movimento_id, 
				replace(f.vl_fluxo, '.', ','), 
				f.membro_id, 
				date_format(f.dt_competencia, '%Y-%m'), 
				f.obs
FROM fluxo f
inner join fluxo_tipo t
on f.fluxo_tipo_id = t.id
inner join fluxo_movimento mv
on f.fluxo_movimento_id = mv.id
left join membro m
on f.membro_id = m.id
WHERE DATE_FORMAT($dt_tipo,'%Y') = $p_ano
and   DATE_FORMAT($dt_tipo,'%m') = $p_mes
and   ($p_subfluxo = 99 or t.id = $p_subfluxo)
and   t.id not in (13, 14)
order by 1, $dt_tipo, 3";
// e($qMensal);
		$b1 = new bd;
		$b1->prepara($qMensal);
		$inicio = "";
		e("<table width=100% class=padrao>");
		$a = 0;
		$c = 0;
		$total = 0;
		$subtotal = 0;
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
			if ($linhas[$a][3] ==  "C") {
				$subtotal += $linhas[$a][5];
				$total += $linhas[$a][5];
			} else {
				$subtotal -= $linhas[$a][5];
				$total -= $linhas[$a][5];
			}
			$a++;
			// echo $linhas[$a][1];
		}
		if ($c > 0) {
			imprimir_array();
		}
		$b1->libera();
		if ($c == 0) {
			e("<td colspan=5 align=center>Nenhum dado encontrado</td>");
		} else {
			total_geral();
		}
		e("</table>");
		
/*		
		e("<td></td>");
		e("");
*/		
}
desconectar();
?>