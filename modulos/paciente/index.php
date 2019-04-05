<?php 

	define("NOME_MODULO", "Paciente"); 
	define("NOME_ACAO", "Listar"); 
	include_once 'breadcrumb.php';

?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
	                <div class="ibox float-e-margins">
	                    <div class="ibox-title col-lg-12">
	                        <h5>Lista de Pacientes</h5>
	                    </div>
	                   <div class="ibox-title-right col-lg-12">
	                        <button type="button" class="btn btn-info" onclick="location.href='/paciente/novo/'">Novo</button>
	                    </div>
	                    <div class="ibox-content">
	                        <div class="table-responsive">
	                    		<table class="table table-striped table-bordered table-hover dataTables-example" >
	                    			<thead>
					                    <tr>
					                        <th>ID</th>
					                        <th>Nome</th>
					                        <th>CPF</th>
					                        <th>Nascimento</th>
<!-- 					                        <th>Convênio</th> -->
<!-- 					                        <th>Registro</th> -->
					                        <th>Ações</th>
					                    </tr>
	                    			</thead>
	                   			 	<tbody>
										<?php 
											$paciente = new Paciente();
										    $pacientes = $paciente->listar();
											
											foreach ($pacientes as $paciente) {
								        ?>
										<tr>
											<td><?php echo $paciente->id?></td>
											<td><?php echo $paciente->genero == "FEMININO" ? "<i class='fa fa-female'></i>" : "<i class='fa fa-male'></i>&nbsp;";
	                                                  echo $paciente->nome?></td>
											<td><?php echo $paciente->cpf?></td>
											<td><?php echo formatarData($paciente->nascimento)?></td>
											<!--  <td><?php echo $paciente->convenio->nome ?></td>
											<td><?php echo $paciente->registro?></td>
											-->
											<td>
												<button onclick="editar(<?php echo $paciente->id?>)">
													<span class="glyphicon glyphicon-edit" title="Editar"></span>
												</button>
												<button onclick="dashboard(<?php echo $paciente->cpf?>,<?php echo $paciente->ultima_internacao?>)">
													<span class="glyphicon glyphicon-stats" title="Dashboard"></span>
												</button>
												<button onclick="excluir(<?php echo $paciente->id?>)">
													<span class="glyphicon glyphicon-trash" title="Excluir"></span>
												</button>
												
											</td>
										</tr>
					
										<?php 
								          	}
								        ?>
	                    			</tbody>
	                    			<tfoot>
					                    <tr>
					                        <th>ID</th>
					                        <th>Nome</th>
					                        <th>CPF</th>
					                        <th>Nascimento</th>
<!-- 					                        <th>Convênio</th> -->
<!-- 					                        <th>Registro</th> -->
					                        <th>Ações</th>
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

			function editar(id){
				var pag = "/paciente/edita/"+id;
				location.href = pag;
			}

			function dashboard(cpf,internacao){
				var pag = "/paciente/detalhes/"+cpf+"/"+internacao;
				location.href = pag;
			}
			
			function excluir(id){
				var pag = "/paciente/excluir/"+id;
				if (confirm("Tem certeza que deseja excluir este paciente?")){
					location.href = pag;
				}
			}
		</script>

