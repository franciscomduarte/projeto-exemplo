<?php 
$filtro_atual = $_REQUEST['filtro'];
if (!isset($filtro_atual))
    $filtro_atual = FILTRO_INICIAL;

$dashboard = new Dashboard();
$dashboard->getDashboarPorChecklist($filtro_atual);
    
?>       
        <div class="wrapper wrapper-content">
            <div class="container">
            <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Checklists</h5>
                                <div class="pull-right">
                                	 <div class="btn-group">
                                        <?php 
                                            foreach ($dashboard->getDashboarFiltroPorChecklist() as $filtro) {
                                                $filtro_ativo = $filtro['id_checklist']."|".$filtro['data_resposta'] == $filtro_atual ? "success active" : "white";?>   
                                            <button type="button" onclick="location.href='/?filtro=<?php echo $filtro['id_checklist']."|".$filtro['data_resposta']?>'" class="btn btn-xs btn-<?php echo $filtro_ativo?>"><?php echo $filtro['label']?></button>    
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                   			 <canvas id="barChartChecklist" height="120"></canvas>
                                		</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            
           <div class="row">
             <?php 
                $questoes = explode(",", $dashboard->grafico_barras_inicial["labels"]);
                for ($i=0; $i < sizeof($questoes); $i++){ ?>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo str_replace('"', '', $questoes[$i])?></h5>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <div id="gauge_<?php echo $i?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            
			 <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">Qtd</span>
                            <h5>Dados do Sistema</h5>
                        </div>
                        
                        <div class="ibox-content">
                        		<div class="row">

	    					       	<div class="col-xs-4">
	                                    <h4><a href="#">Pacientes: </a></h4>
	                                     <small class="stats-label"><?php printf("%02d",$dashboard->total["paciente"])?></small>
	                                </div>
	    
	                                <div class="col-xs-4">
	                                    <small class="stats-label">Cadastrados</small>
	                                    <h4><a href="#"><?php printf("%02d",$dashboard->total["paciente"])?></a></h4>
	                                </div>
	                                <div class="col-xs-4">
	                                    <small class="stats-label">Internados</small>
	                                    <h4><a href="#"><?php printf("%02d",$dashboard->total["internacao"])?></a></h4>
	                                </div>

									<?php $dashboard->getDashboardInternados();?>
									
	    					       	<div class="col-xs-4">
	                                    <h4><a href="#">Internações: </a></h4>
	                                    <small class="stats-label"><?php printf("%02d",$dashboard->total_internados["total"])?></small>
	                                </div>
	    
	                                <div class="col-xs-4">
	                                    <small class="stats-label">Internados</small>
	                                    <h4><a href="#"><?php printf("%02d",$dashboard->total_internados["internado"])?></a></h4>
	                                </div>
	                                <div class="col-xs-4">
	                                    <small class="stats-label">Dispensados</small>
	                                    <h4><a href="#"><?php printf("%02d",$dashboard->total_internados["dispensado"])?></a></h4>
	                                </div>
    							</div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Total</span>
                            <h5>Cheklists</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins"><a href="/checklist"><?php printf("%02d",$dashboard->total["checklist"]) ?></a><small> Cadastrado(s) </small></h1>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Total</span>
                            <h5>Pacientes</h5>
                        </div>
                        <div class="ibox-content">
                        	<h1 class="no-margins"><a href="/paciente"><?php printf("%02d",$dashboard->total["paciente"]) ?></a><small> Cadastrado(s)</small></h1>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Total</span>
                            <h5>Internações</h5>
                        </div>
                        <div class="ibox-content">
                        	<h1 class="no-margins"><a href="/internacao"><?php printf("%02d",$dashboard->total["internacao"]) ?></a><small> Cadastrado(s)</small></h1>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Total</span>
                            <h5>Respostas</h5>
                        </div>
                        <div class="ibox-content">
                        	<h1 class="no-margins"><a href="#"><?php  printf("%02d",$dashboard->total["resposta_checklist"]) ?></a><small> Cadastrado(s)</small></h1>
                        </div>
                    </div>
                </div>
            </div>

            </div>

        </div>
        
<script>
$(document).ready(function() {
	
  var barData = {
	        labels: [<?php echo $dashboard->grafico_barras_inicial["labels"]?>],
	        datasets: [
	            {
	            	label: "SIM",
	                backgroundColor: 'rgba(26,179,148,0.5)',
	                borderColor: "rgba(26,179,148,0.7)",
	                pointBackgroundColor: "rgba(26,179,148,1)",
	                pointBorderColor: "#fff",
	                data: [<?php echo $dashboard->grafico_barras_inicial["resposta_tipo_1"]?>]
	            },
	            {
	                label: "NÃO",
	                backgroundColor: 'rgba(248, 172, 89, 0.5)',
	                pointBorderColor: "#fff",
	                data: [<?php echo $dashboard->grafico_barras_inicial["resposta_tipo_2"]?>]
	            }
	        ]
	    };

    var barOptions = {
    	animation: false,
        responsive: true,
        tooltipTemplate: "<%= value %>",
        tooltipFillColor: "rgba(0,0,0,0)",
        tooltipFontColor: "#444",
        tooltipEvents: [],
        tooltipCaretSize: 0,
        onAnimationComplete: function(){
            this.showTooltip(this.datasets[0].bars, true);
        },
        scales: {
			yAxes: [{
				ticks: {
					min: 0,
					max: <?php echo $dashboard->grafico_barras_inicial["maior_valor"]?>
				}
			}]
		}
    };

    var ctx2 = document.getElementById("barChartChecklist").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

	
	<?php 
	$respostas_sim = explode(",",$dashboard->grafico_barras_inicial["resposta_tipo_1"]);
	#$respostas_nao = explode(",",$dashboard->grafico_barras_inicial["resposta_tipo_2"]);
	for ($i=0; $i < sizeof($questoes); $i++){ 
	?>
	
    var radar_<?php echo $i?> = c3.generate({
    	bindto: '#gauge_<?php echo $i?>',
        data: {
            columns: [['SIM','<?php echo $respostas_sim[$i]?>']],
            type: 'gauge'
        },
        gauge: {},
        color: {
            pattern: ['#FF0000', '#f4ae70', '#F6C600', '#8CD9C9'], // the three color levels for the percentage values.
            threshold: {
                values: [30, 60, 90, 100]
            }
        },
        size: {
            height: 180
        }
    });

    setTimeout(function () {
    	radar_<?php echo $i?>.load({
            columns: [['meta', "75"]]
        });
    }, 0);


	<?php } ?>

















    
});
</script>
