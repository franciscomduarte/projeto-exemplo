<?php
$params = retornaParametrosUrl($_SERVER['QUERY_STRING']);
$id = $params[2];

// Solucao de contorno para edição de usuários.
if ($_SESSION["usuario"] != "Eric Soares Dias" || 
	$_SESSION["usuario"] != "Flaviano O. Silva" || 
	$_SESSION["usuario"] != "DR. ALEXANDRE OLIMPIO" || 
	$_SESSION["usuario"] != "Admin"){
		echo "Acesso Bloqueado...";
		exit();
}

if ($id) {
	$usuario = new Usuario ();
	$obj = $usuario->listarPorChave($id);
}
if (strpos($_SERVER['QUERY_STRING'],"view")){
    $view = true;
}
?>

<div class="col-lg-12">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h5>
				Cadastro de Usuarios<small></small>
			</h5>
		</div>
		<div class="ibox-content">
			<div class="row">

				<form role="form" action="/usuario/gravar" method="post">
					<input type="hidden" name="id"
						value="<?php echo $obj->chave ? $obj->chave : null ?>">
					<div class="form-group col-xs-12 m-sm">

						<div class="form-group col-xs-6">
							<div class="form-group">
								<label>Nome</label><span style="color: red;"> *</span> <input type="text"
									value="<?php echo $obj->nome ? $obj->nome : null ?>"
									placeholder="Insira o nome" class="form-control" name="nome"
									required="required" <?php disableInput($view)?>>
							</div>
						</div>

						<div class="form-group col-xs-6">
							<div class="form-group">
								<label>Email</label><span style="color: red;"> *</span> <input type="email"
									value="<?php echo $obj->email ? $obj->email : null ?>"
									placeholder="Insira o email" class="form-control" name="email"
									required="required" <?php disableInput($view)?>>
							</div>
						</div>

						<div class="form-group col-xs-6">
							<div class="form-group">
								<label>Senha</label><span style="color: red;"> *</span> <input type="password"
									value="<?php echo $obj->senha ? $obj->senha : null ?>"
									placeholder="Insira a senha" class="form-control" name="senha"
									required="required" <?php disableInput($view)?>>
							</div>
						</div>

						<div class="form-group col-xs-6">
							<div class="form-group">
								<label>Perfil</label><span style="color: red;"> *</span>
								
								<select name="perfil" required="required"
								class="form-control" <?php disableInput($view)?>>
								<option value="">-- Selecione --</option>
								<?php
								$perfil = new Perfil();
								$listaPerfil = $perfil->listar();
								foreach ( $listaPerfil as $perfil) {
									?>
									<option value="<?php echo $perfil->id ?>" <?php echo ($obj->perfil->id == $perfil->id ? 'selected="selected"' : '')?>> <?php echo $perfil->descricao?> </option>
								<?php
								}
								?>
	                    		</select>
								
							</div>
						</div>

						<div class="form-group col-xs-6">
							<div class="form-group">
								<label>CPF</label><span style="color: red;"> *</span> <input type="text"
									value="<?php echo $obj->cpf ? $obj->cpf : null ?>"
									placeholder="Insira o CPF" class="form-control" name="cpf"
									required="required" data-mask="999.999.999-99" <?php disableInput($view)?>>
							</div>
						</div>

						<div class="form-group col-xs-4 ">
							<p>
								<label>Status</label><span style="color: red;"> *</span>
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

						<div class="form-group col-xs-12 ">
							<div>
								<button class="btn btn-white" type="button"
									onclick="history.go(-1);">Voltar</button>
								<?php if (!$view) {?>
								<button class="btn btn-primary" type="submit" >Salvar</button>
								<?php }else{?>
								<button onclick="location.href='/usuario/novo/<?php echo $id?>'" class="btn btn-warning" type="button" >Editar</button>
								<?php }?>
							</div>
						</div>
						
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
