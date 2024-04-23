<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
?>

<script>
//--------------------------------------------------------------------------------------------------
// Fun��es
//--------------------------------------------------------------------------------------------------
	function modalGravar() {
		$("#tipo_modal").val(1);
		gravarModalEdicao("frm_cad_parcelas", "<?=$dirApp?>frm_parcelas.php");
	}	
//--------------------------------------------------------------------------------------------------
	function carrega_subtipo_radio(p_tipo, p_sub) {
		var qtd_as = ar_subtipo[p_tipo].length;
		var str_subtipo = "";
		var tem = -1;
		for(i = 0; i < qtd_as; i++) {
			if (p_sub != "" &p_sub == ar_subtipo[p_tipo][i][0]) {
				tem = i;
			}
			str_subtipo += "<input type=radio name=fk_subtipo id=fk_subtipo"+i+" value="+ar_subtipo[p_tipo][i][0]+" ><label for='fk_subtipo"+i+"'>"+ar_subtipo[p_tipo][i][1]+"</label>";
		}
		if (str_subtipo != "") {
			$('#fk_subtipo').html(str_subtipo);
		}
		if (tem != -1) {
			$("#fk_subtipo"+tem).prop( "checked", true );			
		}
	}
//--------------------------------------------------------------------------------------------------
	tituloModalEdicao("Parcelas");
</script>

<?php
	if ($p_opcao == "IM" and $seleciona <> "" and $p_edicao_id <> "") {
		$qtdSeleciona = count($seleciona);
		$vInsertMembro = "insert into rat_membro (fk_rateio, fk_membro) values ";
		$vInsertMultiplo = "";
		for($s = 0; $s < $qtdSeleciona; $s++) {
			if ($seleciona[$s] <> "") {
				$vInsertMultiplo .= " ($p_edicao_id, ".$seleciona[$s]."),";
			}
		}
		if ($vInsertMultiplo <> "") {
			$vInsertMultiplo = exclui_ultimo_car($vInsertMultiplo) . ";";
			$vInsertMembro .= $vInsertMultiplo;
	 // e($vInsertMembro);
			$erro_sql = 0;
			$resultado = executa_sql($vInsertMembro, "");
		} else {
			$erro_sql = 1;
			$resultado = "Membros n�o encontrados";
		}
		resultado();
		return $erro_sql;
	}
	
	$qBaseMembros = "from rat_membro rm where rm.fk_rateio = $p_edicao_id";
	$qMembro = "select id, nm_apelido from membro m where m.tipo_situacao_id in (1,3) and sn_emprestimo = 'S' ";
	$qQtdMembros = "select coalesce(count(*), 0) $qBaseMembros";
	$qtdMembros = pesquisa($qQtdMembros, 0);
	if ($qtdMembros == 0) {
		$qMembroParcela = "$qMembro order by 2";
	} else {
		$qMembroParcela = "$qMembro and m.id exists in (select null $qBaseMembros and rm.fk_membro = m.id) order by 2";
	}
	e($qMembroParcela);
	$b = new bd;
	$b->prepara($qMembroParcela);
	$inicio = "";
	e("<table cellspacing=0>");
	$a = 0;
	$c = 0;
	$subtotal = 0;
	$total = 0;
	e("<form name=frm_cad_parcelas id=frm_cad_parcelas>");
		campo_hidden("p_edicao_id", $p_edicao_id);
	while($row = $b->consulta()){
		if ($qtdMembros == 0) {
			if ($c == 0) {
				campo_hidden("p_opcao", "IM");
			}
			e("<td>");
				campo_checkbox("seleciona[]", $row[0], u8($row[1]), "", "seleciona$c");
			e("<td>");
			if ($c % 2 <> 0) { if ($c <> 0) { e("</tr>");	} }
		} else {
			$qBaseParcelas = "from rat_parcela p where exists (select null $qBaseMembros and p.fk_rat_membro = rm.id ";
			if ($c == 0) {
				e("<th>Nome<th>");
				e("<th><th>");
				e("");
				e("</tr>");
				$qCountParcelas = "select coalesce(count(*), 0) $qBaseParcelas)";
				$countParcelas = pesquisa($qCountParcelas);
				if ($countParcelas == "") {
					campo_hidden("p_opcao", "IP");
				} else {
					campo_hidden("p_opcao", "AP");					
				}
			}
			$qParcelas = "select vl_parcela, nr_parcela, dt_vencimento $qBaseParcelas  and rm.fk_membro = $row[0])";
			$parcelas = pesquisa($qParcelas);
			e("<td>".u8($row[1]) ."<td>");
			if ($parcelas == "") {
				e("<td>". "<td>");
				
			} else {
				e("<td>". "<td>");
				
			}
			e("");
			e("</tr>");
		}
		$c++;
	}
	if ($c > 0) {
		e("</table>");
	}
	enl();
	enl();
	e("</form>");
	$b->libera();
?>

