﻿<div class="topnav" id="myTopnav">
  <a href="#home" class="active"><?=$apps["rat"]["app"]?></a>
  <a href="#" style='float: right' onclick="window.close();"><?=$ico_fechar?></a>
  <div class="dropdown">
    <button class="dropbtn">Cadastro
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
			<a href="cad_rateio.php">Rateio</a>
      <a href="cad_parcela.php">Parcelas</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Tabelas
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="tab_tipo.php">Tipo</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Relatório
      <i class="fa fa-caret-down"></i>
    </button>
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
