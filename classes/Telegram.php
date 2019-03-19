<?php
spl_autoload_register(function ($class) {
    include 'classes/'.$class .'.php';
});

class Telegram extends Base
{
    
    public function enviaAlerta($mensagem) {
        $url = URL_TELEGRAM . TOKEN_TELEGRAM . "/sendMessage?parse_mode=html&chat_id=" . CHAT_ID . "&text=" . $mensagem;
        file_get_contents($url);
    }
    
    public function inserir($obj)
    {}

    public function listar()
    {}

    public function editar($obj)
    {}

    public function listarPorId($id)
    {}
	
	
}
