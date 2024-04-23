<?php
//===========================//
// BANCO DE DADOS
//===========================//

$conexao = "";
$bd = "";

//--------------------------------------------------------
function conectar() {
//--------------------------------------------------------
	global $conexao, $cfg_bd_sv, $cfg_bd_us, $cfg_bd_pw,$cfg_bd_nm;
	$conexao = new mysqli("$cfg_bd_sv","$cfg_bd_us","$cfg_bd_pw","$cfg_bd_nm");
	if ($conexao->connect_errno) {
		echo "Erro de conexão: " . $conexao->connect_error();
		exit();
	}
}
//--------------------------------------------------------
function desconectar() {
//--------------------------------------------------------
	global $conexao;
	$conexao->close();
}

//*************************************
class bd {
// classe banco de dados: formas de acesso ao banco de dados
//*************************************

  var $c;
  var $r;
	
  //-----------------------------------------
  function prepara($pSQL) {
	// envia o comando ou query sql ao banco para verificação de sintaxe
	//-----------------------------------------
    global $conexao;
    $this->c = $conexao->query("SET SQL_BIG_SELECTS=1");
    $this->c = $conexao->query($pSQL);
  }

  //-----------------------------------------
  function consulta() {
	// envia o comando ou query sql ao banco para verificação de sintaxe
	//-----------------------------------------
		return $this->c->fetch_array();
  }

  //-----------------------------------------
  function sql($pSQL, $mensagem="Dados gravados com sucesso!") {
	// executa o comando especificado no prepara
	//-----------------------------------------
    global $conexao, $ultimo_sql_id, $erro_sql;
		$this->c = $conexao->query($pSQL);
		$erro_sql = 0;
   	if (!$this->c) {
			$erro_sql = 1;
			$mensagem = "Erro: " . $conexao->error . "\n SQL: [$pSQL]";
		} else {
			$ultimo_sql_id = $conexao->insert_id;
		}
		return $mensagem;
  }

  //-----------------------------------------
  function libera() {
    // libera a área de memória usada pelo sql
    //-----------------------------------------
		$this->c->free_result();
  }
}

//--------------------------------------------------------
function preparaSQL($pSQL) {
//--------------------------------------------------------
	global $conexao, $bd;
	$bd = $conexao->query($pSQL);
}
//--------------------------------------------------------
function erroSQL($pMensagem="") {
//--------------------------------------------------------
	global $bd;
	if (!$bd) {
		echo "Erro: " . $conexao->error . "<br>$pMensagem";
	}
}
//--------------------------------------------------------
function executa_sql($pSQL, $mensagem="Dados gravados com sucesso!") {
//--------------------------------------------------------
	global $conexao, $bd;
	//echo $pSQL;
	$b = new bd;
	$resultado = $b->sql($pSQL, $mensagem);
	return $resultado;
}
//--------------------------------------------------------
function consultaSQL() {
//--------------------------------------------------------
	global $bd;
	return $bd->fetch_array();
}
//--------------------------------------------------------
function liberaSQL() {
//--------------------------------------------------------
	global $bd;
	$bd->free_result();
}

//-----------------------------------------
function pesquisa($q, $pItem = - 1) {
//-----------------------------------------
	$b = new bd;
	$b->prepara($q);
  $r = $b->consulta();
	$b->libera();
	return ($pItem < 0) ? $r : $r[$pItem];
}

//-----------------------------------------
function tag_select($q, $nome, $campo_obrigatorio, $opcoes = "", $valor_campo = "") {
// escreve o conteúdo de uma query retornando os dados numa tag <select>
// obs: usada na função campo (functions.inc)
//-----------------------------------------
  global $$nome, $desabilitado;
  $texto = "";
  if ($q == 1) {
    $texto = "<option></option>";
  } else {
    if ($q != "") {
			$texto = processaSelect($q, (empty($valor_campo) ? $$nome : $valor_campo));
    }
    if (empty($texto)) {
      $texto = "<option selected value=>Nenhum valor encontrado !</option>";
    } else {
      if (empty($campo_obrigatorio)) {
        $texto = "<option selected value=>Selecione a opção desejada</option>$texto";
      }
    }
  }
  if (!empty($desabilitado)) {
    $opcoes .= " disabled";
  }
  p("<select name=$nome id=$nome $opcoes $campo_obrigatorio>" . $texto . "</select>");
}

//-----------------------------------------
function processaSelect($q, $p_selected) {
//-----------------------------------------
	$b = new bd;
	$b->prepara($q);
  $texto = "";
	while($r = $b->consulta()){
		$u0 = u8($r[0]);
		$u1 = u8($r[1]);
    $texto .= "      <option " .
          ($u0 == $p_selected ? "selected" : "") .
          " value=\"$u0\">$u1</option>";
  }
	$b->libera();
  return $texto;
}

//-----------------------------------------
function processaSelectGrupo($q, $p_selected) {
//-----------------------------------------
	$b = new bd;
	$b->prepara($q);
  $texto = "";
  $g = "";
  $i = 0;
	while($r = $b->consulta()){
		$u0 = u8($r[0]);
		$u1 = u8($r[1]);
		$u2 = u8($r[2]);
		if ($g <> $u2) {
			if ($g <> "") {
				e("</optgroup>");
			}
			e("<optgroup label='$u2'>");
			$g = $u2;
			$i = 1;
		}
    e("      <option " .
          ($u0 == $p_selected ? "selected" : "") .
          " value=\"$u0\">$u1</option>");
  }
  if ($i == 1) {
		e("</optgroup>");
  }
	$b->libera();
  return $texto;
}

//-----------------------------------------
function processaRadio($q, $p_nome, $p_checked, $p_br="", $onchange="", $classe="") {
//-----------------------------------------
	$b = new bd;
	$b->prepara($q);
  $texto = "";
	$c = 0;
	if ($onchange <> "") {
		$onchange = " onchange=\"$onchange\" ";
	}
	if ($classe <> "") {
		$classe = " class=\"$classe\" ";
	}
	while($r = $b->consulta()){
		$u0 = u8($r[0]);
		$u1 = u8($r[1]);
    $texto .= "<input type=radio name=$p_nome $onchange id=rd$p_nome$c ".($u0 == $p_checked ? "checked" : "")." value=$u0><label $classe for=rd$p_nome$c>$u1</label>". ($p_br <> "" ? "<br><br>" : "");
		$c++;
  }
	$b->libera();
	if ($texto <> "") {
		$texto = "<div class=div_radio>$texto</div>";
	}
  return $texto;
}

//-----------------------------------------
function processaRadioGrupo($q, $p_nome, $p_checked, $p_br="") {
//-----------------------------------------
//SELECT tp_pagto, id,ds_forma_pagto FROM gst_tab_pagto g order by 1, 3
	$b = new bd;
	$b->prepara($q);
  $texto = "";
	$c = 0;
	$grupo = "";
	e("<table width=100%>");
	while($r = $b->consulta()){
		if ($grupo <> $r[0]) {
			if ($grupo <> "") {
				e("</td></tr>");				
			}
			e("<td><label>".u8($r[0])."</Label></td><td>");
			$grupo = $r[0];
		}
		$u0 = u8($r[1]);
		$u1 = u8($r[2]);
		e("<input type=radio name=$p_nome id=rd$p_nome$u0 ".($u0 == $p_checked ? "checked" : "")." value=$u0><label for=rd$p_nome$u0>$u1</label>");
		$c++;
  }
	$b->libera();
	if ($grupo <> "") {
		e("</td></tr>");
		// e("<td><label>".u8($grupo)."</Label></td><td>");
	}
	e("</table>");
}

//-----------------------------------------
function processaCheckBox($q, $p_nome, $p_checked="", $p_br="") {
//-----------------------------------------
	$b = new bd;
	$b->prepara($q);
  $texto = "";
	$c = 0;
	while($r = $b->consulta()){
		$u0 = u8($r[0]);
		$u1 = u8($r[1]);
		$nome = replace("$p_nome$u0", "[]");
    $texto .= "<input type=checkbox name=$p_nome id=$nome ".($u0 == $p_checked ? "checked" : "")." value=$u0><label for=$nome>$u1</label>". ($p_br <> "" ? "<br><br>" : "");
		$c++;
  }
	$b->libera();
  return $texto;
}

//-----------------------------------------
function my_nformat($p_variavel, $p_decimal = 2) {
//-----------------------------------------
	return "format($p_variavel, $p_decimal, 'de_DE')";
}

//-----------------------------------------
function preparaCaseDominio($p_nome, $p_dominio) {
//-----------------------------------------
	$v_qtd = count($p_dominio);
	$c = 0;
	$retorno = "";
	while($c < $v_qtd){
		$u0 = $p_dominio[$c];
		$c++;
		$u1 = u8d($p_dominio[$c]);
		$c++;
		$retorno .= "when $p_nome = '$u0' then '$u1'\n";
  }
	return $retorno . " else '' ";
}
//-----------------------------------------
function quem_insert($p_id_gasto, $p_quem) {
//-----------------------------------------
	global $resultado;
	if ($p_quem == "") {
		$resultado = "Quem não informado";
		$erro_sql = 1;
	} else {
		$qtd_tag = count($p_quem);
		$multi_quem = "";
		$erro_sql = 0;
		for($i=0;$i < $qtd_tag; $i++) {
			if (($p_quem[$i] <> "")) { 
				$multi_quem .= ($multi_quem == "" ? "" : ",") ."($p_id_gasto, $p_quem[$i])";
			}
		}
		if ($multi_quem <> "") {				
			$tab_quem_insert = "insert into gst_gastos_quem (fk_gasto, fk_quem) values $multi_quem";
			e($tab_quem_insert);
			$resultado = executa_sql($tab_quem_insert, "");
		} else {
			$erro_sql = 1;
			$resultado = "Quem não encontrado";
		}
	}
	resultado();
	return $erro_sql;
}	



?>