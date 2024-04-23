<center>

<div class="topnav" id="myTopnav">
  <a href="#home" class="active"><i class='fa fa-dollar'></i> Tesouraria CSN</a>
  <a href="#" style='float: right' onclick="window.close();"><?=$ico_fechar?></a>
<?php
	$qMenuSubGrupo = "select m.ds_menu, m.menu_grupo_id, g.ds_menu_grupo, m.pagina
from menu m
inner join menu_grupo g on g.id = m.menu_grupo_id
where 1 = 1
order by m.menu_grupo_id, m.nr_ordem";
	$bm = new bd;
	$bm->prepara($qMenuSubGrupo);
	$grupo = "";
	$c = 0;
	while($row_menu = $bm->consulta()){
		if ($grupo <> $row_menu[1]) {
			if ($c > 0) {
?>
    </div>
  </div>
<?php
			}
			$c++;
?>
  <div class="dropdown">
    <button class="dropbtn"><?=u8($row_menu[2])?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
<?php
			$grupo = $row_menu[1];
		}
    e("<a href='$row_menu[3].php'>".u8($row_menu[0])."</a>");
	}
?>	
    </div>
  </div>
  <a href="sair.php"><?=$ico_sair?> Sair</a>
  <a href="javascript:void(0);" class="icon" onclick="myNavMenu()"><?=$ico_menu?></a>
</div>
<h1 align=center><?=$tituloPagina?></h1>
<div id=Mensagem></div>
<br>
