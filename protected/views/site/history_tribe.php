<?php
    $cs = Yii::app()->clientScript;
    $pt = Yii::app()->homeUrl;
    
    $cs->registerScriptFile($pt.'js/highcharts.js');
    $cs->registerScriptFile($pt.'js/sand-signika.js');
    
    $days = array();
    
    $data_prepoints = array();
    $data_points = array();
    
    $data_previllages = array();
    $data_villages = array();
    
    $data_premembers = array();
    $data_members = array();
    
    $date_prebash_total = array();
    $date_prebash_off = array();
    $date_prebash_def = array();
    
    $date_bash_total = array();
    $date_bash_off = array();
    $date_bash_def = array();
    
    foreach ( $model as $h ) {
        $_day = date('d M', $h->date);
        $data_prepoints[$_day] = $h->points;
        $date_prebash_total[$_day] = $h->bash_points_total;
        $date_prebash_off[$_day] = $h->bash_points_off;
        $date_prebash_def[$_day] = $h->bash_points_def;
        $data_previllages[$_day] = $h->villages;
        $data_premembers[$_day] = $h->members;
    }
    
    for ( $i=13; $i>=0; $i-- ) {
        $need_date = date('d M', time()-3600*24*$i);;
        $days[] = $need_date;
        
        if ( strlen($data_prepoints[$need_date])!=0 ) {
            $data_points[] = (int)$data_prepoints[$need_date];
        } else {
            $data_points[] = null;
        }
        
        if ( strlen($date_prebash_total[$need_date])!=0 ) {
            $date_bash_total[] = (int)$date_prebash_total[$need_date];
        } else {
            $date_bash_total[] = null;
        }
        
        if ( strlen($date_prebash_off[$need_date])!=0 ) {
            $date_bash_off[] = (int)$date_prebash_off[$need_date];
        } else {
            $date_bash_off[] = null;
        }
        
        if ( strlen($date_prebash_def[$need_date])!=0 ) {
            $date_bash_def[] = (int)$date_prebash_def[$need_date];
        } else {
            $date_bash_def[] = null;
        }
        
        if ( strlen($data_previllages[$need_date])!=0 ) {
            $data_villages[] = (int)$data_previllages[$need_date];
        } else {
            $data_villages[] = null;
        }
        
        if ( strlen($data_premembers[$need_date])!=0 ) {
            $data_members[] = (int)$data_premembers[$need_date];
        } else {
            $data_members[] = null;
        }
    }
    
    
    
?>
<script>
    $(document).ready(function(){
        $('#s_tribe').val('<?= $tribe->tag ?>');
        $('#go_search_tribe').click();
        
        $('#chart1').highcharts({
            title: {
                text: '[<?= $tribe->tag ?>] <?= $tribe->name ?> points',
                x: -20
            },
            subtitle: {
                text: 'For the last 2 weeks',
                x: -20
            },
            xAxis: {
                categories: <?= json_encode($days) ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Points'
                },
                allowDecimals: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '[<?= $tribe->tag ?>] <?= $tribe->name ?>',
                data: <?= json_encode($data_points) ?>
            }]
        });
        
        $('#chart2').highcharts({
            title: {
                text: '[<?= $tribe->tag ?>] <?= $tribe->name ?> defeated enemies (the total amount)',
                x: -20
            },
            subtitle: {
                text: 'For the last 2 weeks',
                x: -20
            },
            xAxis: {
                categories: <?= json_encode($days) ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Points'
                },
                allowDecimals: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [/*{
                name: 'Total',
                zIndex: 3,
                data: <?= json_encode($date_bash_total) ?>
            },*/ {
                name: 'Off',
                zIndex: 2,
                data: <?= json_encode($date_bash_off) ?>
            }, {
                name: 'Def',
                zIndex: 1,
                data: <?= json_encode($date_bash_def) ?>
            }]
        });
        
        $('#chart3').highcharts({
            title: {
                text: '[<?= $tribe->tag ?>] <?= $tribe->name ?> villages',
                x: -20
            },
            subtitle: {
                text: 'For the last 2 weeks',
                x: -20
            },
            xAxis: {
                categories: <?= json_encode($days) ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Villages'
                },
                allowDecimals: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '[<?= $tribe->tag ?>] <?= $tribe->name ?>',
                data: <?= json_encode($data_villages) ?>
            }]
        });
        
        $('#chart4').highcharts({
            title: {
                text: '[<?= $tribe->tag ?>] <?= $tribe->name ?> members',
                x: -20
            },
            subtitle: {
                text: 'For the last 2 weeks',
                x: -20
            },
            xAxis: {
                categories: <?= json_encode($days) ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Members'
                },
                allowDecimals: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '[<?= $tribe->tag ?>] <?= $tribe->name ?>',
                data: <?= json_encode($data_members) ?>
            }]
        });
    });
</script>

<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
    'title' => 'Tribe history' . ' - <strong>[' . $tribe->tag . '] '. $tribe->name .'</strong>',
)); ?>

    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#points" role="tab" data-toggle="tab">Points chart</a></li>
        <li><a href="#members" role="tab" data-toggle="tab">Members chart</a></li>
        <li><a href="#villages" role="tab" data-toggle="tab">Villages chart</a></li>
        <li><a href="#bash" role="tab" data-toggle="tab">Defeated enemies chart</a></li>
        <li><a href="#table" role="tab" data-toggle="tab">History in table</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="points">
            <div id="chart1" style="width:1108px; height:500px;"></div>
        </div>
        
        <div class="tab-pane" id="members">
            <div id="chart4" style="width:1108px; height:500px;"></div>
        </div>
        
        <div class="tab-pane" id="villages">
            <div id="chart3" style="width:1108px; height:500px;"></div>
        </div>
        
        <div class="tab-pane" id="bash">
            <div id="chart2" style="width:1108px; height:500px;"></div>
        </div>
        
        <div class="tab-pane" id="table">
            <div class="server_date">
                <?= Yii::app()->dateFormatter->format('dd MMMM, HH:mm', time()) ?> - current server date.
            </div>
            <?php $this->widget('bootstrap.widgets.BsGridView',array(
                'id'=>'points2-grid',
                'dataProvider'=>$dataProvider,
                'enableSorting'=>false,
                'type' => BsHtml::GRID_TYPE_HOVER.' '.BsHtml::GRID_TYPE_CONDENSED,
                'template' => '{summary}{pager}{items}{pager}',
                'pagerCssClass'=>'pagination pagination-right',
                'selectableRows'=>0,
                //'afterAjaxUpdate'=>'function(){updateGrid();}',
                'columns'=>array(
                    array(
                        'name'=>'date',
                        'value'=>'Yii::app()->dateFormatter->format(\'dd MMMM, HH:mm\', $data->date)'
                    ),
                    'rank',
                    'points',
                    'members',
                    'villages',
                    'bash_points_off',
                    'bash_points_def',
                    'bash_points_total'
                ),
            )); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>