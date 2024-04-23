<?php
	$menu_off = 1;
	include_once("../include/include_bd.php");
	$qMembro = "select m.nr_ordem, m.nm_membro, m.nm_apelido, m.tipo_membro_id, m.tipo_hierarquia_id, m.tipo_situacao_id,
	 m.email, m.nascimento,
	 m.fone_residencial, m.fone_comercial, m.celular, m.celular2,
	 m.endereco, m.bairro, m.cep, m.cidade, m.uf,
	 m.cpf, m.rg, m.orgaorg,
	 m.Pai, m.Mae, format(m.vl_mensalidade, 2, 'de_DE'), m.proxima_mensalidade, format(m.vl_prestacao, 2, 'de_DE'), m.proxima_prestacao, m.dt_ingresso
from membro m
where m.id = $id_membro";
	$membro = pesquisa($qMembro);
	$nr_ordem 						= $membro[0];
	$nm_membro 						= u8($membro[1]);
	$nm_apelido 					= u8($membro[2]);
	$tipo_membro_id 			= $membro[3];
	$tipo_hierarquia_id 	= $membro[4];
	$tipo_situacao_id 		= $membro[5];
	$email 								= $membro[6];
	$nascimento 					= $membro[7];
	$fone_residencial 		= $membro[8];
	$fone_comercial 			= $membro[9];
	$celular 							= $membro[10];
	$celular2 						= $membro[11];
	$endereco 						= u8($membro[12]);
	$bairro 							= u8($membro[13]);
	$cep 									= $membro[14];
	$cidade 							= u8($membro[15]);
	$uf 									= $membro[16];
	$cpf 									= $membro[17];
	$rg 									= $membro[18];
	$orgaorg 							= $membro[19];
	$Pai 									= u8($membro[20]);
	$Mae 									= u8($membro[21]);
	$vl_mensalidade 			= $membro[22];
	$proxima_mensalidade 	= substr($membro[23], 0, 7);
	$vl_prestacao 				= $membro[24];
	$proxima_prestacao 		= substr($membro[25], 0, 7);
	$dt_ingresso 					= ($membro[26]);
	$txt = ";" . 	$nr_ordem 						. ";".
	$nm_membro 						. ";".
	$nm_apelido 					. ";".
	$tipo_membro_id 			. ";".
	$tipo_hierarquia_id 	. ";".
	$tipo_situacao_id 		. ";".
	$email 								. ";".
	$nascimento 					. ";".
	$fone_residencial 		. ";".
	$fone_comercial 			. ";".
	$celular 							. ";".
	$celular2 						. ";".
	$endereco 						. ";".
	$bairro 							. ";".
	$cep 									. ";".
	$cidade 							. ";".
	$uf 									. ";".
	$cpf 									. ";".
	$rg 									. ";".
	$orgaorg 							. ";".
	$Pai 									. ";".
	$Mae 									. ";".
	$vl_mensalidade 			. ";".
	$proxima_mensalidade 	. ";".
	$vl_prestacao 				. ";".
	$proxima_prestacao 		. ";".
	$dt_ingresso 					. ";";
	e($txt);
?>