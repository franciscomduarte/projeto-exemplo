<?php 

	define("NOME_MODULO", "Usuário"); 
	define("NOME_ACAO", "Listar"); 
	include_once 'breadcrumb.php';
	// Solucao de contorno para edição de usuários.
	var_dump($_SESSION["usuario"]["email"]);

        if ($_SESSION["usuario"]["email"] == "fosbsb@gmail.com" || 
	    $_SESSION["usuario"]["email"] == "ericsoaresd@gmail.com" || 
	    $_SESSION["usuario"]["email"] == "olimpio@atenzi.com.br" || 
	    $_SESSION["usuario"]["email"] == "admin@enap.gov.br"){
		

?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
	                <div class="ibox float-e-margins">
	                    <div class="ibox-title col-lg-8">
	                        <h5>Lista de Usuários</h5>
	                    </div>
	                   <div class="ibox-title-right col-lg-4">
	                        <button type="button" class="btn btn-info" onclick="location.href='/usuario/novo/'">Novo</button>
	                    </div>
	                    <div class="ibox-content">
	                        <div class="table-responsive">
	                    		<table class="table table-striped table-bordered table-hover dataTables-example" >
	                    			<thead>
					                    <tr>
					                        <th>Foto</th>
											<th>Nome</th>
					                        <th>CPF</th>
					                        <th>E-mail</th>
					                        <th>Data Cadastro</th>
					                        <th>Perfil</th>
					                        <th>Status</th>
					                        <th align="center">Ações</th>
					                    </tr>
	                    			</thead>
	                   			 	<tbody>
    									<?php 
    										$usuarioLista = new Usuario();
    										foreach ($usuarioLista->listar() as $obj) {
    							        ?>
        									<tr>
        										<td width='25px'><img title="<?php echo $obj->chave ?>" class="img-circle m-t-xs img-responsive" src="/img/user.jpg"></td>
        										<td><?php echo $obj->nome?></td>
        										<td><?php echo $obj->cpf?></td>
        										<td><?php echo $obj->email?></td>
        										<td><?php echo formatarDataHora($obj->data_cadastro)?></td>
        										<td><?php echo $obj->perfil->descricao?></td>
        										<td class="project-status" align="center"><?php mostrarAtivoInativo($obj->ativo)?></td>
        										<td align="center">
        										    <button onclick="visualizar('<?php echo $obj->chave?>')">
        												<span class="glyphicon glyphicon-eye-open" title="Visualizar"></span>
        											</button>
        											<button onclick="editar('<?php echo $obj->chave?>')">
        												<span class="glyphicon glyphicon-edit" title="Editar"></span>
        											</button>
        											<button onclick="excluir('<?php echo $obj->chave?>')">
        												<span class="glyphicon glyphicon-trash remove" title="Excluir"></span>
        											</button>
        											
        										</td>
        									</tr>
        				
    									<?php 
    							          	}
    							        ?>
	                    			</tbody>
	                    			<tfoot>
					                    <tr>
											<th>Foto</th>
											<th>Nome</th>
					                        <th>CPF</th>
					                        <th>E-mail</th>
					                        <th>Data Cadastro</th>
					                        <th>Perfil</th>
					                        <th>Status</th>
					                        <th align="center">Ações</th>
					                    </tr>
	                    			</tfoot>
	                    		</table>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>
        
		<script>
    		function visualizar(id){
    			var pag = "/usuario/novo/"+id+"?view";
    			location.href = pag;
    		}
			
			function editar(id){
				var pag = "/usuario/novo/"+id;
				location.href = pag;
			}
		
			function excluir(id){
				var pag = "/usuario/excluir/"+id;
				if (confirm("Tem certeza que deseja excluir este usuário?")){
					location.href = pag;
				}
			}
		</script>
<?php
}else{
  echo "Acesso Bloqueado...";
  exit();

}

?>
