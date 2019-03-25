<?php

#######################################################################
## PARAMENTROS INTERNOS DO SISTEMA
#######################################################################
define('NOME_SISTEMA', 'Sistema de Checklist para UTIs');
define('SIGLA_SISTEMA', 'Bundle');
define('AMBIENTE','PROD');

########################################################################
## PARAMENTROS DO BANCO DE DADOS
########################################################################

$ip = getenv("REMOTE_ADDR");
if($ip == '127.0.0.1' && AMBIENTE == "DEV") {
    define('HOST', 'localhost');
    define('DBNAME', 'e2f10');
    define('CHARSET', 'utf8');
    define('USER', 'root');
    define('PASSWORD', '');
} else {
    define('HOST', 'mysql.e2f.com.br');
    define('DBNAME', 'e2f10');
    define('CHARSET', 'utf8');
    define('USER', 'e2f10');
    define('PASSWORD', 'e2f12345678');
}

########################################################################
## PERFIS FIXOS DO SISTEMA
########################################################################

define('ADMINISTRADOR', 1);
define('SERVIDOR', 2);
define('RECRUTADOR', 3);
define('EXTERNO', 4);

########################################################################
## PARAMETROS PARA DASHBOARD INICIAL
########################################################################
#define('FILTRO_INICIAL','1|2018-11-30');

########################################################################
## PARAMETROS TELEGRAM
########################################################################

// Quando precisar mudar de grupo, olhar isso
//https://github.com/pluginsGLPI/telegrambot/issues/18
//https://api.telegram.org/bot701546356:AAECQf4kMv71A74JFWsPGAcgaSXK3iCBeb4/getUpdates

define('CHAT_ID', '-1001483990900');
define('TOKEN_TELEGRAM', '701546356:AAECQf4kMv71A74JFWsPGAcgaSXK3iCBeb4');
define('URL_TELEGRAM', 'https://api.telegram.org/bot');



?>
