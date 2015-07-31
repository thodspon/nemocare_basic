<?php
$this->title = 'จำนวนผู้ป่วยในแยกรายเดือน';
$this->params['breadcrumbs'][] = $this->title;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
?>
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i> ค้นหาข้อมูล</h3>
            </div>
            <div class="panel-body">
               
                <?= Html::beginForm();?>
                <?= Html::dropDownList('year',null,['2014'=>'2014','2015'=>'2015'],['class'=>'form-control']);?>
                <?= Html::submitButton('ค้นหา',['class'=>'btn btn-info']);?>
                <?= Html::endForm();?>
           
            </div>
        </div>
     </div>
    <div class="col-md-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i> จำนวนผู้ป่วยในแยกรายเดือน</h3>
            </div>
            <div class="panel-body">
                <?php
                echo Highcharts::widget([
                    'options' => [
                        'title' => ['text' => 'จำนวนผู้ป่วยในแยกรายเดือน'],
                        'xAxis' => [
                            'categories' => $mm
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'จำนวน(คน)']
                        ],
                        'series' => [
                            [//'type'=>'line',
                                'name' => 'จำนวนผู้ป่วยใน',
                                'data' => $cnt,
                            ],
                            ['name' => 'ผลรวม', 'data' => $sumadj],
                            ['name' => 'LOS', 'data' => $los],
                        ]
                    ]
                ]);
                ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i> ค่าเฉลี่ย CMI แยกรายเดือน</h3>
            </div>
            <div class="panel-body">
                <?php
                echo Highcharts::widget([
                    'options' => [
                        'title' => ['text' => 'ค่าเฉลี่ย CMI แยกรายเดือน'],
                        'xAxis' => [
                            'categories' => $mm
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'เฉลี่ย(คน)']
                        ],
                        'series' => [
                            ['type' => 'column',
                                'name' => 'CMI',
                                'data' => $cmi,
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i> นอนเฉลี่ยต่อราย</h3>
            </div>
            <div class="panel-body">
                <?php
                echo Highcharts::widget([
                    'options' => [
                        'title' => ['text' => 'นอนเฉลี่ยต่อราย'],
                        'xAxis' => [
                            'categories' => $mm
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'เฉลี่ย(คน)']
                        ],
                        'series' => [
                            ['type' => 'column',
                                'name' => 'Per Case',
                                'data' => $los_per_case,
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> สรุปข้อมูลผู้ป่วยใน</h3>',
                'type' => 'success',
                //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> โหลดข้อมูลใหม่', ['/report/report/report3'], ['class' => 'btn btn-info']),
                'footer' => false
            ],
            'responsive' => true,
            'hover' => true,
            'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'beforeGrid' => '',
                'afterGrid' => '',
            ],
            'showPageSummary' => true,
            'columns' => [
                //['class'=>'yii\grid\SerialColumn'],
                [
                    'label' => 'ปี',
                    'attribute' => 'yy'
                ],
                [
                    'label' => 'เดือน',
                    'attribute' => 'mm'
                ],
                [
                    'label' => 'จำนวนผู้ป่วยใน',
                    'attribute' => 'cnt'
                ],
                [
                    'label' => 'รวม',
                    'attribute' => 'sumadj',
                    'format' => ['decimal', 4]
                ],
                [
                    'label' => 'CMI',
                    'attribute' => 'cmi'
                ],
                [
                    'label' => 'LOS',
                    'attribute' => 'los',
                    'format' => ['decimal']
                ],
                [
                    'label' => 'นอนเฉลี่ยต่อราย',
                    'attribute' => 'los_per_case'
                ],
            ]
        ]);
        ?>
    </div>
</div>