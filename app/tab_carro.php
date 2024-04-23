<?php
if (!isset($id_tab)) { $id_tab = "" ; }
$tab_nome 		= "Carro";
$tituloPagina = "$tab_nome";
include_once("include.php");
$tab_qtd_colunas = 3;
$tab_div_colunas = 44;
if ($opTab == "Alterar" or $opTab == "Incluir") {
	$nm_carro = u8d($nm_carro);
	$ds_carro = u8d($ds_carro);
}
$tab_tabela = "app_carro";
$tab_colunas 			= array("Id", "Carro", "Descrição");
$tab_select 			= "select id_carro, nm_carro, ds_carro from $tab_tabela t order by 2";
$tab_insert 			= "insert into $tab_tabela (nm_carro, ds_carro) values ('$nm_carro', '$ds_carro')";
$tab_update 			= "update $tab_tabela set nm_carro = '$nm_carro', ds_carro = '$ds_carro' where id_carro = $id_tab";
$tab_delete 			= "delete from $tab_tabela where  id_carro = $id_tab";
$tab_tipo_dados = array("NÚMERO", "TEXTO", "TEXTO");
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qcarro = "select id_carro, nm_carro, ds_carro from $tab_tabela t where id_carro = $id_tab order by 2" ;
		$carro = pesquisa($qcarro);
		$id_carro = $carro[0];
		$nm_carro = u8($carro[1]);
		$ds_carro = u8($carro[2]);
		$opTab = "A";
	} else {
		$id_carro = "";
		$nm_carro = "";
		$ds_carro = "";
		$opTab = "I";
	}	
?>
	<label>Nome <input type=text name="nm_carro" id="nm_carro" size=70 value="<?=$nm_carro?>" ></label><br><br>
	<label>Descrição <input type=text name="ds_carro" id="ds_carro" size=100 value="<?=$ds_carro?>" ></label><br><br>
	<script>
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id_carro?>";
	</script>
<?php	
	die;
}
include_once("../include/frm_dados.php");
?>