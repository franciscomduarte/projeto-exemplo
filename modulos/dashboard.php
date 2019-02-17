<?php 

$filtro_atual = $_REQUEST['filtro'];
$dashboard = new Dashboard();

if (!isset($filtro_atual)){
    $dashboard->definirDataFiltroCheckListInicial(NULL,true);
    $filtro_atual = FILTRO_INICIAL;
}

$dashboard->getDashboarPorChecklist($filtro_atual,true);
    
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
                                	 	<select name="filtro" id="filtro_dashboard" class="form-control">
            								<?php
            								
            								foreach ( $dashboard->getDashboarFiltroPorChecklist(NULL,NULL,true) as $filtro) {
            								    $filtro_ativo = $filtro['id_checklist']."|".$filtro['data_resposta'] == $filtro_atual ? "selected" : "";
            									?>
            									<option value="<?php echo $filtro['id_checklist']."|".$filtro['data_resposta'] ?>" <?php echo $filtro_ativo?>> <?php echo $filtro['label']?> </option>
            								<?php
            								}
            								?>
            	                    		</select>
                                    </div>
                                </div>
                            </div>
                            
                           <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <span class="label label-success pull-right">Total</span>
                                                <h5>Número de Pacientes</h5>
                                            </div>
                                            <div class="ibox-content">
                                            	<h1 class="no-margins"><a href="/paciente"><?php printf("%02d",$dashboard->total["paciente"]) ?></a><small> internados(s) no mês</small></h1>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <span class="label label-success pull-right">Total</span>
                                                <h5>Check Lists preenchidos</h5>
                                            </div>
                                            <div class="ibox-content">
                                            	<h1 class="no-margins"><a href="/paciente"><?php printf("%02d",$dashboard->total["paciente"]) ?></a><small> Preenchidos(s) no mês</small></h1>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                   			 <canvas id="barChartChecklist" height="140"></canvas>
                                		</div>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>
           <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                
                                <div class="pull">
                                	<h5>Legenda</h5>
                                	 <div class="btn-group" style="padding-top: 5px;">
                                	 	<span class="pull-right label label-danger"> < 90%</span>
                                	 	<span class="pull-right label label-warning" style="background-color: #F6C600; color: black;"> < 99%</span>
                                	 	<span class="pull-right label label-primary"> 100%</span>
                                    </div>
                                </div>
                            </div>
                       </div>
                   </div>
             </div>
             <?php 
                $questoes = explode(",", $dashboard->grafico_barras_inicial["labels"]);
                echo '<div class="row">';
                for ($i=0; $i < sizeof($questoes); $i++){ ?>
                <div class="col-lg-4">
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
                <?php 
                    if ((($i+1) % 3)==0){
                        echo '</div><div class="row">';
                    }
                }
                ?>
            
            <?php echo '</div>'?>
            
            <div class="row">
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
$('#filtro_dashboard').change(function(){
    location.href="/?filtro="+($(this).val());
});

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
// 	            {
// 	                label: "NÃO",
// 	                backgroundColor: 'rgba(248, 172, 89, 0.5)',
// 	                pointBorderColor: "#fff",
//	                data: [<?php echo $dashboard->grafico_barras_inicial["resposta_tipo_2"]?>]
// 	            }
	        ]
	    };

    var barOptions = {
        responsive: true,
        events: false,
        legend: false,
        animation: {
        	duration: 0,
        	onComplete: function () {
        	    // render the value of the chart above the bar
        	    var ctx = this.chart.ctx;
        	    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
        	    ctx.fillStyle = this.chart.config.options.defaultFontColor;
        	    ctx.textAlign = 'center';
        	    ctx.textBaseline = 'bottom';
        	    this.data.datasets.forEach(function (dataset) {
        	        for (var i = 0; i < dataset.data.length; i++) {
        	            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
        	            ctx.fillText(dataset.data[i]+'%', model.x, model.y - 5);
        	        }
        	    });
        	}},
        scales: {
			yAxes: [{ticks: {min: 0, max: <?php echo $dashboard->grafico_barras_inicial["maior_valor"]?>}}]
		}
    };

    var ctx2 = document.getElementById("barChartChecklist").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
//Grafico Total
	var radar_total = c3.generate({
    	bindto: '#gauge_total',
        data: {
            columns: [['PREVISTOS','<?php echo $dashboard->grafico_barras_inicial["total_previsto"]?>'],
            	      ['RESPONDIDOS','<?php echo $dashboard->grafico_barras_inicial["total_respondido"]?>']],
            type: 'gauge'
        },
        gauge: {
			label: 
				{
					format: function (value, ratio) {
			    	return value;
		    	}
	    	}
        },
        color: {
            pattern: ['#FF0000', '#f4ae70', '#F6C600', '#8CD9C9'], // the three color levels for the percentage values.
            threshold: {
                values: [30, 60, 90, 100]
            }
        },
        size: {
            height: 120
        }
    });

// Graficos Questões	
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
            pattern: ['#FF0000', '#F6C600', '#1ab394'], // the three color levels for the percentage values.
            threshold: {
                values: [89, 99, 100]
            }
        },
        size: {
            height: 165
        }
    });

    setTimeout(function () {
    	radar_<?php echo $i?>.load({
            columns: [['META', "100"]]
        });
    }, 0);


	<?php } ?>
    
});
</script>
