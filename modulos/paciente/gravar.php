<?php 

	#dados do formulario
    $cpf = 	$_REQUEST['cpf'];
    if(validaCPF($cpf)) {
        $paciente               = new Paciente();
        $paciente->id           = $_REQUEST['id_paciente'];
        $paciente->nome         = strtoupper($_REQUEST['nome']);
        $paciente->cpf          = removeCaracteresCPF($cpf);
        $paciente->nascimento   = dateEmMysql($_REQUEST['nascimento'] );
        $paciente->genero       = $_REQUEST['genero'];
        
        $convenio = new Convenio();
        //removido a pedido do Dr. Deixei comentado tanto aqui quanto na tela caso ele mude de ideia.
        //$paciente->registro     = $_REQUEST['registro'];
        //$paciente->convenio     = $convenio->listarPorId($_REQUEST['id_convenio']);
        $paciente->convenio     = $convenio->listarPorId(2);
        
        if($paciente->id){
            $paciente->editar($paciente);
    	} else {
    	    $paciente->inserir($paciente);
    	    $paciente->id = $paciente->retornaIdInserido();
    	}
    	
    	#dados do formulario de internacao
    	$internacao = new Internacao();
    	$internacao->id = $_REQUEST['id_internacao'];
    	//removido a pedido do Dr. Deixei comentado tanto aqui quanto na tela caso ele mude de ideia.
    	//$internacao->numero_internacao = $_REQUEST['numero_internacao'];
    	$internacao->data_internacao = dateEmMysql($_REQUEST['data_internacao']);
    	$internacao->setor->id = $_REQUEST['id_setor'];
    	$internacao->paciente->id = $paciente->id;
    	$internacao->convenio->id = 2;
    	$internacao->checklists = $_REQUEST['id_checklists'];
    	if($internacao->id){
    	   $internacao->editar($internacao);
    	} else {
    	    $internacao->inserir($internacao);
    	}
    	
    	redirecionar("/checklist-resposta");
    } else {
       aprensentaMensagem(ERROR, "CPF inválido.");
    }

?>