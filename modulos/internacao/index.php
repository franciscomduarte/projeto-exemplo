<?php 

	define("NOME_MODULO", "Internação"); 
	define("NOME_ACAO", "Listar"); 
	include_once 'breadcrumb.php';

?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
	                <div class="ibox float-e-margins">
	                    <div class="ibox-title col-lg-8">
	                        <h5>Lista de Internações</h5>
	                    </div>
	                   <div class="ibox-title-right col-lg-4">
	                        <button type="button" class="btn btn-info" onclick="location.href='/internacao/novo/'">Novo</button>
	                    </div>
	                    <div class="ibox-content">
	                        <div class="table-responsive">
	                    		<table class="table table-striped table-bordered table-hover dataTables-example" >
	                    			<thead>
					                    <tr>
					                        <th>ID</th>
					                        <th>Nr. Internação</th>
					                        <th>Paciente</th>
					                        <th>Convênio</th>
					                        <th>Data Internação</th>
					                        <th>Ações</th>
					                    </tr>
	                    			</thead>
	                   			 	<tbody>
										<?php 
											
											$internacao = new Internacao();
											$array = $internacao->listar();
											
											foreach ($array as $linha) {
								        ?>
										<tr>
											<td><?php echo $linha['id']?></td>
											<td><?php echo $linha['numero_internacao']?></td>
											<td><?php echo $linha['id_paciente']?></td>
											<td><?php echo $linha['id_convenio']?></td>
											<td><?php echo formatarDataHora($linha['data_internacao'])?></td>
											<td>
												<button onclick="editar(<?php echo $linha['id']?>)">
													<span class="glyphicon glyphicon-edit" title="Editar"></span>
												</button>
												<button onclick="excluir(<?php echo $linha['id']?>)">
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
					                        <th>Nr. Internação</th>
					                        <th>Paciente</th>
					                        <th>Convênio</th>
					                        <th>Data Internação</th>
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
				var pag = "/internacao/novo/"+id;
				location.href = pag;
			}
		
			function excluir(id){
				var pag = "/internacao/excluir/"+id;
				if (confirm("Tem certeza que deseja excluir esta internação?")){
					location.href = pag;
				}
			}
		</script>
