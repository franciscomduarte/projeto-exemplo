<?php
$params = retornaParametrosUrl($_SERVER['QUERY_STRING']);
$id = $params[2];

$_SESSION['item']      = NULL;
$_SESSION['checklist'] = NULL;
$view = false;

if ($id) {
	$checklist = new Checklist();
	$obj = $checklist->listarPorId($id);
}else{
    $obj = new Checklist();
    $obj->usuario->nome = $_SESSION['usuario']['nome'];
}
if (strpos($_SERVER['QUERY_STRING'],"view")){
    $view = true;
}else if (strpos($_SERVER['QUERY_STRING'],"add")){
    $view = true;
    $add = true;
}

?>

<div class="col-lg-12">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h5>
				Cadastro de Bundles<small></small>
			</h5>
		</div>
		<div class="ibox-content">
			<div class="row">

				<form role="form" action="/checklist/gravar" method="post">
					<input type="hidden" name="id"
						value="<?php echo $obj->id ? $obj->id : null ?>">
					<div class="form-group col-xs-12 m-sm">

						<div class="form-group col-xs-12">
							<div class="form-group">
								<label>Nome</label> <input type="text"
									value="<?php echo $obj->nome ? $obj->nome : null ?>"
									placeholder="Insira o nome" class="form-control" name="nome"
									required="required" <?php disableInput($view)?>>
							</div>
						</div>

						<div class="form-group col-xs-6">
							<div class="form-group">
								<label>Cor</label> 
                            	<input type="text" 
                            			class="form-control colorpicker" 
                            			value="#5367ce" readonly="readonly" name="cor"
                            			required="required" <?php disableInput($view)?>/>
                            </div>
                        </div>
                        
                        <div class="form-group col-xs-6">
							<div class="form-group">
								<label>Sigla</label> <input type="text"
									value="<?php echo $obj->sigla ? $obj->sigla : null ?>"
									placeholder="Digite a sigla" class="form-control" name="sigla"
									required="required" <?php disableInput($view)?>>
							</div>
						</div>
						
						<div class="form-group col-xs-6">
							<p>
								<label>Status</label>
							</p>
							<div class="radio radio-info radio-inline">
								<input type="radio" id="ativo" value="1" name="ativo" <?php disableInput($view)?>
									<?php echo $obj->ativo ? "checked" : ""?>> <label for="ativo">
									Ativo </label>
							</div>

							<div class="radio radio-inline">
								<input type="radio" id="inativo" value="0" name="ativo" <?php disableInput($view)?>
								<?php echo !$obj->ativo ? "checked" : ""?>> <label
									for="inativo"> Inativo </label>
							</div>
						</div>
		                
		                <div class="form-group col-xs-3">
							<div class="form-group">
								<label>Meta</label> <input type="number" min="10" max="100" step="5" style="width: 5em;"
									value="<?php echo $obj->meta ? $obj->meta : null ?>"
									placeholder="Digite a meta" class="form-control" name="meta"
									required="required" <?php disableInput($view)?>>
							</div>
						</div>


						<div class="form-group col-xs-12">
							<div class="form-group">
								<label>Usu??rio Respons??vel</label> 
								<p><?php echo $obj->usuario->nome ? $obj->usuario->nome : null ?></p>
							</div>
						</div>
						
						<div class="form-group col-xs-12 ">
							<div>
								<button class="btn btn-white" type="button"
									onclick="history.go(-1);">Voltar</button>
								<?php if (!$view) {?>
								<button class="btn btn-primary" type="submit">Salvar</button>
								<?php }else{?>
								<button onclick="location.href='/checklist/novo/<?php echo $id?>'" class="btn btn-warning" type="button" >Editar</button>
								<?php }?>
								<?php if ($id != ""){?>
								<!--button onclick="location.href='/checklist/add-item/<?php echo $id?>?add'" class="btn btn-primary" type="button">Adicionar itens</button-->
								<?php }?>
							</div>
						</div>
						
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
