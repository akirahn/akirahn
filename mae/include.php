<?php
	include_once("../include.php");
	if (!isset($menu_off)) { $menu_off = 0 ; }
	if ($menu_off == 0)  {
		include_once("menu.php");		
	}
?>