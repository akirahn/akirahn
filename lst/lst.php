﻿<?php
	function gera_chave() {
		$qCfg = "select ds_config from tab_cfg where id = 1";
		$chave_bd = pesquisa($qCfg, 0);
		$chave = "SKC8e?81nZ&kdE?C$chave_bd";
		return $chave;
	}
	function prepara_lista($p_coluna, $p_tipo = 0) {
		$chave = gera_chave();
		$algoritmo = "aes-256-cfb8";
		$iv = "qX/p9vQg<$(PsJKWhqF8_cRL+c.?_!k-/A'!si\d^[H$#egS$";
		if ($p_tipo == 1) {
			$mensagem = openssl_encrypt($p_coluna, $algoritmo, $chave, NULL, $iv);
		} else {
			$mensagem = openssl_decrypt($p_coluna, $algoritmo, $chave,NULL, $iv);
		}
		return $mensagem;
	}
	function prepara_coluna($p_coluna, $p_tipo = 0) {
		$chave = gera_chave();
		if ($p_tipo == 1) {
			$v_coluna = "TO_BASE64(AES_ENCRYPT('$p_coluna', '$chave'))";
		} else {
			$v_coluna = "AES_DECRYPT(FROM_BASE64($p_coluna), '$chave')";
		}
		return $v_coluna;
	}
?>
