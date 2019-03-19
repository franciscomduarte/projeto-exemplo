<?php

spl_autoload_register(function ($class) {
    include '../../classes/'.$class .'.php';
});

include_once '../../config.php';
include_once '../../util/functions.php';

$chave=$argv[1];


if ($chave == "amFuYWluYVNBQlJJTkFkZVBBVUxBU0FtYW50aGFGT1M="){

  $objChecklist = new Checklist();
  $respostaChecklist = new RespostaChecklist();
  $cl = $objChecklist->listarAtivos();

    foreach ($cl as $checklist) {
        $enviaMensagem = false;
        $mensagem = "<b>Bundle . $checklist->sigla . não preenchido para o(s) paciente(s):</b>";
        $internacoes = $checklist->internacoes;
        foreach ($internacoes as $internacao) {
            $objChecklist = new Checklist();
            $bundles = $objChecklist->listarAtivasPorInternacao($internacao->id);
            foreach ($bundles as $bundle) {
                $statusPreenchimento = $respostaChecklist->verificarPreenchimento($internacao->id, $bundle->id);
                if ($checklist->id == $bundle->id) {
                    if($statusPreenchimento == null){
                        $enviaMensagem = true;
                        $mensagem .= $internacao->paciente->nome . "<br>";
                    }
                    
                }
            }
        }
        $telegram = new Telegram();
        if($enviaMensagem) {
            $telegram->enviaAlerta($mensagem);
        }
        
    }
}
?>
