<?php 

$filtro_atual = $_REQUEST['filtro'];
$dashboard = new Dashboard();
$dashboard_pie = new Dashboard();
$objChecklist = new Checklist();

if (!isset($filtro_atual)){
    $dashboard->definirDataFiltroCheckListInicial(NULL,true);
    $filtro_atual = FILTRO_INICIAL;
}

$dashboard->getDashboarPorChecklist($filtro_atual,true);
$dashboard_pie->getDashboarPorChecklist($filtro_atual,true,"VF");
$numeroPacientesCheckListMes = count($dashboard->getNumeroPacientesCkecklistMes($filtro_atual));
$preenchidosCheckListMes = count($dashboard->getNumeroPreenchidosCkecklistMes($filtro_atual));
$objChecklist = $objChecklist->listarPorIdFiltro($filtro_atual);
    
?>      
        <div class="wrapper wrapper-content">
            <div class="container">
            
            <div class="ibox-title">
                <div class="pull-right">
                	 <div class="btn-group">
				
			<form name="form_filtro_dashboard" action="/" method="POST">
                	  <label class="form-check-label"> 
				<select name="filtro" id="filtro_dashboard" onchange="javascript:filtrar(this)" class="form-control select2_demo_2_checklist">
							<?php
							
							foreach ( $dashboard->getDashboarFiltroPorChecklist(NULL,NULL,true) as $filtro) {
							    $filtro_ativo = $filtro['id_checklist']."|".$filtro['data_resposta'] == $filtro_atual ? "selected" : "";
								?>
								<option value="<?php echo $filtro['id_checklist']."|".$filtro['data_resposta'] ?>" <?php echo $filtro_ativo?>> <?php echo $filtro['label']?> </option>
							<?php
							}
							?>
                    		</select>
                    	  </label>
			</form>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Total</span>
                            <h5>N. de Pacientes cadastrados</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins"><a href="/checklist"><?php printf("%02d",$numeroPacientesCheckListMes) ?></a><small> Cadastrado(s) </small></h1>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Total</span>
                            <h5>N. de bundles preenchidos</h5>
                        </div>
                        <div class="ibox-content">
                        	<h1 class="no-margins"><a href="/paciente"><?php printf("%02d", $preenchidosCheckListMes) ?></a><small> Preenchido(s)</small></h1>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
            
            
            	<div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Bundles - <?php echo strtoupper($objChecklist->sigla." | ".formatarFiltro($filtro_atual))?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                           			 <canvas id="barChartChecklist" height="170"></canvas>
                                        		</div>
                                            </div>
                                    	</div>
                                	</div>
                                
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            	
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
			</div>
            <div class="col-lg-12">
            
            	       <?php 
            	       //esse if foi um cat pra resolver mais facil
            	       $questoes_pie = [];
            	       if ($dashboard_pie->grafico_barras_inicial["labels"] != '"ADESÃO BUNDLE",""'){
            	           $dashboard_pie->grafico_barras_inicial["labels"] = str_replace('"ADESÃO BUNDLE",', "", $dashboard_pie->grafico_barras_inicial["labels"]);
            	           $questoes_pie = explode(",", $dashboard_pie->grafico_barras_inicial["labels"]);
                            echo '<div class="row">';
                            for ($i=0; $i < sizeof($questoes_pie); $i++){ ?>
                            <div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5><?php echo str_replace('"', '', $questoes_pie[$i])?></h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div>
                                        	 <div id="pie_<?php echo $i?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            if ((($i+1) % 2)==0){
                                echo '</div><div class="row">';
                            }
                        }
                        ?>
                    
                    <?php 
                          echo '</div>';
                        }
                     ?>
 
        </div>     
<script>

function filtrar(obj){//alert(obj.value);
  document.form_filtro_dashboard.submit();
}

$(document).ready(function() {

  <?php 
  $array_respostas = $dashboard_pie->grafico_barras_inicial["respostas"];
	
	for ($i=0; $i < sizeof($questoes_pie); $i++){ 
	    $array_pie_alternativa = explode(",",$dashboard_pie->grafico_barras_inicial["item_vf"][$i]["alternativa"]);
	    $array_pie_total = explode(",",$dashboard_pie->grafico_barras_inicial["item_vf"][$i]["total"]);
	    $data=NULL;
	    for ($y=0;$y<sizeof($array_pie_alternativa);$y++){
	        $data .= "[$array_pie_alternativa[$y],$array_pie_total[$y]],";
	    }?>
            c3.generate({
                bindto: '#pie_<?php echo $i?>',
                data:{
                    columns: [
                        <?php echo $data?>
                    ],
                    type : 'pie'
                }
            });
    
	<?php }?>

     
  var barData = {
	        labels: [<?php echo $dashboard->grafico_barras_inicial["labels"]?>],
	        datasets: [
	            {
	            	label: "SIM",
	                borderColor: "rgba(26,179,148,0.7)",
	                pointBackgroundColor: "rgba(26,179,148,1)",
	                pointBorderColor: "rgba(255,255,255,255)",
	                data: [<?php echo $dashboard->grafico_barras_inicial["resposta_tipo_1"]?>],	 
	                backgroundColor: [
	                    'rgba(248, 172, 89, 0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                    'rgba(26,179,148,0.5)',
	                ],               
// 	            {
// 	                label: "NÃO",
// 	                backgroundColor: 'rgba(248, 172, 89, 0.5)',
// 	                pointBorderColor: "#fff",
//	                data: [<?php #echo $dashboard->grafico_barras_inicial["resposta_tipo_2"]?>]
// 	            }
	            }]
	    };

  Chart.defaults.global.defaultFontSize = '15';
  
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
			yAxes: [{ticks: {min: 0, max: <?php echo $dashboard->grafico_barras_inicial["maior_valor"]?>}}],
	        //xAxes: [{gridLines: {offsetGridLines: true}}],
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

	//Grafico pizza
	var radar_total2 = c3.generate({
    	bindto: '#pizzaChartChecklist',
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
