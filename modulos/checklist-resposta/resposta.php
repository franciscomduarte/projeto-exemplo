<?php 

	define("NOME_MODULO", "Questionários"); 
	define("NOME_ACAO", "Responder"); 
	include_once 'breadcrumb.php';
	
	$params = retornaParametrosUrl($_SERVER['QUERY_STRING']);
	$id_checklist = $params[2];
	$id_internacao = $params[3];
	
	$obj = new Checklist();
	$questionario = $obj->listarPorId($id_checklist);
	
?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
	                    <div class="ibox-content">
						<div class="ibox ">
                        <div class="ibox-title">
                            <h5><?php echo "Bundle - ".$questionario->sigla?></h5>
                        </div>
                        <form role="form" action="/checklist-resposta/gravar" method="post">
                        <input type="hidden"  value="<?php echo $id_checklist?>" name="id_checklist">
                        <input type="hidden"  value="<?php echo $id_internacao ?>" name="id_internacao">
                        <div class="ibox-content">
							<?php 
							$item = new Item();
							$itensChecklist = $item->listarPorIdChecklist($id_checklist);
                                foreach ($itensChecklist as $i) { ?>
                                	<div class="form-group">
                                		<label class="text-navy"><?php echo $i->enunciado ?><br/></label>
                                	
                                	<?php $objAlternativa = new Alternativa(); 
                                	      $alternativas =$objAlternativa->listarComItem($i->id);
                                	?>	
                                	<?php 
                                	   if ($i->tipo == 'ME')  { 
                                	       foreach ($alternativas as $alternativa) { ?>
                                    			<div class="i-checks"><label> <input type="checkbox" value="<?php echo $alternativa->id ?>" name="<?php echo $alternativa->id ?>"> <i></i> <?php echo $alternativa->descricao ?> </label></div>
                                	<?php  }
                                	   }
                                	?>
                                	
                                	<?php if ($i->tipo == 'TX')  { ?>
                                		<input type="text" value="" class="form-control" name="tx-<?php echo $i->id?>" maxlength="200" size="200">
                                	<?php } ?>
                                	
                                	<?php 
                                	   if ($i->tipo == 'VF')  {
                                	       foreach ($alternativas as $alternativa) { 
                                	?>
												<div class="i-checks"><label> <input required="required" type="radio" value="<?php echo $alternativa->id ?>" name="vf-<?php echo $i->id?>"> <i></i> <?php echo $alternativa->descricao ?> </label></div>
                                	<?php  }
                                	   }
                                	?>
                                	
                                	<?php 
                                	   if ($i->tipo == 'SN')  {
                                	       foreach ($alternativas as $alternativa) { 
                                	?>
												<div class="i-checks"><label> <input required="required" type="radio" value="<?php echo $alternativa->id ?>" name="sn-<?php echo $i->id?>"> <i></i> <?php echo $alternativa->descricao ?> </label></div>
                                	<?php  }
                                	   }
                                	?>
                                	
                                	<?php if ($i->tipo == 'MV')  { ?>
                                		<select multiple="multiple" class="form-control">
                                			<option>Opção 1</option>
                                		</select>
                                	<?php } ?>
                                	
                                	<div class="hr-line-dashed"></div>
                                <?php } ?>
	                    </div>
	                    <div>
                        	<button class="btn btn-white" type="button" onclick="history.go(-1);">Cancelar</button>
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </div>
	                </div>
	                </form>
	            </div>
            </div>
        </div>
     </div>
  </div>
