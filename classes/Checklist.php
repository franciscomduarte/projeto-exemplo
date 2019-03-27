<?php

class Checklist extends Base
{	
    public $id;
    public $data_cadastro;
    public $nome;
    public $usuario;
    public $ativo;
    public $meta;
    public $sigla;
    public $cor;
    public $tipo; //�nico ou di�rio
    public $itens = [];
	
	// internações ativas no checklist
    public $internacoes = [];
	
	public function __construct(){
	    $this->tabela = "checklist";
	    $this->usuario = new Usuario();
	}
	
	public function inserir($obj){
		$sql = "INSERT INTO ".$this->tabela." (id,nome,usuario_id,ativo,meta,sigla, cor, tipo) 
				               VALUES (null,'$obj->nome','".$_SESSION['usuario']['id']."',$obj->ativo,'$obj->meta','$obj->sigla','$obj->cor','$obj->tipo')";
        
        return  executarSql($sql);
	}
	
	public function editar($obj){
		$sql = "UPDATE ".$this->tabela." 
                SET nome 	= '$obj->nome',
					ativo 	= '$obj->ativo',
                    meta    = '$obj->meta',
                    sigla   = '$obj->sigla',
                    cor   = '$obj->cor',
                    tipo   = '$obj->tipo'
                WHERE id 	= $obj->id";
		
		return executarSql($sql);
	}
	
	public function desativar($id){
		$sql = "UPDATE ".$this->tabela." set ativo = 0 WHERE id = $id ";
		
		return executarSql($sql);
	}
	
	public function listar(){
		self::listarObjetos();
		$checklists = [];
		
		$internacao = new Internacao();
		
		foreach ($this->array as $linha) {
		    $checklist = new Checklist();
		    $checklist->id            = $linha['id'];
		    $checklist->nome          = $linha['nome'];
		    $checklist->data_cadastro = $linha['data_cadastro'];
		    $checklist->ativo         = $linha['ativo'];
		    $checklist->meta          = $linha['meta'];
		    $checklist->sigla         = $linha['sigla'];
		    $checklist->tipo           = $linha['tipo'];
		    $checklist->cor           = $linha['cor'];
		    $checklist->usuario       = $checklist->usuario->listarPorId($linha['usuario_id']);
		    $checklist->internacoes   = $internacao->listarAtivas($linha['id']);
		    
		    $checklists[] = $checklist;
		}
		return $checklists;
	}
	
	public function listarAtivos(){
	    self::listarObjetosAtivos();
	    $checklists = [];
	    
	    $internacao = new Internacao();
	    foreach ($this->array as $linha) {
	        $checklist = new Checklist();
	        $checklist->id            = $linha['id'];
	        $checklist->nome          = $linha['nome'];
	        $checklist->data_cadastro = $linha['data_cadastro'];
	        $checklist->ativo         = $linha['ativo'];
	        $checklist->meta          = $linha['meta'];
	        $checklist->sigla         = $linha['sigla'];
	        $checklist->tipo           = $linha['tipo'];
	        $checklist->cor           = $linha['cor'];
	        $checklist->usuario       = $checklist->usuario->listarPorId($linha['usuario_id']);
	        $checklist->internacoes   = $internacao->listarAtivas($linha['id']);
	        
	        $checklists[] = $checklist;
	    }
	    return $checklists;
	}
	
	public function listarAtivosCount(){
	    $sql   = "SELECT c.id, c.nome, c.sigla, c.cor, count(i.id_checklist) as total 
                    FROM checklist c, internacao_checklist i 
                    WHERE c.id = i.id_checklist
                    and c.ativo = 1
                    and i.data_saida is null 
                    group by c.id
                    order by c.sigla";
	    $query = executarSql($sql);
	    $this->array = $query->fetch_all(MYSQLI_ASSOC);

	    $checklists = [];
	    
	    foreach ($this->array as $linha) {
	        $checklist = new Checklist();
	        $checklist->id            = $linha['id'];
	        $checklist->nome          = $linha['nome'];
	        $checklist->sigla         = $linha['sigla']." (".$linha['total'].")";
	        $checklist->tipo           = $linha['tipo'];
	        $checklist->cor           = $linha['cor'];
	        
	        $checklists[] = $checklist;
	    }
	    return $checklists;
	}
	
	
	public function listarPendentesPorInternacao($id_paciente){
	    
	   $sql = "SELECT * FROM checklist where id NOT IN (SELECT c.id
                FROM checklist c, internacao_checklist ic, internacao i, paciente p
                WHERE 1 = 1
                AND c.id = ic.id_checklist
                AND i.id = ic.id_internacao
                AND ic.data_saida is null
                AND i.id_paciente = p.id
                AND c.ativo = 1
                AND p.id = $id_paciente) 
                AND ativo = 1 ";

	    $query = executarSql($sql);
	    $array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    $checklists = array();
	    
	    $internacao = new Internacao();
	    
	    foreach ($array as $linha) {
	        $checklist = new Checklist();
	        $checklist->id            = $linha['id'];
	        $checklist->nome          = $linha['nome'];
	        $checklist->data_cadastro = $linha['data_cadastro'];
	        $checklist->ativo         = $linha['ativo'];
	        $checklist->meta          = $linha['meta'];
	        $checklist->sigla          = $linha['sigla'];
	        $checklist->tipo           = $linha['tipo'];
	        $checklist->cor          = $linha['cor'];
	        $checklist->usuario       = $checklist->usuario->listarPorId($linha['usuario_id']);
	        $checklist->internacoes  = $internacao->listarAtivas($linha['id']);
	        
	        $checklists[] = $checklist;
	    }
	    return $checklists;
	}
	
	public function listarAtivasPorInternacao($id_internacao){
	    
	    $sql = "SELECT *
                FROM checklist i, internacao_checklist ic
                WHERE i.id = ic.id_checklist
                AND ic.data_saida is null
                AND i.ativo = 1
                AND ic.id_internacao = $id_internacao
                ORDER BY i.id ";
	    $query = executarSql($sql);
	    $array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    $checklists = array();
	    $internacao = new Internacao();
	    foreach ($array as $linha) {
	        $checklist = new Checklist();
	        $checklist->id            = $linha['id'];
	        $checklist->nome          = $linha['nome'];
	        $checklist->data_cadastro = $linha['data_cadastro'];
	        $checklist->ativo         = $linha['ativo'];
	        $checklist->meta          = $linha['meta'];
	        $checklist->sigla         = $linha['sigla'];
	        $checklist->tipo           = $linha['tipo'];
	        $checklist->cor           = $linha['cor'];
	        $checklist->usuario       = $checklist->usuario->listarPorId($linha['usuario_id']);
	        $checklist->internacoes   = $internacao->listarAtivas($linha['id']);
	        
	        $checklists[] = $checklist;
	    }
	    return $checklists;
	}

	public function listarPorInternacao($id_internacao){
	    
	    $sql = "SELECT *
                FROM checklist c, internacao_checklist ic
                WHERE c.id = ic.id_checklist
                AND c.ativo = 1
                AND ic.id_internacao = '$id_internacao' 
                ORDER BY 1";
	    $query = executarSql($sql);
	    $array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    $checklists = array();
	    foreach ($array as $linha) {
	        $checklist = new Checklist();
	        $checklist->id            = $linha['id'];
	        $checklist->nome          = $linha['nome'];
	        $checklist->tipo           = $linha['tipo'];
	        $checklist->sigla         = $linha['sigla'];
	        $checklist->cor           = $linha['cor'];
	        
	        $checklists[] = $checklist;
	    }
	    return $checklists;
	}
	
	public function listarTodosPorInternacao($id_internacao){
	    
	    $sql = "SELECT *
                FROM checklist c, internacao_checklist ic
                WHERE c.id = ic.id_checklist
                AND ic.id_internacao = '$id_internacao'
                ORDER BY 1";
	    $query = executarSql($sql);
	    $array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    $checklists = array();
	    foreach ($array as $linha) {
	        $checklist = new Checklist();
	        $checklist->id            = $linha['id'];
	        $checklist->nome          = $linha['nome'];
	        $checklist->sigla         = $linha['sigla'];
	        $checklist->tipo           = $linha['tipo'];
	        $checklist->cor           = $linha['cor'];
	        
	        $checklists[] = $checklist;
	    }
	    return $checklists;
	}
	
	public function listarPorId($id){
		self::listarObjetosPorId($id);
		
		$checklist = new Checklist();
		$internacao = new Internacao();
		foreach ($this->array as $linha) {
		    $checklist->id            = $linha['id'];
		    $checklist->nome          = $linha['nome'];
		    $checklist->data_cadastro = $linha['data_cadastro'];
		    $checklist->ativo         = $linha['ativo'];
		    $checklist->meta          = $linha['meta'];
		    $checklist->sigla         = $linha['sigla'];
		    $checklist->tipo           = $linha['tipo'];
		    $checklist->cor           = $linha['cor'];
		    $checklist->usuario       = $checklist->usuario->listarPorId($linha['usuario_id']);
		    $checklist->internacoes   = $internacao->listarAtivas($linha['id']);
		}
		
		return $checklist;
		
	}

	public function listarPorIdFiltro($filtro){

           $lista        = explode("|", $filtro);
           $id_checklist = $lista[0];
           $data_internacao = $lista[1];

	   return $this->listarPorId($id_checklist);	

	}
		

	
	public function listarPorNome($nome){
		$sql = "SELECT *
				FROM ".$this->tabela."
				WHERE nome like '%$nome%' order by nome";
		
		$query = executarSql($sql);
		
		return $query->fetch_array(MYSQLI_ASSOC);
	}
		
	public function deletar($id){
	    #TODO
		#fazer consulta no checklist_resposta pra verificar se já tem resposta
		#se tiver não pode excluir.
	    self::deletar($id);
	}
	
	public function getChecklistIndividualSumarizado($id_internacao,$id_paciente) {
	    $sql = "select i.id, ic.id_checklist,c.nome, c.sigla,
                	   ifnull(datediff(ic.data_saida,i.data_internacao),datediff(now(),i.data_internacao)) as total_previsto,
                       count(*) as total_resposta
                from   resposta_checklist r, internacao_checklist ic, internacao i, checklist c
                where  r.id_internacao  = i.id
                and    ic.id_internacao = i.id
                and    r.id_internacao  = ic.id_internacao
                and    ic.id_checklist  = c.id
                and    i.id = '$id_internacao' 
                and    i.id_paciente = '$id_paciente' 
                group by i.id,ic.id_checklist";
	    
	    $query = executarSql($sql);
	    $checklistvos = array();
	    $this->array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    foreach ($this->array as $linha){
	        $checklistvo = new ChecklistVO();
	        $checklistvo->id_internacao  = $linha['id'];
	        $checklistvo->id_checklist   = $linha['id_checklist'];
	        $checklistvo->nome_checklist = $linha['nome'];
	        $checklistvo->sigla_cheklist = $linha['sigla'];
	        $checklistvo->total_previsto = $linha['total_previsto'];
	        $checklistvo->total_resposta = $linha['total_resposta'];
	        $checklistvos[] = $checklistvo;
	    }
	    
	    return $checklistvos;
	}
	
	public function getChecklistsSumarizadosDoDia() {
	    
	    $sql = "select c.id, c.nome, c.sigla, c.cor, c.tipo,
        	    (select count(*) from internacao_checklist where id_checklist = c.id and data_saida is null) as total_internados,
        	    (select count(*) from resposta_checklist   where id_checklist = c.id and data_resposta >= curdate()) as total_respostas
        	    from   checklist c
        	    where  c.tipo <> 'UNICO'";
	    
	    $query = executarSql($sql);
	    $checklistvos = array();
	    $this->array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    foreach ($this->array as $linha){
	        $checklistvo = new ChecklistVO();
	        $checklistvo->id_checklist   = $linha['id'];
	        $checklistvo->nome_checklist = $linha['nome'];
	        $checklistvo->sigla_cheklist = $linha['sigla'];
	        $checklistvo->total_previsto = $linha['total_internados'];
	        $checklistvo->total_resposta = $linha['total_respostas'];
	        $checklistvos[] = $checklistvo;
	    }
	    
	    return $checklistvos;
	}
	
}

class ChecklistVO {
    
    public $id_internacao;
    public $id_checklist;
    public $nome_checklist;
    public $sigla_cheklist;
    public $total_previsto;
    public $total_resposta;
    
    public function getDiferenca(){
        return $this->total_previsto - $this->total_resposta;
    }
    
    public function getPorcentagem() {
        return round(($this->total_resposta*100)/$this->total_previsto);
    }
}
