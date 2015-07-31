<?php
$this->title = 'รายงานข้อมูลที่บันทึก รายวันที่ '.$day.' '.$mm.' '.$year;
$this->params['breadcrumbs'][] = $this->title;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
//use kartik\dropdown\DropdownX;
?>
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i>เลือกวันที่ เพื่อค้นหาข้อมูล</h3>
            </div>
            <div class="panel-body">
               
                <?= Html::beginForm();?>
                <div class="col-sm-3 col-md-3">
                
               <?php
                    
                       
echo DatePicker::widget([
    'name' => 'date',
     'id' => 'date',
    'value' => date("Y-m-d"),
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]);

                        ?>
                    
                </div>
                <div class="col-sm-3 col-md-3">
                <?= Html::submitButton('ค้นหา',['class'=>'btn btn-info']);?></div>
                <?= Html::endForm();?>
           
            </div>
        </div>
     </div>
    <div class="col-md-12">
         <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-align-center"></i>  ข้อมูลกราฟ</h3>
            </div>
            <div class="panel-body">
        <?php
    //   print_r($arraytype_from);
 if(empty($arraytype_from['-Screening-'])){
     
              $arraytype_from['-Screening-']=[0];}
              if(empty($arraytype_from['KPI_57'])){
     
              $arraytype_from['KPI_57']=[0];}
              if(empty($arraytype_from['Scope'])){
     
             $arraytype_from['Scope']=[0];}
              if(empty($arraytype_from['ScreeningReport'])){
     
              $arraytype_from['ScreeningReport']=[0];}
              if(empty($arraytype_from['Tiger-LC'])){
     
              $arraytype_from['Tiger-LC']=[0];}
              if(empty($arraytype_from['tomor_board'])){
     
              $arraytype_from['tomor_board']=[0];}
        if(empty($arraytype_from['ClinicCaDay'])){

            $arraytype_from['ClinicCaDay']=[0];}
           
//print_r($arraytype_from['-Screening-']);
        echo Highcharts::widget(
                [
                    'options' => [
                        'title' => ['text' => 'จำนวนผู้ป่วยที่บันทึก รายวันที่ '.$day.' '.$mm.' '.$year],
                        'xAxis' => [
                            [

'categories' => $day2
                          //  'categories' => $mount
                            ],
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'จำนวน(คน)']
                        ],
                        'series' => [

                            //'type' => 'column',
                            [ 'type' => 'column',
                                'name' => 'KPI_57',
                               'data' => $arraytype_from['KPI_57']
                            ],
                            [  'type' => 'column',
                                'name' => 'Scope',
                                'data' => $arraytype_from['Scope']
                            ],
                            [  'type' => 'column',
                                'name' => 'ScreeningReport',
                               'data' => $arraytype_from['ScreeningReport']
                            ],
                            [  'type' => 'column',
                                'name' => 'Tiger-LC',
                               'data' => $arraytype_from['Tiger-LC']
                            ],
                            [  'type' => 'column',
                                'name' => 'tomor_board',
                                'data' => $arraytype_from['tomor_board']
                            ],
                            
                                 [ 'type' => 'column',
                                     'name' => '-Screening-',
                               
                                'data' =>$arraytype_from['-Screening-'],
                     
                            ],
                            [ 'type' => 'column',
                                'name' => 'ClinicCaDay',

                                'data' =>$arraytype_from['ClinicCaDay'],

                            ],

                        ]

                    ]
                ]
        );
        ?>
                   </div>
                </div>
    </div>

    <div class="col-md-12">
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> สรุปข้อมูลการบันทึกข้อมูล รายปี </h3>',
        'type' => 'success',
        //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> โหลดข้อมูลใหม่', ['/report/report/report_key_d'], ['class' => 'btn btn-info']),
        'footer' => false
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'ปี',
            'attribute' => 'yy'
        ],
        [
            'label' => 'เดือน',
            'attribute' => 'mm2'
        ],
        [
            'label' => 'จำนวนผู้ป่วยที่บันทึก',
            'attribute' => 'cnt555'
        ],
        [
            'label' => 'ผู้ที่บันทึกข้อมูล',
            'attribute' => 'user_key'
        ],
        [
            'label' => 'ประเภทข้อมูล',
            'attribute' => 'type_from'
        ],
    ]
]);
?>

    </div>
</div>
