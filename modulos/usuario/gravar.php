<?php 

 	// Solucao de contorno para edição de usuários.
	if ($_SESSION["usuario"]["email"] == "fosbsb@gmail.com" || 
	    $_SESSION["usuario"]["email"] == "ericsoaresd@gmail.com" || 
	    $_SESSION["usuario"]["email"] == "olimpio@atenzi.com.br" || 
	    $_SESSION["usuario"]["email"] == "admin@enap.gov.br"){

		#dados do formulario
		$usuario = new Usuario();
		$usuario->chave 		= $_REQUEST['id'];
		$usuario->nome 			= strtoupper($_REQUEST['nome']);
		$usuario->email  		= $_REQUEST['email'];
		$usuario->senha 		= md5($_REQUEST['senha']);
		$usuario->ativo 		= $_REQUEST['ativo'];
		$usuario->perfil->id    = $_REQUEST['perfil'];
		$usuario->cpf 			= $_REQUEST['cpf'];
		$usuario->foto 			= isset($_REQUEST['foto']) ? $_REQUEST['foto'] : NULL;
		
		if(validaCPF($usuario->cpf)) {
			if($usuario->chave){
				$usuario->editar($usuario);
			} else {
				$usuario->inserir($usuario);
			}
			redirecionar("/usuario");
		}else{
			aprensentaMensagem(ERROR, "CPF inválido.");
		}
	}else{
		echo "Acesso Bloqueado...";
		exit();
	}
?>