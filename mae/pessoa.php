<?php
if (!isset($id_tab)) { $id_tab = "" ; }
if (!isset($sn_ativo)) { $sn_ativo = "" ; }
if (!isset($sn_cartao)) { $sn_cartao = "" ; }
$tab_nome 				= "Pessoa";
$tituloPagina = "Tabela $tab_nome";
include_once("include.php");
$tab_qtd_colunas = 4;
$tab_div_colunas = 16;
$tab_colunas 			= array("Id", "Nome", "Ativo", "Cartão");
$tab_select 			= "select id_pessoa, nm_pessoa, if(sn_ativo=1, 'X', ''), if(sn_cartao=1, 'X', '') from mae_pessoa t order by 2, 3";
$tab_insert 			= "insert into mae_pessoa (nm_pessoa, sn_ativo, sn_cartao) values ('".u8d($nm_pessoa)."', $sn_ativo, $sn_cartao)";
$tab_update 			= "update mae_pessoa set nm_pessoa = '".u8d($nm_pessoa)."', sn_ativo = $sn_ativo , sn_cartao = $sn_cartao where id_pessoa = $id_tab";
$tab_delete 			= "delete from mae_pessoa where  id_pessoa = $id_tab";
if (($opTab == "Alterar" and $id_tab <> "") or ($opTab == "Incluir" and $id_tab == "")) {
	if ($id_tab <> "") {
		$qPessoa = "select id_pessoa, nm_pessoa, sn_ativo, sn_cartao from mae_pessoa t where id_pessoa = $id_tab order by 2, 3" ;
		$pessoa = pesquisa($qPessoa);
		$id_pessoa = $pessoa[0];
		$nm_pessoa = $pessoa[1];
		$sn_ativo  = $pessoa[2];
		$sn_cartao = $pessoa[3];
		$opTab = "A";
	} else {
		$id_pessoa = "";
		$nm_pessoa = "";
		$sn_ativo  = 1;
		$sn_cartao = 0;
		$opTab = "I";
	}	
?>
	<label>Descrição <input type="text" name="nm_pessoa" id="nm_pessoa" size=30 value="<?=$nm_pessoa?>"></label>
	<br><br>Ativo<div class=div_radio>
	<input type=radio name=sn_ativo id=sn_ativo_s <?php e($sn_ativo == 1 ? "checked" : ""); ?> value=1><label for=sn_ativo_s>Sim</label>
	<input type=radio name=sn_ativo id=sn_ativo_n <?php e($sn_ativo == 0 ? "checked" : ""); ?> value=0><label for=sn_ativo_n>Não</label>
	</div><br><br>Dono do Cartão<div class=div_radio>
	<input type=radio name=sn_cartao id=sn_cartao_s <?php e($sn_cartao == 1 ? "checked" : ""); ?> value=1><label for=sn_cartao_s>Sim</label>
	<input type=radio name=sn_cartao id=sn_cartao_n <?php e($sn_cartao == 0 ? "checked" : ""); ?> value=0><label for=sn_cartao_n>Não</label>
	</div>
	<script>
		el("menu_off").value = 0;
		el("opTab").value = "<?=$opTab?>";
		el("id_tab").value = "<?=$id_pessoa?>";
	</script>
<?php	
	die;
}
include_once("frm_dados.php");
?>