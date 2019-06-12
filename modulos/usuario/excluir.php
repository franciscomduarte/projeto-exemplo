<?php 
    
	// dados da url
    $params = retornaParametrosUrl($_SERVER['QUERY_STRING']);
	$id = $params[2];

	// Solucao de contorno para edição de usuários.
	if ($_SESSION["usuario"]["email"] == "fosbsb@gmail.com" || 
	    $_SESSION["usuario"]["email"] == "ericsoaresd@gmail.com" || 
	    $_SESSION["usuario"]["email"] == "olimpio@atenzi.com.br" || 
	    $_SESSION["usuario"]["email"] == "admin@enap.gov.br"){

	#dados do formulario
	$usuario = new Usuario();
	$usuario->deletar($id);
	redirecionar("/usuario");

	}else{
		echo "Acesso Bloqueado...";
		exit();
	}
?>