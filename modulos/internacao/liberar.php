<?php 

	// dados da url
    $params = retornaParametrosUrl($_SERVER['QUERY_STRING']);
	$id_internacao = $params[2];
	$id_checklist = $params[3];

	#dados do formulario
	$internacao = new Internacao();
	$internacao->atualizarDataSaida($id_internacao, $id_checklist);
	redirecionar("/checklist-resposta/".$id_checklist);
?>