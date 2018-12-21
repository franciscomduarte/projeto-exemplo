<?php 

	#dados do formulario
    $cpf = 	$_REQUEST['cpf'];
    if(validaCPF($cpf)) {
        $paciente               = new Paciente();
        $paciente->id           = $_REQUEST['id'];
        $paciente->nome         = $_REQUEST['nome'];
        $paciente->cpf          = removeCaracteresCPF($cpf);
        $paciente->nascimento   = dateEmMysql($_REQUEST['nascimento'] );
        $paciente->genero    = $_REQUEST['genero'];
        $paciente->registro    = $_REQUEST['registro'];
        $convenio = new Convenio();
        $paciente->convenio     = $convenio->listarPorId($_REQUEST['id_convenio']);

        if($paciente->id){
            $paciente->editar($paciente);
    	} else {
    	    $paciente->inserir($paciente);
    	}
    	
    	redirecionar("/paciente");
    } else {
        aprensentaMensagem(ERROR, "CPF inválido.");
    }

?>