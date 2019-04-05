<?php 
	
	include_once 'conexao.php';
	
	define ('ERROR', 'error');
	define ('SUCCESS', 'Success');

	function red($pagina) {
	    echo "<script>location.href='$pagina';</script>";
	}
	function redirecionar($pagina) {
	    echo "<html>";
	    echo "<head>";
	    echo "<meta http-equiv=\"refresh\" content=\"0.1;URL='$pagina\"'>";
        echo "</head>";
        echo "<body>";
        echo '<center>		
		<svg class="lds-dna" width="400px"  height="400px"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="background: none;"><circle cx="6.451612903225806" cy="63.6687" r="2.68025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-0.5s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="0s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-0.5s"></animate>
		</circle><circle cx="6.451612903225806" cy="36.3313" r="3.31975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.5s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-0.5s"></animate>
		</circle><circle cx="16.129032258064512" cy="52.4034" r="2.44025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-0.7s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-0.2s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-0.7s"></animate>
		</circle><circle cx="16.129032258064512" cy="47.5966" r="3.55975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.7s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.2s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-0.7s"></animate>
		</circle><circle cx="25.806451612903224" cy="39.2882" r="2.59975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-0.9s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-0.4s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-0.9s"></animate>
		</circle><circle cx="25.806451612903224" cy="60.7118" r="3.40025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.9s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.4s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-0.9s"></animate>
		</circle><circle cx="35.48387096774193" cy="32.946" r="2.83975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.1s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-0.6s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-1.1s"></animate>
		</circle><circle cx="35.48387096774193" cy="67.054" r="3.16025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-2.1s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.6s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-1.1s"></animate>
		</circle><circle cx="45.16129032258064" cy="32.2214" r="3.07975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.3s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-0.8s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-1.3s"></animate>
		</circle><circle cx="45.16129032258064" cy="67.7786" r="2.92025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-2.3s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.8s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-1.3s"></animate>
		</circle><circle cx="54.838709677419345" cy="36.3313" r="3.31975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.5s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-1.5s"></animate>
		</circle><circle cx="54.838709677419345" cy="63.6687" r="2.68025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-2.5s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-2s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-1.5s"></animate>
		</circle><circle cx="64.51612903225805" cy="47.5966" r="3.55975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.7s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.2s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-1.7s"></animate>
		</circle><circle cx="64.51612903225805" cy="52.4034" r="2.44025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-2.7s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-2.2s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-1.7s"></animate>
		</circle><circle cx="74.19354838709677" cy="60.7118" r="3.40025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-1.9s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.4s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-1.9s"></animate>
		</circle><circle cx="74.19354838709677" cy="39.2882" r="2.59975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-2.9s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-2.4s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-1.9s"></animate>
		</circle><circle cx="83.87096774193547" cy="67.054" r="3.16025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-2.1s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.6s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-2.1s"></animate>
		</circle><circle cx="83.87096774193547" cy="32.946" r="2.83975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-3.1s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-2.6s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-2.1s"></animate>
		</circle><circle cx="93.54838709677418" cy="67.7786" r="2.92025">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-2.3s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-1.8s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#dadbb7;#e5ee2f;#dadbb7" dur="2s" repeatCount="indefinite" begin="-2.3s"></animate>
		</circle><circle cx="93.54838709677418" cy="32.2214" r="3.07975">
		  <animate attributeName="r" times="0;0.5;1" values="2.4000000000000004;3.5999999999999996;2.4000000000000004" dur="2s" repeatCount="indefinite" begin="-3.3s"></animate>
		  <animate attributeName="cy" keyTimes="0;0.5;1" values="32;68;32" dur="2s" repeatCount="indefinite" begin="-2.8s" keySplines="0.5 0 0.5 1;0.5 0 0.5 1" calcMode="spline"></animate>
		  <animate attributeName="fill" keyTimes="0;0.5;1" values="#b3c430;#7d8f2c;#b3c430" dur="2s" repeatCount="indefinite" begin="-2.3s"></animate>
		</circle></svg>
    	</center>';
        echo "</body>";
        echo "</html>";
        exit;
	    #echo "<script>location.href='$pagina';</script>";
	}
	
	function aprensentaMensagem($tipo, $mensagem) {
		if($tipo == ERROR) {
			echo "<script> apresentaMensagemErro('$mensagem') </script>";
		} else if ($tipo == SUCCESS) {
			echo "<script> apresentaMensagemSucesso('$mensagem') </script>";
		}
	}
	
	function removeCaracteresCPF($cpf) {
	    return preg_replace( '/[^0-9]/is', '', $cpf );
	}
	
	function validaCPF($cpf) {
	    
	    // Extrai somente os números
	    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
	    
	    // Verifica se foi informado todos os digitos corretamente
	    if (strlen($cpf) != 11) {
	        return false;
	    }
	    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	    if (preg_match('/(\d)\1{10}/', $cpf)) {
	        return false;
	    }
	    // Faz o calculo para validar o CPF
	    for ($t = 9; $t < 11; $t++) {
	        for ($d = 0, $c = 0; $c < $t; $c++) {
	            $d += $cpf{$c} * (($t + 1) - $c);
	        }
	        $d = ((10 * $d) % 11) % 10;
	        if ($cpf{$c} != $d) {
	            return false;
	        }
	    }
	    return true;
    	}
    
    function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i ++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k ++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
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
	
	function formatarData($date,$mensal=false){
		$date = date_create($date);
		
		if (!$mensal){
		    $data_formatada = date_format($date, 'd/m/Y');
		}else{
		    $data_formatada = strftime('%b/%Y', strtotime(date_format($date, 'Y-m-d')));
		}
		return strtoupper($data_formatada);
	}

	function formatarDataHora($date){
	    if (isset($date)){
	       $date = date_create($date);
	       return date_format($date, 'd/m/Y H:i:s');
	    }
	}
	
	function dateEmMysql($dateSql){
	    $ano= substr($dateSql, 6);
	    $mes= substr($dateSql, 3,-5);
	    $dia= substr($dateSql, 0,-8);
	    return $ano."-".$mes."-".$dia;
	}
	
	function formataDataMysql($date){
		$date = date_create($date);
		return date_format($date, 'Y-m-d');
	}
	
	function diffDate($data, $data_atual) {
	    
	    $data       = str_replace("/", "-", $data);
	    $data_atual = str_replace("/", "-", $data_atual);
	    
	    if(strlen($data_atual) < 10)
	        $data_atual = "";
	    
	    $date_time  = new DateTime( $data_atual );
	    
	    $diff       = $date_time->diff( new DateTime( $data ) );
	    $result = $diff->format( '%a dia(s)' );
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
	    return $y>0 ? round($x*100/($x+$y),0) : 100;
	}
	
	function calculaPorcentagemTotal($x,$y) {
	    return $y>0 ? round(($y*100)/$x,1) : 0;
	}
	
	function tratarArray($arr) {
	    return substr($arr,0,strlen($arr)-1);
	}
	
	function isMobile() {
	   
    	$android = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"android");
    	$ipad = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"ipad");
    	$iphone = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"iphone");
    	$ipod = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"ipod");
	
    	if (($android === false) && ($ipad === false) && ($iphone === false) && ($ipod === false))
    	    return false;
    	else
    	    return true;
	}
	
	function isMobile2() {
	    $mobile = false;
	    $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric","Samsung");
	    foreach($user_agents as $user_agent){
	        if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== false) {
	            $mobile = true;
	            //$modelo = $user_agent;
	            break;
	        }
	    }
	    return $mobile ? true : false;
	}
	
    function isMobile3() {
        $tablet_browser = 0;
        $mobile_browser = 0;
        
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }
        
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }
        
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }
        
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');
        
        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }
        
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }
        
        return ($tablet_browser > 0 || $mobile_browser > 0); 
    }

    function formatarFiltro($filtro){
	$linha = explode("|",$filtro);
        $date  = date_create("01".$linha[1]);
        if($date) {
            return date_format($date, 'M/Y');
        }
     }

	
	
?>
