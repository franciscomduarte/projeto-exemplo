<?php 

	#dados do formulario
    $convenio = new Convenio();
    $convenio->id   = $_REQUEST['id'];
    $convenio->nome = strtoupper($_REQUEST['nome']);
	
    if($convenio->id){
        $convenio->editar($convenio);
	} else {
	    $convenio->inserir($convenio);
	}
	redirecionar("/convenio");

?>