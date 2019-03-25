<?php

class Item extends Base
{	
    public $id;
	public $enunciado;
	public $tipo;
	public $meta;
	public $alternativas = [];
	public $checklist;
	
	public function __construct(){
	    $this->tabela = "item";
	    $this->checklist = new Checklist();
	}
	
	public function inserir($obj){
	    try {
    		$sql = "INSERT INTO ".$this->tabela." (id,enunciado,tipo,meta) 
    				               VALUES (null,'$obj->enunciado','$obj->tipo','$obj->meta')";
    		
    		retornaConexao()->begin_transaction();
    		
    		retornaConexao()->query($sql);
    		
    		$obj->id=retornaId();
    		
    		$sql_checklist = "INSERT INTO checklist_item (id_item,id_checklist)
                              VALUES (".$obj->id.",".$obj->checklist->id.");";    
        	
    		retornaConexao()->query($sql_checklist);
        	
    		retornaConexao()->commit();
        	
            return $this->listarPorId($obj->id);
            
	    }catch (Exception $e){
	        retornaConexao()->rollback();
        	echo $e->getMessage();
        	exit();
        }
        
	}
	
	public function editar($obj){
		$sql = "UPDATE ".$this->tabela."  
                SET enunciado = '$obj->nome',
					tipo 	  = '$obj->tipo',
                    meta      = '$obj->meta'
                WHERE id 	= $obj->id";
		
		$sqlItens = "";
		var_dump($sql);
		exit();
		return executarSql($sql);
	}
	
	public function desativar($id){
		$sql = "UPDATE ".$this->tabela." set ativo = 0 WHERE id = $id ";
		
		return executarSql($sql);
	}
	
	public function listar(){
		$sql = "SELECT * FROM checklist WHERE 1=1 order by nome";
		$query = executarSql($sql);
		
		$array = $query->fetch_all(MYSQLI_ASSOC);
		
		$checklists = [];
		
		foreach ($array as $linha) {
		    $checklist = new Checklist();
		    $checklist->id            = $linha['id'];
		    $checklist->nome          = $linha['nome'];
		    $checklist->data_cadastro = $linha['data_cadastro'];
		    $checklist->ativo         = $linha['ativo'];
		   
		    $checklist->usuario       = $checklist->usuario->listarPorId($linha['usuario_id']);
		    
		    $checklists[] = $checklist;
		}
		
		return $checklists;
	}
	
	public function listarPorId($id){
		$sql = "SELECT * FROM checklist WHERE 1=1 AND id = $id ";
		$query = executarSql($sql);
		$array = $query->fetch_all(MYSQLI_ASSOC);
		
		$checklist = new Checklist();
		
		foreach ($array as $linha) {
		    $checklist->id            = $linha['id'];
		    $checklist->nome          = $linha['nome'];
		    $checklist->data_cadastro = $linha['data_cadastro'];
		    $checklist->ativo         = $linha['ativo'];
		    
		    $checklist->usuario       = $checklist->usuario->listarPorId($linha['usuario_id']);
		}
		
		return $checklist;
		
	}
	
	public function listarPorIdChecklist($id){
	    $sql = "SELECT c.* FROM checklist as a, checklist_item as b, item as c 
                WHERE a.id = b.id_checklist 
                AND c.id = b.id_item 
                AND b.id_checklist = $id 
                AND c.tipo != 'TX'
                UNION ALL
                SELECT c.* FROM checklist as a, checklist_item as b, item as c 
                WHERE a.id = b.id_checklist 
                AND c.tipo = 'TX'
                AND c.id = b.id_item 
                AND b.id_checklist = $id ";
	    $query = executarSql($sql);
	    $array = $query->fetch_all(MYSQLI_ASSOC);
	    
	    $itens = array();
	    
	    foreach ($array as $linha) {
	        $item = new Item();
	        $item->id            = $linha['id'];
	        $item->enunciado     = $linha['enunciado'];
	        $item->tipo          = $linha['tipo'];
	        $item->meta          = $linha['meta'];
	        $itens[] = $item;
	    }
	    return $itens;
	}
	
	public function listarPorNome($nome){
		$sql = "SELECT *
				FROM checklist
				WHERE nome like '%$nome%' order by nome";
		
		$query = executarSql($sql);
		
		return $query->fetch_array(MYSQLI_ASSOC);
	}
		
	public function deletar($id){
		#fazer consulta no checklist_resposta pra verificar se já tem resposta
		#se tiver não pode excluir.
	    $sql = "DELETE FROM checklist WHERE id = " . $id;
		return executarSql($sql);
	}
	
}