﻿<div class="topnav" id="myTopnav">
  <a href="#home" class="active"><?=$apps["gst"]["app"]?></a>
  <a href="#" style='float: right' onclick="window.close();"><?=$ico_fechar?></a>
  <div class="dropdown">
		<label class="dropbtn" onclick="location.href='cad_financas.php'">Cadastro</label>
  </div>
	
<!--	
	<a href="gastos.php">Gasto</a>
  <div class="dropdown">
    <label for=mdd1 class="dropbtn">Cadastro
      <i class="fa fa-caret-down"></i>
    </label>
		<input class=menu_ck type=checkbox id=mdd1>
    <div class="dropdown-content">
      <a href="cad_carro.php">Carro</a>
			<a href="cad_gastos.php">Gastos</a>
			<a href="cad_series.php">Séries</a>
			<a href="cad_tarefa.php">Tarefas</a>
    </div>
  </div>
-->	
  <div class="dropdown">
    <label for=mdd2 class="dropbtn">Tabelas
      <i class="fa fa-caret-down"></i>
    </label>
		<input class=menu_ck type=checkbox id=mdd2>
    <div class="dropdown-content">
      <a href="tab_pagto.php">Pagto</a>
      <a href="tab_forma_pagto.php">Forma Pagto</a>
      <a href="tab_quem.php">Quem</a>
      <a href="tab_tag.php">Tag</a>
      <a href="tab_tipo.php">Tipo</a>
      <a href="tab_subtipo.php">SuperTipo</a>
    </div>
  </div>
  <div class="dropdown">
    <label for=mdd3 class="dropbtn">Relatório
      <i class="fa fa-caret-down"></i>
    </label>
		<input class=menu_ck type=checkbox id=mdd3>
    <div class="dropdown-content">
      <a href="rel_tipo_mensal.php">Tipo Mensal</a>
      <a href="rel_tipo_anual.php">Tipo Anual</a>
    </div>
  </div>
  <a href="javascript:void(0);" class="icon" onclick="myNavMenu()"><?=$ico_menu?></a>
</div>
<h1 align=center><?=$tituloPagina?></h1>
<div id=Mensagem></div>
<br>
