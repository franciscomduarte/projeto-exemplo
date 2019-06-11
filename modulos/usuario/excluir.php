<?php 
    
	// dados da url
    $params = retornaParametrosUrl($_SERVER['QUERY_STRING']);
	$id = $params[2];

	// Solucao de contorno para edição de usuários.
	if ($_SESSION["usuario"] != "Eric Soares Dias" || 
		$_SESSION["usuario"] != "Flaviano O. Silva" || 
		$_SESSION["usuario"] != "DR. ALEXANDRE OLIMPIO" || 
		$_SESSION["usuario"] != "Admin"){
			echo "Acesso Bloqueado...";
			exit();
	}

	#dados do formulario
	$usuario = new Usuario();
	$usuario->deletar($id);
	redirecionar("/usuario");
?>