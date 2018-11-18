<?php 

	###################################################################
	## PARAMENTROS INTERNOS DO SISTEMA
	###################################################################
	define('NOME_SISTEMA', 'Banco Interno de Instrutores'); 
	define('SIGLA_SISTEMA', 'b2i'); 

	###################################################################
	## PARAMENTROS DO BANCO DE DADOS
	###################################################################
	define('HOST', 'localhost');
	define('DBNAME', 'exemplo');
	define('CHARSET', 'utf8');
	define('USER', 'root');
	define('PASSWORD', ''); 
	
// 	define('HOST', 'mysql.e2f.com.br');
// 	define('DBNAME', 'e2f10');
// 	define('CHARSET', 'utf8');
// 	define('USER', 'e2f10');
// 	define('PASSWORD', 'e2f12345678'); 
	
// 	define('HOST', '10.224.40.60');
// 	define('DBNAME', 'b2i');
// 	define('CHARSET', 'utf8');
// 	define('USER', 'b2i_user');
// 	define('PASSWORD', 'b2i_user'); 

	###################################################################
	## PERFIS FIXOS DO SISTEMA
	###################################################################
	
	define('ADMINISTRADOR', 1);
	define('SERVIDOR', 2);
	define('RECRUTADOR', 3);
	define('EXTERNO', 4);
	
?>