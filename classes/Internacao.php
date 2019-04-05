<?php

class Internacao extends Base
{
	
	public $id;
	public $numero_internacao;
	public $data_internacao;
	public $setor;
	public $paciente;
	public $convenio;
	
	public $checklists = [];
	
	public function __construct(){
	    $this->tabela   = "internacao";
	    $this->tabela_relacionada = "internacao_checklist";
	    $this->setor    = new Setor();
	    $this->convenio = new Convenio();
	    $this->paciente = new Paciente();
	}
	
	public function inserir($obj){
		$sql = "INSERT INTO ".$this->tabela." (id, numero_internacao, data_internacao, id_setor, id_paciente, id_convenio) 
                VALUES (null, '$obj->numero_internacao', '$obj->data_internacao', ".$obj->setor->id.", 
		                ".$obj->paciente->id.", ".$obj->convenio->id.")";
	    executarSql($sql);
	    
	    $id_internacao_inserida = self::retornaIdInserido();
	    
	    // insere na tabela internacao_checklist
	    if($obj->checklists){
    	    foreach ($obj->checklists as $checklist) {
    	        $sqlRelacionado = "INSERT INTO ".$this->tabela_relacionada." (id_internacao, id_checklist)
                                   VALUES ($id_internacao_inserida, $checklist)";
    	        executarSql($sqlRelacionado);
    	    }
	    }
	}
	
	public function inserirTabelaRelacionada($id_internacao, $id_checklist){
	        $sqlRelacionado = "INSERT INTO ".$this->tabela_relacionada." (id_internacao, id_checklist)
                               VALUES ($id_internacao, $id_checklist)";
	        executarSql($sqlRelacionado);
	}
	
	public function editar($obj){
		$sql = "UPDATE ".$this->tabela." 
                SET numero_internacao = '$obj->numero_internacao', 
                data_internacao = '$obj->data_internacao',
                id_setor    = ".$obj->setor->id.",
                id_paciente = ".$obj->paciente->id.",
                id_convenio = ".$obj->convenio->id."
                WHERE id = $obj->id ";
		
	   executarSql($sql);
	   
	   // insere na tabela internacao_checklist
	   if($obj->checklists) {
    	   foreach ($obj->checklists as $checklist) {
    	       $sqlRelacionado = "INSERT INTO ".$this->tabela_relacionada." (id_internacao, id_checklist)
                                   VALUES ($obj->id, $checklist)";
    	       executarSql($sqlRelacionado);
    	   }
	   }
	}
	
	public function atualizarDataSaida($id_internacao, $id_checklist){
	    $sql = "UPDATE ".$this->tabela_relacionada."
                SET data_saida = '" . date('Y-m-d H:i') . "'
                WHERE id_internacao = " . $id_internacao . " and id_checklist = " . $id_checklist ;
	    return executarSql($sql);
	}
	
	public function listar(){
		self::listarObjetos();
		$internacoes = array();
	    
	    foreach ($this->array as $linha) {
	        
	        $internacao = new Internacao();
	        $convenio   = new Convenio();
	        $paciente   = new Paciente();
	        $setor   = new Setor();
	        
	        $internacao->id = $linha['id'];
	        $internacao->numero_internacao = $linha['numero_internacao'];
	        $internacao->data_internacao = $linha['data_internacao'];
	        $internacao->paciente = $paciente->listarPorId($linha['id_paciente']);
	        $internacao->convenio = $convenio->listarPorId($linha['id_convenio']);
	        $internacao->setor = $setor->listarPorId($linha['id_setor']);
	        $internacoes[] = $internacao;
	    }
	    return $internacoes;
	}

	public function listarTodasPorCpf($cpf,$order="asc"){
	    $sql = "select i.id, i.numero_internacao, i.data_internacao, i.id_setor, i.id_paciente,
                	   p.nome, p.cpf, p.nascimento, p.genero, p.registro, p.id_convenio
                from internacao i, paciente p
                where i.id_paciente = p.id
                and   p.cpf = '$cpf' 
                order by i.id $order";
	    
        $this->array = executarSql($sql);
	    $internacoes = array();
	    
	    foreach ($this->array as $linha) {
	        
	        $internacao = new Internacao();
	        $convenio   = new Convenio();
	        $paciente   = new Paciente();
	        $setor      = new Setor();
	        
	        $internacao->id = $linha['id'];
	        $internacao->numero_internacao = $linha['numero_internacao'];
	        $internacao->data_internacao = $linha['data_internacao'];
	        $internacao->paciente = $paciente->listarPorId($linha['id_paciente']);
	        $internacao->convenio = $convenio->listarPorId($linha['id_convenio']);
	        $internacao->setor = $setor->listarPorId($linha['id_setor']);
	        $internacoes[] = $internacao;
	    }
	    return $internacoes;
	}
	
	public function listarAtivas($id_checklist){
	    
	    $sql = "SELECT *
                FROM internacao i, internacao_checklist ic
                WHERE i.id = ic.id_internacao
                AND ic.data_saida is null
                AND ic.id_checklist = $id_checklist
                ORDER BY i.data_internacao ";
	    $query = executarSql($sql);
	    $array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    $internacoes = array();

	    foreach ($array as $linha) {
	        
	        $internacao = new Internacao();
	        $convenio   = new Convenio();
	        $paciente   = new Paciente();
	        $setor      = new Setor();
	        
	        $internacao->id = $linha['id'];
	        $internacao->numero_internacao = $linha['numero_internacao'];
	        $internacao->data_internacao = $linha['data_internacao'];
	        $internacao->paciente = $paciente->listarPorId($linha['id_paciente']);
	        $internacao->convenio = $convenio->listarPorId($linha['id_convenio']);
	        $internacao->setor = $setor->listarPorId($linha['id_setor']);
	        $internacoes[] = $internacao;
	    }
	    return $internacoes;
	}
	
	public function listarInternacaoPorCpf($cpf){
		$sql = "SELECT i.numero_internacao, i.id as id, p.id as id_paciente, p.id_convenio as id_convenio, p.cpf, i.id_setor as id_setor, i.data_internacao 
                FROM internacao i, paciente p, internacao_checklist c
                WHERE i.id_paciente = p.id 
                AND i.id = c.id_internacao
                AND p.cpf = '$cpf'
                AND c.data_saida is null 
                ORDER BY i.data_internacao desc limit 1 ";
		$query = executarSql($sql);
		$array = $query->fetch_all(MYSQLI_ASSOC);
		
		$internacao = null;
		
		foreach ($array as $linha) {
		    
		    $internacao = new Internacao();
		    $convenio   = new Convenio();
		    $paciente   = new Paciente();
		    $setor      = new Setor();
		    
		    $internacao->id = $linha['id'];
		    $internacao->numero_internacao = $linha['numero_internacao'];
		    $internacao->data_internacao = $linha['data_internacao'];
		    $internacao->paciente = $paciente->listarPorId($linha['id_paciente']);
		    $internacao->convenio = $convenio->listarPorId($linha['id_convenio']);
		    $internacao->setor = $setor->listarPorId($linha['id_setor']);
		}
		return $internacao;
	}
	
	public function listarPorId($id){
	    self::listarObjetosPorId($id);
	    foreach ($this->array as $linha) {
	        
	        $internacao = new Internacao();
	        $convenio   = new Convenio();
	        $paciente   = new Paciente();
	        $setor      = new Setor();
	        
	        $internacao->id = $linha['id'];
	        $internacao->numero_internacao = $linha['numero_internacao'];
	        $internacao->data_internacao = $linha['data_internacao'];
	        $internacao->paciente = $paciente->listarPorId($linha['id_paciente']);
	        $internacao->convenio = $convenio->listarPorId($linha['id_convenio']);
	        $internacao->setor = $setor->listarPorId($linha['id_setor']);
	    }
	    return $internacao;
	}
	
	public function getInternacaoChecklist($id_internacao){
	    $sql = "SELECT IFNULL(data_saida,true) as ativo 
                FROM  internacao_checklist
                WHERE id_internacao = '$id_internacao'";
	   
	    $query = executarSql($sql);
	    $this->array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    $data_saida_internacao="Sem Alta";
	    
	    foreach ($this->array as $linha){
	        $data_saida_internacao = $linha['ativo']==1 ? true : formatarDataHora($linha['ativo']);
	    }
	    
	    return $data_saida_internacao;
	    
	}
	
}