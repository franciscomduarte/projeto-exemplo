<?php 

// dados da url
$params = retornaParametrosUrl($_SERVER['QUERY_STRING']);
$id = $params[2];


$objInternacao = new Internacao();
$paciente = new Paciente();
$objPaciente =  $paciente->listarPorId($id);
$objInternacao = $objInternacao->listarInternacaoPorCpf($objPaciente->cpf);

$setor   = new Setor();
$setores = $setor->listar();

$convenio = new Convenio();
$objConvenio = $convenio->listar();

?>

<div class="col-lg-12">
	<div class="ibox float-e-margins">
    	<div class="ibox-title">
        	<h5>Cadastro de Paciente<small></small></h5>
        </div>
        <div class="ibox-content">
        	<div class="row">
            	<div class="col-sm-12">
            	   	<div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Paciente / Internação </a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                
                                    <form role="form" action="/paciente/gravar" method="post">
                                		<input type="hidden" name="id_paciente" value="<?php echo $objPaciente->id ? $objPaciente->id : null ?>">
                                		<input type="hidden" name="id_convenio" value="<?php echo $objPaciente->convenio->id ? $objPaciente->convenio->id : null ?>">
                                		<input type="hidden" name="id_internacao" value="<?php echo $objInternacao->id ? $objInternacao->id : null ?>">
 
                                    	<div class="form-group col-sm-6"><label>Nome</label><span style="color: red;"> *</span> <input required="required" type="text" value="<?php echo $objPaciente->nome ? $objPaciente->nome : null ?>" placeholder="Nome do paciente" class="form-control" name="nome"></div>
                                        <div class="form-group col-sm-6"><label>CPF</label><span style="color: red;"> *</span> <input  <?php echo $objPaciente != null ? "readonly" : "" ?> required="required" data-mask="999.999.999-99" type="text" value="<?php echo $objPaciente->cpf ? mask($objPaciente->cpf,'###.###.###-##') : mask($paciente->cpf,'###.###.###-##') ?>" placeholder="CPF do paciente" class="form-control" name="cpf"></div>
                                       	
                						<div class="form-group col-sm-6">
                							<label>Gênero</label><span style="color: red;"> *</span>
                							<select name="genero" required="required" class="form-control">
                							<option value="">-- Selecione --</option>
                							<option value="MASCULINO" <?php echo ("MASCULINO" == $objPaciente->genero ? 'selected="selected"' : '')?>>Masculino</option>
                							<option value="FEMININO" <?php echo ("FEMININO" == $objPaciente->genero ? 'selected="selected"' : '')?>>Feminino</option>
                							<option value="OUTRO" <?php echo ("OUTRO" == $objPaciente->genero ? 'selected="selected"' : '')?>>Outro</option>
                                    		</select>
                						</div>
                						
                						<div class="form-group col-sm-6">
                							<label for="db">Nascimento</label><span style="color: red;"> *</span>
                							<div class="input-group">
                								<input class="form-control" id="db" type="text" required="required"
                									data-role="datebox"
                									data-options='{"mode":"datebox","useInline":false,"useInlineAlign":"center", "useLang":"pt-br", "afterToday":false,"beforeToday":true}' 
                									name="nascimento"
                									value="<?php echo formatarData($objPaciente->nascimento)  ?>">
                							</div>
                						</div>
                						
                						<!--  
                                       	<div class="form-group col-sm-6">
                							<label>Convênio</label><span style="color: red;"> *</span> 
                									<select class="form-control" name="id_convenio" required="required">
                										<option value="">-- Selecione --</option>
                										<?php foreach ($objConvenio as $c) { 
                							             ?>
                    										<option value="<?php echo $c->id?>" id="s<?php echo $c->id ?>" <?php echo $objPaciente->convenio->id == $c->id ? 'selected' : ''?>>
                    									<?php 
                    							             echo $c->nome; 
                    							         ?>
                    									</option>
                										<?php
                							             } 
                							             ?>	
                							
                									</select>						
                						</div>
                						
                						<div class="form-group col-sm-6">
                                        	<label>Número da Internação</label><span style="color: red;"> *</span> 
                                        	<input type="text" value="<?php echo $objInternacao->numero_internacao ? $objInternacao->numero_internacao : null ?>" placeholder="Informe o número da internação" class="form-control" name="numero_internacao" required="required">
                                        </div>
                                        -->
                    					<div class="form-group col-sm-6">
                    						<label for="db">Data da Internação</label><span style="color: red;"> *</span> 
                    						<div class="input-group">
                    						<input class="form-control" id="db" type="text"
                    									data-role="datebox"
                    									data-options='{"mode":"datebox","useInline":false,"useInlineAlign":"center", "useLang":"pt-br", "afterToday":true,"beforeToday":false}' 
                    									name="data_internacao"
                    									readonly="readonly"
                    									value="<?php echo formatarData($objInternacao->data_internacao)  ?>"
                    									required="required"
                    									>
                    						</div>
                                        </div>
                                        <!--  
                                        <div class="form-group col-sm-6">
                                        	<label>Registro de Internação</label> <span style="color: red;"> *</span>
                                           	<textarea required="required" placeholder="Registro de internação" class="form-control" name="registro"><?php echo $objPaciente->registro ? $objPaciente->registro : "" ?></textarea>
                                        </div>
                                        -->
                                        <div class="form-group col-sm-6">
                    						<label>Setor</label><span style="color: red;"> *</span>  
                        							<select class="form-control" name="id_setor" required="required">
                        							<?php foreach ($setores as $setor) { ?>
                            							<option value="<?php echo $setor->id?>" id="<?php echo $setor->id ?>" <?php echo $objInternacao->id_setor == $setor->id ? 'selected' : ''?>>
                            							<?php echo $setor->nome; ?>
                            							</option>
                        							<?php
                        							} 
                        							?>	
                        							</select>						
                						</div>
       
                                        <div class="row">&nbsp;</div>  
                                        <div>
                                        	<button class="btn btn-white" type="button" onclick="history.go(-1);">Cancelar</button>
                                            <button class="btn btn-primary" type="submit">Salvar</button>
                                        </div>
                                    </form>
                         		</div>
                            </div>
                        </div>


                    </div>
                </div>
            	
               	</div>
           	</div>
       	</div>
    </div>
</div>