<?php 
	
	include_once 'conexao.php';
	
	define ('ERROR', 'error');
	define ('SUCCESS', 'Success');

	function redirecionar($pagina) {
		echo "<script>location.href='$pagina';</script>";
	}
	
	function aprensentaMensagem($tipo, $mensagem) {
		if($tipo == ERROR) {
			echo "<script> apresentaMensagemErro('$mensagem') </script>";
		} else if ($tipo == SUCCESS) {
			echo "<script> apresentaMensagemSucesso('$mensagem') </script>";
		}
	}
	
	function verificarPermissaoComId($url) {
		$urlSeparada = explode("{", $url);
		$usuario = $_SESSION['usuario'];
		
		$urlFormatada   = $urlSeparada[0];
		$id             = isset($urlSeparada[1]) ? $urlSeparada[1] : null;
		
		// Verifica se a URL necessita se montada com id_usuario 
		// Caso seja necessário outros ids, acrescentar outros ifs
		if ($id == 'id_usuario}') {
			$urlFormatada .= $usuario['id'];
		}
		return $urlFormatada;
	}
	
	function executarSql($sql) {
		$mysqli = Conexao::getInstance();
		$result = $mysqli->query($sql);
		if ($mysqli->errno) { 
			$mensagem = "MySQL error:". trim(addslashes($mysqli->errno)) .":". trim(addslashes($mysqli->error));
			aprensentaMensagem(ERROR, $mensagem);
			return $mysqli;
			//TODO criar rotina para salvar os erros sql numa tabela
// 			exit();
		}
		return $result;
	}
	
	function retornaConexao() {
	    
	    $mysqli = Conexao::getInstance();
	    return $mysqli;

	}
	
	function retornaId(){
		$mysqli = Conexao::getInstance();
		return $mysqli->insert_id;
	}
	
	function retornaParametrosUrl($r){
	    if (strpos($r, "&")){
	       $r = strstr($r, "&",true);
	    }
		return explode("/", $r);
	}
	
	function caculaProgresso($item, $total) {
		return ($item/$total)*100;
	}
	
	function formatarData($date){
		$date = date_create($date);
		return date_format($date, 'd/m/y');
	}

	function formatarDataHora($date){
	    if (isset($date)){
	       $date = date_create($date);
	       return date_format($date, 'd/m/Y H:i:s');
	    }
	}
	
	function formataDataMysql($date){
		$date = date_create($date);
		return date_format($date, 'Y-m-d');
	}
	
	function diffDate($data, $data_atual) {
	    
	    $date_time  = new DateTime( $data_atual );
	    $diff       = $date_time->diff( new DateTime( $data ) );
	    $result = $diff->format( '%d dia(s)' );
	    return $result;
	}
	
	function verificarProgresso($objeto){
		if ($objeto['progresso'] == NULL){
			echo 'active';
		}else{
			echo $objeto['progresso'] == 0 ? 'active' : '';
		}
	}
	
	function disableInput($disabled) {
	    if ($disabled)
	        echo "disabled='disabled'";
	}
	
	function mostrarAtivoInativo($status){
	    echo $status == '1' ? '<span class="label label-primary">Ativo</span>' : '<span class="label label-default">Inativo</span>';
	}

	function calculaPorcentagem($x,$y){
	    return $x*100/($x+$y);
	}
	
?>