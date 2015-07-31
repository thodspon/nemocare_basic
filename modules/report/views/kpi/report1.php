<?php


 $this->title = 'รายงานข้อมูล Case Tiger-LC';
$this->params['breadcrumbs'][]=$this->title;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
<?php
echo Highcharts::widget(
        [
            'options'=>[
             'title' => ['text' => 'จำนวนผู้ป่วย ที่เข้าร่วมโครงการ Tiger-LC รายเดือน'],
      'xAxis' => [
         'categories' => $mm
      ], 
                'yAxis' => [
         'title' => ['text' => 'จำนวน(คน)']
      ],
      'series' => [
         [
             //'type' => 'column',
         'name' => 'จำนวนผู้ป่วย',
             'data'=>$cnt555,
             
             ]
      ]
            ]
            
        ]
        );

?>
 </div>
 
    <div class="col-md-12">
<?php
echo GridView::widget([
    'dataProvider'=>$dataProvider,
       'panel'=>[
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> สรุปข้อมูลผู้ป่วย ที่เข้าร่วมโครงการ Tiger-LC </h3>',
        'type'=>'success',
        //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> โหลดข้อมูลใหม่', ['/report/report/report1'], ['class' => 'btn btn-info']),
        'footer'=>false
    ],
    'columns'=>[
        ['class'=>'yii\grid\SerialColumn'],
        [
            'label'=>'ปี',
            'attribute'=>'yy'
        ],
        [
            'label'=>'เดือน',
            'attribute'=>'mm2'
        ],
        [
            'label'=>'จำนวนผู้ป่วยในโครงการ Tiger-LC',
            'attribute'=>'cnt555'
        ],
    ]
]);
?>
        
 </div>
</div>
