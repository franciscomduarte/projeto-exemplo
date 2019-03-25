<?php

class Dashboard{
    
    public $total;
    public $total_internados;
    public $grafico_barras_inicial;
    public $filtro_grafico_checklist;
        
    function __construct() {
        $sql = "SELECT TABLE_NAME, TABLE_ROWS 
                FROM INFORMATION_SCHEMA.TABLES 
                WHERE TABLE_SCHEMA = '".DBNAME."' ";
        
        $query = executarSql($sql);
        $this->array = $query->fetch_all(MYSQLI_ASSOC);
            
        $this->total  = [];
        
        foreach ($this->array as $linha) {
            $key   = $linha['TABLE_NAME'];
            $value = $linha['TABLE_ROWS'];
            
            $this->total += [$key => $value];
        }
        
    }    
    
    public function __get($valor){
        return $this->$valor;
    }
 
    public function getDashboardInternados($setor=NULL) {
        if($setor != NULL){
           $sqlsetor = "and setor=$setor";
        }
        
        $sql = "select (SELECT COUNT(*) FROM internacao WHERE 1=1 $sqlsetor) as total,
                       (SELECT COUNT(*) FROM internacao i, internacao_checklist ic WHERE i.id = ic.id_internacao $sqlsetor) as dispensado,
	                   (SELECT COUNT(*) FROM internacao i, internacao_checklist ic WHERE i.id = ic.id_internacao $sqlsetor) as internado";  
        
        $query = executarSql($sql);
        $this->array = $query->fetch_all(MYSQLI_ASSOC);
        $this->total_internados   = $this->array[0];
            
    }
    
    public function getDashboardRespostasCheckListPorDia($setor=NULL){
        
        if ($setor==NULL){
            $sql = "select c.id, date_format(r.data_resposta,'%d/%m') as data_resposta, c.nome, c.meta,
                    count(*) as total_respondido,
                    (select count(*) from internacao i, internacao_checklist ic where i.id = ic.id_internacao and (ic.data_saida is null or ic.data_saida <= r.data_resposta)) as total_esperado
                    from resposta_checklist r, checklist c
                    where c.id = r.id_checklist
                    group by c.id, date_format(r.data_resposta,'%Y-%m-%d')";
        }else{
            $sql = "select c.id, date_format(r.data_resposta,'%d/%m') as data_resposta, c.nome, c.meta, count(*) as total_respondido,
                    (select count(*) from internacao i, internacao_checklist ic where i.id = ic.id_internacao and (data_saida is null or data_saida <= r.data_resposta) and id_setor='$setor') as total_esperado
                    from resposta_checklist r, checklist c, internacao i
                    where c.id = r.id_checklist
                    and   r.id_internacao = i.id
                    and   i.id_setor = '$setor'  
                    group by c.id, date_format(r.data_resposta,'%Y-%m-%d')";
        }
        
        $query = executarSql($sql);
        
        $this->array = $query->fetch_all(MYSQLI_ASSOC);
        
        $array_dias = [];
        $array_respondidos = [];
        $array_esperados = [];
        
        $soma_total_respondido = 0;
        $soma_total_esperados  = 0;
        $soma_total_metas      = 0;
        $maior_valor           = 0;
        
        foreach ($this->array as $linha){
            $array_dias[]        = $linha['data_resposta'];
            $array_respondidos[] = $linha['total_respondido'];
            $array_esperados[]   = $linha['total_esperado'];
            
            $soma_total_respondido += $linha['total_respondido'];
            $soma_total_esperados  += $linha['total_esperado'];
            $soma_total_metas      += $linha['meta'];
            
            if ($maior_valor < $linha['total_esperado'])
                $maior_valor   = $linha['total_esperado'];
        }
       
        $porcentagem_resposta = $soma_total_esperados > 0 ? round(($soma_total_respondido*100)/$soma_total_esperados) : 0;
        $porcentagem_meta     = sizeof($array_dias)   > 0 ? $soma_total_metas/sizeof($array_dias) : 0;
        
        $this->grafico_barras_inicial = 
                array(
                    "dias"                  => '"'.implode('","',$array_dias).'"',
                    "previstos"             => implode(',',$array_esperados),
                    "respondidos"           => implode(',',$array_respondidos),
                    "meta_calculada"        => $porcentagem_meta,
                    "porcetagem_resposta"   => $porcentagem_resposta,
                    "maior_valor_grafico"   => round($maior_valor*1.25)
                );
    }
    
    public function getDashboarFiltroPorChecklist($id_cheklist=NULL,$id_setor=NULL,$mensal=false){
        
        
        if(!$mensal){
            $sql = "select r.id, date_format(r.data_resposta,'%Y-%m-%d') as data_resposta,
                	   c.sigla, r.id_checklist
                from   resposta_checklist r, internacao i, checklist c
                where  i.id = r.id_internacao
                and    c.id = r.id_checklist
                group by date_format(r.data_resposta,'%Y-%m-%d'), c.sigla
                order by r.data_resposta desc";
        }else{
            $sql = "select r.id, date_format(r.data_resposta,'%Y-%m') as data_resposta,
                	   c.sigla, r.id_checklist
                from   resposta_checklist r, internacao i, checklist c
                where  i.id = r.id_internacao
                and    c.id = r.id_checklist
                group by date_format(r.data_resposta,'%Y-%m'), c.sigla
                order by r.data_resposta desc";
        }
        
        if (isset($id_cheklist) && isset($id_setor)){
            
            if(!$mensal){
                $sql = "select r.id, date_format(r.data_resposta,'%Y-%m-%d') as data_resposta,
                    	   c.sigla, r.id_checklist
                    from   resposta_checklist r, internacao i, checklist c
                    where  i.id = r.id_internacao
                    and    c.id = r.id_checklist
                    and    c.id = '".$id_cheklist."' 
                    and    i.id_setor = '".$id_setor."' 
                    group by date_format(r.data_resposta,'%Y-%m-%d') , c.sigla
                    order by r.data_resposta desc";
            }else{
                $sql = "select r.id, date_format(r.data_resposta,'%Y-%m') as data_resposta,
                    	   c.sigla, r.id_checklist
                    from   resposta_checklist r, internacao i, checklist c
                    where  i.id = r.id_internacao
                    and    c.id = r.id_checklist
                    and    c.id = '".$id_cheklist."'
                    and    i.id_setor = '".$id_setor."'
                    group by date_format(r.data_resposta,'%Y-%m'), c.sigla
                    order by r.data_resposta desc";
            }
        }
        
        $query = executarSql($sql);
        
        $array_filtro = [];
        
        foreach ($query->fetch_all(MYSQLI_ASSOC) as $linha){
            $array_filtro[] = array("id_checklist"  => $linha['id_checklist'],
                                    "data_resposta" => $linha['data_resposta'],
                                    "sigla"         => $linha['sigla'],
                                    "label"         => $linha['sigla']." # ".formatarData($linha['data_resposta'],$mensal)
                             );   
        }
        return $array_filtro;
    }
    
    public function definirDataFiltroCheckListInicial($filtro=NULL,$mensal=false){
        
        if(!$mensal){
            $sql = "select r.id, date_format(r.data_resposta,'%Y-%m-%d') as data_resposta,
            	    c.sigla, r.id_checklist, count(*) as total_respostas
                    from resposta_checklist r, checklist c
                    where r.id_checklist = c.id
                    group by  date_format(r.data_resposta,'%Y-%m-%d'), r.id_checklist
                    order by id desc limit 1";
        }else{
            $sql = "select r.id, date_format(r.data_resposta,'%Y-%m') as data_resposta,
            	    c.sigla, r.id_checklist, count(*) as total_respostas
                    from resposta_checklist r, checklist c
                    where r.id_checklist = c.id
                    group by  date_format(r.data_resposta,'%Y-%m'), r.id_checklist
                    order by id desc limit 1";
        }
        
        $query = executarSql($sql);
        
        foreach ($query->fetch_all(MYSQLI_ASSOC) as $linha){
           $filtro_retorno = $linha['id_checklist']."|".$linha['data_resposta'];
        }
        define('FILTRO_INICIAL', $filtro_retorno);
    }
    
    public function getNumeroPacientesCkecklistMes($filtro, $id_setor=null){
        $lista        = explode("|", $filtro);
        $id_checklist = $lista[0];
        $data_internacao = $lista[1];
        
        if ($id_setor!=null){
            $condicao = " and b.id_setor =  " . $id_setor;
        }
        
        $sql = "SELECT * 
                FROM paciente a, internacao b, internacao_checklist c
                WHERE 1=1 
                and a.id = b.id_paciente
                and b.id = c.id_internacao
                and c.id_checklist = '".$id_checklist."' 
                and (date_format(c.data_saida,'%Y-%m') = '" . $data_internacao . "' or c.data_saida is null )" . $condicao  ;
        $query = executarSql($sql);
        return $query->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getNumeroPreenchidosCkecklistMes($filtro, $id_setor=null){
        $lista        = explode("|", $filtro);
        $id_checklist = $lista[0];
        $data_resposta = $lista[1];
        
        if ($id_setor!=NULL){
            $condicao = " and b.id_setor =  " . $id_setor;
        }
        
        $sql = " SELECT * 
                 FROM resposta_checklist a, internacao b 
                 WHERE 1 = 1 
                 and a.id_checklist = '".$id_checklist."'
                 and a.id_internacao = b.id 
                 and date_format(a.data_resposta,'%Y-%m') = '" . $data_resposta . "'" . $condicao;
        
        $query = executarSql($sql);
        return $query->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getDashboarPorChecklist($filtro,$mensal=false,$tipo_questao="SN"){
        
        $lista        = explode("|", $filtro);
        $id_checklist = $lista[0];
        $data_resposta_checklist = $lista[1];
        $array_item = NULL;
        
        if(!$mensal){
            $sql = "select item.id, item.enunciado, item.meta, alternativa.descricao,
            		IFNULL((select count(id_resposta_alternativa)              
            		 from resposta_checklist_item r, item i, alternativa a              
            		 where r.id_item = i.id 
            		 and   i.id = item.id
                     and   item.tipo = '".$tipo_questao."'  
            		 and   a.id = alternativa.id              
            		 and   a.id = r.id_resposta_alternativa              
            		 and   r.id_resposta_checklist in (select r.id as id_resposta    
            		 								   from resposta_checklist r                        
            		 								   where r.id_checklist = '".$id_checklist."'                        
            		 								   and   date_format(r.data_resposta,'%Y-%m-%d') = '".$data_resposta_checklist."')              
            		group by r.id_resposta_alternativa),0) as total_resposta 
                    from item, checklist_item c, alternativa
                    where item.id = c.id_item
                    and   item.tipo = '".$tipo_questao."'  
                    and   alternativa.id_item = item.id
                    and   c.id_checklist = '".$id_checklist."' 
                    group by item.id, alternativa.id
                    order by item.enunciado, alternativa.descricao";
        }else{
            $sql = "select item.id, item.enunciado, item.meta, alternativa.descricao,
        		IFNULL((select count(id_resposta_alternativa)
        		 from resposta_checklist_item r, item i, alternativa a
        		 where r.id_item = i.id
        		 and   i.id = item.id
        		 and   item.tipo = '".$tipo_questao."'  
                 and   a.id = alternativa.id
        		 and   a.id = r.id_resposta_alternativa
        		 and   r.id_resposta_checklist in (select r.id as id_resposta
        		 								   from resposta_checklist r
        		 								   where r.id_checklist = '".$id_checklist."'
        		 								   and   date_format(r.data_resposta,'%Y-%m') = '".$data_resposta_checklist."')
        		group by r.id_resposta_alternativa),0) as total_resposta
                from item, checklist_item c, alternativa
                where item.id = c.id_item
                and   item.tipo = '".$tipo_questao."'  
                and   alternativa.id_item = item.id
                and   c.id_checklist = '".$id_checklist."' 
                group by item.id, alternativa.id
                order by item.enunciado, alternativa.descricao";
        }
        
        $query = executarSql($sql);
        //echo $sql;
        $enunciado = "";
        $array_labels = [];
        $array_nao    = [];
        $array_sim    = [];
	    $array_nao_porcentagem = [];
	    $array_sim_porcentagem = [];
        $maior_valor  = 0;
        $array_item = [];
        foreach ($query->fetch_all(MYSQLI_ASSOC) as $linha){
            //mudanca de enunciado
            if ($enunciado != $linha["enunciado"]){
                $array_labels[] = $linha["enunciado"];
                $enunciado      = $linha["enunciado"];
            }
            
            
            $array_item_id          .= "'".$linha["id"]."',";
            $array_item_enunciado   .= "'".$linha["enunciado"]."',";
            $array_item_item        .= "'".$linha["descricao"]."',";
            $array_item_total       .= "'".$linha["total_resposta"]."',";
            
            $array_item[]  = array(
                                "id"    => $linha["id"],
                                "enunciado" => $linha["enunciado"],
                                "item"  => $linha["descricao"],
                                "total" => $linha["total_resposta"]
                                 );
            
            if (strtolower($linha["descricao"]) == "não")
                $array_nao[] =  $linha["total_resposta"];
            
            if (strtolower($linha["descricao"]) == "sim")
                $array_sim[] =  $linha["total_resposta"];
            
                if ($maior_valor < $linha['total_resposta'])
                    $maior_valor = $linha['total_resposta'];
                        
        }
        
        $soma_sim=0;
        $soma_nao=0;
    	for($i=0;$i<sizeof($array_sim);$i++){
    	   $array_sim_porcentagem[]=calculaPorcentagem($array_sim[$i],$array_nao[$i]);
    	   $array_nao_porcentagem[]=calculaPorcentagem($array_nao[$i],$array_sim[$i]);
    	   $soma_sim += calculaPorcentagem($array_sim[$i],$array_nao[$i]);
    	   $soma_nao += calculaPorcentagem($array_nao[$i],$array_sim[$i]);
    	}

    	$array_total = $this->getPacientesPrevistosRespondidos($id_checklist, $data_resposta_checklist, $mensal);
    	
    	if (sizeof($array_sim_porcentagem) > 0){
    	   $psim = $soma_sim/sizeof($array_sim_porcentagem);
    	}else{
    	   $psim = 0;
    	}
    	
    	if (sizeof($array_nao_porcentagem) > 0){
    	    $pnao = $soma_nao/sizeof($array_nao_porcentagem);
    	}else{
    	    $pnao = 0;
    	}
    	$e = NULL;
    	$array_teste = [];
    	for($x=0;$x<sizeof($array_item);$x++){
    	    if ($e != $array_item[$x]["enunciado"] && $x > 0){
    	        $array_teste[] = array(
    	                           "enunciado" => $e,
    	                           "alternativa" => tratarArray($a),
    	                           "total"       => tratarArray($t)
    	                         );
    	        $e=NULL;
    	        $a=NULL;
    	        $t=NULL;
    	    }
    	    
    	    $e  = $array_item[$x]["enunciado"];
    	    $a .="'".$array_item[$x]["item"]."',";
    	    $t .= $array_item[$x]["total"].",";
    	}
    	if (sizeof($array_item)>0){
        	$array_teste[] = array(
        	    "enunciado" => $e,
        	    "alternativa" => tratarArray($a),
        	    "total"       => tratarArray($t)
        	);
    	}
    	
        $this->grafico_barras_inicial =
        array(
            "labels"            => '"ADESÃO BUNDLE","'.implode('","',$array_labels).'"',
            "resposta_tipo_1"   => (round($psim)).",".implode(',',$array_sim_porcentagem),
            "resposta_tipo_2"   => (round($pnao)).",".implode(',',$array_nao_porcentagem),
            "maior_valor"       => 120,
            "total_previsto"    => $array_total["total_previsto"],
            "total_respondido"  => $array_total["total_respondido"],
            "respostas"         => $array_item,
            "item_vf"           => $array_teste
        );
        
    }

    
    private function getPacientesPrevistosRespondidos($id_checklist,$data_saida,$mensal=false){
        
        if(!$mensal){
        
            $sql_where = "select i.id 
    					  from internacao_checklist c, internacao i
    					  where i.id = c.id_internacao
    					  and c.id_checklist = '".$id_checklist."' 
    					  and i.data_internacao <= '".$data_saida."' 
    					  and (c.data_saida is null or date_format(c.data_saida,'%Y-%m-%d') = '".$data_saida."'))";
            
            $sql = "select (select count(*) 
            		        from internacao_checklist where id_checklist = '".$id_checklist."' 
            		        and id_internacao in ($sql_where)
            		        as total_previsto, 
            	           (select count(*) 
            		        from resposta_checklist where id_checklist = '".$id_checklist."' 
            		        and date_format(data_resposta,'%Y-%m-%d') = '".$data_saida."' 
                            and id_internacao in ($sql_where)
            		        as total_respondido"; 
        
        }else{
            
            $sql_where = "select i.id
    					  from internacao_checklist c, internacao i
    					  where i.id = c.id_internacao
    					  and c.id_checklist = '".$id_checklist."'
    					  and date_format(i.data_internacao,'%Y-%m') = '".$data_saida."'
    					  and (c.data_saida is null or date_format(c.data_saida,'%Y-%m') = '".$data_saida."'))";
            
            $sql = "select (select count(*)
            		        from internacao_checklist where id_checklist = '".$id_checklist."'
            		        and id_internacao in ($sql_where)
            		        as total_previsto,
            	           (select count(*)
            		        from resposta_checklist where id_checklist = '".$id_checklist."'
            		        and date_format(data_resposta,'%Y-%m') = '".$data_saida."'
                            and id_internacao in ($sql_where)
            		        as total_respondido"; 
            
        }
        
        $query = executarSql($sql);
        $this->array = $query->fetch_all(MYSQLI_ASSOC);
                
        return $this->array[0];
    }
    
    public function getDashboarPorChecklistEPessoa($filtro,$mensal=false){
        
        $lista        = explode("|", $filtro);
        $id_checklist = $lista[0];
        $data_resposta_checklist = $lista[1];
        
        if(!$mensal){
            $sql = "select item.id, item.enunciado, item.meta, alternativa.descricao,
            		IFNULL((select count(id_resposta_alternativa)
            		 from resposta_checklist_item r, item i, alternativa a
            		 where r.id_item = i.id
            		 and   i.id = item.id
            		 and   a.id = alternativa.id
            		 and   a.id = r.id_resposta_alternativa
            		 and   r.id_resposta_checklist in (select r.id as id_resposta
            		 								   from resposta_checklist r
            		 								   where r.id_checklist = '".$id_checklist."'
            		 								   and   date_format(r.data_resposta,'%Y-%m-%d') = '".$data_resposta_checklist."')
            		group by r.id_resposta_alternativa),0) as total_resposta
                    from item, checklist_item c, alternativa
                    where item.id = c.id_item
                    and   alternativa.id_item = item.id
                    and   c.id_checklist = '".$id_checklist."'
                    group by item.id, alternativa.id
                    order by item.enunciado, alternativa.descricao";
        }else{
            $sql = "select item.id, item.enunciado, item.meta, alternativa.descricao,
        		IFNULL((select count(id_resposta_alternativa)
        		 from resposta_checklist_item r, item i, alternativa a
        		 where r.id_item = i.id
        		 and   i.id = item.id
        		 and   a.id = alternativa.id
        		 and   a.id = r.id_resposta_alternativa
        		 and   r.id_resposta_checklist in (select r.id as id_resposta
        		 								   from resposta_checklist r
        		 								   where r.id_checklist = '".$id_checklist."'
        		 								   and   date_format(r.data_resposta,'%Y-%m') = '".$data_resposta_checklist."')
        		group by r.id_resposta_alternativa),0) as total_resposta
                from item, checklist_item c, alternativa
                where item.id = c.id_item
                and   alternativa.id_item = item.id
                and   c.id_checklist = '".$id_checklist."'
                group by item.id, alternativa.id
                order by item.enunciado, alternativa.descricao";
        }
        
        $query = executarSql($sql);
        $enunciado = "";
        $array_labels = [];
        $array_nao    = [];
        $array_sim    = [];
        $array_nao_porcentagem = [];
        $array_sim_porcentagem = [];
        $maior_valor  = 0;
        
        foreach ($query->fetch_all(MYSQLI_ASSOC) as $linha){
            
            if ($enunciado != $linha["enunciado"]){
                $array_labels[] = $linha["enunciado"];
                $enunciado      = $linha["enunciado"];
            }
            
            if (strtolower($linha["descricao"]) == "não")
                $array_nao[] =  $linha["total_resposta"];
                
                if (strtolower($linha["descricao"]) == "sim")
                    $array_sim[] =  $linha["total_resposta"];
                    
                    if ($maior_valor < $linha['total_resposta'])
                        $maior_valor = $linha['total_resposta'];
                        
        }
        $soma_sim=0;
        $soma_nao=0;
        for($i=0;$i<sizeof($array_sim);$i++){
            $array_sim_porcentagem[]=calculaPorcentagem($array_sim[$i],$array_nao[$i]);
            $array_nao_porcentagem[]=calculaPorcentagem($array_nao[$i],$array_sim[$i]);
            $soma_sim += calculaPorcentagem($array_sim[$i],$array_nao[$i]);
            $soma_nao += calculaPorcentagem($array_nao[$i],$array_sim[$i]);
        }
        
        $array_total = $this->getPacientesPrevistosRespondidos($id_checklist, $data_resposta_checklist, $mensal);
        
        $this->grafico_barras_inicial =
        array(
            "labels"            => '"ADESÃO BUNDLE","'.implode('","',$array_labels).'"',
            "resposta_tipo_1"   => (round($soma_sim/sizeof($array_sim_porcentagem))).",".implode(',',$array_sim_porcentagem),
            "resposta_tipo_2"   => (round($soma_nao/sizeof($array_nao_porcentagem))).",".implode(',',$array_nao_porcentagem),
            "maior_valor"       => 120,
            "total_previsto"    => $array_total["total_previsto"],
            "total_respondido"  => $array_total["total_respondido"]
        );
        
    }
    
    
}



?>
