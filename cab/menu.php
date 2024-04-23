<?php
?>	
<div class="topnav" id="myTopnav">
  <a href="#home" class="active"><?=$apps["cab"]["app"]?></a>
  <a href="#" style='float: right' onclick="window.close();"><?=$ico_fechar?></a>
	<a href="cad_cab_episodio.php">Episódio</a>
	<a href="tab_remedio.php">Remédio</a>
	<a href="rel_cabeca.php">Relatório</a>
	<a href="rel_cabeca25.php">Relatório 25</a>
<!--	
  <div class="dropdown">
    <button class="dropbtn">Tabelas
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="tab_gasto.php">Gasto</a>
    </div>
  </div>
-->
  <a href="javascript:void(0);" class="icon" onclick="myNavMenu()"><?=$ico_menu?></a>
</div>
<h1 align=center><?=$tituloPagina?></h1>
<div id=Mensagem></div>
<br>
